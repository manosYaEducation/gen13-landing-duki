<?php
session_start();
require_once '../db.php';

header('Content-Type: application/json');

// Obtener los datos del POST en formato JSON
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Verificar si se recibieron datos del carrito
if (!empty($data['carrito'])) {
    $carrito = $data['carrito'];
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $status = 'pendiente';
    $fecha = date('Y-m-d H:i:s');
    
    // Crear un nuevo pedido en la tabla orders
    if ($userId) {
        $conn->query("INSERT INTO orders (user_id, status, fecha) VALUES ($userId, '$status', '$fecha')");
    } else {
        $conn->query("INSERT INTO orders (status, fecha) VALUES ('$status', '$fecha')");
    }
    $orderId = $conn->insert_id;
    
    if (is_array($carrito) && $orderId) {
        $error = false;
        
        // Insertar los detalles del pedido
        foreach ($carrito as $item) {
            $idProducto = intval($item['id']);
            $cantidad = intval($item['cantidad']);
            
            if ($idProducto > 0 && $cantidad > 0) {
                // Verificar stock disponible
                $stock = $conn->query("SELECT stock FROM products WHERE id = $idProducto")->fetch_assoc();
                if ($stock && $stock['stock'] >= $cantidad) {
                    // Insertar en la tabla order_details
                    $conn->query("INSERT INTO order_details (order_id, product_id, quantity) 
                                VALUES ($orderId, $idProducto, $cantidad)");
                    
                    // Actualizar el stock del producto
                    $conn->query("UPDATE products SET stock = stock - $cantidad WHERE id = $idProducto");
                } else {
                    $error = true;
                    break;
                }
            }
        }
        
        if (!$error) {
            echo json_encode([
                'success' => true,
                'message' => 'Pedido creado correctamente',
                'order_id' => $orderId
            ]);
        } else {
            // Si hubo error, eliminar la orden y sus detalles
            $conn->query("DELETE FROM order_details WHERE order_id = $orderId");
            $conn->query("DELETE FROM orders WHERE id = $orderId");
            
            echo json_encode([
                'success' => false,
                'message' => 'No hay suficiente stock disponible'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al crear el pedido'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No se recibieron datos del carrito'
    ]);
}
?>

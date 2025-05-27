<?php
session_start();
require_once '../db.php';

// Definir la ruta base
$base_url = '/landing_duki';

// Verificar si se recibieron datos del carrito
if (!empty($_POST['carrito'])) {
    $carrito = json_decode($_POST['carrito'], true);
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $status = 'pendiente';
    $fecha = date('Y-m-d H:i:s');
    
    // Crear un nuevo pedido en la tabla orders
    // Si no hay usuario logueado, creamos un pedido sin user_id
    if ($userId) {
        $conn->query("INSERT INTO orders (user_id, status, fecha) VALUES ($userId, '$status', '$fecha')");
    } else {
        $conn->query("INSERT INTO orders (status, fecha) VALUES ('$status', '$fecha')");
    }
    $orderId = $conn->insert_id;
    
    if (is_array($carrito) && $orderId) {
        // Insertar los detalles del pedido
        foreach ($carrito as $item) {
            $idProducto = intval($item['id_producto']);
            $cantidad = intval($item['cantidad']);
            
            if ($idProducto > 0 && $cantidad > 0) {
                // Insertar en la tabla order_details
                $conn->query("INSERT INTO order_details (order_id, product_id, quantity) 
                              VALUES ($orderId, $idProducto, $cantidad)");
                
                // Actualizar el stock del producto
                $conn->query("UPDATE products SET stock = stock - $cantidad WHERE id = $idProducto AND stock >= $cantidad");
            }
        }
        
        // Redirigir a WhatsApp (la URL viene por POST)
        $waUrl = isset($_POST['wa_url']) ? $_POST['wa_url'] : $base_url . '/front/compra-aprobada.html';
        header('Location: ' . $waUrl);
        exit;
    } else {
        // Error al crear el pedido
        header('Location: ' . $base_url . '/front/compra-rechazada.html');
        exit;
    }
} else {
    // Si no hay datos, vuelve a la tienda
    header('Location: ' . $base_url . '/front/tienda.php');
    exit;
}
?>

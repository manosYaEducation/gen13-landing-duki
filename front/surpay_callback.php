<?php
header('Content-Type: application/json');
require_once '../db.php';

// Obtener los datos del POST
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validar los datos
if (!isset($data['transaction_id']) || !isset($data['status'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Datos incompletos'
    ]);
    exit;
}

// Buscar la orden por transaction_id
$transactionId = $conn->real_escape_string($data['transaction_id']);
$order = $conn->query("SELECT * FROM orders WHERE transaction_id = '$transactionId'")->fetch_assoc();

if (!$order) {
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'message' => 'Orden no encontrada'
    ]);
    exit;
}

// Actualizar el estado del pago
$status = $data['status'];
$orderId = $order['id'];

switch ($status) {
    case 'completed':
        // Pago completado exitosamente
        $conn->query("UPDATE orders SET payment_status = 'completed', status = 'aprobado' WHERE id = $orderId");
        break;
    
    case 'failed':
        // Pago fallido
        $conn->query("UPDATE orders SET payment_status = 'failed', status = 'rechazado' WHERE id = $orderId");
        // Devolver el stock
        $details = $conn->query("SELECT product_id, quantity FROM order_details WHERE order_id = $orderId");
        while ($detail = $details->fetch_assoc()) {
            $productId = $detail['product_id'];
            $quantity = $detail['quantity'];
            $conn->query("UPDATE products SET stock = stock + $quantity WHERE id = $productId");
        }
        break;
    
    case 'pending':
        // Pago pendiente
        $conn->query("UPDATE orders SET payment_status = 'pending' WHERE id = $orderId");
        break;
    
    default:
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Estado de pago inválido'
        ]);
        exit;
}

echo json_encode([
    'success' => true,
    'message' => 'Estado actualizado correctamente'
]);

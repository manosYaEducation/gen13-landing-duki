<?php
header('Content-Type: application/json');

require_once '../db.php';

// Obtener los datos del POST
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validar los datos
if (!isset($data['order_id']) || !isset($data['status'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Datos incompletos'
    ]);
    exit;
}

// Obtener información de la orden
$orderId = intval($data['order_id']);
$status = $data['status'];

// Validar el estado
if (!in_array($status, ['approved', 'rejected'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Estado inválido'
    ]);
    exit;
}

// Actualizar el estado de la orden
$payment_status = ($status === 'approved') ? 'completed' : 'rejected';
$transaction_id = 'TX_' . time() . '_' . $orderId;

$result = $conn->query("UPDATE orders SET 
    transaction_id = '$transaction_id',
    payment_status = '$payment_status',
    payment_date = NOW()
    WHERE id = $orderId");

if ($result) {
    echo json_encode([
        'success' => true,
        'message' => 'Pago ' . ($status === 'approved' ? 'aprobado' : 'rechazado') . ' correctamente'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error al actualizar el estado del pago'
    ]);
}
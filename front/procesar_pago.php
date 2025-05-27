<?php
header('Content-Type: application/json');

// Habilitar reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../db.php';

// Verificar si hay datos POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['success' => false, 'message' => 'Método no permitido']));
}

// Obtener y validar los datos JSON
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    die(json_encode([
        'success' => false,
        'message' => 'JSON inválido: ' . json_last_error_msg()
    ]));
}

if (!isset($data['order_id']) || !isset($data['status'])) {
    http_response_code(400);
    die(json_encode([
        'success' => false,
        'message' => 'Faltan datos requeridos',
        'data_received' => $data
    ]));
}

$order_id = intval($data['order_id']);
$status = in_array($data['status'], ['approved', 'rejected']) ? $data['status'] : null;

if (!$order_id || !$status) {
    http_response_code(400);
    die(json_encode([
        'success' => false,
        'message' => 'Datos inválidos',
        'order_id' => $order_id,
        'status' => $status
    ]));
}

try {
    // Actualizar el estado de la orden
    $new_status = ($status === 'approved') ? 'completed' : 'rejected';
    
    // Usar solo la columna status que sabemos que existe
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param('si', $new_status, $order_id);
    $result = $stmt->execute();
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => $status === 'approved' ? 'Pago aprobado' : 'Pago rechazado'
        ]);
    } else {
        throw new Exception('Error al actualizar la orden: ' . $conn->error);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error en el servidor: ' . $e->getMessage()
    ]);
}

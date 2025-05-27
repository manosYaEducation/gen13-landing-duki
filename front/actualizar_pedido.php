<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_POST['status'])) {
    $orderId = intval($_POST['order_id']);
    $status = $_POST['status'];
    
    // Validar el estado
    if (!in_array($status, ['aprobado', 'rechazado'])) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Estado inválido']);
        exit;
    }
    
    // Actualizar el estado del pedido
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $orderId);
    
    if ($stmt->execute()) {
        // Si el pedido es rechazado, devolver el stock
        if ($status === 'rechazado') {
            // Obtener los detalles del pedido
            $details = $conn->query("SELECT product_id, quantity FROM order_details WHERE order_id = $orderId");
            while ($detail = $details->fetch_assoc()) {
                // Devolver el stock
                $productId = $detail['product_id'];
                $quantity = $detail['quantity'];
                $conn->query("UPDATE products SET stock = stock + $quantity WHERE id = $productId");
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error al actualizar']);
    }
    
    $stmt->close();
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
}

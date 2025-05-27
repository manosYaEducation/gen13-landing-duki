<?php
header('Content-Type: application/json');
require_once '../db.php';

// Obtener los datos del POST
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validar los datos
if (!isset($data['order_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'ID de orden requerido'
    ]);
    exit;
}

// Obtener información de la orden
$orderId = intval($data['order_id']);
$order = $conn->query("SELECT o.*, 
    (SELECT SUM(p.price * od.quantity) 
     FROM order_details od 
     JOIN products p ON od.product_id = p.id 
     WHERE od.order_id = o.id) as total 
    FROM orders o 
    WHERE o.id = $orderId")->fetch_assoc();

if (!$order) {
    echo json_encode([
        'success' => false,
        'message' => 'Orden no encontrada'
    ]);
    exit;
}

// Configurar la petición a Surpay
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$callbackUrl = $baseUrl . '/api/surpay_callback.php';
$redirectUrl = $baseUrl . '/front/ver_boleta.php?order_id=' . $orderId;

// Datos para Surpay
$surpayData = [
    'idcliente' => 'DUKI_SHOP_' . $orderId, // Identificador único del cliente
    'monto' => $order['total'],
    'issue' => 'Orden #' . $orderId,
    'transaction_id' => 'TX_' . time() . '_' . $orderId,
    'status_url' => $callbackUrl,
    'redirect_url' => $redirectUrl
];

// En producción, usar la URL real de Surpay
$surpayUrl = 'https://link-generator.surpay.cl/surpay';

// Para desarrollo/pruebas, usar el mock
if ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1') {
    $surpayUrl = $baseUrl . '/api/mock_surpay.php';
}

// Realizar la petición a Surpay
$ch = curl_init($surpayUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($surpayData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al comunicarse con Surpay'
    ]);
    exit;
}

// Decodificar la respuesta de Surpay
$surpayResponse = json_decode($response, true);

if (!$surpayResponse || !isset($surpayResponse['url_pago'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Respuesta inválida de Surpay'
    ]);
    exit;
}

// Guardar la información de la transacción
$conn->query("UPDATE orders SET 
    transaction_id = '{$surpayData['transaction_id']}',
    payment_status = 'pending'
    WHERE id = $orderId");

// Devolver la URL de pago
echo json_encode([
    'success' => true,
    'url_pago' => $surpayResponse['url_pago']
]);

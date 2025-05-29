<?php
header('Content-Type: application/json');

// Simular un pequeño delay
sleep(1);

// Obtener los datos del POST
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validar los datos requeridos
if (!isset($data['idcliente']) || !isset($data['monto']) || !isset($data['transaction_id'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Datos incompletos'
    ]);
    exit;
}

// Generar una URL de pago simulada
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$mockPaymentUrl = $baseUrl . '/front/mock_surpay_payment.php?' . http_build_query([
    'transaction_id' => $data['transaction_id'],
    'amount' => $data['monto'],
    'redirect_url' => $data['redirect_url'] ?? '',
    'status_url' => $data['status_url'] ?? ''
]);

// Devolver la respuesta simulada
echo json_encode([
    'success' => true,
    'url_pago' => $mockPaymentUrl
]);

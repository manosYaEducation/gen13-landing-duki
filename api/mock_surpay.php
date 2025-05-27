<?php
header('Content-Type: application/json');

// Obtener los datos del POST en formato JSON
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validar campos requeridos
$requiredFields = ['idcliente', 'monto', 'transaction_id', 'status_url', 'redirect_url'];
$missingFields = [];

foreach ($requiredFields as $field) {
    if (!isset($data[$field]) || empty($data[$field])) {
        $missingFields[] = $field;
    }
}

if (!empty($missingFields)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Datos incompletos. Campos faltantes: ' . implode(', ', $missingFields)
    ]);
    exit;
}

// Generar URL de pago simulada
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$mockPaymentUrl = $baseUrl . '/api/mock_surpay_payment.php?' . http_build_query([
    'transaction_id' => $data['transaction_id'],
    'amount' => $data['monto'],
    'redirect_url' => $data['redirect_url'],
    'status_url' => $data['status_url']
]);

// Simular respuesta de Surpay
$response = [
    'success' => true,
    'url_pago' => $mockPaymentUrl
];

echo json_encode($response);

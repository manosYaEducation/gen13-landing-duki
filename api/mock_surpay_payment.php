<?php
header('Content-Type: application/json');

// Obtener el transaction_id de la URL
$transaction_id = $_GET['transaction_id'] ?? 'TX-' . time();

// Simular respuesta de Surpay
$response = [
    'success' => true,
    'url_pago' => 'http://localhost/landing_duki/front/ver_boleta.php?transaction_id=' . $transaction_id
];

file_put_contents(__DIR__ . '/surpay_response_log.txt', 
    date('Y-m-d H:i:s') . "\nResponse: " . json_encode($response) . "\n\n", 
    FILE_APPEND
);

echo json_encode($response);

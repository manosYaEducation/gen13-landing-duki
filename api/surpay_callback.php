<?php
header('Content-Type: application/json');

// Recibir los datos de la notificación de Surpay
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Registrar la notificación para depuración
file_put_contents('surpay_callback_log.txt', date('Y-m-d H:i:s') . ' - ' . $json . PHP_EOL, FILE_APPEND);

// Verificar que los datos necesarios estén presentes
if (!isset($data['transaction_id']) || !isset($data['status'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Datos incompletos'
    ]);
    exit;
}

// Extraer los datos relevantes
$transaction_id = $data['transaction_id'];
$status = $data['status'];
$amount = $data['amount'] ?? 0;
$payment_method = $data['payment_method'] ?? '';
$payment_date = $data['payment_date'] ?? '';

// Aquí deberías implementar la lógica para actualizar el estado de la transacción en tu base de datos
// Por ejemplo:
// $db = new PDO('mysql:host=localhost;dbname=tu_base_de_datos', 'usuario', 'contraseña');
// $stmt = $db->prepare("UPDATE transactions SET status = ?, payment_method = ?, payment_date = ? WHERE transaction_id = ?");
// $stmt->execute([$status, $payment_method, $payment_date, $transaction_id]);

// Responder a Surpay que hemos recibido la notificación correctamente
echo json_encode([
    'success' => true,
    'message' => 'Notificación recibida correctamente'
]);
?>

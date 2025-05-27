<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Obtener el ID de transacción
$transaction_id = $_GET['transaction_id'] ?? '';

if (empty($transaction_id)) {
    echo json_encode([
        'success' => false,
        'message' => 'ID de transacción no proporcionado'
    ]);
    exit;
}

// En un entorno real, aquí consultarías el estado de la transacción en tu base de datos
// Por ejemplo:
// $db = new PDO('mysql:host=localhost;dbname=tu_base_de_datos', 'usuario', 'contraseña');
// $stmt = $db->prepare("SELECT * FROM transactions WHERE transaction_id = ?");
// $stmt->execute([$transaction_id]);
// $transaction = $stmt->fetch(PDO::FETCH_ASSOC);

// Para fines de demostración, simularemos una consulta a la base de datos
// En un entorno de producción, deberías implementar la consulta real a tu base de datos
$transaction = [
    'transaction_id' => $transaction_id,
    'status' => 'success', // Simulamos una transacción exitosa
    'amount' => 10000,
    'payment_method' => 'Tarjeta de crédito',
    'payment_date' => date('Y-m-d H:i:s')
];

// Si prefieres, también puedes consultar el estado directamente a Surpay
// utilizando su API (si proporcionan un endpoint para consultar el estado)
// Ejemplo:
/*
$ch = curl_init("https://api.surpay.cl/transactions/{$transaction_id}");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer TU_API_KEY'
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $surpayResponse = json_decode($response, true);
    $transaction = [
        'transaction_id' => $surpayResponse['transaction_id'],
        'status' => $surpayResponse['status'],
        'amount' => $surpayResponse['amount'],
        'payment_method' => $surpayResponse['payment_method'],
        'payment_date' => $surpayResponse['payment_date']
    ];
}
*/

// Devolver la información de la transacción
echo json_encode([
    'success' => true,
    'transaction' => $transaction
]);
?>

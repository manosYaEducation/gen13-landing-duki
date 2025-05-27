<?php
header('Content-Type: application/json');

// Permitir CORS para pruebas locales
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Simulación de base de datos de giftcards
$giftcards = [
    '989500001111484375' => [
        'giftCardNumber' => '989500001111484375',
        'balance' => 100,
        'expirationDate' => '2026-03-26T23:59:59.228-0300',
        'pin' => '125476'
    ]
];

// Autenticación básica con Bearer token (no se valida JWT real, solo que exista)
$headers = getallheaders();
if (empty($headers['Authorization']) || strpos($headers['Authorization'], 'Bearer ') !== 0) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit();
}

// Obtener el número de giftcard de la URL
$uri = $_SERVER['REQUEST_URI'];
$matches = [];
if (preg_match('#/giftcards/(\d+)#', $uri, $matches)) {
    $number = $matches[1];
    if (isset($giftcards[$number])) {
        // GET: Consultar saldo
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            echo json_encode($giftcards[$number]);
            exit();
        }
        // POST: Transferir saldo
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($uri, 'balanceTransfer') !== false) {
            // Validar PIN si se envía
            $input = json_decode(file_get_contents('php://input'), true);
            $pin = $input['pin'] ?? '';
            if ($pin !== $giftcards[$number]['pin']) {
                http_response_code(403);
                echo json_encode(['error' => 'PIN incorrecto']);
                exit();
            }
            // Simular transferencia
            echo json_encode(['message' => 'Saldo transferido exitosamente']);
            exit();
        }
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Giftcard no encontrada']);
        exit();
    }
}

http_response_code(400);
echo json_encode(['error' => 'Petición inválida']);

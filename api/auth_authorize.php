<?php
header('Content-Type: application/json');

// Permitir CORS para pruebas locales
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Methods: POST, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Leer el cuerpo JSON
$input = json_decode(file_get_contents('php://input'), true);

$username = $input['username'] ?? '';
$password = $input['password'] ?? '';

// Credenciales de ejemplo
if ($username === 'superUser' && $password === 'superPass') {
    // Generar un JWT falso (solo para pruebas, NO usar en producción)
    $token = base64_encode(json_encode([
        'sub' => $username,
        'iat' => time(),
        'exp' => time() + 3600
    ]));
    echo json_encode(['access_token' => $token]);
} else {
    http_response_code(401);
    echo json_encode(['error' => 'Credenciales inválidas']);
}

<?php
session_start();
require_once __DIR__ . '/../db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el token del formulario POST
    $idToken = $_POST['idToken'] ?? null;

    if (!$idToken) {
        http_response_code(400);
        echo json_encode(['error' => 'Token no proporcionado']);
        exit;
    }

    // Verificar el token de Firebase usando la API de verificación de tokens de Firebase
    $apiKey = 'AIzaSyCdepVqtZD-Yr0FU7uAUdiuzNeHw_BVPUw';
    $url = "https://identitytoolkit.googleapis.com/v1/accounts:lookup?key={$apiKey}";
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['idToken' => $idToken]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode !== 200) {
        http_response_code(401);
        echo json_encode(['error' => 'Token de autenticación inválido']);
        exit;
    }
    
    $userData = json_decode($response, true);
    $user = $userData['users'][0];
    
    // Verificar si el usuario ya existe en la base de datos por email
    $email = $user['email'];
    $stmt = $conn->prepare("SELECT id, username, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        // El usuario no existe, crear uno nuevo
        $username = $user['displayName'] ?? explode('@', $email)[0];
        $role = 'user'; // Rol por defecto
        
        // Insertar el nuevo usuario
        $stmt = $conn->prepare("INSERT INTO users (username, email, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $role);
        $stmt->execute();
        $userId = $stmt->insert_id;
    } else {
        // El usuario ya existe, obtener sus datos
        $row = $result->fetch_assoc();
        $userId = $row['id'];
        $role = $row['role'];
    }

    // Iniciar sesión
    $_SESSION['user_id'] = $userId;
    $username = $user['displayName'] ?? explode('@', $email)[0];
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['role'] = $role;

    // Establecer cookie de sesión
    session_write_close();

    // Redirigir a la tienda
    header('Location: /landing-duki/front/tienda.php');
    exit();
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}

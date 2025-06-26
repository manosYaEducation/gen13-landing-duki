<?php
// Configuración de entorno
define('ENVIRONMENT', 'production'); // Cambiar a 'development' en entorno local

// Configuración de rutas base
$base_path = 'https://timeline-duki.alphadocere.cl/';

define('BASE_URL', $base_path);
define('ASSETS_URL', $base_path . 'assets');

define('DB_HOST', 'localhost');
define('DB_USER', 'alphadocere_duki_store');
define('DB_PASS', 'wUShrkDoeK2S');
define('DB_NAME', 'alphadocere_duki_store');

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Función para obtener la URL base
function get_base_url($path = '') {
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}

// Función para obtener la URL de assets
function asset_url($path) {
    return rtrim(ASSETS_URL, '/') . '/' . ltrim($path, '/');
}

// Conexión a la base de datos
function get_db_connection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        error_log("Error de conexión a la base de datos: " . $conn->connect_error);
        if (ENVIRONMENT === 'development') {
            die("Error de conexión a la base de datos: " . $conn->connect_error);
        } else {
            die("Error al conectar con la base de datos. Por favor, intente más tarde.");
        }
    }
    
    $conn->set_charset("utf8mb4");
    return $conn;
}
?>

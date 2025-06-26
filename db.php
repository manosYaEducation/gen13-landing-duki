<?php
// Configuración para entorno de producción (cPanel)
// Credenciales para timeline-duki.alphadocere.cl
$host = "localhost"; // Normalmente sigue siendo localhost en cPanel
$user = "alphadocere_duki_store"; // Usuario de la base de datos
$password = "wUShrkDoeK2S"; // Contraseña de la base de datos
$dbname = "alphadocere_duki_store"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Configuración global para rutas
// Configuración para el dominio timeline-duki.alphadocere.cl
// Como el sitio está en su propio subdominio, usamos '/' como base
$base_url = '';  // Dejamos vacío porque ya está en su propio subdominio
?>

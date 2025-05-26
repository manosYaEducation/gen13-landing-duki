<?php
$host = "localhost";
$user = "root";
$password = ""; // Por defecto en XAMPP, el usuario root no tiene contraseña
$dbname = "duki_store";

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
// Si quieres comprobar que funciona, descomenta la siguiente línea:
// echo "Conexión exitosa a la base de datos";
?>

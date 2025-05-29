<?php
require_once 'db.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener todos los productos
$result = $conn->query("SELECT id, name, image FROM products");

if ($result->num_rows > 0) {
    echo "<h2>Rutas de imágenes en la base de datos:</h2>";
    echo "<table border='1' cellpadding='8' style='border-collapse: collapse;'>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Ruta de la imagen</th><th>¿Existe?</th><th>Ruta completa</th></tr>";
    
    while($row = $result->fetch_assoc()) {
        $image_path = $row['image'];
        $full_path = $_SERVER['DOCUMENT_ROOT'] . '/landing-duki/' . ltrim($image_path, '/');
        $exists = file_exists($full_path) ? 'Sí' : 'No';
        
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($image_path) . "</td>";
        echo "<td>" . $exists . "</td>";
        echo "<td>" . htmlspecialchars($full_path) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "No se encontraron productos en la base de datos.";
}

// Verificar permisos de la carpeta de imágenes
$images_dir = $_SERVER['DOCUMENT_ROOT'] . '/landing-duki/assets/tienda';
echo "<h2>Permisos de la carpeta de imágenes:</h2>";
echo "Ruta: " . $images_dir . "<br>";
echo "¿Existe? " . (is_dir($images_dir) ? 'Sí' : 'No') . "<br>";

// Mostrar algunas imágenes de ejemplo
$example_images = [
    'cadeameri.png',
    'cadeduki.jpg',
    'poleronduki.png'
];

echo "<h2>Verificando algunas imágenes de ejemplo:</h2>";
echo "<div style='display: flex; flex-wrap: wrap; gap: 20px;'>";
foreach ($example_images as $img) {
    $img_path = $images_dir . '/' . $img;
    $img_url = '/landing-duki/assets/tienda/' . $img;
    $exists = file_exists($img_path);
    
    echo "<div style='border: 1px solid #ccc; padding: 10px; text-align: center;'>";
    echo "<div>" . htmlspecialchars($img) . "</div>";
    echo "<div>Existe: " . ($exists ? 'Sí' : 'No') . "</div>";
    if ($exists) {
        echo "<img src='$img_url' style='max-width: 200px; max-height: 200px; margin-top: 10px;'>";
    }
    echo "</div>";
}
echo "</div>";

$conn->close();
?>

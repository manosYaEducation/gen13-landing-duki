<?php
require_once 'db.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si la tabla products existe
$result = $conn->query("SHOW TABLES LIKE 'products'");
if ($result->num_rows == 0) {
    die("La tabla 'products' no existe en la base de datos.");
}

// Contar productos
$count = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'];
echo "Productos encontrados: " . $count . "<br><br>";

// Mostrar algunos productos (máximo 5 para no saturar)
$products = $conn->query("SELECT * FROM products LIMIT 5");
if ($products->num_rows > 0) {
    echo "<h3>Algunos productos:</h3>";
    while($row = $products->fetch_assoc()) {
        echo "ID: " . $row['id'] . " - " . $row['name'] . " - $" . $row['price'] . "<br>";
        echo "Imagen: " . (empty($row['image']) ? 'No tiene imagen' : $row['image']) . "<br><br>";
    }
} else {
    echo "No se encontraron productos en la base de datos.";
}

$conn->close();
?>

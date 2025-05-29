<?php
require_once 'db.php';

// Actualizar las rutas de las imágenes en la base de datos
$sql = "UPDATE products SET image = REPLACE(image, '/landing_duki/', '/landing-duki/')";

if ($conn->query($sql) === TRUE) {
    echo "Se actualizaron " . $conn->affected_rows . " registros correctamente.<br>";
    echo "Las rutas de las imágenes han sido corregidas.";
} else {
    echo "Error al actualizar las rutas: " . $conn->error;
}

// Mostrar algunas rutas actualizadas para verificar
$result = $conn->query("SELECT id, name, image FROM products LIMIT 3");
if ($result->num_rows > 0) {
    echo "<h3>Algunas rutas actualizadas:</h3>";
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . " - " . $row['name'] . "<br>";
        echo "Ruta: " . $row['image'] . "<br><br>";
    }
}

$conn->close();
?>

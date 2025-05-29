<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit();
}

require_once '../db.php';

// Definir la ruta base
$base_url = '/landing_duki';

// Procesar eliminación de producto
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $product_id = intval($_GET['delete']);
    
    // Primero obtener la información del producto para eliminar la imagen si existe
    $product = $conn->query("SELECT * FROM products WHERE id = $product_id")->fetch_assoc();
    
    if ($product) {
        // Primero eliminar registros relacionados en stock_history
        $conn->query("DELETE FROM stock_history WHERE product_id = $product_id");
        
        // Eliminar registros en order_details si existen
        $conn->query("DELETE FROM order_details WHERE product_id = $product_id");
        
        // Ahora eliminar el producto de la base de datos
        if ($conn->query("DELETE FROM products WHERE id = $product_id")) {
            // Si tiene imagen y la imagen está en nuestro servidor, la eliminamos
            if (!empty($product['image']) && strpos($product['image'], '/landing_duki/assets/') !== false) {
                $image_path = $_SERVER['DOCUMENT_ROOT'] . $product['image'];
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }
            
            // Mostrar mensaje de éxito y redirigir
            echo '<script>alert("Producto eliminado correctamente"); window.location.href="' . $base_url . '/front/dashboard.php";</script>';
            exit;
        } else {
            // Error al eliminar
            echo '<script>alert("Error al eliminar el producto: ' . $conn->error . '"); window.location.href="' . $base_url . '/front/dashboard.php";</script>';
            exit;
        }
    } else {
        // Producto no encontrado
        echo '<script>alert("Producto no encontrado"); window.location.href="' . $base_url . '/front/dashboard.php";</script>';
        exit;
    }
}

// Procesar edición de producto (formulario GET)
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $product_id = intval($_GET['edit']);
    $product = $conn->query("SELECT * FROM products WHERE id = $product_id")->fetch_assoc();
    
    if (!$product) {
        echo '<script>alert("Producto no encontrado"); window.location.href="' . $base_url . '/front/dashboard.php";</script>';
        exit;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - Duki Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            background: #18181c;
            color: #fff;
            font-family: 'Bebas Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: #23232a;
            border-radius: 16px;
            box-shadow: 0 0 24px #6f0001cc;
        }
        .form-title {
            color: #6f0001;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            letter-spacing: 2px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 1.2rem;
        }
        label {
            display: block;
            font-weight: 700;
            color: #e0b800;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }
        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            background: #18181c;
            color: #fff;
            border: 1.5px solid #6f0001;
            border-radius: 6px;
            padding: 10px 15px;
            font-size: 1.1rem;
            font-family: Arial, sans-serif;
        }
        .buttons {
            display: flex;
            gap: 1.2rem;
            margin-top: 2rem;
        }
        .btn {
            background: linear-gradient(90deg, #400208 0%, #6f0001 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.8rem 2.5rem;
            font-size: 1.2rem;
            font-family: 'Bebas Neue', Arial, sans-serif;
            font-weight: bold;
            letter-spacing: 2px;
            box-shadow: 0 0 16px #6f0001cc;
            cursor: pointer;
            text-shadow: 0 0 8px #fff, 0 0 6px #6f0001;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-cancel {
            background: #23232a;
            color: #fff;
            border: 2px solid #6f0001;
        }
        .current-image {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            border-radius: 8px;
            border: 2px solid #6f0001;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="form-title">EDITAR PRODUCTO</h1>
        
        <form method="POST" enctype="multipart/form-data" action="admin_products.php">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            
            <div class="form-group">
                <label>NOMBRE:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>DESCRIPCIÓN:</label>
                <textarea name="description" rows="4"><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-group">
                <label>PRECIO:</label>
                <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>
            </div>
            
            <!-- Campo de stock eliminado -->
            
            <div class="form-group">
                <label>IMAGEN ACTUAL:</label>
                <?php if (!empty($product['image'])): ?>
                    <div>
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Imagen actual" class="current-image">
                    </div>
                <?php else: ?>
                    <p>No hay imagen</p>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label>NUEVA IMAGEN (dejar en blanco para mantener la actual):</label>
                <input type="file" name="image" accept="image/*">
            </div>
            
            <div class="buttons">
                <button type="submit" name="update_product" class="btn">GUARDAR CAMBIOS</button>
                <a href="<?php echo $base_url; ?>/front/dashboard.php" class="btn btn-cancel">CANCELAR</a>
            </div>
        </form>
    </div>
</body>
</html>
<?php
    exit;
}

// Procesar edición de producto (formulario POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $product_id = intval($_POST['product_id']);
    $name = $_POST['name'];
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $price = floatval($_POST['price']);
    // Stock eliminado
    
    // Primero obtenemos el producto actual para comparar
    $current_product = $conn->query("SELECT * FROM products WHERE id = $product_id")->fetch_assoc();
    
    if (!$current_product) {
        echo '<script>alert("Producto no encontrado"); window.location.href="' . $base_url . '/front/dashboard.php";</script>';
        exit;
    }
    
    // Verificar si se ha subido una nueva imagen
    $image_url = $current_product['image']; // Mantener la actual por defecto
    
    if (isset($_FILES['image']) && $_FILES['image']['tmp_name']) {
        $img_name = uniqid('prod_') . '_' . basename($_FILES['image']['name']);
        $target = '../assets/tienda/' . $img_name;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image_url = '/landing_duki/assets/tienda/' . $img_name;
            
            // Si tenía una imagen anterior, la eliminamos
            if (!empty($current_product['image']) && strpos($current_product['image'], '/landing_duki/assets/') !== false) {
                $old_image_path = $_SERVER['DOCUMENT_ROOT'] . $current_product['image'];
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }
        }
    }
    
    // Actualizar el producto (sin stock)
    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?");
    $stmt->bind_param('ssdsi', $name, $description, $price, $image_url, $product_id);
    
    if ($stmt->execute()) {
        // Eliminado el registro de cambio de stock
        
        echo '<script>alert("Producto actualizado correctamente"); window.location.href="' . $base_url . '/front/dashboard.php";</script>';
        exit;
    } else {
        echo '<script>alert("Error al actualizar producto: ' . $conn->error . '"); window.location.href="' . $base_url . '/front/dashboard.php";</script>';
        exit;
    }
}

// Si no hay acción definida, redirigir al dashboard
header("Location: " . $base_url . "/front/dashboard.php");
exit;
?>

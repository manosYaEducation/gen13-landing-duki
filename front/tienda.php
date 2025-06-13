<?php
session_start();
$user = isset($_SESSION["username"]) ? $_SESSION["username"] : null;

// Definir la ruta base
$base_url = '/landing-duki';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Duki</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <style>
        .notificacion {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #6f0001;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            transform: translateX(120%);
            transition: transform 0.3s ease-in-out;
            z-index: 1000;
        }
        .notificacion.mostrar {
            transform: translateX(0);
        }
<?php
// Incluimos aquí el CSS embebido del archivo original tienda.html
?>
body {
    background: #18181c;
    margin: 0;
    font-family: 'Bebas Neue', Arial, sans-serif;
    color: #fff;
}

.tienda-title {
    font-size: 2rem;
    margin: 2rem 0 1rem 2.5rem;
    font-weight: bold;
    letter-spacing: 2px;
}
.products-container {
    display: flex;
    gap: 2.5rem;
    justify-content: center;
    margin-top: 7rem;
    flex-wrap: wrap;
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
}
.product-card {
    background: #23232a;
    border-radius: 18px;
    box-shadow: 0 0 24px #6f0001cc;
    padding: 1.3rem 1.2rem 1.5rem 1.2rem;
    min-width: 200px;
    max-width: 220px;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 2rem;
}
.product-img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 0 12px #6f0001aa;
    margin-bottom: 1rem;
}
.product-name {
    font-size: 1.1rem;
    font-weight: bold;
    margin-bottom: 0.3rem;
    color: #fff;
    letter-spacing: 1px;
    text-align: center;
}
.product-desc {
    color: #c9cfd3;
    font-size: 0.95rem;
    text-align: center;
    margin-bottom: 0.5rem;
}
.product-price {
    color: #e03838;
    font-size: 1.08rem;
    font-weight: bold;
    margin-bottom: 0.7rem;
}
.product-btn {
    background: linear-gradient(90deg, #400208 0%, #6f0001 100%);
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 0.7rem 2.2rem;
    font-size: 1.1rem;
    font-family: 'Bebas Neue', Arial, sans-serif;
    font-weight: bold;
    letter-spacing: 2px;
    box-shadow: 0 0 12px #6f0001cc;
    cursor: pointer;
    text-shadow: 0 0 8px #fff, 0 0 6px #6f0001;
    text-decoration: none;
    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
    display: inline-block;
}
.product-btn:hover {
    background: linear-gradient(90deg, #6f0001 0%, #400208 100%);
    color: #fff;
    box-shadow: 0 0 24px #6f0001;
}
.login-btn-navbar {
    background: linear-gradient(90deg, #400208 0%, #6f0001 100%);
    color: #c9cfd3;
    border: none;
    border-radius: 8px;
    padding: 0.7rem 1.6rem;
    font-size: 1.1rem;
    font-family: 'Bebas Neue', Arial, sans-serif;
    font-weight: bold;
    letter-spacing: 2px;
    box-shadow: 0 0 12px #6f0001cc;
    cursor: pointer;
    text-shadow: 0 0 8px #899cbc, 0 0 6px #556694;
    text-decoration: none;
    margin-left: 1.2rem;
    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
    display: inline-block;
    border: 2px solid #899cbc;
}
.login-btn-navbar:hover {
    background: linear-gradient(90deg, #6f0001 0%, #400208 100%);
    color: #fff;
    box-shadow: 0 0 24px #6f0001;
    border-color: #556694;
}
    </style>
<body>
    
<?php include 'components/navbar.php'; ?>
</div>
    <div class="tienda-title"></div>
    <div class="products-container">
    <?php
    require_once '../db.php';
    $prods = $conn->query("SELECT * FROM products ORDER BY id DESC");
    while($row = $prods->fetch_assoc()): ?>
        <div class="product-card" onclick="window.location='<?php echo $base_url; ?>/front/producto_detalle.php?id=<?php echo $row['id']; ?>'" style="cursor:pointer;">
            <?php if($row['image']): ?>
                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="product-img" style="cursor:pointer;" onclick="event.stopPropagation(); window.location='<?php echo $base_url; ?>/front/producto_detalle.php?id=<?php echo $row['id']; ?>'">
            <?php endif; ?>
            <div class="product-name" style="cursor:pointer;" onclick="event.stopPropagation(); window.location='<?php echo $base_url; ?>/front/producto_detalle.php?id=<?php echo $row['id']; ?>'">
                <?php echo htmlspecialchars($row['name']); ?>
            </div>
            <?php if(isset($row['description'])): ?>
            <div class="product-desc"><?php echo htmlspecialchars($row['description']); ?></div>
            <?php endif; ?>
            <div class="product-price">$<?php echo number_format($row['price'],0,',','.'); ?></div>
            <button class="product-btn" onclick="event.stopPropagation(); addToCart(<?php echo $row['id']; ?>, '<?php echo addslashes(htmlspecialchars($row['name'])); ?>', <?php echo $row['price']; ?>, '<?php echo addslashes(htmlspecialchars($row['image'])); ?>');">AGREGAR AL CARRITO</button>
        </div>
    <?php endwhile; ?>
</div>
    <div class="notificacion" id="notificacion"></div>
    <script src="carrito.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            actualizarContadorCarrito();
        });
        
        // Función para agregar al carrito desde esta página
        function addToCart(id, nombre, precio, imagen) {
            agregarAlCarrito(id, nombre, precio, imagen);
            event.stopPropagation();
        }
    </script>
</body>
</html>

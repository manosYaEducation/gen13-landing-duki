<?php
require_once __DIR__ . '/../config.php';
session_start();
$user = isset($_SESSION["username"]) ? $_SESSION["username"] : null;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Duki</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo get_base_url('styles.css'); ?>">
</head>
<body>
    <style>
body {
    background: #18181c;
    margin: 0;
    font-family: 'Bebas Neue', Arial, sans-serif;
    color: #fff;
    opacity: 0;
    animation: fadeIn 0.8s ease-in-out forwards;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
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
    opacity: 0;
    animation: fadeIn 0.8s ease-in-out forwards;
    animation-delay: 0.2s;
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
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(224, 56, 56, 0.3);
}
.product-img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 0 12px #6f0001aa;
    margin-bottom: 1rem;
    transition: transform 0.3s ease;
}
.product-card:hover .product-img {
    transform: scale(1.05);
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
    transition: all 0.3s ease;
    display: inline-block;
}
.product-btn:hover {
    background: linear-gradient(90deg, #6f0001 0%, #400208 100%);
    color: #fff;
    box-shadow: 0 0 24px #6f0001;
    transform: translateY(-2px);
}

.notificacion {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(35, 35, 42, 0.95);
    color: #fff;
    padding: 1rem 2rem;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(111, 0, 1, 0.5);
    display: none;
    z-index: 1000;
    text-align: center;
    font-size: 1.2rem;
    letter-spacing: 1px;
    opacity: 0;
    animation: fadeIn 0.3s ease-in-out forwards;
}

    </style>
<body>
    
<?php include 'components/navbar.php'; ?>
    <div class="tienda-title"></div>
    <div class="products-container">
    <?php
    $conn = get_db_connection();
    $prods = $conn->query("SELECT * FROM products ORDER BY id DESC");
    while($row = $prods->fetch_assoc()): ?>
        <div class="product-card" onclick="window.location='<?php echo get_base_url('front/producto_detalle.php'); ?>?id=<?php echo $row['id']; ?>'" style="cursor:pointer;">
            <?php if($row['image']): ?>
                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="product-img" style="cursor:pointer;" onclick="event.stopPropagation(); window.location='<?php echo get_base_url('front/producto_detalle.php'); ?>?id=<?php echo $row['id']; ?>'">
            <?php endif; ?>
            <div class="product-name" style="cursor:pointer;" onclick="event.stopPropagation(); window.location='<?php echo get_base_url('front/producto_detalle.php'); ?>?id=<?php echo $row['id']; ?>'">
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
    <script src="<?php echo get_base_url('front/carrito.js'); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            actualizarContadorCarrito();
        });
        
        // Función para agregar al carrito desde esta página
        function addToCart(id, nombre, precio, imagen) {
            agregarAlCarrito(id, nombre, precio, imagen, 1);
            event.stopPropagation();
            
            // Mostrar notificación centrada
            const notificacion = document.getElementById('notificacion');
            notificacion.textContent = '¡Producto agregado al carrito!';
            notificacion.style.display = 'block';
            
            // Ocultar la notificación después de 2 segundos
            setTimeout(() => {
                notificacion.style.display = 'none';
            }, 2000);
        }
    </script>
</body>
</html>

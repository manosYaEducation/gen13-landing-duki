<?php
// producto_detalle.php
require_once '../db.php';

// Verificar la ruta base
echo '<!-- Ruta base: ' . $_SERVER['DOCUMENT_ROOT'] . ' -->';
echo '<!-- Ruta actual: ' . __FILE__ . ' -->';

// Definir la ruta base
$base_url = '/landing_duki';

// Obtener el ID del producto desde la URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<h2>Producto no encontrado.</h2>';
    exit;
}
$id = intval($_GET['id']);
$prod = $conn->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();
if (!$prod) {
    echo '<h2>Producto no encontrado.</h2>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($prod['name']); ?> - Duki Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <style>
        body { background: #18181c; color: #fff; font-family: 'Bebas Neue', Arial, sans-serif; margin:0; }
        .navbar {
            background: #18181c;
            border-bottom: 2.5px solid #6f0001;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.6rem 2rem;
            box-shadow: 0 2px 24px #6f0001cc;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            z-index: 1000;
        }
        .navbar-logo {
            width: 48px;
            margin-right: 2rem;
        }
        .navbar-menu {
            display: flex;
            gap: 2.2rem;
        }
        .navbar-link {
            color: #fff;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: bold;
            letter-spacing: 1px;
            padding: 0.3rem 0.8rem;
            border-radius: 6px;
            transition: background 0.2s, color 0.2s;
        }
        .navbar-link:hover {
            background: #6f0001;
            color: #fff;
        }
        .login-btn-navbar {
            background: #23232a;
            color: #fff;
            border: 2px solid #6f0001;
            border-radius: 7px;
            padding: 0.35rem 1.1rem;
            font-size: 1.08rem;
            font-family: 'Bebas Neue', Arial, sans-serif;
            font-weight: bold;
            letter-spacing: 1px;
            text-decoration: none;
            margin-left: 0.7rem;
        }
        .login-btn-navbar:hover {
            background: #6f0001;
            color: #fff;
        }
        .detalle-container {
            display: flex;
            flex-wrap:wrap;
            gap:4rem;
            justify-content:center;
            align-items:flex-start;
            padding:3rem 2rem 2rem 2rem;
            margin-top: 6.5rem;
        }
        .detalle-img { width:350px; height:350px; object-fit:cover; border-radius:18px; background:#23232a; box-shadow:0 0 32px #6f0001cc; }
        .detalle-info { max-width:420px; }
        .detalle-nombre { font-size:2.3rem; font-weight:bold; letter-spacing:2px; margin-bottom:0.6rem; color:#e0b800; }
        .detalle-precio { font-size:2rem; color:#e03838; font-weight:bold; margin-bottom:1.2rem; }
        /* Eliminado estilo de stock */
        .detalle-desc { font-size:1.1rem; color:#c9cfd3; margin-bottom:1.4rem; }
        .detalle-btns { display:flex; gap:1.2rem; }
        .detalle-btn {
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
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
        }
        .detalle-btn:hover {
            background: linear-gradient(90deg, #6f0001 0%, #400208 100%);
            color: #fff;
            box-shadow: 0 0 24px #6f0001;
        }
    </style>
</head>
<body>
    <div class="navbar" style="display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center;">
            <img src="<?php echo $base_url; ?>/assets/ameri.png" alt="Logo" class="navbar-logo">
            <div class="navbar-menu">
                <a href="<?php echo $base_url; ?>/index.html" class="navbar-link">VOLVER A LA TIMELINE</a>
                <a href="<?php echo $base_url; ?>/index.html" class="navbar-link">INICIO</a>
                <a href="<?php echo $base_url; ?>/front/tienda.php" class="navbar-link">PRODUCTOS</a>
                <a href="#" class="navbar-link">CONTACTO</a>
                <a href="<?php echo $base_url; ?>/front/carrito.php" class="navbar-link" style="position: relative;">
                    CARRITO
                    <span id="carrito-contador" style="background: #e03838; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; position: absolute; top: -8px; right: -8px;">0</span>
                </a>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 1.2rem;">
            <?php if (isset($_SESSION['username'])): ?>
                <div style="color:#fff; font-weight:bold; font-size:1.1rem; display:flex; align-items:center; gap:0.7rem;">
                    <img src="<?php echo $base_url; ?>/assets/devil (2).png" alt="Devil Icon" style="height:28px; width:28px; object-fit:contain; vertical-align:middle;">
                    <?php echo htmlspecialchars($_SESSION['username']); ?>
                </div>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="<?php echo $base_url; ?>/front/dashboard.php" class="login-btn-navbar" style="background: #6f0001; color: #fff; margin-left:1rem;">DASHBOARD</a>
                <?php endif; ?>
                <a href="<?php echo $base_url; ?>/logout.php" class="login-btn-navbar" style="margin-left:1rem;">CERRAR SESIÓN</a>
            <?php else: ?>
                <a href="<?php echo $base_url; ?>/login.php" class="login-btn-navbar" style="margin-left:1rem;">INICIAR SESIÓN</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="detalle-container">
        <img class="detalle-img" src="<?php echo htmlspecialchars($prod['image']); ?>" alt="<?php echo htmlspecialchars($prod['name']); ?>">
        <div class="detalle-info">
            <div class="detalle-nombre"><?php echo htmlspecialchars($prod['name']); ?></div>
            <div class="detalle-precio">$<?php echo number_format($prod['price'],0,',','.'); ?></div>
            <!-- Eliminada información de stock -->
            <div class="detalle-desc">
                <?php echo !empty($prod['description']) ? htmlspecialchars($prod['description']) : 'Sin descripción.'; ?>
            </div>
            <div class="detalle-btns">
                <button class="detalle-btn" id="btn-agregar-carrito">Agregar al carrito</button>
                <button class="detalle-btn" id="btn-comprar-ahora" style="background:#23232a; color:#e0b800; border:2px solid #e0b800;">Comprar ahora</button>
            </div>
        </div>
    </div>
    <script src="carrito.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Datos del producto actual
            const productoId = <?php echo $prod['id']; ?>;
            const productoNombre = "<?php echo addslashes(htmlspecialchars($prod['name'])); ?>";
            const productoPrecio = <?php echo $prod['price']; ?>;
            const productoImagen = "<?php echo addslashes(htmlspecialchars($prod['image'])); ?>";
            
            // Botón agregar al carrito
            document.getElementById('btn-agregar-carrito').addEventListener('click', () => {
                agregarAlCarrito(productoId, productoNombre, productoPrecio, productoImagen);
            });
            
            // Botón comprar ahora
            document.getElementById('btn-comprar-ahora').addEventListener('click', () => {
                // Primero agregamos al carrito
                agregarAlCarrito(productoId, productoNombre, productoPrecio, productoImagen);
                // Luego redirigimos al carrito
                window.location.href = '<?php echo $base_url; ?>/front/carrito.php';
            });
            
            // Inicializar contador de carrito
            actualizarContadorCarrito();
        });
    </script>
</body>
</html>

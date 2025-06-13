<?php
$current_page = basename($_SERVER['PHP_SELF']);
$user = isset($_SESSION["username"]) ? $_SESSION["username"] : null;
$base_url = '/landing-duki';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<nav class="navbar" style="display: flex; align-items: center; justify-content: space-between; background: #18181c; border-bottom: 2.5px solid #6f0001; padding: 0.6rem 2rem; box-shadow: 0 2px 24px #6f0001cc;">
    <div style="display: flex; align-items: center;">
        <img src="<?php echo $base_url; ?>/assets/ameri.png" alt="Logo" class="navbar-logo" style="width: 48px; margin-right: 2rem;">
        <div class="navbar-menu" style="display: flex; gap: 2.2rem;">
            <a href="<?php echo $base_url; ?>/index.html" class="navbar-link" style="color: #fff; text-decoration: none; font-size: 1.1rem; font-weight: bold; letter-spacing: 1px; padding: 0.3rem 0.8rem; border-radius: 6px; transition: background 0.2s, color 0.2s;">VOLVER A LA TIMELINE</a>
            <a href="<?php echo $base_url; ?>/front/tienda.php" class="navbar-link" style="color: #fff; text-decoration: none; font-size: 1.1rem; font-weight: bold; letter-spacing: 1px; padding: 0.3rem 0.8rem; border-radius: 6px; transition: background 0.2s, color 0.2s;">PRODUCTOS</a>
            <a href="<?php echo $base_url; ?>/front/contacto.php" class="navbar-link" style="color: #fff; text-decoration: none; font-size: 1.1rem; font-weight: bold; letter-spacing: 1px; padding: 0.3rem 0.8rem; border-radius: 6px; transition: background 0.2s, color 0.2s;">CONTACTO</a>
        </div>
    </div>
    <div style="display: flex; align-items: center; gap: 1.2rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.95rem; color: #e0b800;">
            <label for="moneda-tienda" style="margin: 0;">Moneda:</label>
            <select id="moneda-tienda" style="padding: 0.2rem 0.4rem; border-radius: 6px; border: none; font-family: 'Bebas Neue', Arial, sans-serif; font-size: 0.95rem;">
                <option value="CLP">CLP</option>
                <option value="ARS">ARS</option>
            </select>
        </div>

        <?php if ($user): ?>
            <div style="color:#fff; font-weight:bold; font-size:1.1rem; display:flex; align-items:center; gap:0.7rem;">
                <img src="<?php echo $base_url; ?>/assets/devil (2).png" alt="Devil Icon" style="height:28px; width:28px; object-fit:contain; vertical-align:middle;">
                <?php echo htmlspecialchars($user); ?>
            </div>
            <a href="<?php echo $base_url; ?>/front/carrito.php" class="navbar-link" style="color: #fff; text-decoration: none; font-size: 1.1rem; font-weight: bold; letter-spacing: 1px; padding: 0.3rem 0.8rem; border-radius: 6px; transition: background 0.2s, color 0.2s; position: relative;">
                <i class="fas fa-shopping-cart" style="font-size: 1.3rem;"></i>
                <span class="cart-count" style="background: #e03838; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; position: absolute; top: -8px; right: -8px;">0</span>
            </a>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="<?php echo $base_url; ?>/front/dashboard.php" class="login-btn-navbar" style="background: #6f0001; color: #fff; margin-left:1rem; background: linear-gradient(90deg, #400208 0%, #6f0001 100%); color: #c9cfd3; border: none; border-radius: 8px; padding: 0.7rem 1.6rem; font-size: 1.1rem; font-family: 'Bebas Neue', Arial, sans-serif; font-weight: bold; letter-spacing: 2px; box-shadow: 0 0 12px #6f0001cc; cursor: pointer; text-shadow: 0 0 8px #899cbc, 0 0 6px #556694; text-decoration: none; margin-left:1.2rem; transition: background 0.2s, color 0.2s, box-shadow 0.2s; display: inline-block; border: 2px solid #899cbc;">DASHBOARD</a>
            <?php endif; ?>
            <a href="<?php echo $base_url; ?>/logout.php" class="navbar-link" style="color: #fff; text-decoration: none; font-size: 1.3rem; padding: 0.3rem 0.8rem; border-radius: 6px; transition: background 0.2s, color 0.2s;">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        <?php else: ?>
            <a href="<?php echo $base_url; ?>/login.php" class="login-btn-navbar" style="margin-left:1rem; background: linear-gradient(90deg, #400208 0%, #6f0001 100%); color: #c9cfd3; border: none; border-radius: 8px; padding: 0.7rem 1.6rem; font-size: 1.1rem; font-family: 'Bebas Neue', Arial, sans-serif; font-weight: bold; letter-spacing: 2px; box-shadow: 0 0 12px #6f0001cc; cursor: pointer; text-shadow: 0 0 8px #899cbc, 0 0 6px #556694; text-decoration: none; margin-left:1.2rem; transition: background 0.2s, color 0.2s, box-shadow 0.2s; display: inline-block; border: 2px solid #899cbc;">INICIAR SESIÓN</a>
        <?php endif; ?>
    </div>
</nav>

<style>
.navbar-link:hover {
    background: #6f0001;
    color: #fff;
}

.login-btn-navbar:hover {
    background: linear-gradient(90deg, #6f0001 0%, #400208 100%);
    color: #fff;
    box-shadow: 0 0 24px #6f0001;
    border-color: #556694;
}

@media (max-width: 991.98px) {
    .navbar {
        flex-direction: column;
        padding: 1rem;
    }
    
    .navbar-menu {
        flex-direction: column;
        width: 100%;
        margin-top: 1rem;
    }
    
    .navbar-link {
        width: 100%;
        text-align: center;
        margin: 0.5rem 0;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Actualizar contador del carrito
    function updateCartCount() {
        const cart = JSON.parse(localStorage.getItem('carritoDuki')) || [];
        const count = cart.reduce((total, item) => total + item.cantidad, 0);
        document.querySelectorAll('.cart-count').forEach(el => {
            el.textContent = count;
        });
    }
    
    updateCartCount();
    window.addEventListener('storage', updateCartCount);
});
</script>
</body>
</html> 
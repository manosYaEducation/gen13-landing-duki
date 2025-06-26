<?php
require_once __DIR__ . '/../../config.php';
$current_page = basename($_SERVER['PHP_SELF']);
$user = isset($_SESSION["username"]) ? $_SESSION["username"] : null;
$base_url = get_base_url();
?>
<nav class="navbar">
    <div class="navbar-brand">
        <button class="menu-toggle" id="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
    <img src="<?php echo $base_url; ?>/assets/ameri.png" alt="Logo" class="navbar-logo">
    <span class="nav-links">
        <a href="<?php echo $base_url; ?>/index.html" class="navbar-link">VOLVER A LA TIMELINE</a>
        <a href="<?php echo $base_url; ?>/front/tienda.php" class="navbar-link">PRODUCTOS</a>
        <a href="<?php echo $base_url; ?>/front/contacto.php" class="navbar-link">CONTACTO</a>
        <?php if ($user): ?>
            <div class="user-info">
                <img src="<?php echo $base_url; ?>/assets/devil (2).png" alt="Devil Icon" class="user-icon">
                <?php echo htmlspecialchars($user); ?>
            </div>
            
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="<?php echo $base_url; ?>/front/dashboard.php" class="login-btn-navbar">DASHBOARD</a>
            <?php endif; ?>
            <a href="<?php echo $base_url; ?>/logout.php" class="navbar-link logout-link">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        <?php else: ?>
            <a href="<?php echo $base_url; ?>/login.php" class="login-btn-navbar">INICIAR SESIÓN</a>
        <?php endif; ?>
    </span>
    <div class="nav-utils">
        <label for="moneda-tienda">Moneda:</label>
        <select id="moneda-tienda">
            <option value="CLP">CLP</option>
            <option value="ARS">ARS</option>
        </select>
        <a href="<?php echo get_base_url('front/carrito.php'); ?>" class="navbar-link cart-link">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-count">0</span>
        </a>
    </div>
</nav>

<style>
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(30, 30, 32, 0.98);
    border-bottom: 3px solid #6f0001;
    padding: 0.6rem 2rem;
    box-shadow: 0 2px 18px rgba(0, 0, 0, 0.12);
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    height: 64px;
    font-family: 'Anton', sans-serif;
}

.navbar-brand {
    display: flex;
    align-items: center;
}

.navbar-logo {
    width: 48px;
    height: 48px;
    object-fit: contain;
    transition: all 0.3s ease;
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.nav-utils {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.navbar-link {
    color: #c9cfd3;
    border-radius: 8px;
    padding: 0.7rem 1.6rem;
    font-size: 1.1rem;
    font-family: 'Bebas Neue', Arial, sans-serif;
    font-weight: bold;
    letter-spacing: 2px;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
    text-shadow: 0 0 8px rgba(255, 255, 255, 0.1);
}

.navbar-link:hover {
    background: #6f0001;
    color: #fff;
    text-shadow: 0 0 12px rgba(255, 255, 255, 0.2);
}

.navbar-link.cart-link {
    padding: 0;
    width: 30px;
    margin-right: 2rem;
}

.cart-link {
    position: relative;
}

.cart-link i {
    font-size: 1.3rem;
}

.cart-count {
    background: #e03838;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    position: absolute;
    top: -8px;
    right: -8px;
}

.user-info {
    color: #fff;
    font-weight: bold;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 0.7rem;
}

.user-icon {
    height: 28px;
    width: 28px;
    object-fit: contain;
}

.login-btn-navbar {
    color: #c9cfd3;
    border-radius: 8px;
    padding: 0.7rem 1.6rem;
    font-size: 1.1rem;
    font-family: 'Bebas Neue', Arial, sans-serif;
    font-weight: bold;
    letter-spacing: 2px;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
    text-shadow: 0 0 8px rgba(255, 255, 255, 0.1);
}

.login-btn-navbar:hover {
    background: #6f0001;
    color: #fff;
    text-shadow: 0 0 12px rgba(255, 255, 255, 0.2);
}

.logout-link i {
    font-size: 1.3rem;
}

#moneda-tienda {
    padding: 0.2rem 0.4rem;
    border-radius: 6px;
    border: none;
    background: rgba(24, 24, 28, 0.9);
    color: #fff;
    font-family: 'Bebas Neue', Arial, sans-serif;
    font-size: 0.95rem;
    cursor: pointer;
    border: 2px solid #6f0001;
    box-shadow: 0 0 12px #6f0001cc;
}

.menu-toggle {
    display: none;
    flex-direction: column;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.5rem;
}

.menu-toggle span {
    width: 25px;
    height: 3px;
    background: #fff;
    margin: 3px 0;
    transition: 0.3s;
}

@media (max-width: 768px) {
    .menu-toggle {
        display: flex;
    }
    
    .nav-links {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: rgba(30, 30, 32, 0.98);
        flex-direction: column;
        padding: 1rem;
        border-bottom: 3px solid #6f0001;
    }
    
    .nav-links.active {
        display: flex;
    }
    
    .nav-utils {
        margin-left: auto;
    }
}
</style>

<script>
document.getElementById('menu-toggle').addEventListener('click', function() {
    const navLinks = document.querySelector('.nav-links');
    navLinks.classList.toggle('active');
});
</script> 
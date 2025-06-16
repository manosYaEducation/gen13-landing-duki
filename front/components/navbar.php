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
        <a href="<?php echo $base_url; ?>/front/carrito.php" class="navbar-link cart-link">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-count">0</span>
        </a>
    </div>
</nav>

<style>
.navbar {
    display: flex;
    justify-content: space-between;
    background-color: #000000;
    border-bottom: 2.5px solid #6f0001;
    padding: 0.6rem auto;
    box-shadow: 0 2px 24px #6f0001cc;
}

.navbar-logo {
    width: 48px;
    margin-left: 2rem;
    transition: width 0.3s ease; /* Para una transición suave */
}
.navbar-link.cart-link{
    margin-right: 2rem;
}


@media (max-width: 768px) {
    .navbar-logo {
        width: 36px;
        height: 36px; /* Tamaño más pequeño para móviles */
        margin-right: 1rem; /* Margen más pequeño */
    }
}

@media (max-width: 480px) {
    .navbar-logo {
        width: 28px;
        height: 28px; /* Aún más pequeño para pantallas muy pequeñas */
        margin-right: 0.8rem;
    }
}

.nav-links {
    display: flex;
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
    margin-left: 1.2rem;
    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
    display: inline-block;
    margin-right: 1.5rem;
}
.navbar-link.cart-link{
    padding: 0;
    width: 30px;
}

.navbar-link:hover {
    background: #6f0001;
    color: #fff;
}



.currency-selector label {
    margin: 0;
    color: #fff;
}

#moneda-tienda {
    padding: 0.2rem 0.4rem;
    border-radius: 6px;
    border: none;
    font-family: 'Bebas Neue', Arial, sans-serif;
    font-size: 0.95rem;
    cursor: pointer;
}

.cart-link {
    position: relative;
   
}

.cart-link i {
    font-size: 1.3rem;
    padding:0;
   
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
    flex-direction: row;
}

.user-icon {
    height: 28px;
    width: 28px;
    object-fit: contain;
    vertical-align: middle;
    flex-direction: row;
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
    margin-left: 1.2rem;
    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
    display: inline-block;
    margin-right: 1.5rem;
}

.login-btn-navbar:hover {
    background: #6f0001;
    color: #fff;
}

.logout-link i {
    font-size: 1.3rem;
    margin-right: 1.5rem;
}

.menu-toggle {
    display: none;
    flex-direction: column;
    justify-content: space-between;
    width: 30px;
    height: 21px;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 0;
    margin-left: 1rem;
}

.menu-toggle span {
    width: 100%;
    height: 3px;
    background-color: #fff;
    border-radius: 3px;
    transition: all 0.3s ease;
}

@media (max-width: 820px) {
    .navbar {
        flex-direction: row;
        padding: 0.6rem 1rem;
        flex-wrap: wrap;
    }

    .menu-toggle {
        display: flex;
    }

    .menu-toggle.active span:nth-child(1) {
        transform: translateY(9px) rotate(45deg);
    }

    .menu-toggle.active span:nth-child(2) {
        opacity: 0;
    }

    .menu-toggle.active span:nth-child(3) {
        transform: translateY(-9px) rotate(-45deg);
    }

    .nav-links, .nav-utils {
        display: none;
        width: 100%;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        padding: 0;
        background-color: #000000;
        margin-top: 0;
    }

    .nav-links.active, .nav-utils.active {
        display: flex;
    }

    .nav-utils.active {
        flex-direction: row;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .navbar-link {
        width: 100%;
        text-align: center;
        padding: 0;
        font-size: 1rem;
    }

    .user-info {
        width: 100%;
        justify-content: center;
        font-size: 1rem;
    }

    .login-btn-navbar {
        width: 100%;
        text-align: center;
        margin: 0.5rem 0;
        font-size: 1rem;
        padding: 0.5rem 1rem;
    }

    .logout-link {
        width: auto;
        margin: 0.5rem 0;
    }

    .navbar-logo {
        width: 36px;
        height: 36px;
        margin-right: 1rem;
    }
}

@media (max-width: 480px) {
    .navbar-link {
        font-size: 1rem;
        padding: 0.3rem 0.6rem;
    }

    .login-btn-navbar {
        font-size: 1rem;
        padding: 0.6rem 1.2rem;
    }
}
</style>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    const navUtils = document.querySelector('.nav-utils');

    menuToggle.addEventListener('click', function() {
        this.classList.toggle('active');
        navLinks.classList.toggle('active');
        navUtils.classList.toggle('active');
    });

    // Cerrar menú al hacer clic en un enlace
    document.querySelectorAll('.navbar-link').forEach(link => {
        link.addEventListener('click', () => {
            menuToggle.classList.remove('active');
            navLinks.classList.remove('active');
            navUtils.classList.remove('active');
        });
    });

    // Cerrar menú al hacer clic fuera
    document.addEventListener('click', (e) => {
        if (!menuToggle.contains(e.target) && !navLinks.contains(e.target) && !navUtils.contains(e.target)) {
            menuToggle.classList.remove('active');
            navLinks.classList.remove('active');
            navUtils.classList.remove('active');
        }
    });

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
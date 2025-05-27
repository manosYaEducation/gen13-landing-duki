<?php
session_start();
$order_id = $_GET['order_id'] ?? null;

if (!$order_id) {
    header('Location: carrito.php');
    exit;
}

require_once '../db.php';

// Obtener información de la orden y sus detalles
$order = $conn->query("SELECT o.*, 
    (SELECT SUM(p.price * od.quantity) 
     FROM order_details od 
     JOIN products p ON od.product_id = p.id 
     WHERE od.order_id = o.id) as total,
    (SELECT COUNT(*) FROM order_details WHERE order_id = o.id) as num_items
    FROM orders o 
    WHERE o.id = $order_id")->fetch_assoc();

if (!$order) {
    header('Location: carrito.php');
    exit;
}

// Obtener los detalles de los productos
$details = $conn->query("SELECT od.*, p.name, p.price, p.image_url 
    FROM order_details od 
    JOIN products p ON od.product_id = p.id 
    WHERE od.order_id = $order_id");

$items = [];
while ($item = $details->fetch_assoc()) {
    $items[] = $item;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Pago - Tienda Duki</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6f0001;
            --bg-dark: #18181c;
            --bg-darker: #23232a;
            --success: #28a745;
            --danger: #dc3545;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg-dark);
            font-family: 'Bebas Neue', Arial, sans-serif;
            color: var(--white);
            line-height: 1.6;
            min-height: 100vh;
        }

        .navbar {
            background: var(--bg-darker);
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-logo {
            height: 40px;
        }

        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .card {
            background: var(--bg-darker);
            border-radius: 12px;
            border: 2px solid var(--primary);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .order-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--primary);
        }

        .order-title {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .order-subtitle {
            font-size: 1.2rem;
            opacity: 0.8;
        }

        .order-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .summary-item {
            padding: 1rem;
            background: rgba(111, 0, 1, 0.1);
            border-radius: 8px;
        }

        .summary-label {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-bottom: 0.5rem;
        }

        .summary-value {
            font-size: 1.5rem;
            color: var(--primary);
        }

        .products-list {
            margin-bottom: 2rem;
        }

        .product-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 1rem;
        }

        .product-info {
            flex: 1;
        }

        .product-name {
            font-size: 1.2rem;
            margin-bottom: 0.25rem;
        }

        .product-price {
            color: var(--primary);
        }

        .product-quantity {
            background: var(--primary);
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            margin-left: 1rem;
        }

        .total-section {
            text-align: right;
            padding: 1rem;
            border-top: 2px solid var(--primary);
            margin-top: 1rem;
        }

        .total-amount {
            font-size: 2rem;
            color: var(--primary);
        }

        .actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 8px;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.2rem;
            cursor: pointer;
            transition: transform 0.2s;
            min-width: 200px;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-approve {
            background: var(--success);
            color: var(--white);
        }

        .btn-reject {
            background: var(--danger);
            color: var(--white);
        }

        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .loading-content {
            text-align: center;
            color: var(--white);
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid var(--primary);
            border-top: 5px solid var(--white);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div style="display: flex; align-items: center;">
            <img src="../assets/ameri.png" alt="Logo" class="navbar-logo">
            <div class="navbar-menu">
                <a href="../index.html" class="navbar-link">Inicio</a>
                <a href="carrito.php" class="navbar-link">Carrito</a>
            </div>
        </div>
    </div>

    <div class="payment-container">
        <div class="payment-header">
            <h1>Confirmar Pago</h1>
            <p>Orden #<?php echo $order_id; ?></p>
        </div>
        
        <div class="payment-details">
            <h3>Detalles del Pedido</h3>
            <?php
            $details = $conn->query("SELECT od.*, p.name, p.price 
                FROM order_details od 
                JOIN products p ON od.product_id = p.id 
                WHERE od.order_id = $order_id");
            
            while ($item = $details->fetch_assoc()) {
                echo "<div style='margin: 10px 0;'>";
                echo "<strong>{$item['name']}</strong> x {$item['quantity']}";
                echo "<span style='float: right'>$" . number_format($item['price'] * $item['quantity'], 0, ',', '.') . "</span>";
                echo "</div>";
            }
            ?>
        </div>

        <div class="payment-total">
            <strong>Total a Pagar:</strong> $<?php echo number_format($order['total'], 0, ',', '.'); ?>
        </div>

        <div class="payment-actions">
            <button class="btn-approve" onclick="procesarPago('approved')">Aprobar Pago</button>
            <button class="btn-reject" onclick="procesarPago('rejected')">Rechazar Pago</button>
        </div>
    </div>

    <script>
        async function procesarPago(status) {
            try {
                const response = await fetch('../api/procesar_pago.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        order_id: <?php echo $order_id; ?>,
                        status: status
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    // Limpiar el carrito
                    localStorage.removeItem('carritoDuki');
                    // Redirigir a la página de la boleta
                    window.location.href = 'ver_boleta.php?order_id=<?php echo $order_id; ?>';
                } else {
                    alert(data.message || 'Error al procesar el pago');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al procesar el pago');
            }
        }
    </script>
</body>
</html>

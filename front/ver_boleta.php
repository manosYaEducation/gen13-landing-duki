<?php
require_once '../db.php';

// Verificar si se proporcionó un ID de orden
if (!isset($_GET['order_id'])) {
    header('Location: tienda.php');
    exit;
}

$orderId = intval($_GET['order_id']);

// Obtener información de la orden
$order = $conn->query("SELECT o.*, 
    (SELECT SUM(p.price * od.quantity) 
     FROM order_details od 
     JOIN products p ON od.product_id = p.id 
     WHERE od.order_id = o.id) as total 
    FROM orders o 
    WHERE o.id = $orderId")->fetch_assoc();

if (!$order) {
    header('Location: tienda.php');
    exit;
}

// Obtener detalles de la orden
$details = $conn->query("SELECT od.*, p.name, p.price 
    FROM order_details od 
    JOIN products p ON od.product_id = p.id 
    WHERE od.order_id = $orderId");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta - Orden #<?php echo $orderId; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            background: #18181c;
            min-height: 100vh;
            font-family: 'Bebas Neue', Arial, sans-serif;
            margin: 0;
            padding: 2rem;
            color: #fff;
        }
        .boleta {
            max-width: 800px;
            margin: 0 auto;
            background: #1f1f23;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 0 24px #6f0001cc;
        }
        .boleta-header {
            text-align: center;
            margin-bottom: 2rem;
            border-bottom: 2px solid #6f0001;
            padding-bottom: 1rem;
        }
        .boleta-title {
            font-size: 2.5rem;
            color: #fff;
            text-shadow: 0 0 24px #6f0001;
            margin: 0;
        }
        .boleta-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .info-item {
            background: #18181c;
            padding: 1rem;
            border-radius: 8px;
        }
        .info-label {
            color: #999;
            font-size: 0.9rem;
            margin-bottom: 0.3rem;
        }
        .info-value {
            color: #fff;
            font-size: 1.2rem;
        }
        .productos-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }
        .productos-table th {
            background: #6f0001;
            color: #fff;
            padding: 0.8rem;
            text-align: left;
        }
        .productos-table td {
            padding: 0.8rem;
            border-bottom: 1px solid #333;
        }
        .total {
            text-align: right;
            font-size: 1.5rem;
            color: #e0b800;
            margin-top: 1rem;
        }
        .status {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: bold;
        }
        .status-pendiente { background: #e0b800; color: #000; }
        .status-aprobado { background: #1fa700; color: #fff; }
        .status-rechazado { background: #6f0001; color: #fff; }
        
        .payment-frame {
            width: 100%;
            height: 600px;
            border: none;
            margin-top: 2rem;
            border-radius: 8px;
            background: #fff;
        }
    </style>
</head>
<body>
    <div class="boleta">
        <div class="boleta-header">
            <h1 class="boleta-title">Boleta - Orden #<?php echo $orderId; ?></h1>
        </div>
        
        <div class="boleta-info">
            <div class="info-item">
                <div class="info-label">Fecha</div>
                <div class="info-value"><?php echo date('d/m/Y H:i', strtotime($order['fecha'])); ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Estado</div>
                <div class="info-value">
                    <span class="status status-<?php echo $order['status']; ?>">
                        <?php echo ucfirst($order['status']); ?>
                    </span>
                </div>
            </div>
            <?php if ($order['transaction_id']): ?>
            <div class="info-item">
                <div class="info-label">ID Transacción</div>
                <div class="info-value"><?php echo $order['transaction_id']; ?></div>
            </div>
            <?php endif; ?>
            <div class="info-item">
                <div class="info-label">Estado de Pago</div>
                <div class="info-value"><?php echo ucfirst($order['payment_status'] ?? 'pendiente'); ?></div>
            </div>
        </div>
        
        <table class="productos-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unit.</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($detail = $details->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($detail['name']); ?></td>
                    <td><?php echo $detail['quantity']; ?></td>
                    <td>$<?php echo number_format($detail['price'], 0, ',', '.'); ?></td>
                    <td>$<?php echo number_format($detail['price'] * $detail['quantity'], 0, ',', '.'); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <div class="total">
            Total: $<?php echo number_format($order['total'], 0, ',', '.'); ?>
        </div>
        
        <?php if ($order['status'] === 'pendiente' && (!isset($order['payment_status']) || $order['payment_status'] === 'pending')): ?>
        <div id="payment-container">
            <button onclick="iniciarPago()" 
                    style="display: block; width: 100%; margin-top: 1rem; padding: 1rem; 
                           background: #6f0001; color: white; border: none; border-radius: 8px; 
                           font-size: 1.2rem; cursor: pointer;">
                Pagar ahora
            </button>
        </div>
        
        <script>
        async function iniciarPago() {
            try {
                const response = await fetch('procesar_pago.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        order_id: <?php echo $orderId; ?>
                    })
                });
                
                const data = await response.json();
                
                if (data.success && data.url_pago) {
                    // Crear el iframe para el pago
                    const container = document.getElementById('payment-container');
                    container.innerHTML = `<iframe src="${data.url_pago}" class="payment-frame"></iframe>`;
                } else {
                    alert('Error al iniciar el pago: ' + (data.message || 'Error desconocido'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al procesar la solicitud');
            }
        }
        </script>
        <?php endif; ?>
    </div>
</body>
</html>

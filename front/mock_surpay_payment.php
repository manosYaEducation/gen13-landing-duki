<?php
session_start();
require_once '../db.php';

// Definir la ruta base
$base_url = '/landing_duki';

// Obtener los datos de la URL
$transaction_id = $_GET['transaction_id'] ?? '';
$amount = $_GET['amount'] ?? 0;
$redirect_url = $_GET['redirect_url'] ?? '';
$status_url = $_GET['status_url'] ?? '';

// Obtener el ID de la orden desde el transaction_id (TX_timestamp_orderid)
$orderId = explode('_', $transaction_id)[2] ?? 0;

// Obtener la información de la orden
$order = null;
if ($orderId) {
    $order = $conn->query("SELECT * FROM orders WHERE id = $orderId")->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar Pedido - Tienda Duki</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <style>
        body {
            background: #18181c;
            margin: 0;
            font-family: 'Bebas Neue', Arial, sans-serif;
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem;
        }
        .payment-container {
            background: #23232a;
            border-radius: 18px;
            box-shadow: 0 0 24px #6f0001cc;
            padding: 2rem;
            max-width: 600px;
            width: 100%;
            margin-top: 2rem;
        }
        .payment-title {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 2rem;
            color: #e0b800;
        }
        .payment-details {
            margin-bottom: 2rem;
        }
        .payment-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding: 0.5rem 0;
            border-bottom: 1px solid #333;
        }
        .payment-label {
            color: #999;
        }
        .payment-value {
            color: #fff;
            font-weight: bold;
        }
        .payment-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }
        .btn {
            background: #6f0001;
            color: #fff;
            border: none;
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Bebas Neue', Arial, sans-serif;
            transition: background 0.2s;
        }
        .btn:hover {
            background: #8f0001;
        }
        .btn-secondary {
            background: #333;
        }
        .btn-secondary:hover {
            background: #444;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <div class="payment-title">PAGAR PEDIDO</div>
        
        <div class="payment-details">
            <div class="payment-row">
                <div class="payment-label">Orden #:</div>
                <div class="payment-value"><?php echo $orderId; ?></div>
            </div>
            <div class="payment-row">
                <div class="payment-label">Total:</div>
                <div class="payment-value">$<?php echo number_format($amount, 0, ',', '.'); ?></div>
            </div>
            <div class="payment-row">
                <div class="payment-label">Estado:</div>
                <div class="payment-value"><?php echo $order ? strtoupper($order['status']) : 'PENDIENTE'; ?></div>
            </div>
        </div>
        
        <form id="payment-form">
            <input type="hidden" name="transaction_id" value="<?php echo htmlspecialchars($transaction_id); ?>">
            <input type="hidden" name="status_url" value="<?php echo htmlspecialchars($status_url); ?>">
            <input type="hidden" name="redirect_url" value="<?php echo htmlspecialchars($redirect_url); ?>">
            
            <div class="payment-actions">
                <button type="button" class="btn btn-secondary" onclick="simularPago('rejected')">RECHAZAR PAGO</button>
                <button type="button" class="btn" onclick="simularPago('approved')">APROBAR PAGO</button>
            </div>
        </form>
    </div>

    <script>
        async function simularPago(status) {
            const form = document.getElementById('payment-form');
            const transaction_id = form.querySelector('[name="transaction_id"]').value;
            const status_url = form.querySelector('[name="status_url"]').value;
            const redirect_url = form.querySelector('[name="redirect_url"]').value;
            
            try {
                // Notificar al callback URL
                if (status_url) {
                    await fetch(status_url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            transaction_id: transaction_id,
                            status: status
                        })
                    });
                }
                
                // Redirigir
                window.location.href = redirect_url + (redirect_url.includes('?') ? '&' : '?') + 
                    'status=' + status + '&transaction_id=' + transaction_id;
                
            } catch (error) {
                console.error('Error:', error);
                alert('Error al procesar el pago');
            }
        }
    </script>
</body>
</html>

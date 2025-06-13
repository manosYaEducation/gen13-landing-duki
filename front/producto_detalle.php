<?php
// producto_detalle.php
session_start();
require_once '../db.php';

// Verificar la ruta base
echo '<!-- Ruta base: ' . $_SERVER['DOCUMENT_ROOT'] . ' -->';
echo '<!-- Ruta actual: ' . __FILE__ . ' -->';

// Definir la ruta base
$base_url = '/landing-duki';

// Obtener el ID del producto desde la URL
if (!isset($_GET['id'])) {
    header('Location: tienda.php');
    exit;
}
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$producto = $result->fetch_assoc();
if (!$producto) {
    header('Location: tienda.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($producto['name']); ?> - Duki</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            background: #18181c;
            margin: 0;
            font-family: 'Bebas Neue', Arial, sans-serif;
            color: #fff;
        }
        .detalle-container {
            max-width: 1200px;
            margin: 100px auto 50px;
            padding: 0 20px;
        }
        .producto-detalle {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            background: #23232a;
            border-radius: 18px;
            padding: 2rem;
            box-shadow: 0 0 24px #6f0001cc;
        }
        .producto-imagen {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 0 12px #6f0001aa;
        }
        .producto-info {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        .producto-nombre {
            font-size: 2.5rem;
            font-weight: bold;
            letter-spacing: 2px;
            margin: 0;
        }
        .producto-precio {
            color: #e03838;
            font-size: 2rem;
            font-weight: bold;
        }
        .producto-descripcion {
            font-size: 1.2rem;
            line-height: 1.6;
            color: #c9cfd3;
        }
        .producto-acciones {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        .cantidad-selector {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        .btn-cantidad {
            background: #23232a;
            color: #fff;
            border: 2px solid #6f0001;
            border-radius: 8px;
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-cantidad:hover {
            background: #6f0001;
        }
        #cantidad {
            width: 60px;
            height: 40px;
            text-align: center;
            font-size: 1.2rem;
            font-family: 'Bebas Neue', Arial, sans-serif;
            border: 2px solid #6f0001;
            border-radius: 8px;
            background: #23232a;
            color: #fff;
        }
        #cantidad::-webkit-inner-spin-button,
        #cantidad::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .btn-comprar {
            background: linear-gradient(90deg, #400208 0%, #6f0001 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 1rem 2rem;
            font-size: 1.2rem;
            font-family: 'Bebas Neue', Arial, sans-serif;
            font-weight: bold;
            letter-spacing: 2px;
            box-shadow: 0 0 12px #6f0001cc;
            cursor: pointer;
            text-shadow: 0 0 8px #fff, 0 0 6px #6f0001;
            transition: background 0.2s, box-shadow 0.2s;
            text-decoration: none;
        }
        .btn-comprar:hover {
            background: linear-gradient(90deg, #6f0001 0%, #400208 100%);
            box-shadow: 0 0 24px #6f0001;
        }
        .btn-volver {
            background: #23232a;
            color: #fff;
            border: 2px solid #6f0001;
            border-radius: 8px;
            padding: 1rem 2rem;
            font-size: 1.2rem;
            font-family: 'Bebas Neue', Arial, sans-serif;
            font-weight: bold;
            letter-spacing: 2px;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            text-decoration: none;
        }
        .btn-volver:hover {
            background: #6f0001;
            color: #fff;
        }
        .notificacion {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #6f0001;
            color: white;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-family: 'Bebas Neue', Arial, sans-serif;
            font-size: 1.2rem;
            letter-spacing: 1px;
            box-shadow: 0 0 24px #6f0001cc;
            z-index: 1000;
            animation: slideIn 0.3s ease-out;
        }
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @media (max-width: 768px) {
            .producto-detalle {
                grid-template-columns: 1fr;
            }
            .producto-imagen {
                height: 300px;
            }
            .producto-acciones {
                flex-direction: column;
            }
            .btn-comprar, .btn-volver {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <?php include 'components/navbar.php'; ?>

    <div class="detalle-container">
        <div class="producto-detalle">
            <img src="<?php echo htmlspecialchars($producto['image']); ?>" alt="<?php echo htmlspecialchars($producto['name']); ?>" class="producto-imagen">
            <div class="producto-info">
                <h1 class="producto-nombre"><?php echo htmlspecialchars($producto['name']); ?></h1>
                <div class="producto-precio" data-precio="<?php echo $producto['price']; ?>">$<?php echo number_format($producto['price'],0,',','.'); ?></div>
                <?php if(isset($producto['description'])): ?>
                    <p class="producto-descripcion"><?php echo htmlspecialchars($producto['description']); ?></p>
                <?php endif; ?>
                <div class="producto-acciones">
                    <div class="cantidad-selector">
                        <button class="btn-cantidad" onclick="cambiarCantidad(-1)">-</button>
                        <input type="number" id="cantidad" value="1" min="1" max="99" onchange="validarCantidad()">
                        <button class="btn-cantidad" onclick="cambiarCantidad(1)">+</button>
                    </div>
                    <button class="btn-comprar" onclick="agregarAlCarrito(<?php echo $producto['id']; ?>, '<?php echo addslashes(htmlspecialchars($producto['name'])); ?>', <?php echo $producto['price']; ?>, '<?php echo addslashes(htmlspecialchars($producto['image'])); ?>');">AGREGAR AL CARRITO</button>
                    <a href="tienda.php" class="btn-volver">VOLVER A LA TIENDA</a>
                </div>
            </div>
        </div>
    </div>

    <script>
    function cambiarCantidad(delta) {
        const input = document.getElementById('cantidad');
        const nuevaCantidad = parseInt(input.value) + delta;
        if (nuevaCantidad >= 1 && nuevaCantidad <= 99) {
            input.value = nuevaCantidad;
        }
    }

    function validarCantidad() {
        const input = document.getElementById('cantidad');
        let valor = parseInt(input.value);
        if (isNaN(valor) || valor < 1) valor = 1;
        if (valor > 99) valor = 99;
        input.value = valor;
    }

    function agregarAlCarrito(id, nombre, precio, imagen) {
        const cantidad = parseInt(document.getElementById('cantidad').value);
        let carrito = JSON.parse(localStorage.getItem('carritoDuki')) || [];
        const productoExistente = carrito.find(item => item.id === id);

        if (productoExistente) {
            productoExistente.cantidad += cantidad;
        } else {
            carrito.push({
                id: id,
                nombre: nombre,
                precio: precio,
                imagen: imagen,
                cantidad: cantidad
            });
        }

        localStorage.setItem('carritoDuki', JSON.stringify(carrito));
        actualizarContadorCarrito();
        mostrarNotificacion('Producto agregado al carrito');
    }

    function actualizarContadorCarrito() {
        const carrito = JSON.parse(localStorage.getItem('carritoDuki')) || [];
        const count = carrito.reduce((total, item) => total + item.cantidad, 0);
        document.querySelectorAll('.cart-count').forEach(el => {
            el.textContent = count;
        });
    }

    function mostrarNotificacion(mensaje) {
        const notificacion = document.createElement('div');
        notificacion.className = 'notificacion';
        notificacion.textContent = mensaje;
        document.body.appendChild(notificacion);

        setTimeout(() => {
            notificacion.remove();
        }, 2000);
    }

    // Inicializar contador del carrito
    actualizarContadorCarrito();
    </script>
</body>
</html>

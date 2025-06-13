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
    <title>Carrito - Duki</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            background: #18181c;
            margin: 0;
            font-family: 'Bebas Neue', Arial, sans-serif;
            color: #fff;
            opacity: 0;
            transition: opacity 0.3s ease-in;
        }
        body.loaded {
            opacity: 1;
        }
        .carrito-container {
            max-width: 1200px;
            margin: 100px auto 50px;
            padding: 0 20px;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease-out;
        }
        .carrito-container.loaded {
            opacity: 1;
            transform: translateY(0);
        }
        .carrito-titulo {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            text-align: center;
            letter-spacing: 2px;
        }
        .carrito-vacio {
            text-align: center;
            font-size: 1.2rem;
            color: #c9cfd3;
            margin-top: 3rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease-out;
        }
        .carrito-vacio.loaded {
            opacity: 1;
            transform: translateY(0);
        }
        .carrito-items {
            display: grid;
            gap: 2rem;
        }
        .carrito-item {
            background: #23232a;
            border-radius: 18px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 2rem;
            box-shadow: 0 0 24px #6f0001cc;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease-out;
        }
        .carrito-item.loaded {
            opacity: 1;
            transform: translateY(0);
        }
        .item-imagen {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 0 12px #6f0001aa;
        }
        .item-info {
            flex: 1;
        }
        .item-nombre {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
        }
        .item-precio {
            color: #e03838;
            font-size: 1.2rem;
            font-weight: bold;
        }
        .item-cantidad {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 1rem;
        }
        .cantidad-btn {
            background: #6f0001;
            color: #fff;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 5px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .cantidad-btn:hover {
            background: #400208;
        }
        .cantidad-valor {
            font-size: 1.2rem;
            min-width: 30px;
            text-align: center;
        }
        .item-eliminar {
            background: none;
            border: none;
            color: #e03838;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            transition: color 0.2s;
        }
        .item-eliminar:hover {
            color: #ff4d4d;
        }
        .carrito-total {
            margin-top: 3rem;
            text-align: right;
            font-size: 1.5rem;
        }
        .total-valor {
            color: #e03838;
            font-weight: bold;
        }
        .carrito-acciones {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }
        .accion-btn {
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
        }
        .accion-btn:hover {
            background: linear-gradient(90deg, #6f0001 0%, #400208 100%);
            box-shadow: 0 0 24px #6f0001;
        }
        .accion-btn.vaciar {
            background: #23232a;
            color: #e03838;
            border: 2px solid #e03838;
        }
        .accion-btn.vaciar:hover {
            background: #e03838;
            color: #fff;
        }
        @media (max-width: 768px) {
            .carrito-item {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
            .item-cantidad {
                justify-content: center;
            }
            .carrito-acciones {
                flex-direction: column;
            }
            .accion-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php include 'components/navbar.php'; ?>

    <div class="carrito-container">
        <h1 class="carrito-titulo">MI CARRITO</h1>
        
        <div id="carrito-items" class="carrito-items">
            <!-- Los items del carrito se cargarán dinámicamente aquí -->
        </div>

        <div id="carrito-vacio" class="carrito-vacio" style="display: none;">
            Tu carrito está vacío
        </div>

        <div id="carrito-total" class="carrito-total" style="display: none;">
            Total: <span class="total-valor">$0</span>
        </div>

        <div id="carrito-acciones" class="carrito-acciones" style="display: none;">
            <button class="accion-btn vaciar" onclick="vaciarCarrito()">VACIAR CARRITO</button>
            <button class="accion-btn" onclick="procederPago()">PROCEDER AL PAGO</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Mostrar el body con fade in
            document.body.classList.add('loaded');
            
            // Mostrar el contenedor con animación
            setTimeout(() => {
                document.querySelector('.carrito-container').classList.add('loaded');
                actualizarCarrito();
            }, 100);
        });

        function actualizarCarrito() {
            const carrito = JSON.parse(localStorage.getItem('carritoDuki')) || [];
            const contenedor = document.getElementById('carrito-items');
            const vacio = document.getElementById('carrito-vacio');
            const total = document.getElementById('carrito-total');
            const acciones = document.getElementById('carrito-acciones');

            if (carrito.length === 0) {
                contenedor.style.display = 'none';
                vacio.style.display = 'block';
                setTimeout(() => {
                    vacio.classList.add('loaded');
                }, 100);
                total.style.display = 'none';
                acciones.style.display = 'none';
                return;
            }

            contenedor.style.display = 'grid';
            vacio.style.display = 'none';
            total.style.display = 'block';
            acciones.style.display = 'flex';

            // Usar DocumentFragment para mejor rendimiento
            const fragment = document.createDocumentFragment();
            let totalPrecio = 0;

            carrito.forEach((item, index) => {
                const itemElement = document.createElement('div');
                itemElement.className = 'carrito-item';
                itemElement.innerHTML = `
                    <img src="${item.imagen}" alt="${item.nombre}" class="item-imagen" loading="lazy">
                    <div class="item-info">
                        <div class="item-nombre">${item.nombre}</div>
                        <div class="item-precio">$${item.precio.toLocaleString()}</div>
                        <div class="item-cantidad">
                            <button class="cantidad-btn" onclick="actualizarCantidad(${item.id}, ${item.cantidad - 1})">-</button>
                            <span class="cantidad-valor">${item.cantidad}</span>
                            <button class="cantidad-btn" onclick="actualizarCantidad(${item.id}, ${item.cantidad + 1})">+</button>
                        </div>
                    </div>
                    <button class="item-eliminar" onclick="eliminarItem(${item.id})">×</button>
                `;
                fragment.appendChild(itemElement);
                totalPrecio += item.precio * item.cantidad;

                // Animar cada item con un pequeño retraso
                setTimeout(() => {
                    itemElement.classList.add('loaded');
                }, 100 * (index + 1));
            });

            // Limpiar y agregar todos los elementos de una vez
            contenedor.innerHTML = '';
            contenedor.appendChild(fragment);
            document.querySelector('.total-valor').textContent = `$${totalPrecio.toLocaleString()}`;
        }

        function actualizarCantidad(id, nuevaCantidad) {
            if (nuevaCantidad < 1) {
                eliminarItem(id);
                return;
            }

            const carrito = JSON.parse(localStorage.getItem('carritoDuki')) || [];
            const item = carrito.find(item => item.id === id);
            if (item) {
                item.cantidad = nuevaCantidad;
                localStorage.setItem('carritoDuki', JSON.stringify(carrito));
                actualizarCarrito();
            }
        }

        function eliminarItem(id) {
            const carrito = JSON.parse(localStorage.getItem('carritoDuki')) || [];
            const nuevoCarrito = carrito.filter(item => item.id !== id);
            localStorage.setItem('carritoDuki', JSON.stringify(nuevoCarrito));
            actualizarCarrito();
        }

        function vaciarCarrito() {
            if (confirm('¿Estás seguro de que quieres vaciar el carrito?')) {
                localStorage.removeItem('carritoDuki');
                actualizarCarrito();
            }
        }

        function procederPago() {
            // Aquí iría la lógica para proceder al pago
            alert('Funcionalidad de pago en desarrollo');
        }
    </script>
</body>
</html>

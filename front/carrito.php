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
    <title>Carrito - Tienda Duki</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            background: #18181c;
            margin: 0;
            font-family: 'Bebas Neue', Arial, sans-serif;
            color: #fff;
        }
        .navbar {
            background: #18181c;
            border-bottom: 2.5px solid #6f0001;
            display: flex;
            align-items: center;
            padding: 0.6rem 2rem;
            box-shadow: 0 2px 24px #6f0001cc;
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
            background: linear-gradient(90deg, #400208 0%, #6f0001 100%);
            color: #c9cfd3;
            border: none;
            border-radius: 8px;
            padding: 0.7rem 1.6rem;
            font-size: 1.1rem;
            font-family: 'Bebas Neue', Arial, sans-serif;
            font-weight: bold;
            letter-spacing: 2px;
            box-shadow: 0 0 12px #6f0001cc;
            cursor: pointer;
            text-shadow: 0 0 8px #899cbc, 0 0 6px #556694;
            text-decoration: none;
            margin-left: 1.2rem;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
            display: inline-block;
            border: 2px solid #899cbc;
        }
        .login-btn-navbar:hover {
            background: linear-gradient(90deg, #6f0001 0%, #400208 100%);
            color: #fff;
            box-shadow: 0 0 24px #6f0001;
            border-color: #556694;
        }
        .carrito-container {
            max-width: 1000px;
            margin: 3rem auto;
            padding: 2rem;
            background: #23232a;
            border-radius: 16px;
            box-shadow: 0 0 24px #6f0001cc;
        }
        .carrito-titulo {
            font-size: 2.2rem;
            margin-bottom: 1.5rem;
            color: #e0b800;
            letter-spacing: 2px;
            text-align: center;
        }
        .carrito-vacio {
            text-align: center;
            padding: 2rem;
            color: #c9cfd3;
            font-size: 1.2rem;
        }
        .carrito-item {
            display: flex;
            align-items: center;
            background: #18181c;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            border: 1px solid #6f0001;
        }
        .carrito-item-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 1.5rem;
        }
        .carrito-item-info {
            flex: 1;
        }
        .carrito-item-nombre {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .carrito-item-precio {
            font-size: 1.1rem;
            color: #e03838;
            margin-bottom: 0.5rem;
        }
        .carrito-item-acciones {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .cantidad-control {
            display: flex;
            align-items: center;
            background: #2a2a32;
            border-radius: 8px;
            overflow: hidden;
        }
        .btn-cantidad {
            background: #6f0001;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            font-family: 'Bebas Neue', Arial, sans-serif;
            font-size: 1.1rem;
            cursor: pointer;
        }
        .cantidad-valor {
            padding: 0.5rem 1rem;
            min-width: 2rem;
            text-align: center;
        }
        .btn-eliminar {
            background: #6f0001;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-family: 'Bebas Neue', Arial, sans-serif;
            font-size: 1rem;
            cursor: pointer;
        }
        .carrito-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 2px solid #6f0001;
        }
        .carrito-total-texto {
            font-size: 1.6rem;
            font-weight: bold;
        }
        .carrito-total-valor {
            font-size: 1.8rem;
            color: #e03838;
            font-weight: bold;
        }
        .carrito-acciones {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
        }
        .btn-seguir-comprando {
            background: #23232a;
            color: #fff;
            border: 2px solid #6f0001;
            border-radius: 8px;
            padding: 0.8rem 1.5rem;
            font-size: 1.1rem;
            font-family: 'Bebas Neue', Arial, sans-serif;
            font-weight: bold;
            letter-spacing: 1px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-finalizar-compra {
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
        }
        .btn-finalizar-compra:hover {
            background: linear-gradient(90deg, #6f0001 0%, #400208 100%);
        }
        .metodos-pago {
            margin-top: 2rem;
            display: none;
        }
        .metodos-pago-titulo {
            font-size: 1.4rem;
            margin-bottom: 1rem;
            color: #e0b800;
        }
        .metodos-pago-opciones {
            display: flex;
            gap: 1rem;
        }
        .metodo-btn {
            background: #23232a;
            color: #fff;
            border: 2px solid #6f0001;
            border-radius: 8px;
            padding: 0.8rem 1.5rem;
            font-size: 1.1rem;
            font-family: 'Bebas Neue', Arial, sans-serif;
            font-weight: bold;
            letter-spacing: 1px;
            cursor: pointer;
        }
        .metodo-btn.selected {
            background: #6f0001;
            color: #fff;
        }
        .notificacion {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #6f0001;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            transform: translateX(120%);
            transition: transform 0.3s ease-in-out;
            z-index: 1000;
        }
        .notificacion.mostrar {
            transform: translateX(0);
        }
        #carrito-contador {
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
    </style>
</head>
<body>
    <div class="navbar" style="display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center;">
            <img src="<?php echo $base_url; ?>/assets/ameri.png" alt="Logo" class="navbar-logo">
            <div class="navbar-menu">
                <a href="<?php echo $base_url; ?>/index.html" class="navbar-link">VOLVER A LA TIMELINE</a>
                <a href="<?php echo $base_url; ?>/front/tienda.php" class="navbar-link">PRODUCTOS</a>
                <a href="<?php echo $base_url; ?>/front/contacto.php" class="navbar-link">CONTACTO</a>
                <a href="<?php echo $base_url; ?>/front/carrito.php" class="navbar-link" style="position: relative;">
                    CARRITO
                    <span id="carrito-contador">0</span>
                </a>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 1.2rem;">
            <?php if ($user): ?>
                <div style="color:#fff; font-weight:bold; font-size:1.1rem; display:flex; align-items:center; gap:0.7rem;">
                    <img src="<?php echo $base_url; ?>/assets/devil (2).png" alt="Devil Icon" style="height:28px; width:28px; object-fit:contain; vertical-align:middle;">
                    <?php echo htmlspecialchars($user); ?>
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

    <div class="carrito-container">
        <h1 class="carrito-titulo">TU CARRITO</h1>
        <div id="carrito-items"></div>
        
        <div class="carrito-total">
            <div class="carrito-total-texto">TOTAL:</div>
            <div class="carrito-total-valor" id="carrito-total-valor">$0</div>
        </div>

        <div id="envio-gratis-barra" style="margin-top: 1rem; text-align: center; font-size: 1.2rem; color: #e0b800;"></div>
        
        <div style="margin-top: 1.5rem; text-align: center;">
            <label for="pais-envio" style="font-size: 1.2rem; color: #e0b800;">Selecciona tu país de envío:</label><br>
            <select id="pais-envio" style="margin-top: 0.5rem; padding: 0.5rem; font-size: 1rem; border-radius: 6px;">
                <option value="Chile">Chile</option>
                <option value="Argentina">Argentina</option>
            </select>
        </div>

        <div id="tiempo-entrega" style="margin-top: 1rem; text-align: center; font-size: 1.2rem; color: #e0b800;"></div>

        <div class="carrito-acciones">
            <a href="<?php echo $base_url; ?>/front/tienda.php" class="btn-seguir-comprando">SEGUIR COMPRANDO</a>
            <button onclick="finalizarCompra()" class="btn-finalizar-compra">FINALIZAR COMPRA</button>
        </div>

        <div class="metodos-pago" id="metodos-pago">
            <div class="metodos-pago-titulo">SELECCIONA EL MÉTODO DE PAGO:</div>
            <div class="metodos-pago-opciones">
                <button type="button" class="metodo-btn selected" id="btn-transferencia" onclick="seleccionarMetodo('Transferencia')">TRANSFERENCIA</button>
                <button type="button" class="metodo-btn" id="btn-efectivo" onclick="seleccionarMetodo('Efectivo')">EFECTIVO</button>
                <input type="hidden" id="metodo-pago" value="Transferencia">
            </div>
            <div style="margin-top: 1.5rem;">
                <button class="btn-finalizar-compra" id="btn-pagar-whatsapp">PAGAR AHORA</button>
            </div>
        </div>
    </div>

    <!-- Overlay de carga -->
    <div id="loading-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; text-align: center;">
            <div class="loader" style="border: 5px solid #f3f3f3; border-top: 5px solid #6f0001; border-radius: 50%; width: 50px; height: 50px; animation: spin 1s linear infinite; margin: 0 auto 20px;"></div>
            <div>Procesando pedido...</div>
        </div>
    </div>

    <style>
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .btn-finalizar-compra:disabled {
            background: #666;
            cursor: not-allowed;
        }
    </style>

    <script src="carrito.js"></script>
    <script>
        // Función para seleccionar método de pago
        function seleccionarMetodo(metodo) {
            document.getElementById('metodo-pago').value = metodo;
            document.querySelectorAll('.metodo-btn').forEach(btn => {
                btn.classList.remove('selected');
            });
            document.getElementById('btn-' + metodo.toLowerCase()).classList.add('selected');
        }

        // Crear orden y redirigir a la boleta
        async function finalizarCompra() {
            const btnFinalizar = document.getElementById('btn-finalizar-compra');
            const loadingOverlay = document.getElementById('loading-overlay');
            
            try {
                const carrito = JSON.parse(localStorage.getItem('carritoDuki')) || [];
                
                if (carrito.length === 0) {
                    alert('El carrito está vacío');
                    return;
                }
                
                // Deshabilitar botón y mostrar overlay
                if (btnFinalizar) btnFinalizar.disabled = true;
                if (loadingOverlay) loadingOverlay.style.display = 'block';
                
                // Crear la orden
                const response = await fetch('crear_pedido.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        carrito: carrito
                    })
                });
                
                const data = await response.json();
                
                if (!data.success) {
                    throw new Error(data.message || 'Error al crear la orden');
                }

                // Marcar que ya no es usuario nuevo
                localStorage.setItem('primeraCompraHecha', 'true');

                // Redirigir a la página de confirmación de pago
                window.location.href = `confirmar_pago.php?order_id=${data.order_id}&total=${data.total}`;
                
            } catch (error) {
                console.error('Error:', error);
                alert(error.message || 'Error al procesar la solicitud');
            } finally {
                // Rehabilitar botón y ocultar overlay
                if (btnFinalizar) btnFinalizar.disabled = false;
                if (loadingOverlay) loadingOverlay.style.display = 'none';
            }
        }
        
        // Renderizar el carrito
        function renderizarCarrito() {
            const carritoItems = document.getElementById('carrito-items');
            const carritoTotalValor = document.getElementById('carrito-total-valor');
            const carrito = JSON.parse(localStorage.getItem('carritoDuki')) || [];
            const btnFinalizar = document.getElementById('btn-finalizar-compra');
            const metodosPago = document.getElementById('metodos-pago');
            
            if (carrito.length === 0) {
                carritoItems.innerHTML = '<div class="carrito-vacio">No hay productos en tu carrito</div>';
                carritoTotalValor.textContent = '$0';
                if (btnFinalizar) btnFinalizar.style.display = 'none';
                if (metodosPago) metodosPago.style.display = 'none';
                return;
            }
            
            if (btnFinalizar) btnFinalizar.style.display = 'block';
            if (metodosPago) metodosPago.style.display = 'block';
            carritoItems.innerHTML = '';
            
            const moneda = localStorage.getItem('monedaSeleccionada') || 'CLP';

            const tipoCambio = {
                CLP: 1,
                ARS: 1.26
            };

            const factorCambio = tipoCambio[moneda] || 1;

            let total = 0;
            carrito.forEach(item => {
                const subtotal = item.precio * item.cantidad;
                total += subtotal;

                const precioConvertido = item.precio * factorCambio;
                const subtotalConvertido = subtotal * factorCambio;

                const itemHtml = `
                    <div class="carrito-item">
                        <img src="${item.imagen}" alt="${item.nombre}" class="carrito-item-img">
                        <div class="carrito-item-info">
                            <div class="carrito-item-nombre">${item.nombre}</div>
                            <div class="carrito-item-precio">${moneda} $${precioConvertido.toLocaleString('es-CL')}</div>
                            <div class="carrito-item-subtotal" style="color: #e0b800; margin-top: 0.5rem;">Subtotal: ${moneda} $${subtotalConvertido.toLocaleString('es-CL')}</div>
                        </div>
                        <div class="carrito-item-acciones">
                            <div class="cantidad-control">
                                <button class="btn-cantidad" onclick="actualizarCantidad(${item.id}, ${item.cantidad - 1})">-</button>
                                <span class="cantidad-valor">${item.cantidad}</span>
                                <button class="btn-cantidad" onclick="actualizarCantidad(${item.id}, ${item.cantidad + 1})">+</button>
                            </div>
                            <button class="btn-eliminar" onclick="eliminarDelCarrito(${item.id})">Eliminar</button>
                        </div>
                    </div>
                `;
                carritoItems.innerHTML += itemHtml;
                carritoTotalValor.textContent = `${moneda} $${(total * factorCambio).toLocaleString('es-CL')}`;
            });

            // Actualizar el total
            carritoTotalValor.textContent = `${moneda} $${(total * factorCambio).toLocaleString('es-CL')}`;

            // Mostrar barra de envío gratis
            const envioGratisBarra = document.getElementById('envio-gratis-barra');
            const umbralEnvioGratisNormal = 50000;
            const umbralEnvioGratisNuevo = 40000;

            // Leer si es usuario nuevo
            const esUsuarioNuevo = localStorage.getItem('primeraCompraHecha') !== 'true';

            // Determinar umbral a usar
            let umbralActual = esUsuarioNuevo ? umbralEnvioGratisNuevo : umbralEnvioGratisNormal;
            let faltante = umbralActual - total;
            let faltanteConvertido = faltante * factorCambio;
            let umbralConvertido = umbralActual * factorCambio;

            if (total >= umbralActual) {
                if (esUsuarioNuevo) {
                    envioGratisBarra.textContent = '🎁 ¡Como cliente nuevo tienes envío gratis por superar el mínimo de tu primera compra! 🎁';
                } else {
                    envioGratisBarra.textContent = '🎉 ¡Tienes envío gratis en tu compra! 🎉';
                }
            } else {
                if (esUsuarioNuevo) {
                    envioGratisBarra.textContent = `Como cliente nuevo, te faltan ${moneda} $${faltanteConvertido.toLocaleString('es-CL')} para obtener envío gratis. 🎁`;
                } else {
                    envioGratisBarra.textContent = `Te faltan ${moneda} $${faltanteConvertido.toLocaleString('es-CL')} para obtener envío gratis. 🛍️`;
                }
            }

            // Mostrar tiempo estimado de entrega según país
            const paisEnvioSelect = document.getElementById('pais-envio');
            const tiempoEntregaDiv = document.getElementById('tiempo-entrega');

            function actualizarTiempoEntrega() {
                const pais = paisEnvioSelect.value;
                let tiempo = '';
                if (pais === 'Chile') {
                    tiempo = 'Entrega estimada: 3 a 5 días hábiles.';
                } else if (pais === 'Argentina') {
                    tiempo = 'Entrega estimada: 5 a 10 días hábiles.';
                }
                tiempoEntregaDiv.textContent = tiempo;
            }

            // Ejecutar al cargar
            actualizarTiempoEntrega();

            // Ejecutar cuando el usuario cambie el país
            paisEnvioSelect.addEventListener('change', actualizarTiempoEntrega);
        
            // Actualizar carrito si cambia la moneda
            monedaSelect.addEventListener('change', renderizarCarrito);

        }

        // Cuando se carga la página
        document.addEventListener('DOMContentLoaded', () => {
            carrito = JSON.parse(localStorage.getItem('carritoDuki')) || [];
            renderizarCarrito();
            
            // Botón para finalizar compra
            const btnFinalizar = document.getElementById('btn-finalizar-compra');
            if (btnFinalizar) {
                btnFinalizar.addEventListener('click', finalizarCompra);
            }

            // Inicializar método de pago por defecto
            seleccionarMetodo('Transferencia');
        });
    </script>
</body>
</html>

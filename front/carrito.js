// Carrito de compras
let carrito = JSON.parse(localStorage.getItem('carritoDuki')) || [];

// Agregar producto al carrito
function agregarAlCarrito(id, nombre, precio, imagen, cantidad = 1) {
    const idx = carrito.findIndex(item => item.id === id);
    if (idx > -1) {
        carrito[idx].cantidad += cantidad;
    } else {
        carrito.push({id, nombre, precio, imagen, cantidad});
    }
    guardarCarrito();
    mostrarNotificacion(`${nombre} agregado al carrito`);
    actualizarContadorCarrito();
}

// Eliminar producto del carrito
function eliminarDelCarrito(id) {
    carrito = carrito.filter(item => item.id !== id);
    guardarCarrito();
    actualizarContadorCarrito();
    if (typeof renderizarCarrito === 'function') {
        renderizarCarrito();
    }
}

// Actualizar cantidad de un producto
function actualizarCantidad(id, nuevaCantidad) {
    const idx = carrito.findIndex(item => item.id === id);
    if (idx > -1) {
        if (nuevaCantidad > 0) {
            carrito[idx].cantidad = nuevaCantidad;
        } else {
            eliminarDelCarrito(id);
        }
        guardarCarrito();
        if (typeof renderizarCarrito === 'function') {
            renderizarCarrito();
        }
    }
    actualizarContadorCarrito();
}

// Guardar carrito en localStorage
function guardarCarrito() {
    localStorage.setItem('carritoDuki', JSON.stringify(carrito));
}

// Vaciar el carrito
function vaciarCarrito() {
    carrito = [];
    guardarCarrito();
    actualizarContadorCarrito();
    if (typeof renderizarCarrito === 'function') {
        renderizarCarrito();
    }
}

// Calcular el total del carrito
function calcularTotal() {
    return carrito.reduce((total, item) => total + (item.precio * item.cantidad), 0);
}

// Mostrar notificación
function mostrarNotificacion(mensaje) {
    const notificacion = document.createElement('div');
    notificacion.className = 'notificacion';
    notificacion.textContent = mensaje;
    document.body.appendChild(notificacion);
    
    setTimeout(() => {
        notificacion.classList.add('mostrar');
    }, 10);
    
    setTimeout(() => {
        notificacion.classList.remove('mostrar');
        setTimeout(() => {
            document.body.removeChild(notificacion);
        }, 300);
    }, 2000);
}

// Actualizar contador del carrito
function actualizarContadorCarrito() {
    const contador = document.getElementById('carrito-contador');
    if (contador) {
        const cantidad = carrito.reduce((total, item) => total + item.cantidad, 0);
        contador.textContent = cantidad;
        contador.style.display = cantidad > 0 ? 'flex' : 'none';
    }
}

// Inicializar contador al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    actualizarContadorCarrito();
});

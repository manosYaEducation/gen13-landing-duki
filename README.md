# 🎵 Duki - Tienda Oficial y Línea de Tiempo

[![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?logo=php)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white)](https://www.mysql.com/)
[![HTML5](https://img.shields.io/badge/HTML5-E34F26?logo=html5&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/HTML)
[![CSS3](https://img.shields.io/badge/CSS3-1572B6?logo=css3&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/CSS)
[![JavaScript](https://img.shields.io/badge/JavaScript-ES6-F7DF1E?logo=javascript&logoColor=black)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)

Bienvenido a la tienda y línea de tiempo de Duki, un proyecto que combina la pasión por la música con una experiencia de compra integrada. Este sitio web ofrece una experiencia inmersiva en la carrera del artista, junto con una tienda en línea completa.

## ✨ Características Principales

### 🎨 Línea de Tiempo Interactiva
- Recorre la carrera de Duki a través de los años
- Visualiza sus mayores éxitos y momentos destacados
- Diseño atractivo y responsivo

### 🛍️ Tienda en Línea
- Catálogo completo de productos oficiales
- Carrito de compras con persistencia en localStorage
- Proceso de pago seguro
- Integración con WhatsApp para finalización de pedidos
- Panel de administración para gestión de productos

### 👤 Panel de Usuario
- Registro e inicio de sesión de usuarios
- Historial de pedidos
- Seguimiento de estado de pedidos

## 🗃️ Estructura de la Base de Datos

El proyecto utiliza una base de datos MySQL con las siguientes tablas principales:

### 📦 Tablas Principales
- `users`: Almacena la información de los usuarios registrados
- `products`: Catálogo de productos disponibles
- `orders`: Registro de pedidos realizados
- `order_details`: Detalle de los productos en cada pedido
- `cart` y `cart_items`: Gestión del carrito de compras
- `stock_history`: Historial de cambios en el inventario

## 🚀 Tecnologías Utilizadas

### Frontend
- HTML5, CSS3, JavaScript (ES6+)
- Diseño responsivo con CSS Grid y Flexbox
- Font Awesome para iconos
- Google Fonts para tipografía

### Backend
- PHP 7.4+
- MySQL 8.0
- Sesiones PHP para autenticación

### Características Adicionales
- Validación de formularios en cliente y servidor
- Manejo de sesiones seguras
- Sistema de notificaciones
- Integración con WhatsApp para pedidos

## 🛠️ Instalación

1. Clona el repositorio:
   ```bash
   git clone [URL_DEL_REPOSITORIO]
   ```

2. Importa la base de datos:
   - Crea una base de datos MySQL llamada `duki_store`
   - Importa el archivo `duki_store.sql` incluido en el proyecto

3. Configura las credenciales:
   - Actualiza el archivo `db.php` con tus credenciales de base de datos

4. Configura un servidor web (por ejemplo, XAMPP, WAMP, etc.)
   - Coloca el proyecto en la carpeta `htdocs` (XAMPP) o `www` (WAMP)
   - Asegúrate de que el módulo `mod_rewrite` esté habilitado

5. Accede al proyecto en tu navegador:
   ```
   http://localhost/landing_duki
   ```

   Para acceder al panel de administración:
   ```
   http://localhost/landing_duki/front/dashboard.php
   ```

## 📦 Requisitos del Sistema

- PHP 7.4 o superior
- MySQL 8.0 o superior
- Servidor web (Apache/Nginx)
- Navegador web moderno (Chrome, Firefox, Safari, Edge)
- Extensión PHP PDO MySQL habilitada

## 🔐 Credenciales por Defecto

### Panel de Administración
- **Usuario:** admin@duki.com
- **Contraseña:** admin123
<div align="center">
  Hecho con ❤️ para los fans de Duki | © 2025 Todos los derechos reservados
</div>

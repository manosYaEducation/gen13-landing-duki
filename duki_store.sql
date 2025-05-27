-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-05-2025 a las 20:41:13
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `duki_store`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(30) DEFAULT 'pendiente',
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `created_at`, `status`, `fecha`) VALUES
(2, NULL, NULL, '2025-05-27 18:33:02', 'pendiente', '2025-05-27 20:33:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image`, `created_at`) VALUES
(6, 'Polera She Don\'t Give a Fo', 'Polera negra con diseño inspirado en el icónico tema \"She Don\'t Give a Fo\" de Duki (2017).', 25000.00, 15, '/landing_duki/assets/tienda/polera_shedontgiveafo.jpg', '2025-05-27 18:40:12'),
(7, 'Polera Goteo', 'Polera negra con diseño de gotas metálicas inspirada en el hit \"Goteo\" de Duki (2019).', 25000.00, 12, '/landing_duki/assets/tienda/polera_goteo.jpg', '2025-05-27 18:40:12'),
(8, 'Polera Rockstar', 'Polera negra con diseño rockero inspirado en el tema \"Rockstar\" de Duki (2018).', 25000.00, 18, '/landing_duki/assets/tienda/polera_rockstar.jpg', '2025-05-27 18:40:12'),
(9, 'Polera LeBron', 'Polera negra con diseño deportivo inspirado en \"LeBron\" de Duki (2022).', 25000.00, 20, '/landing_duki/assets/tienda/polera_lebron.jpg', '2025-05-27 18:40:12'),
(10, 'Polera Givenchy', 'Polera premium con estilo de alta moda inspirada en \"Givenchy\" de Duki (2022).', 28000.00, 10, '/landing_duki/assets/tienda/polera_givenchy.jpg', '2025-05-27 18:40:12'),
(11, 'Polera Super Sangre Joven', 'Polera oficial del álbum debut \"Super Sangre Joven\" (2019). Diseño con el logo del álbum en la parte frontal.', 27000.00, 15, '/landing_duki/assets/tienda/polera_ssj.jpg', '2025-05-27 18:40:12'),
(12, 'Polera Desde el Fin del Mundo', 'Polera negra con el arte del álbum \"Desde el Fin del Mundo\" (2021). Edición limitada.', 27000.00, 12, '/landing_duki/assets/tienda/polera_dfdm.jpg', '2025-05-27 18:40:12'),
(13, 'Polera Antes de Ameri', 'Polera con diseño inspirado en el álbum \"Antes de Ameri\" (2023). Estilo urbano y minimalista.', 27000.00, 14, '/landing_duki/assets/tienda/polera_ada.jpg', '2025-05-27 18:40:12'),
(14, 'Polera Ameri Tour', 'Polera oficial del \"Ameri Tour\" (2024). Diseño exclusivo con fechas de la gira en la espalda.', 30000.00, 25, '/landing_duki/assets/tienda/polera_ameritour.jpg', '2025-05-27 18:40:12'),
(15, 'Polera El Quinto Escalón', 'Polera conmemorativa de la época de El Quinto Escalón (2016). Para los verdaderos fans del freestyle.', 26000.00, 8, '/landing_duki/assets/tienda/polera_quintoescalon.jpg', '2025-05-27 18:40:12'),
(16, 'Polera Freestyle Duki', 'Polera con diseño de micrófono y frases icónicas de las batallas de Duki. Estilo urbano y callejero.', 26000.00, 10, '/landing_duki/assets/tienda/polera_freestyle.jpg', '2025-05-27 18:40:12'),
(17, 'Polera Milan Duki', 'Polera inspirada en el icónico camperón del Milan que Duki usaba en sus primeras batallas.', 28000.00, 12, '/landing_duki/assets/tienda/polera_milan.jpg', '2025-05-27 18:40:12'),
(18, 'Polera Logo Ameri', 'Polera minimalista con el logo Ameri en el centro. Disponible en negro con detalles dorados.', 24000.00, 30, '/landing_duki/assets/tienda/polera_logoameri.jpg', '2025-05-27 18:40:12'),
(19, 'Polera Trap Argentino', 'Polera con diseño que combina elementos del trap y la bandera argentina. Tributo a los pioneros del género.', 26000.00, 15, '/landing_duki/assets/tienda/polera_traparg.jpg', '2025-05-27 18:40:12'),
(20, 'Polera Lost Tape', 'Polera exclusiva inspirada en \"Lost Tape\" (2023) con diseño vintage de cassette.', 27000.00, 12, '/landing_duki/assets/tienda/polera_losttape.jpg', '2025-05-27 18:40:12'),
(21, 'Polera Mode Duki', 'Polera con ilustración de Duki en estilo anime. Edición de coleccionista.', 28000.00, 8, '/landing_duki/assets/tienda/polera_modeduki.jpg', '2025-05-27 18:40:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock_history`
--

CREATE TABLE `stock_history` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `change` int(11) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `changed_by` int(11) DEFAULT NULL,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','cliente') DEFAULT 'cliente',
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `reset_token`, `reset_token_expiry`, `created_at`) VALUES
(1, 'dus6n66', 'dusanocaranzadev@gmail.com', '$2y$10$E1IfeAtgt5DIoP48ukR3hOKQ2KB8nlLOUHFKol/46ULUpeBn3z0iy', 'cliente', NULL, NULL, '2025-05-16 16:39:22'),
(2, 'admin', 'admin@duki.com', '$2y$10$xOPDk7mbhQL6Xn.mJR0bQeuW881EoK4Hap2TnVflkKD8EJ91GUxgS', 'admin', NULL, NULL, '2025-05-16 20:31:59'),
(3, 'loyalty', 'cebollinlibre@gmail.com', '$2y$10$xOPDk7mbhQL6Xn.mJR0bQeuW881EoK4Hap2TnVflkKD8EJ91GUxgS', 'cliente', NULL, NULL, '2025-05-22 22:31:13');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_ibfk_1` (`user_id`);

--
-- Indices de la tabla `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `stock_history`
--
ALTER TABLE `stock_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `changed_by` (`changed_by`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `stock_history`
--
ALTER TABLE `stock_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Filtros para la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Filtros para la tabla `stock_history`
--
ALTER TABLE `stock_history`
  ADD CONSTRAINT `stock_history_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `stock_history_ibfk_2` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

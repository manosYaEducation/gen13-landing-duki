-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-05-2025 a las 23:57:42
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
(2, NULL, NULL, '2025-05-27 18:33:02', 'pendiente', '2025-05-27 20:33:02'),
(3, NULL, NULL, '2025-05-27 20:19:40', 'pendiente', '2025-05-27 22:19:40'),
(4, NULL, NULL, '2025-05-27 20:24:10', 'pendiente', '2025-05-27 22:24:10'),
(5, NULL, NULL, '2025-05-27 20:24:32', 'pendiente', '2025-05-27 22:24:32'),
(6, 2, NULL, '2025-05-27 20:36:07', 'pendiente', '2025-05-27 22:36:07'),
(7, 2, NULL, '2025-05-27 20:38:27', 'pendiente', '2025-05-27 22:38:27'),
(8, 2, NULL, '2025-05-27 20:41:19', 'pendiente', '2025-05-27 22:41:19'),
(9, 2, NULL, '2025-05-27 20:42:09', 'pendiente', '2025-05-27 22:42:09'),
(10, 2, NULL, '2025-05-27 20:44:02', 'pendiente', '2025-05-27 22:44:02'),
(11, 2, NULL, '2025-05-27 20:44:06', 'pendiente', '2025-05-27 22:44:06'),
(12, 2, NULL, '2025-05-27 20:44:16', 'pendiente', '2025-05-27 22:44:16'),
(13, 2, NULL, '2025-05-27 20:44:23', 'pendiente', '2025-05-27 22:44:23'),
(14, 2, NULL, '2025-05-27 20:45:36', 'pendiente', '2025-05-27 22:45:36'),
(16, 2, NULL, '2025-05-27 20:45:56', 'pendiente', '2025-05-27 22:45:56'),
(17, 2, NULL, '2025-05-27 20:49:42', 'pendiente', '2025-05-27 22:49:42'),
(18, 2, NULL, '2025-05-27 20:49:45', 'pendiente', '2025-05-27 22:49:45'),
(19, 2, NULL, '2025-05-27 20:52:46', 'pendiente', '2025-05-27 22:52:46'),
(20, 2, NULL, '2025-05-27 20:52:49', 'pendiente', '2025-05-27 22:52:49'),
(21, 2, NULL, '2025-05-27 20:52:54', 'pendiente', '2025-05-27 22:52:54'),
(22, 2, NULL, '2025-05-27 20:56:17', 'pendiente', '2025-05-27 22:56:17'),
(23, 2, NULL, '2025-05-27 20:56:27', 'pendiente', '2025-05-27 22:56:27'),
(24, 2, NULL, '2025-05-27 20:56:32', 'pendiente', '2025-05-27 22:56:32'),
(25, 2, NULL, '2025-05-27 21:04:30', 'pendiente', '2025-05-27 23:04:30'),
(26, 2, NULL, '2025-05-27 21:07:07', 'pendiente', '2025-05-27 23:07:07'),
(27, 2, NULL, '2025-05-27 21:08:21', 'pendiente', '2025-05-27 23:08:21'),
(28, 2, NULL, '2025-05-27 21:26:43', 'pendiente', '2025-05-27 23:26:43'),
(30, 2, NULL, '2025-05-27 21:27:44', 'pendiente', '2025-05-27 23:27:44'),
(31, 2, NULL, '2025-05-27 21:28:51', 'pendiente', '2025-05-27 23:28:51'),
(32, 2, NULL, '2025-05-27 21:29:46', 'pendiente', '2025-05-27 23:29:46'),
(33, 2, NULL, '2025-05-27 21:32:42', 'pendiente', '2025-05-27 23:32:42'),
(34, 2, NULL, '2025-05-27 21:34:00', 'rejected', '2025-05-27 23:34:00');

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

--
-- Volcado de datos para la tabla `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(2, 3, 19, 1),
(3, 4, 19, 1),
(4, 4, 20, 1),
(5, 5, 19, 1),
(6, 5, 20, 1),
(7, 6, 19, 1),
(8, 6, 20, 1),
(9, 6, 21, 1),
(10, 6, 11, 1),
(11, 7, 19, 1),
(12, 8, 21, 1),
(13, 9, 21, 1),
(14, 10, 21, 1),
(15, 11, 21, 1),
(16, 12, 21, 1),
(17, 12, 19, 1),
(18, 13, 21, 1),
(19, 13, 19, 1),
(20, 14, 21, 1),
(21, 14, 19, 1),
(22, 16, 8, 1),
(23, 17, 8, 1),
(24, 18, 8, 1),
(25, 19, 8, 1),
(26, 20, 8, 1),
(27, 21, 8, 1),
(28, 22, 8, 1),
(29, 23, 20, 1),
(30, 24, 20, 1),
(31, 25, 9, 1),
(32, 26, 9, 1),
(33, 27, 9, 1),
(34, 28, 9, 1),
(36, 30, 9, 1),
(37, 31, 9, 1),
(38, 32, 15, 1),
(39, 33, 15, 1),
(40, 34, 14, 1);

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
(8, 'Polera Alas', 'Polera blanca con diseño de alas de duki', 25000.00, 11, '/landing_duki/assets/tienda/prod_68360c81358a4_610 (1).jpg', '2025-05-27 18:40:12'),
(9, 'Polera A.D.A Tour', 'Polera negra con diseño de A.D.A Tour 2024', 25000.00, 13, '/landing_duki/assets/tienda/prod_68360c23c37d1_640.webp', '2025-05-27 18:40:12'),
(10, 'Polera Givenchy', 'Polera premium con estilo de alta moda inspirada en \"Givenchy\" de Duki (2022).', 28000.00, 10, '/landing_duki/assets/tienda/prod_68360bd7e9e1a_632 (1).jpg', '2025-05-27 18:40:12'),
(11, 'Polera Super Sangre Joven', 'Polera oficial del álbum debut \"Super Sangre Joven\" (2019). Diseño con el logo del álbum en la parte frontal.', 27000.00, 14, '/landing_duki/assets/tienda/prod_68360bd02fd3b_71JOPOaBiLL._AC_UY1000_.jpg', '2025-05-27 18:40:12'),
(12, 'Polera Desde el Fin del Mundo', 'Polera negra con el arte del álbum \"Desde el Fin del Mundo\" (2021). Edición limitada.', 27000.00, 12, '/landing_duki/assets/tienda/prod_68360b3325e67_D_NQ_NP_629596-MLM78395194150_082024-O-playera-de-duki-desde-el-fin-del-mundo-envio-rapido.webp', '2025-05-27 18:40:12'),
(13, 'Polera Antes de Ameri', 'Polera con diseño inspirado en el álbum \"Antes de Ameri\" (2023). Estilo urbano y minimalista.', 27000.00, 14, '/landing_duki/assets/tienda/prod_68360b4e1916e_T-SHIRTFRONT_1080x.png.webp', '2025-05-27 18:40:12'),
(14, 'Polera Ameri Tour', 'Polera oficial del \"Ameri Tour\" (2024). Diseño exclusivo con fechas de la gira en la espalda.', 30000.00, 24, '/landing_duki/assets/tienda/prod_68360aba859ab_duki-merch-oficial-ameri-photo.webp', '2025-05-27 18:40:12'),
(15, 'Polera El Quinto Escalón', 'Polera conmemorativa de la época de El Quinto Escalón (2016). Para los verdaderos fans del freestyle.', 26000.00, 6, '/landing_duki/assets/tienda/prod_68360ab1136fa_D_858891-MLA51538864485_092022-O.jpg', '2025-05-27 18:40:12'),
(17, 'Polera Milan Duki', 'Polera inspirada en el icónico camperón del Milan que Duki usaba en sus primeras batallas.', 28000.00, 12, '/landing_duki/assets/tienda/prod_68360a6ff0bb9_k-hax8hh_400x400.jpg', '2025-05-27 18:40:12'),
(18, 'Polera Logo Ameri', 'Polera minimalista con el logo Ameri en el centro. Disponible en negro con detalles dorados.', 24000.00, 30, '/landing_duki/assets/tienda/prod_68360ad62c62f_Polera-Duki-Ameri-Frente-Rojo-Fuerte.png', '2025-05-27 18:40:12'),
(19, 'Polera Trap Argentino', 'Polera con diseño que combina elementos del trap y la bandera argentina. Tributo a los pioneros del género.', 26000.00, 7, '/landing_duki/assets/tienda/prod_683609aba9211_Camiseta_de_Duki_x_Argentina.webp', '2025-05-27 18:40:12'),
(20, 'Poster Lost Tape', 'Poster de  \"Lost Tape\" (2023) con diseño vintage de cassette.', 6000.00, 15, '/landing_duki/assets/tienda/prod_6836092e4a4e4_ab67616d0000b2730324a77a6966bb3e4c8b6ac0.jpg', '2025-05-27 18:40:12'),
(21, 'Polera Mode Duki', 'Polera con ilustración de Duki en estilo retro. Edición de coleccionista.', 28000.00, 0, '/landing_duki/assets/tienda/prod_6836099001b4a_Saa537f38efe2452dbd7daf4d46bdc86dd.avif', '2025-05-27 18:40:12');

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

--
-- Volcado de datos para la tabla `stock_history`
--

INSERT INTO `stock_history` (`id`, `product_id`, `change`, `reason`, `changed_by`, `changed_at`) VALUES
(6, 20, 8, 'Actualización manual desde admin', 2, '2025-05-27 18:49:18');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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

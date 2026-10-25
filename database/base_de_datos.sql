-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2026 at 04:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zonajoystick`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `sub_categoria` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre`, `descripcion`, `sub_categoria`) VALUES
(1, 'Videojuegos', 'Videojuegos para distintas plataformas', NULL),
(2, 'Figuras', 'Figuras y coleccionables', NULL),
(3, 'Manga', 'Libros y manga', NULL),
(4, 'TCG', 'Juegos de cartas coleccionables', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `descuento`
--

CREATE TABLE `descuento` (
  `id_descuento` int(10) UNSIGNED NOT NULL,
  `porcentaje_descuento` decimal(5,2) NOT NULL,
  `validez` date DEFAULT NULL,
  `usos` int(10) UNSIGNED NOT NULL DEFAULT 0
) ;

-- --------------------------------------------------------

--
-- Table structure for table `descuento_producto`
--

CREATE TABLE `descuento_producto` (
  `id_producto` int(10) UNSIGNED NOT NULL,
  `id_descuento` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_producto`
--

CREATE TABLE `detalle_producto` (
  `id_pedido` int(10) UNSIGNED NOT NULL,
  `id_producto` int(10) UNSIGNED NOT NULL,
  `cantidad` int(10) UNSIGNED NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ;

--
-- Dumping data for table `detalle_producto`
--

INSERT INTO `detalle_producto` (`id_pedido`, `id_producto`, `cantidad`, `precio`) VALUES
(1, 4, 1, 1890.00),
(2, 4, 1, 1890.00),
(3, 4, 1, 1890.00),
(4, 4, 1, 1890.00),
(5, 2, 7, 2490.00),
(6, 2, 1, 2490.00),
(6, 4, 3, 1890.00),
(7, 1, 1, 3500.00),
(7, 3, 1, 1290.00),
(7, 4, 1, 1890.00),
(8, 2, 1, 2490.00),
(8, 3, 1, 1290.00),
(8, 4, 1, 1890.00),
(9, 2, 1, 2490.00),
(9, 4, 2, 1890.00),
(10, 2, 1, 2490.00),
(11, 1, 1, 3500.00),
(11, 2, 2, 2490.00),
(11, 3, 2, 1290.00),
(11, 4, 2, 1890.00),
(12, 1, 1, 3500.00),
(12, 2, 1, 2490.00),
(12, 3, 1, 1290.00),
(12, 4, 1, 1890.00),
(13, 2, 1, 2490.00),
(13, 4, 1, 1890.00);

-- --------------------------------------------------------

--
-- Table structure for table `direccion`
--

CREATE TABLE `direccion` (
  `id_direccion` int(10) UNSIGNED NOT NULL,
  `calle` varchar(150) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mensaje`
--

CREATE TABLE `mensaje` (
  `id_mensaje` int(10) UNSIGNED NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `asunto` varchar(200) NOT NULL,
  `contenido` text NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `metodo_pago`
--

CREATE TABLE `metodo_pago` (
  `id_metodo_pago` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `id_usuario` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pago`
--

CREATE TABLE `pago` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_pedido` int(10) UNSIGNED NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `ultimos4` char(4) NOT NULL,
  `resultado` enum('aprobado','rechazado') NOT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(10) UNSIGNED NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(40) NOT NULL DEFAULT 'pendiente',
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `envio_nombre` varchar(60) DEFAULT NULL,
  `envio_direccion` varchar(100) DEFAULT NULL,
  `envio_ciudad` varchar(50) DEFAULT NULL,
  `envio_departamento` varchar(30) DEFAULT NULL,
  `envio_telefono` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `fecha`, `estado`, `id_usuario`, `total`, `envio_nombre`, `envio_direccion`, `envio_ciudad`, `envio_departamento`, `envio_telefono`) VALUES
(1, '2026-10-19 22:14:57', 'Pendiente', 1, 0.00, NULL, NULL, NULL, NULL, NULL),
(2, '2026-10-19 22:15:35', 'Pendiente', 1, 0.00, NULL, NULL, NULL, NULL, NULL),
(3, '2026-10-19 22:17:30', 'Pendiente', 1, 0.00, NULL, NULL, NULL, NULL, NULL),
(4, '2026-10-19 22:18:28', 'Pendiente', 1, 0.00, NULL, NULL, NULL, NULL, NULL),
(5, '2026-10-19 22:21:57', 'Pendiente', 1, 0.00, NULL, NULL, NULL, NULL, NULL),
(6, '2026-10-21 23:54:00', 'Pendiente', 2, 0.00, NULL, NULL, NULL, NULL, NULL),
(7, '2026-10-22 00:08:06', 'Pendiente', 2, 0.00, NULL, NULL, NULL, NULL, NULL),
(8, '2026-10-23 08:24:53', 'Pendiente', 2, 5670.00, NULL, NULL, NULL, NULL, NULL),
(9, '2026-10-23 13:25:29', 'Pendiente', 2, 6270.00, NULL, NULL, NULL, NULL, NULL),
(10, '2026-10-23 16:16:58', 'Pendiente', 2, 2490.00, NULL, NULL, NULL, NULL, NULL),
(11, '2026-10-24 15:41:45', 'Pendiente', 2, 14840.00, NULL, NULL, NULL, NULL, NULL),
(12, '2026-10-24 17:09:15', 'Pendiente', 2, 9170.00, NULL, NULL, NULL, NULL, NULL),
(13, '2026-10-24 18:45:29', 'Pendiente', 8, 4380.00, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `imagen` varchar(500) DEFAULT NULL,
  `id_categoria` int(10) UNSIGNED NOT NULL
) ;

--
-- Dumping data for table `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre`, `precio`, `descripcion`, `stock`, `imagen`, `id_categoria`) VALUES
(1, 'Grand Theft Auto VI', 3500.00, 'Videojuego Grand Theft Auto VI de Rockstar Games', 10, '/Proyecto-Anual/public/img/GTAVI.png', 1),
(2, 'Astro Bot PS5', 2490.00, 'Videojuego Astro Bot para PlayStation 5', 12, '/Proyecto-Anual/public/img/AstroBot.jpg', 1),
(3, 'Funko Pop Astro Bot', 1290.00, 'Figura coleccionable Funko Pop de Astro Bot', 8, '/Proyecto-Anual/public/img/AstroBotFunko.png', 2),
(4, 'Capa Akatsuki', 1890.00, 'Capa inspirada en Akatsuki de Naruto para cosplay', 6, '/Proyecto-Anual/public/img/Capa-Akatsuki.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(10) UNSIGNED NOT NULL,
  `nombre_rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre_rol`) VALUES
(1, 'administrador'),
(3, 'cliente'),
(2, 'empleado');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `id_rol` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellido`, `email`, `contrasena`, `id_rol`) VALUES
(1, 'Usuario', 'Prueba', 'prueba@zonajoystick.test', 'CUENTA_DE_PRUEBA_SIN_LOGIN', 3),
(2, 'Franco', 'Pirez', 'francopirez4@gmail.com', '$2y$10$YrAr4OJx0W41xZtjzllR/ukF0G5Y3b//5SA8zbItfHqjgYXUs1DP6', 1),
(3, 'Franco', 'Pirez', 'francogamer578@gmail.com', '$2y$10$Gvj3zhCCPeOWOzDYeVyOle5lnyoOiz3uLC1ZCRusiqq4PEYUm/xPu', 3),
(5, '<script>alert(XSS)</script>', 'Pirez', 'prueba@example.com', '$2y$10$e.vtcUIx2LZ7RTRHrEsKuOaJ4PcP7gKsKI5sC3jthwYovwjhS.lTu', 3),
(6, 'Facundo', 'Martino', 'facumar@gmai.com', '$2y$10$HnfqUr0hLp9JHsLXsLFxG.D7KOYIcMV1g/dkK1VEkqIvvNPfQXMoy', 3),
(7, 'admin', 'prueba', 'admin@zonajoystick.com', '$2y$10$E4hXxtSE8KHfuOEjoQB35uD14ZhT7lFtwGAmx32SY4GjpqHLLf66G', 1),
(8, 'cliente', 'prueba', 'cliente@zonajoystick.com', '$2y$10$3SSH0swOxw5.GTlenC6Fb.5U02FCm1W5oCeXit/hoZmAfngD5cyiy', 3),
(9, 'Facundo', 'CHOpapo', 'piaabelarde@hotmail.com', '$2y$10$ndhTEZ0mDiOqbYxRsFuHNOYarcEyRcr/4XOZHvJnsoZUE6cCnTup.', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indexes for table `descuento`
--
ALTER TABLE `descuento`
  ADD PRIMARY KEY (`id_descuento`);

--
-- Indexes for table `descuento_producto`
--
ALTER TABLE `descuento_producto`
  ADD PRIMARY KEY (`id_producto`,`id_descuento`),
  ADD KEY `fk_descuento_producto_descuento` (`id_descuento`);

--
-- Indexes for table `detalle_producto`
--
ALTER TABLE `detalle_producto`
  ADD PRIMARY KEY (`id_pedido`,`id_producto`),
  ADD KEY `fk_detalle_producto` (`id_producto`);

--
-- Indexes for table `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`id_direccion`),
  ADD KEY `fk_direccion_usuario` (`id_usuario`);

--
-- Indexes for table `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`id_mensaje`),
  ADD KEY `fk_mensaje_usuario` (`id_usuario`);

--
-- Indexes for table `metodo_pago`
--
ALTER TABLE `metodo_pago`
  ADD PRIMARY KEY (`id_metodo_pago`),
  ADD KEY `fk_metodo_pago_usuario` (`id_usuario`);

--
-- Indexes for table `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pago_pedido` (`id_pedido`);

--
-- Indexes for table `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `fk_pedido_usuario` (`id_usuario`);

--
-- Indexes for table `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_producto_categoria` (`id_categoria`);

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `nombre_rol` (`nombre_rol`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_usuario_rol` (`id_rol`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `descuento`
--
ALTER TABLE `descuento`
  MODIFY `id_descuento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `direccion`
--
ALTER TABLE `direccion`
  MODIFY `id_direccion` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `id_mensaje` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `metodo_pago`
--
ALTER TABLE `metodo_pago`
  MODIFY `id_metodo_pago` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pago`
--
ALTER TABLE `pago`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `descuento_producto`
--
ALTER TABLE `descuento_producto`
  ADD CONSTRAINT `fk_descuento_producto_descuento` FOREIGN KEY (`id_descuento`) REFERENCES `descuento` (`id_descuento`),
  ADD CONSTRAINT `fk_descuento_producto_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Constraints for table `detalle_producto`
--
ALTER TABLE `detalle_producto`
  ADD CONSTRAINT `fk_detalle_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`),
  ADD CONSTRAINT `fk_detalle_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Constraints for table `direccion`
--
ALTER TABLE `direccion`
  ADD CONSTRAINT `fk_direccion_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `mensaje`
--
ALTER TABLE `mensaje`
  ADD CONSTRAINT `fk_mensaje_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `metodo_pago`
--
ALTER TABLE `metodo_pago`
  ADD CONSTRAINT `fk_metodo_pago_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `fk_pago_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`);

--
-- Constraints for table `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_pedido_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`);

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

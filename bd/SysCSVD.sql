-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 04-06-2023 a las 03:04:50
-- Versión del servidor: 5.7.36
-- Versión de PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `facturacionsimple2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

DROP TABLE IF EXISTS `areas`;
CREATE TABLE IF NOT EXISTS `areas` (
  `id_area` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_area` varchar(150) COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id_area`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`id_area`, `nombre_area`) VALUES
(1, 'administrador'),
(3, 'atención al publico'),
(4, 'cajas'),
(5, 'gerencia'),
(6, 'compras');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`) VALUES
(3, 'libreria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

DROP TABLE IF EXISTS `detalle_ventas`;
CREATE TABLE IF NOT EXISTS `detalle_ventas` (
  `cantidad` int(11) NOT NULL,
  `precio_unitario` float NOT NULL,
  `subtotal` float NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  PRIMARY KEY (`id_producto`,`id_venta`),
  KEY `id_venta` (`id_venta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos_menu`
--

DROP TABLE IF EXISTS `grupos_menu`;
CREATE TABLE IF NOT EXISTS `grupos_menu` (
  `id_grupo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_grupo` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `icono` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id_grupo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `grupos_menu`
--

INSERT INTO `grupos_menu` (`id_grupo`, `nombre_grupo`, `icono`) VALUES
(1, 'administrar', 'fas fa-cog'),
(3, 'seguridad', 'fas fa-lock'),
(4, 'productos', 'fas fa-desktop'),
(6, 'ventas', 'fas fa-cart-plus');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items_interno`
--

DROP TABLE IF EXISTS `items_interno`;
CREATE TABLE IF NOT EXISTS `items_interno` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_item` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `url` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `id_grupo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_item`),
  KEY `id_grupo` (`id_grupo`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `items_interno`
--

INSERT INTO `items_interno` (`id_item`, `nombre_item`, `url`, `id_grupo`) VALUES
(1, 'grupos del menu', 'grupos_menu.php', 1),
(2, 'items del menu', 'items.php', 1),
(5, 'areas', 'areas.php', 1),
(7, 'usuarios', 'usuarios.php', 1),
(8, 'clave', 'clave.php', 3),
(9, 'productos', 'productos.php', 4),
(10, 'categorias', 'categorias.php	', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items_x_areas`
--

DROP TABLE IF EXISTS `items_x_areas`;
CREATE TABLE IF NOT EXISTS `items_x_areas` (
  `id_area` int(11) DEFAULT NULL,
  `id_item` int(11) DEFAULT NULL,
  KEY `id_area` (`id_area`),
  KEY `id_item` (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items_x_usuario`
--

DROP TABLE IF EXISTS `items_x_usuario`;
CREATE TABLE IF NOT EXISTS `items_x_usuario` (
  `id_item` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  KEY `id_usuario` (`id_usuario`),
  KEY `id_item_2` (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `items_x_usuario`
--

INSERT INTO `items_x_usuario` (`id_item`, `id_usuario`) VALUES
(NULL, NULL),
(8, 5),
(5, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_barra` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `precio` float NOT NULL,
  `stock` int(11) NOT NULL,
  `foto` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `id_categoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `codigo_barra`, `nombre`, `descripcion`, `precio`, `stock`, `foto`, `id_categoria`) VALUES
(7, '44444', 'rrrr', '<p>rrrrrrrrrrrrrrrrrrr</p>\r\n', 8, 99, '1685755729.PNG', 3),
(9, 'codigobirome', 'birome1980okok', '<p>descripcion birome ok</p>\r\n', 100, 20, '1685847422.png', 3),
(12, '22222222222', 'lapiz3', '<p>ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss</p>\r\n', 10, 12, '1685847205.PNG', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `apellido` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `usuario` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `clave` varchar(30) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `telefono` varchar(60) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `correo` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `id_area` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `usuarios_ibfk_1` (`id_area`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `usuario`, `clave`, `telefono`, `correo`, `id_area`) VALUES
(1, 'admin', 'admin', 'admin', 'admin', '1', 'test@test.com', 1),
(5, 'test1', NULL, 'caja1', 'caja1', NULL, 'caja1@gmail.com', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

DROP TABLE IF EXISTS `ventas`;
CREATE TABLE IF NOT EXISTS `ventas` (
  `id_venta` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_de_venta` date NOT NULL,
  `importe_total` float NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_venta`),
  KEY `id_usuario2` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `id_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `id_venta` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`);

--
-- Filtros para la tabla `items_interno`
--
ALTER TABLE `items_interno`
  ADD CONSTRAINT `id_grupo` FOREIGN KEY (`id_grupo`) REFERENCES `grupos_menu` (`id_grupo`);

--
-- Filtros para la tabla `items_x_areas`
--
ALTER TABLE `items_x_areas`
  ADD CONSTRAINT `id_area` FOREIGN KEY (`id_area`) REFERENCES `areas` (`id_area`),
  ADD CONSTRAINT `id_item` FOREIGN KEY (`id_item`) REFERENCES `items_interno` (`id_item`);

--
-- Filtros para la tabla `items_x_usuario`
--
ALTER TABLE `items_x_usuario`
  ADD CONSTRAINT `id_item2` FOREIGN KEY (`id_item`) REFERENCES `items_interno` (`id_item`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `id_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_area`) REFERENCES `areas` (`id_area`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `id_usuario2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

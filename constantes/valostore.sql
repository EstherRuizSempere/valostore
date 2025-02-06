-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla valostore.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `idCategoriaPadre` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idCategoriaPadre` (`idCategoriaPadre`),
  CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`idCategoriaPadre`) REFERENCES `categorias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla valostore.categorias: ~14 rows (aproximadamente)
INSERT INTO `categorias` (`id`, `nombre`, `activo`, `idCategoriaPadre`) VALUES
	(1, 'Duelista', 1, NULL),
	(2, 'Centinela', 1, NULL),
	(3, 'Iniciador', 1, NULL),
	(4, 'Controlador', 1, NULL),
	(5, 'Alta movilidad', 1, 1),
	(6, 'Explosivos', 1, 1),
	(7, 'Auto-suficientes', 1, 1),
	(8, 'Exploradores', 1, 3),
	(9, 'Desestabilizadores', 1, 3),
	(10, 'Defensores zonales', 1, 2),
	(11, 'Soporte', 1, 2),
	(12, 'Bloqueadores visuales', 1, 4),
	(13, 'Tóxicos', 1, 4),
	(14, 'Cósmicos', 1, 4);

-- Volcando estructura para tabla valostore.linea_pedido
CREATE TABLE IF NOT EXISTS `linea_pedido` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idPedido` int NOT NULL,
  `idProducto` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` float(8,2) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idPedido` (`idPedido`),
  KEY `idProducto` (`idProducto`),
  CONSTRAINT `linea_pedido_ibfk_1` FOREIGN KEY (`idPedido`) REFERENCES `pedidos` (`id`),
  CONSTRAINT `linea_pedido_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla valostore.linea_pedido: ~2 rows (aproximadamente)
INSERT INTO `linea_pedido` (`id`, `idPedido`, `idProducto`, `nombre`, `descripcion`, `precio`, `imagen`) VALUES
	(1, 6, 5, 'astra', 'lorem ipsum is simply dummy text of the printing and typesetting industry. lorem ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. it has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. it was popularised in the 1960s with the release of letraset sheets containing lorem ipsum passages, and more recently with desktop publishing software like aldus pagemaker including versions of lorem ipsum.', 60.00, '/media/img/productos/67951e6c2d019.png'),
	(2, 6, 3, 'omen', 'lorem ipsum is simply dummy text of the printing and typesetting industry. lorem ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. it has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. it was popularised in the 1960s with the release of letraset sheets containing lorem ipsum passages, and more recently with desktop publishing software like aldus pagemaker including versions of lorem ipsum.', 45.00, '/media/img/productos/67951e2e8604d.png');

-- Volcando estructura para tabla valostore.pedidos
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` enum('recibido','pendiente','aprobado','enviado','cancelado','reembolsado','error') NOT NULL DEFAULT 'recibido',
  `idUsuario` int NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido2` varchar(50) NOT NULL,
  `apellido1` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `localidad` varchar(100) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `metodoPago` enum('paypal','transferencia','tarjeta') NOT NULL DEFAULT 'transferencia',
  PRIMARY KEY (`id`),
  KEY `idUsuario` (`idUsuario`),
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla valostore.pedidos: ~6 rows (aproximadamente)
INSERT INTO `pedidos` (`id`, `fecha`, `total`, `estado`, `idUsuario`, `nombre`, `apellido2`, `apellido1`, `email`, `direccion`, `localidad`, `provincia`, `telefono`, `metodoPago`) VALUES
	(1, '2025-02-02 10:59:25', 105.00, 'recibido', 2, 'Esther', 'Ruiz', 'Castillo', 'estherbeep@gmail.com', 'Calle Carmeli Serrano Garcia', '651303179', 'Alicante', '651303179', 'transferencia'),
	(2, '2025-02-02 11:00:50', 105.00, 'recibido', 2, 'Esther', 'Ruiz', 'Ruiz', 'estherbeep@gmail.com', 'Calle Carmeli Serrano Garcia', '651303179', 'Alicante', '651303179', 'transferencia'),
	(3, '2025-02-02 11:03:40', 105.00, 'recibido', 2, 'Esther', 'Ruiz', 'Ruiz', 'estherbeep@gmail.com', 'Calle Carmeli Serrano Garcia', '651303179', 'Alicante', '651303179', 'transferencia'),
	(4, '2025-02-02 11:05:20', 105.00, 'recibido', 2, 'Esther', 'Ruiz', 'Castillo', 'estherbeep@gmail.com', 'Calle Carmeli Serrano Garcia', '651303179', 'Alicante', '651303179', 'transferencia'),
	(5, '2025-02-02 11:06:23', 105.00, 'recibido', 2, 'Esther', 'Ruiz', 'Castillo', 'estherbeep@gmail.com', 'Calle Carmeli Serrano Garcia', '651303179', 'Alicante', '651303179', 'transferencia'),
	(6, '2025-02-02 11:06:44', 105.00, 'recibido', 2, 'Esther', 'Ruiz', 'Castillo', 'estherbeep@gmail.com', 'Calle Carmeli Serrano Garcia', '651303179', 'Alicante', '651303179', 'transferencia');

-- Volcando estructura para tabla valostore.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci NOT NULL,
  `categoria_id` int NOT NULL,
  `precio` float(8,2) NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`),
  CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla valostore.productos: ~3 rows (aproximadamente)
INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `categoria_id`, `precio`, `imagen`, `activo`) VALUES
	(3, 'omen', 'lorem ipsum is simply dummy text of the printing and typesetting industry. lorem ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. it has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. it was popularised in the 1960s with the release of letraset sheets containing lorem ipsum passages, and more recently with desktop publishing software like aldus pagemaker including versions of lorem ipsum.', 5, 45.00, '/media/img/productos/67951e2e8604d.png', 1),
	(4, 'sage', 'lorem ipsum is simply dummy text of the printing and typesetting industry. lorem ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. it has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. it was popularised in the 1960s with the release of letraset sheets containing lorem ipsum passages, and more recently with desktop publishing software like aldus pagemaker including versions of lorem ipsum.', 5, 50.00, '/media/img/productos/67951e57219d7.png', 0),
	(5, 'astra', 'lorem ipsum is simply dummy text of the printing and typesetting industry. lorem ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. it has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. it was popularised in the 1960s with the release of letraset sheets containing lorem ipsum passages, and more recently with desktop publishing software like aldus pagemaker including versions of lorem ipsum.', 5, 60.00, '/media/img/productos/67951e6c2d019.png', 1);

-- Volcando estructura para tabla valostore.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `apellido1` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `apellido2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `localidad` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `provincia` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` varchar(9) COLLATE utf8mb4_general_ci NOT NULL,
  `contrasenya` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `rol` enum('admin','usuario','editor') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'usuario',
  `activo` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla valostore.usuarios: ~3 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `usuario`, `email`, `nombre`, `apellido1`, `apellido2`, `direccion`, `localidad`, `provincia`, `telefono`, `contrasenya`, `fechaNacimiento`, `rol`, `activo`) VALUES
	(1, 'manolo', 'estherbeep@gmail.com', 'Esther', 'Ruiz', 'Ruiz', 'Calle Carmeli Serrano Garcia', 'Elche', 'Alicante', '651303179', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db', '1996-07-03', 'admin', 1),
	(2, 'sevelina', 'estherbeep@hotmail.com', 'Esther', 'Ruiz', 'Sempere', 'Carmelo Serrano GarcÃ­a nÂº1 p5', 'Elche', 'Alicante', '651303179', '33275a8aa48ea918bd53a9181aa975f15ab0d0645398f5918a006d08675c1cb27d5c645dbd084eee56e675e25ba4019f2ecea37ca9e2995b49fcb12c096a032e', '1996-07-02', 'usuario', 1),
	(3, 'Ã¡lvaro', 'hola@gmail.com', 'Alvaro', 'Castillo', 'Sempere', 'C. del Barraquer, 3, 03005 Alicante', 'Alacant', 'Alicante', '658559878', '33275a8aa48ea918bd53a9181aa975f15ab0d0645398f5918a006d08675c1cb27d5c645dbd084eee56e675e25ba4019f2ecea37ca9e2995b49fcb12c096a032e', '1111-11-11', 'usuario', 1);

-- Volcando estructura para tabla valostore.usuario_producto
IF NOT EXISTS ;

-- Volcando datos para la tabla valostore.usuario_producto: ~2 rows (aproximadamente)
/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

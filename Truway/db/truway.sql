-- ORDEN CORRECTO DE CREACIÓN Y RELACIONES PARA LA BASE DE DATOS truway

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `truway` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `truway`;


CREATE TABLE `tipo_producto` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` text NOT NULL,
  `contrasena` varchar(50) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `telefono` text NOT NULL,
  `rol` enum('admin','cliente') NOT NULL DEFAULT 'cliente',
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `estado_facturacion` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `estado` enum('pago','pendiente') NOT NULL DEFAULT 'pendiente',
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `mails_automaticos` (
  `id_mail` int(11) NOT NULL AUTO_INCREMENT,
  `destinatario` varchar(255) NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` datetime NOT NULL DEFAULT current_timestamp(),
  `estado_envio` enum('pendiente','enviado','fallido') NOT NULL DEFAULT 'pendiente',
  PRIMARY KEY (`id_mail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `precio` float(11,2) DEFAULT NULL,
  `tipo_producto` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_carrito`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `precio_total` float(11,2) NOT NULL,
  `metodo_pago` enum('Tarjeta_debito','Tarjeta_credito','Debito','Transferencia_bancaria') DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `paquetes` (
  `id_paquete` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_paquete`),
  KEY `id_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `detalle_carrito` (
  `id_detalle_carrito` int(11) NOT NULL AUTO_INCREMENT,
  `id_carrito` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `precio_carrito` decimal(10,2) NOT NULL,
  `fecha_reserva` date DEFAULT NULL,
  PRIMARY KEY (`id_detalle_carrito`),
  KEY `id_carrito` (`id_carrito`),
  KEY `id_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `detalle_paquete` (
  `id_detalle_paquete` int(11) NOT NULL AUTO_INCREMENT,
  `id_paquete` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  PRIMARY KEY (`id_detalle_paquete`),
  KEY `id_paquete` (`id_paquete`),
  KEY `id_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `detalle_pedido` (
  `id_detalle_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_detalle_pedido`),
  KEY `id_pedido` (`id_pedido`),
  KEY `id_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `estadias` (
  `id_estadia` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `localidad` varchar(70) DEFAULT NULL,
  `nombre_hotel` varchar(70) DEFAULT NULL,
  `servicios` varchar(150) DEFAULT NULL,
  `categoria` enum('1','2','3','4','5') DEFAULT NULL,
  PRIMARY KEY (`id_estadia`),
  KEY `id_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `excursiones` (
  `id_excursion` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `ubicacion_salida` varchar(70) DEFAULT NULL,
  `duracion` int(11) NOT NULL,
  `guia` tinyint(1) DEFAULT NULL,
  `dificultad` enum('alta','media','baja') DEFAULT NULL,
  PRIMARY KEY (`id_excursion`),
  KEY `id_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pasajes` (
  `id_pasaje` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `origen` varchar(70) DEFAULT NULL,
  `destino` varchar(70) DEFAULT NULL,
  `aerolinea` varchar(70) DEFAULT NULL,
  `tipo_pasaje` enum('solo_ida','ida_y_vuelta') DEFAULT NULL,
  PRIMARY KEY (`id_pasaje`),
  KEY `id_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `vehiculos` (
  `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `marca` varchar(70) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `capacidad` int(11) DEFAULT NULL,
  `empresa_rentadora` varchar(50) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_vehiculo`),
  KEY `id_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pedidos_aprobados` (
  `id_pedido` int(11) NOT NULL,
  PRIMARY KEY (`id_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pedidos_pendientes` (
  `id_pedido` int(11) NOT NULL,
  PRIMARY KEY (`id_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pedidos_rechazados` (
  `id_pedido` int(11) NOT NULL,
  PRIMARY KEY (`id_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) NOT NULL,
  `fecha_venta` datetime NOT NULL DEFAULT current_timestamp(),
  `estado_facturacion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_venta`),
  UNIQUE KEY `id_pedido_UNIQUE` (`id_pedido`),
  KEY `ventas_ibfk_1` (`estado_facturacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pedidos_historicos` (
  `id_historico` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) NOT NULL,
  `fecha_entrega` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_historico`),
  UNIQUE KEY `id_pedido_UNIQUE` (`id_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`tipo_producto`) REFERENCES `tipo_producto` (`tipo`) ON DELETE SET NULL;

ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

ALTER TABLE `detalle_carrito`
  ADD CONSTRAINT `detalle_carrito_ibfk_1` FOREIGN KEY (`id_carrito`) REFERENCES `carrito` (`id_carrito`),
  ADD CONSTRAINT `detalle_carrito_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

ALTER TABLE `detalle_paquete`
  ADD CONSTRAINT `detalle_paquete_ibfk_1` FOREIGN KEY (`id_paquete`) REFERENCES `paquetes` (`id_paquete`),
  ADD CONSTRAINT `detalle_paquete_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;

ALTER TABLE `estadias`
  ADD CONSTRAINT `estadias_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

ALTER TABLE `excursiones`
  ADD CONSTRAINT `excursiones_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

ALTER TABLE `paquetes`
  ADD CONSTRAINT `paquetes_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;

ALTER TABLE `pasajes`
  ADD CONSTRAINT `pasajes_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

ALTER TABLE `pedidos_aprobados`
  ADD CONSTRAINT `fk_aprobados_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE;

ALTER TABLE `pedidos_pendientes`
  ADD CONSTRAINT `fk_pendientes_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE;

ALTER TABLE `pedidos_rechazados`
  ADD CONSTRAINT `fk_rechazados_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE;

ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_ventas_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos_aprobados` (`id_pedido`) ON DELETE CASCADE,
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`estado_facturacion`) REFERENCES `estado_facturacion` (`id_estado`);

ALTER TABLE `pedidos_historicos`
  ADD CONSTRAINT `fk_historico_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `ventas` (`id_pedido`) ON DELETE CASCADE;


INSERT INTO `tipo_producto` (`id_tipo`, `tipo`) VALUES
(1, 'Paquete'),
(2, 'Excursión'),
(3, 'Pasaje'),
(4, 'Alquiler de Vehículo'),
(5, 'Estadía');

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `email`, `contrasena`, `fecha_nacimiento`, `telefono`, `rol`) VALUES
(1, 'Joaquin', 'Roldan', 'roldanjoaquind42@gmail.com', 'b4b147bc522828731f1a016bfa72c073', '2006-09-26', '+542262540188', 'cliente'),
(2, 'Matias', 'Gigena', 'Matias@gige.com', 'b4b147bc522828731f1a016bfa72c073', '1990-08-23', '+54121212', 'admin');

INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`, `precio`, `tipo_producto`) VALUES
(1, 'Visita al Glaciar Perito Moreno', 'Explora el majestuoso Perito Moreno con nuestro tour guiado', 80000.00, 'Excursión'),
(4, 'Estadia Ushuaia', 'Una estadía confortable en Ushuaia, la ciudad más austral del mundo, que combina naturaleza, aventura y comodidad.', 90298.00, 'Estadía'),
(5, 'Buenos Aires - Ushuaia', 'Pasaje aéreo para viajar desde Buenos Aires a Ushuaia.', 122000.00, 'Pasaje'),
(6, 'Alquiler de Auto en Ushuaia', 'Servicio de alquiler de vehículos para recorrer Ushuaia y sus alrededores con total libertad y comodidad', 270000.00, 'Alquiler de Vehículo'),
(7, 'Los Acebos Ushuaia Hotel', 'Un alojamiento de 4 estrellas muy valorado por su hermosa ubicación y vistas, habitaciones lujosas y confortables', 750000.00, 'Estadía'),
(8, 'Trekking Laguna Esmeralda', 'Conquista el sendero hacia la Laguna Esmeralda, una experiencia guiada única en el corazón de la naturaleza.', 143750.00, 'Excursión'),
(9, 'Paquete Usuahia', 'Un paquete turístico a Ushuaia ofrece una experiencia completa para descubrir los impresionantes paisajes de la Patagonia y Tierra del Fuego', 790000.00, 'Paquete'),
(17, 'gg', 'gg', 66.00, 'Paquete');

INSERT INTO `carrito` (`id_carrito`, `id_usuario`) VALUES
(2, 1);

INSERT INTO `detalle_carrito` (`id_detalle_carrito`, `id_carrito`, `id_producto`, `cantidad`, `precio_carrito`, `fecha_reserva`) VALUES
(3, 2, 7, 2, 750000.00, '2025-06-25');

INSERT INTO `paquetes` (`id_paquete`, `id_producto`) VALUES
(1, 9),
(3, 17);

INSERT INTO `detalle_paquete` (`id_detalle_paquete`, `id_paquete`, `id_producto`) VALUES
(49, 1, 8),
(50, 1, 5),
(51, 1, 4),
(52, 1, 6),
(53, 3, 8),
(54, 3, 5);

INSERT INTO `estadias` (`id_estadia`, `id_producto`, `localidad`, `nombre_hotel`, `servicios`, `categoria`) VALUES
(1, 4, 'Tierra del fuego', 'Hotel del fin del mundo', 'Habitaciones estándar con caja fuerte, TV por cable, teléfono, baño privado con bañera, restaurante y bar/confitería, conexión Wi-Fi, estacionamiento', '4'),
(2, 7, 'Usuahia', 'Los Acebos Ushuaia Hotel', 'Recepción 24 horas, Información turística y servicio de conserjería, Wi-Fi gratuito e Internet Point, Servicio de shuttle al centro de la ciudad', '4');

INSERT INTO `excursiones` (`id_excursion`, `id_producto`, `ubicacion_salida`, `duracion`, `guia`, `dificultad`) VALUES
(1, 1, 'Traslado ida y vuelta desde hotel', 10, 1, 'baja'),
(2, 8, 'Traslado ida y vuelta desde hotel', 5, 1, 'media');

INSERT INTO `pasajes` (`id_pasaje`, `id_producto`, `origen`, `destino`, `aerolinea`, `tipo_pasaje`) VALUES
(1, 5, 'Buenos Aires', 'Ushuaia', 'Aerolíneas Argentinas', 'solo_ida');

INSERT INTO `vehiculos` (`id_vehiculo`, `id_producto`, `marca`, `modelo`, `capacidad`, `empresa_rentadora`, `tipo`) VALUES
(1, 6, 'Toyota', 'Corolla', 5, 'Rentacar Ushuaia', 'auto');

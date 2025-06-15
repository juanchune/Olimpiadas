

CREATE DATABASE IF NOT EXISTS `truway` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `truway`;

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` text NOT NULL,
  `contrasena` varchar(50) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `telefono` text NOT NULL,
  `rol` enum('admin','cliente') NOT NULL DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `precio` float(11,2) DEFAULT NULL,
  `tipo_producto` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `detalle_carrito` (
  `id_detalle_carrito` int(11) NOT NULL,
  `id_carrito` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `precio_carrito` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `paquetes` (
  `id_paquete` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `detalle_paquete` (
  `id_detalle_paquete` int(11) NOT NULL,
  `id_paquete` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `estadias` (
  `id_estadia` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `localidad` varchar(70) DEFAULT NULL,
  `nombre_hotel` varchar(70) DEFAULT NULL,
  `servicios` varchar(150) DEFAULT NULL,
  `categoria` enum('1','2','3','4','5') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `excursiones` (
  `id_excursion` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `ubicacion_salida` varchar(70) DEFAULT NULL,
  `duracion` int(11) NOT NULL,
  `guia` tinyint(1) DEFAULT NULL,
  `dificultad` enum('alta','media','baja') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pasajes` (
  `id_pasaje` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `origen` varchar(70) DEFAULT NULL,
  `destino` varchar(70) DEFAULT NULL,
  `aerolinea` varchar(70) DEFAULT NULL,
  `tipo_pasaje` enum('solo_ida','ida_y_vuelta') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `vehiculos` (
  `id_vehiculo` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `marca` varchar(70) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `capacidad` int(11) DEFAULT NULL,
  `empresa_rentadora` varchar(50) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tipo_producto` (
  `id_tipo` int(11) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `precio_total` float(11,2) NOT NULL,
  `metodo_pago` enum('Tarjeta_debito','Tarjeta_credito','Debito','Transferencia_bancaria') DEFAULT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `detalle_pedido` (
  `id_detalle_pedido` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pedidos_aprobados` (
  `id_pedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pedidos_pendientes` (
  `id_pedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pedidos_rechazados` (
  `id_pedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `estado_facturacion` (
  `id_estado` int(11) NOT NULL,
  `estado` enum('pago','pendiente') NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `fecha_venta` datetime NOT NULL DEFAULT current_timestamp(),
  `estado_facturacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pedidos_historicos` (
  `id_historico` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `fecha_entrega` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `mails_automaticos` (
  `id_mail` int(11) NOT NULL,
  `destinatario` varchar(255) NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` datetime NOT NULL DEFAULT current_timestamp(),
  `estado_envio` enum('pendiente','enviado','fallido') NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `usuarios` ADD PRIMARY KEY (`id_usuario`);
ALTER TABLE `productos` ADD PRIMARY KEY (`id_producto`);
ALTER TABLE `carrito` ADD PRIMARY KEY (`id_carrito`), ADD KEY `id_usuario` (`id_usuario`);
ALTER TABLE `detalle_carrito` ADD PRIMARY KEY (`id_detalle_carrito`), ADD KEY `id_carrito` (`id_carrito`), ADD KEY `id_producto` (`id_producto`);
ALTER TABLE `paquetes` ADD PRIMARY KEY (`id_paquete`), ADD KEY `id_producto` (`id_producto`);
ALTER TABLE `detalle_paquete` ADD PRIMARY KEY (`id_detalle_paquete`), ADD KEY `id_paquete` (`id_paquete`), ADD KEY `id_producto` (`id_producto`);
ALTER TABLE `estadias` ADD PRIMARY KEY (`id_estadia`), ADD KEY `id_producto` (`id_producto`);
ALTER TABLE `excursiones` ADD PRIMARY KEY (`id_excursion`), ADD KEY `id_producto` (`id_producto`);
ALTER TABLE `pasajes` ADD PRIMARY KEY (`id_pasaje`), ADD KEY `id_producto` (`id_producto`);
ALTER TABLE `vehiculos` ADD PRIMARY KEY (`id_vehiculo`), ADD KEY `id_producto` (`id_producto`);
ALTER TABLE `tipo_producto` ADD PRIMARY KEY (`id_tipo`);
ALTER TABLE `pedidos` ADD PRIMARY KEY (`id_pedido`), ADD KEY `id_usuario` (`id_usuario`);
ALTER TABLE `detalle_pedido` ADD PRIMARY KEY (`id_detalle_pedido`), ADD KEY `id_pedido` (`id_pedido`), ADD KEY `id_producto` (`id_producto`);
ALTER TABLE `pedidos_aprobados` ADD PRIMARY KEY (`id_pedido`);
ALTER TABLE `pedidos_pendientes` ADD PRIMARY KEY (`id_pedido`);
ALTER TABLE `pedidos_rechazados` ADD PRIMARY KEY (`id_pedido`);
ALTER TABLE `estado_facturacion` ADD PRIMARY KEY (`id_estado`);
ALTER TABLE `ventas` ADD PRIMARY KEY (`id_venta`), ADD UNIQUE KEY `id_pedido_UNIQUE` (`id_pedido`), ADD KEY `ventas_ibfk_1` (`estado_facturacion`);
ALTER TABLE `pedidos_historicos` ADD PRIMARY KEY (`id_historico`), ADD UNIQUE KEY `id_pedido_UNIQUE` (`id_pedido`);
ALTER TABLE `mails_automaticos` ADD PRIMARY KEY (`id_mail`);


ALTER TABLE `usuarios` MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `productos` MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
ALTER TABLE `carrito` MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `detalle_carrito` MODIFY `id_detalle_carrito` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `paquetes` MODIFY `id_paquete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `detalle_paquete` MODIFY `id_detalle_paquete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
ALTER TABLE `estadias` MODIFY `id_estadia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `excursiones` MODIFY `id_excursion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
ALTER TABLE `pasajes` MODIFY `id_pasaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `vehiculos` MODIFY `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `tipo_producto` MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `pedidos` MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `detalle_pedido` MODIFY `id_detalle_pedido` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `pedidos_historicos` MODIFY `id_historico` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `estado_facturacion` MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `ventas` MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `mails_automaticos` MODIFY `id_mail` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `carrito` ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
ALTER TABLE `detalle_carrito` ADD CONSTRAINT `detalle_carrito_ibfk_1` FOREIGN KEY (`id_carrito`) REFERENCES `carrito` (`id_carrito`);
ALTER TABLE `detalle_carrito` ADD CONSTRAINT `detalle_carrito_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);
ALTER TABLE `paquetes` ADD CONSTRAINT `paquetes_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;
ALTER TABLE `detalle_paquete` ADD CONSTRAINT `detalle_paquete_ibfk_1` FOREIGN KEY (`id_paquete`) REFERENCES `paquetes` (`id_paquete`);
ALTER TABLE `detalle_paquete` ADD CONSTRAINT `detalle_paquete_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);
ALTER TABLE `estadias` ADD CONSTRAINT `estadias_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);
ALTER TABLE `excursiones` ADD CONSTRAINT `excursiones_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);
ALTER TABLE `pasajes` ADD CONSTRAINT `pasajes_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);
ALTER TABLE `vehiculos` ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);
ALTER TABLE `pedidos` ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
ALTER TABLE `detalle_pedido` ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE;
ALTER TABLE `detalle_pedido` ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;
ALTER TABLE `pedidos_aprobados` ADD CONSTRAINT `fk_aprobados_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE;
ALTER TABLE `pedidos_pendientes` ADD CONSTRAINT `fk_pendientes_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE;
ALTER TABLE `pedidos_rechazados` ADD CONSTRAINT `fk_rechazados_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE;
ALTER TABLE `ventas` ADD CONSTRAINT `fk_ventas_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos_aprobados` (`id_pedido`) ON DELETE CASCADE;
ALTER TABLE `ventas` ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`estado_facturacion`) REFERENCES `estado_facturacion` (`id_estado`);
ALTER TABLE `pedidos_historicos` ADD CONSTRAINT `fk_historico_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `ventas` (`id_pedido`) ON DELETE CASCADE;

INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`, `precio`, `tipo_producto`) VALUES
(1, 'Visita al Glaciar Perito Moreno', 'Explora el majestuoso Perito Moreno con nuestro tour guiado', 80000.00, 'Excursión'),
(4, 'Estadia Ushuaia', 'Una estadía confortable en Ushuaia, la ciudad más austral del mundo, que combina naturaleza, aventura y comodidad.', 90288.00, 'Estadía'),
(5, 'Buenos Aires - Ushuaia', 'Pasaje aéreo para viajar desde Buenos Aires a Ushuaia.', 122000.00, 'Pasaje'),
(6, 'Alquiler de Auto en Ushuaia', 'Servicio de alquiler de vehículos para recorrer Ushuaia y sus alrededores con total libertad y comodidad', 270000.00, 'Alquiler de Vehículo'),
(7, 'Los Acebos Ushuaia Hotel', 'Un alojamiento de 4 estrellas muy valorado por su hermosa ubicación y vistas, habitaciones lujosas y confortables', 75000.00, 'Estadía'),
(8, 'Trekking Laguna Esmeralda', 'Conquista el sendero hacia la Laguna Esmeralda, una experiencia guiada única en el corazón de la naturaleza.', 143750.00, 'Excursión'),
(9, 'Paquete Usuahia', 'Un paquete turístico a Ushuaia ofrece una experiencia completa para descubrir los impresionantes paisajes de la Patagonia y Tierra del Fuego', 790.00, 'Paquete'),
(16, 'Excursión Extra', 'Excursión adicional', 0.00, 'Excursión');

INSERT INTO `tipo_producto` (`id_tipo`, `tipo`) VALUES
(1, 'Paquete'),
(2, 'Excursión'),
(3, 'Pasaje'),
(4, 'Alquiler de Vehículo'),
(5, 'Estadía');


INSERT INTO `paquetes` (`id_paquete`, `id_producto`) VALUES
(1, 9);

INSERT INTO `detalle_paquete` (`id_detalle_paquete`, `id_paquete`, `id_producto`) VALUES
(1, 1, 8),
(2, 1, 4),
(3, 1, 5),
(4, 1, 6);


INSERT INTO `estadias` (`id_estadia`, `id_producto`, `localidad`, `nombre_hotel`, `servicios`, `categoria`) VALUES
(1, 4, 'Tierra del fuego', 'Hotel del fin del mundo', 'Habitaciones estándar con caja fuerte, TV por cable, teléfono, baño privado con bañera, restaurante y bar/confitería, conexión Wi-Fi, estacionamiento', '4'),
(2, 7, 'Usuahia', 'Los Acebos Ushuaia Hotel', 'Recepción 24 horas, Información turística y servicio de conserjería, Wi-Fi gratuito e Internet Point, Servicio de shuttle al centro de la ciudad', '4');


INSERT INTO `excursiones` (`id_excursion`, `id_producto`, `ubicacion_salida`, `duracion`, `guia`, `dificultad`) VALUES
(1, 1, 'Traslado ida y vuelta desde hotel', 10, 1, 'baja'),
(2, 8, 'Traslado ida y vuelta desde hotel', 5, 1, 'media'),
(3, 16, '', 0, 0, 'baja');


INSERT INTO `pasajes` (`id_pasaje`, `id_producto`, `origen`, `destino`, `aerolinea`, `tipo_pasaje`) VALUES
(1, 5, 'Buenos Aires', 'Ushuaia', 'Aerolíneas Argentinas', 'solo_ida');


INSERT INTO `vehiculos` (`id_vehiculo`, `id_producto`, `marca`, `modelo`, `capacidad`, `empresa_rentadora`, `tipo`) VALUES
(1, 6, 'Toyota', 'Corolla', 5, 'Rentacar Ushuaia', 'auto');

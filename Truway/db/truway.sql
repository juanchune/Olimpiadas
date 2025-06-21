-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-06-2025 a las 21:27:40
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `truway`
--

CREATE DATABASE IF NOT EXISTS `if0_39268523_truway` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `if0_39268523_truway`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_carrito`
--

CREATE TABLE `detalle_carrito` (
  `id_detalle_carrito` int(11) NOT NULL,
  `id_carrito` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `precio_carrito` decimal(10,2) NOT NULL,
  `fecha_reserva` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_paquete`
--

CREATE TABLE `detalle_paquete` (
  `id_detalle_paquete` int(11) NOT NULL,
  `id_paquete` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_paquete`
--

INSERT INTO `detalle_paquete` (`id_detalle_paquete`, `id_paquete`, `id_producto`) VALUES
(1, 1, 1),
(2, 1, 11),
(3, 1, 16),
(4, 2, 3),
(5, 2, 13),
(6, 2, 19),
(7, 3, 2),
(8, 3, 9),
(9, 3, 15),
(10, 3, 18),
(11, 4, 5),
(12, 4, 8),
(13, 4, 12),
(14, 5, 4),
(15, 5, 10),
(16, 5, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id_detalle_pedido` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadias`
--

CREATE TABLE `estadias` (
  `id_estadia` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `localidad` varchar(70) DEFAULT NULL,
  `nombre_hotel` varchar(70) DEFAULT NULL,
  `servicios` varchar(150) DEFAULT NULL,
  `categoria` enum('1','2','3','4','5') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estadias`
--

INSERT INTO `estadias` (`id_estadia`, `id_producto`, `localidad`, `nombre_hotel`, `servicios`, `categoria`) VALUES
(1, 6, 'Puerto Iguazú, Argentina', 'Gran Meliá Iguazú', 'Piscina, spa, restaurante, vista a cataratas', '5'),
(2, 7, 'Foz do Iguaçu, Brasil', 'Belmond Hotel das Cataratas', 'Spa, piscina, comedor gourmet.', '5'),
(3, 8, 'Puerto Iguazú, Argentina', 'Overo Lodge & Selva', 'Pileta, spa, Wi‑Fi.', '3'),
(4, 9, 'Puerto Iguazú, Argentina', 'Mercure Iguazú Hotel Iru', 'Piscina, restaurante, Wi‑Fi.', '3'),
(5, 10, 'Puerto Iguazú, Argentina', 'Falls Iguazú Hotel & Spa', 'Restaurante, bar, spa, gimnasio.', '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_facturacion`
--

CREATE TABLE `estado_facturacion` (
  `id_estado` int(11) NOT NULL,
  `estado` enum('pago','pendiente') NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `excursiones`
--

CREATE TABLE `excursiones` (
  `id_excursion` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `ubicacion_salida` varchar(70) DEFAULT NULL,
  `duracion` int(11) NOT NULL,
  `guia` tinyint(1) DEFAULT NULL,
  `dificultad` enum('alta','media','baja') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `excursiones`
--

INSERT INTO `excursiones` (`id_excursion`, `id_producto`, `ubicacion_salida`, `duracion`, `guia`, `dificultad`) VALUES
(1, 1, 'El Chaltén, Argentina', 10, 1, 'alta'),
(2, 2, 'Göreme, Turquía', 3, 1, 'baja'),
(3, 3, 'Nairobi, Kenia', 48, 1, 'media'),
(4, 4, 'El Cairo, Egipto', 8, 1, 'baja'),
(5, 5, 'Cusco, Perú', 48, 1, 'alta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mails_automaticos`
--

CREATE TABLE `mails_automaticos` (
  `id_mail` int(11) NOT NULL,
  `destinatario` varchar(255) NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` datetime NOT NULL DEFAULT current_timestamp(),
  `estado_envio` enum('pendiente','enviado','fallido') NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquetes`
--

CREATE TABLE `paquetes` (
  `id_paquete` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paquetes`
--

INSERT INTO `paquetes` (`id_paquete`, `id_producto`) VALUES
(1, 21),
(2, 22),
(3, 23),
(4, 24),
(5, 25),
(7, 29);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pasajes`
--

CREATE TABLE `pasajes` (
  `id_pasaje` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `origen` varchar(70) DEFAULT NULL,
  `destino` varchar(70) DEFAULT NULL,
  `aerolinea` varchar(70) DEFAULT NULL,
  `tipo_pasaje` enum('solo_ida','ida_y_vuelta') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pasajes`
--

INSERT INTO `pasajes` (`id_pasaje`, `id_producto`, `origen`, `destino`, `aerolinea`, `tipo_pasaje`) VALUES
(1, 11, 'Buenos Aires', 'El Calafate', 'Aerolíneas Argentinas', 'ida_y_vuelta'),
(2, 12, 'Madrid', 'Cusco', 'Iberia/LATAM', 'ida_y_vuelta'),
(3, 13, 'Nairobi', 'Maasai Mara', 'Safari Air', 'ida_y_vuelta'),
(4, 14, 'Estambul', 'Capadocia', 'Turkish Airlines', 'ida_y_vuelta'),
(5, 15, 'Buenos Aires', 'Ushuaia', 'Flybondi', 'ida_y_vuelta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `precio_total` float(11,2) NOT NULL,
  `metodo_pago` enum('Tarjeta debito','Tarjeta credito') DEFAULT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_aprobados`
--

CREATE TABLE `pedidos_aprobados` (
  `id_pedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_historicos`
--

CREATE TABLE `pedidos_historicos` (
  `id_historico` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `fecha_entrega` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_pendientes`
--

CREATE TABLE `pedidos_pendientes` (
  `id_pedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_rechazados`
--

CREATE TABLE `pedidos_rechazados` (
  `id_pedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `precio` float(11,2) DEFAULT NULL,
  `tipo_producto` varchar(50) DEFAULT NULL,
  `codigo_producto` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`, `precio`, `tipo_producto`, `codigo_producto`) VALUES
(1, 'Trekking al Monte Fitz Roy', 'Caminata de día completo con guía y transporte local.', 448000.00, 'Excursión', 'EXC001'),
(2, 'Tour en Globo en Capadocia', 'Paseo en globo al amanecer con desayuno y seguro.', 560000.00, 'Excursión', 'EXC002'),
(3, 'Safari Maasai Mara 2 días', 'Safari de dos días con campamento y comidas incluidas.', 1960000.00, 'Excursión', 'EXC003'),
(4, 'Excursión Pirámides de Giza', 'Tour guiado a Giza y Dahshur con almuerzo incluido.', 392000.00, 'Excursión', 'EXC004'),
(5, 'Caminata al Machu Picchu', 'Trek de 2 días con guía, entradas y comidas.', 728000.00, 'Excursión', 'EXC005'),
(6, 'Gran Meliá Iguazú', 'Luxury dentro del parque con desayuno buffet.', 1120000.00, 'Estadía', 'EST001'),
(7, 'Belmond Hotel das Cataratas', 'Hotel cinco estrellas dentro del parque con spa y cena incluida.', 1120000.00, 'Estadía', 'EST002'),
(8, 'Overo Lodge & Selva', 'Cabañas boutique con desayuno y senderos ecológicos incluidos.', 675000.00, 'Estadía', 'EST003'),
(9, 'Mercure Iguazú Hotel Iru', 'Habitación moderna con piscina, spa y desayuno.', 420000.00, 'Estadía', 'EST004'),
(10, 'Falls Iguazú Hotel & Spa', 'Resort con spa, piscina y vista a la selva.', 462000.00, 'Estadía', 'EST005'),
(11, 'BA – El Calafate', 'Ida y vuelta, equipaje incluido, comida abordo.', 392000.00, 'Pasaje', 'PAS001'),
(12, 'Madrid – Cusco', 'Ida y vuelta, escala Lima, maleta 23 kg.', 1540000.00, 'Pasaje', 'PAS002'),
(13, 'Nairobi – Maasai Mara', 'Ida y vuelta en avioneta + traslados incluidos.448000', 44800.00, 'Pasaje', 'PAS003'),
(14, 'Estambul – Capadocia', ' Ida y vuelta, equipaje y comidas a bordo.', 196000.00, 'Pasaje', 'PAS004'),
(15, 'Buenos Aires – Ushuaia', 'Ida y vuelta low‑cost, sin maleta.', 224000.00, 'Pasaje', 'PAS005'),
(16, 'Toyota Hilux 4×4', 'Camioneta para rutas off‑road.', 300000.00, 'Alquiler de Vehículo', 'VEH001'),
(17, 'Jeep Wrangler', '4×4 con techo quitado para clima cálido.', 320000.00, 'Alquiler de Vehículo', 'VEH002'),
(18, 'Moto Honda CRF300', 'Enduro ligera para senderos.', 224000.00, 'Alquiler de Vehículo', 'VEH003'),
(19, 'Van Mercedes Sprinter 12 pax', 'Minibus con aire acondicionado.', 840000.00, 'Alquiler de Vehículo', 'VEH004'),
(20, 'Camper Van Fiat Ducato', 'Combi equipada con cocina y cama.', 900000.00, 'Alquiler de Vehículo', 'VEH005'),
(21, 'Aventura El Chaltén Deluxe', 'Trekking Fitz Roy + vuelo BA‑Calafate + Hilux 4×4 x 2 días.', 22400000.00, 'Paquete', 'PAQ001'),
(22, 'Safari Maasai Mara Premium', 'Safari 2 días + avioneta + van Sprinter.', 3248000.00, 'Paquete', 'PAQ002'),
(23, 'Capadocia Completo', 'Globo + hotel 2 noches + vuelo + moto.', 3016000.00, 'Paquete', 'PAQ003'),
(24, 'Machu Picchu Todo Incluido', 'Trek 2 días + hotel + vuelo a Cusco.', 2780000.00, 'Paquete', 'PAQ004'),
(25, 'Egipto Cultural', 'Tour Giza + vuelo CDMX–El Cairo + hotel 2 noches.', 1568000.00, 'Paquete', 'PAQ005'),
(29, 'pRUEBA', 'pRUEBA', 11.00, 'Paquete', 'pRUEBA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_producto`
--

CREATE TABLE `tipo_producto` (
  `id_tipo` int(11) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

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

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `email`, `contrasena`, `fecha_nacimiento`, `telefono`, `rol`) VALUES
(1, 'Matias', 'Gigena', 'matiasgigena@admin.com', '0192023a7bbd73250516f069df18b500', '1998-11-11', '+542262940495', 'admin'),
(2, 'Maia', 'Sanchez', 'sanchezmaialen6@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '2007-01-24', '+541234', 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id_vehiculo` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `marca` varchar(70) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `capacidad` int(11) DEFAULT NULL,
  `empresa_rentadora` varchar(50) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id_vehiculo`, `id_producto`, `marca`, `modelo`, `capacidad`, `empresa_rentadora`, `tipo`) VALUES
(1, 16, 'Toyota', 'Hilux', 5, 'Rent a Car Sur', 'camioneta'),
(2, 17, 'Jeep', 'Wrangler', 5, 'Safari Wheels', 'camioneta'),
(3, 18, 'Honda', 'CRF300', 2, 'Moto Travel Mundo', 'moto'),
(4, 19, 'Mercedes', 'Sprinter', 12, 'GroupRide', 'minibus'),
(5, 20, 'Fiat', 'Ducato', 4, 'VanCampers', 'combi');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `fecha_venta` date NOT NULL DEFAULT curdate(),
  `estado_facturacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `detalle_carrito`
--
ALTER TABLE `detalle_carrito`
  ADD PRIMARY KEY (`id_detalle_carrito`),
  ADD KEY `id_carrito` (`id_carrito`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `detalle_paquete`
--
ALTER TABLE `detalle_paquete`
  ADD PRIMARY KEY (`id_detalle_paquete`),
  ADD KEY `id_paquete` (`id_paquete`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id_detalle_pedido`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `estadias`
--
ALTER TABLE `estadias`
  ADD PRIMARY KEY (`id_estadia`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `estado_facturacion`
--
ALTER TABLE `estado_facturacion`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `excursiones`
--
ALTER TABLE `excursiones`
  ADD PRIMARY KEY (`id_excursion`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `mails_automaticos`
--
ALTER TABLE `mails_automaticos`
  ADD PRIMARY KEY (`id_mail`);

--
-- Indices de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD PRIMARY KEY (`id_paquete`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `pasajes`
--
ALTER TABLE `pasajes`
  ADD PRIMARY KEY (`id_pasaje`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `pedidos_aprobados`
--
ALTER TABLE `pedidos_aprobados`
  ADD PRIMARY KEY (`id_pedido`);

--
-- Indices de la tabla `pedidos_historicos`
--
ALTER TABLE `pedidos_historicos`
  ADD PRIMARY KEY (`id_historico`),
  ADD UNIQUE KEY `id_pedido_UNIQUE` (`id_pedido`);

--
-- Indices de la tabla `pedidos_pendientes`
--
ALTER TABLE `pedidos_pendientes`
  ADD PRIMARY KEY (`id_pedido`);

--
-- Indices de la tabla `pedidos_rechazados`
--
ALTER TABLE `pedidos_rechazados`
  ADD PRIMARY KEY (`id_pedido`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id_vehiculo`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `estado_facturacion` (`estado_facturacion`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_carrito`
--
ALTER TABLE `detalle_carrito`
  MODIFY `id_detalle_carrito` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_paquete`
--
ALTER TABLE `detalle_paquete`
  MODIFY `id_detalle_paquete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id_detalle_pedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estadias`
--
ALTER TABLE `estadias`
  MODIFY `id_estadia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `estado_facturacion`
--
ALTER TABLE `estado_facturacion`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `excursiones`
--
ALTER TABLE `excursiones`
  MODIFY `id_excursion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `mails_automaticos`
--
ALTER TABLE `mails_automaticos`
  MODIFY `id_mail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  MODIFY `id_paquete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pasajes`
--
ALTER TABLE `pasajes`
  MODIFY `id_pasaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos_historicos`
--
ALTER TABLE `pedidos_historicos`
  MODIFY `id_historico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `detalle_carrito`
--
ALTER TABLE `detalle_carrito`
  ADD CONSTRAINT `detalle_carrito_ibfk_1` FOREIGN KEY (`id_carrito`) REFERENCES `carrito` (`id_carrito`),
  ADD CONSTRAINT `detalle_carrito_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `detalle_paquete`
--
ALTER TABLE `detalle_paquete`
  ADD CONSTRAINT `detalle_paquete_ibfk_1` FOREIGN KEY (`id_paquete`) REFERENCES `paquetes` (`id_paquete`),
  ADD CONSTRAINT `detalle_paquete_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `estadias`
--
ALTER TABLE `estadias`
  ADD CONSTRAINT `estadias_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `excursiones`
--
ALTER TABLE `excursiones`
  ADD CONSTRAINT `excursiones_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD CONSTRAINT `paquetes_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pasajes`
--
ALTER TABLE `pasajes`
  ADD CONSTRAINT `pasajes_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `pedidos_aprobados`
--
ALTER TABLE `pedidos_aprobados`
  ADD CONSTRAINT `fk_aprobados_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidos_historicos`
--
ALTER TABLE `pedidos_historicos`
  ADD CONSTRAINT `fk_historico_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE;

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`estado_facturacion`) REFERENCES `estado_facturacion` (`id_estado`),
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

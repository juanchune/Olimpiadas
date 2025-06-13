CREATE DATABASE IF NOT EXISTS `truway` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `truway`;

CREATE TABLE usuarios (
  id_usuario int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  nombre varchar(100) NOT NULL,
  apellido varchar(100) NOT NULL,
  email text NOT NULL,
  contrasena varchar(50) NOT NULL,
  fecha_nacimiento date NOT NULL,
  telefono text NOT NULL
);

CREATE TABLE productos(
    id_producto INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nombre VARCHAR(50),
    descripcion VARCHAR(150),
    precio FLOAT(11,2),
    tipo_producto INT(11)
);

CREATE TABLE tipo_producto(
    id_tipo INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    tipo VARCHAR(50)
);

INSERT INTO tipo_producto (`id_tipo`, `tipo`) VALUES
    (1, 'Paquete'),
    (2, 'Excursión'),
    (3, 'Pasaje'),
    (4, 'Alquiler de Vehículo'),
    (5, 'Estadía');

CREATE TABLE vehiculos (
    id_vehiculo int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_producto int(11) NOT NULL,
    marca varchar(70) DEFAULT NULL,
    modelo varchar(50) DEFAULT NULL,
    capacidad int(11) DEFAULT NULL,
    empresa_rentadora varchar(50) DEFAULT NULL,
    tipo varchar(50) DEFAULT NULL,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

CREATE TABLE estadias (
    id_estadia int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_producto int(11) NOT NULL,
    localidad varchar(70) DEFAULT NULL,
    nombre_hotel varchar(70) DEFAULT NULL,
    servicios varchar(150) DEFAULT NULL,
    categoria enum('1','2','3','4','5') DEFAULT NULL,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

CREATE TABLE pasajes (
    id_pasaje int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_producto int(11) NOT NULL,
    origen varchar(70) DEFAULT NULL,
    destino varchar(70) DEFAULT NULL,
    aerolinea varchar(70) DEFAULT NULL,
    tipo_pasaje enum('ida','ida_vuelta') DEFAULT NULL,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

CREATE TABLE paquetes(
    id_paquete INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_producto INT(11),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

CREATE TABLE detalle_paquete(
    id_detalle_paquete INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_paquete INT(11) NOT NULL,
    id_producto INT(11) NOT NULL,
    FOREIGN KEY (id_paquete) REFERENCES paquetes(id_paquete),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

CREATE TABLE estado_pedidos (
    id_estado int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    estado enum('pendiente','aprobado','rechazado') NOT NULL DEFAULT 'pendiente'
);

CREATE TABLE estado_facturacion (
    id_estado int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    estado enum('pago','pendiente') NOT NULL DEFAULT 'pendiente'
);

CREATE TABLE pedidos (
    id_pedido int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_usuario int(11) NOT NULL,
    fecha date NOT NULL,
    precio_total float(11,2) NOT NULL,
    metodo_pago enum('Tarjeta_debito','Tarjeta_credito','Debito','Transferencia_bancaria') DEFAULT NULL,
    cantidad int(11) NOT NULL,
    estado_pedido INT(11),
    estado_facturacion INT(11),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (estado_pedido) REFERENCES estado_pedidos(id_estado),
    FOREIGN KEY (estado_facturacion) REFERENCES estado_facturacion(id_estado)
);

CREATE TABLE carrito (
    id_carrito int(11) PRIMARY KEY NOT NULL,
    id_usuario int(11) NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE detalle_carrito (
    id_detalle_carrito int(11) PRIMARY KEY NOT NULL,
    id_carrito int(11) NOT NULL,
    id_producto int(11) NOT NULL,
    cantidad int(11) NOT NULL DEFAULT 1,
    precio_carrito decimal(10,2) NOT NULL,
    FOREIGN KEY (id_carrito) REFERENCES carrito(id_carrito),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);
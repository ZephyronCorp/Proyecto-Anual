CREATE DATABASE zonajoystick;

USE zonajoystick;

-- Tabla Rol
CREATE TABLE Rol (
    id_rol INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL UNIQUE
);

-- Tabla Usuario
CREATE TABLE Usuario (
    id_usuario INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    id_rol INT UNSIGNED NOT NULL,

    FOREIGN KEY (id_rol) REFERENCES Rol(id_rol)
);

-- Tabla Mensaje
CREATE TABLE Mensaje (
    id_mensaje INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    asunto VARCHAR(200) NOT NULL,
    contenido TEXT NOT NULL,
    respuesta VARCHAR(1000) NULL,
    fecha_respuesta DATETIME NULL,
    id_usuario INT UNSIGNED NOT NULL,

    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

-- Tabla Pedido
CREATE TABLE Pedido (
    id_pedido INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    estado VARCHAR(40) NOT NULL DEFAULT 'pendiente',
    total DECIMAL(10,2) NOT NULL DEFAULT 0,
    envio_nombre VARCHAR(60) NULL,
    envio_direccion VARCHAR(100) NULL,
    envio_ciudad VARCHAR(50) NULL,
    envio_departamento VARCHAR(30) NULL,
    envio_telefono VARCHAR(15) NULL,
    estado_envio ENUM('preparando', 'enviado', 'entregado')
        NOT NULL DEFAULT 'preparando',
    id_usuario INT UNSIGNED NOT NULL,

    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

-- Tabla Pago
-- Cada fila representa un intento de pago.
CREATE TABLE Pago (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    metodo VARCHAR(50) NOT NULL DEFAULT 'tarjeta',
    monto DECIMAL(10,2) NOT NULL,
    ultimos4 CHAR(4) NOT NULL,
    resultado ENUM('aprobado', 'rechazado') NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_pedido INT UNSIGNED NOT NULL,

    FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido)
);

-- Tabla Categoria
CREATE TABLE Categoria (
    id_categoria INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NULL
);

-- Tabla Producto
CREATE TABLE Producto (
    id_producto INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    descripcion TEXT NULL,
    stock INT UNSIGNED NOT NULL DEFAULT 0,
    imagen VARCHAR(500) NULL,
    stock_minimo INT NOT NULL DEFAULT 5,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    id_categoria INT UNSIGNED NOT NULL,

    FOREIGN KEY (id_categoria) REFERENCES Categoria(id_categoria)
);

-- Tabla Detalle_Pedido
CREATE TABLE Detalle_Pedido (
    cantidad INT UNSIGNED NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    id_pedido INT UNSIGNED NOT NULL,
    id_producto INT UNSIGNED NOT NULL,

    PRIMARY KEY (id_pedido, id_producto),

    FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido),
    FOREIGN KEY (id_producto) REFERENCES Producto(id_producto)
);

-- Roles del sistema
INSERT INTO Rol (id_rol, nombre_rol)
VALUES
(1, 'administrador'),
(2, 'cliente');

-- Categorías del sistema
INSERT INTO Categoria (id_categoria, nombre, descripcion)
VALUES
(1, 'Videojuegos', 'Videojuegos para distintas plataformas'),
(2, 'Figuras', 'Figuras y coleccionables'),
(3, 'Manga', 'Libros y manga'),
(4, 'TCG', 'Juegos de cartas coleccionables');

-- Administrador: rol 1
INSERT INTO Usuario (nombre, apellido, email, contrasena, id_rol)
VALUES (
    'Admin',
    'Prueba',
    'admin@zonajoystick.com',
    '$2y$10$9cloUOThzgPME4MQbGRndeW/PfJmhEKX8CcG4.OHH1T35WfTyd0Ze',
    1
);

-- Cliente: rol 2
INSERT INTO Usuario (nombre, apellido, email, contrasena, id_rol)
VALUES (
    'Cliente',
    'Prueba',
    'cliente@zonajoystick.com',
    '$2y$10$pE05b5lzCyYrrwpIU8gVyehS5POrdfxzcOrPFZXVy3fsO6zoS4F2K',
    2
);
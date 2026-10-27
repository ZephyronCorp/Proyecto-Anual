CREATE DATABASE zonajoystick;

USE zonajoystick;

-- Tabla Rol
CREATE TABLE Rol (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL
);

-- Tabla Usuario
CREATE TABLE Usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    id_rol INT NOT NULL,

    FOREIGN KEY (id_rol) REFERENCES Rol(id_rol)
);
-- Agregar columna activo en la tabla usuario
ALTER TABLE usuario
ADD COLUMN activo TINYINT(1) NOT NULL DEFAULT 1;
ADD COLUMN fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;

-- Tabla Direccion
CREATE TABLE Direccion (
    id_direccion INT AUTO_INCREMENT PRIMARY KEY,
    calle VARCHAR(150) NOT NULL,
    numero VARCHAR(20) NOT NULL,
    ciudad VARCHAR(100) NOT NULL,
    id_usuario INT NOT NULL,

    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

-- Tabla Metodo_Pago
CREATE TABLE Metodo_Pago (
    id_metodo_pago INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    activo BOOLEAN NOT NULL,
    id_usuario INT NOT NULL,

    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

-- Tabla Mensaje
CREATE TABLE Mensaje (
    id_mensaje INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME NOT NULL,
    asunto VARCHAR(150) NOT NULL,
    contenido TEXT NOT NULL,
    id_usuario INT NOT NULL,

    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

-- Tabla Pedido
CREATE TABLE Pedido (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    estado VARCHAR(50) NOT NULL DEFAULT 'pendiente',
    total DECIMAL(10,2) NOT NULL DEFAULT 0,
    id_usuario INT NOT NULL,
    envio_nombre VARCHAR(60) NULL,
    envio_direccion VARCHAR(100) NULL,
    envio_ciudad VARCHAR(50) NULL,
    envio_departamento VARCHAR(30) NULL,
    envio_telefono VARCHAR(15) NULL,

    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

-- Tabla Pago
-- Cada registro representa un intento de pago.
CREATE TABLE Pago (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    ultimos4 CHAR(4) NOT NULL,
    resultado ENUM('aprobado', 'rechazado') NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido)
);

-- Tabla Categoria
CREATE TABLE Categoria (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    sub_categoria VARCHAR(100)
);

-- Tabla Producto
CREATE TABLE Producto (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    descripcion TEXT,
    stock INT UNSIGNED NOT NULL DEFAULT 0,
    stock_minimo INT NOT NULL DEFAULT 5,
    imagen VARCHAR(500) NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    id_categoria INT NOT NULL,

    FOREIGN KEY (id_categoria) REFERENCES Categoria(id_categoria)
);

-- Tabla Descuento
CREATE TABLE Descuento (
    id_descuento INT AUTO_INCREMENT PRIMARY KEY,
    porcentaje_descuento DECIMAL(5,2) NOT NULL,
    validez DATE NOT NULL,
    usos INT NOT NULL
);

-- Tabla Detalle_Producto
CREATE TABLE Detalle_Producto (
    id_pedido INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,

    PRIMARY KEY (id_pedido, id_producto),

    FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido),
    FOREIGN KEY (id_producto) REFERENCES Producto(id_producto)
);

-- Tabla Descuento_Producto
CREATE TABLE Descuento_Producto (
    id_producto INT NOT NULL,
    id_descuento INT NOT NULL,

    PRIMARY KEY (id_producto, id_descuento),

    FOREIGN KEY (id_producto) REFERENCES Producto(id_producto),
    FOREIGN KEY (id_descuento) REFERENCES Descuento(id_descuento)
);


-- Inserts
INSERT INTO Rol (nombre_rol)
VALUES
('Administrador'),
('Empleado'),
('Cliente');

-- Usuarios de prueba con contraseña almacenada como hash
INSERT INTO Usuario (nombre, apellido, email, contrasena, id_rol)
VALUES
('Admin', 'Prueba', 'admin@zonajoystick.com', '$2y$10$E4hXxtSE8KHfuOEjoQB35uD14ZhT7lFtwGAmx32SY4GjpqHLLf66G', 1),
('Cliente', 'Prueba', 'cliente@zonajoystick.com', '$2y$10$3SSH0swOxw5.GTlenC6Fb.5U02FCm1W5oCeXit/hoZmAfngD5cyiy', 3);

-- Categorías
INSERT INTO Categoria (nombre, descripcion, sub_categoria)
VALUES
('Videojuegos', 'Juegos para diferentes plataformas', NULL),
('Figuras y coleccionables', 'Figuras de personajes y coleccionables', NULL),
('Indumentaria', 'Ropa y accesorios de videojuegos y anime', NULL),
('TCG', 'Cartas coleccionables', NULL);

-- Videojuegos
INSERT INTO Producto (nombre, precio, descripcion, stock, id_categoria, imagen)
VALUES
('Grand Theft Auto VI', 3500, 'Videojuego de acción y mundo abierto.', 10, 1, '/Proyecto-Anual/public/img/GTAVI.png'),
('Astro Bot PS5', 2490, 'Videojuego de plataformas para PlayStation 5.', 12, 1, '/Proyecto-Anual/public/img/AstroBot.jpg');

-- Figuras y coleccionables
INSERT INTO Producto (nombre, precio, descripcion, stock, id_categoria, imagen)
VALUES
('Funko Pop Astro Bot', 1290, 'Figura coleccionable de Astro Bot.', 8, 2, '/Proyecto-Anual/public/img/AstroBotFunko.png'),
('Figura Izuku Midoriya', 1590, 'Figura coleccionable de Izuku Midoriya.', 6, 2, '/Proyecto-Anual/public/img/Figura-Izuku.jpg');

-- Indumentaria
INSERT INTO Producto (nombre, precio, descripcion, stock, id_categoria, imagen)
VALUES
('Capa Akatsuki', 1890, 'Capa inspirada en Akatsuki de Naruto.', 6, 3, '/Proyecto-Anual/public/img/Capa-Akatsuki.jpg');

-- TCG
INSERT INTO Producto (nombre, precio, descripcion, stock, id_categoria, imagen)
VALUES
('Pokemon Trainer Box', 2990, 'Caja de cartas coleccionables Pokemon.', 8, 4, '/Proyecto-Anual/public/img/Pokemon-Trainer-Box.jpg');

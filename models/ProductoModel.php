<?php

class ProductoModel {
    private $conexion;

    // Regla para determinar el nivel de stock.
    private $sqlNivelStock = "CASE
                                WHEN p.stock = 0 THEN 'agotado'
                                WHEN p.stock <= p.stock_minimo THEN 'bajo'
                                ELSE 'ok'
                             END";

    // Constructor: recibe la conexión a MySQL.
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Devuelve los productos activos o filtra por categoría y búsqueda.
    public function listarProductos($idCategoria = null, $busqueda = "") {
        $sql = "SELECT * FROM Producto WHERE activo = 1";
        $tipos = "";
        $parametros = [];

        // Filtro por categoría.
        if ($idCategoria !== null && $idCategoria !== "") {
            $sql .= " AND id_categoria = ?";
            $tipos .= "i";
            $parametros[] = (int)$idCategoria;
        }

        // Filtro por texto.
        if ($busqueda !== "") {
            $sql .= " AND (nombre LIKE ? OR descripcion LIKE ?)";
            $tipos .= "ss";
            $patron = "%" . $this->escaparLike($busqueda) . "%";
            $parametros[] = $patron;
            $parametros[] = $patron;
        }

        $sql .= " ORDER BY nombre";

        $stmt = $this->conexion->prepare($sql);

        if (!empty($parametros)) {
            $stmt->bind_param($tipos, ...$parametros);
        }

        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    private function escaparLike($texto) {
        return str_replace(
            ['\\', '%', '_'],
            ['\\\\', '\\%', '\\_'],
            $texto
        );
    }

    // Devuelve un producto activo mediante su ID.
    public function obtenerProductoPorId($idProducto) {
        $consultaSql = "
            SELECT
                Producto.id_producto,
                Producto.nombre,
                Producto.descripcion,
                Producto.precio,
                Producto.stock,
                Producto.imagen,
                Categoria.id_categoria,
                Categoria.nombre AS nombre_categoria
            FROM Producto
            INNER JOIN Categoria
                ON Producto.id_categoria = Categoria.id_categoria
            WHERE Producto.id_producto = ?
                AND Producto.activo = 1";

        $consultaPreparada = mysqli_prepare($this->conexion, $consultaSql);

        mysqli_stmt_bind_param(
            $consultaPreparada,
            "i",
            $idProducto
        );

        mysqli_stmt_execute($consultaPreparada);
        $resultado = mysqli_stmt_get_result($consultaPreparada);

        $producto = mysqli_fetch_assoc($resultado);

        mysqli_stmt_close($consultaPreparada);

        return $producto;
    }

    // Devuelve todas las categorías.
    public function listarCategorias() {
        $consultaSql = "SELECT * FROM Categoria ORDER BY nombre ASC";

        $resultado = mysqli_query($this->conexion, $consultaSql);

        $listaDeCategorias = [];

        while ($filaCategoria = mysqli_fetch_assoc($resultado)) {
            $listaDeCategorias[] = $filaCategoria;
        }

        return $listaDeCategorias;
    }

    // Métodos para el panel de administración.

    // Devuelve todos los productos, incluidos los dados de baja.
    public function listarTodosAdmin() {
        $sql = "SELECT
                    p.id_producto,
                    p.nombre,
                    p.precio,
                    p.stock,
                    p.stock_minimo,
                    p.imagen,
                    p.activo,
                    c.nombre AS categoria,
                    {$this->sqlNivelStock} AS nivel_stock
                FROM Producto p
                INNER JOIN Categoria c
                    ON c.id_categoria = p.id_categoria
                ORDER BY p.activo DESC, p.nombre ASC";

        return $this->conexion->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    // Devuelve un producto, esté activo o dado de baja.
    public function obtenerParaAdmin($idProducto) {
        $stmt = $this->conexion->prepare(
            "SELECT
                p.id_producto,
                p.nombre,
                p.descripcion,
                p.precio,
                p.stock,
                p.stock_minimo,
                p.imagen,
                p.id_categoria,
                p.activo,
                {$this->sqlNivelStock} AS nivel_stock
             FROM Producto p
             WHERE p.id_producto = ?"
        );

        $stmt->bind_param("i", $idProducto);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // Devuelve los productos activos con stock bajo o agotado.
    public function listarStockBajo() {
        $sql = "SELECT
                    p.id_producto,
                    p.nombre,
                    p.stock,
                    p.stock_minimo,
                    {$this->sqlNivelStock} AS nivel_stock
                FROM Producto p
                WHERE p.activo = 1
                    AND p.stock <= p.stock_minimo
                ORDER BY p.stock ASC, p.nombre ASC";

        return $this->conexion->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    // Crea un producto y devuelve su ID o false si falla.
    public function crear($datos) {
        $stmt = $this->conexion->prepare(
            "INSERT INTO Producto
                (nombre, descripcion, precio, stock, stock_minimo, imagen, id_categoria)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssdiisi",
            $datos['nombre'],
            $datos['descripcion'],
            $datos['precio'],
            $datos['stock'],
            $datos['stock_minimo'],
            $datos['imagen'],
            $datos['id_categoria']
        );

        if (!$stmt->execute()) {
            return false;
        }

        return $this->conexion->insert_id;
    }

    // Actualiza los datos de un producto.
    public function actualizar($idProducto, $datos) {
        $stmt = $this->conexion->prepare(
            "UPDATE Producto
             SET nombre = ?, descripcion = ?, precio = ?, stock = ?,
                 stock_minimo = ?, imagen = ?, id_categoria = ?
             WHERE id_producto = ?"
        );

        $stmt->bind_param(
            "ssdiisii",
            $datos['nombre'],
            $datos['descripcion'],
            $datos['precio'],
            $datos['stock'],
            $datos['stock_minimo'],
            $datos['imagen'],
            $datos['id_categoria'],
            $idProducto
        );

        return $stmt->execute();
    }

    // Da de baja un producto o lo reactiva.
    public function cambiarActivo($idProducto, $activo) {
        $stmt = $this->conexion->prepare(
            "UPDATE Producto
             SET activo = ?
             WHERE id_producto = ?"
        );

        $stmt->bind_param("ii", $activo, $idProducto);

        return $stmt->execute();
    }
}
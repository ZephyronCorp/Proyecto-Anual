<?php

class ProductoModel {
    private $conexion;

    // Constructor: recibe la conexión a MySQL.
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Devuelve todos los productos o filtra por categoría.
    public function listarProductos($idCategoriaFiltro = null) {

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
                ON Producto.id_categoria = Categoria.id_categoria";

        // Si hay una categoría seleccionada, agregamos el filtro.
        if (!empty($idCategoriaFiltro)) {
            $consultaSql .= " WHERE Producto.id_categoria = ?";
        }

        $consultaSql .= " ORDER BY Producto.nombre ASC";
        $consultaPreparada = mysqli_prepare($this->conexion, $consultaSql);

        if (!empty($idCategoriaFiltro)) {
            mysqli_stmt_bind_param(
                $consultaPreparada,
                "i",
                $idCategoriaFiltro
            );
        }

        mysqli_stmt_execute($consultaPreparada);
        $resultado = mysqli_stmt_get_result($consultaPreparada);
        $listaDeProductos = [];

        while ($filaProducto = mysqli_fetch_assoc($resultado)) {
            $listaDeProductos[] = $filaProducto;
        }

        mysqli_stmt_close($consultaPreparada);
        return $listaDeProductos;
    }

    // Devuelve un producto específico mediante su ID.
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
            WHERE Producto.id_producto = ?";

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
}

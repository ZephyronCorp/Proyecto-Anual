<?php

class ProductoModel {
    private $conexion;

    // Constructor: recibe la conexión a MySQL.
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Devuelve todos los productos o filtra por categoría.
    public function listarProductos($idCategoria = null, $busqueda = "") {
        $sql = "SELECT * FROM Producto WHERE 1=1";
        $tipos = "";
        $parametros = [];

        
        //filtro por categoría
        if ($idCategoria !== null && $idCategoria !== "") {
            $sql .= " AND id_categoria = ?";
            $tipos .= "i";
            $parametros[] = (int)$idCategoria;
        }
        
        //filtro por texto

        if($busqueda !==""){
            $sql .= " AND (nombre LIKE ? OR descripcion LIKE ?)";
            $tipos .= "ss";
            $patron = "%" . $this->escaparLike($busqueda) . "%";
            $parametros[] = $patron;
            $parametros[] = $patron;
        }

        $sql .= " ORDER BY nombre";

        $stmt = $this->conexion->prepare($sql);
        if(!empty($parametros)){
            $stmt->bind_param($tipos, ...$parametros);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        
    }

    private function escaparLike($texto) {
            return str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $texto);
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

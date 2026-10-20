<?php

class PedidoModel {
    private $conexion;

    // Constructor: recibe la conexión a MySQL.
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Crea un nuevo pedido en la base de datos y devuelve el ID del pedido creado.
    public function crearPedido($idUsuario) {
        $consultaSql = "INSERT INTO Pedido (fecha, estado, id_usuario) VALUES (NOW(), 'Pendiente', ?)";
        $consultaPreparada = mysqli_prepare($this->conexion, $consultaSql);
        mysqli_stmt_bind_param($consultaPreparada, "i", $idUsuario);
        mysqli_stmt_execute($consultaPreparada);
        $idPedido = mysqli_insert_id($this->conexion);
        mysqli_stmt_close($consultaPreparada);
        return $idPedido;
    }

    // Agrega un detalle de pedido a la base de datos.
    public function agregarDetallePedido($idPedido, $idProducto, $cantidad, $precioUnitario) {
        $consultaSql = "INSERT INTO Detalle_Producto (id_pedido, id_producto, cantidad, precio) VALUES (?, ?, ?, ?)";
        $consultaPreparada = mysqli_prepare($this->conexion, $consultaSql);
        mysqli_stmt_bind_param($consultaPreparada, "iiid", $idPedido, $idProducto, $cantidad, $precioUnitario);
        mysqli_stmt_execute($consultaPreparada);
        mysqli_stmt_close($consultaPreparada);
    }
}

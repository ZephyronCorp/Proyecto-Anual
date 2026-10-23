<?php

class PedidoModel {
    private $conexion;

    // Constructor: recibe la conexión a MySQL.
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Crea un nuevo pedido en la base de datos y devuelve el ID del pedido creado.
    public function crearPedido($idUsuario, $totalDelPedido) {
        $consultaSql = "INSERT INTO Pedido (fecha, estado, id_usuario, total) VALUES (NOW(), ? , ?, ?)";
        $consultaPreparada = mysqli_prepare($this->conexion, $consultaSql);
        $estado = 'Pendiente';
        mysqli_stmt_bind_param($consultaPreparada, "sid", $estado, $idUsuario, $totalDelPedido);
        mysqli_stmt_execute($consultaPreparada);
        return mysqli_insert_id($this->conexion); // Devuelve el ID del pedido recién creado.
    }

    // Agrega un detalle de pedido a la base de datos.
    public function agregarDetallePedido($idPedido, $idProducto, $cantidad, $precioUnitario) {
        $consultaSql = "INSERT INTO Detalle_Producto (id_pedido, id_producto, cantidad, precio) VALUES (?, ?, ?, ?)";
        $consultaPreparada = mysqli_prepare($this->conexion, $consultaSql);
        mysqli_stmt_bind_param($consultaPreparada, "iiid", $idPedido, $idProducto, $cantidad, $precioUnitario);
        mysqli_stmt_execute($consultaPreparada);
        mysqli_stmt_close($consultaPreparada);
    }

    // Lista todos los pedidos de un usuario específico.
    public function listarPorUsuario($idUsuario) {
    $consultaSql = "SELECT id_pedido, fecha, estado, total
                    FROM Pedido
                    WHERE id_usuario = ?
                    ORDER BY fecha DESC, id_pedido DESC";

    $consultaPreparada = mysqli_prepare($this->conexion, $consultaSql);
    mysqli_stmt_bind_param($consultaPreparada, "i", $idUsuario);
    mysqli_stmt_execute($consultaPreparada);

    $resultado = mysqli_stmt_get_result($consultaPreparada);
    $pedidos = [];

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $pedidos[] = $fila;
    }

    mysqli_stmt_close($consultaPreparada);

    return $pedidos;
}
}

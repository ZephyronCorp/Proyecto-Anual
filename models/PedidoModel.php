<?php

class PedidoModel {
    private $conexion;

    // Constructor: recibe la conexión a MySQL.
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Crea un nuevo pedido en la base de datos y devuelve el ID del pedido creado.
    public function crearPedido($idUsuario, $totalDelPedido, $envio) {
        $stmt = $this->conexion->prepare(
            "INSERT INTO pedido
            (id_usuario, fecha, total, envio_nombre, envio_direccion, envio_ciudad, envio_departamento, envio_telefono)
            VALUES (?, NOW(), ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "idsssss",
            $idUsuario, $totalDelPedido,
            $envio['nombre'], $envio['direccion'], $envio['ciudad'], $envio['departamento'], $envio['telefono']
        );
        $stmt->execute();
        return $this->conexion->insert_id; // Devuelve el ID del pedido recién creado.
    }

    // Agrega un detalle de pedido a la base de datos.
    public function agregarDetallePedido($idPedido, $idProducto, $cantidad, $precioUnitario) {
        $consultaSql = "INSERT INTO Detalle_Producto (id_pedido, id_producto, cantidad, precio) VALUES (?, ?, ?, ?)";
        $consultaPreparada = mysqli_prepare($this->conexion, $consultaSql);
        mysqli_stmt_bind_param($consultaPreparada, "iiid", $idPedido, $idProducto, $cantidad, $precioUnitario);
        mysqli_stmt_execute($consultaPreparada);
        mysqli_stmt_close($consultaPreparada);
    }

    public function obtenerPorId($idPedido, $idUsuario){
        $stmt = $this->conexion->prepare(
            "SELECT * FROM pedidos WHERE id = ? AND id_usuario = ?"
        );
        $stmt->bind_param("ii", $idPedido, $idUsuario);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Lista todos los pedidos de un usuario específico.
    public function listarPorUsuario($idUsuario) {
        $stmt = $this->conexion->prepare( "SELECT id_pedido, fecha, estado, total
                    FROM Pedido
                    WHERE id_usuario = ?
                    ORDER BY fecha DESC, id_pedido DESC");

        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        return $stmt->get_resutl->fetch(MYSQLI_ASSOC);
    }

    public function obtenerDetalle($idPedido){
        $stmt = $this->conexion->prepare(
        "SELECT p.nombre, d.cantidad, d.precio AS precio_unitario,
                (d.cantidad * d.precio) AS subtotal
         FROM Detalle_Producto d
         INNER JOIN Producto p ON p.id_producto = d.id_producto
         WHERE d.id_pedido = ?"
        );
        $stmt->bind_param("i", $idPedido);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }    

    public function cambiarEstado($idPedido, $estado){
        $stmt = $this->conexion->prepare("UPDATE pedido SET estado = ? WHERE id = ?");
        $stmt -> bind_param("si", $estado, $idPedido);
        if(!$stmt->execute()){
            throw new Exception("No se puedo actualizar el pedido.");
        }
    }

    public function crearPedidoCompleto($idUsuario, $total, $envio, $carrito){
        $this->conexion->begin_transaction();
        try {
            $idPedido = $this->crearPedido($idUsuario, $total, $envio);
            foreach ($carrito as $item){
                $this->agregarDetallePedido($idPedido,
                $item['id'],
                $item['cantidad'],
                $item['precio']); 
            }
            $this->conexion->commit();
            return $idPedido;
        } catch (Throwable $e ){
            $this->conexion->rollback();
            return false;
        }
    }
}

<?php
require_once __DIR__ . '/ProductoModel.php';

class PedidoModel {
    private $conexion;
    private $productoModel;
    // Constructor: recibe la conexión a MySQL.
    public function __construct($conexion) {
        $this->conexion = $conexion;
        $this -> productoModel = new ProductoModel($conexion);
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
            "SELECT * FROM pedido WHERE id_pedido = ? AND id_usuario = ?"
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
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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
        $stmt = $this->conexion->prepare("UPDATE pedido SET estado = ? WHERE id_pedido = ?");
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
            
                if (!$this-> productoModel -> descontarStock($item['id'], $item['cantidad'])) {
                throw new Exception("Stock insuficiente para el producto" . $item['id']);
                }
            }
            $this->conexion->commit();
            return $idPedido;
        } catch (Throwable $e ){
            $this->conexion->rollback();
            return false;
        }
    }

    // Métodos para el panel de administración.

    // Lista los pedidos con el nombre del cliente y filtros opcionales.
    public function listarAdmin($filtros = []) {
        $sql = "SELECT p.id_pedido, p.fecha, p.total, p.estado,
                    p.estado_envio, u.nombre AS cliente
                FROM Pedido p
                INNER JOIN Usuario u ON u.id_usuario = p.id_usuario
                WHERE 1=1";

        $tipos = '';
        $params = [];

        if (!empty($filtros['estado'])) {
            $sql .= " AND p.estado = ?";
            $tipos .= 's';
            $params[] = $filtros['estado'];
        }

        if (!empty($filtros['estado_envio'])) {
            $sql .= " AND p.estado_envio = ?";
            $tipos .= 's';
            $params[] = $filtros['estado_envio'];
        }

        if (!empty($filtros['desde'])) {
            $sql .= " AND p.fecha >= ?";
            $tipos .= 's';
            $params[] = $filtros['desde'];
        }

        if (!empty($filtros['hasta'])) {
            // Incluye todos los pedidos del último día elegido.
            $sql .= " AND p.fecha < DATE_ADD(?, INTERVAL 1 DAY)";
            $tipos .= 's';
            $params[] = $filtros['hasta'];
        }

        $sql .= " ORDER BY p.fecha DESC, p.id_pedido DESC";

        if (!empty($filtros['limite'])) {
            $sql .= " LIMIT " . (int)$filtros['limite'];
        }

        $stmt = $this->conexion->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($tipos, ...$params);
        }

        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Obtiene cualquier pedido con los datos de su cliente.
    public function obtenerParaAdmin($idPedido) {
        $stmt = $this->conexion->prepare(
            "SELECT p.*, u.nombre AS cliente_nombre,
                    u.email AS cliente_email
            FROM Pedido p
            INNER JOIN Usuario u ON u.id_usuario = p.id_usuario
            WHERE p.id_pedido = ?"
        );

        $stmt->bind_param("i", $idPedido);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // Cambia el envío solo si el pedido está pagado y conserva el estado esperado.
    public function cambiarEstadoEnvio($idPedido, $estadoActual, $estadoNuevo) {
        $stmt = $this->conexion->prepare(
            "UPDATE Pedido
            SET estado_envio = ?
            WHERE id_pedido = ?
                AND estado = 'pagado'
                AND estado_envio = ?"
        );

        $stmt->bind_param("sis", $estadoNuevo, $idPedido, $estadoActual);
        $stmt->execute();

        return $stmt->affected_rows === 1;
    }

    // Cuenta los pedidos y suma sus importes por estado de pago.
    public function resumenPorEstado($desde, $hasta) {
        $stmt = $this->conexion->prepare(
            "SELECT estado, COUNT(*) AS cantidad, SUM(total) AS total
            FROM Pedido
            WHERE fecha >= ?
                AND fecha < DATE_ADD(?, INTERVAL 1 DAY)
            GROUP BY estado"
        );

        $stmt->bind_param("ss", $desde, $hasta);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

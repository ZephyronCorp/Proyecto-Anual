<?php

require_once __DIR__ . '/../models/ProductoModel.php';
require_once __DIR__ . '/../models/PedidoModel.php';
require_once __DIR__ . '/../models/MensajeModel.php';

class AdminController {
    private $conexion;
    private $productoModel;
    private $pedidoModel;
    private $mensajeModel;

    public function __construct($conexion) {
        requerirRol(1);

        $this->conexion = $conexion;
        $this->productoModel = new ProductoModel($conexion);
        $this->pedidoModel = new PedidoModel($conexion);
        $this->mensajeModel = new MensajeModel($conexion);
    }

    public function panel() {
        $nombreAdmin = usuarioActualNombre();

        $productosStockBajo = $this->productoModel->listarStockBajo();

        // Los cinco pedidos más recientes.
        $ultimosPedidos = $this->pedidoModel->listarAdmin([
            'limite' => 5
        ]);

        // Pedidos pagados que todavía están preparando.
        $pedidosPorEnviar = $this->pedidoModel->listarAdmin([
            'estado' => 'pagado',
            'estado_envio' => 'preparando'
        ]);

        // Cantidad de consultas que todavía no tienen respuesta.
        $mensajesSinResponder = $this->mensajeModel->contarSinResponder();

        require __DIR__ . '/../views/admin.php';
    }
}
?>
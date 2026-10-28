<?php

require_once __DIR__ . '/../models/ProductoModel.php';
require_once __DIR__ . '/../models/PedidoModel.php';

class AdminController {
    private $conexion;
    private $productoModel;
    private $pedidoModel;

    public function __construct($conexion) {
        requerirRol(1);

        $this->conexion = $conexion;
        $this->productoModel = new ProductoModel($conexion);
        $this->pedidoModel = new PedidoModel($conexion);
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

        require __DIR__ . '/../views/admin.php';
    }
}
?>

<?php

class PedidoController {
    private $conexion;
    private $pedidoModel;

    public function __construct($conexion) {
        $this->conexion = $conexion;
        $this->pedidoModel = new PedidoModel($conexion);
    }

    public function confirmarPedido() {

        // Comprobamos que el carrito haya sido enviado.
        if (!isset($_POST['carritoJson']) || empty($_POST['carritoJson'])) {
            header('Location: index.php?pagina=carrito');
            exit;
        }

        $carritoRecibido = json_decode($_POST['carritoJson'], true);

        if (empty($carritoRecibido)) {
            header('Location: index.php?pagina=carrito');
            exit;
        }

       // Usuario de prueba mientras implementamos el login.
        $idUsuario = 1;

        // Calculamos el total del pedido.
        $totalDelPedido = 0;
        foreach ($carritoRecibido as $itemDelCarrito) {
            $totalDelPedido += $itemDelCarrito['precio'] * $itemDelCarrito['cantidad'];
        }

        // Creamos el pedido.
        $idPedidoCreado = $this->pedidoModel->crearPedido($idUsuario);

        // Guardamos los productos del pedido.
        foreach ($carritoRecibido as $itemDelCarrito) {
            $this->pedidoModel->agregarDetallePedido(
                $idPedidoCreado,
                $itemDelCarrito['id'],
                $itemDelCarrito['cantidad'],
                $itemDelCarrito['precio']
            );
        }

        // Mostramos la confirmación.
        require __DIR__ . '/../views/pedido_confirmado.php';
    }
}

<?php

require_once __DIR__ . '/../models/PedidoModel.php';
require_once __DIR__ . '/../models/PagoModel.php';

class AdminPedidoController {
    private $conexion;
    private $pedidoModel;
    private $pagoModel;

    // Estados permitidos.
    private $estadosPago = ['pendiente', 'pagado', 'rechazado'];
    private $estadosEnvio = ['preparando', 'enviado', 'entregado'];

    // Siguiente paso permitido para el envío.
    private $siguienteEnvio = [
        'preparando' => 'enviado',
        'enviado' => 'entregado'
    ];

    // Mensajes permitidos.
    private $avisos = [
        'envio_ok' => [
            'tipo' => 'exito',
            'texto' => 'El estado de envío fue actualizado.'
        ],
        'invalido' => [
            'tipo' => 'error',
            'texto' => 'No se pudo realizar la acción: los datos no son válidos.'
        ],
        'transicion' => [
            'tipo' => 'error',
            'texto' => 'Ese cambio de estado no está permitido para este pedido.'
        ],
        'sin_factura' => [
            'tipo' => 'error',
            'texto' => 'Solo se puede facturar un pedido pagado.'
        ],
        'fallo' => [
            'tipo' => 'error',
            'texto' => 'Ocurrió un problema al guardar el cambio. Intentá de nuevo.'
        ]
    ];

    public function __construct($conexion) {
        requerirRol(1);

        $this->conexion = $conexion;
        $this->pedidoModel = new PedidoModel($conexion);
        $this->pagoModel = new PagoModel($conexion);
    }

    // Lista los pedidos con filtros opcionales.
    public function listar() {
        $filtroEstado = $this->leerOpcion('estado', $this->estadosPago);
        $filtroEnvio = $this->leerOpcion('estado_envio', $this->estadosEnvio);

        $pedidos = $this->pedidoModel->listarAdmin([
            'estado' => $filtroEstado,
            'estado_envio' => $filtroEnvio
        ]);

        $estadosPago = $this->estadosPago;
        $estadosEnvio = $this->estadosEnvio;
        $aviso = $this->leerAviso();

        require __DIR__ . '/../views/admin/pedidos_lista.php';
    }

    // Muestra el detalle de un pedido.
    public function ver() {
        $idPedido = $this->leerIdDeLaUrl();

        $pedido = ($idPedido !== null)
            ? $this->pedidoModel->obtenerParaAdmin($idPedido)
            : null;

        if (!$pedido) {
            redirigir('admin_pedidos', '&msg=invalido');
        }

        $detalle = $this->pedidoModel->obtenerDetalle($pedido['id_pedido']);
        $pago = $this->pagoModel->obtenerAprobado($pedido['id_pedido']);
        $siguiente = $this->siguienteEnvio[$pedido['estado_envio']] ?? null;
        $aviso = $this->leerAviso();

        require __DIR__ . '/../views/admin/pedido_detalle.php';
    }

    // Avanza el estado de envío de un pedido.
    public function cambiarEnvio() {
        // Solo se permite modificar mediante POST.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirigir('admin_pedidos');
        }

        $idPedido = $this->leerIdDeLaUrl();
        $nuevo = $_POST['nuevo'] ?? '';

        if ($idPedido === null ||!in_array($nuevo, $this->estadosEnvio, true)) {
            redirigir('admin_pedidos', '&msg=invalido');
        }

        // Comprueba que el pedido exista.
        $pedido = $this->pedidoModel->obtenerParaAdmin($idPedido);

        if (!$pedido) {
            redirigir('admin_pedidos', '&msg=invalido');
        }

        $volver = '&id=' . $idPedido;

        // Solo se puede enviar un pedido pagado.
        if ($pedido['estado'] !== 'pagado') {
            redirigir('admin_pedido_detalle', $volver . '&msg=transicion');
        }

        // Solo se permite avanzar al siguiente estado.
        $esperado = $this->siguienteEnvio[$pedido['estado_envio']] ?? null;

        if ($esperado !== $nuevo) {
            redirigir('admin_pedido_detalle', $volver . '&msg=transicion');
        }

        if ($this->pedidoModel->cambiarEstadoEnvio(
            $idPedido,
            $pedido['estado_envio'],
            $nuevo
        )) {
            redirigir('admin_pedido_detalle', $volver . '&msg=envio_ok');
        }

        redirigir('admin_pedido_detalle', $volver . '&msg=fallo');
    }

    // Muestra la factura de cualquier pedido pagado.
    public function factura() {
        $idPedido = $this->leerIdDeLaUrl();

        $pedido = ($idPedido !== null)
            ? $this->pedidoModel->obtenerParaAdmin($idPedido)
            : null;

        if (!$pedido) {
            redirigir('admin_pedidos', '&msg=invalido');
        }

        // Solo se pueden facturar pedidos pagados.
        if ($pedido['estado'] !== 'pagado') {
            redirigir(
                'admin_pedido_detalle',
                '&id=' . (int)$pedido['id_pedido'] . '&msg=sin_factura'
            );
        }

        $detalle = $this->pedidoModel->obtenerDetalle($pedido['id_pedido']);
        $pago = $this->pagoModel->obtenerAprobado($pedido['id_pedido']);

        $numeroFactura = str_pad(
            $pedido['id_pedido'],
            6,
            '0',
            STR_PAD_LEFT
        );

        // Nombre del comprador, obtenido desde la base.
        $cliente = $pedido['cliente_nombre'];

        $urlVolver = 'index.php?pagina=admin_pedido_detalle&id='
            . (int)$pedido['id_pedido'];

        require __DIR__ . '/../views/factura.php';
    }

    // Lee el ID de la URL y devuelve un entero positivo o null.
    private function leerIdDeLaUrl() {
        $idPedido = filter_var(
            $_GET['id'] ?? null,
            FILTER_VALIDATE_INT
        );

        return ($idPedido !== false && $idPedido > 0)
            ? $idPedido
            : null;
    }

    // Acepta un filtro solamente si está en la lista permitida.
    private function leerOpcion($clave, $permitidos) {
        $valor = $_GET[$clave] ?? '';

        return (is_string($valor) && in_array($valor, $permitidos, true))
            ? $valor
            : '';
    }

    // Obtiene el aviso de la lista de mensajes permitidos.
    private function leerAviso() {
        $clave = $_GET['msg'] ?? '';

        return (is_string($clave) && isset($this->avisos[$clave]))
            ? $this->avisos[$clave]
            : null;
    }
}
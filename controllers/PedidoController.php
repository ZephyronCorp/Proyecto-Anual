<?php

require_once __DIR__ . '/../models/PagoModel.php';
require_once __DIR__ . '/../models/PedidoModel.php';
require_once __DIR__ . '/../models/ProductoModel.php';

class PedidoController {
    private $conexion;
    private $pedidoModel;
    private $pagoModel;
    private $productoModel;

    private $departamentos = 
        [
        'Artigas', 'Canelones', 'Cerro Largo', 'Colonia', 'Durazno', 'Flores',
        'Florida', 'Lavalleja', 'Maldonado', 'Montevideo', 'Paysandú',
        'Río Negro', 'Rivera', 'Rocha', 'Salto', 'San José', 'Soriano',
        'Tacuarembó', 'Treinta y Tres'
        ];

    public function __construct($conexion) {
        $this->conexion = $conexion;
        $this->pedidoModel = new PedidoModel($conexion);
        $this->pagoModel = new PagoModel($conexion);
        $this->productoModel = new ProductoModel($conexion);
    }

    public function checkout(){
    requerirLogin();

    // 1) Leer los productos y cantidades del carrito.
    $items = $this->leerCarrito();
    if (empty($items)) {
        redirigir('carrito');
    }

    // 2) Obtener precios y total desde la base de datos.
    $datos = $this->calcularCarrito($items);
    if ($datos === null) {
        redirigir('carrito');
    }
    $carrito = $datos['carrito'];
    $total = $datos['total'];

    // 3) Variables que usa la vista.
    $departamentos = $this->departamentos;
    $carritoJson = json_encode($items);
    $errores = [];
    $envio = [
        'nombre' => '', 'direccion' => '', 'ciudad' => '',
        'departamento' => '', 'telefono' => ''
    ];

    // 4) ¿Enviaron el formulario de dirección?
    if (isset($_POST['confirmar'])) {
        $envio = [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'direccion' => trim($_POST['direccion'] ?? ''),
            'ciudad' => trim($_POST['ciudad'] ?? ''),
            'departamento' => trim($_POST['departamento'] ?? ''),
            'telefono' => preg_replace('/\D/', '', $_POST['telefono'] ?? '')
        ];

        $errores = $this->validarEnvio($envio);

        // 5) Crear el pedido si no hay errores.
        if (empty($errores)) {
            $idPedido = $this->pedidoModel->crearPedidoCompleto(
                usuarioActualId(), $total, $envio, $carrito
            );

            if ($idPedido) {
                redirigir('pago', '&id=' . (int)$idPedido);
            }

            $errores[] = 'No pudimos crear el pedido. Intentá de nuevo.';
        }
    }

    require __DIR__ . '/../views/checkout.php';
    }

    public function pagar(){
        $pedido = $this->obtenerPedidoDelUsuario();

        // Si ya está pagado, no tiene sentido volver a cobrar.
        if ($pedido['estado'] === 'pagado') {
            redirigir('pago_resultado', '&id=' . $pedido['id_pedido']);
        }

        $errores = [];
        $titular = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titular = trim($_POST['titular'] ?? '');
            $numero = preg_replace('/\D/', '', $_POST['numero'] ?? '');
            $vencimiento = trim($_POST['vencimiento'] ?? '');
            $cvv = $_POST['cvv'] ?? '';

            $errores = $this->validarTarjeta($titular, $numero, $vencimiento, $cvv);

            if (empty($errores)) {
                $resultado = $this->simularPasarela($numero);

                $ok = $this->pagoModel->registrarIntento(
                    $pedido['id_pedido'],
                    $pedido['total'], 
                    substr($numero, -4),
                    $resultado
                );
                
                if($ok){
                    redirigir('pago_resultado', '&id=' . $pedido['id_pedido']);
                }
                $errores[] = 'Ocurrió un problema al procesar el pago. Intentá de nuevo.';
            }
        }

        require __DIR__ . '/../views/pago.php';
    }

    public function resultado() {
        $pedido = $this->obtenerPedidoDelUsuario();

        // Todavía no se intentó pagar: lo mandamos a pagar.
        if ($pedido['estado'] === 'pendiente') {
            redirigir('pago', '&id=' . $pedido['id_pedido']);
        }

        require __DIR__ . '/../views/pago_resultado.php';
    }

    public function misPedidos() {
    
    requerirLogin(); // Aseguramos que el usuario esté logueado antes de mostrar sus pedidos.

    //
    $idUsuario = usuarioActualId();

    $pedidos = $this->pedidoModel->listarPorUsuario($idUsuario);

    require __DIR__ . '/../views/misPedidos.php';
    }

    public function verPedido(){
        $pedido = $this->obtenerPedidoDelUsuario();
        $detalle = $this->pedidoModel->obtenerDetalle($pedido['id_pedido']);
        require __DIR__ . '/../views/pedido_detalle.php';
    }

    public function factura(){
        $pedido = $this->obtenerPedidoDelUsuario();

        //Solo se factura lo que estas pagando
        if ($pedido['estado'] !== 'pagado') {
            redirigir('pedido-detalle','&id=' . $pedido['id_pedido']);
        }

        $detalle = $this->pedidoModel->obtenerDetalle($pedido['id_pedido']);
        $pago = $this->pagoModel->obtenerAprobado($pedido['id_pedido']);
        $numeroFactura = str_pad($pedido['id_pedido'], 6, '0', STR_PAD_LEFT); // 000005
        $cliente = usuarioActualNombre();
        $urlVolver = 'index.php?pagina=pedido-detalle&id=' . (int)$pedido['id_pedido'];

        require __DIR__ . '/../views/factura.php';
    }
    // Lee carritoJson (POST) y devuelve [['id' => 5, 'cantidad' => 2], ...]
    // Si algún dato no es válido, devuelve un arreglo vacío.
    private function leerCarrito() {
        $json = $_POST['carritoJson'] ?? '';
        if (!is_string($json)) {
            return [];
        }
        $lista = json_decode($json, true);
        if (!is_array($lista)) {
            return [];
        }
        $items = [];
        foreach ($lista as $item) {
            $id = filter_var($item['id'] ?? null, FILTER_VALIDATE_INT);
            $cantidad = filter_var($item['cantidad'] ?? null, FILTER_VALIDATE_INT);
            if ($id === false || $id < 1 || $cantidad === false || $cantidad < 1) {
                return []; // un solo dato inválido invalida todo el carrito
            }
            $items[] = ['id' => $id, 'cantidad' => $cantidad];
        }
        return $items;
    }
    
    // Busca cada producto en la base y calcula el total.
    // Devuelve null si algún producto no existe.
    private function calcularCarrito($items) {
        $carrito = [];
        $total = 0;
        foreach ($items as $item) {
            $producto = $this->productoModel->obtenerProductoPorId($item['id']);
            if (!$producto) {
                return null;
            }
            if($item['cantidad'] > (int)$producto['stock']){
                return null;
            }
        $precio = (float)$producto['precio']; // el precio sale de la BASE
        $carrito[] = ['id'=> $item['id'],
            'nombre' => $producto['nombre'],
            'cantidad' => $item['cantidad'],
            'precio' => $precio
        ];
        $total += $precio * $item['cantidad'];
        }
        return ($total > 0) ? ['carrito' => $carrito, 'total' => $total] : null;
    }

    // Devuelve la lista de errores del formulario de envío
    private function validarEnvio($envio) {
        $errores = [];
        if (!$this->largoEntre($envio['nombre'], 3, 60)) {
            $errores[] = 'El nombre debe tener entre 3 y 60 caracteres.';
        }
        if (!$this->largoEntre($envio['direccion'], 5, 100)) {
            $errores[] = 'La dirección debe tener entre 5 y 100 caracteres.';
        }
        if (!$this->largoEntre($envio['ciudad'], 2, 50)) {
            $errores[] = 'La ciudad debe tener entre 2 y 50 caracteres.';
        }
        if (!in_array($envio['departamento'], $this->departamentos, true)) {
            $errores[] = 'Elegí un departamento de la lista.';
        }
        if (!$this->largoEntre($envio['telefono'], 8, 12)) {
            $errores[] = 'El teléfono debe tener entre 8 y 12 dígitos.';
        }
    return $errores;
    }
    // Devuelve la lista de errores del formulario de tarjeta.
    private function validarTarjeta($titular, $numero, $vencimiento, $cvv) {
        $errores = [];

        if (!$this->largoEntre($titular, 3, 60)) {
            $errores[] = 'El nombre del titular debe tener entre 3 y 60 caracteres.';
        }

        if (strlen($numero) !== 16) {
            $errores[] = 'El número de tarjeta debe tener 16 dígitos.';
        }

        if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $vencimiento)) {
            $errores[] = 'El vencimiento debe tener el formato MM/AA.';
        } else {
            $vence = DateTime::createFromFormat('!m/y', $vencimiento);
            $vence->modify('last day of this month')->setTime(23, 59, 59);

            if ($vence < new DateTime()) {
                $errores[] = 'La tarjeta está vencida.';
            }
        }

        if (!preg_match('/^\d{3}$/', $cvv)) {
            $errores[] = 'El código de seguridad debe tener 3 dígitos.';
        }

        return $errores;
    
    }   
    // ¿El texto tiene entre $min y $max caracteres?
    private function largoEntre($texto, $min, $max) {
        $largo = mb_strlen($texto);
        return $largo >= $min && $largo <= $max;
    }

    private function simularPasarela($numeroTarjeta) {
        $ultimoDigito = (int)substr($numeroTarjeta, -1);
        return ($ultimoDigito % 2 === 0) ? 'aprobado' : 'rechazado';
    }
    private function obtenerPedidoDelUsuario(){
        requerirLogin();

        $idPedido = (int)($_GET['id'] ?? 0);
        $pedido = $this ->pedidoModel->obtenerPorId($idPedido,usuarioActualId());

        if(!$pedido){
            //Mismo mensaje si no existe o si es de otro
            http_response_code(403);
            require __DIR__ . '/../views/sin_permiso.php';
            exit;
        }
        return $pedido;
    }
}
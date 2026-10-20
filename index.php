<?php
//Conexion a la base de datos.
require_once __DIR__ . '/config/conexion.php';

//Clases de modelos que vamos a necesitar en distintas páginas.
require_once __DIR__ . '/models/ProductoModel.php';
require_once __DIR__ . '/models/PedidoModel.php';
//require_once __DIR__ . '/models/UsuarioModel.php';

//Clases de controllers.
require_once __DIR__ . '/controllers/ProductoController.php';
require_once __DIR__ . '/controllers/PedidoController.php';
//require_once __DIR__ . '/controllers/UsuarioController.php';

//Pagina solicitada por el usuario.
$paginaSolicitada = isset($_GET['pagina']) ? $_GET['pagina'] : 'home';

switch ($paginaSolicitada) {
    case 'home':
    require __DIR__ . '/views/home.php';
    break;

    case 'catalogo':
    $productoController = new ProductoController($conexion);
    $productoController->mostrarCatalogo();
    break;

    case 'producto':
        $productoController = new ProductoController($conexion);
        $productoController->mostrarDetalle();
        break;

    case 'carrito':
        require __DIR__ . '/views/Carrito.php';
        break;

    case 'confirmar-pedido':
        $pedidoController = new PedidoController($conexion);
        $pedidoController->confirmarPedido();
        break;

    case 'registro':
        require __DIR__ . '/views/register.php';
        break;

    case 'login':
        require __DIR__ . '/views/login.php';
        break;

    default:
        http_response_code(404);
        echo "Página no encontrada";
        break;
}
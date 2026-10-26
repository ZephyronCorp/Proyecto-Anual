<?php
session_start();
//Conexion a la base de datos y autenticación.
require_once __DIR__ . '/config/conexion.php';
require_once __DIR__ . '/config/auth.php';

//Clases de modelos que vamos a necesitar en distintas páginas.
require_once __DIR__ . '/models/ProductoModel.php';
require_once __DIR__ . '/models/PedidoModel.php';
require_once __DIR__ . '/models/UsuarioModel.php';

//Clases de controllers.
require_once __DIR__ . '/controllers/ProductoController.php';
require_once __DIR__ . '/controllers/PedidoController.php';
require_once __DIR__ . '/controllers/UsuarioController.php';
require_once __DIR__ . '/controllers/AdminController.php';
require_once __DIR__ . '/controllers/AdminProductoController.php';

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

    case 'checkout':
        (new PedidoController($conexion)) -> checkout();
        break;

    case 'registro':
        $controladorUsuario = new UsuarioController($conexion);
        $controladorUsuario->registro();
        break;

    case 'login':
        $controladorUsuario = new UsuarioController($conexion);
        $controladorUsuario->login();
        break;
    
    case 'logout':
        $controladorUsuario = new UsuarioController($conexion);
        $controladorUsuario->logout();
        break;
        
    case 'mis-pedidos':
        $pedidoController = new PedidoController($conexion);
        $pedidoController->misPedidos();
        break;

    case 'pedido-detalle':
        $pedidoController = new PedidoController($conexion);
        $pedidoController->verPedido();
        break;
    
    case 'admin':
        (new AdminController($conexion))->panel();
        break;
    
    case 'pago':
        (new PedidoController($conexion)) -> pagar();
        break;
    
    case 'pago_resultado':
        (new PedidoController($conexion))->resultado();
        break;
    
    case 'factura':
        (new PedidoController($conexion)) -> factura();
        break;
    
    case 'admin_productos':
        (new AdminProductoController($conexion)) -> listar();
        break;
    case 'admin_producto_crear':
        (new AdminProductoController($conexion)) -> crear();
        break;
    case 'admin_producto_editar':
        (new AdminProductoController($conexion)) -> editar();
        break;
    case 'admin_producto_estado':
        (new AdminProductoController($conexion)) -> cambiarEstado();
        break;
    
    case 'sin_permiso':
        require __DIR__ . '/views/sin_permiso.php';
        break;
    default:
        http_response_code(404);
        echo "<h1>Página no encontrada</h1>";
        break;
}
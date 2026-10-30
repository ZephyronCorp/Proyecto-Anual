<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona Joystick</title>
    <link rel="stylesheet" href="/Proyecto-Anual/public/css/<?php echo $css ?>">
    <link rel="stylesheet" href="/Proyecto-Anual/public/css/mensaje.css">
    <link rel="icon" href="/Proyecto-Anual/public/img/favicon.ico" type="image/x-icon">
</head>

<body>
    <!-- Header con logo y barra de navegación. -->
    <header>
        <div class="header-izquierda">
            <a href="/Proyecto-Anual/index.php?pagina=home"><img src="/Proyecto-Anual/public/img/Logo completo.png" alt="Logo empresa" class="logo"></a>

            <nav class="menu">
                <a href="/Proyecto-Anual/index.php?pagina=catalogo">Catálogo</a>
            </nav>
        </div>
        <div class="header-derecha">
            <?php if (estaLogueado()):?>
                <span class="usuario">Bienvenido, <?= escapar(usuarioActualNombre()) ?></span>
                <?php if (esAdmin()):?>
                    <a href="/Proyecto-Anual/index.php?pagina=admin" class="admin">Panel de administración</a>
                <?php endif;?>
                <a href="index.php?pagina=mis-pedidos">Mis pedidos</a>    
                <a href="/Proyecto-Anual/index.php?pagina=logout" class="logout">Cerrar sesión</a>
                <a href="/Proyecto-Anual/index.php?pagina=carrito"><img src="/Proyecto-Anual/public/img/Carrito-De-Compras.png" alt="Carrito de compras" class="carrito"></a>
            <?php else: ?>
                <a href="/Proyecto-Anual/index.php?pagina=login" class="login">Ingresar</a>
                <a href="/Proyecto-Anual/index.php?pagina=registro" class="register">Registrarse</a>
                <a href="/Proyecto-Anual/index.php?pagina=carrito"><img src="/Proyecto-Anual/public/img/Carrito-De-Compras.png" alt="Carrito de compras" class="carrito"></a>
            <?php endif; ?>
        </div>
    </header>
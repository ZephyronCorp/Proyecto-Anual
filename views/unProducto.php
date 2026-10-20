<!--
Autor: Franco Pirez
Ultima actualizacion: 29/08/2026
-->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Proyecto-Anual/public/css/unProducto.css">
    <link rel="icon" href="/Proyecto-Anual/public/img/favicon.ico" type="image/x-icon" sizes="512x512">
    <title>Astro Bot</title>
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
            <a href="/Proyecto-Anual/index.php?pagina=login" class="login">Ingresar</a>
            <a href="/Proyecto-Anual/index.php?pagina=register" class="register">Registrarse</a>
            <a href="/Proyecto-Anual/index.php?pagina=carrito"><img src="/Proyecto-Anual/public/img/Carrito-De-Compras.png" alt="Carrito de compras" class="carrito"></a>
        </div>
    </header>

    <!-- Contenido principal de la página -->
    
    <main>
        <nav class="breadcrumb">

            <a href="/Proyecto-Anual/index.php?pagina=home">Inicio</a>
            <span>></span>
            <a href="/Proyecto-Anual/index.php?pagina=catalogo">Catálogo</a>
            <span>></span>
            <span><?php echo htmlspecialchars($producto['nombre']); ?></span>
            
        </nav>

        <section class ="producto">

            <div class="imagenes">
                <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
            </div>

            <div class="info-producto">

                <h1><?php echo htmlspecialchars($producto['nombre']); ?></h1>
                <p class="precio">$<?php echo number_format($producto['precio'], 0, ',', '.'); ?></p>

                <div class="stock">
                    <p><strong>Disponibilidad</strong>: <?php echo $producto['stock']; ?> artículos disponibles.</p>
                </div>

                <div>
                    <button
                        id="carrito-btn"
                        data-id="<?php echo $producto['id_producto']; ?>"
                        data-nombre="<?php echo htmlspecialchars($producto['nombre']); ?>"
                        data-precio="<?php echo $producto['precio']; ?>"
                        <?php echo ($producto['stock'] <= 0) ? 'disabled' : ''; ?>>
                        Agregar al carrito
                    </button>
                </div>
            </div>

        </section>

        <section class="desc-producto">

            <h2>Descripción</h2>
            <br>

            <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>

        </section>

        <!-- Sección con los productos relacionados -->
        
        <h2>Productos Relacionados</h2>
        <section class="productos-relacionados">
            <article class="tarjeta1">
                <img src="public/img/JuegoRE9.jpg" alt="Resident 9 Requiem PS5">
                <h4>Resident 9 Requiem</h4>
            </article>
            <article class="tarjeta2">
                <img src="public/img/AstroBotFunko.png" alt="Funko Pop Leon S Kennedy">
                <h4>Funko Pop Astro Bot</h4>
            </article>
            <article class="tarjeta3">
                <img src="public/img/GOWRag.jpg" alt="God of War: Ragnarok PS5">
                <h4>God of War: Ragnarok</h4>
            </article>
        </section>
    </main>
    <!-- Pie de página -->
    <footer>
        <hr>
        <h3>Contacto</h3>

        <p>Correo electrónico: zonajoystick26@gmail.com</p>

        <p>Teléfono: +589 97 951 885</p>

        <p>Centro, Montevideo Uruguay</p>
        <p>&copy; Creado por Zephyron Corp.</p>
    </footer>

    <div id="mensaje-flotante" class="mensaje-flotante"></div>
    <script src="/Proyecto-Anual/public/js/storage.js"></script>
    <script src="/Proyecto-Anual/public/js/catalogo.js"></script>
</body>
</html>

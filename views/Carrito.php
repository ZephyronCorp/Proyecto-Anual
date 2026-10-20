<!--
Autor: Franco Pirez
Ultima actualizacion: 30/08/2026
-->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="/Proyecto-Anual/public/css/carrito.css">
    <link rel="icon" href="/Proyecto-Anual/public/img/favicon.ico" type="image/x-icon">
</head>

<body>
    <header>
        <div class="header-izquierda">
            <a href="/Proyecto-Anual/index.php?pagina=home">
                <img src="/Proyecto-Anual/public/img/Logo completo.png" alt="Logo empresa" class="logo">
            </a>

            <nav class="menu">
                <a href="/Proyecto-Anual/index.php?pagina=catalogo">Catálogo</a>
            </nav>
        </div>
        <div class="header-derecha">
            <a href="/Proyecto-Anual/index.php?pagina=login" class="login">Ingresar</a>
            <a href="/Proyecto-Anual/index.php?pagina=registro" class="register">Registrarse</a>
            <a href="/Proyecto-Anual/index.php?pagina=carrito"><img src="/Proyecto-Anual/public/img/Carrito-De-Compras.png" alt="Carrito de compras" class="carrito"></a>
        </div>
    </header>
    <main class="pagina-carrito">
        <h1>Tu carrito</h1>
        <section class="contenido-carrito">
            <!-- Acá JavaScript va a agregar los productos -->
            <div class="lista-carrito" id="lista-carrito">
            </div>

            <aside class="resumen-carrito">
                <h2>Resumen</h2>
                <p>Productos: <span id="cantidad-productos">0</span></p>
                <p>Total:<span id="total">$0</span></p>
                <button id="finalizar-compra">Finalizar compra</button>
            </aside>
        </section>
    </main>

    <footer>
        <hr>

        <h3>Contacto</h3>

        <p>Correo electrónico: zonajoystick26@gmail.com</p>

        <p>Teléfono: +598 97 951 885</p>

        <p>Centro, Montevideo Uruguay</p>

        <p>&copy; Creado por Zephyron Corp</p>
    </footer>
    <script src="/Proyecto-Anual/public/js/storage.js"></script>
    <script src="/Proyecto-Anual/public/js/carrito.js"></script>
</body>
</html>
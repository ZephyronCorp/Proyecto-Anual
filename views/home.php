<!--
Autor: Dante La Banca
Ultima actualizacion: 29/08/2026
-->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona Joystick</title>
    <link rel="stylesheet" href="/Proyecto-Anual/public/css/style.css">
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
            <a href="/Proyecto-Anual/index.php?pagina=login" class="login">Ingresar</a>
            <a href="/Proyecto-Anual/index.php?pagina=registro" class="register">Registrarse</a>
            <a href="/Proyecto-Anual/index.php?pagina=carrito"><img src="/Proyecto-Anual/public/img/Carrito-De-Compras.png" alt="Carrito de compras" class="carrito"></a>
        </div>
    </header>

    <!-- Principal -->
    <main>
        <section class="banner">
            <img src="/Proyecto-Anual/public/img/Banner.png" alt="Banner Principal" width="1300" height="200"
                class="banner">
        </section>
        <section class="catalogo">
            <h2>Categorías</h2>
            <div class="categorias">
                <div class="categoria">
                    <a href="/Proyecto-Anual/index.php?pagina=catalogo#figuras"><img src="/Proyecto-Anual/public/img/Logo-Catalogo-Figuras.png" alt="Figuras"></a>
                    <p>Figuras</p>
                </div>
                <div class="categoria">
                    <a href="/Proyecto-Anual/index.php?pagina=catalogo#juegos"><img src="/Proyecto-Anual/public/img/Logo-Catalogo-Videojuegos.png" alt="Juegos"></a>
                    <p>Videojuegos</p>
                </div>
                <div class="categoria">
                    <a href="/Proyecto-Anual/index.php?pagina=catalogo#indumentaria"><img src="/Proyecto-Anual/public/img/Logo-Catalogo-Indumentaria.png" alt="Indumentaria"></a>
                    <p>Indumentaria</p>
                </div>
                <div class="categoria">
                    <a href="/Proyecto-Anual/index.php?pagina=catalogo#cartas-tcg"><img src="/Proyecto-Anual/public/img/Logo-Catalogo-Tcg.png" alt="Cartas TCG"></a>
                    <p>Cartas TCG</p>
                </div>
            </div>
        </section>
        <section class="productos">
            <h2>Productos Destacados</h2>
            <div class="productos-destacados">
                <div class="card">
                    <img src="/Proyecto-Anual/public/img/Figura-Izuku.jpg" alt="Figura Izuku">
                    <p>Figura</p>
                    <h3>Figura Izuku</h3>
                    <p class = "precio">$250USD</p>
                </div>
                <div class="card">
                    <img src="/Proyecto-Anual/public/img/GTAVI.png" alt="Juego fisico Grand Theft Auto VI">
                    <p>Videojuego</p>
                    <h3>Grand Theft Auto VI</h3>
                    <p class = "precio">$150USD</p>
                </div>
                <div class="card">
                    <img src="/Proyecto-Anual/public/img/Capa-Akatsuki.jpg" alt="Capa akatsuki">
                    <p>Indumentaria</p>
                    <h3>Capa Akatsuki</h3>
                    <p class = "precio">$600</p>
                </div>
                
                <div class="card">
                    <img src="/Proyecto-Anual/public/img/Pokemon-Trainer-Box.jpg" alt="Pokémon TCG: Mega Evolution-Ascended Heroes Pokémon Center Elite Trainer Box">
                    <p>Cartas TCG</p>
                    <h3>Pokémon TCG: Mega Evolution-Ascended Heroes Pokémon Center Elite Trainer Box</h3>
                    <p class = "precio">$150USD</p>
                </div>
                
                <div class="card">
                    <a href="/Proyecto-Anual/index.php?pagina=producto">
                    <img src="/Proyecto-Anual/public/img/AstroBotFunko.png" alt="Astro Bot PS5">
                    </a>
                    <p>Videojuego</p>
                    <a href="/Proyecto-Anual/index.php?pagina=producto"><h3>Astro Bot PS5</h3></a>
                    <p class = "precio">$50USD</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Pie de página -->

    <footer>
        <hr>
        <h3>Contacto</h3>
        <p>
            Correo electrónico: zonajoystick26@gmail.com
        </p>
        <p>
            Teléfono: +598 97 951 885
        </p>
        <p>
            Centro, Montevideo Uruguay
        </p>
        <p>
            &copy; Creado por Zephyron Corp
        </p>
    </footer>
</body>

</html>

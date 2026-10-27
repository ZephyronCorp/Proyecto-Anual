<!--Autor: Dante La Banca Ultima actualizacion: 29/08/2026-->
<?php
$css = "style.css";
require __DIR__ . '/header.php';?>
    <main>
        <section class="banner">
            <img src="/Proyecto-Anual/public/img/Banner.png" alt="Banner Principal" width="1300" height="200"
                class="banner">
        </section>
        <section class="catalogo">
            <h2>Categorías</h2>
            <div class="categorias">
                <div class="categoria">
                    <a href="/Proyecto-Anual/index.php?pagina=catalogo&categoria=2"><img src="/Proyecto-Anual/public/img/Logo-Catalogo-Figuras.png" alt="Figuras"></a>
                    <p>Figuras</p>
                </div>
                <div class="categoria">
                    <a href="/Proyecto-Anual/index.php?pagina=catalogo&categoria=1"><img src="/Proyecto-Anual/public/img/Logo-Catalogo-Videojuegos.png" alt="Juegos"></a>
                    <p>Videojuegos</p>
                </div>
                <div class="categoria">
                    <a href="/Proyecto-Anual/index.php?pagina=catalogo&categoria=3"><img src="/Proyecto-Anual/public/img/Logo-Catalogo-Indumentaria.png" alt="Indumentaria"></a>
                    <p>Indumentaria</p>
                </div>
                <div class="categoria">
                    <a href="/Proyecto-Anual/index.php?pagina=catalogo&categoria=4"><img src="/Proyecto-Anual/public/img/Logo-Catalogo-Tcg.png" alt="Cartas TCG"></a>
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
<?php require __DIR__ . '/footer.php'; ?>
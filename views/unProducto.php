<!--
Autor: Franco Pirez
Ultima actualizacion: 29/08/2026
-->
<?php
$css = "unProducto.css";
require __DIR__ . '/header.php';?>

        <nav class="breadcrumb">

            <a href="/Proyecto-Anual/index.php?pagina=home">Inicio</a>
            <span>></span>
            <a href="/Proyecto-Anual/index.php?pagina=catalogo">Catálogo</a>
            <span>></span>
            <span><?php echo htmlspecialchars($producto['nombre']); ?></span>
            
        </nav>

        <section class ="producto">

            <div class="imagenes">
                <img src="public/img/productos/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
            </div>

            <div class="info-producto">

                <h1><?php echo htmlspecialchars($producto['nombre']); ?></h1>
                <p class="precio">$<?php echo number_format($producto['precio'], 0, ',', '.'); ?></p>

                <div class="stock">
                    <p><strong>Disponibilidad</strong>: <?php echo $producto['stock']; ?> artículos disponibles.</p>
                </div>

                <div>
                    <?php if ((int) $producto['stock'] > 0): ?>
                    <button
                        id="carrito-btn"
                        data-id="<?php echo $producto['id_producto']; ?>"
                        data-nombre="<?php echo htmlspecialchars($producto['nombre']); ?>"
                        data-precio="<?php echo $producto['precio']; ?>"
                        <?php echo ($producto['stock'] <= 0) ? 'disabled' : ''; ?>>
                        Agregar al carrito
                    </button>
                    <?php else :?>
                        <span class = "stock stock-agotado">Sin stock</span>
                    <?php endif; ?>
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
                <img src="public/img/productos/JuegoRE9.jpg" alt="Resident 9 Requiem PS5">
                <h4>Resident 9 Requiem</h4>
            </article>
            <article class="tarjeta2">
                <img src="public/img/productos/AstroBotFunko.png" alt="Funko Pop Leon S Kennedy">
                <h4>Funko Pop Astro Bot</h4>
            </article>
            <article class="tarjeta3">
                <img src="public/img/productos/GOWRag.jpg" alt="God of War: Ragnarok PS5">
                <h4>God of War: Ragnarok</h4>
            </article>
        </section>
    </main>

    <div id="mensaje-flotante" class="mensaje-flotante"></div>

    <?php 
    $scriptExtra = 'public/js/catalogo.js';
    require __DIR__ . '/footer.php'; ?>
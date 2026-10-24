<!--Autor: Eric Leyes Ultima actualizacion: 02/09/2026-->

<?php
$css = "Catalogo.css";
require __DIR__ . '/header.php';?>

    <section class="hero">
        <h2>Elegí lo que te guste!</h2>
        <p>Videojuegos • Figuras • Manga • TCG</p>
    </section>
    
    <!-- Filtro por categoría -->
    <form action="index.php" method="GET" class="filtros">
        <input type="hidden" name="pagina" value="catalogo">

        <label for="selectorCategoria">Filtrar por categoría:</label>
        <select name="categoria" id="selectorCategoria">
            <option value="">Todas las categorías</option>
            <?php foreach ($listaDeCategorias as $categoria): ?>
                <option 
                    value="<?php echo (int)$categoria['id_categoria']; ?>"
                    <?php echo ($idCategoriaSeleccionada == $categoria['id_categoria']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($categoria['nombre']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="boton">Filtrar</button>
    </form>

    <!-- Buscador de productos -->
    <form action="index.php" method="GET" class="buscador">
        <input type="hidden" name="pagina" value="catalogo">
        <?php if (!empty($idCategoriaSeleccionada)): ?>
            <input type="hidden" name="categoria"
            value="<?= escapar($idCategoriaSeleccionada) ?>">
        <?php endif; ?>
        <label for="q">Buscar productos</label>
        <input type="text" id="q" name="q" maxlength="50" placeholder="Ej: ..." value="<?= escapar($busqueda) ?>">
        <input type="submit" value="Buscar">
    </form>

    <?php if ($busqueda !== ''): ?>
        <p class="resumen-busqueda">
        <?= count($listaDeProductos) ?> resultado(s) para
        "<strong><?= escapar($busqueda) ?></strong>"
        — <a href="index.php?pagina=catalogo<?= !empty($idCategoriaSeleccionada) ?
        '&categoria=' . urlencode($idCategoriaSeleccionada) : '' ?>">Limpiar búsqueda</a>
        </p>
    <?php endif; ?>
    <?php if (empty($listaDeProductos)): ?>
        <p class="sin-resultados">No encontramos productos con esos criterios.</p>
    <?php endif; ?>
    
    <!-- Sección de catálogo -->
    <section class="catalogo">
            <!-- Verificar si hay productos disponibles -->
            <?php if (empty($listaDeProductos)): ?>

            <?php else: ?>
                <!-- Mostrar cada producto en una tarjeta -->
                <?php foreach ($listaDeProductos as $producto): ?>
                    <?php
                        // Verificar si el producto está sin stock
                        $sinStock = $producto['stock'] == 0;
                    ?>
                    
                    <div class="card">
                        <div class="imagen-producto">
                            <a href="index.php?pagina=producto&id=<?php echo $producto['id_producto']; ?>">
                                <img
                                    src="<?php echo htmlspecialchars($producto['imagen']); ?>"
                                    alt="<?php echo htmlspecialchars($producto['nombre']); ?>"
                                >
                            </a>
                        </div>
            
                        <a href="index.php?pagina=producto&id=<?php echo $producto['id_producto']; ?>">
                            <h3>
                                <?php echo htmlspecialchars($producto['nombre']); ?>
                            </h3>
                        </a>

                        <p class="precio">
                            $<?php echo number_format($producto['precio'], 0, ',', '.'); ?>
                        </p>

                        <button
                            id="carrito-btn"
                            data-id="<?php echo $producto['id_producto']; ?>"
                            data-nombre="<?php echo htmlspecialchars($producto['nombre']); ?>"
                            data-precio="<?php echo $producto['precio']; ?>"
                            <?php echo $sinStock ? 'disabled' : ''; ?>
                        >
                            Agregar al carrito
                        </button>

                    </div>


                <?php endforeach; ?>

        <?php endif; ?>

    </section>


    <div id="mensaje-flotante" class="mensaje-flotante"></div>

<?php 
$scriptExtra = 'public/js/catalogo.js';
require __DIR__ . '/footer.php'; ?>

<!--Autor: Eric Leyes Ultima actualizacion: 02/09/2026-->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona Joystick</title>
    <link rel="stylesheet" href="/Proyecto-Anual/public/css/Catalogo.css">
    <link rel="icon" href="/Proyecto-Anual/public/img/favicon.ico" type="image/x-icon" sizes="512x512">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
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

    
    <!-- Sección de catálogo -->
    <section class="catalogo">
            <!-- Verificar si hay productos disponibles -->
            <?php if (empty($listaDeProductos)): ?>

            <p>No hay productos disponibles en este momento.</p>

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

    <!-- Pie de página -->
    <footer>
        <hr>
        <h3>Contacto</h3>

        <p>Correo electrónico: zonajoystick26@gmail.com</p>

        <p>Teléfono: +589 97 951 885</p>

        <p>Centro, Montevideo Uruguay</p>
        <p>&copy; Creado por Zephyron Corp.</p>
    </footer>
    <script src="/Proyecto-Anual/public/js/storage.js"></script>
    <script src="/Proyecto-Anual/public/js/catalogo.js"></script>
</body>
</html>

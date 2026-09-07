<!--Autor: Eric Leyes Ultima actualizacion: 02/09/2026-->

 
<?php
    //Conectar la base de datos con el catalogo
    require_once 'php/conexion.php';
    $sql = "SELECT * FROM productos";
    $resultado = mysqli_query($conexion, $sql);
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona Joystick</title>
    <link rel="stylesheet" href="css/Catalogo.css">
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon" sizes="512x512">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header con logo y barra de navegación. -->
    <header>
        <div class="header-izquierda">
            <a href="index.html"><img src="assets/Logo completo.png" alt="Logo empresa" class="logo"></a>

            <nav class="menu">
                <a href="Catalogo.php">Catálogo</a>
            </nav>
        </div>
        <div class="header-derecha">
            <a href="login.html" class="login">Ingresar</a>
            <a href="register.html" class="register">Registrarse</a>
            <a href="carrito.html"><img src="assets/Carrito-De-Compras.png" alt="Carrito de compras" class="carrito"></a>
        </div>
    </header>

    <section class="hero">
        <h2>Elegí lo que te guste!</h2>
        <p>Videojuegos • Figuras • Manga • TCG</p>
    </section>


    <!-- Sección de catálogo -->
    <section class="catalogo">
        <!-- Bucle para mostrar los productos del catálogo -->
        <?php 
        // Verificar si hay productos disponibles
            if (mysqli_num_rows($resultado) > 0): 
        ?>
            <?php 
            // Bucle para mostrar cada producto en una tarjeta
            while ($producto = mysqli_fetch_assoc($resultado)): 
            ?>
                <?php 
                    // Verificar si el producto está sin stock
                    $sinStock = $producto['stock'] == 0; 
                    ?>
                <div class="card">
                    <div class="imagen-producto"><img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>"></div>
                    <h3><?php echo $producto['nombre']; ?></h3>
                    <p class="precio">$<?php echo $producto['precio']; ?></p>
                    <button id="carrito-btn"
                    data-id="<?php echo $producto['id']; ?>"
                    data-nombre="<?php echo $producto['nombre']; ?>"
                    data-precio="<?php echo $producto['precio']; ?>"
                    <?php echo $sinStock ? 'disabled' : ''; ?>

                    >
                    Agregar al carrito</button>
                </div>

            <?php endwhile; ?>
            <?php else: ?>
                <p>No hay productos disponibles en este momento.</p> 
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
    <script src="js/storage.js"></script>
    <script src="js/catalogo.js"></script>
</body>
</html>
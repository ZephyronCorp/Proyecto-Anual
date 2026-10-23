<?php
$css = "carrito.css";
require __DIR__ . '/header.php';?>
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

<?php
$scriptExtra = 'public/js/carrito.js'; 
require __DIR__ . '/footer.php'; 
?>
    <?php if (estaLogueado()): ?>
        <a class="boton-mensajes-flotante"
            href="index.php?pagina=mis_mensajes">
            Mensajes
        </a>
    <?php endif; ?>
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
    <script src="public/js/storage.js"></script>
    <?php 
    if(isset ($scriptExtra)){
        echo '<script src ="' . htmlspecialchars($scriptExtra) . '"></script>';
    }
    if (isset($scriptEnLinea)) {
    echo '<script>' . $scriptEnLinea . '</script>';
    }
    ?>
</body>
</html>

<!--
Autor: Facundo Martino
Ultima actualizacion: 29/08/2026
-->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="/Proyecto-Anual/public/css/login.css">
    <link rel="icon" href="/Proyecto-Anual/public/img/favicon.ico" type="image/x-icon">
</head>

<body>
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
  <main class="pagina-login">
    <!-- Apartado para elegir si quieres iniciar sesión o registrarte -->
      <div class="opciones-login">
        <a href="/Proyecto-Anual/index.php?pagina=login" class="activo">Iniciar sesión</a>
        <a href="/Proyecto-Anual/index.php?pagina=registro">Crear cuenta</a>
      </div>
    <section class="login-card">
      <!-- Formulario para iniciar sesión -->
       
      <h2>Bienvenido de nuevo</h2>
      <form id="formLogin">
        <div class="campo">
          <label for="email">Correo electrónico</label>
          <input type="email" id="email" placeholder="tucorreo@email.com">
        </div>

        <div class="campo">
          <label for="contrasena">Contraseña</label>
          <input type="password" id="contrasena" placeholder="Contraseña">
        </div>

        <div class="recordar-datos">
          <label>
          <input type="checkbox">Recordarme</label>
          <a href="#">¿Olvidaste tu contraseña?</a>
        </div>

        <button type="submit">Iniciar sesión</button>
      </form>
      <p id="Mensaje"></p>
    </section>
  </main>
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
    <script src="/Proyecto-Anual/public/js/login.js"></script>
</body>
</html>
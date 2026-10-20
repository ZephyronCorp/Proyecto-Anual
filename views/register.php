<!--
Autor: Facundo Martino
Ultima actualizacion: 29/08/2026
-->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta</title>
    <link rel="stylesheet" href="/Proyecto-Anual/public/css/register.css">
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
  <main class="pagina-register">
      <!-- Apartado para elegir si quieres registrarte o iniciar sesión -->
      <div class="opciones-register">
        <a href="/Proyecto-Anual/index.php?pagina=login">Iniciar sesión</a>
        <a href="/Proyecto-Anual/index.php?pagina=registro" class="activo">Crear cuenta</a>
      </div>
    <section class="register-card">
      <!-- Formulario para registrarse -->
      <h2>Creá tu cuenta</h2>
      <form id="formRegister">
      <div class="nombre-completo">
        <div class="campo">
          <label for="nombre">Nombre</label>
          <input type="text" id="nombre" placeholder="Juan">
        </div>

        <div class="campo">
          <label for="apellido">Apellido</label>
          <input type="text" id="apellido" placeholder="Pérez">
        </div>

      </div>

      <div class="campo">
        <label for="email">Correo electrónico</label>
        <input type="email" id="email" placeholder="tucorreo@email.com">
      </div>

      <div class="campo">
        <label for="contrasena">Contraseña</label>
        <input type="password" id="contrasena" placeholder="Mínimo 8 caracteres">
      </div>

      <div class="campo">
        <label for="confirmar-contrasena">Confirmá la contraseña</label>
        <input type="password" id="confirmar-contrasena" placeholder="Repetí tu contraseña">
      </div>
      
      <button type="submit">Registrarse</button>
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
  <script src="/Proyecto-Anual/public/js/register.js"></script>
</body>
</html>

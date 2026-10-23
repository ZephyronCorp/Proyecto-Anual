<?php
$css = "login.css";
require __DIR__ . '/header.php';?>

  <main class="pagina-login">
    <!-- Apartado para elegir si quieres iniciar sesión o registrarte -->
      <div class="opciones-login">
        <a href="/Proyecto-Anual/index.php?pagina=login" class="activo">Iniciar sesión</a>
        <a href="/Proyecto-Anual/index.php?pagina=registro">Crear cuenta</a>
      </div>
    <section class="login-card">
      <!-- Formulario para iniciar sesión -->
       <?php if (($_GET['registro'] ?? '') === 'ok'): ?>
        <p class="exito">¡Registro exitoso! Ahora podés iniciar sesión.</p>
      <?php endif; ?>

      <?php 
      if (!empty($errores)): ?>
        <ul class="errores">
          <?php foreach ($errores as $error): ?>
            <li><?= escapar($error) ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <?php if ($mensajeOk !== ''): ?>
          <p class="exito"><?= escapar($mensajeOk) ?></p>
      <?php endif; ?>
      <h2>Bienvenido de nuevo</h2>
      <form id="formLogin" method="POST" action="/Proyecto-Anual/index.php?pagina=login">
        <div class="campo">
          <label for="email">Correo electrónico</label>
          <input type="email" id="email" placeholder="tucorreo@email.com" name="email" required>
        </div>

        <div class="campo">
          <label for="contrasena">Contraseña</label>
          <input type="password" id="contrasena" placeholder="Contraseña" name="contrasena" required>
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
<?php 
$scriptExtra = 'public/js/login.js';
require __DIR__ . '/footer.php'; 
?>
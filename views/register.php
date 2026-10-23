<?php
$css = "register.css";
require __DIR__ . '/header.php';?>

  <main class="pagina-register">
      <!-- Apartado para elegir si quieres registrarte o iniciar sesión -->
      <div class="opciones-register">
        <a href="/Proyecto-Anual/index.php?pagina=login">Iniciar sesión</a>
        <a href="/Proyecto-Anual/index.php?pagina=registro" class="activo">Crear cuenta</a>
      </div>
    <section class="register-card">
      <!-- Formulario para registrarse -->
      <h2>Creá tu cuenta</h2>

      <!-- Muestra los errores de validación si existen -->
      <?php if (!empty($errores)): ?>
        <ul class="errores">
          <?php foreach ($errores as $error): ?>
            <li><?= escapar($error) ?></li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <?php if ($mensajeOk !== ''): ?>
          <p class="exito"><?= escapar($mensajeOk) ?></p>
        <?php endif; ?>

      <form id="formRegister" method="POST" action="/Proyecto-Anual/index.php?pagina=registro">
      <div class="nombre-completo">
        <div class="campo">
          <label for="nombre">Nombre</label>
          <input type="text" id="nombre" placeholder="Juan" name="nombre" value="<?= escapar($nombre) ?>" required>
        </div>

        <div class="campo">
          <label for="apellido">Apellido</label>
          <input type="text" id="apellido" placeholder="Pérez" name="apellido" value="<?= escapar($apellido) ?>" required>
        </div>

      </div>

      <div class="campo">
        <label for="email">Correo electrónico</label>
        <input type="email" id="email" placeholder="tucorreo@email.com" name="email" value="<?= escapar($email) ?>" required>
      </div>

      <div class="campo">
        <label for="contrasena">Contraseña</label>
        <input type="password" id="contrasena" placeholder="Mínimo 8 caracteres" name="contrasena" required>
      </div>

      <div class="campo">
        <label for="confirmar-contrasena">Confirmá la contraseña</label>
        <input type="password" id="confirmar-contrasena" placeholder="Repetí tu contraseña" name="confirmar_contrasena" required>
      </div>
      
      <button type="submit">Registrarse</button>
      </form>
      <p id="Mensaje"></p>
    </section>
  </main>
<?php 
$scriptExtra = 'public/js/register.js';
require __DIR__ . '/footer.php'; ?>

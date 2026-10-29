<?php
$css = "mensaje.css";
require __DIR__ . '/header.php';
?>

<main class="pagina-mensajes">
    <h1>Contacto</h1>

    <p>
        Escribinos tu consulta y te respondemos desde acá.
        <a href="index.php?pagina=mis_mensajes">Ver mis mensajes</a>
    </p>

    <?php if ($aviso !== null): ?>
        <p class="<?= escapar($aviso['tipo']) ?>">
            <?= escapar($aviso['texto']) ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($errores)): ?>
        <ul class="errores">
            <?php foreach ($errores as $error): ?>
                <li><?= escapar($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="index.php?pagina=mensaje_enviar"
        method="POST" class="formulario-mensaje">

        <label for="asunto">Asunto</label>
        <input class="campo-mensaje" type="text"
            id="asunto" name="asunto"
            maxlength="<?= (int)$maxAsunto ?>"
            value="<?= escapar($asunto) ?>" required>

        <label for="texto">
            Mensaje (máximo <?= (int)$maxTexto ?> caracteres)
        </label>
        <textarea class="campo-mensaje"
            id="texto" name="texto" rows="8"
            maxlength="<?= (int)$maxTexto ?>" required><?= escapar($texto) ?></textarea>

        <button class="boton-mensaje" type="submit">
            Enviar consulta
        </button>
    </form>
</main>

<?php require __DIR__ . '/footer.php'; ?>
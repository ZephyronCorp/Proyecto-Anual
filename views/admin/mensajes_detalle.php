<?php
$css = "estilosAdmin.css";
require __DIR__ . '/../header.php';
?>

<main class="pagina-productos">
    <h1>Mensaje N.º <?= (int)$mensaje['id_mensaje'] ?></h1>

    <p>
        <a href="index.php?pagina=admin_mensajes">
            Volver a la bandeja
        </a>
    </p>

    <?php if ($aviso !== null): ?>
        <p class="<?= escapar($aviso['tipo']) ?>">
            <?= escapar($aviso['texto']) ?>
        </p>
    <?php endif; ?>

    <p>
        <strong>Cliente:</strong>
        <?= escapar($mensaje['cliente_nombre']) ?>
        (<?= escapar($mensaje['cliente_email']) ?>)<br>

        <strong>Fecha:</strong>
        <?= escapar(date('d/m/Y H:i', strtotime($mensaje['fecha']))) ?><br>

        <strong>Asunto:</strong>
        <?= escapar($mensaje['asunto']) ?>
    </p>

    <div class="consulta-mensaje">
        <p><?= nl2br(escapar($mensaje['contenido'])) ?></p>
    </div>

    <?php if ($mensaje['respuesta'] !== null): ?>
        <h2>Respuesta enviada</h2>

        <p>
            <?= escapar(date(
                'd/m/Y H:i',
                strtotime($mensaje['fecha_respuesta'])
            )) ?>
        </p>

        <div class="respuesta-admin">
            <p><?= nl2br(escapar($mensaje['respuesta'])) ?></p>
        </div>
    <?php else: ?>
        <h2>Responder</h2>

        <form
            action="index.php?pagina=admin_mensaje_responder&id=<?= (int)$mensaje['id_mensaje'] ?>"
            method="POST" class="formulario-respuesta">

            <label for="respuesta">
                Tu respuesta (máximo <?= (int)$maxRespuesta ?> caracteres)
            </label>

            <textarea class="campo-respuesta"
                id="respuesta" name="respuesta" rows="6"
                maxlength="<?= (int)$maxRespuesta ?>" required><?= escapar($textoRespuesta) ?></textarea>

            <button class="boton-respuesta" type="submit"
                onclick="return confirm('Una vez enviada, la respuesta no se puede modificar. ¿Enviarla?');">
                Enviar respuesta
            </button>
        </form>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/../footer.php'; ?>
<?php
$css = "mensaje.css";
require __DIR__ . '/header.php';
?>

<main class="pagina-mensajes">
    <h1>Mis mensajes</h1>

    <p>
        <a href="index.php?pagina=contacto">
            Escribir una consulta nueva
        </a>
    </p>

    <?php if ($aviso !== null): ?>
        <p class="<?= escapar($aviso['tipo']) ?>">
            <?= escapar($aviso['texto']) ?>
        </p>
    <?php endif; ?>

    <?php if (empty($mensajes)): ?>
        <p>Todavía no enviaste ninguna consulta.</p>
    <?php else: ?>
        <?php foreach ($mensajes as $m): ?>
            <article class="mensaje-caja">
                <h2><?= escapar($m['asunto']) ?></h2>

                <p class="fecha-mensaje">
                    Enviado el
                    <?= escapar(date('d/m/Y H:i', strtotime($m['fecha']))) ?>
                </p>

                <p><?= nl2br(escapar($m['contenido'])) ?></p>

                <?php if ($m['respuesta'] === null): ?>
                    <p class="mensaje-pendiente">
                        Pendiente de respuesta
                    </p>
                <?php else: ?>
                    <div class="respuesta-mensaje">
                        <h3>Respuesta de la tienda</h3>

                        <p class="fecha-mensaje">
                            <?= escapar(date(
                                'd/m/Y H:i',
                                strtotime($m['fecha_respuesta'])
                            )) ?>
                        </p>

                        <p><?= nl2br(escapar($m['respuesta'])) ?></p>
                    </div>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/footer.php'; ?>
<?php
$css = "pagoResultado.css";
require __DIR__ . '/header.php';?>

<?php if ($pedido['estado'] === 'pagado'): ?>
    <h1>¡Pago aprobado!</h1>

    <p>
        Gracias por tu compra. Tu pedido N.º
        <strong><?= escapar($pedido['id_pedido']) ?></strong>
        fue pagado correctamente.
    </p>

    <p>
        Total abonado:
        <strong>
            $ <?= escapar(number_format($pedido['total'], 2, ',', '.')) ?>
        </strong>
    </p>

    <p>
        <a href="index.php?pagina=catalogo">Seguir comprando</a>
    </p>
<?php else: ?>
    <h1>Pago rechazado</h1>

    <p>
        No pudimos procesar el pago del pedido N.º
        <strong><?= escapar($pedido['id_pedido']) ?></strong>.
    </p>

    <p>
        <a href="index.php?pagina=pago&id=<?= (int)$pedido['id_pedido'] ?>">
            Intentar de nuevo
        </a>
        |
        <a href="index.php?pagina=catalogo">Volver al catálogo</a>
    </p>
<?php endif; ?>

<?php require __DIR__ . '/footer.php'; ?>

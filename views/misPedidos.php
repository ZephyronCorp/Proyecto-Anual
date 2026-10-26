<?php
$css = "carrito.css";
require __DIR__ . '/header.php';
?>

<main class="pagina-carrito">
    <h1>Mis pedidos</h1>

    <?php if (empty($pedidos)): ?>
        <p>Todavía no realizaste pedidos.</p>
    <?php else: ?>
        <table class="tabla-pedidos">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?= escapar($pedido['id_pedido']) ?></td>
                        <td><?= escapar($pedido['fecha']) ?></td>
                        <td><?= escapar($pedido['estado']) ?></td>
                        <td>$<?= escapar(number_format($pedido['total'], 2, ',', '.')) ?></td>

                        <td>
                            <a href="index.php?pagina=pedido-detalle&id=<?= (int)$pedido['id_pedido'] ?>">
                                Ver detalle
                            </a>

                            <?php if ($pedido['estado'] !== 'pagado'): ?>
                                |
                                <a href="index.php?pagina=pago&id=<?= (int)$pedido['id_pedido'] ?>">
                                    Pagar
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/footer.php'; ?>
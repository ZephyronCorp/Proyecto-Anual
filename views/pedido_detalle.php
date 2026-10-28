<?php
$css = "pedido_detalle.css";
require __DIR__ . '/header.php';
?>

<main class="pagina-carrito">
    <h1>Pedido N.º <?= (int)$pedido['id_pedido'] ?></h1>

    <p>
        Fecha:
        <?= escapar(date('d/m/Y H:i', strtotime($pedido['fecha']))) ?>
    </p>

    <p>
        Estado:
        <span class="estado estado-<?= escapar($pedido['estado']) ?>">
            <?= escapar(ucfirst($pedido['estado'])) ?>
        </span>
    </p>

    <?php if ($pedido['estado'] === 'pagado'): ?>
        <p>
            Envío:
            <span class="estado estado-<?= escapar($pedido['estado_envio']) ?>">
                <?= escapar(ucfirst($pedido['estado_envio'])) ?>
            </span>
        </p>
    <?php endif; ?>
    
    <h2>Productos</h2>

    <table class="tabla-pedidos">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cant.</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($detalle as $linea): ?>
                <tr>
                    <td><?= escapar($linea['nombre']) ?></td>
                    <td><?= (int)$linea['cantidad'] ?></td>

                    <td>
                        $ <?= escapar(number_format($linea['precio_unitario'], 2, ',', '.')) ?>
                    </td>

                    <td>
                        $ <?= escapar(number_format($linea['subtotal'], 2, ',', '.')) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr>
                <th colspan="3">Total</th>
                <th>
                    $ <?= escapar(number_format($pedido['total'], 2, ',', '.')) ?>
                </th>
            </tr>
        </tfoot>
    </table>

    <h2>Envío</h2>

    <p>
        <?= escapar($pedido['envio_nombre']) ?><br>
        <?= escapar($pedido['envio_direccion']) ?><br>
        <?= escapar($pedido['envio_ciudad']) ?>,
        <?= escapar($pedido['envio_departamento']) ?><br>
        Tel.: <?= escapar($pedido['envio_telefono']) ?>
    </p>

    <p>
        <?php if ($pedido['estado'] !== 'pagado'): ?>
            <a href="index.php?pagina=pago&id=<?= (int)$pedido['id_pedido'] ?>">
                Pagar este pedido
            </a>
            |
        <?php endif; ?>

        <a href="index.php?pagina=mis-pedidos">Volver a mis pedidos</a>
    </p>
</main>

<?php require __DIR__ . '/footer.php'; ?>
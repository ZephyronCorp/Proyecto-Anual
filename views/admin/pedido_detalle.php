<?php
$css = "estilosAdmin.css";
require __DIR__ . '/../header.php';
?>

<main class="pagina-productos">
    <h1>Pedido N.º <?= (int)$pedido['id_pedido'] ?></h1>

    <p>
        <a href="index.php?pagina=admin_pedidos">Volver a pedidos</a>
    </p>

    <?php if ($aviso !== null): ?>
        <p class="<?= escapar($aviso['tipo']) ?>">
            <?= escapar($aviso['texto']) ?>
        </p>
    <?php endif; ?>

    <h2>Datos del pedido</h2>

    <p>
        Fecha:
        <?= escapar(date('d/m/Y H:i', strtotime($pedido['fecha']))) ?>
    </p>

    <p>
        Cliente:
        <?= escapar($pedido['cliente_nombre']) ?>
        (<?= escapar($pedido['cliente_email']) ?>)
    </p>

    <p>
        Pago:
        <span class="estado estado-<?= escapar($pedido['estado']) ?>">
            <?= escapar(ucfirst($pedido['estado'])) ?>
        </span>

        <?php if ($pago): ?>
            — tarjeta terminada en
            <strong><?= escapar($pago['ultimos4']) ?></strong>,
            el <?= escapar(date('d/m/Y H:i', strtotime($pago['fecha']))) ?>
        <?php endif; ?>
    </p>

    <h2>Productos</h2>

    <table class="tabla">
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

    <h2>Datos de envío</h2>

    <p>
        <?= escapar($pedido['envio_nombre']) ?><br>
        <?= escapar($pedido['envio_direccion']) ?><br>
        <?= escapar($pedido['envio_ciudad']) ?>,
        <?= escapar($pedido['envio_departamento']) ?><br>
        Tel.: <?= escapar($pedido['envio_telefono']) ?>
    </p>

    <!-- Las etapas 3 y 4 agregan el estado de envío y el enlace a la factura. -->
</main>

<?php require __DIR__ . '/../footer.php'; ?>
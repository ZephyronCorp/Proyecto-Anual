-<?php
$css = "factura.css";
require __DIR__ . '/header.php';?>


<div class="barra no-imprimir">
        <button onclick="window.print()">Descargar PDF / Imprimir</button>
        <a href="index.php?pagina=pedido_detalle&id=<?= (int)$pedido['id_pedido'] ?>">
            Volver al pedido
        </a>
    </div>

    <div class="encabezado">
        <div>
            <h1>Zona Joystick</h1>
            <p>Videojuegos y coleccionables</p>
        </div>

        <div class="der">
            <h2>FACTURA</h2>
            <p>
                N.º <strong><?= escapar($numeroFactura) ?></strong><br>
                Fecha: <?= escapar(date('d/m/Y', strtotime($pago['fecha'] ?? $pedido['fecha']))) ?>
            </p>
        </div>
    </div>

    <div class="datos">
        <div>
            <strong>Cliente</strong><br>
            <?= escapar($cliente) ?>
        </div>

        <div>
            <strong>Enviar a</strong><br>
            <?= escapar($pedido['envio_nombre']) ?><br>
            <?= escapar($pedido['envio_direccion']) ?><br>
            <?= escapar($pedido['envio_ciudad']) ?>,
            <?= escapar($pedido['envio_departamento']) ?>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th class="der">Cant.</th>
                <th class="der">Precio unit.</th>
                <th class="der">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detalle as $linea): ?>
                <tr>
                    <td><?= escapar($linea['nombre']) ?></td>
                    <td class="der"><?= (int)$linea['cantidad'] ?></td>
                    <td class="der">
                        $ <?= escapar(number_format($linea['precio_unitario'], 2, ',', '.')) ?>
                    </td>
                    <td class="der">
                        $ <?= escapar(number_format($linea['subtotal'], 2, ',', '.')) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="3" class="der total">TOTAL</td>
                <td class="der total">
                    $ <?= escapar(number_format($pedido['total'], 2, ',', '.')) ?>
                </td>
            </tr>
        </tfoot>
    </table>

    <?php if ($pago): ?>
        <p class="pago">
            Pagado con tarjeta terminada en
            <strong><?= escapar($pago['ultimos4']) ?></strong>.
        </p>
    <?php endif; ?>

    <p class="pie">
        Documento de práctica generado con fines educativos. Sin validez fiscal.
    </p>
<?php 
require __DIR__ . '/footer.php'; ?>

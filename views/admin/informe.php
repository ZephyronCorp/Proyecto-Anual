<?php
$css = "estilosAdmin.css";
require __DIR__ . '/../header.php';
?>

<main class="pagina-productos">
    <h1>Informe de transacciones</h1>

    <p>
        <a href="index.php?pagina=admin">Volver al panel</a>
        |
        <a href="index.php?pagina=admin_pedidos">Ver pedidos</a>
    </p>

    <form action="index.php" method="GET" class="filtros">
        <input type="hidden" name="pagina" value="admin_informe">

        <label for="desde">Desde</label>
        <input type="date" id="desde" name="desde"
            value="<?= escapar($desde) ?>">

        <label for="hasta">Hasta</label>
        <input type="date" id="hasta" name="hasta"
            value="<?= escapar($hasta) ?>">

        <input class="boton-filtrar" type="submit" value="Generar informe">
    </form>

    <?php if (!empty($errores)): ?>
        <ul class="errores">
            <?php foreach ($errores as $error): ?>
                <li><?= escapar($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>
            Período:
            <strong><?= escapar(date('d/m/Y', strtotime($desde))) ?></strong>
            al
            <strong><?= escapar(date('d/m/Y', strtotime($hasta))) ?></strong>
        </p>

        <section class="tarjetas">
            <article class="tarjeta">
                <h2>Ventas</h2>
                <p>
                    <strong><?= (int)$cantidadVentas ?></strong>
                    pedido(s) pagado(s)
                </p>
            </article>

            <article class="tarjeta">
                <h2>Total facturado</h2>
                <p>
                    <strong>
                        $ <?= escapar(number_format($totalVentas, 2, ',', '.')) ?>
                    </strong>
                </p>
            </article>

            <article class="tarjeta">
                <h2>Promedio por venta</h2>
                <p>
                    <strong>
                        $ <?= escapar(number_format($promedio, 2, ',', '.')) ?>
                    </strong>
                </p>
            </article>
        </section>

        <h2>Pedidos por estado de pago</h2>

        <table class="tabla">
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>Cantidad</th>
                    <th>Monto</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($resumen as $estado => $datos): ?>
                    <tr>
                        <td>
                            <span class="estado estado-<?= escapar($estado) ?>">
                                <?= escapar(ucfirst($estado)) ?>
                            </span>
                        </td>

                        <td><?= (int)$datos['cantidad'] ?></td>

                        <td>
                            $ <?= escapar(number_format($datos['total'], 2, ',', '.')) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><em>Solo los pedidos pagados cuentan como ventas.</em></p>

        <h2>Detalle de ventas</h2>

        <?php if (empty($ventas)): ?>
            <p class="sin-resultados">
                No hubo ventas en el período elegido.
            </p>
        <?php else: ?>
            <table class="tabla">
                <thead>
                    <tr>
                        <th>N.º</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Envío</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($ventas as $v): ?>
                        <tr>
                            <td><?= (int)$v['id_pedido'] ?></td>

                            <td>
                                <?= escapar(date('d/m/Y H:i', strtotime($v['fecha']))) ?>
                            </td>

                            <td><?= escapar($v['cliente']) ?></td>

                            <td>
                                $ <?= escapar(number_format($v['total'], 2, ',', '.')) ?>
                            </td>

                            <td>
                                <span class="estado estado-<?= escapar($v['estado_envio']) ?>">
                                    <?= escapar(ucfirst($v['estado_envio'])) ?>
                                </span>
                            </td>

                            <td>
                                <a href="index.php?pagina=admin_pedido_detalle&id=<?= (int)$v['id_pedido'] ?>">
                                    Detalle
                                </a>
                                |
                                <a href="index.php?pagina=admin_pedido_factura&id=<?= (int)$v['id_pedido'] ?>">
                                    Factura
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/../footer.php'; ?>
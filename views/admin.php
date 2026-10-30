<?php 
$css = "admin.css";
require __DIR__ . '/header.php'; 
?>

<h1>Panel de administración</h1>
<p class = "bienvenida">Bienvenido,<strong><?=escapar($nombreAdmin)?></strong>.</p>

<section class="tarjetas">
    <article class="tarjeta">
        <h2>Productos</h2>
        <p>Agregar, editar o eliminar productos del catálogo.</p>
        <a href="index.php?pagina=admin_productos">Gestionar productos</a>
    </article>

    <article class="tarjeta">
        <h2>Pedidos</h2>
        <p>Ver los pedidos realizados por los clientes.</p>
        <a href="index.php?pagina=admin_pedidos">Ver pedidos</a>
    </article>

    <article class="tarjeta">
        <h2>Usuarios</h2>
        <p>Consultar las cuentas registradas.</p>
        <a href="index.php?pagina=admin_usuarios">Ver usuarios</a>
    </article>

    <article class="tarjeta">
        <h2>Informe</h2>
        <p>Ventas y transacciones por rango de fechas.</p>
        <a href="index.php?pagina=admin_informe">Ver informe</a>
    </article>

    <article class="tarjeta">
        <h2>Mensajes</h2>
        <p>Leer las consultas de los clientes y responderlas.</p>
        <a href="index.php?pagina=admin_mensajes">Ver mensajes</a>
    </article>  
</section>

<section class="alerta-mensajes">
    <h2>Mensajes de clientes</h2>

    <?php if ($mensajesSinResponder === 0): ?>
        <p>No hay mensajes sin responder.</p>
    <?php else: ?>
        <p class="aviso-mensajes">
            <?= (int)$mensajesSinResponder ?> mensaje(s) sin responder.

            <a href="index.php?pagina=admin_mensajes&filtro=sin_responder">
                Ver consultas pendientes
            </a>
        </p>
    <?php endif; ?>
</section>
<p class = "frase" >Agregar, editar, dar de baja o reactivar productos del catálogo.</p>

<section class="alerta-stock">
    <h2>Pedidos por enviar</h2>

    <?php if (empty($pedidosPorEnviar)): ?>
        <p>No hay pedidos pagados esperando envío.</p>
    <?php else: ?>
        <p class="aviso-stock">
            <?= count($pedidosPorEnviar) ?> pedido(s) pagado(s)
            esperando ser enviado(s).

            <a href="index.php?pagina=admin_pedidos&estado=pagado&estado_envio=preparando">
                Verlos
            </a>
        </p>
    <?php endif; ?>
</section>

<section>
    <h2>Últimos pedidos</h2>

    <?php if (empty($ultimosPedidos)): ?>
        <p>Todavía no hay pedidos.</p>
    <?php else: ?>
        <table class="tabla">
            <thead>
                <tr>
                    <th>N.º</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Pago</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($ultimosPedidos as $p): ?>
                    <tr>
                        <td><?= (int)$p['id_pedido'] ?></td>

                        <td><?= escapar($p['cliente']) ?></td>

                        <td>
                            <?= escapar(date('d/m/Y H:i', strtotime($p['fecha']))) ?>
                        </td>

                        <td>
                            $ <?= escapar(number_format($p['total'], 2, ',', '.')) ?>
                        </td>

                        <td>
                            <span class="estado estado-<?= escapar($p['estado']) ?>">
                                <?= escapar(ucfirst($p['estado'])) ?>
                            </span>
                        </td>

                        <td>
                            <a href="index.php?pagina=admin_pedido_detalle&id=<?= (int)$p['id_pedido'] ?>">
                                Ver detalle
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p>
            <a href="index.php?pagina=admin_pedidos">Ver todos los pedidos</a>
        </p>
    <?php endif; ?>
</section>

<section class="alerta-stock">
    <h2>Alertas de stock</h2>

    <?php if (empty($productosStockBajo)): ?>
        <p>Todo en orden: ningún producto tiene stock bajo o agotado.</p>
    <?php else: ?>
        <p class="aviso-stock">
            <?= count($productosStockBajo) ?> producto(s) con stock bajo o agotado.
        </p>

        <table class="tabla">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Stock</th>
                    <th>Mínimo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($productosStockBajo as $p): ?>
                    <tr>
                        <td><?= escapar($p['nombre']) ?></td>
                        <td><?= (int)$p['stock'] ?></td>
                        <td><?= (int)$p['stock_minimo'] ?></td>

                        <td>
                            <span class="stock stock-<?= escapar($p['nivel_stock']) ?>">
                                <?= ($p['nivel_stock'] === 'agotado')
                                    ? 'Sin stock' : 'Stock bajo' ?>
                            </span>
                        </td>

                        <td>
                            <a href="index.php?pagina=admin_producto_editar&id=<?= (int)$p['id_producto'] ?>">
                                Reponer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>
<?php require __DIR__ . '/footer.php'; ?>


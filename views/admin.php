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
</section>

<section>
    <h2>Últimos pedidos</h2>
    <table class="tabla">
        <thead>
            <tr>
                <th>N.º</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Ana Pérez</td>
                <td>2026-10-05</td>
                <td>$ 1.250</td>
                <td>Pagado</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Luis Gómez</td>
                <td>2026-10-06</td>
                <td>$ 780</td>
                <td>Pendiente</td>
            </tr>
        </tbody>
</table>
<p><em>(Datos de ejemplo: más adelante se reemplazan por los
pedidos reales.)</em></p>
</section>
<?php require __DIR__ . '/footer.php'; ?>


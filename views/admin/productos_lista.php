<?php
$css = "estilosAdmin.css";
require __DIR__ . '/../header.php';

// Textos para cada nivel de stock calculado por el modelo.
$etiquetas = [
    'agotado' => 'Sin stock',
    'bajo' => 'Stock bajo',
    'ok' => 'OK'
];
?>

<main class="pagina-productos">
    <h1>Productos</h1>

    <p>
        <a href="index.php?pagina=admin">Volver al panel</a>
        |
        <a href="index.php?pagina=admin_producto_crear">+ Nuevo producto</a>
    </p>

    <?php if ($aviso !== ''): ?>
        <p class="exito"><?= escapar($aviso) ?></p>
    <?php endif; ?>

    <?php if (empty($productos)): ?>
        <p>Todavía no hay productos cargados.</p>
    <?php else: ?>
        <table class="tabla">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($productos as $p): ?>
                    <tr class="<?= ((int)$p['activo'] === 1) ? '' : 'inactivo' ?>">
                        <td>
                            <?php if (!empty($p['imagen'])): ?>
                                <img src="public/img/productos/<?= escapar($p['imagen']) ?>"
                                    alt="<?= escapar($p['nombre']) ?>" class="miniatura">
                            <?php else: ?>
                                <span class="sin-imagen">Sin imagen</span>
                            <?php endif; ?>
                        </td>

                        <td><?= escapar($p['nombre']) ?></td>
                        <td><?= escapar($p['categoria']) ?></td>

                        <td>
                            $ <?= escapar(number_format($p['precio'], 2, ',', '.')) ?>
                        </td>

                        <td>
                            <span class="stock-valor">
                                <?= (int)$p['stock'] ?>
                            </span>

                            <span class="stock stock-<?= escapar($p['nivel_stock']) ?>">
                                <?= escapar($etiquetas[$p['nivel_stock']]) ?>
                            </span>
                        </td>

                        <td>
                            <?= ((int)$p['activo'] === 1) ? 'Activo' : 'Dado de baja' ?>
                        </td>

                        <td>
                            <a href="index.php?pagina=admin_producto_editar&id=<?= (int)$p['id_producto'] ?>">
                                Editar
                            </a>

                            <form action="index.php?pagina=admin_producto_estado&id=<?= (int)$p['id_producto'] ?>"
                                method="POST" class="en-linea">

                                <?php if ((int)$p['activo'] === 1): ?>
                                    <input type="hidden" name="activo" value="0">

                                    <button type="submit"
                                        onclick="return confirm('¿Dar de baja este producto?');">
                                        Dar de baja
                                    </button>
                                <?php else: ?>
                                    <input type="hidden" name="activo" value="1">

                                    <button type="submit">Reactivar</button>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/../footer.php'; ?>
<?php
$css = "estilosAdmin.css";
require __DIR__ . '/../header.php';
?>

<main class="pagina-productos">
    <h1><?= escapar($titulo) ?></h1>

    <p>
        <a href="index.php?pagina=admin_productos">Volver a la lista</a>
    </p>

    <?php if (!empty($errores)): ?>
        <ul class="errores">
            <?php foreach ($errores as $error): ?>
                <li><?= escapar($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="<?= escapar($urlAccion) ?>" method="POST"
        enctype="multipart/form-data">

        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" maxlength="100"
            value="<?= escapar($producto['nombre']) ?>" required>

        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" rows="4"
            maxlength="500"><?= escapar($producto['descripcion']) ?></textarea>

        <label for="id_categoria">Categoría</label>
        <select id="id_categoria" name="id_categoria" required>
            <option value="">-- Elegí --</option>

            <?php foreach ($categorias as $c): ?>
                <option value="<?= (int)$c['id_categoria'] ?>"
                    <?= ((string)$producto['id_categoria'] === (string)$c['id_categoria'])
                        ? 'selected' : '' ?>>
                    <?= escapar($c['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="precio">Precio ($)</label>
        <input type="number" id="precio" name="precio" min="0.01" step="0.01"
            value="<?= escapar($producto['precio']) ?>" required>

        <label for="stock">Stock (unidades disponibles)</label>
        <input type="number" id="stock" name="stock" min="0" step="1"
            value="<?= escapar($producto['stock']) ?>" required>

        <label for="stock_minimo">Stock mínimo (para la alerta)</label>
        <input type="number" id="stock_minimo" name="stock_minimo" min="0" step="1"
            value="<?= escapar($producto['stock_minimo']) ?>" required>

        <small>
            Cuando el stock llegue a este número o menos,
            el producto aparece en las alertas.
        </small>

        <?php if (!empty($producto['imagen'])): ?>
            <p>
                Imagen actual:<br>
                <img src="public/img/productos/<?= escapar($producto['imagen']) ?>"
                    alt="Imagen actual del producto" class="miniatura-grande">
            </p>
        <?php endif; ?>

        <label for="imagen">
            Imagen (JPG, PNG o WEBP, máximo 2 MB)
            <?= !empty($producto['imagen'])
                ? '— dejá vacío para conservar la actual' : '' ?>
        </label>
        <input type="file" id="imagen" name="imagen"
            accept="image/jpeg,image/png,image/webp">

        <input type="submit" value="Guardar">
    </form>
</main>

<?php require __DIR__ . '/../footer.php'; ?>
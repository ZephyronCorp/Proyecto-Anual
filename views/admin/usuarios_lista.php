<?php
$css = "estilosAdmin.css";
require __DIR__ . '/../header.php';
?>

<main class="pagina-productos">
    <h1>Usuarios</h1>

    <p>
        <a href="index.php?pagina=admin">Volver al panel</a>
    </p>

    <?php if ($aviso !== null): ?>
        <p class="<?= escapar($aviso['tipo']) ?>">
            <?= escapar($aviso['texto']) ?>
        </p>
    <?php endif; ?>

    <?php if (empty($usuarios)): ?>
        <p>Todavía no hay usuarios registrados.</p>
    <?php else: ?>
        <table class="tabla">
            <thead>
                <tr>
                    <th>N.º</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Pedidos</th>
                    <th>Registro</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($usuarios as $u): ?>
                    <?php
                    $esMiCuenta = ((int)$u['id_usuario'] === $idActual);
                    $esAdmin = ((int)$u['id_rol'] === 1);
                    ?>

                    <tr class="<?= ((int)$u['activo'] === 1) ? '' : 'inactivo' ?>">
                        <td><?= (int)$u['id_usuario'] ?></td>

                        <td>
                            <?= escapar($u['nombre']) ?>

                            <?php if ($esMiCuenta): ?>
                                <em>(Tu cuenta)</em>
                            <?php endif; ?>
                        </td>

                        <td><?= escapar($u['email']) ?></td>

                        <td>
                            <span class="rol <?= $esAdmin ? 'rol-admin' : 'rol-cliente' ?>">
                                <?= $esAdmin ? 'Administrador' : 'Cliente' ?>
                            </span>
                        </td>

                        <td><?= (int)$u['cantidad_pedidos'] ?></td>

                        <td>
                            <?= escapar(date('d/m/Y', strtotime($u['fecha_registro']))) ?>
                        </td>

                        <td>
                            <?= ((int)$u['activo'] === 1) ? 'Activo' : 'Desactivado' ?>
                        </td>

                        <td>
                            <?php if ($esMiCuenta): ?>
                                <em>No disponible para tu propia cuenta</em>
                            <?php else: ?>
                                <!-- Las acciones se agregan en las etapas 3 y 4. -->
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/../footer.php'; ?>
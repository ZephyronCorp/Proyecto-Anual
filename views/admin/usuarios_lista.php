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
                                <form action="index.php?pagina=admin_usuario_rol&id=<?= (int)$u['id_usuario'] ?>"
                                    method="POST" class="en-linea">

                                    <label for="rol-<?= (int)$u['id_usuario'] ?>" class="solo-lectores">
                                        Rol
                                    </label>

                                    <select id="rol-<?= (int)$u['id_usuario'] ?>" name="id_rol">
                                        <?php foreach ($roles as $r): ?>
                                            <option value="<?= (int)$r ?>" <?= ((int)$u['id_rol'] === (int)$r) ? 'selected' : '' ?>>
                                                <?= ((int)$r === 1) ? 'Administrador' : 'Cliente' ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <button type="submit" onclick="return confirm('¿Cambiar el rol de este usuario?');">
                                        Cambiar rol
                                    </button>
                                </form>
                                <form action="index.php?pagina=admin_usuario_estado&id=<?= (int)$u['id_usuario'] ?>"
                                method="POST" class="en-linea">

                                <?php if ((int)$u['activo'] === 1): ?>
                                    <input type="hidden" name="activo" value="0">
                                    <button type="submit"
                                    onclick="return confirm('¿Desactivar esta cuenta? La persona no podrá iniciar sesión.');">
                                        Desactivar
                                    </button>
                                <?php else: ?>
                                    <input type="hidden" name="activo" value="1">

                                    <button type="submit">Reactivar</button>
                                <?php endif; ?>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/../footer.php'; ?>
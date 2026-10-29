<?php
$css = "estilosAdmin.css";
require __DIR__ . '/../header.php';
?>

<main class="pagina-productos">
    <h1>Mensajes de clientes</h1>

    <p>
        <a href="index.php?pagina=admin">Volver al panel</a>
    </p>

    <?php if ($aviso !== null): ?>
        <p class="<?= escapar($aviso['tipo']) ?>">
            <?= escapar($aviso['texto']) ?>
        </p>
    <?php endif; ?>

    <form action="index.php" method="GET" class="filtros">
        <input type="hidden" name="pagina" value="admin_mensajes">

        <label for="filtro">Mostrar</label>
        <select id="filtro" name="filtro">
            <option value="">Todos</option>

            <?php foreach ($filtrosValidos as $valor => $texto): ?>
                <option value="<?= escapar($valor) ?>"
                    <?= ($filtro === $valor) ? 'selected' : '' ?>>
                    <?= escapar($texto) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button class="boton-filtrar" type="submit">
            Filtrar
        </button>
    </form>

    <?php if (empty($mensajes)): ?>
        <p>No hay mensajes para mostrar.</p>
    <?php else: ?>
        <div class="tabla-mensajes">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>N.º</th>
                        <th>Cliente</th>
                        <th>Asunto</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($mensajes as $m): ?>
                        <tr>
                            <td><?= (int)$m['id_mensaje'] ?></td>

                            <td>
                                <?= escapar($m['cliente_nombre']) ?><br>
                                <small>
                                    <?= escapar($m['cliente_email']) ?>
                                </small>
                            </td>

                            <td><?= escapar($m['asunto']) ?></td>

                            <td>
                                <?= escapar(date(
                                    'd/m/Y H:i',
                                    strtotime($m['fecha'])
                                )) ?>
                            </td>

                            <td>
                                <?php if ((int)$m['respondido'] === 1): ?>
                                    <span class="estado estado-respondido">
                                        Respondido
                                    </span>
                                <?php else: ?>
                                    <span class="estado estado-sin-responder">
                                        Sin responder
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <a href="index.php?pagina=admin_mensaje_detalle&id=<?= (int)$m['id_mensaje'] ?>">
                                    Ver consulta
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/../footer.php'; ?>
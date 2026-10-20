
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido confirmado - Zona Joystick</title>
    <link rel="stylesheet" href="/Proyecto-Anual/public/css/pedido_confirmado.css">
    <link rel="icon" href="/Proyecto-Anual/public/img/favicon.ico" type="image/x-icon">
</head>
<body>

    <section class="pedido-confirmado">
        <h1>¡Gracias por tu compra!</h1>
        <p>Tu pedido quedó registrado con el número <strong>#<?php echo $idPedidoCreado; ?></strong>.</p>

        <table class="tabla-resumen-pedido">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carritoRecibido as $itemDelCarrito): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($itemDelCarrito['nombre']); ?></td>
                        <td><?php echo $itemDelCarrito['cantidad']; ?></td>
                        <td>$<?php echo number_format($itemDelCarrito['precio'], 2, ',', '.'); ?></td>
                        <td>$<?php echo number_format($itemDelCarrito['precio'] * $itemDelCarrito['cantidad'], 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p class="total-pedido-confirmado">
            Total del pedido: $<?php echo number_format($totalDelPedido, 2, ',', '.'); ?>
        </p>

        <a href="index.php?pagina=catalogo" class="boton boton--principal">Seguir comprando</a>
    </section>

    <script src="/Proyecto-Anual/public/js/storage.js"></script>
    <script>
        guardarCarrito([]);
        actualizarContadorCarrito();
    </script>

</body>
</html>

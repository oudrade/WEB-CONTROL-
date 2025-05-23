<?php
$data = [];
if (file_exists('facturas/facturas.json')) {
    $json = file_get_contents('facturas/facturas.json');
    $data = json_decode($json, true);
}

$clientes = array_unique(array_column($data, 'cliente'));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Facturas</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .filtros { margin-bottom: 20px; }
        button { padding: 5px 10px; margin-right: 5px; }
    </style>
</head>
<body>
    <h2>Gestión de Facturas</h2>

    <div class="filtros">
        <form method="GET">
            Cliente:
            <select name="cliente">
                <option value="">-- Todos --</option>
                <?php foreach ($clientes as $cli): ?>
                    <option value="<?= $cli ?>" <?= ($_GET['cliente'] ?? '') == $cli ? 'selected' : '' ?>><?= $cli ?></option>
                <?php endforeach; ?>
            </select>

            Fecha:
            <input type="date" name="fecha" value="<?= $_GET['fecha'] ?? '' ?>">
            <button type="submit">Filtrar</button>
            <button onclick="window.print()">Exportar a PDF</button>
            <a href="facturas/agregar.php"><button type="button">Agregar Factura</button></a>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>N°</th><th>Folio</th><th>Fecha</th><th>Emisor</th><th>Cliente</th><th>Productos</th>
                <th>Subtotal</th><th>IVA</th><th>Total a Pagar</th>
                <th>Monto Total</th><th>Abono</th><th>Pago Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data as $index => $factura) {
                if (!empty($_GET['cliente']) && $_GET['cliente'] !== $factura['cliente']) continue;
                if (!empty($_GET['fecha']) && $_GET['fecha'] !== $factura['fecha']) continue;

                $subtotal = floatval($factura['subtotal']);
                $iva = round($subtotal * 0.19, 2);
                $total = $subtotal + $iva;
            ?>
                <tr>
                    <td><?= $factura['numero'] ?></td>
                    <td><?= $factura['folio'] ?></td>
                    <td><?= $factura['fecha'] ?></td>
                    <td><?= $factura['emisor'] ?></td>
                    <td><?= $factura['cliente'] ?></td>
                    <td><?= $factura['productos'] ?></td>
                    <td><?= number_format($subtotal, 0, ',', '.') ?></td>
                    <td><?= number_format($iva, 0, ',', '.') ?></td>
                    <td><?= number_format($total, 0, ',', '.') ?></td>
                    <td><?= number_format($factura['monto_total'], 0, ',', '.') ?></td>
                    <td><?= number_format($factura['abono'], 0, ',', '.') ?></td>
                    <td><?= number_format($factura['pago_total'], 0, ',', '.') ?></td>
                    <td>
                        <a href="editar.php?id=<?= $index ?>"><button>Editar</button></a>
                        <a href="eliminar.php?id=<?= $index ?>" onclick="return confirm('¿Eliminar esta factura?')"><button>Eliminar</button></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="../dashboard.php"><button>Volver al Dashboard</button></a>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$archivo = 'facturas.json';
$data = json_decode(file_get_contents($archivo), true);
$id = $_GET['id'];
$factura = $data[$id];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Factura</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f4f4f4; }
        form { background: white; padding: 20px; border-radius: 8px; width: 400px; }
        label { display: block; margin-top: 10px; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; }
        .btn { margin-top: 15px; background-color: #3498db; color: white; padding: 10px; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Editar Factura</h2>
    <form method="post" action="update.php">
        <input type="hidden" name="id" value="<?= $id ?>">
        <label>Cliente:</label>
        <input type="text" name="cliente" value="<?= $factura['cliente'] ?>" required>
        <label>Valor:</label>
        <input type="number" name="valor" value="<?= $factura['valor'] ?>" required>
        <label>Moneda:</label>
        <select name="moneda">
            <option value="CLP" <?= $factura['moneda'] == 'CLP' ? 'selected' : '' ?>>CLP</option>
            <option value="USD" <?= $factura['moneda'] == 'USD' ? 'selected' : '' ?>>USD</option>
            <option value="EUR" <?= $factura['moneda'] == 'EUR' ? 'selected' : '' ?>>EUR</option>
        </select>
        <label>Fecha:</label>
        <input type="date" name="fecha" value="<?= $factura['fecha'] ?>" required>
        <label>Estado:</label>
        <select name="estado">
            <option value="Pendiente" <?= $factura['estado'] == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
            <option value="Pagada" <?= $factura['estado'] == 'Pagada' ? 'selected' : '' ?>>Pagada</option>
            <option value="Vencida" <?= $factura['estado'] == 'Vencida' ? 'selected' : '' ?>>Vencida</option>
        </select>
        <button class="btn" type="submit">Actualizar</button>
    </form>
</body>
</html>

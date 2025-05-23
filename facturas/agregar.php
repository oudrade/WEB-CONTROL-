<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
$clientes = [];
if (file_exists('../clientes.json')) {
    $clientes = json_decode(file_get_contents('../clientes.json'), true);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Factura</title>
    <style>
        form { max-width: 600px; margin: auto; background: #f9f9f9; padding: 20px; border-radius: 10px; }
        input, select { width: 100%; margin-bottom: 10px; padding: 8px; }
        label { font-weight: bold; }
    </style>
    <script>
        function calcularIVAyPendiente() {
            let subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
            let abono = parseFloat(document.getElementById('abono').value) || 0;
            let iva = subtotal * 0.19;
            let total = subtotal + iva;
            let pendiente = total - abono;
            document.getElementById('iva').value = iva.toFixed(2);
            document.getElementById('total').value = total.toFixed(2);
            document.getElementById('pendiente').value = pendiente.toFixed(2);
        }
    </script>
</head>
<body>
    <h2 style="text-align:center;">Agregar Factura</h2>
    <form method="post" action="guardar.php">
        <label>Número:</label><input type="text" name="numero" required>
        <label>Folio:</label><input type="text" name="folio" required>
        <label>Fecha:</label><input type="date" name="fecha" required>
        <label>Emisor:</label><input type="text" name="emisor" required>
        <label>Cliente:</label>
        <select name="cliente" required>
            <option value="">-- Seleccionar Cliente --</option>
            <?php foreach ($clientes as $c): ?>
                <option value="<?= $c['nombre'] ?>"><?= $c['nombre'] ?></option>
            <?php endforeach; ?>
        </select>
        <label>Productos:</label><input type="text" name="productos" required>
        <label>Subtotal:</label><input type="number" step="0.01" name="subtotal" id="subtotal" oninput="calcularIVAyPendiente()" required>
        <label>IVA (19%):</label><input type="number" step="0.01" name="iva" id="iva" readonly>
        <label>Total a Pagar:</label><input type="number" step="0.01" name="total_pagar" id="total" readonly>
        <label>Abono:</label><input type="number" step="0.01" name="abono" id="abono" oninput="calcularIVAyPendiente()" required>
        <label>Monto Pendiente:</label><input type="number" step="0.01" name="monto_pendiente" id="pendiente" readonly>
        <button type="submit">Guardar Factura</button>
        <button type="button" onclick="history.back()">Volver</button>
    </form>
</body>
</html>

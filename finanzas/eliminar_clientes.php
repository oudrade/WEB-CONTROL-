<?php
session_start();
$clientes = file_exists("../clientes.json") ? json_decode(file_get_contents("../clientes.json"), true) : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Eliminar Clientes</title>
  <style>
    body { font-family: Arial; margin: 20px; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #999; padding: 8px; text-align: left; }
    button { padding: 5px 10px; }
  </style>
</head>
<body>

<h2>Eliminar Clientes</h2>
<table>
  <tr>
    <th>Nombre</th>
    <th>RUT</th>
    <th>Dirección</th>
    <th>Teléfono</th>
    <th>Acción</th>
  </tr>
  <?php foreach ($clientes as $i => $c): ?>
  <tr id="cliente<?= $i ?>">
    <td><?= htmlspecialchars($c['nombre']) ?></td>
    <td><?= htmlspecialchars($c['rut']) ?></td>
    <td><?= htmlspecialchars($c['direccion']) ?></td>
    <td><?= htmlspecialchars($c['telefono']) ?></td>
    <td><button onclick="eliminarCliente(<?= $i ?>)">Eliminar</button></td>
  </tr>
  <?php endforeach; ?>
</table>

<br>
<a href="facturas.php">← Volver</a>

<script>
function eliminarCliente(indice) {
  if (!confirm("¿Eliminar este cliente?")) return;
  fetch('eliminar_cliente.php', {
    method: 'POST',
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ index: indice })
  }).then(res => res.json())
    .then(data => {
      if (data.success) {
        document.getElementById("cliente" + indice).remove();
      } else {
        alert("Error: " + (data.error || "no se pudo eliminar"));
      }
    });
}
</script>

</body>
</html>
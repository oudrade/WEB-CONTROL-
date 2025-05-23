<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$edps = file_exists("../edp.json") ? json_decode(file_get_contents("../edp.json"), true) : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Listado de EDP</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background-color: #f0f0f0; }
  </style>
</head>
<body>
  <h2>Listado de EDP Registrados</h2>

  <?php if (!empty($edps)): ?>
  <table>
    <tr>
      <th>EDP</th>
      <th>FlexiAPP</th>
      <th>Centrality</th>
      <th>OC</th>
      <th>Detalle</th>
      <th>Complejidad</th>
      <th>Monto</th>
      <th>ITO</th>
      <th>Fecha Realizado</th>
    </tr>
    <?php foreach ($edps as $item): ?>
    <tr>
      <td><?= htmlspecialchars($item["edp"] ?? '') ?></td>
      <td><?= htmlspecialchars($item["flexiapp"] ?? '') ?></td>
      <td><?= htmlspecialchars($item["centrality"] ?? '') ?></td>
      <td><?= htmlspecialchars($item["oc"] ?? '') ?></td>
      <td><?= htmlspecialchars($item["detalle"] ?? '') ?></td>
      <td><?= htmlspecialchars($item["complejidad"] ?? '') ?></td>
      <td><?= htmlspecialchars($item["monto"] ?? '') ?></td>
      <td><?= htmlspecialchars($item["ito"] ?? '') ?></td>
      <td><?= htmlspecialchars($item["fecha_realizado"] ?? '') ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
  <?php else: ?>
    <p>No hay EDP registrados aún.</p>
  <?php endif; ?>

  <br><br>
  <a href="edp.php">← Volver al módulo EDP</a>
</body>
</html>
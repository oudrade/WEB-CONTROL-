<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$contenido = file_exists("../edp.json") ? file_get_contents("../edp.json") : '';
$edps = json_decode($contenido, true);
if (!is_array($edps)) $edps = [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Módulo EDP</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #aaa; padding: 8px; text-align: left; }
    select, input[type="text"], input[type="date"], input[type="number"] {
      width: 100%; padding: 4px;
    }
    .acciones button { padding: 4px 10px; margin: 2px; }
  </style>
</head>
<body>
  <h2>Módulo EDP - Finanzas</h2>

  <form id="formEDP">
    <table>
      <tr>
        <th>EDP</th><th>FlexiAPP</th><th>Centrality</th><th>OC</th><th>Detalle</th><th>Complejidad</th><th>Monto</th><th>ITO</th><th>Fecha Realizado</th>
      </tr>
      <tr>
        <td><input type="text" name="edp" required></td>
        <td><input type="text" name="flexiapp"></td>
        <td><input type="text" name="centrality"></td>
        <td><input type="text" name="oc"></td>
        <td><input type="text" name="detalle"></td>
        <td>
          <select name="complejidad">
            <option value="Baja">Baja Opex</option>
            <option value="Media">Media Opex</option>
            <option value="Alta">Alta Opex</option>
             <option value="Baja">Baja Capex</option>
            <option value="Media">Media Capex</option>
            <option value="Alta">Alta Capex</option>
          </select>
        </td>
        <td><input type="number" name="monto" step="0.01"></td>
        <td><input type="text" name="ito"></td>
        <td><input type="date" name="fecha_realizado"></td>
      </tr>
    </table>
    <br>
    <button type="submit">Guardar EDP</button>
  </form>

  <p id="mensaje" style="color: green;"></p>

  <h3>EDP Registrados</h3>
  <table>
    <tr>
      <th>EDP</th><th>FlexiAPP</th><th>Centrality</th><th>OC</th><th>Detalle</th><th>Complejidad</th><th>Monto</th><th>ITO</th><th>Fecha</th><th>Acciones</th>
    </tr>
    <?php foreach ($edps as $i => $e): ?>
    <tr>
      <td><?= htmlspecialchars($e['edp']) ?></td>
      <td><?= htmlspecialchars($e['flexiapp']) ?></td>
      <td><?= htmlspecialchars($e['centrality']) ?></td>
      <td><?= htmlspecialchars($e['oc']) ?></td>
      <td><?= htmlspecialchars($e['detalle']) ?></td>
      <td><?= htmlspecialchars($e['complejidad']) ?></td>
      <td><?= htmlspecialchars($e['monto']) ?></td>
      <td><?= htmlspecialchars($e['ito']) ?></td>
      <td><?= htmlspecialchars($e['fecha_realizado']) ?></td>
      <td class="acciones">
        <button onclick="editarEDP(<?= $i ?>)">Editar</button>
        <button onclick="eliminarEDP(<?= $i ?>)">Eliminar</button>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>

  <br>
  <a href="listar_edp.php">📋 Ver EDP Registrados</a><br><br>
  <a href="../dashboard.php">← Volver al Dashboard</a>

<script>
document.getElementById("formEDP").onsubmit = async function(e) {
  e.preventDefault();
  const formData = new FormData(this);
  const data = {};
  formData.forEach((v, k) => data[k] = v);

  const res = await fetch("guardar_edp.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(data)
  });

  const result = await res.json();
  const mensaje = document.getElementById("mensaje");
  if (result.success) {
    mensaje.textContent = "EDP guardado correctamente.";
    this.reset();
    location.reload();
  } else {
    mensaje.textContent = "Error al guardar EDP.";
    mensaje.style.color = "red";
  }
};

function editarEDP(index) {
  alert("Función de edición aún no implementada (índice: " + index + ")");
}

function eliminarEDP(index) {
  if (!confirm("¿Seguro que quieres eliminar este registro?")) return;
  fetch("eliminar_edp.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ index })
  }).then(res => res.json())
    .then(data => {
      if (data.success) location.reload();
      else alert("Error al eliminar");
    });
}
</script>
</body>
</html>
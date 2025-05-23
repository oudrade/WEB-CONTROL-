<?php 
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$facturas = file_exists("../facturas.json") ? json_decode(file_get_contents("../facturas.json"), true) : [];
$clientes = file_exists("../clientes.json") ? json_decode(file_get_contents("../clientes.json"), true) : [];

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión de Facturas</title>
<style>
  body { font-family: Arial; }
  button { margin-right: 10px; }
  .popup, .overlay {
    display: none; position: fixed; z-index: 10;
  }
  .popup {
    top: 20%; left: 30%; background: #fff; padding: 20px;
    border: 1px solid #999; box-shadow: 0 0 10px #000;
  }
  .overlay {
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.5); z-index: 5;
  }
</style>
</head>
<body>
<h2>Gestión de Facturas</h2>
<button onclick="abrirFactura()">+ Agregar Factura</button>
<button onclick="abrirCliente()">+ Agregar Cliente</button>
<a href="eliminar_clientes.php" target="_blank">Probar enlace directo</a>
<button onclick="window.location.href='./eliminar_clientes.php'">Eliminar Cliente</button>

<!-- Popup cliente -->
<div class="overlay" id="overlay" onclick="cerrar()"></div>
<div class="popup" id="popupCliente">
  <form id="formCliente">
    <h3>Agregar Cliente</h3>
    <p>Nombre: <input name="nombre" required></p>
    <p>RUT: <input name="rut" required></p>
    <p>Dirección: <input name="direccion"></p>
    <p>Teléfono: <input name="telefono"></p>
    <button type="submit">Guardar</button>
    <button type="button" onclick="cerrar()">Cancelar</button>
  </form>
</div>

<!-- Popup factura -->
<div class="popup" id="popupFactura">
  <form id="formFactura">
    <h3>Agregar Factura</h3>
    <p>Cliente: 
  <select id="clienteSelect" name="cliente" required>
    <?php foreach ($clientes as $c): ?>
      <option value="<?= $c["nombre"] ?>"><?= $c["nombre"] ?></option>
    <?php endforeach; ?>
  </select>
</p>
    <p>N°: <input name="numero"></p>
    <p>Folio: <input name="folio"></p>
    <p>Fecha Ingreso: <input type="date" name="fecha"></p>
    <p>Fecha Vencimiento: <input type="date" name="fecha_vencimiento"></p>
    <p>Productos: <input name="productos"></p>
    <p>Localidad: <input name="localidad"></p>
    <p>Subtotal: <input name="subtotal" type="number" step="0.01"></p>
    <p>IVA (19%): <input name="iva" type="number" step="0.01" readonly></p>
    <p>Total a Pagar: <input name="total_pagar" type="number" step="0.01" readonly></p>
    <p>Comentario: <textarea name="comentario"></textarea></p>
    <button type="submit">Guardar</button>
    <button type="button" onclick="cerrar()">Cerrar</button>
  </form>
</div>
<?php if (!empty($facturas)): ?>
<h3>Listado de Facturas</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>N°</th>
        <th>Folio</th>
        <th>Fecha Ingreso</th>
        <th>Fecha Vencimiento</th>
        <th>Cliente</th>
        <th>Productos</th>
        <th>Subtotal</th>
        <th>IVA</th>
        <th>Total a Pagar</th>
        <th>Abono</th>
        <th>Pago Pendiente</th>
        <th>Comentario</th>
    </tr>
  <?php if (!empty($facturas)): ?>
    <?php foreach ($facturas as $f): 
      $abono = isset($f['abono']) ? floatval($f['abono']) : 0;
      $total = floatval($f['total_pagar']);
      $pendiente = $total - $abono;
    ?>
    <tr title="<?= htmlspecialchars($f['comentario'] ?? '') ?>">
        <td><?= htmlspecialchars($f['numero']) ?></td>
        <td><?= htmlspecialchars($f['folio']) ?></td>
        <td><?= htmlspecialchars($f['fecha']) ?></td>
        <td><?= htmlspecialchars($f['fecha_vencimiento']) ?></td>
        <td><?= isset($f['cliente']) ? htmlspecialchars($f['cliente']) : '<span         style="color:red;">(sin cliente)</span>' ?></td>
        <td><?= htmlspecialchars($f['productos']) ?></td>
        <td><?= htmlspecialchars($f['subtotal']) ?></td>
        <td><?= htmlspecialchars($f['iva']) ?></td>
        <td><?= htmlspecialchars($f['total_pagar']) ?></td>
        <td>
        <input type="number" step="0.01" value="<?= number_format($abono, 2, '.', '') ?>" 
         oninput="calcularPendiente(this)">
        </td>
        <td class="pendiente"><?= number_format($pendiente, 2) ?></td>
        <td><?= htmlspecialchars($f['comentario']) ?></td>
    </tr>
    <?php endforeach; ?>
  <?php endif; ?>
</table>
<?php else: ?>
<p>No hay facturas registradas aún.</p>
<?php endif; ?>

<br><br><a href="../dashboard.php">← Volver al Dashboard</a>-

<script>
function abrirCliente() {
  document.getElementById("popupCliente").style.display = "block";
  document.getElementById("overlay").style.display = "block";
}
function abrirFactura() {
  document.getElementById("popupFactura").style.display = "block";
  document.getElementById("overlay").style.display = "block";
}
function cerrar() {
  document.getElementById("popupCliente").style.display = "none";
  document.getElementById("popupFactura").style.display = "none";
  document.getElementById("overlay").style.display = "none";
}
document.getElementById("formCliente").onsubmit = async function(e) {
  e.preventDefault();
  const formData = new FormData(this);
  const json = {};
  formData.forEach((v, k) => json[k] = v);
  const res = await fetch("guardar_cliente.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(json)
  });
  const data = await res.json();
  if (data.success) {
    const option = document.createElement("option");
    option.textContent = data.cliente.nombre;
    document.getElementById("clienteSelect").appendChild(option);
    cerrar();
  } else {
    alert("Error al guardar cliente");
  }
};
document.getElementById("formFactura").onsubmit = async function(e) {
  e.preventDefault();
  const formData = new FormData(this);
  const json = {};
  formData.forEach((v, k) => json[k] = v);

  const res = await fetch("guardar_factura.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(json)
  });

  const data = await res.json();
  if (data.success) {
    alert("Factura guardada correctamente.");
    location.reload();
  } else {
    alert("Error al guardar factura.");
  }
};

document.querySelector("input[name='subtotal']").addEventListener("input", calcularFactura);

function calcularFactura() {
  const subtotal = parseFloat(document.querySelector("input[name='subtotal']").value) || 0;
  const iva = subtotal * 0.19;
  const total = subtotal + iva;

  document.querySelector("input[name='iva']").value = iva.toFixed(2);
  document.querySelector("input[name='total_pagar']").value = total.toFixed(2);
}
function calcularPendiente(input) {
  const row = input.closest("tr");
  const total = parseFloat(row.children[8].textContent.replace(/[^0-9.-]+/g, "")) || 0;
  const abono = parseFloat(input.value) || 0;
  const pendiente = total - abono;
  row.querySelector(".pendiente").textContent = pendiente.toLocaleString("es-CL", { minimumFractionDigits: 2 });
}
</script>

</body>
</html>

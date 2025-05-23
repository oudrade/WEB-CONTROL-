<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!in_array($_SESSION['rol'] ?? '', ['Maestro', 'Administrativo'])) {
    echo "Acceso denegado.";
    exit;
}

$usuarios = json_decode(file_get_contents("rrhh.json"), true);

// Agregar nuevo usuario
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nuevo"])) {
    $nuevo = [
        "rut" => $_POST["rut"],
        "nombre" => $_POST["nombre"],
        "correo" => $_POST["correo"],
        "telefono" => $_POST["telefono"],
        "ciudad" => $_POST["ciudad"],
        "fecha_nacimiento" => $_POST["fecha_nacimiento"],
        "rol" => $_POST["rol"],
        "fecha_examen" => $_POST["fecha_examen"]
    ];
    $usuarios[] = $nuevo;
    file_put_contents("rrhh.json", json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    header("Location: rrhh.php");
    exit;
}

// Editar usuario existente
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["editar"])) {
    foreach ($usuarios as &$usuario) {
        if ($usuario["rut"] === $_POST["rut"]) {
            $usuario["nombre"] = $_POST["nombre"];
            $usuario["correo"] = $_POST["correo"];
            $usuario["telefono"] = $_POST["telefono"];
            $usuario["ciudad"] = $_POST["ciudad"];
            $usuario["fecha_nacimiento"] = $_POST["fecha_nacimiento"];
            $usuario["rol"] = $_POST["rol"];
            $usuario["fecha_examen"] = $_POST["fecha_examen"];
            break;
        }
    }
    file_put_contents("rrhh.json", json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    header("Location: rrhh.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión RRHH</title>
    <style>
        table, th, td { border: 1px solid #aaa; border-collapse: collapse; padding: 8px; }
        .modal, .modal-add { display: none; position: fixed; top: 10%; left: 30%; background: white; padding: 20px; border: 1px solid #888; box-shadow: 0 0 10px #000; z-index: 10; }
        .overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 5; }
        button { margin: 5px; }
    </style>
</head>
<body>
<h2>Gestión de RRHH</h2>
<button onclick="abrirAgregar()">+ Agregar Personal</button>
<table>
    <tr><th>RUT</th><th>Nombre</th><th>Correo</th><th>Teléfono</th><th>Ciudad</th><th>Rol</th><th>Fecha Examen</th><th>Editar</th></tr>
    <?php foreach ($usuarios as $u): ?>
    <tr>
        <td><?= $u["rut"] ?></td><td><?= $u["nombre"] ?></td><td><?= $u["correo"] ?></td>
        <td><?= $u["telefono"] ?></td><td><?= $u["ciudad"] ?></td><td><?= $u["rol"] ?></td>
        <td><?= $u["fecha_examen"] ?? '' ?></td>
        <td><button onclick='abrirEditar(<?= json_encode($u) ?>)'>Editar</button></td>
    </tr>
    <?php endforeach; ?>
</table>

<div class="overlay" id="overlay" onclick="cerrarModal()"></div>

<!-- Modal Agregar -->
<div class="modal-add" id="modalAgregar">
  <form method="post">
    <input type="hidden" name="nuevo" value="1">
    <h3>Agregar Personal</h3>
    <p><input name="rut" placeholder="RUT" required></p>
    <p><input name="nombre" placeholder="Nombre" required></p>
    <p><input name="correo" placeholder="Correo"></p>
    <p><input name="telefono" placeholder="Teléfono"></p>
    <p><input name="ciudad" placeholder="Ciudad"></p>
    <p><input type="date" name="fecha_nacimiento"></p>
    <p><select name="rol"><option value="Usuario">Usuario</option><option value="Administrativo">Administrativo</option></select></p>
    <p><input type="date" name="fecha_examen"></p>
    <button type="submit">Guardar</button>
    <button type="button" onclick="cerrarModal()">Cancelar</button>
  </form>
</div>

<!-- Modal Editar -->
<div class="modal" id="modal">
  <form method="post">
    <input type="hidden" name="editar" value="1">
    <input type="hidden" name="rut" id="rut">
    <p><input name="nombre" id="nombre" placeholder="Nombre"></p>
    <p><input name="correo" id="correo" placeholder="Correo"></p>
    <p><input name="telefono" id="telefono" placeholder="Teléfono"></p>
    <p><input name="ciudad" id="ciudad" placeholder="Ciudad"></p>
    <p><input type="date" name="fecha_nacimiento" id="fecha_nacimiento"></p>
    <p><select name="rol" id="rol"><option value="Usuario">Usuario</option><option value="Administrativo">Administrativo</option></select></p>
    <p><input type="date" name="fecha_examen" id="fecha_examen"></p>
    <button type="submit">Guardar</button>
    <button type="button" onclick="cerrarModal()">Cancelar</button>
  </form>
</div>

<br><a href="dashboard.php">← Volver al Dashboard</a>

<script>
function abrirAgregar() {
  document.getElementById("modalAgregar").style.display = "block";
  document.getElementById("overlay").style.display = "block";
}
function abrirEditar(data) {
  document.getElementById("rut").value = data.rut;
  document.getElementById("nombre").value = data.nombre;
  document.getElementById("correo").value = data.correo;
  document.getElementById("telefono").value = data.telefono;
  document.getElementById("ciudad").value = data.ciudad;
  document.getElementById("fecha_nacimiento").value = data.fecha_nacimiento;
  document.getElementById("rol").value = data.rol;
  document.getElementById("fecha_examen").value = data.fecha_examen ?? '';
  document.getElementById("modal").style.display = "block";
  document.getElementById("overlay").style.display = "block";
}
function cerrarModal() {
  document.getElementById("modalAgregar").style.display = "none";
  document.getElementById("modal").style.display = "none";
  document.getElementById("overlay").style.display = "none";
}
</script>
</body>
</html>

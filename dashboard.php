<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$rol = $_SESSION['rol'] ?? 'Invitado';
$user = $_SESSION['user_id'] ?? 'Invitado';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel Principal</title>
  <style>
    body { margin: 0; font-family: Arial; display: flex; }
    .sidebar {
      width: 200px; background-color: #005f87; color: white;
      height: 100vh; padding-top: 20px; position: fixed;
    }
    .sidebar h3 { text-align: center; color: white; }
    .sidebar a {
      display: block; color: white; padding: 10px 20px;
      text-decoration: none; border-bottom: 1px solid #007da1;
    }
    .sidebar a:hover { background-color: #007da1; }
    .main {
      margin-left: 200px; padding: 20px; flex: 1;
    }
    .card {
      background: #f0f0f0; padding: 15px; margin-bottom: 15px;
      border-radius: 12px; box-shadow: 0 0 5px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h3>Menú</h3>
    <a href="dashboard.php">Dashboard</a>
    <?php if ($rol === 'Maestro' || $rol === 'Administrativo'): ?>
      <a href="rrhh.php">RRHH</a>
    <?php endif; ?>
    <?php if ($rol === 'Maestro'): ?>
      <a href="usuarios.php">Usuarios</a>
    <?php endif; ?>
    <?php if ($rol === 'Usuario' || $rol === 'Administrativo' || $rol === 'Maestro'): ?>
      <a href="vehiculos.php">Vehículos</a>
      <a href="vacaciones.php">Vacaciones</a>
    <?php endif; ?>
    <?php if ($rol !== 'Usuario'): ?>
      <h4 style="margin: 10px 20px 5px;">Finanzas</h4>
      <a href="finanzas/facturas.php">Facturas</a>
      <a href="finanzas/edp.php">EDP</a>
    <?php endif; ?>
    <a href="logout.php">Cerrar sesión</a>
  </div>

  <div class="main">
    <h2>Bienvenido, <?= htmlspecialchars($user) ?> (Rol: <?= htmlspecialchars($rol) ?>)</h2>
    <div class="card">
      <strong>Panel de alertas y accesos:</strong><br>
      (Aquí puedes añadir tarjetas con accesos directos o advertencias si las necesitas)
    </div>
  </div>
</body>
</html>

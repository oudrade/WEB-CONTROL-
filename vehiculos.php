<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>🚗 Vehículos</title>
    <style>
        body { font-family: Arial; margin: 20px; background-color: #f4f4f4; }
        .container { background: white; padding: 20px; border-radius: 8px; }
        .btn-retorno {
            display:inline-block;padding:10px 20px;background:#3498db;color:white;
            text-decoration:none;border-radius:5px;margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🚗 Vehículos</h2>
        <p>Este es un módulo en desarrollo.</p>
        <a href="dashboard.php" class="btn-retorno">⬅ Volver al Dashboard</a>
    </div>
</body>
</html>

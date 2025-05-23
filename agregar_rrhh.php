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
    <title>Agregar Persona - RRHH</title>
    <style>
        body { font-family: Arial; margin: 20px; background-color: #f4f4f4; }
        form { background: white; padding: 20px; border-radius: 8px; width: 400px; }
        label { display: block; margin-top: 10px; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; }
        .btn { margin-top: 15px; background-color: #9b59b6; color: white; padding: 10px; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Agregar Persona - RRHH</h2>
    <form method="post" action="guardar_rrhh.php">
        <label>RUT:</label>
        <input type="text" name="rut" required>
        <label>Nombre Completo:</label>
        <input type="text" name="nombre" required>
        <label>Ciudad:</label>
        <input type="text" name="ciudad" required>
        <label>Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" required>
        <label>Correo Electrónico:</label>
        <input type="email" name="correo" required>
        <label>Teléfono:</label>
        <input type="text" name="telefono" required>
        <label>Isapre:</label>
        <input type="text" name="isapre">
        <label>AFP:</label>
        <input type="text" name="afp">
        <label>Cargo:</label>
        <input type="text" name="cargo">
        <label>Tipo de Usuario:</label>
        <select name="tipo_usuario" required>
            <option value="Maestro">Maestro</option>
            <option value="Administrador">Administrador</option>
            <option value="Usuario">Usuario</option>
        </select>
        <button type="submit" class="btn">Guardar</button>
    </form>

    <div style='margin-top: 20px;'>
        <a href="dashboard.php" style="display:inline-block;padding:10px 20px;background:#3498db;color:white;text-decoration:none;border-radius:5px;">
            ⬅ Volver al Dashboard
        </a>
    </div>

</body>
</html>

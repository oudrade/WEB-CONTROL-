<?php
session_start();
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $rut = $_POST['rut'] ?? '';
    $clave = $_POST['password'] ?? '';
    $usuarios = json_decode(file_get_contents("rrhh.json"), true);
    foreach ($usuarios as $u) {
        if ($u['rut'] === $rut && $clave === "1234") {
            $_SESSION['user_id'] = $u['rut'];
            $_SESSION['username'] = $u['nombre'];
            $_SESSION['rol'] = $u['rol'];
            header("Location: dashboard.php");
            exit;
        }
    }
    $error = "Credenciales incorrectas.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <style>
    body { background: #d0eaff; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; }
    form { background: white; padding: 2em; border-radius: 10px; box-shadow: 0 0 10px #666; }
    input { margin-bottom: 1em; width: 100%; padding: .5em; }
    button { padding: .5em 1em; background: #0077a3; color: white; border: none; border-radius: 5px; }
  </style>
</head>
<body>
<form method="post">
  <h2>Ingreso al Sistema</h2>
  <?php if ($error): ?><p style="color:red;"><?= $error ?></p><?php endif; ?>
  <input type="text" name="rut" placeholder="RUT" required>
  <input type="password" name="password" placeholder="Contraseña" required>
  <button type="submit">Ingresar</button>
</form>
</body>
</html>

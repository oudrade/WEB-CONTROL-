<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'rut' => $_POST['rut'],
        'nombre' => $_POST['nombre'],
        'ciudad' => $_POST['ciudad'],
        'fecha_nacimiento' => $_POST['fecha_nacimiento'],
        'correo' => $_POST['correo'],
        'telefono' => $_POST['telefono'],
        'isapre' => $_POST['isapre'],
        'afp' => $_POST['afp'],
        'cargo' => $_POST['cargo'],
        'tipo_usuario' => $_POST['tipo_usuario']
    ];

    $archivo = 'rrhh.json';
    $personal = [];

    if (file_exists($archivo)) {
        $contenido = file_get_contents($archivo);
        $personal = json_decode($contenido, true);
    }

    $personal[] = $data;
    file_put_contents($archivo, json_encode($personal, JSON_PRETTY_PRINT));

    header("Location: rrhh.php");
    exit;
}
?>
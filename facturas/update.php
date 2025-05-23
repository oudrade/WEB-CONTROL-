<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$archivo = 'facturas.json';
$data = json_decode(file_get_contents($archivo), true);
$id = $_POST['id'];

$data[$id] = [
    'cliente' => $_POST['cliente'],
    'valor' => $_POST['valor'],
    'moneda' => $_POST['moneda'],
    'fecha' => $_POST['fecha'],
    'estado' => $_POST['estado']
];

file_put_contents($archivo, json_encode($data, JSON_PRETTY_PRINT));
header("Location: facturas.php");
exit;
?>

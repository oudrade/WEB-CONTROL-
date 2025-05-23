<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$archivo = 'facturas.json';
$data = json_decode(file_get_contents($archivo), true);
$id = $_GET['id'];
unset($data[$id]);
$data = array_values($data); // reindexar
file_put_contents($archivo, json_encode($data, JSON_PRETTY_PRINT));
header("Location: facturas.php");
exit;
?>

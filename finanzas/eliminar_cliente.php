<?php
$data = json_decode(file_get_contents("php://input"), true);
$index = $data['index'];
$archivo = "../clientes.json";

if (!file_exists($archivo)) {
  echo json_encode(["success" => false, "error" => "Archivo no encontrado"]);
  exit;
}

$clientes = json_decode(file_get_contents($archivo), true);

if (!isset($clientes[$index])) {
  echo json_encode(["success" => false, "error" => "Índice inválido"]);
  exit;
}

array_splice($clientes, $index, 1);
file_put_contents($archivo, json_encode($clientes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo json_encode(["success" => true]);
<?php
$data = json_decode(file_get_contents("php://input"), true);
$archivo = "../facturas.json";

$facturas = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];
$facturas[] = $data;

file_put_contents($archivo, json_encode($facturas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo json_encode(["success" => true]);

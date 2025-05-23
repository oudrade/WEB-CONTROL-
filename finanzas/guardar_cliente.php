<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['nombre'])) {
    echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
    exit;
}

$clientesFile = "../clientes.json";
$clientes = file_exists($clientesFile) ? json_decode(file_get_contents($clientesFile), true) : [];

$clientes[] = [
    "nombre" => $data["nombre"],
    "rut" => $data["rut"] ?? "",
    "direccion" => $data["direccion"] ?? "",
    "telefono" => $data["telefono"] ?? ""
];

file_put_contents($clientesFile, json_encode($clientes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo json_encode(['success' => true, 'cliente' => end($clientes)]);

<?php
$data = json_decode(file_get_contents("php://input"), true);
$archivo = "../edp.json";

$registro = [
    "edp" => $data["edp"] ?? "",
    "flexiapp" => $data["flexiapp"] ?? "",
    "centrality" => $data["centrality"] ?? "",
    "oc" => $data["oc"] ?? "",
    "detalle" => $data["detalle"] ?? "",
    "complejidad" => $data["complejidad"] ?? "",
    "monto" => $data["monto"] ?? "",
    "ito" => $data["ito"] ?? "",
    "fecha_realizado" => $data["fecha_realizado"] ?? ""
];

$edps = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];
$edps[] = $registro;

file_put_contents($archivo, json_encode($edps, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo json_encode(["success" => true]);
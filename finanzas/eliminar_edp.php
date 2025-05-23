<?php
$data = json_decode(file_get_contents("php://input"), true);
$index = $data["index"] ?? null;

if ($index === null) {
    echo json_encode(["success" => false, "error" => "No index provided"]);
    exit;
}

$archivo = "../edp.json";
$edps = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];

if (isset($edps[$index])) {
    array_splice($edps, $index, 1);
    file_put_contents($archivo, json_encode($edps, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "Invalid index"]);
}

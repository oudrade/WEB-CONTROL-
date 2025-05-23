 <?php
$data = json_decode(file_get_contents("php://input"), true);
$archivo = "../edp.json";
$index = $data["index"] ?? null;

// Validaciones
if (!is_numeric($index)) {
    echo json_encode(["success" => false, "error" => "Índice inválido"]);
    exit;
}
unset($data["index"]);

$edps = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];
if (!is_array($edps)) $edps = [];

if (!isset($edps[$index])) {
    echo json_encode(["success" => false, "error" => "Registro no encontrado"]);
    exit;
}

// Actualizar el registro
$edps[$index] = $data;
file_put_contents($archivo, json_encode($edps, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo json_encode(["success" => true]);
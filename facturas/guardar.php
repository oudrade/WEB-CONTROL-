<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $factura = [
        'numero' => $_POST['numero'],
        'folio' => $_POST['folio'],
        'fecha' => $_POST['fecha'],
        'emisor' => $_POST['emisor'],
        'cliente' => $_POST['cliente'],
        'productos' => $_POST['productos'],
        'subtotal' => floatval($_POST['subtotal']),
        'iva' => floatval($_POST['iva']),
        'total_pagar' => floatval($_POST['total_pagar']),
        'monto_total' => floatval($_POST['monto_total']),
        'abono' => floatval($_POST['abono']),
        'pago_total' => floatval($_POST['pago_total']),
    ];

    $archivo = 'facturas/facturas.json';
    $datos = [];

    if (file_exists($archivo)) {
        $contenido = file_get_contents($archivo);
        $datos = json_decode($contenido, true) ?? [];
    }

    $datos[] = $factura;

    file_put_contents($archivo, json_encode($datos, JSON_PRETTY_PRINT));
    header("Location: ../facturas.php");
    exit;
} else {
    echo "Método no permitido.";
}
?>

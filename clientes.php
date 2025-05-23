<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$archivo = 'clientes.json';
$clientes = [];

if (file_exists($archivo)) {
    $clientes = json_decode(file_get_contents($archivo), true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo = [
        'nombre' => $_POST['nombre'],
        'rut' => $_POST['rut'],
        'correo' => $_POST['correo'],
        'direccion' => $_POST['direccion'],
        'telefono' => $_POST['telefono']
    ];

    if (isset($_POST['id']) && $_POST['id'] !== '') {
        $clientes[(int)$_POST['id']] = $nuevo;
    } else {
        $clientes[] = $nuevo;
    }

    file_put_contents($archivo, json_encode($clientes, JSON_PRETTY_PRINT));
    header("Location: clientes.php");
    exit;
}

if (isset($_GET['eliminar'])) {
    $id = (int)$_GET['eliminar'];
    array_splice($clientes, $id, 1);
    file_put_contents($archivo, json_encode($clientes, JSON_PRETTY_PRINT));
    header("Location: clientes.php");
    exit;
}

$editar_id = isset($_GET['editar']) ? (int)$_GET['editar'] : null;
$editar_cliente = $editar_id !== null ? $clientes[$editar_id] : ['nombre'=>'','rut'=>'','correo'=>'','direccion'=>'','telefono'=>''];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
    <style>
        table, td, th { border: 1px solid black; border-collapse: collapse; padding: 8px; }
        th { background: #eee; }
        form { margin-top: 20px; }
    </style>
</head>
<body>
    <h2>Gestión de Clientes</h2>

    <table>
        <tr><th>Nombre</th><th>RUT</th><th>Correo</th><th>Dirección</th><th>Teléfono</th><th>Acciones</th></tr>
        <?php foreach ($clientes as $index => $c): ?>
            <tr>
                <td><?= $c['nombre'] ?></td>
                <td><?= $c['rut'] ?></td>
                <td><?= $c['correo'] ?></td>
                <td><?= $c['direccion'] ?></td>
                <td><?= $c['telefono'] ?></td>
                <td>
                    <a href="clientes.php?editar=<?= $index ?>">Editar</a> |
                    <a href="clientes.php?eliminar=<?= $index ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3><?= $editar_id !== null ? "Editar Cliente" : "Agregar Cliente" ?></h3>
    <form method="post">
        <?php if ($editar_id !== null): ?>
            <input type="hidden" name="id" value="<?= $editar_id ?>">
        <?php endif; ?>
        Nombre: <input type="text" name="nombre" value="<?= $editar_cliente['nombre'] ?>" required><br>
        RUT: <input type="text" name="rut" value="<?= $editar_cliente['rut'] ?>"><br>
        Correo: <input type="text" name="correo" value="<?= $editar_cliente['correo'] ?>"><br>
        Dirección: <input type="text" name="direccion" value="<?= $editar_cliente['direccion'] ?>"><br>
        Teléfono: <input type="text" name="telefono" value="<?= $editar_cliente['telefono'] ?>"><br>
        <button type="submit">Guardar</button>
    </form>

    <a href="dashboard.php"><button>Volver al Dashboard</button></a>
</body>
</html>

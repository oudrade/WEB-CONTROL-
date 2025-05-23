<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function verificarSesion() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
}

function esMaestro() {
    return isset($_SESSION['user_rol']) && $_SESSION['user_rol'] === 'maestro';
}
?>

<?php
    session_start();
    if (isset($_SESSION['username'])) { // Verifica si hay una sesión iniciada
        session_destroy();
        echo "<script>alert('Sesión cerrada correctamente'); window.location.href='index.php';</script>"; // Redirige a 'index'
    } else {
        echo "<script>alert('No hay una sesión iniciada'); window.location.href='index.php';</script>";
    }
    exit();
?>

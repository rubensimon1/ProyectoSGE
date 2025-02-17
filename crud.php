<?php
session_start();

// Verifica si el usuario está logueado, de lo contrario redirige a login
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

if (isset($_SESSION['usuario'])) {
    echo "Sesión iniciada: " . $_SESSION['usuario'];
} else {
    echo "No se ha iniciado sesión";
}

// Aquí va el código para mostrar las tablas del CRUD
?>

<h2>Bienvenido, <?php echo $_SESSION['usuario']; ?>!</h2>

<!-- Aquí va el código para mostrar tus tablas o el CRUD -->

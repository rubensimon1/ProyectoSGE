<?php
$host = "localhost";
$user = "root";  // Cambiar si tienes otra configuración
$pass = "";
$db = "libreria_bd";

$conn = new mysqli($host, $user, $pass, $db);

// Verifica si la conexión es exitosa
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>

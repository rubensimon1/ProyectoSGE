<?php
session_start();
include 'conexion.php'; // Incluye la conexión a la base de datos

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica que las claves 'usuario' y 'password' existan en el formulario POST
    if (isset($_POST['usuario']) && isset($_POST['password'])) {
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];

        // Depuración: Verifica que los datos estén siendo enviados correctamente
        echo "Usuario: " . $usuario . "<br>";
        echo "Contraseña: " . $password . "<br>";

        // Consulta para verificar el usuario y la contraseña en la base de datos
        $sql = "SELECT * FROM usuarios WHERE usuario = ?";
        $stmt = $conn->prepare($sql); // Aquí cambiamos $mysqli por $conn
        $stmt->bind_param('s', $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Verificar si el usuario existe en la base de datos
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();

            // Verificar la contraseña (usando password_verify si tienes contraseñas cifradas)
            if (password_verify($password, $fila['password'])) {
                // Usuario autenticado correctamente
                $_SESSION['usuario'] = $usuario; // Guardamos la sesión del usuario

                // Depuración: Verifica que la sesión se ha guardado
                echo "Sesión iniciada correctamente: " . $_SESSION['usuario'] . "<br>";

                // Redirigir al CRUD
                header('Location: crud.php'); // Cambia esto a la página del CRUD
                exit();
            } else {
                echo "Contraseña incorrecta";
            }
        } else {
            echo "Usuario no encontrado";
        }
    } else {
        echo "Usuario o contraseña no proporcionados";
    }
}
?>

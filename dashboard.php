<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: index.html");
    exit();
}

require "config.php"; // Conexión a la base de datos

// Agregar producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"])) {
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];
    $sql = "INSERT INTO productos (nombre, precio) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sd", $nombre, $precio);
    $stmt->execute();
}

// Eliminar producto
if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    $conn->query("DELETE FROM productos WHERE id = $id");
    header("Location: dashboard.php");
    exit();
}

// Obtener productos
$result = $conn->query("SELECT * FROM productos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Bienvenido, <?php echo $_SESSION["usuario"]; ?>!</h2>
    <a href="logout.php">Cerrar sesión</a>

    <h3>Agregar Producto</h3>
    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre del producto" required>
        <input type="number" step="0.01" name="precio" placeholder="Precio" required>
        <button type="submit">Guardar</button>
    </form>

    <h3>Lista de Productos</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row["id"]; ?></td>
            <td><?php echo $row["nombre"]; ?></td>
            <td><?php echo $row["precio"]; ?></td>
            <td>
                <a href="dashboard.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('¿Eliminar este producto?');">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

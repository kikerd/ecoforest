<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'ecoforest');

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.html");
    exit();
}

// Obtener lista de usuarios
$query = "SELECT id, nombre, apellido, usuario, correo, rol FROM usuarios";
$result = $conn->query($query);

// Actualizar rol de usuario
if (isset($_POST['actualizar_rol'])) {
    $usuario_id = $_POST['usuario_id'];
    $nuevo_rol = $_POST['nuevo_rol'];
    $conn->query("UPDATE usuarios SET rol = '$nuevo_rol' WHERE id = $usuario_id");
    header("Location: gestionar_usuarios.php");
    exit();
}

// Eliminar usuario
if (isset($_POST['eliminar_usuario'])) {
    $usuario_id = $_POST['usuario_id'];
    $conn->query("DELETE FROM usuarios WHERE id = $usuario_id");
    header("Location: gestionar_usuarios.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        table { width: 80%; margin: auto; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 10px; }
        th { background-color: #4CAF50; color: white; }
        .btn { padding: 5px 10px; margin: 5px; cursor: pointer; }
        .btn-edit { background-color: #f0ad4e; color: white; }
        .btn-delete { background-color: #d9534f; color: white; }
    </style>
</head>
<body>
    <h2>Gestión de Usuarios</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Usuario</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['nombre'] ?></td>
            <td><?= $row['apellido'] ?></td>
            <td><?= $row['usuario'] ?></td>
            <td><?= $row['correo'] ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="usuario_id" value="<?= $row['id'] ?>">
                    <select name="nuevo_rol">
                        <option value="usuario" <?= $row['rol'] == 'usuario' ? 'selected' : '' ?>>Usuario</option>
                        <option value="admin" <?= $row['rol'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                    <button type="submit" name="actualizar_rol" class="btn btn-edit">Actualizar</button>
                </form>
            </td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="usuario_id" value="<?= $row['id'] ?>">
                    <button type="submit" name="eliminar_usuario" class="btn btn-delete" onclick="return confirm('¿Seguro que quieres eliminar este usuario?');">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="admin.php">Volver al panel de administración</a>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: index.html'); // Redirigir si no es admin
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'ecoforest');
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener cantidad de usuarios
$result = $conn->query("SELECT COUNT(*) AS total FROM usuarios");
$totalUsuarios = $result->fetch_assoc()['total'];

// Obtener usuarios registrados recientemente
$usuariosRecientes = $conn->query("SELECT id, usuario, correo, rol FROM usuarios ORDER BY id DESC LIMIT 5");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2a3d33;
            color: white;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #3e4a41;
            border-radius: 10px;
            text-align: center;
        }
        h1 { color: #4CAF50; }
        .estadisticas, .usuarios {
            margin: 20px 0;
            padding: 15px;
            background-color: #1c2b1f;
            border-radius: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #4CAF50;
        }
        th { background-color: #4CAF50; }
        .btn {
            display: inline-block;
            margin: 10px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover { background-color: #45a049; }
        .logout {
            background-color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Panel de Administrador</h1>
        <p>Bienvenido, <b><?php echo $_SESSION['usuario']; ?></b></p>

        <div class="estadisticas">
            <h2>Estadísticas</h2>
            <p><b>Total de Usuarios:</b> <?php echo $totalUsuarios; ?></p>
        </div>

        <div class="usuarios">
            <h2>Últimos Usuarios Registrados</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Rol</th>
                </tr>
                <?php while ($row = $usuariosRecientes->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['usuario']; ?></td>
                    <td><?php echo $row['correo']; ?></td>
                    <td><?php echo $row['rol']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <a href="gestionar_usuario.php" class="btn">Gestionar Usuarios</a>
        <a href="logout.php" class="btn logout">Cerrar Sesión</a>
    </div>
</body>
</html>

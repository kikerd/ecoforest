<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'ecoforest');

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Manejo del login
    if (isset($_POST['login'])) {
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
        $query = "SELECT id, password FROM usuarios WHERE usuario = '$usuario'";
        $result = $conn->query($query);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verificar la contraseña con password_verify
            if (password_verify($password, $row['password'])) {
                $_SESSION['usuario_id'] = $row['id'];
                $_SESSION['usuario'] = $usuario;
                header('Location: formulario.php');
            } else {
                $mensaje = "Usuario o contraseña incorrectos";
            }
        } else {
            $mensaje = "Usuario o contraseña incorrectos";
        }
    }
    
    // Manejo del registro
    if (isset($_POST['registro'])) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $correo = $_POST['correo'];
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];

        // Encriptar la contraseña
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO usuarios (nombre, apellido, correo, usuario, password) 
                  VALUES ('$nombre', '$apellido', '$correo', '$usuario', '$password_hash')";
        
        if ($conn->query($query) === TRUE) {
            $mensaje = "Registro exitoso";
        } else {
            $mensaje = "Error: " . $conn->error;
        }
    }
    
    // Guardar formulario
    if (isset($_POST['guardar_formulario'])) {
        if (!isset($_SESSION['usuario_id'])) {
            $mensaje = "Debes iniciar sesión primero.";
            exit();
        }
        
        $dato1 = $_POST['dato1'];
        $dato2 = $_POST['dato2'];
        $usuario_id = $_SESSION['usuario_id'];

        $query = "INSERT INTO formularios (usuario_id, dato1, dato2) 
                  VALUES ('$usuario_id', '$dato1', '$dato2')";
        
        if ($conn->query($query) === TRUE) {
            $mensaje = "Formulario guardado exitosamente";
        } else {
            $mensaje = "Error: " . $conn->error;
        }
    }
    
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login, Registro y Formulario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2a3d33; /* Verde oscuro */
            color: white;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #ffffff;
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #3e4a41; /* Un verde un poco más claro */
            border-radius: 10px;
        }

        input[type="text"], input[type="password"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background-color: #495c50;
            color: white;
            border: 1px solid #7a8c82;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50; /* Verde brillante */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .barra-superior {
            background-color: #1c2b1f;
            text-align: center;
            padding: 15px 0;
            font-size: 24px;
            font-weight: bold;
        }

        .barra-inferior {
            background-color: #1c2b1f;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 14px;
        }

        /* Estilo para el mensaje en la esquina inferior izquierda */
        .mensaje {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="barra-superior">
        EcoForest
    </div>

    <h2>Login</h2>
    <form method="POST">
        Usuario: <input type="text" name="usuario" required><br>
        Contraseña: <input type="password" name="password" required><br>
        <button type="submit" name="login">Ingresar</button>
    </form>
    
    <h2>Registro</h2>
    <form method="POST">
        Nombre: <input type="text" name="nombre" required><br>
        Apellido: <input type="text" name="apellido" required><br>
        Correo Electrónico: <input type="email" name="correo" required><br>
        Usuario: <input type="text" name="usuario" required><br>
        Contraseña: <input type="password" name="password" required><br>
        <button type="submit" name="registro">Registrar</button>
    </form>

    <!-- Mensaje en la esquina inferior izquierda -->
    <div class="mensaje" id="mensaje">
        <?php if (isset($mensaje)) echo $mensaje; ?>
    </div>

    <div class="barra-inferior">
        &copy; 2025 EcoForest. Todos los derechos reservados.
    </div>

    <script>
        // Mostrar el mensaje si existe
        <?php if (isset($mensaje)): ?>
            document.getElementById('mensaje').style.display = 'block';
            setTimeout(function() {
                document.getElementById('mensaje').style.display = 'none';
            }, 5000); // El mensaje se oculta después de 5 segundos
        <?php endif; ?>
    </script>
</body>
</html>

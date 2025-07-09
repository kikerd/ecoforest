<!DOCTYPE html>
<html>
<head>
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form action="procesar_recuperacion.php" method="POST">
        <input type="email" name="email" placeholder="Ingresa tu correo" required>
        <button type="submit">Enviar enlace de recuperación</button>
    </form>
    <style>
        body {
    font-family: Arial, sans-serif;
    text-align: center;
    background-color: #f4f4f4;
}
form {
    display: inline-block;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
}
input, button {
    display: block;
    width: 100%;
    margin: 10px 0;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
button {
    background-color: #28a745;
    color: white;
    cursor: pointer;
}
button:hover {
    background-color: #218838;
}
    </style>
</body>
</html>
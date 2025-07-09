<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(50));
        $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $stmt = $conn->prepare("INSERT INTO recuperaciones (email, token, expira) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $token, $expira);
        $stmt->execute();
        
        $enlace = "http://localhost/recuperar_password.php?token=" . $token;
        mail($email, "Recuperación de contraseña", "Haz clic en: " . $enlace);

        echo "Se ha enviado un enlace de recuperación a tu correo.";
    } else {
        echo "El correo no está registrado.";
    }
}
?>
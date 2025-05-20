<?php
session_start();
require_once("../includes/conexion.php"); // $conn es un objeto PDO

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';

    if (empty($usuario) || empty($contrasena)) {
        $error = "Por favor, completa todos los campos.";
    } else {
        $sql = "SELECT id, usuario, contrasena FROM usuarios WHERE usuario = :usuario OR correo = :usuario LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['usuario' => $usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($contrasena, $user['contrasena'])) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nombre'] = $user['usuario'];
            header("Location: ../index.php");
            exit;
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    }
}
?>




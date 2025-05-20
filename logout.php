<?php
session_start();

// Destruye todas las variables de sesión
$_SESSION = [];

// Destruye la sesión
session_destroy();

// Redirige al index o a login
header("Location: index.php");
exit;

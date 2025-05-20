<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Tienda Gym Virtual</title>
  <link rel="stylesheet" href="/css/estilos.css" />
</head>
<body>
  <header>
    <nav class="navbar">
      <ul>
        <li><a href="/index.php">Inicio</a></li>
        <li><a href="/catalogo.php">Catálogo</a></li>

        <?php if (isset($_SESSION['usuario'])): ?>
          <li><a href="#">Hola, <?php echo htmlspecialchars($_SESSION['usuario']); ?></a></li>
          <li><a href="/controllers/logout.php">Cerrar sesión</a></li>
        <?php else: ?>
          <li><a href="/login.html">Iniciar sesión</a></li>
          <li><a href="/register.html">Registrarse</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>

<nav>
  <ul>
    <li><a href="index.php">Inicio</a></li>
    <li><a href="catalogo.php">Catálogo</a></li>
    <?php if (isset($_SESSION['usuario'])): ?>
      <li><a href="logout.php">Cerrar sesión (<?= $_SESSION['usuario'] ?>)</a></li>
    <?php else: ?>
      <li><a href="login.html">Iniciar sesión</a></li>
      <li><a href="register.html">Registrarse</a></li>
    <?php endif; ?>
  </ul>
</nav>

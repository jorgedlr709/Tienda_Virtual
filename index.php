<?php
session_start();
?>

<!DOCTYPE html>

<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Tienda Gym - Inicio</title>
  <link rel="stylesheet" href="css/estilo_index.css" />
</head>
<body>

  <nav>
    <div class="logo">Tienda Gym</div>
    <div>
      <a href="index.php">Inicio</a>
      <a href="controllers/tienda.php">Tienda</a>
      <?php if (isset($_SESSION['usuario_nombre'])): ?>
        <a href="logout.php">Cerrar sesión (<?=htmlspecialchars($_SESSION['usuario_nombre'])?>)</a>
      <?php else: ?>
        <a href="login.html">Iniciar sesión</a>
        <a href="controllers/register.php">Registrarse</a>
      <?php endif; ?>
    </div>
  </nav>

  <section class="hero">
    <h1>Ropa y accesorios para tu entrenamiento</h1>
    <?php if (isset($_SESSION['usuario_nombre'])): ?>
      <p>Hola, <?=htmlspecialchars($_SESSION['usuario_nombre'])?>! Gracias por iniciar sesión.</p>
    <?php else: ?>
      <p>Descubre productos de alta calidad diseñados para potenciar tu rendimiento y estilo.</p>
    <?php endif; ?>
  </section>

  <section class="beneficios">
    <div class="beneficio">
      <img src="img/icons/calidad.png" alt="Alta calidad" />
      <h3>Alta calidad</h3>
      <p>Solo trabajamos con las mejores marcas y materiales resistentes.</p>
    </div>
    <div class="beneficio">
      <img src="img/icons/envios.png" alt="Envíos rápidos" />
      <h3>Envíos rápidos</h3>
      <p>Recibe tu pedido en tiempo récord con nuestro servicio express.</p>
    </div>
    <div class="beneficio">
      <img src="img/icons/precios.png" alt="Precios competitivos" />
      <h3>Precios competitivos</h3>
      <p>Ofrecemos los mejores precios del mercado sin sacrificar calidad.</p>
    </div>
    <div class="beneficio">
      <img src="img/icons/atencion.png" alt="Atención personalizada" />
      <h3>Atención personalizada</h3>
      <p>Estamos para ayudarte en cada paso de tu compra y entrenamiento.</p>
    </div>
  </section>

  <footer>
    &copy; <?=date('Y')?> Tienda Gym. Todos los derechos reservados.
  </footer>

</body>
</html>





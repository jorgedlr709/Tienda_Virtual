<?php
session_start();
include("../includes/conexion.php");

$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

if ($busqueda !== '') {
    $sql = "SELECT id, nombre, descripcion, precio, imagen 
            FROM productos 
            WHERE nombre LIKE :busqueda OR descripcion LIKE :busqueda";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':busqueda' => "%$busqueda%"]);
} else {
    $sql = "SELECT id, nombre, descripcion, precio, imagen FROM productos";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalCarrito = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $totalCarrito += $item['cantidad'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Tienda - Tienda Gym</title>
  <link rel="stylesheet" href="/Tienda_Virtual/css/estilo_tienda.css">
</head>
<body>

<nav>
  <div class="nav-left">
    <a href="/Tienda_Virtual/index.php">Inicio</a>
    <a href="/Tienda_Virtual/controllers/tienda.php">Tienda</a>
    <?php if (isset($_SESSION['usuario_nombre'])): ?>
      <a href="/Tienda_Virtual/logout.php">Cerrar sesión (<?=htmlspecialchars($_SESSION['usuario_nombre'])?>)</a>
    <?php else: ?>
      <a href="/Tienda_Virtual/login.html">Iniciar sesión</a>
      <a href="/Tienda_Virtual/controllers/register.php">Registrarse</a>
    <?php endif; ?>
  </div>

  <div class="nav-right">
    <form id="buscar-form" method="get" action="tienda.php">
      <input type="text" name="busqueda" id="buscar" placeholder="Buscar..." value="<?= htmlspecialchars($busqueda) ?>">
      <span class="icono-busqueda"></span>
    </form>
    <a class="carrito-icono" href="/Tienda_Virtual/controllers/carrito.php" title="Ver carrito">
      🛒
      <?php if ($totalCarrito > 0): ?>
        <span class="carrito-contador"><?= $totalCarrito ?></span>
      <?php endif; ?>
    </a>
  </div>
</nav>

<main>
  <header>
    <h1>Catálogo de Productos</h1>
    <?php if ($busqueda !== ''): ?>
      <p style="text-align:center;">Resultados para: <strong><?= htmlspecialchars($busqueda) ?></strong></p>
    <?php endif; ?>
  </header>

  <section class="productos">
    <?php if (count($productos) === 0): ?>
      <p style="text-align:center;">No se encontraron productos.</p>
    <?php else: ?>
      <div class="grid-productos">
        <?php foreach ($productos as $producto): ?>
          <article class="producto">
            <img src="/Tienda_Virtual/img/productos/<?=htmlspecialchars($producto['imagen'])?>" alt="<?=htmlspecialchars($producto['nombre'])?>" />
            <h3><?=htmlspecialchars($producto['nombre'])?></h3>
            <p><?=htmlspecialchars($producto['descripcion'])?></p>
            <p><strong><?=number_format($producto['precio'], 2)?> €</strong></p>

            <?php if (isset($_SESSION['usuario_id'])): ?>
              <form action="/Tienda_Virtual/controllers/agregar_carrito.php" method="post">
                <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                <button type="submit">Añadir al carrito</button>
              </form>
            <?php else: ?>
              <p><a href="/Tienda_Virtual/login.html">Inicia sesión para añadir al carrito</a></p>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>
</main>

<footer>
  &copy; <?=date('Y')?> Tienda Gym. Todos los derechos reservados.
</footer>

</body>
</html>


 
















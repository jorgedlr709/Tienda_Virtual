<?php
session_start();
include("../includes/conexion.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.html");
    exit();
}

$carrito = $_SESSION['carrito'] ?? [];

$productos = [];

if (!empty($carrito)) {
    $ids = implode(',', array_keys($carrito));
    $stmt = $conn->query("SELECT * FROM productos WHERE id IN ($ids)");
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Tu carrito - Tienda Gym</title>
  <link rel="stylesheet" href="/Tienda_Virtual/css/estilo_carrito.css">
</head>
<body>

<header>
  Tu carrito de compras
</header>

<main>
  <a href="/Tienda_Virtual/controllers/tienda.php" class="volver-tienda">← Volver a tienda</a>

  <?php if (empty($productos)): ?>
    <p>Tu carrito está vacío.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Imagen</th>
          <th>Producto</th>
          <th>Precio</th>
          <th>Cantidad</th>
          <th>Total</th>
          <th>Eliminar</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $total = 0;
        foreach ($productos as $producto):
          $cantidad = $carrito[$producto['id']]['cantidad'];
          $subtotal = $cantidad * $producto['precio'];
          $total += $subtotal;
        ?>
        <tr>
          <td>
            <img class="producto-img" src="/Tienda_Virtual/img/productos/<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
          </td>
          <td><?= htmlspecialchars($producto['nombre']) ?></td>
          <td><?= number_format($producto['precio'], 2) ?> €</td>
          <td><?= $cantidad ?></td>
          <td><?= number_format($subtotal, 2) ?> €</td>
          <td>
            <form class="eliminar-form" method="post" action="/Tienda_Virtual/controllers/eliminar_producto.php">
              <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
              <button type="submit">Eliminar</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <h3>Total: <?= number_format($total, 2) ?> €</h3>
    <form action="/Tienda_Virtual/controllers/procesar_compra.php" method="POST">
      <button type="submit">Finalizar compra</button>
    </form>
  <?php endif; ?>
</main>

<footer>
  &copy; <?=date('Y')?> Tienda Gym. Todos los derechos reservados.
</footer>

</body>
</html>








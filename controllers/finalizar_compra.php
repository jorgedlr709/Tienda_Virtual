<?php
session_start();
include("../includes/conexion.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.html");
    exit();
}

$carrito = $_SESSION['carrito'] ?? [];

if (empty($carrito)) {
    header("Location: /Tienda_Virtual/controllers/tienda.php");
    exit();
}

$productos = [];
$ids = implode(',', array_keys($carrito));
$stmt = $conn->query("SELECT * FROM productos WHERE id IN ($ids)");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcular total
$total = 0;
foreach ($productos as $producto) {
    $cantidad = $carrito[$producto['id']]['cantidad'];
    $subtotal = $producto['precio'] * $cantidad;
    $total += $subtotal;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Finalizar compra - Tienda Gym</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f8f8;
            padding: 20px;
            max-width: 900px;
            margin: 0 auto;
        }
        h1 {
            color: #007bff;
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        th, td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
        img.producto-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
        .total {
            text-align: right;
            font-size: 1.3rem;
            margin-bottom: 30px;
        }
        button {
            background-color: #28a745;
            border: none;
            padding: 15px 30px;
            font-size: 1.2rem;
            color: white;
            cursor: pointer;
            border-radius: 8px;
            display: block;
            margin: 0 auto;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #218838;
        }
        .volver {
            display: block;
            margin: 20px auto;
            text-align: center;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        .volver:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <h1>Finalizar compra</h1>

    <table>
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Producto</th>
                <th>Precio unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): 
                $cantidad = $carrito[$producto['id']]['cantidad'];
                $subtotal = $producto['precio'] * $cantidad;
            ?>
            <tr>
                <td><img class="producto-img" src="/Tienda_Virtual/img/productos/<?=htmlspecialchars($producto['imagen'])?>" alt="<?=htmlspecialchars($producto['nombre'])?>"></td>
                <td><?=htmlspecialchars($producto['nombre'])?></td>
                <td><?=number_format($producto['precio'], 2)?> €</td>
                <td><?= $cantidad ?></td>
                <td><?=number_format($subtotal, 2)?> €</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total"><strong>Total: <?=number_format($total, 2)?> €</strong></div>

    <form action="/Tienda_Virtual/controllers/procesar_compra.php" method="POST">
        <button type="submit">Confirmar compra</button>
    </form>

    <a href="/Tienda_Virtual/controllers/carrito.php" class="volver">← Volver al carrito</a>

</body>
</html>

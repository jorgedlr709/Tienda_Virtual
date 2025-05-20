<?php
session_start();
include("../includes/conexion.php");

// Comprobar que usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.html");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$carrito = $_SESSION['carrito'] ?? [];

if (empty($carrito)) {
    // No hay productos para comprar
    header("Location: /Tienda_Virtual/carrito.php");
    exit();
}

try {
    // Empezar transacción para que todo sea atómico
    $conn->beginTransaction();

    $fecha_compra = date('Y-m-d H:i:s');

    // Preparar statement para insertar en compras
    $stmt = $conn->prepare("INSERT INTO compras (cliente_id, producto_id, cantidad, fecha_compra) VALUES (:cliente_id, :producto_id, :cantidad, :fecha_compra)");

    // Insertar cada producto
    foreach ($carrito as $producto_id => $info) {
        $cantidad = $info['cantidad'];

        $stmt->execute([
            ':cliente_id' => $usuario_id,
            ':producto_id' => $producto_id,
            ':cantidad' => $cantidad,
            ':fecha_compra' => $fecha_compra
        ]);
    }

    // Confirmar transacción
    $conn->commit();

    // Vaciar carrito
    unset($_SESSION['carrito']);

    // Redirigir a página de éxito o agradecimiento
    header("Location: /Tienda_Virtual/compra_exitosa.php");
    exit();

} catch (PDOException $e) {
    // Si falla, deshacer cambios
    $conn->rollBack();
    echo "Error al procesar la compra: " . $e->getMessage();
    exit();
}

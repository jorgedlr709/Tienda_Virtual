<?php
session_start();

// Cambié a 'usuario_id' para que sea coherente con tu login.php
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar que producto_id venga y sea un número
    if (isset($_POST['producto_id']) && is_numeric($_POST['producto_id'])) {
        $producto_id = (int) $_POST['producto_id'];

        // Carrito en sesión
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Si ya existe, incrementar cantidad
        if (isset($_SESSION['carrito'][$producto_id])) {
            $_SESSION['carrito'][$producto_id]['cantidad'] += 1;
        } else {
            // Agregar nuevo producto con cantidad 1
            $_SESSION['carrito'][$producto_id] = [
                'cantidad' => 1
            ];
        }

        header("Location: ../controllers/tienda.php?mensaje=producto_agregado");
        exit();
    } else {
        // Producto no válido, redirigir o mostrar error
        header("Location: ../controllers/tienda.php?error=producto_invalido");
        exit();
    }
} else {
    // Método no permitido
    header("Location: ../controllers/tienda.php");
    exit();
}
?>


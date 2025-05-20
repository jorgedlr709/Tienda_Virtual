<?php
include("../includes/conexion.php");

$errores = [];
$datos = [
    'nombre' => '',
    'apellidos' => '',
    'correo' => '',
    'fecha_nacimiento' => '',
    'genero' => '',
    'usuario' => '',
    'contrasena' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $campos = ['nombre', 'apellidos', 'correo', 'fecha_nacimiento', 'genero', 'usuario', 'contrasena'];
    foreach ($campos as $campo) {
        if (empty(trim($_POST[$campo] ?? ''))) {
            $errores[] = "Por favor, completa el campo: $campo";
        } else {
            $datos[$campo] = trim($_POST[$campo]);
        }
    }

    if (!$errores) {
        $sqlUsuario = "SELECT id FROM usuarios WHERE usuario = :usuario";
        $stmtUsuario = $conn->prepare($sqlUsuario);
        $stmtUsuario->execute(['usuario' => $datos['usuario']]);
        if ($stmtUsuario->fetch()) {
            $errores[] = "El nombre de usuario ya está registrado.";
        }

        $sqlCorreo = "SELECT id FROM clientes WHERE correo = :correo";
        $stmtCorreo = $conn->prepare($sqlCorreo);
        $stmtCorreo->execute(['correo' => $datos['correo']]);
        if ($stmtCorreo->fetch()) {
            $errores[] = "El correo ya está registrado.";
        }
    }

    if (!$errores) {
        $contrasenaHash = password_hash($datos['contrasena'], PASSWORD_DEFAULT);

        $sqlUsuarios = "INSERT INTO usuarios (usuario, contrasena, correo) VALUES (:usuario, :contrasena, :correo)";
        $stmtUsuarios = $conn->prepare($sqlUsuarios);
        $stmtUsuarios->execute([
            'usuario' => $datos['usuario'],
            'contrasena' => $contrasenaHash,
            'correo' => $datos['correo']
        ]);

        $sqlClientes = "INSERT INTO clientes (nombre, apellidos, correo, fecha_nacimiento, genero) VALUES (:nombre, :apellidos, :correo, :fecha_nacimiento, :genero)";
        $stmtClientes = $conn->prepare($sqlClientes);
        $stmtClientes->execute([
            'nombre' => $datos['nombre'],
            'apellidos' => $datos['apellidos'],
            'correo' => $datos['correo'],
            'fecha_nacimiento' => $datos['fecha_nacimiento'],
            'genero' => $datos['genero']
        ]);

        echo "Registro exitoso. Redirigiendo al login...";
        echo '<script>
            setTimeout(function() {
                window.location.href = "../login.html";
            }, 2000);
        </script>';
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Registro - Tienda Gym</title>
  <link rel="stylesheet" href="../css/estilo_register.css" />
</head>
<body>

  <div class="registro-container">
    <h2>Registro de Usuario</h2>

    <?php if ($errores): ?>
      <div class="errores">
        <ul>
          <?php foreach ($errores as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form action="" method="POST" novalidate>
      <label for="usuario">Usuario</label>
      <input type="text" id="usuario" name="usuario" required autocomplete="username" value="<?= htmlspecialchars($datos['usuario']) ?>" />

      <label for="contrasena">Contraseña</label>
      <input type="password" id="contrasena" name="contrasena" required autocomplete="new-password" />

      <label for="nombre">Nombre</label>
      <input type="text" id="nombre" name="nombre" required value="<?= htmlspecialchars($datos['nombre']) ?>" />

      <label for="apellidos">Apellidos</label>
      <input type="text" id="apellidos" name="apellidos" required value="<?= htmlspecialchars($datos['apellidos']) ?>" />

      <label for="correo">Correo electrónico</label>
      <input type="email" id="correo" name="correo" required autocomplete="email" value="<?= htmlspecialchars($datos['correo']) ?>" />

      <label for="fecha_nacimiento">Fecha de nacimiento</label>
      <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required value="<?= htmlspecialchars($datos['fecha_nacimiento']) ?>" />

      <label for="genero">Género</label>
      <select id="genero" name="genero" required>
        <option value="" <?= $datos['genero'] === '' ? 'selected' : '' ?>>Selecciona</option>
        <option value="Masculino" <?= $datos['genero'] === 'Masculino' ? 'selected' : '' ?>>Masculino</option>
        <option value="Femenino" <?= $datos['genero'] === 'Femenino' ? 'selected' : '' ?>>Femenino</option>
        <option value="Otro" <?= $datos['genero'] === 'Otro' ? 'selected' : '' ?>>Otro</option>
      </select>

      <button type="submit">Registrarse</button>
    </form>

    <p class="text-center">¿Ya tienes cuenta? <a href="../login.html">Inicia sesión</a></p>
  </div>

</body>
</html>









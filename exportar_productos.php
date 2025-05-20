<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include("includes/conexion.php"); 

try {
    // Consulta todos los productos
    $stmt = $conn->query("SELECT * FROM productos");
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$productos) {
        echo "No hay productos para exportar.";
        exit;
    }

    // Crear objeto XML
    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><catalogo></catalogo>');

    foreach ($productos as $producto) {
        $productoXML = $xml->addChild('producto');
        $productoXML->addChild('id', $producto['id']);
        $productoXML->addChild('nombre', htmlspecialchars($producto['nombre']));
        $productoXML->addChild('descripcion', htmlspecialchars($producto['descripcion']));
        $productoXML->addChild('precio', $producto['precio']);
        $productoXML->addChild('stock', $producto['stock']);
        $productoXML->addChild('imagen', htmlspecialchars($producto['imagen']));
    }

    // Guardar el archivo XML en el servidor
    $archivo = 'catalogo.xml';
    $xml->asXML($archivo);

    echo "Archivo XML generado correctamente: <a href='$archivo' download>Descargar catálogo</a>";

} catch (PDOException $e) {
    echo "Error en la consulta o conexión: " . $e->getMessage();
}
?>


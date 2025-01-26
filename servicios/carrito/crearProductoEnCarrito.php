<?php
include_once __DIR__ . '/../../gestores/GestorCarrito.php';
include_once __DIR__ . '/../../gestores/GestorProducto.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$gestorCarrito = new GestorCarrito();
$gestorProducto = new GestorProducto();

$idProducto = $_POST['id'] ?? null;

if (!$idProducto) {
    header('Location: ../../vista/producto/producto-detalle.php?id=' . $idProducto . '&error=EsteProductoNoExiste');
    exit();
}


try {
    // comprueba si el producto existe
    $producto = $gestorProducto->getProducto($idProducto);

    // añade el producto al carrito
    $gestorCarrito->anyadirProductoCarrito($idProducto);
} catch (Exception $e) {
    header('Location: ../../vista/producto/producto-detalle.php?id=' . $idProducto . '&error=' . $e->getMessage());
    exit();
}

header('Location: ../../vista/producto/producto-detalle.php?id=' . $idProducto);
exit();


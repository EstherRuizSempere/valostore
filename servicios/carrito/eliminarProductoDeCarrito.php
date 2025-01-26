<?php

include_once __DIR__ . '/../../gestores/GestorCarrito.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$gestorCarrito = new GestorCarrito();

$idProducto = $_POST['id'] ?? null;

if (!$idProducto) {
    header('Location: ../../vista/carrito/carrito.php?id=' . $idProducto . '&error=EsteProductoNoExiste');
    exit();
}

$gestorCarrito->eliminarProducto($idProducto);

header('Location: ../../vista/carrito/carrito.php');

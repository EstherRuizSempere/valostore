<?php
include_once __DIR__ . '/../../gestores/GestorPedido.php';
include_once __DIR__ . '/../../gestores/GestorCarrito.php';

$idPedido = $_GET['idPedido'];

$gestorPedido = new GestorPedido();
$gestorCarrito = new GestorCarrito();

$gestorPedido->cambiarEstadoPedido($idPedido, 'pendiente');

$gestorCarrito->vaciarCarrito();

header('Location: ../../vista/pedido/transferencia.php?idPedido=' . $idPedido);

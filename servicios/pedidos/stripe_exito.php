<?php
include_once __DIR__ . '/../../gestores/GestorPedido.php';
include_once __DIR__ . '/../../gestores/GestorCarrito.php';


$idPedido = $_GET['idPedido'];

$gestorPedido = new GestorPedido();
$gestorCarrito = new GestorCarrito();
$gestorPedidoUsuarioProducto = new GestorUsuarioProducto();
$gestorLineaPedido = new GestorLineaPedido();

$gestorPedido->cambiarEstadoPedido($idPedido, 'aprobado');
$gestorPedido->cambiarMetodoPagoPedido($idPedido, 'tarjeta');

$gestorCarrito->vaciarCarrito();

header('Location: ../../vista/pedido/confirmacionPedido.php?idPedido=' . $idPedido);

<?php

include_once __DIR__ . '/../../gestores/GestorPedido.php';

$gestorPedido = new GestorPedido();
//Llamo al id del pedido
$idPedido = $_POST['id'] ?? null;
//Capturo el estado del pedido
$estadoPedido = $_POST['estado'] ?? null;

//Compruebo que id pedido y estado pedido no sea nulo:
if ($idPedido === null || $estadoPedido === null) {
    header('Location: /vista/backoffice/pedidos/detallePedido.php?error=ErrorAlCambiarElEstado&id=' . $idPedido);
    exit();
}
try {


//Cambio el estado que he seleccionado
    $gestorPedido->cambiarEstadoPedido($idPedido, $estadoPedido);
}catch (Exception $e) {
    header('Location: /vista/backoffice/pedidos/detallePedido.php?error=ErrorAlCambiarElEstado&id=' . $idPedido);
    exit();
}

header('Location: /vista/backoffice/pedidos/detallePedido.php?id=' . $idPedido);
exit();



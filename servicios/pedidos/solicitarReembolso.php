<?php

include_once __DIR__ . '/../../gestores/GestorPedido.php';

$gestorPedido = new GestorPedido();

$idPedido = $_POST['id'] ?? null;

//Compruebo que id pedido y estado pedido no sea nulo:
if ($idPedido === null) {
    header('Location: /vista/usuario/normal/misPedidos.php?error=ErrorAlCambiarElEstado');
    exit();
}

try {


//Cambio el estado que he seleccionado
    $gestorPedido->cambiarEstadoPedido($idPedido, "reembolsado");
}catch (Exception $e) {
    header('Location: /vista/pedido/detallePedidoUsuario.php?error=ErrorAlCambiarElEstado&id=' . $idPedido);
    exit();
}

header('Location: /vista/pedido/detallePedidoUsuario.php?id=' . $idPedido);
exit();



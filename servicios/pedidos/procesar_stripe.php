<?php
include_once __DIR__ . '/../../constantes/clavesStripe.php';
include_once __DIR__ . '/../../gestores/GestorPedido.php';
include_once __DIR__ . '/../../gestores/GestorLineaPedido.php';
require __DIR__ . '/../../vendor/autoload.php';

$idPedido = $_POST['idPedido'];

\Stripe\Stripe::setApiKey(Stripe::$claveSecreta);

$gestorLineaPedido = new GestorLineaPedido();
$lineasPedido = $gestorLineaPedido->getLineasDePedido($idPedido);

$lineasPedidoStrype = [];

foreach ($lineasPedido as $lineaPedido) {
    $lineasPedidoStrype[] = [
        "quantity" => 1,
        "price_data" => [
            "currency" => "eur",
            "unit_amount" => $lineaPedido->getPrecio() * 100,
            "product_data" => [
                "name" => $lineaPedido->getNombre()
            ]
        ]
    ];
}


$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "payment_method_types" => ["card"],
    "success_url" => "http://lolstore.test/servicios/pedidos/stripe_exito.php?idPedido=" . $idPedido,
    "line_items" => $lineasPedidoStrype
]);

http_response_code(303);
header('Location: ' . $checkout_session->url);
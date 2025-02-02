<?php
include_once __DIR__ . '/../../gestores/GestorProducto.php';
include_once __DIR__ . '/../../config/utilidades.php';
include_once __DIR__ . '/../../entidades/Producto.php';
include_once __DIR__ . '/../../gestores/GestorCarrito.php';
include_once __DIR__ . '/../../entidades/LineaPedido.php';
include_once __DIR__ . '/../../entidades/Pedido.php';
include_once __DIR__ . '/../../gestores/GestorPedido.php';
include_once __DIR__ . '/../../gestores/GestorLineaPedido.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}
//Defino las variables que llegan por post y compruebo que no estén vacías:
$nombre = $_POST["nombre"] ?? null;
$apellido1 = $_POST["apellido1"] ?? null;
$apellido2 = $_POST["apellido2"] ?? null;
$email = $_POST["email"] ?? null;
$direccion = $_POST["direccion"] ?? null;
$localidad = $_POST["localidad"] ?? null;
$provincia = $_POST["provincia"] ?? null;
$telefono = $_POST["telefono"] ?? null;

//Compruebo que los datos no estén vacíos:
if ($nombre == null || $apellido1 == null || $apellido2 == null || $email == null || $direccion == null || $localidad == null || $provincia == null || $telefono == null) {
    header("Location: ../../vista/pedido/datosPedido.php?error=CamposVacios");
    exit();
}

//Compruebo que el email sea válido:
try {
    Utilidades::validarEmail($email);
} catch (Exception $e) {
    header("Location: ../../vista/pedido/datosPedido.php?error=" . $e->getMessage());
    exit();
}
//Creo Gestor Carrito, Usuario,
$gestorCarrito = new GestorCarrito();

//Creo el pedido:
//Creo un objeto datetime porque quiero capturar exactamente la hora y la fecha
//El valor por defecto de la bdd es "recibido" y el métdo de pago "trasnferencia"
$pedido = new Pedido(0, new DateTime(), $gestorCarrito->getTotal(), "recibido", $_SESSION['id'], $nombre, $apellido1, $apellido2, $email, $direccion, $localidad, $provincia, $telefono, "transferencia");

//Guardo el pedido en la base de datos:
$gestorPedido = new GestorPedido();
try {
    $idPedido = $gestorPedido->crearPedido($pedido);
} catch (Exception $e) {
    header("Location: ../../vista/pedido/datosPedido.php?error=" . $e->getMessage());
    exit();
}

//Genero el array de lineas de pedido:
foreach ($gestorCarrito->getCarrito() as $lineaCarrito) {
    $lineaPedido = new LineaPedido(0, $idPedido, $lineaCarrito->getId(), $lineaCarrito->getProducto()->getNombre(), $lineaCarrito->getProducto()->getDescripcion(), $lineaCarrito->getProducto()->getPrecio(), $lineaCarrito->getProducto()->getImagen());

    //Creo en base de datos la línea pedido:
    $gestorLineaPedido = new GestorLineaPedido();
    try {
        $gestorLineaPedido->crearLineaPedido($lineaPedido);
    } catch (Exception $e) {
        header("Location: ../../vista/pedido/datosPedido.php?error=" . $e->getMessage());
        exit();
    };
}

header("Location: ../../vista/carrito/metodoDePago.php?idPedido=$idPedido");
exit();
<?php

include_once __DIR__ . '/../../gestores/GestorProducto.php';
include_once __DIR__ . '/../../config/utilidades.php';
include_once __DIR__ . '/../../entidades/Producto.php';
include_once __DIR__ . '/../../gestores/GestorProducto.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}

//Defino las variables que llegan por post y compruebo que no estén vacías
$nombre = $_POST["nombre"] ?? null;
$descripcion = $_POST["descripcion"] ?? null;
$categoria_id = $_POST["categoria_id"] ?? null;
$precio = $_POST['precio'] ?? null;
$imagen = $_FILES['imagen'] ?? null;
$activo = $_POST['activo'] ?? null;

//Compruebo que los datos no estén vacíos
if ($nombre == null || $descripcion == null || $categoria_id == null || $precio == null || $imagen == null || $activo == null) {
    header("Location: ../../vista/backoffice/producto/crearProducto.php?error=CamposVacios");
    exit();
}
//Compruebo que el precio sea mator que 0
if ($precio <= 0) {
    header("Location: ../../vista/backoffice/producto/crearProducto.php?error=PrecioIncorrecto");
    exit();
}

//Compruebo que la imagen sea válida
try {
    $nombreImagen = Utilidades::subidaImagen($imagen, __DIR__ . "/../../media/img/productos/");
}catch (Exception $e) {
    header("Location: ../../vista/backoffice/producto/crearProducto.php?error=" . $e->getMessage());
    exit();
}

if ($nombreImagen == null) {
    header("Location: ../../vista/backoffice/producto/crearProducto.php?error=ImagenIncorrecta");
    exit();
}

//Creo el producto
$producto = new Producto(0, $nombre, $descripcion, $categoria_id, "", $precio, "/media/img/productos/" . $nombreImagen, $activo);
$gestorProducto = new GestorProducto();

try {
    $gestorProducto->nuevoProducto($producto);
} catch (Exception $e) {
    header("Location: ../../vista/backoffice/producto/crearProducto.php?error=" . $e->getMessage());
    exit();
}

header("Location: ../../vista/backoffice/producto/crearProducto.php?mensaje=ProductoCreado");
exit();





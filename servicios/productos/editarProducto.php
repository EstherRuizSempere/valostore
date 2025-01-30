<?php
include_once __DIR__ . '/../../gestores/GestorProducto.php';
include_once __DIR__ . '/../../config/utilidades.php';
include_once __DIR__ . '/../../entidades/Producto.php';
include_once __DIR__ . '/../../gestores/GestorProducto.php';
include_once __DIR__ . '/../../config/seguridad.php';

//Verifico que el usuario esté logueado con sus permisos
Seguridad::usuarioPermisos(['admin', 'editor']);

//Si no es post, retornamos
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /vista/backoffice/producto/tablaProducto.php");
    exit();
}


//Defino las variables que me llegan por post:
$id = $_POST["id"] ?? null;
$nombre = $_POST["nombre"] ?? null;
$descripcion = $_POST["descripcion"] ?? null;
$categoria_id = $_POST["categoria_id"] ?? null;
$precio = $_POST["precio"] ?? null;
$imagen = $_FILES["imagen"] ?? null;
//Ternaria que indica que si el valor es 0 será incactivo, y sino será 1 que es activo
$activo = isset($_POST["activo"]) && $_POST["activo"] == "1" ? 1 : 0;



//Compruebo que los datos obligatorios no estén vacios
if (empty($id) || empty($nombre) || empty($descripcion) || empty($categoria_id) || empty($precio)) {
    header("Location: /vista/backoffice/producto/actualizarProducto.php?id=$id&error=CamposObligatorios");
    exit();
}

//Compruebo que el precio sea mayor que 0
if ($precio <= 0) {
    header("Location: /vista/backoffice/producto/actualizarProducto.php?id=$id&error=PrecioInvalido");
    exit();
}

//Creo mi gestor
$gestorProducto = new GestorProducto();
$producto_bd = $gestorProducto->listarProductoUnico($id);

//Si no existe el producto, redirijo
if (!$producto_bd) {
    header("Location: /vista/backoffice/producto/tablaProducto.php?error=ProductoNoEncontrado");
    exit();
}

//Proceso si he subido una imagen nueva
//Si la imagen viene vacía, mantengo la imagen que ya tenía
if($imagen["name"] != null) {
    try {
        $nombreImagen = Utilidades::subidaImagen($imagen, __DIR__ . "/../../media/img/productos/");
        $rutaImagen = "/media/img/productos/" . $nombreImagen;
    } catch (Exception $e) {
        header("Location: /vista/backoffice/producto/actualizarProducto.php?id=$id&error=" . $e->getMessage());
        exit();
    }
} else {
    $rutaImagen = $producto_bd->getImagen();
}

  //Creo el producto con los datos actualizados
    $producto = new Producto($id, $nombre, $descripcion, $categoria_id, "", $precio, $rutaImagen, $activo);

try {
    $gestorProducto->editarProducto($producto);
    header("Location: /vista/backoffice/producto/tablaProducto.php?mensaje=ProductoActualizado");

}catch (Exception $e) {
    header("Location: /vista/backoffice/producto/actualizarProducto.php?id=$id&error=" . $e->getMessage());
    exit();
}
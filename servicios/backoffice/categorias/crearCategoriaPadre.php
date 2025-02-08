<?php
include_once __DIR__ . '/../../../gestores/GestorCategoria.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}

//Defino las variables que llegan por post y compruebo que no estén vacías
$nombre = $_POST["nombre"] ?? null;
$activo = $_POST["activo"] ?? null;

//Compruebo que los datos no estén vacíos
if ($nombre == null || $activo == null) {
    header("Location: /vista/backoffice/categoria/crearCategoriaPadre.php?error=CamposVacios");
    exit();
}

$gestorCategroria = new GestorCategoria();

if ($gestorCategroria->comprobarCategoria($nombre)) {
    header("Location:  /vista/backoffice/categoria/crearCategoriaPadre.php?error=CategoriaYaExiste");
    exit();
}

try {
    $crearCategoria = $gestorCategroria->crearCategoriaPadre($nombre, $activo);
} catch (Exception $e) {
    header("Location:  /vista/backoffice/categoria/crearCategoriaPadre.php?error=" . $e->getMessage());
    exit();
}

header("Location:  /vista/backoffice/categoria/tablaCategorias.php?mensaje=CategoriaCreada");
exit();
<?php
include_once __DIR__ . '/../../../gestores/GestorCategoria.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}

//Defino las variables que llegan por post y compruebo que no estén vacías
$nombre = $_POST["nombre"] ?? null;
$activo = $_POST["activo"] ?? null;
$categoria_padre = $_POST["categoria_padre"] ?? null;

//Compruebo que los datos no estén vacíos
if ($nombre == null || $activo == null || $categoria_padre == null) {
    header("Location: /vista/backoffice/categoria/crearCategoriaHija.php?error=CamposVacios");
    exit();
}

$gestorCategroria = new GestorCategoria();

if ($gestorCategroria->comprobarCategoriaHija($nombre)) {
    header("Location:  /vista/backoffice/categoria/crearCategoriaHija.php?error=CategoriaYaExiste");
    exit();
}

try {
    $crearCategoriaHija = $gestorCategroria->crearCategoriaHija($nombre, $activo, $categoria_padre);
}catch (Exception $e) {
    header("Location:  /vista/backoffice/categoria/crearCategoriaHija.php?error=" . $e->getMessage());
    exit();
}

header("Location:  /vista/backoffice/categoria/tablaCategorias.php?mensaje=CategoriaHijaCreada");
exit();
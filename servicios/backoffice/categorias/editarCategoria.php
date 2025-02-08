<?php
include_once __DIR__ . '/../../../gestores/GestorCategoria.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}

//Defino las variables que llegan por post y compruebo que no estén vacías
$id = $_POST["id"] ?? null;
$nombre = $_POST["nombre"] ?? null;
$activo = $_POST["activo"] ?? null;
$categoria_padre = $_POST["categoria_padre"] ?? null;

//Compruebo que los datos no estén vacíos
if ($id == null || $nombre == null || $activo == null) {
    header("Location: /vista/backoffice/categoria/editarCategoria.php?error=CamposVacios&id=" . $id);
    exit();
}

$gestorCategroria = new GestorCategoria();
if ($gestorCategroria->comprobarCategoriaHija($nombre, $id)) {
    header("Location:  /vista/backoffice/categoria/editarCategoria.php?error=CategoriaYaExiste&id=" . $id);
    exit();
}
if($gestorCategroria->comprobarCategoria($nombre, $id)){
    header("Location:  /vista/backoffice/categoria/editarCategoria.php?error=CategoriaPadreYaExiste&id=" . $id);
    exit();
}

try {
    $gestorCategroria->editarCategoria($id, $nombre, $activo, $categoria_padre);
}catch (Exception $e) {
    header("Location:  /vista/backoffice/categoria/editarCategoria.php?error=" . $e->getMessage() . "&id=" . $id);
    exit();
}

if($categoria_padre == null && $activo == 0){
   $categoriasHijas = $gestorCategroria->listarCategoriasHijaDeCategoriaPadre($id);

    foreach ($categoriasHijas as $categoriasHija) {
        $gestorCategroria->editarCategoria($categoriasHija->getId(), $categoriasHija->getNombre(), 0, $categoriasHija->getIdCategoriaPadre());
   }
}

header("Location:  /vista/backoffice/categoria/tablaCategorias.php?mensaje=CategoriaEditada");
exit();
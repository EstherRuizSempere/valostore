<?php

include_once __DIR__ . '/../../../config/seguridad.php';
include_once __DIR__ . '/../../../gestores/GestorCategoria.php';

Seguridad::usuarioPermisos(['admin', 'editor']);


//Creo un objeto de la clase GestorCategoria
$gestorCategoria = new GestorCategoria();
$idCategoria = $_GET['id'] ?? null;
$categoria = $gestorCategoria->getCategoria($idCategoria);
$categoriasPadre = $gestorCategoria->listarCategoriasPadre();

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Valo Store</title>
    <link rel="icon" href="../../../media/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../../media/styles/style.css">
    <link rel="stylesheet" href="../../../media/styles/navegadorstyle.css">
    <link rel="stylesheet" href="../../../media/styles/categoriastyle.css">
    <link rel="stylesheet" href="../../../media/styles/footer.css">
</head>
<body>
<?php include_once __DIR__ . '/../../navegador/navegadorlogueado.php'; ?>

<main>
<div class="container p-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="formulario-categoria">
                <div class="header-text">
                    <h4><span>Actualizar</span> Categoría</h4>
                    <p>Modifica los detalles de la categoría</p>
                </div>

                <form id="editarCategoriaForm" action="/servicios/backoffice/categorias/editarCategoria.php" method="POST">
                    <input type="hidden" name="id" value="<?= $categoria->getId() ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre de la categoría*</label>
                                <input type="text" name="nombre" class="form-control" id="nombre" value="<?= $categoria->getNombre() ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="activo" class="form-label">Activo*</label>
                                <select name="activo" class="form-control selector-categoria" id="activo"  required>
                                    <option value="1" <?= $categoria->getActivo() == 1 ? "selected" : "" ?> >Activo</option>
                                    <option value="0" <?= $categoria->getActivo() == 0 ? "selected" : ""?> >Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <?php if($categoria->getIdCategoriaPadre() !== null) { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="categoria_padre" class="form-label">Categoría Padre</label>
                                <select name="categoria_padre" class="form-control selector-categoria" id="categoria_padre">
                                    <?php foreach ($categoriasPadre as $categoriaPadre) { ?>
                                        <option value="<?= $categoriaPadre->getId() ?>" <?= $categoria->getIdCategoriaPadre() == $categoriaPadre->getId() ? "selected" : "" ?>><?= $categoriaPadre->getNombre() ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Actualizar Categoría</button>
                        <a class="btn btn-primary ms-4" href="tablaCategorias.php">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</main>

</body>


<?php
include_once __DIR__ . '/../../footer/footer.php';
?>

</html>
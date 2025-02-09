<?php

include_once __DIR__ . '/../../../config/seguridad.php';
include_once __DIR__ . '/../../../gestores/GestorCategoria.php';

Seguridad::usuarioPermisos(['admin', 'editor']);

$gestorCategoria = new GestorCategoria();

$categoriasPadre = $gestorCategoria->listarCategoriasPadre();
$categoriasHija = $gestorCategoria->listarCategoriasHija();


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
    <link rel="stylesheet" href="../../../media/styles/zonaAdminStyle.css">
    <link rel="stylesheet" href="../../../media/styles/footer.css">
</head>
<body>

<?php include_once __DIR__ . '/../../navegador/navegadorlogueado.php'; ?>

<main>
    <div class="container-fluid perfil-container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card personajes-card">
                    <div class="card-header">
                        <h3><i class="bi bi-tags"></i> Listado de Categorías Padre</h3>
                        <a href="/vista/backoffice/categoria/nuevaCategoriaPadre.php" class="nav-link active">
                            <i class="bi bi-plus-circle me-2"></i> Crear categoría
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table admin-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Activo</th>
                                <th style="width: 130px">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($categoriasPadre as $categoriaPadre) { ?>
                                <tr>
                                    <td><?= $categoriaPadre->getId() ?></td>
                                    <td><?= $categoriaPadre->getNombre() ?> </td>
                                    <td>
                                        <?= $categoriaPadre->getActivo() == 1 ? '<i class="bi bi-check2"></i>' : '<i class="bi bi-x-lg"></i>' ?>

                                    </td>
                                    <td>
                                        <a href="/vista/backoffice/categoria/editarCategoria.php?id=<?= $categoriaPadre->getId() ?>" class="btn btn-sm admin-btn"><i class="bi bi-pencil"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center pt-4">
            <div class="col-lg-10">
                <div class="card personajes-card">
                    <div class="card-header">
                        <h3><i class="bi bi-tags"></i> Listado de Subcategorías</h3>
                        <a href="nuevaCategoriaHija.php" class="nav-link active">
                            <i class="bi bi-plus-circle me-2"></i> Crear categoría
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table admin-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Categoría Padre</th>
                                <th>Activo</th>
                                <th style="width: 130px">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($categoriasHija as $categoriaHija) { ?>

                            <tr>
                                <td><?= $categoriaHija->getId() ?></td>
                                <td><?= $categoriaHija->getNombre() ?> </td>
                                <td><?= $categoriaHija->getIdCategoriaPadre() ?> </td>
                                <td>
                                    <?= $categoriaHija->getActivo() == 1 ? '<i class="bi bi-check2"></i>' : '<i class="bi bi-x-lg"></i>' ?>

                                </td>
                                <td>
                                    <a href="/vista/backoffice/categoria/editarCategoria.php?id=<?= $categoriaHija->getId() ?>" class="btn btn-sm admin-btn"><i class="bi bi-pencil"></i></a>
                                </td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include_once __DIR__ . '/../../footer/footer.php'; ?>
</body>
</html>
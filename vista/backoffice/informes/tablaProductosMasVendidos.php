<?php

include_once __DIR__ . '/../../../config/seguridad.php';
include_once __DIR__ . '/../../../gestores/GestorProducto.php';

Seguridad::usuarioPermisos(['admin', 'editor']);

$gestorProducto = new GestorProducto();

$productos = $gestorProducto->listarProductos();



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
                        <h3><i class="bi bi-box-seam"></i> Listado de Productos</h3>
                        <a href="/vista/backoffice/producto/crearProducto.php" class="nav-link active">
                            <i class="bi bi-person me-2"></i> ¿Botón para ordenar por más vendidos y menos vendidos?
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table admin-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Imagen</th>
                                <th>Activo</th>
                                <th style="width: 130px">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($productos as $producto){ ?>
                                <tr>
                                    <td><?= $producto->getId() ?></td>
                                    <td><?= $producto->getNombre() ?></td>
                                    <td><?= $producto->getDescripcion() ?></td>
                                    <td><?= $producto->getCategoria() ?></td>
                                    <td><?= $producto->getPrecio() ?> VP</td>
                                    <td>
                                        <img style="height: 60px" src="<?= $producto->getImagen() ?>" alt="">
                                    </td>
                                    <td>
                                        <?= $producto->getActivo() == 1 ? '<i class="bi bi-check2"></i>' : '<i class="bi bi-x-lg"></i>' ?>

                                    </td>
                                    <td>
                                        <a href="./../../producto/producto-detalle.php" class="btn btn-sm admin-btn"><i class="bi bi-eye"></i></a>
                                        <a href="./../producto/actualizarProducto.php?id=<?= $producto->getId()?>" class="btn btn-sm admin-btn"><i class="bi bi-pencil"></i></a>
                                        <a href="./../producto/borrarProducto.php?id=<?=$producto->getId() ?>" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>

                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>


            </div>
        </div>
    </div>

</main>

<?php include_once __DIR__ . '/../../footer/footer.php'; ?>
</body>
</html>
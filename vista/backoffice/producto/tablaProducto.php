<?php

include_once __DIR__ . '/../../../config/seguridad.php';

Seguridad::usuarioPermisos(['admin']);

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
                    </div>
                    <div class="card-body">
                        <table class="table admin-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Imagen</th>
                                <th>Activo</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="admin-table-actions">
                                    <a href="/vista/producto/producto-detalle.php" class="btn btn-sm admin-btn"><i class="bi bi-eye"></i></a>
                                    <a href="/vista/backoffice/producto/actualizarProducto.php" class="btn btn-sm admin-btn"><i class="bi bi-pencil"></i></a>
                                    <a href="/vista/backoffice/producto/borrarProducto.php" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>

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
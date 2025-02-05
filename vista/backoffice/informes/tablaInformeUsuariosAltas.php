<?php
include_once __DIR__ . '/../../../config/seguridad.php';
include_once __DIR__ . '/../../../gestores/GestorInformes.php';

Seguridad::usuarioPermisos(['admin']);
$gestorInformes = new GestorInformes();
$usuario_bd = $_SESSION['id'];


try {
    //Ternaria para que nos devuelva el valor de la variable si existe y no sea null
    $email = (isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : null;

    //Listamos usuarios:
    $listadoUsuariosDormidos = $gestorInformes->getUsuariosDormidos();
    $listadoUsuariosDespiertos = $gestorInformes->getUsuariosDespiertos();
} catch (Throwable $e) {
    $mensaje = $e->getMessage();
}
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


                <div class="card personajes-card mb-4">
                    <div class="card-header">
                        <h3><i class="bi bi-people"></i> Listado de Usuarios <strong>Activos</strong></h3>
                    </div>
                    <div class="card-body">
                        <table class="table admin-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Nombre</th>
                                <th>Primer Apellido</th>
                                <th>Segundo Apellido</th>
                                <th>Direccion</th>
                                <th>Localidad</th>
                                <th>Provincia</th>
                                <th>Teléfono</th>
                                <th>Fecha de nacimiento</th>
                                <th>Rol</th>
                                <th>Activo</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($listadoUsuariosDespiertos as $usuario) { ?>
                                <tr>
                                    <td><?= $usuario->getId() ?></td>
                                    <td><?= $usuario->getUsuario() ?></td>
                                    <td><?= $usuario->getEmail() ?></td>
                                    <td><?= $usuario->getNombre() ?></td>
                                    <td><?= $usuario->getApellido1() ?></td>
                                    <td><?= $usuario->getApellido2() ?></td>
                                    <td><?= $usuario->getDireccion() ?></td>
                                    <td><?= $usuario->getLocalidad() ?></td>
                                    <td><?= $usuario->getProvincia() ?></td>
                                    <td><?= $usuario->getTelefono() ?></td>
                                    <td><?= $usuario->getFechaNacimiento()->format('Y-m-d') ?></td>
                                    <td><?= $usuario->getRol() ?></td>
                                    <td><?= $usuario->getActivo() ?></td>
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

                <div class="card personajes-card mb-4">
                    <div class="card-header">
                        <h3><i class="bi bi-people"></i> Listado de Usuarios <strong>No Activos</strong></h3>
                    </div>
                    <div class="card-body">
                        <table class="table admin-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Nombre</th>
                                <th>Primer Apellido</th>
                                <th>Segundo Apellido</th>
                                <th>Direccion</th>
                                <th>Localidad</th>
                                <th>Provincia</th>
                                <th>Teléfono</th>
                                <th>Fecha de nacimiento</th>
                                <th>Rol</th>
                                <th>Activo</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($listadoUsuariosDormidos as $usuario) { ?>
                                <tr>
                                    <td><?= $usuario->getId() ?></td>
                                    <td><?= $usuario->getUsuario() ?></td>
                                    <td><?= $usuario->getEmail() ?></td>
                                    <td><?= $usuario->getNombre() ?></td>
                                    <td><?= $usuario->getApellido1() ?></td>
                                    <td><?= $usuario->getApellido2() ?></td>
                                    <td><?= $usuario->getDireccion() ?></td>
                                    <td><?= $usuario->getLocalidad() ?></td>
                                    <td><?= $usuario->getProvincia() ?></td>
                                    <td><?= $usuario->getTelefono() ?></td>
                                    <td><?= $usuario->getFechaNacimiento()->format('Y-m-d') ?></td>
                                    <td><?= $usuario->getRol() ?></td>
                                    <td><?= $usuario->getActivo() ?></td>
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
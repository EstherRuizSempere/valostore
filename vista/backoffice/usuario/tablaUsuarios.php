<?php
include_once __DIR__ . '/../../../config/seguridad.php';
include_once __DIR__ . '/../../../gestores/GestorUsuarios.php';

Seguridad::usuarioPermisos(['admin']);
$gestorUSuarios = new GestorUsuarios();
$usuario_bd = $_SESSION['id'];


try {
    //Ternaria para que nos devuelva el valor de la variable si existe y no sea null
    $email = (isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : null;

    //Listamos usuarios:
    $listadoUsuarios = $gestorUSuarios->listarUsuarios($email);
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
                        <h3><i class="bi bi-people"></i> Listado de Usuarios</h3>
                        <a href="/vista/backoffice/usuario/crearUsuario.php" class="nav-link active">
                            <i class="bi bi-person me-2"></i> Crear usuario
                        </a>
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
                                <th>Acciones</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($listadoUsuarios as $usuario) {
                                //Capturo la fecha de nacimiento
                                $fechaNacimiento = $usuario->getFechaNacimiento();
                                //En caso de que no haya nada dentro de la fecha de nacimiento, se le asigna un valor vacío
                                $fechaNacimientoFormateada = $fechaNacimiento ? $fechaNacimiento->format('Y-m-d') : '';
                                ?>
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
                                    <td><?= $fechaNacimientoFormateada ?></td>
                                    <td><?= $usuario->getRol() ?></td>
                                    <td><?= $usuario->getActivo() ?></td>
                                    <?php if ($usuario_bd != $usuario->getId()) { ?>
                                        <td>
                                            <a href="borrarUsuario.php?id=<?= $usuario->getId() ?>"
                                               class="btn btn-sm admin-btn"><i class="bi bi-trash"></i></a>
                                            <a href="actualizarUsuario.php?id=<?= $usuario->getId() ?>"
                                               class="btn btn-sm admin-btn"><i class="bi bi-pencil"></i></a>
                                        </td>
                                    <?php } ?>
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
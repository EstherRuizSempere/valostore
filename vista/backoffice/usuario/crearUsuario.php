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
    <title>Lol Store</title>
    <link rel="icon" href="../../../media/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../../media/styles/style.css">
    <link rel="stylesheet" href="../../../media/styles/navegadorstyle.css">
    <link rel="stylesheet" href="../../../media/styles/actualizarAdminStyle.css">
    <link rel="stylesheet" href="../../../media/styles/footer.css">
</head>
<body>
<?php include_once __DIR__ . '/../../navegador/navegadorlogueado.php'; ?>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="registro-form">
                <div class="header-text">
                    <h4><span>Crear</span> Nuevo Usuario</h4>
                    <p>Configura un nuevo usuario para el sistema</p>
                </div>

                <form id="crearUsuarioForm" action="/servicios/backoffice/usuarios/crearUsuario.php" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Nombre de Usuario*</label>
                                <input type="text" name="usuario" class="form-control" id="usuario" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email*</label>
                                <input type="email" name="email" class="form-control" id="email" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre*</label>
                                <input type="text" name="nombre" class="form-control" id="nombre" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="apellido1" class="form-label">Primer Apellido*</label>
                                <input type="text" name="apellido1" class="form-control" id="apellido1" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="rol" class="form-label">Rol de Usuario*</label>
                                <select name="rol" class="form-control" id="rol" required>
                                    <option value="">Seleccionar Rol</option>
                                    <option value="admin">Administrador</option>
                                    <option value="usuario">Usuario</option>
                                    <option value="editor">Editor</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contrasenya" class="form-label">Contraseña*</label>
                                <input type="password" name="contrasenya" class="form-control" id="contrasenya"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="validarContrasenya" class="form-label">Confirmar Contraseña*</label>
                                <input type="password" name="validarContrasenya" class="form-control"
                                       id="validarContrasenya" required>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Crear Usuario</button>
                        <a class="btn btn-primary ms-4" href="/vista/backoffice/usuario/tablaUsuarios.php">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once __DIR__ . '/../../footer/footer.php'; ?>
</body>
</html>
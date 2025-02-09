<?php
include_once __DIR__ . '/../../../config/seguridad.php';
include_once __DIR__ . '/../../../gestores/GestorUsuarios.php';

Seguridad::usuarioPermisos(['admin']);


$idUsuario = $_GET['id'];
$gestorUsuarios = new GestorUsuarios();

try {
    //Capturo al usuario
    $usuario = $gestorUsuarios->getUsuario($idUsuario);

    if (!$usuario) {
        header('Location: tablaUsuarios.php?error=Usuario no encontrado');
        exit();
    }

    //Verifico que admin no se edite en este apartado a si mismo
    if ($usuario->getId() == $_SESSION['id']) {
        header('Location: tablaUsuarios.php?error=No puedes eliminarte a ti mismo');
        exit();
    }
} catch (Throwable $e) {
    $mensaje = $e->getMessage();
    header('Location: tablaUsuarios.php?error=' . urlencode($mensaje));
    exit();
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
                    <h4><span>Actualizar</span> Usuario</h4>
                    <p>Modifica los datos del usuario <?php echo $usuario->getUsuario() ?></p>
                </div>

                <form id="actualizarUsuarioForm"  action="../../../servicios/backoffice/usuarios/actualizarUsuario.php"
                      method="POST">
                    <input type="hidden" name="id" value="<?php echo $usuario->getId() ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Nombre de Usuario</label>
                                <input type="text" name="usuario" class="form-control" id="usuario" required
                                       value="<?= $usuario->getUsuario() ?>">
                                >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" id="email" required
                                       value="<?= $usuario->getEmail() ?>">>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control" id="nombre" required
                                       value="<?= $usuario->getNombre() ?>">
                                >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="apellido1" class="form-label">Primer Apellido</label>
                                <input type="text" name="apellido1" class="form-control" id="apellido1" required
                                       value="<?= $usuario->getApellido1() ?>">
                                >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="rol" class="form-label">Rol de Usuario*</label>
                                <select name="rol" class="form-control" id="rol" required>
                                    <option <?= $usuario->getRol() == "admin" ? "selected" : "" ?> value="admin">
                                        Administrador
                                    </option>
                                    <option value="editor" <?= $usuario->getRol() == "editor" ? "selected" : "" ?> >
                                        Editor
                                    </option>
                                    <option value="usuario" <?= $usuario->getRol() == "usuario" ? "selected" : "" ?> >
                                        Usuario
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 pb-3">
                        <label for="activo" class="form-label">Activo*</label>
                        <select name="activo" class="form-control selector-categoria"
                                id="activo" required>
                            <option <?= $usuario->getActivo() == 1 ? "selected" : "" ?> value="1">Activo
                            </option>
                            <option <?= $usuario->getActivo() == 0 ? "selected" : "" ?> value="0">
                                Inactivo
                            </option>

                        </select>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                        <a class="btn btn-primary ms-4" href="tablaUsuarios.php">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 footer-info">
                <img src="../../../media/img/logo-valostore.png" alt="Logo Valo Store" class="footer-logo">
                <p class="mt-3">Tu tienda de confianza para conseguir los mejores personajes de Valorant.</p>
                <div class="social-links mt-3">
                    <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="discord"><i class="bi bi-discord"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 footer-links">
                <h4>Enlaces Útiles</h4>
                <ul>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Inicio</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Tienda</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Sobre Nosotros</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Términos y Condiciones</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Política de Privacidad</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-6 footer-contacto">
                <h4>Contáctanos</h4>
                <p>
                    <i class="bi bi-geo-alt"></i> Calle Principal, 123 <br>
                    03201 Elche, España<br><br>
                    <i class="bi bi-phone"></i> +34 999 999 999<br>
                    <i class="bi bi-envelope"></i> info@valostore.com<br>
                </p>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="copyright">
                        © 2025 <strong>Esther Ruiz Sempere</strong>. Todos los derechos reservados.
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
<?php
require_once '../../../gestores/GestorUsuarios.php';
require_once '../../../config/seguridad.php';

Seguridad::usuarioPermisos(['usuario', 'admin', 'editor']);

$gestorUsuarios = new GestorUsuarios();
$usuario = $gestorUsuarios->getUsuario($_SESSION['id']);

//Hago una ternaria para volver a la zona:
$redirigirZona = ($_SESSION['rol'] == 'admin' || $_SESSION['rol'] == 'editor') ? './../../backoffice/perfil/zonaAdmin.php' : 'zonaUsuarioNormal.php';


?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lol Store</title>
    <link rel="icon" href="../../media/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../../media/styles/style.css">
    <link rel="stylesheet" href="../../../media/styles/navegadorstyle.css">
    <link rel="stylesheet" href="../../../media/styles/registrostyle.css">
    <link rel="stylesheet" href="../../../media/styles/footer.css">
</head>
<body>
<?php include_once '../../navegador/navegadorlogueado.php'; ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="registro-form">
                <div class="header-text">
                    <h4><span>Edita tu</span> Cuenta</h4>
                    <p>¡No ólvides de introducir todos los datos obligatorios!</p>
                </div>

                <form id="registroForm" action="../../../servicios/usuarios/editarUsuarioNormal.php" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Nombre de Usuario*</label>
                                <input type="text" name="usuario" class="form-control" id="usuario" required
                                       value="<?= $usuario->getUsuario() ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email*</label>
                                <input type="email" name="email" class="form-control" id="email" required
                                       value="<?= $usuario->getEmail() ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre*</label>
                                <input type="text" name="nombre" class="form-control" id="nombre" required
                                       value="<?= $usuario->getNombre() ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="apellido1" class="form-label">Primer Apellido*</label>
                                <input type="text" name="apellido1" class="form-control" id="apellido1" required
                                       value="<?= $usuario->getApellido1() ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="apellido2" class="form-label">Segundo Apellido</label>
                                <input type="text" name="apellido2" class="form-control" id="apellido2"
                                       value="<?= $usuario->getApellido2() ?>">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección*</label>
                        <input type="text" name="direccion" class="form-control" id="direccion" required
                               value="<?= $usuario->getDireccion() ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="localidad" class="form-label">Localidad*</label>
                                <input type="text" name="localidad" class="form-control" id="localidad" required
                                       value="<?= $usuario->getLocalidad() ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="provincia" class="form-label">Provincia*</label>
                                <input type="text" name="provincia" class="form-control" id="provincia" required
                                       value="<?= $usuario->getProvincia() ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono*</label>
                                <input type="tel" name="telefono" class="form-control" id="telefono" required
                                       value="<?= $usuario->getTelefono() ?>">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento*</label>
                        <input type="date" name="fechaNacimiento" class="form-control" id="fechaNacimiento" required
                               value="<?= $usuario->getFechaNacimiento()->format('Y-m-d') ?>">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Editar Cuenta</button>
                        <a class="btn btn-primary ms-2" href="<?= $redirigirZona ?>">Vuelve atrás</a>
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
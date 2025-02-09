<?php
session_start();
include_once __DIR__ . '/../../config/seguridad.php';
include_once __DIR__ . '/../../gestores/GestorUsuarios.php';

Seguridad::usuarioPermisos(['usuario', 'admin', 'editor']);

$gestorUsuarios = new GestorUsuarios();
$usuario = $gestorUsuarios->getUsuario($_SESSION['id']);

//Hago una ternaria para volver a la zona:
$redirigirZona = ($_SESSION['rol'] == 'admin' || $_SESSION['rol'] == 'editor') ? './../backoffice/perfil/zonaAdmin.php' : './normal/zonaUsuarioNormal.php';

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
    <link rel="stylesheet" href="../../media/styles/style.css">
    <link rel="stylesheet" href="../../media/styles/navegadorstyle.css">
    <link rel="stylesheet" href="../../media/styles/forgotstyle.css">
    <link rel="stylesheet" href="../../media/styles/footer.css">
</head>
<body>
<header>
    <?php include_once __DIR__ . '/../navegador/navegadorlogueado.php'; ?>
</header>
<div class="container p-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="registro-form">
                <div class="header-text">
                    <h4>¿Quieres cambiar tu <span>contraseña</span>?</h4>
                    <p>Introduce tu nueva contraseña para cambiarla</p>
                </div>

                <form id="registroForm" action="../../servicios/usuarios/editarContrasenya.php" method="POST">
                    <div class="row contrasenya">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contrasenya" class="form-label">Contraseña*</label>
                                <input type="password" name="contrasenya" class="form-control" id="contrasenya" required>
                            </div>
                        </div>
                    </div>
                    <div class="row contrasenya">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="validarContrasenya" class="form-label">Confirma la Contraseña*</label>
                                <input type="password" name="validarContrasenya" class="form-control" id="contrasenya" required>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Cambiar contraseña</button>
                        <a class="btn btn-primary" href="<?= $redirigirZona ?>">Vuelve atrás</a>

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
                <img src="../../media/img/logo-valostore.png" alt="Logo Valo Store" class="footer-logo">
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
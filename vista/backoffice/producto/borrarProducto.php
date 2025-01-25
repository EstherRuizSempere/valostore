<?php

include_once __DIR__ . '/../../../config/seguridad.php';

Seguridad::usuarioPermisos(['admin']);

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
    <link rel="stylesheet" href="../../../media/styles/borrarProductoStyle.css">
    <link rel="stylesheet" href="../../../media/styles/footer.css">
</head>
<body>
<?php include_once '../../navegador/navegadorlogueado.php'; ?>

<main>
    <div class="container-fluid perfil-container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card perfil-card mb-4">
                    <div class="card-header">
                        <h3><i class="bi bi-exclamation-triangle"></i> Eliminar Producto</h3>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-8 text-center">
                                <h4 class="mb-4 p-3"><i class="bi bi-person-x me-4"></i>¿Estás seguro de que deseas
                                    eliminar al personaje X?</h4>
                                <p class="mb-4">Esta acción no se puede deshacer.
                                    Se eliminarán todos sus datos.</p>

                                <form action="" method="POST" class="mb-4">
                                    <div class="mb-3">
                                        <input type="password" class="form-control" id="contrasenya" name="contrasenya"
                                               placeholder="Introduce tu contraseña para confirmar" required>
                                    </div>
                                    <div class="d-flex justify-content-center gap-3">
                                        <a href="" class="borrar-perfil-btn">
                                            Cancelar
                                        </a>
                                        <button type="submit" class="borrar-perfil-btn">
                                            Eliminar Personaje
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

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
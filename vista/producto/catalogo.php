<?php

include_once __DIR__ . '/../../config/seguridad.php';

Seguridad::usuarioPermisos(['user', 'admin']);

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
    <link rel="stylesheet" href="../../media/styles/catalogoStyle.css">
    <link rel="stylesheet" href="../../media/styles/footer.css">
</head>
<body>

<?php include_once '../navegador/navegadorlogueado.php'; ?>
<main>
    <div class="container-fluid catalogo-container">
        <div class="container">
            <h1 class="catalogo-header">Catálogo de Personajes</h1>

            <div class="filtros-section">
                <div class="row">
                    <div class="col-md-4">
                        <select class="form-select">
                            <option selected>Filtrar por Rol</option>
                            <option>Duelista</option>
                            <option>Centinela</option>
                            <option>Iniciador</option>
                            <option>Controlador</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select">
                            <option selected>Ordenar por Precio</option>
                            <option>Menor a Mayor</option>
                            <option>Mayor a Menor</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select">
                            <option selected>Ordenar por nombre</option>
                            <option>Ascendente</option>
                            <option>Descendente</option>
                        </select>
                    </div>
                </div>

            </div>
        </div>

        <div class="contenedor-cards">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <a href="producto-detalle.php">
                        <div class="personaje-card">
                            <div class="personaje-imagen">
                                <img src="../../media/img/jett.png" alt="Jett">
                            </div>

                            <div class="personaje-detalles">
                                <h3 class="personaje-nombre">Jett</h3>
                                <span class="personaje-rol">Duelista</span>
                                <div class="personaje-precio">1000 VP</div>
                            </div>
                        </div>
                    </a>

                </div>

                <div class="col-md-3 mb-4">
                    <div class="personaje-card">
                        <a href="producto-detalle.php">
                            <div class="personaje-imagen">
                                <img src="../../media/img/sage.png" alt="Sage">
                            </div>
                            <div class="personaje-detalles">
                                <h3 class="personaje-nombre">Sage</h3>
                                <span class="personaje-rol">Centinela</span>
                                <div class="personaje-precio">950 VP</div>
                            </div>
                        </a>

                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="personaje-card">
                        <a href="producto-detalle.php">
                            <div class="personaje-imagen">
                                <img src="../../media/img/omen.png" alt="Omen">
                            </div>
                            <div class="personaje-detalles">
                                <h3 class="personaje-nombre">Omen</h3>
                                <span class="personaje-rol">Controlador</span>
                                <div class="personaje-precio">900 VP</div>
                            </div>
                        </a>

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
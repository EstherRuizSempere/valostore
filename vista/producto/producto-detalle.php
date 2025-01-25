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
    <link rel="stylesheet" href="../../media/styles/productostyle.css">
    <link rel="stylesheet" href="../../media/styles/footer.css">
</head>
<body>
<?php include_once '../navegador/navegadorlogueado.php'; ?>

<main>
    <div class="container-fluid producto-container">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="producto-imagen-container">
                        <img src="../../media/img/jett.png" alt="Jett" class="producto-imagen">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="producto-info">
                        <div class="producto-rol-badge">Duelista</div>
                        <h1 class="producto-nombre">Jett</h1>
                        <div class="producto-precio">1000 VP</div>
                        <div class="producto-dificultad">
                            <span>Dificultad:</span>
                            <div class="dificultad-barras">
                                <div class="barra activa"></div>
                                <div class="barra activa"></div>
                                <div class="barra"></div>
                            </div>
                        </div>
                        <div class="producto-acciones">
                            <button class="btn-comprar">
                                <i class="bi bi-cart-plus"></i> Añadir al carrito
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <div class="producto-tabs">
                        <ul class="nav nav-tabs" id="producto-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#historia"  type="button">Historia</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#habilidades" type="button">Habilidades</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="producto-tab-content">
                            <div class="tab-pane fade show active" id="historia">
                                <div class="producto-descripcion">
                                    <h3>Historia</h3>
                                    <p>Representando a Corea del Sur, el estilo de lucha ágil y evasivo de Jett le permite asumir grandes riesgos. Corre y esquiva en cada refriega mientras hace trizas a los enemigos con una rapidez vertiginosa.</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="habilidades">
                                <div class="habilidades-grid">
                                    <div class="habilidad-card">
                                        <div class="habilidad-header">
                                            <img src="../../media/img/habilidad1.png" alt="Corriente Ascendente">
                                            <h4>Corriente Ascendente</h4>
                                        </div>
                                        <p>Te PROPULSAS instantáneamente hacia arriba.</p>
                                    </div>
                                    <div class="habilidad-card">
                                        <div class="habilidad-header">
                                            <img src="../../media/img/habilidad2.png" alt="Viento de Cola">
                                            <h4>Viento de Cola</h4>
                                        </div>
                                        <p>ACTIVAS propulsión instantáneamente hacia la dirección en la que te estés moviendo.</p>
                                    </div>
                                </div>
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
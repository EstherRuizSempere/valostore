<?php
include_once __DIR__ . '/../../../config/seguridad.php';

Seguridad::usuarioPermisos(['usuario']);

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
    <link rel="stylesheet" href="../../../media/styles/zonaUsuarioNormalStyle.css">
    <link rel="stylesheet" href="../../../media/styles/footer.css">
</head>
<body>
<header>
    <nav class="navegador">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <a href="../../login/login.php" class="navbar-brand">
                    <img class="img-fluid img-logo" src="../../../media/img/logo-valostore.png" alt="Logo Valo Store">
                </a>

                <ul class="nav nav-pills ms-auto iconos-nav">
                    <li class="nav-item">
                        <a href="../../producto/catalogo.php" class="nav-link active">
                            <i class="bi bi-shop img-iconos"></i>
                            Tienda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="carrito.html" class="nav-link active">
                            <i class="bi bi-cart img-iconos"></i>
                            Carrito
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                           aria-expanded="false">
                            <i class="bi bi-person-circle img-iconos"></i>
                            ¡Hola, Esther!
                        </a>
                        <ul class="dropdown-menu dropdown-menu">
                            <li><a class="dropdown-item" href="perfil.html"><i class="bi bi-person me-2"></i>Mi
                                    Perfil</a></li>
                            <li><a class="dropdown-item" href="pedidos.html"><i class="bi bi-box me-2"></i>Mis
                                    Pedidos</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="cerrar-sesion.html"><i
                                            class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main>
    <div class="container-fluid perfil-container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card perfil-card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="perfil-avatar">
                                    <img src="../../../media/img/imagen-perfil.png" alt="Avatar del usuario"
                                         class="img-fluid rounded">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="perfil-info">
                                    <span class="status-badge">
                                        <i class="bi bi-circle-fill"></i> Online
                                    </span>
                                    <h2 class="perfil-username">TherBeep</h2>
                                    <div class="mb-2 ">
                                        <a href="../editarContrasenya.php" class="btn  edit-perfil-btn">
                                            <i class="bi bi-pencil"></i> Cambio Contraseña
                                        </a>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a href="actualizarUsuarioNormal.php" class="btn  edit-perfil-btn">
                                                <i class="bi bi-pencil"></i> Editar Perfil
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="borrarUsuarioNormal.php" class="btn  edit-perfil-btn">
                                                <i class="bi bi-trash"></i> Eliminar Perfil
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="perfil-status">
                                    <div class="status-item">
                                        <i class="bi bi-person-badge"></i>
                                        <span class="status-valor">10</span>
                                        <span class="status-label">Personajes</span>
                                    </div>
                                    <div class="status-item">
                                        <a href=""> <i class="bi bi-backpack3"></i>
                                            <span class="status-valor">10</span>
                                            <span class="status-label">Compras</span>
                                        </a>

                                    </div>
                                    <div class="status-item">
                                        <i class="bi bi-slash-circle"></i>
                                        <span class="status-valor">10</span>
                                        <span class="status-label">Personajes no en posesión</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card personajes-card mb-4">
                    <div class="card-header">
                        <h3><i class="bi bi-people"></i> Tus Personajes</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 mb-4">
                                <div class="personaje-item">
                                    <div class="personaje-imagen">
                                        <img src="../../../media/img/astra-product.png" alt="Personaje 1"
                                             class="img-fluid">
                                        <div class="personaje-detalles">
                                            <button class="btn btn-light btn-sm">Ver Detalles</button>
                                        </div>
                                    </div>
                                    <div class="personaje-info">
                                        <h4>Astra</h4>
                                        <span class="personaje-rol">Humos</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mb-4">
                                <div class="personaje-item">
                                    <div class="personaje-imagen">
                                        <img src="../../../media/img/astra-product.png" alt="Personaje 1"
                                             class="img-fluid">
                                        <div class="personaje-detalles">
                                            <button class="btn btn-light btn-sm">Ver Detalles</button>
                                        </div>
                                    </div>
                                    <div class="personaje-info">
                                        <h4>Astra</h4>
                                        <span class="personaje-rol">Humos</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mb-4">
                                <div class="personaje-item">
                                    <div class="personaje-imagen">
                                        <img src="../../../media/img/astra-product.png" alt="Personaje 1"
                                             class="img-fluid">
                                        <div class="personaje-detalles">
                                            <button class="btn btn-light btn-sm">Ver Detalles</button>
                                        </div>
                                    </div>
                                    <div class="personaje-info">
                                        <h4>Astra</h4>
                                        <span class="personaje-rol">Humos</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mb-4">
                                <div class="personaje-item">
                                    <div class="personaje-imagen">
                                        <img src="../../../media/img/astra-product.png" alt="Personaje 1"
                                             class="img-fluid">
                                        <div class="personaje-detalles">
                                            <button class="btn btn-light btn-sm">Ver Detalles</button>
                                        </div>
                                    </div>
                                    <div class="personaje-info">
                                        <h4>Astra</h4>
                                        <span class="personaje-rol">Humos</span>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-2 mb-4">
                                <div class="personaje-item">
                                    <div class="personaje-imagen">
                                        <img src="../../../media/img/astra-product.png" alt="Personaje 1"
                                             class="img-fluid">
                                        <div class="personaje-detalles">
                                            <button class="btn btn-light btn-sm">Ver Detalles</button>
                                        </div>
                                    </div>
                                    <div class="personaje-info">
                                        <h4>Astra</h4>
                                        <span class="personaje-rol">Humos</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mb-4">
                                <div class="personaje-item">
                                    <div class="personaje-imagen">
                                        <img src="../../../media/img/astra-product.png" alt="Personaje 1"
                                             class="img-fluid">
                                        <div class="personaje-detalles">
                                            <button class="btn btn-light btn-sm">Ver Detalles</button>
                                        </div>
                                    </div>
                                    <div class="personaje-info">
                                        <h4>Astra</h4>
                                        <span class="personaje-rol">Humos</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card personajes-card mb-4">
                    <div class="card-header">
                        <h3><i class="bi bi-person-dash"></i> Personajes no en posesión</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 mb-4">
                                <div class="personaje-item">
                                    <div class="personaje-imagen">
                                        <img src="../../../media/img/astra-product.png" alt="Personaje 1"
                                             class="img-fluid">
                                        <div class="personaje-detalles">
                                            <button class="btn btn-light btn-sm">Ver Detalles</button>
                                        </div>
                                    </div>
                                    <div class="personaje-info">
                                        <h4>Astra</h4>
                                        <span class="personaje-rol">Humos</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mb-4">
                                <div class="personaje-item">
                                    <div class="personaje-imagen">
                                        <img src="../../../media/img/astra-product.png" alt="Personaje 1"
                                             class="img-fluid">
                                        <div class="personaje-detalles">
                                            <button class="btn btn-light btn-sm">Ver Detalles</button>
                                        </div>
                                    </div>
                                    <div class="personaje-info">
                                        <h4>Astra</h4>
                                        <span class="personaje-rol">Humos</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mb-4">
                                <div class="personaje-item">
                                    <div class="personaje-imagen">
                                        <img src="../../../media/img/astra-product.png" alt="Personaje 1"
                                             class="img-fluid">
                                        <div class="personaje-detalles">
                                            <button class="btn btn-light btn-sm">Ver Detalles</button>
                                        </div>
                                    </div>
                                    <div class="personaje-info">
                                        <h4>Astra</h4>
                                        <span class="personaje-rol">Humos</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mb-4">
                                <div class="personaje-item">
                                    <div class="personaje-imagen">
                                        <img src="../../../media/img/astra-product.png" alt="Personaje 1"
                                             class="img-fluid">
                                        <div class="personaje-detalles">
                                            <button class="btn btn-light btn-sm">Ver Detalles</button>
                                        </div>
                                    </div>
                                    <div class="personaje-info">
                                        <h4>Astra</h4>
                                        <span class="personaje-rol">Humos</span>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-2 mb-4">
                                <div class="personaje-item">
                                    <div class="personaje-imagen">
                                        <img src="../../../media/img/astra-product.png" alt="Personaje 1"
                                             class="img-fluid">
                                        <div class="personaje-detalles">
                                            <button class="btn btn-light btn-sm">Ver Detalles</button>
                                        </div>
                                    </div>
                                    <div class="personaje-info">
                                        <h4>Astra</h4>
                                        <span class="personaje-rol">Humos</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mb-4">
                                <div class="personaje-item">
                                    <div class="personaje-imagen">
                                        <img src="../../../media/img/astra-product.png" alt="Personaje 1"
                                             class="img-fluid">
                                        <div class="personaje-detalles">
                                            <button class="btn btn-light btn-sm">Ver Detalles</button>
                                        </div>
                                    </div>
                                    <div class="personaje-info">
                                        <h4>Astra</h4>
                                        <span class="personaje-rol">Humos</span>
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
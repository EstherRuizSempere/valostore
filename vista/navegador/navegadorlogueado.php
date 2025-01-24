<header>
    <nav class="navegador">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <a href="/index.php" class="navbar-brand">
                    <img class="img-fluid img-logo" src="/media/img/logo-valostore.png" alt="Logo Valo Store">
                </a>

                <?php

                if ($_SESSION['rol'] == 'usuario') {
                    ?>
                    <ul class="nav nav-pills ms-auto iconos-nav">
                        <li class="nav-item">
                            <a href="/vista/producto/catalogo.php" class="nav-link active">
                                <i class="bi bi-shop img-iconos"></i>
                                Tienda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/vista/carrito/carrito.php" class="nav-link active">
                                <i class="bi bi-cart img-iconos"></i>
                                Carrito
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                               aria-expanded="false">
                                <i class="bi bi-person-circle img-iconos"></i>
                                ¡Hola, Usuario!
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
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

                <?php } else if ($_SESSION['rol'] == 'admin' || $_SESSION['rol'] == 'editor') { ?>
                    <ul class="nav nav-pills ms-auto iconos-nav">
                        <li class="nav-item">
                            <a href="/vista/producto/catalogo.php" class="nav-link active">
                                <i class="bi bi-shop img-iconos"></i>
                                Usuarios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/vista/carrito/carrito.php" class="nav-link active">
                                <i class="bi bi-cart img-iconos"></i>
                                Productos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/vista/carrito/carrito.php" class="nav-link active">
                                <i class="bi bi-cart img-iconos"></i>
                                Pedidos
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                               aria-expanded="false">
                                <i class="bi bi-person-circle img-iconos"></i>
                                ¡Hola, <?php echo $_SESSION['usuario'] ?>!
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="/vista/backoffice/perfil/zonaAdmin.php"><i class="bi bi-person me-2"></i>Mi
                                        Perfil</a></li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="cerrar-sesion.html"><i
                                                class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </nav>
</header>
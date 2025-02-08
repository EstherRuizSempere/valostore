<?php
//Me comprueba si la sesión está iniciada, si no lo está, la inicia y me incluye el archivo GestorCarrito.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../gestores/GestorCarrito.php';

$gestorCarrito = new GestorCarrito();

?>

<header>
    <nav class="navegador">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <a href="/index.php" class="navbar-brand">
                    <img class="img-fluid img-logo" src="/media/img/logo-valostore.png" alt="Logo Valo Store">
                </a>

                <?php if ($_SESSION['rol'] == 'usuario') { ?>
                    <ul class="nav nav-pills ms-auto iconos-nav">
                        <li class="nav-item">
                            <a href="./../../../index.php" class="nav-link active">
                                <i class="bi bi-shop img-iconos"></i> Tienda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/vista/carrito/carrito.php" class="nav-link active">
                                <i class="bi bi-cart img-iconos"></i>
                                <?php if ($gestorCarrito->getCantidadProductos() == 0) : ?>
                                    Carrito
                                <?php else : ?>
                                    <span id="carrito-cantidad-productos"><?= $gestorCarrito->getCantidadProductos() ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                               aria-expanded="false">
                                <i class="bi bi-person-circle img-iconos"></i> ¡Hola, <?php echo $_SESSION['usuario'] ?>
                                !
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="/vista/usuario/normal/zonaUsuarioNormal.php"><i
                                                class="bi bi-person me-2"></i> Mi Perfil</a></li>
                                <li><a class="dropdown-item" href="/vista/usuario/normal/misPedidos.php"><i class="bi bi-box me-2"></i> Mis Pedidos</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="/./servicios/autentifiacion/logout.php"><i
                                                class="bi bi-box-arrow-right me-2"></i> Cerrar sesión</a></li>
                            </ul>
                        </li>
                    </ul>

                <?php } else if ($_SESSION['rol'] == 'admin' || $_SESSION['rol'] == 'editor') { ?>
                    <ul class="nav nav-pills ms-auto iconos-nav">
                        <li class="nav-item">
                            <?php if ($_SESSION['rol'] == 'admin'){ ?>
                            <a href="/vista/backoffice/usuario/tablaUsuarios.php" class="nav-link active">
                                <i class="bi bi-person me-2"></i> Usuarios
                            </a>
                        </li>
                        <?php } ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                               aria-expanded="false">
                                <i class="bi bi-shop img-iconos"></i> Productos
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/vista/backoffice/producto/tablaProducto.php"><i
                                                class="bi bi-pencil"></i> Gestión Productos</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="/vista/backoffice/categoria/tablaCategorias.php"><i
                                                class="bi bi-tag"></i> Categorías</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                               aria-expanded="false">
                                <i class="bi bi-shop img-iconos"></i> Informes
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($_SESSION['rol'] == 'admin') { ?>
                                    <li><a class="dropdown-item"
                                           href="/vista/backoffice/informes/tablaInformeUsuariosAltas.php"><i
                                                    class="bi bi-pencil"></i>Usuarios</a></li>
                                <?php } ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item"
                                       href="/vista/backoffice/informes/tablaProductosMasVendidos.php"><i
                                                class="bi bi-tag"></i> Productos </a></li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="/vista/backoffice/informes/ventaDelMes.php"><i
                                                class="bi bi-tag"></i> Ventas </a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="/vista/backoffice/pedidos/tablaPedidos.php" class="nav-link active">
                                <i class="bi bi-cart img-iconos"></i> Pedidos
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                               aria-expanded="false">
                                <i class="bi bi-person-circle img-iconos"></i> ¡Hola, <?php echo $_SESSION['usuario'] ?>
                                !
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="/vista/backoffice/perfil/zonaAdmin.php"><i
                                                class="bi bi-person me-2"></i> Mi Perfil</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="/./servicios/autentifiacion/logout.php"><i
                                                class="bi bi-box-arrow-right me-2"></i> Cerrar sesión</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </nav>
</header>

<?php

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
                    <img class="img-fluid img-logo" src="../../media/img/logo-valostore.png" alt="Logo Valo Store">
                </a>


                <ul class="nav nav-pills ms-auto iconos-nav">
                    <li class="nav-item">
                        <a href="https://playvalorant.com/es-es/download/" class="nav-link active">
                            <i class="bi bi-download img-iconos"></i>
                            Descargar juego
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
                    <li class="nav-item">
                        <a href="/vista/login/login.php" class="nav-link active">
                            <i class="bi bi-person-circle img-iconos"></i>
                            Iniciar sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<?php

    include_once __DIR__ . '/../../gestores/GestorCarrito.php';

    $gestorCarrito = new GestorCarrito();

    $carrito = $gestorCarrito->getCarrito();
    $total = $gestorCarrito->getTotal();

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Valo Store</title>
    <link rel="icon" href="../../media/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../media/styles/style.css">
    <link rel="stylesheet" href="../../media/styles/navegadorstyle.css">
    <link rel="stylesheet" href="../../media/styles/carritostyle.css">
    <link rel="stylesheet" href="../../media/styles/footer.css">
</head>
<body>
<?php

if (isset($_SESSION['usuario'])) {
    include_once __DIR__ . '/../navegador/navegadorlogueado.php';
} else {
    include_once __DIR__ . '/../navegador/navegadornologueado.php';
}
?>


<main>
    <div class="container-fluid carrito-container">
        <div class="container">
            <h1 class="carrito-titulo">Tu Carrito</h1>

            <div class="carrito-content">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="carrito-items">
                            <?php foreach($carrito as $carritoItem): ?>
                            <div class="carrito-item">
                                <img src="<?= $carritoItem->getProducto()->getImagen() ?>" alt="imagen-producto" class="item-imagen">
                                <div class="item-detalles">
                                    <h3><?= $carritoItem->getProducto()->getNombre() ?></h3>
                                    <span class="item-rol"><?= $carritoItem->getProducto()->getCategoria() ?></span>
                                </div>
                                <div class="item-precio"><?= $carritoItem->getProducto()->getPrecio() ?> VP</div>
                                <form action="../../servicios/carrito/eliminarProductoDeCarrito.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $carritoItem->getId() ?>">
                                    <button class="btn-eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                                <?php endforeach; ?>

                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="carrito-resumen">
                            <h2>Resumen del pedido</h2>
                            <div class="resumen-item">
                                <span>Subtotal</span>
                                <span><?= $total ?> VP</span>
                            </div>
                            <div class="resumen-item total">
                                <span>Total</span>
                                <span><?= $total ?> VP</span>
                            </div>
                            <a href="../pedido/datosPedido.php" class="btn-pagar">
                                Proceder al pago
                            </a>
                            <a href="/index.php" class="btn-seguir-comprando">
                                Seguir comprando
                            </a>
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
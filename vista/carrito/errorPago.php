<?php
include_once __DIR__ . '/../../config/seguridad.php';

Seguridad::usuarioPermisos(['usuario']);
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
    <link rel="stylesheet" href="../../media/styles/errorPagoStyle.css">
    <link rel="stylesheet" href="../../media/styles/footer.css">
</head>
<body>
<?php include_once '../navegador/navegadorlogueado.php'; ?>

<main>
    <div class="container-fluid error-pago-container">
        <div class="container">
            <div class="error-pago-content">
                <i class="bi bi-exclamation-circle error-icon"></i>
                <h1 class="error-titulo">Error en el Pago</h1>
                <p class="error-mensaje">
                    Lo sentimos, ha ocurrido un error durante el proceso de pago.
                    No te preocupes, no se ha realizado ningún cargo en tu cuenta.
                </p>

                <div class="error-detalles">
                    <div class="error-detalles-item">
                        <span class="error-detalles-label">ID de Pedido:</span>
                        <span>#12345</span>
                    </div>
                    <div class="error-detalles-item">
                        <span class="error-detalles-label">Método de pago:</span>
                        <span>Tarjeta de crédito</span>
                    </div>
                    <div class="error-detalles-item">
                        <span class="error-detalles-label">Código de error:</span>
                        <span>ERR_PAYMENT_001</span>
                    </div>
                    <div class="error-detalles-item">
                        <span class="error-detalles-label">Fecha y hora:</span>
                        <span>01/02/2025 15:30</span>
                    </div>
                </div>

                <div class="botones-container">
                    <a href="metodoPago.php" class="btn-reintentar">
                        Reintentar pago
                    </a>
                    <a href="/index.php" class="btn-volver">
                        Volver a la tienda
                    </a>
                </div>

                <div class="soporte-info">
                    ¿Necesitas ayuda? Contacta con nuestro
                    <a href="#" class="soporte-link">servicio de soporte</a>
                    o llámanos al <strong>+34 999 999 999</strong>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
include_once __DIR__ . '/../footer/footer.php';
?>

</body>
</html>
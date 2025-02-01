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
    <link rel="stylesheet" href="../../media/styles/metodoPagoStyleMal.css">
    <link rel="stylesheet" href="../../media/styles/footer.css">
</head>
<body>
<?php include_once '../navegador/navegadorlogueado.php'; ?>

<main>
    <div class="container-fluid metodo-pago-container">
        <div class="container">
            <h1 class="metodo-pago-titulo">Método de Pago</h1>

            <div class="metodo-pago-content">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="opciones-pago">
                            <div class="opcion-pago">
                                <div class="opcion-pago-header">
                                    <i class="bi bi-credit-card opcion-pago-icon"></i>
                                    <h3 class="opcion-pago-titulo">Pago con PayPal o Tarjeta</h3>
                                </div>
                                <p class="opcion-pago-descripcion">
                                    Paga de forma segura utilizando tu cuenta de PayPal o tarjeta de crédito/débito
                                </p>
                            </div>

                            <div class="opcion-pago">
                                <div class="opcion-pago-header">
                                    <i class="bi bi-bank opcion-pago-icon"></i>
                                    <h3 class="opcion-pago-titulo">Transferencia Bancaria</h3>
                                </div>
                                <p class="opcion-pago-descripcion">
                                    Realiza una transferencia directa a nuestra cuenta bancaria
                                </p>
                                <div class="datos-bancarios">
                                    <div class="datos-bancarios-item">
                                        <span>Titular:</span>
                                        <strong>Valo Store S.L.</strong>
                                    </div>
                                    <div class="datos-bancarios-item">
                                        <span>IBAN:</span>
                                        <strong>ES91 2100 0418 4502 0005 1332</strong>
                                    </div>
                                    <div class="datos-bancarios-item">
                                        <span>Concepto:</span>
                                        <strong>Pedido #12345</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="detalles-pago">
                            <h2 class="detalles-pago-titulo">Resumen del pago</h2>
                            <div class="resumen-item">
                                <span>Total a pagar</span>
                                <span>1000 VP</span>
                            </div>
                            <button class="btn-continuar">
                                Continuar con el pago
                            </button>
                        </div>
                    </div>
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
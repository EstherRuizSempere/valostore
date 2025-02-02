<?php
include_once __DIR__ . '/../../config/seguridad.php';
include_once __DIR__ . '/../../constantes/clavesStripe.php';
include_once __DIR__ . '/../../gestores/GestorCarrito.php';

Seguridad::usuarioPermisos(['usuario']);

$clavePublica = Stripe::$clavePublica;
$gestorCarrito = new GestorCarrito();
$total = $gestorCarrito->getTotal();
$id = $_GET['idPedido'];
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
    <link rel="stylesheet" href="../../media/styles/metodoPagoStyle.css">
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
                                    <input type="radio" name="metodoPago" id="paypal" value="paypal"
                                           class="opcion-pago-radio">
                                    <label for="paypal" class="opcion-pago-label">
                                        <div class="opcion-pago-header">
                                            <i class="bi bi-paypal opcion-pago-icon"></i>
                                            <h3 class="opcion-pago-titulo">PayPal</h3>
                                        </div>
                                        <p class="opcion-pago-descripcion">
                                            Paga de forma segura utilizando tu cuenta de PayPal
                                        </p>
                                    </label>
                                </div>

                                <div class="opcion-pago">
                                    <input type="radio" name="metodoPago" id="tarjeta" value="tarjeta"
                                           class="opcion-pago-radio">
                                    <label for="tarjeta" class="opcion-pago-label">
                                        <div class="opcion-pago-header">
                                            <i class="bi bi-credit-card opcion-pago-icon"></i>
                                            <h3 class="opcion-pago-titulo">Tarjeta de Crédito/Débito</h3>
                                        </div>
                                        <p class="opcion-pago-descripcion">
                                            Paga con tu tarjeta de crédito o débito
                                        </p>
                                        <div class="tarjetas-aceptadas">
                                            <img src="./../../media/img/visa.png" alt="Visa" class="tarjeta-imagen">
                                            <img src="./../../media/img/mc_symbol_opt_73_3x.png" alt="Mastercard"
                                                 class="tarjeta-imagen">
                                            <img src="./../../media/img/american-express.png" alt="American Express"
                                                 class="tarjeta-imagen">
                                        </div>
                                    </label>
                                </div>

                                <div class="opcion-pago">
                                    <input type="radio" name="metodoPago" id="transferencia" value="transferencia"
                                           class="opcion-pago-radio">
                                    <label for="transferencia" class="opcion-pago-label">
                                        <div class="opcion-pago-header">
                                            <i class="bi bi-bank opcion-pago-icon"></i>
                                            <h3 class="opcion-pago-titulo">Transferencia Bancaria</h3>
                                        </div>
                                        <p class="opcion-pago-descripcion">
                                            Realiza una transferencia directa a nuestra cuenta bancaria
                                        </p>

                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="detalles-pago">
                                <h2 class="detalles-pago-titulo">Resumen del pago</h2>
                                <div class="resumen-item">
                                    <span>Total a pagar</span>
                                    <span><?= $total ?> VP</span>
                                </div>
                                <div class="boton-transferencia">
                                    <a href="/servicios/pedidos/transferencia_exito.php?idPedido=<?= $id ?>" class="btn-continuar">
                                        Continuar con el pago
                                    </a>
                                </div>
                                <div class="boton-stripe">
                                    <form action="/servicios/pedidos/procesar_stripe.php" method="POST">
                                        <input type="hidden" name="idPedido" value="<?= $id ?>">
                                        <button type="submit" class="btn-continuar">
                                            Continuar con el pago
                                        </button>
                                    </form>
                                </div>
                                <div class="boton-paypal"></div>
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
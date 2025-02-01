<?php
include_once __DIR__ . '/../../config/seguridad.php';
include_once __DIR__ . '/../../gestores/GestorCarrito.php';
Seguridad::usuarioPermisos(['usuario']);

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
    <link rel="stylesheet" href="../../media/styles/pagostyle.css">
    <link rel="stylesheet" href="../../media/styles/footer.css">
</head>
<body>
<?php include_once '../navegador/navegadorlogueado.php'; ?>


<main>
    <div class="container-fluid pago-container">
        <div class="container">
            <h1 class="pago-titulo">Datos del pedido</h1>

            <div class="row">
                <div class="col-lg-8">
                    <div class="pago-form">
                        <form action="" method="POST">
                            <div class="form-section">
                                <h2>Información Personal</h2>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nombre</label>
                                            <input type="text" class="form-control" name="nombre" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Primer apellido</label>
                                            <input type="text" class="form-control" name="apellido1" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Segundo apellido</label>
                                            <input type="text" class="form-control" name="apellido2" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>

                            <div class="form-section">
                                <h2>Datos de envío</h2>
                                <div class="form-group">
                                    <label for="direccion">Dirección *</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="localidad">Localidad *</label>
                                            <input type="text" class="form-control" id="localidad" name="localidad"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="localidad">Provincia *</label>
                                            <input type="text" class="form-control" id="provincia" name="provincia"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="localidad">Teléfono *</label>
                                            <input type="text" class="form-control" id="telefono" name="telefono"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn-finalizar">
                                <a href="../carrito/metodoDePago.php"> Continuar al método de pago
                                </a>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="pago-resumen">
                        <h2>Tu Pedido</h2>
                        <div class="resumen-items">
                            <?php foreach ($carrito as $carrritoItem): ?>
                                <div class="resumen-item">
                                    <span> <?= $carrritoItem->getProducto()->getNombre() ?></span>
                                    <span><?= $carrritoItem->getProducto()->getPrecio() ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="resumen-total">
                            <span>Total</span>
                            <span><?= $total ?> VP</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
include_once '../footer/footer.php';
?>
</body>
</html>
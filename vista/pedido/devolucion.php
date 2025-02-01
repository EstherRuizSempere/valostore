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
    <link rel="stylesheet" href="../../media/styles/devolucionStyle.css">
    <link rel="stylesheet" href="../../media/styles/footer.css">
</head>
<body>
<?php include_once '../navegador/navegadorlogueado.php'; ?>


<main>
    <div class="container-fluid devolucion-container">
        <div class="container">
            <h1 class="devolucion-titulo">Solicitar Devolución</h1>

            <div class="devolucion-content">
                <form id="formDevolucion" method="POST" action="#">
                    <div class="pedido-info">
                        <h2 class="pedido-info-titulo">Información del Pedido</h2>
                        <div class="pedido-detalles">
                            <div class="pedido-detalle-item">
                                <div class="detalle-label">Número de Pedido</div>
                                <div class="detalle-valor">#12345</div>
                            </div>
                            <div class="pedido-detalle-item">
                                <div class="detalle-label">Fecha de Compra</div>
                                <div class="detalle-valor">01/02/2025</div>
                            </div>
                            <div class="pedido-detalle-item">
                                <div class="detalle-label">Estado</div>
                                <div class="detalle-valor">Entregado</div>
                            </div>
                        </div>
                    </div>

                    <div class="producto-devolucion">
                        <img src="" alt="Producto" class="producto-imagen">
                        <div class="producto-info">
                            <h3 class="producto-nombre">Nombre del Producto</h3>
                            <div class="producto-categoria">Categoría</div>
                        </div>
                        <div class="producto-precio">1000 VP</div>
                    </div>

                    <div class="form-group">
                        <label for="motivoDevolucion" class="form-label">Motivo de la devolución</label>
                        <select id="motivoDevolucion" name="motivo" class="form-select" required>
                            <option value="">Selecciona un motivo</option>
                            <option value="error">Error en el pedido</option>
                            <option value="defectuoso">Ya no quiero este personaje</option>
                            <option value="insatisfecho">No satisfecho con el producto</option>
                            <option value="otro">Otro motivo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="descripcion" class="form-label">Descripción detallada</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" rows="4" required></textarea>
                        <div class="form-texto-ayuda">Por favor, proporciona todos los detalles posibles sobre el motivo
                            de tu devolución.
                        </div>
                    </div>

                    <div class="botones-container">
                        <button type="submit" class="btn-enviar">Enviar solicitud</button>
                        <a href="" class="btn-cancelar">Cancelar</a>
                    </div>
                </form>

                <div class="politica-devolucion">
                    <h3 class="politica-devolucion-titulo">Política de Devoluciones</h3>
                    <p class="politica-devolucion-texto">
                        Tienes 14 días desde la recepción del pedido para solicitar una devolución.
                        El producto debe ser usado menos de 24h de juego.
                        Una vez recibida tu solicitud, la revisaremos y te contactaremos en un plazo máximo de 48 horas.
                    </p>
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
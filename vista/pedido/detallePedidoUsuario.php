<?php

include_once __DIR__ . '/../../config/seguridad.php';
include_once __DIR__ . '/../../gestores/GestorPedido.php';
include_once __DIR__ . '/../../gestores/GestorLineaPedido.php';

Seguridad::usuarioPermisos(['usuario']);

$id = $_GET['id'];

$gestorPedido = new GestorPedido();
$gestorLineaPedido = new GestorLineaPedido();
$pedido = $gestorPedido->getPedido($id);
$productos = $gestorLineaPedido->getLineasDePedido($id);

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Valo Store</title>
    <link rel="icon" href="../../../media/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../../media/styles/style.css">
    <link rel="stylesheet" href="../../../media/styles/navegadorstyle.css">
    <link rel="stylesheet" href="../../../media/styles/detallePedidoStyle.css">
    <link rel="stylesheet" href="../../../media/styles/footer.css">
</head>
<body>

<?php include_once __DIR__ . '/../navegador/navegadorlogueado.php'; ?>

<main>
    <div class="container-fluid pedidos-container">
        <div class="container">
            <h1 class="pedidos-titulo">Detalle del Pedido</h1>

            <div class="pedidos-content">
                <div class="detalle-item">
                    <span class="id-pedido">Pedido #<?= $pedido->getId() ?></span>
                    <?php if($pedido->getEstado() == "aprobado"): ?>
                        <form action="./../../servicios/pedidos/solicitarReembolso.php" method="post">
                            <input type="hidden" name="id" value="<?= $pedido->getId() ?>">
                            <button class="borrar-perfil-btn" type="submit">
                                Solicitar reembolso
                            </button>
                        </form>
                    <?php endif; ?>

                </div>

                <div class="detalles-pedido">
                    <div class="seccion-detalles">
                        <h2 class="seccion-titulo">Datos del Cliente</h2>
                        <div class="detalle-item">
                            <span>ID Usuario:</span>
                            <span><?= $pedido->getIdUsuario() ?></span>
                        </div>
                        <div class="detalle-item">
                            <span>Nombre:</span>
                            <span><?= $pedido->getNombre() ?> <?= $pedido->getApellido1() ?></span>
                        </div>
                        <div class="detalle-item">
                            <span>Email:</span>
                            <span><?= $pedido->getEmail() ?></span>
                        </div>
                    </div>

                    <div class="seccion-detalles">
                        <h2 class="seccion-titulo">Detalles del Pedido</h2>
                        <div class="detalle-item">
                            <span>Fecha:</span>
                            <span><?= $pedido->getFecha()->format('d/m/Y H:i') ?></span>
                        </div>
                        <div class="detalle-item">
                            <span>Estado:</span>
                            <span class="estado estado-<?= strtolower($pedido->getEstado()) ?>"><?= $pedido->getEstado()?></span>
                        </div>
                    </div>
                </div>

                <div class="seccion-detalles">
                    <h2 class="seccion-titulo">Productos</h2>
                    <div class="productos-lista">
                        <?php foreach ($productos as $producto) { ?>
                            <div class="producto-item">
                                <img src="<?= $producto->getImagen() ?>" alt="<?= $producto->getNombre() ?>" class="producto-imagen">
                                <div>
                                    <h3><?= $producto->getNombre() ?></h3>
                                </div>
                                <span class="producto-precio"><?= $producto->getPrecio() ?>P</span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="total-pedido">
                        <span>Total: <?= $pedido->getTotal() ?>P</span>
                    </div>
                    <a href="/vista/usuario/normal/misPedidos.php" class="borrar-perfil-btn">
                        Vuelve atrás
                    </a>
                </div>
            </div>

        </div>

    </div>
</main>


<?php include_once __DIR__ . '/../footer/footer.php'; ?>

</body>
</html>
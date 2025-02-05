<?php

include_once __DIR__ . '/../../../config/seguridad.php';
include_once __DIR__ . '/../../../gestores/GestorPedido.php';

Seguridad::usuarioPermisos(['usuario']);

$gestorPedido = new GestorPedido();
$pedidos = $gestorPedido-> listarPedidosUsuario($_SESSION['id']);

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
    <link rel="stylesheet" href="../../../media/styles/tablaPedidoStyle.css">
    <link rel="stylesheet" href="../../../media/styles/footer.css">
</head>
<body>

<?php include_once __DIR__ . '/../../navegador/navegadorlogueado.php'; ?>


<main>
    <div class="container-fluid pedidos-container">
        <div class="container">
            <h1 class="pedidos-titulo">Gestión de Pedidos</h1>

            <div class="pedidos-content">
                <div class="filtros-container">
                    <div class="filtro-grupo">
                        <label class="filtro-label">Estado:</label>
                        <select class="filtro-select">
                            <option value="">Todos</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="procesando">Procesando</option>
                            <option value="enviado">Enviado</option>
                            <option value="entregado">Entregado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                    <div class="filtro-grupo">
                        <label class="filtro-label">Fecha:</label>
                        <input type="date" class="filtro-select">
                    </div>
                    <div class="filtro-grupo">
                        <input type="text" class="busqueda-input" placeholder="Buscar por ID...">
                    </div>
                </div>

                <div class="tabla-responsive">
                    <table class="tabla-pedidos">
                        <thead>
                        <tr>
                            <th>ID Pedido</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>ID Usuario</th>
                            <th style="width: 140px">Acciones</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($pedidos as $pedido) { ?>
                            <tr>
                                <td><span class="id-pedido"><?= $pedido->getId() ?></span></td>
                                <td><span><?= $pedido->getFecha()->format('Y-m-d') ?> - <?= $pedido->getFecha()->format('H:i') ?></span></td>
                                <td><span class="precio-pedido"><?= $pedido->getTotal() ?>P</span></td>
                                <td>

                                    <?php

                                    switch ($pedido->getEstado()) {
                                        case 'recibido':
                                            echo '<span class="estado estado-recibido">Recibido</span>';
                                            break;
                                        case 'pendiente':
                                            echo '<span class="estado estado-pendiente">Pendiente</span>';
                                            break;
                                        case 'aprobado':
                                            echo '<span class="estado estado-aprobado">Aprobado</span>';
                                            break;
                                        case 'enviado':
                                            echo '<span class="estado estado-enviado">Enviado</span>';
                                            break;
                                        case 'cancelado':
                                            echo '<span class="estado estado-cancelado">Cancelado</span>';
                                            break;
                                        case 'reembolsado':
                                            echo '<span class="estado estado-reembolsado">Reembolsado</span>';
                                            break;
                                        case 'error':
                                            echo '<span class="estado estado-cancelado">Error</span>';
                                            break;
                                    }
                                    ?>

                                </td>
                                <td><?= $pedido->getIdUsuario() ?></td>
                                <td>
                                    <a href="./../../pedido/detallePedidoUsuario.php?id=<?=$pedido->getId()?>" class="btn btn-sm admin-btn"><i class="bi bi-eye"></i></a>

                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="paginacion">
                    <a href="#" class="pagina-link">Anterior</a>
                    <a href="#" class="pagina-link activa">1</a>
                    <a href="#" class="pagina-link">2</a>
                    <a href="#" class="pagina-link">3</a>
                    <a href="#" class="pagina-link">Siguiente</a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include_once __DIR__ . '/../../footer/footer.php'; ?>

</body>
</html>
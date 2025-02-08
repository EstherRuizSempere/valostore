<?php

include_once __DIR__ . '/../../../config/seguridad.php';
include_once __DIR__ . '/../../../gestores/GestorPedido.php';

Seguridad::usuarioPermisos(['admin', 'editor']);

$filtroEstado = $_GET['estado'] ?? null;
$filtroFecha = $_GET['fecha'] ?? null;
$filtroIdPedido = $_GET['idPedido'] ?? null;
$pagina = $_GET['pagina'] ?? 1;
$limite = 10;
$inicio = ($pagina - 1) * $limite;

$gestorPedido = new GestorPedido();
$resultadoPedidos = $gestorPedido->listarPedidos($filtroEstado, $filtroFecha, $filtroIdPedido, $inicio, $limite);

$pedidos = $resultadoPedidos['pedidos'];
$totalPedidos = $resultadoPedidos['totalPedidos'];


$totalPaginas = ceil($totalPedidos / $limite); //uso ceil para redondear el número de páginas


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
                <form action="tablaPedidos.php" method="get">
                    <div class="filtros-container">
                        <div class="filtro-grupo">
                            <label class="filtro-label">Estado:</label>
                            <select class="filtro-select" name="estado">
                                <option value="" <?= ($filtroEstado == null ? "selected" : "") ?>>Todos</option>
                                <option value="recibido" <?= ($filtroEstado == "recibido" ? "selected" : "") ?>>Recibido</option>
                                <option value="pendiente" <?= ($filtroEstado == "pendiente" ? "selected" : "") ?>>Pendiente</option>
                                <option value="aprobado" <?= ($filtroEstado == "aprobado" ? "selected" : "") ?>>Aprobado</option>
                                <option value="enviado" <?= ($filtroEstado == "enviado" ? "selected" : "") ?>>Enviado</option>
                                <option value="cancelado" <?= ($filtroEstado == "cancelado" ? "selected" : "") ?>>Cancelado</option>
                                <option value="reembolsado" <?= ($filtroEstado == "reembolsado" ? "selected" : "") ?>>Reembolsado</option>
                                <option value="error" <?= ($filtroEstado == "error" ? "selected" : "") ?>>Error</option>
                            </select>
                        </div>
                        <div class="filtro-grupo">
                            <label class="filtro-label">Fecha:</label>
                            <input type="date" class="filtro-select" name="fecha" value="<?= $filtroFecha ?>">
                        </div>
                        <div class="filtro-grupo">
                            <input type="text" class="busqueda-input" placeholder="Buscar por ID..." name="idPedido" value="<?= $filtroIdPedido ?>">
                        </div>
                        <div class="filtro-grupo">
                            <input type="submit" value="Buscar">
                        </div>
                    </div>

                </form>
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
                                <a href="detallePedidoAdmin.php?id=<?=$pedido->getId()?>" class="btn btn-sm admin-btn"><i class="bi bi-eye"></i></a>

                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="paginacion">
                    <?php if ($pagina > 1): ?>
                        <a href="?pagina=<?= $pagina - 1 ?>" class="pagina-link">Anterior</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <a href="?pagina=<?= $i ?>" class="pagina-link <?= ($i == $pagina) ? 'activa' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>

                    <?php if ($pagina < $totalPaginas): ?>
                        <a href="?pagina=<?= $pagina + 1 ?>" class="pagina-link">Siguiente</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include_once __DIR__ . '/../../footer/footer.php'; ?>

</body>
</html>

<?php

include_once __DIR__ . '/../../../config/seguridad.php';
include_once __DIR__ . '/../../../gestores/GestorInformes.php';
Seguridad::usuarioPermisos(['admin', 'editor']);


$gestorInformes = new GestorInformes();
$totalVentas = $gestorInformes->getTotalVentas();
$totalPedidosCompletados = $gestorInformes->getTotalPedidosCompletados();
$cestaMedia = $gestorInformes->getCestaMedia();

$totalVentasProductoUnidad = $gestorInformes->totalVentasPersoajes();
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
    <link rel="stylesheet" href="../../../media/styles/totalVentasStyle.css">
    <link rel="stylesheet" href="../../../media/styles/footer.css">
</head>
<body>

<?php include_once __DIR__ . '/../../navegador/navegadorlogueado.php'; ?>

<main>
    <div class="container-fluid pedidos-container">
        <div class="container">
            <h1 class="pedidos-titulo">Informe de Ventas Mensual</h1>

            <div class="pedidos-content">
                <div class="resumen-ventas">
                    <div class="resumen-card">
                        <h3>Ventas Totales</h3>
                        <p class="valor-resumen"><?= $totalVentas ?> €</p>
                    </div>
                    <div class="resumen-card">
                        <h3>Pedidos Completados</h3>
                        <p class="valor-resumen"><?= $totalPedidosCompletados ?></p>
                    </div>
                    <div class="resumen-card">
                        <h3>Ticket Promedio</h3>
                        <p class="valor-resumen"><?= $cestaMedia ?>€</p>
                    </div>
                </div>

                <div class="filtros-container">
                    <div class="filtro-grupo">
                        <label class="filtro-label">Mes:</label>
                        <select class="filtro-select">
                            <option value="1">Enero</option>
                            <option value="2" selected>Febrero</option>
                            <option value="3">Marzo</option>
                        </select>
                    </div>
                    <div class="filtro-grupo">
                        <label class="filtro-label">Año:</label>
                        <select class="filtro-select">
                            <option value="2025" selected>2025</option>
                            <option value="2024">2024</option>
                        </select>
                    </div>
                    <div class="filtro-grupo">
                        <label class="filtro-label">Categoría:</label>
                        <select class="filtro-select">
                            <option value="">Todas</option>
                            <option value="skins">Skins</option>
                            <option value="pases">Pases de Batalla</option>
                            <option value="puntos">Puntos VP</option>
                        </select>
                    </div>
                </div>

                <div class="tabla-responsive">
                    <table class="tabla-pedidos">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Unidades Vendidas</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($totalVentasProductoUnidad as $producto) { ?>
                        <tr>
                            <td><span class="producto-nombre"><?= $producto["id"] ?></span></td>
                            <td><?= $producto["nombreProducto"] ?></td>
                            <td><?= $producto["nombreCategoriaPadre"] ?></td>
                            <td><span class="precio-pedido"><?= $producto["unidadesVendidas"] ?></span></td>
                            <td><span class="porcentaje"><?= $producto["total"] ?> €</span></td>
                        </tr>

                        <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="paginacion">
                    <a href="#" class="pagina-link">Anterior</a>
                    <a href="#" class="pagina-link activa">1</a>
                    <a href="#" class="pagina-link">2</a>
                    <a href="#" class="pagina-link">Siguiente</a>
                </div>
            </div>
        </div>
    </div>
</main>


<?php include_once __DIR__ . '/../../footer/footer.php'; ?>
</body>
</html>
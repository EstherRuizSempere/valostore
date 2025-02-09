<?php
include_once __DIR__ . '/../../../config/seguridad.php';
include_once __DIR__ . '/../../../gestores/GestorInformes.php';
include_once __DIR__ . '/../../../gestores/GestorCategoria.php';

Seguridad::usuarioPermisos(['admin', 'editor']);

$filtroOrden = $_GET['orden'] ?? null;
$filtroCategoria = $_GET['categoria'] ?? null;
$pagina = $_GET['pagina'] ?? 1;
$limite = 5;
$inicio = ($pagina - 1) * $limite;


$gestorInformes = new GestorInformes();
$gestorCategoria = new GestorCategoria();


$totalVentas = $gestorInformes->getTotalVentas();
$totalPedidosCompletados = $gestorInformes->getTotalPedidosCompletados();
$cestaMedia = $gestorInformes->getCestaMedia();
$totalCategorias = $gestorCategoria->listarCategoriasPadre();

$totalVentasProductoUnidad = $gestorInformes->totalVentasPersoajes($filtroOrden, $filtroCategoria, $inicio, $limite);

$listaProductos = $totalVentasProductoUnidad['totalVentasProductoUnidad'];
$totalProductos = $totalVentasProductoUnidad['totalVentas'];

$totalPaginas = ceil($totalProductos / $limite); //uso ceil para redondear el número de páginas

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
            <h1 class="pedidos-titulo">Total ventas</h1>

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


                <form action="totalVentas.php" method="GET">
                    <div class="filtros-container">
                        <div class="filtro-grupo">
                            <label class="filtro-label">Ordenar</label>
                            <select class="filtro-select" name="orden">
                                <option value="nombreProducto asc" <?= ($filtroOrden == 'nombreProducto asc') ? 'selected' : '' ?>>Nombre:
                                    A-Z
                                </option>
                                <option value="nombreProducto desc" <?= ($filtroOrden == 'nombreProducto desc') ? 'selected' : '' ?>>Nombre:
                                    Z-A
                                </option>
                                <option value="total asc" <?= ($filtroOrden == 'total asc') ? 'selected' : '' ?> >Total:
                                    Menor a Mayor
                                </option>
                                <option value="total desc" <?= ($filtroOrden == 'total desc') ? 'selected' : '' ?> >Total:
                                    Mayor a Menor
                                </option>
                                <option value="unidadesVendidas desc" <?= ($filtroOrden == 'unidadesVendidas desc') ? 'selected' : '' ?> >Unidades vendidas:
                                    Mayor a Menor
                                </option>
                                <option value="unidadesVendidas asc" <?= ($filtroOrden == 'unidadesVendidas asc') ? 'selected' : '' ?> >Unidades vendidas:
                                    Menor a Mayor
                                </option>
                            </select>
                        </div>
                        <div class="filtro-grupo">
                            <label class="filtro-label">Categoría:</label>
                            <select class="filtro-select" name="categoria">
                                <option value="">Todas las categorias</option>
                                <?php foreach ($totalCategorias as $categoriaPadre) { ?>
                                    <option value="<?= $categoriaPadre->getId() ?>"><?= $categoriaPadre->getNombre() ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <button type="submit" class="btn search-button">

                            <i class="bi bi-search"></i>
                        </button>
                    </div>

                </form>


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
                        <?php foreach ($listaProductos as $producto) { ?>
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
                    <?php if ($pagina > 1): ?>
                        <a href="?pagina=<?= $pagina - 1 ?>" class="pagina-link">Anterior</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <a href="?pagina=<?= $i ?>"
                           class="pagina-link <?= ($i == $pagina) ? 'activa' : '' ?>"><?= $i ?></a>
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
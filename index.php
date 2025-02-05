<?php
session_start();
include_once __DIR__ . '/gestores/GestorProducto.php';
$nombre = $_GET['nombre'] ?? null;

$gestorProducto = new GestorProducto();
$productos = $gestorProducto->listarProductos($nombre);

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Valo Store</title>
    <link rel="icon" href="./media/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./media/styles/style.css">
    <link rel="stylesheet" href="./media/styles/navegadorstyle.css">
    <link rel="stylesheet" href="./media/styles/catalogoStyle.css">
    <link rel="stylesheet" href="./media/styles/footer.css">
</head>
<body>

<?php
if (isset($_SESSION['usuario'])) {
    include_once __DIR__ . '/vista/navegador/navegadorlogueado.php';
} else {
    include_once __DIR__ . '/vista/navegador/navegadornologueado.php';
}
?>
<main>
    <div class="container-fluid catalogo-container">
        <div class="container">
            <h1 class="catalogo-header">Catálogo de Personajes</h1>

            <div class="filtros-section">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <select class="form-select">
                            <option selected>Ordenar por...</option>
                            <option value="precio_asc">Precio: Menor a Mayor</option>
                            <option value="precio_desc">Precio: Mayor a Menor</option>
                            <option value="categoria_asc">Categoría: A-Z</option>
                            <option value="categoria_desc">Categoría: Z-A</option>
                            <option value="nombre_asc">Nombre: A-Z</option>
                            <option value="nombre_desc">Nombre: Z-A</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <form class="search-container" method="GET" action="index.php">
                            <input type="text" class="form-control search-input" placeholder="Buscar personaje..."
                                   name="nombre" value="<?= $nombre?>">
                            <button type="submit" class="btn search-button">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="contenedor-cards">
            <div class="row">
                <?php foreach ($productos as $producto) { ?>
                    <div class="col-md-3 mb-4">
                        <a href="/vista/producto/producto-detalle.php?id=<?= $producto->getId() ?>">
                            <div class="personaje-card">
                                <div class="personaje-imagen">
                                    <img src="<?= $producto->getImagen() ?>" alt="Jett">
                                </div>

                                <div class="personaje-detalles">
                                    <h3 class="personaje-nombre"><?= $producto->getNombre() ?></h3>
                                    <span class="personaje-rol"><?= $producto->getCategoria() ?></span>
                                    <div class="personaje-precio"><?= $producto->getPrecio() ?> VP</div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</main>

<?php include_once __DIR__ . '/vista/footer/footer.php'; ?>

</body>
</html>
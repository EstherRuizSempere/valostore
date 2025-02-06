<?php
session_start();
include_once __DIR__ . '/gestores/GestorProducto.php';
//Capturo las variables de la url
$nombre = $_GET['nombre'] ?? null;
$orden = $_GET['orden'] ?? 'ASC';
$categoria_id = $_GET['categoria'] ?? null;


$gestorProducto = new GestorProducto();
//Obtengo los productos
$productos = $gestorProducto->listarProductos($nombre);

//Me genero un switch para ordenar los productos dependiendo el filtro:
if (isset($_GET['orden'])) {
    //Si el usuario ha elegido un orden especifico a través del get, uso el swtich que corresponda
    switch ($_GET['orden']) {
        case 'precio_asc':
            $productos = $gestorProducto->listarProductosPrecio(null, 'ASC');
            break;
        case 'precio_desc':
            $productos = $gestorProducto->listarProductosPrecio(null, 'DESC');
            break;
        case 'categoria_asc':
            if ($categoria_id) {
                $productos = $gestorProducto->listarProductosPorCategoria($categoria_id, 'ASC');
            } else {
                $productos = $gestorProducto->listarProductos(null, 'ASC');
            }
            break;
        case 'categoria_desc':
            if ($categoria_id) {
                $productos = $gestorProducto->listarProductosPorCategoria($categoria_id, 'DESC');
            } else {
                $productos = $gestorProducto->listarProductos(null, 'DESC');
            }
            break;
        case 'nombre_asc':
            $productos = $gestorProducto->listarProductos($nombre, 'ASC');
            break;
        case 'nombre_desc':
            $productos = $gestorProducto->listarProductos($nombre, 'DESC');
            break;
        default:
            $productos = $gestorProducto->listarProductos($nombre, 'ASC');
    }


}

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
                        <form class="search-container" method="GET" action="index.php">
                            <select class="form-select" name="orden">
                                <option value="precio_asc" <?= ($orden == 'precio_asc') ? 'selected' : '' ?> >Precio:
                                    Menor a Mayor
                                </option>
                                <option value="precio_desc" <?= ($orden == 'precio_desc') ? 'selected' : '' ?>>Precio:
                                    Mayor a Menor
                                </option>
                                <option value="categoria_asc" <?= ($orden == 'categoria_asc') ? 'selected' : '' ?>>
                                    Categoría: A-Z
                                </option>
                                <option value="categoria_desc" <?= ($orden == 'categoria_desc') ? 'selected' : '' ?>>
                                    Categoría: Z-A
                                </option>
                                <option value="nombre_asc" <?= ($orden == 'nombre_asc') ? 'selected' : '' ?>>Nombre:
                                    A-Z
                                </option>
                                <option value="nombre_desc" <?= ($orden == 'nombre_desc') ? 'selected' : '' ?>>Nombre:
                                    Z-A
                                </option>
                            </select>
                            <?php if ($nombre): ?>
                            <?php //Me creo un input con el valor oculto para conservar el valor del filtro de la búsqueda ?>
                                <input type="hidden" name="nombre" value="<?= htmlspecialchars($nombre) ?>">
                            <?php endif; ?>
                            <?php if ($categoria_id): ?>
                                <input type="hidden" name="categoria" value="<?= htmlspecialchars($categoria_id) ?>">
                            <?php endif; ?>
                            <button type="submit" class="btn search-button">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form class="search-container" method="GET" action="index.php">
                            <input type="text" class="form-control search-input" placeholder="Buscar personaje..."
                                   name="nombre" value="<?= $nombre ?>">
                            <?php if ($orden && $orden !== 'ASC'): ?>
                                <input type="hidden" name="orden" value="<?= htmlspecialchars($orden) ?>">
                            <?php endif; ?>

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
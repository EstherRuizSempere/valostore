<?php

include_once __DIR__ . '/../../../config/seguridad.php';
include_once __DIR__ . '/../../../gestores/GestorProducto.php';
include_once __DIR__ . '/../../../gestores/GestorPedido.php';
include_once __DIR__ . '/../../../gestores/GestorUsuarioProducto.php';


Seguridad::usuarioPermisos(['usuario']);

$gestorProducto = new GestorProducto();
$gestorPedido = new GestorPedido();
$gestorUsuarioProducto = new GestorUsuarioProducto();

$productosDeUsuario = $gestorProducto->getProductosDeUsuario($_SESSION['id']);
$pedidos = $gestorPedido->listarPedidosUsuario($_SESSION['id']);

$personajesNoPosesion = count($gestorProducto->listarProductos()) - count($productosDeUsuario);
$listadoPersonajesNoEnPosesion = $gestorUsuarioProducto->productoNoEnPosesion($_SESSION['id'], count($productosDeUsuario));


?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lol Store</title>
    <link rel="icon" href="../../../media/img/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../../media/styles/style.css">
    <link rel="stylesheet" href="../../../media/styles/navegadorstyle.css">
    <link rel="stylesheet" href="../../../media/styles/zonaUsuarioNormalStyle.css">
    <link rel="stylesheet" href="../../../media/styles/footer.css">
</head>
<body>
<?php include_once '../../navegador/navegadorlogueado.php'; ?>

<main>
    <div class="container-fluid perfil-container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card perfil-card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="perfil-avatar">
                                    <img src="../../../media/img/imagen-perfil.png" alt="Avatar del usuario"
                                         class="img-fluid rounded">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="perfil-info">
                                    <span class="status-badge">
                                        <i class="bi bi-circle-fill"></i> Online
                                    </span>
                                    <h2 class="perfil-username"><?php echo $_SESSION['usuario'] ?></h2>
                                    <div class="mb-2 ">
                                        <a href="../editarContrasenya.php" class="btn  edit-perfil-btn">
                                            <i class="bi bi-pencil"></i> Cambio Contraseña
                                        </a>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a href="actualizarUsuarioNormal.php" class="btn  edit-perfil-btn">
                                                <i class="bi bi-pencil"></i> Editar Perfil
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="borrarUsuarioNormal.php" class="btn  edit-perfil-btn">
                                                <i class="bi bi-trash"></i> Eliminar Perfil
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="perfil-status">
                                    <div class="status-item">
                                        <i class="bi bi-person-badge"></i>
                                        <span class="status-valor"><?= count($productosDeUsuario) ?></span>
                                        <span class="status-label">Personajes</span>
                                    </div>
                                    <div class="status-item">
                                        <a href=""> <i class="bi bi-backpack3"></i>
                                            <span class="status-valor"><?= count($pedidos) ?></span>
                                            <span class="status-label">Compras</span>
                                        </a>

                                    </div>
                                    <div class="status-item">
                                        <i class="bi bi-slash-circle"></i>
                                        <span class="status-valor"><?= $personajesNoPosesion ?></span>
                                        <span class="status-label">Personajes no en posesión</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card personajes-card mb-4">
                    <div class="card-header">
                        <h3><i class="bi bi-people"></i> Tus Personajes</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($productosDeUsuario as $producto) { ?>
                                <div class="col-md-2 mb-4">
                                    <div class="personaje-item">
                                        <div class="personaje-imagen">
                                            <img src="<?= $producto->getImagen() ?>" alt="Personaje 1"
                                                 class="img-fluid">
                                            <div class="personaje-detalles">
                                                <button class="btn btn-light btn-sm">Ver Detalles</button>
                                            </div>
                                        </div>
                                        <div class="personaje-info">
                                            <h4><?= $producto->getNombre() ?></h4>
                                            <span class="personaje-rol"><?= $producto->getCategoria() ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php }; ?>
                        </div>
                    </div>
                </div>
                <div class="card personajes-card mb-4">
                    <div class="card-header">
                        <h3><i class="bi bi-person-dash"></i> Personajes no en posesión</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($listadoPersonajesNoEnPosesion as $productoNoPosesion){ ?>

                            <div class="col-md-2 mb-4">
                                <div class="personaje-item">
                                    <div class="personaje-imagen">
                                        <img src="<?= $productoNoPosesion->getImagen() ?>" alt="Personaje 1"
                                             class="img-fluid">
                                        <div class="personaje-detalles">
                                            <a href="/vista/producto/producto-detalle.php?id=<?= $productoNoPosesion->getId() ?>" class="btn btn-light btn-sm">Ver Detalles</a>
                                        </div>
                                    </div>
                                    <div class="personaje-info">
                                        <h4><?= $productoNoPosesion->getNombre() ?></h4>
                                        <span class="personaje-rol"><?= $productoNoPosesion->getCategoria() ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php }; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<?php include_once '../../footer/footer.php'; ?>

</body>
</html>
<?php

include_once __DIR__ . '/../../../config/seguridad.php';
include_once __DIR__ . '/../../../gestores/GestorProducto.php';

Seguridad::usuarioPermisos(['admin', 'editor']);

$gestorProducto = new GestorProducto();

try {
    $producto = $gestorProducto->listarProductoUnico($_GET['id']);
} catch (Exception $e) {
    header("Location: tablaProducto.php?error=ProductoNoEncontrado");
    exit();
}

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
    <link rel="stylesheet" href="../../../media/styles/productonuevostyle.css">
    <link rel="stylesheet" href="../../../media/styles/footer.css">
</head>
<body>
<?php include_once __DIR__ . '/../../navegador/navegadorlogueado.php'; ?>
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="formulario-producto">
                    <div class="header-text">
                        <h4><span>Actualizar</span> Producto</h4>
                        <p>Modifica los detalles del producto <?php echo $producto->getNombre() ?></p>
                    </div>

                    <form id="actualizarProductoForm" action="../../../servicios/productos/editarProducto.php"
                          method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $producto->getId() ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="categoria_id" class="form-label">Tipo de personaje*</label>
                                    <select name="categoria_id" class="form-control selector-categoria"
                                            id="categoria_id" required>
                                        <option value="">Selecciona tipo de personaje</option>
                                        <option <?= ($producto->getCategoriaId() == 5) ? "selected" : "" ?> value="5">Duelista - Alta moviliadad</option>
                                        <option value="6"></option>
                                        <option value="7"></option>
                                        <option value="8"></option>
                                        <option value="9"></option>
                                        <option value="10"></option>
                                        <option value="11"></option>
                                        <option value="12"></option>
                                        <option value="13"></option>
                                        <option value="14"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="activo" class="form-label">Activo*</label>
                                    <select name="activo" class="form-control selector-categoria"
                                            id="activo" required>
                                        <option <?= $producto->getActivo() == 1 ? "selected" : "" ?> value="1">Activo</option>
                                        <option <?= $producto->getActivo() == 0 ? "selected" : "" ?> value="0">Inactivo</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre del personaje*</label>
                                    <input type="text" name="nombre" class="form-control" id="nombre"
                                           required value="<?php echo $producto->getNombre() ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="precio" class="form-label">Precio*</label>
                                    <input type="number" name="precio" class="form-control" id="precio" step="0.01"
                                           required value="<?php echo $producto->getPrecio() ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="imagen" class="form-label">Imagen del Producto*</label>
                                    <input type="file" name="imagen" class="form-control imagen-form" id="imagen"
                                            value="<?php echo $producto->getImagen() ?>">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion" class="form-control" id="descripcion"
                                      rows="3"><?php  echo $producto->getDescripcion(); ?></textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Actualizar Producto</button>
                            <a class="btn btn-primary ms-4" href="tablaProducto.php">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 footer-info">
                <img src="../../../media/img/logo-valostore.png" alt="Logo Valo Store" class="footer-logo">
                <p class="mt-3">Tu tienda de confianza para conseguir los mejores personajes de Valorant.</p>
                <div class="social-links mt-3">
                    <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="discord"><i class="bi bi-discord"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 footer-links">
                <h4>Enlaces Útiles</h4>
                <ul>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Inicio</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Tienda</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Sobre Nosotros</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Términos y Condiciones</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Política de Privacidad</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-6 footer-contacto">
                <h4>Contáctanos</h4>
                <p>
                    <i class="bi bi-geo-alt"></i> Calle Principal, 123 <br>
                    03201 Elche, España<br><br>
                    <i class="bi bi-phone"></i> +34 999 999 999<br>
                    <i class="bi bi-envelope"></i> info@valostore.com<br>
                </p>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="copyright">
                        © 2025 <strong>Esther Ruiz Sempere</strong>. Todos los derechos reservados.
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
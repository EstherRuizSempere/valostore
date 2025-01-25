<!doctype html>
<html lang="en">
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
    <link rel="stylesheet" href="../../media/styles/loginstyle.css">
    <link rel="stylesheet" href="../../media/styles/navegadorstyle.css">
</head>
<body>

    <div class="w-100 vh-100 d-flex flex-column" id="contenedor-padre">
    <?php include_once '../navegador/navegadornologueado.php'; ?>

        <main class="container-fluid d-flex justify-content-end align-items-center flex-grow-1">
            <div class="card m-2 row justify-content-center">
                <div class="row align-items-center">
                    <div class="col-md-12 justify-content-center text-center">
                        <img class="img-fluid img-login" src="../../media/img/Astra.png"
                             alt="Logo poro">
                        <h3 class="text-center mb-4 ">Iniciar Sesión</h3>
                        <form method="POST" action="../../servicios/autentifiacion/login.php">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                                <input type="email" class="form-control" placeholder="Email" name="email"
                                       aria-label="email"
                                       aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon2">
                <i class="bi bi-lock"></i>
            </span>
                                <input type="password" class="form-control" name="contrasenya" placeholder="Contraseña">
                            </div>
                            <input type="submit" class="btn w-100 bton-secondary boton-formulario" value="Entrar">
                        </form>
                        <a class="pt-4 d-inline-block forgot-password" href="../usuario/olvidarContrasenya.php">¿Has olvidado la contraseña?</a>
                        <a class="d-inline-block nuevo-miembro" href="../usuario/registro.php">¿No estás registrado? ¡Hazlo!</a>

                    </div>
                </div>
            </div>

        </main>
        <footer>
            <div class="container-fluid ">
                <div class="footer-legal text-center mt-3">
                    <p>© 2025 Esther Ruiz Sempere. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
    </div>

</body>
</html>
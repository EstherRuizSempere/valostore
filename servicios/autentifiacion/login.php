<?php
include_once __DIR__ . '/../../gestores/GestorUsuarios.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}

//Defino las variables que llegan por post y compruebo que no estén vacías
$email = $_POST["email"] ?? null;
$contrasenya = $_POST["contrasenya"] ?? null;

//Si está vacio algún campo, no puedo loguearme
if ($email == null || $contrasenya == null) {
    header("Location: ../../vista/login/login.php?error=CamposVacios");
    exit();
}

try {
    $gestorUsuarios = new GestorUsuarios();


    //Verifico el autentifiacion:
    $usuario = $gestorUsuarios->verificarLogin($email, $contrasenya);

    //Si el usuario no existe, me dará el error:
    if ($usuario == null) {
        header("Location: ../../vista/login/login.php?error=UsuarioNoExiste");
        exit();
    }
    //Comprobamos que el usuario esté activo
    if($usuario->getActivo() == 0){
        header("Location: ../../vista/login/login.php?error=UsuarioNoActivo");
        exit();
    }

    //Si el usuario sí existe, crea la sesión
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['id'] = $usuario->getId();
    $_SESSION['usuario'] = $usuario->getUsuario();
    $_SESSION['email'] = $usuario->getEmail();
    $_SESSION['nombre'] = $usuario->getNombre();
    $_SESSION['rol'] = $usuario->getRol();

    //Dependiendo del rol lo redirigimos a un lugar, u otro:
    if ($usuario->getRol() == "usuario") {
        header("Location: ../../vista/usuario/normal/zonaUsuarioNormal.php");
        exit();
    }else if ($usuario->getRol() == "admin" || $usuario->getRol() == "editor") {
        header("Location: ../../vista/backoffice/perfil/zonaAdmin.php");
        exit();
    }

} catch (Exception $error) {
    header("Location: ../../vista/login/login.php?error=" . $error->getMessage());
    exit();
}
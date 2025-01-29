<?php
require_once __DIR__ . '/../../config/seguridad.php';
require_once __DIR__ . '/../../gestores/GestorUsuarios.php';
require_once __DIR__ . '/../../config/utilidades.php';

//Usuarios que tienen permiso para entrar
Seguridad::usuarioPermisos(['usuario', 'admin', 'editor']);

//Si el método no viene por post, return
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}

//Defino las variables que llegan por post y compruebo que no estén vacías
$contrasenya = $_POST["contrasenya"] ?? null;
$validarContrasenya = $_POST["validarContrasenya"] ?? null;


//Compruebo que los datos no estén vacíos
if ($contrasenya == null || $validarContrasenya == null) {
    header("Location: ../../vista/usuario/editarContrasenya.php?error=CamposVacios");
    exit();
}

//Compruebo que las contraseñas sean válidas:
if ($contrasenya != $validarContrasenya) {
    header("Location: ../../vista/usuario/editarContrasenya.php?error=LasContrasenyasNoCoinciden");
    exit();
}

if (!Utilidades::validarContrasenya($contrasenya)) {
    header("Location: ../../vista/usuario/editarContrasenya.php?error=ContrasenyaNoValida");
    exit();
}


$gestorUsuarios = new GestorUsuarios();


try{
    $gestorUsuarios->editarContrasenya($_SESSION['id'], $contrasenya);

    if ($_SESSION['rol'] == 'usuario') {
        header("Location: ../../vista/usuario/normal/zonaUsuarioNormal.php?mensaje=ContrasenyaActualizada");
        exit();
    } else if ($_SESSION['rol'] == 'admin' || $_SESSION['rol'] == 'editor') {
        header("Location: ../../vista/backoffice/perfil/zonaAdmin.php?mensaje=ContrasenyaActualizada");
        exit();
    }
}catch (Exception $e) {
   if ($_SESSION['rol'] == 'usuario') {
        header("Location: ../../vista/usuario/normal/zonaUsuarioNormal.php?error=ErrorActualizarContrasenya");
        exit();
    } else if ($_SESSION['rol'] == 'admin' || $_SESSION['rol'] == 'editor') {
        header("Location: ../../vista/backoffice/perfil/zonaAdmin.php?error=ErrorActualizarContrasenya");
        exit();
    }
}
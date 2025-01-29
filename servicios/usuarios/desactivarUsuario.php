<?php
require_once __DIR__ . '/../../gestores/GestorUsuarios.php';
require_once __DIR__ . '/../../config/seguridad.php';
require_once __DIR__ . '/../../config/utilidades.php';


Seguridad::usuarioPermisos(['usuario']);

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}

//Defino las variables que llegan por post y compruebo que no estén vacías
$id = $_SESSION['id'];
$contrasenya = $_POST["contrasenya"] ?? null;

//Compruebo que los datos no estén vacíos
if ($contrasenya == null) {
    header("Location: ../../vista/usuario/normal/borrarUsuarioNormal.php?error=CamposVacios");
    exit();
}
//llamo al gestor de usuarios
$gestorUsuarios = new GestorUsuarios();
$usuario_bd = $gestorUsuarios->getUsuario($id);

//Compruebo que la contraseña esté bien:
if($usuario_bd->getContrasenya() != Utilidades::hashContrasenya($contrasenya)){

    header("Location: ../../vista/usuario/normal/borrarUsuarioNormal.php?error=ContrasenyaIncorrecta");
    exit();
}

$gestorUsuarios->desactivarUsuario($id);
include_once __DIR__ . '../autentificacion/logout.php';
header("Location: ../../vista/login/login.php?mensaje=UsuarioDesactivado");
exit();
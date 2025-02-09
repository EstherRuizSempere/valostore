<?php
require_once __DIR__ . '/../../gestores/GestorUsuarios.php';
require_once __DIR__ . '/../../config/seguridad.php';
require_once __DIR__ . '/../../config/utilidades.php';

//Permito acceso a:
Seguridad::usuarioPermisos(['usuario', 'admin', 'editor']);

//Compruebo que el método de la petición sea POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}

//Defino las variables que llegan por post y compruebo que no estén vacías
$usuario = $_POST["usuario"] ?? null;
$email = $_POST["email"] ?? null;
$nombre = $_POST["nombre"] ?? null;
$apellido1 = $_POST["apellido1"] ?? null;
$apellido2 = $_POST["apellido2"] ?? null;
$direccion = $_POST["direccion"] ?? null;
$localidad = $_POST["localidad"] ?? null;
$provincia = $_POST["provincia"] ?? null;
$telefono = $_POST["telefono"] ?? null;
$fechaNacimiento = $_POST["fechaNacimiento"] ?? null;
$rol = $_SESSION['rol']; //Mantengo el rol actual del usuario
$activo = 1;

//Compruebo que los datos no estén vacíos
if ($usuario == null || $email == null || $nombre == null || $apellido1 == null || $apellido2 == null || $direccion == null || $localidad == null || $provincia == null || $telefono == null || $fechaNacimiento == null) {
    header("Location: ../../vista/usuario/normal/actualizarUsuarioNormal.php?error=CamposVacios");
    exit();
}

//Comrpuebo la fecha de nacimiento
Utilidades::validarFechaNacimiento($fechaNacimiento);


//Reasigno que fecha de nacimiento sea una fecha no un string
$fechaNacimiento = new DateTime($fechaNacimiento);
$gestorUsuarios = new GestorUsuarios();

//Comprobamos que no exista el nombre de usuario
if ($gestorUsuarios->comprobarUserNameExiste($usuario, $_SESSION['id'])) {
    header("Location: ../../vista/usuario/normal/actualizarUsuarioNormal.php?error=ElNombreDeUsuarioYaExiste");
    exit();
}

try {
    $usuario_bd = $gestorUsuarios->getUsuario($_SESSION['id']);
    $usuario_bd->setUsuario($usuario);
    $usuario_bd->setEmail($email);
    $usuario_bd->setNombre($nombre);
    $usuario_bd->setApellido1($apellido1);
    $usuario_bd->setApellido2($apellido2);
    $usuario_bd->setDireccion($direccion);
    $usuario_bd->setLocalidad($localidad);
    $usuario_bd->setProvincia($provincia);
    $usuario_bd->setTelefono($telefono);
    $usuario_bd->setFechaNacimiento($fechaNacimiento);
    $usuario_bd->setRol($rol);
    $usuario_bd->setActivo($activo);

    //Valido que el nombre de usuario sea correcto
    if (!Utilidades::validarNombreUsuario($usuario)) {
        header("Location:  ../../vista/usuario/normal/actualizarUsuarioNormal.php?error=UsuarioInvalido");
        exit();
    }
    //Valido que el nombre sea correcto
    if (!Utilidades::validarNombre($nombre)) {
        header("Location:  ../../vista/usuario/normal/actualizarUsuarioNormal.php?error=NombreInvalido");
        exit();
    }

    $gestorUsuarios->editarUsuario($usuario_bd);

    if ($_SESSION['rol'] == 'usuario') {
        header("Location: ../../vista/usuario/normal/zonaUsuarioNormal.php?mensaje=UsuarioActualizado");
        exit();
    } else if ($_SESSION['rol'] == 'admin' || $_SESSION['rol'] == 'editor') {
        header("Location: ../../vista/backoffice/perfil/zonaAdmin.php?mensaje=UsuarioActualizado");
        exit();
    }

} catch (Exception $e) {
    if ($_SESSION['rol'] == 'usuario') {
        header("Location: ../../vista/usuario/normal/actualizarUsuarioNormal.php?error=" . $e->getMessage());
        exit();
    } else if ($_SESSION['rol'] == 'admin' || $_SESSION['rol'] == 'editor') {
        header("Location: ../../backoffice/perfil/actualizarUsuarioNormal.php?error=" . $e->getMessage());
        exit();
    }
}



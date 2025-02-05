<?php
include_once __DIR__.'/../../gestores/GestorUsuarios.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}

//Defino las variables que llegan por post y compruebo que no estén vacías
$usuario = $_POST["usuario"] ?? null;
$email = $_POST["email"] ?? null;
$nombre = $_POST["nombre"] ?? null;
$apellido1 = $_POST["apellido1"] ?? null;
$contrasenya = $_POST["contrasenya"] ?? null;
$validarContrasenya = $_POST["validarContrasenya"] ?? null;
$rol = "usuario";
$activo = 1;

//Compruebo que los datos no estén vacíos
if ($usuario == null || $email == null || $nombre == null || $apellido1 == null ||  $contrasenya == null || $validarContrasenya == null) {
    header("Location: ../../vista/usuario/registro.php?error=CamposVacios");
    exit();
}


$gestorUsuarios = new GestorUsuarios();

if($gestorUsuarios->comprobarUsuarioExiste($usuario, $email)){
    header("Location: ../../vista/usuario/registro.php?error=UsuarioYaExiste");
    exit();
}


//Valido que la contrasenya sea igual
if($contrasenya != $validarContrasenya){
    header("Location: ../../vista/usuario/registro.php?error=ContrasenyasNoCoinciden");
    exit();
}

try {
    $usuario = new Usuario(0, $usuario, $email, $nombre, $apellido1, $apellido ="", $direccion ="", $localidad = "", $provincia = "", $telefono = "", $contrasenya, null, $rol, $activo);
    $gestorUsuarios->nuevoUsuario($usuario);
}catch (Exception $e){
    header("Location: ../../vista/usuario/registro.php?error=" . $e->getMessage());
    exit();
}

header("Location: ../../vista/login/login.php?mensaje=UsuarioCreado");
exit();

//TODO: añadir que cuando se va a registrar un usuario dormido, pase a estar activo
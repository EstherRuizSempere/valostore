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
$apellido2 = $_POST["apellido2"] ?? null;
$direccion = $_POST["direccion"] ?? null;
$localidad = $_POST["localidad"] ?? null;
$provincia = $_POST["provincia"] ?? null;
$telefono = $_POST["telefono"] ?? null;
$contrasenya = $_POST["contrasenya"] ?? null;
$validarContrasenya = $_POST["validarContrasenya"] ?? null;
$fechaNacimiento = $_POST["fechaNacimiento"] ?? null;
$rol = "usuario";
$activo = 1;

//Compruebo que los datos no estén vacíos
if ($usuario == null || $email == null || $nombre == null || $apellido1 == null || $apellido2 == null || $direccion == null || $localidad == null || $provincia == null || $telefono == null || $contrasenya == null || $validarContrasenya == null || $fechaNacimiento == null) {
    header("Location: ../../vista/usuario/registro.php?error=CamposVacios");
    exit();
}

//Reasigno que fecha de nacimiento sea una fecha no un string
$fechaNacimiento = new DateTime($fechaNacimiento);
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
    $usuario = new Usuario(0, $usuario, $email, $nombre, $apellido1, $apellido2, $direccion, $localidad, $provincia, $telefono, $contrasenya, $fechaNacimiento, $rol, $activo);
    $gestorUsuarios->nuevoUsuario($usuario);
}catch (Exception $e){
    header("Location: ../../vista/usuario/registro.php?error=" . $e->getMessage());
    exit();
}
<?php
include_once __DIR__ . '/../../../gestores/GestorUsuarios.php';
include_once __DIR__ . '/../../../config/utilidades.php';

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
$rol = $_POST["rol"];
$activo = 1;

//Compruebo que los datos no estén vacíos
if ($usuario == null || $email == null || $nombre == null || $apellido1 == null ||  $contrasenya == null || $validarContrasenya == null ||  $rol == null) {
header("Location: /vista/backoffice/usuario/crearUsuario.php?error=CamposVacios");
exit();
}


$gestorUsuarios = new GestorUsuarios();

if($gestorUsuarios->comprobarUsuarioExiste($usuario, $email)){
header("Location:  /vista/backoffice/usuario/crearUsuario.php?error=UsuarioYaExiste");
exit();
}

//Valido que la contrasenya sea igual
if($contrasenya != $validarContrasenya){
header("Location:  /vista/backoffice/usuario/crearUsuario.php?error=ContrasenyasNoCoinciden");
exit();
}

//Valido que la contrasenya tenga al menos 4 caracteres
if(!Utilidades::validarContrasenya($contrasenya)){
header("Location:  /vista/backoffice/usuario/crearUsuario.php?error=ContrasenyaInvalida");
exit();
}
//Valido que el nombre de usuario sea correcto
if(!Utilidades::validarNombreUsuario($usuario)){
header("Location:  /vista/backoffice/usuario/crearUsuario.php?error=UsuarioInvalido");
exit();
}
//Valido que el nombre sea correcto
if(!Utilidades::validarNombre($nombre)){
header("Location:  /vista/backoffice/usuario/crearUsuario.php?error=NombreInvalido");
exit();
}

try {
$usuario = new Usuario(0, $usuario, $email, $nombre, $apellido1, $apellido ="", $direccion ="", $localidad = "", $provincia = "", $telefono = "", $contrasenya, null, $rol, $activo);
$gestorUsuarios->nuevoUsuario($usuario);
}catch (Exception $e){
header("Location:  /vista/backoffice/usuario/crearUsuario.php?error=" . $e->getMessage());
exit();
}

header("Location:  /vista/backoffice/usuario/tablaUsuarios.php?mensaje=UsuarioCreado");
exit();

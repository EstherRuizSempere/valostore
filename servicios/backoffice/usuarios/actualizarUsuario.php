<?php
require_once __DIR__ . '/../../../config/seguridad.php';
require_once __DIR__ . '/../../../gestores/GestorUsuarios.php';

//Verifico que el usuario esté logueado y tenga permisos de administrador
Seguridad::usuarioPermisos(['admin']);


//Si no es post, return
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    return;
}

//Obtengo los datos del formulario:
$id = $_POST['id'] ?? null;
$usuario = $_POST['usuario'] ?? null;
$email = $_POST['email'] ?? null;
$nombre = $_POST['nombre'] ?? null;
$apellido1 = $_POST['apellido1'] ?? null;
$rol = $_POST['rol'] ?? null;
$activo = $_POST['activo'] ?? null;

//Compruebo que los datos no estén vacíos
if ($id == null || $usuario == null || $email == null || $nombre == null || $apellido1 == null || $rol == null || $activo == null) {
    header('Location: ../../../vista/backoffice/usuario/actualizarUsuario.php?error=CamposVacios');
    exit();
}

//Compruebo que no exista el nombre de usuario
$gestorUsuarios = new GestorUsuarios();
if ($gestorUsuarios->comprobarUserNameExiste($usuario, $id)) {
    header('Location: ../../../vista/backoffice/usuario/actualizarUsuario.php?error=ElNombreDeUsuarioYaExiste');
    exit();
}

//Compruebo que no exista el email de usuario
if ($gestorUsuarios->comprobarEmailExiste($email, $id)) {
    header('Location: ../../../vista/backoffice/usuario/actualizarUsuario.php?error=ElEmailYaExiste');
    exit();
}
//Valido que el nombre de usuario sea correcto
if (!Utilidades::validarNombreUsuario($usuario)) {
    header("Location:  ../../../vista/backoffice/usuario/actualizarUsuario.php?error=UsuarioInvalido");
    exit();
}
//Valido que el nombre sea correcto
if (!Utilidades::validarNombre($nombre)) {
    header("Location:  ../../../vista/backoffice/usuario/actualizarUsuario.php?error=NombreInvalido");
    exit();
}

try {
    $usuario_bd = $gestorUsuarios->getUsuario($id);
    $usuario_bd->setUsuario($usuario);
    $usuario_bd->setEmail($email);
    $usuario_bd->setNombre($nombre);
    $usuario_bd->setApellido1($apellido1);
    $usuario_bd->setRol($rol);
    $usuario_bd->setActivo($activo);

    $gestorUsuarios->editarUsuario($usuario_bd);

    header("Location: ../../../vista/backoffice/usuario/tablaUsuarios.php?mensaje=UsuarioActualizado");
    exit();
} catch (Exception $e) {
    header("Location: ../../../vista/backoffice/usuario/actualizarUsuario.php?error=ErrorActualizarUsuario");
    exit();
}
<?php
require_once __DIR__ . '/../../../gestores/GestorUsuarios.php';
require_once __DIR__ . '/../../../config/seguridad.php';
require_once __DIR__ . '/../../../config/utilidades.php';


Seguridad::usuarioPermisos(['admin']);

//Compruebo la sesión activa, que sea admin
if (!isset($_SESSION['id'])) {
    header('Location: /vista/login/login.php?error=NoHasIniciadoSesion');
    exit();
}


try{
    //Si no es post, no hago nada
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception('Método de solicitud no válido');

    }

    // Verifico ID de usuario
    if (!isset($_POST['usuario_id']) || empty($_POST['usuario_id'])) {
        throw new Exception('No se ha recibido el ID del usuario a desactivar');
    }

    //Capturo el id del usuario
    $usuario_id = $_POST['usuario_id'];


    // Verifico que no intenta desactivarse a sí mismo
    if ($usuario_id == $_SESSION['id']) {
        throw new Exception('No puedes desactivar tu propia cuenta');
    }

    // Desactivar usuario
    $gestorUsuarios = new GestorUsuarios();
    $gestorUsuarios->desactivarUsuario($usuario_id);

    // Redireccionar con mensaje de éxito
    header('Location: ./../../../vista/backoffice/usuario/tablaUsuarios.php?mensaje=' . urlencode('Usuario desactivado correctamente'));
    exit();

} catch (Throwable $e) {
    header('Location: ./../../../vista/backoffice/usuario/borrarUsuario.php?id=' . $usuario_id . '&error=' . urlencode($e->getMessage()));
    exit();
}


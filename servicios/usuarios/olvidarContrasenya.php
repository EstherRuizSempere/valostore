<?php
require_once __DIR__ . '/../../gestores/GestorUsuarios.php';
require_once __DIR__ . '/../../config/seguridad.php';

try {
    //Compruebo que los datos se envíen y no estén vacíos,
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $contrasenya = $_POST['contrasenya'];


        $gestorUsuarios = new GestorUsuarios();
        $usuario_bd = $gestorUsuarios->listarUnUsuario($email);

        if ($usuario_bd != null) {
            $gestorUsuarios->editarContrasenya($usuario_bd->getId(), $contrasenya);
            // Redirigir a la página de restablecimiento de contraseña con el email como parámetro
            header("Location: ../../vista/usuario/olvidarContrasenya.php?email=$email");
            exit();
        } else {
            //Redirigir a la página de olvidar contraseña con un mensaje de error
            header("Location: ../../vista/usuario/olvidarContrasenya.php?error=UsuarioNoValido");
            exit();
        }
    } else {

        // Redirigir a la página de olvidar contraseña con un mensaje de error si los datos no están completos
        header("Location: ../../vista/usuario/olvidarContrasenya.php?error=DatosIncompletos");
        exit();
    }
} catch (Throwable $e) {
    header("Location: ../../vista/usuario/olvidarContrasenya.php?error=" . $e->getMessage());
}
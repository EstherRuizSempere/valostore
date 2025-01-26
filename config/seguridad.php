<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class Seguridad{
    public static function usuarioPermisos(array $rolesPermitidos){
        //Si no existe la sesión voy al login
        if(!isset($_SESSION['id'])){
            header("Location: /vista/login/login.php");
            exit();
        }

        //Si por otro lado, existe la sesión:

        $rolUsuario = $_SESSION['rol'];
        if (!in_array($rolUsuario, $rolesPermitidos)){
            header("Location: /vista/producto/catalogo.php");
            exit();
        }
    }
}
<?php
//TODO: Implementar la funcionalidad de cerrar sesión arreglando el nav
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION = array();
session_destroy();
header("Location: ../../vista/login/login.php?mensaje=SesionCerrada");
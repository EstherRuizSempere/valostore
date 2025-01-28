<?php
require_once __DIR__ . '/../../config/seguridad.php';
require_once __DIR__ . '/../../gestores/GestorUsuarios.php';

//Verifico permisos
Seguridad::usuarioPermisos(['admin'],);

//Si no es un post, no hago nada
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}

//Defino las variables que llegan por post y compruebo que no estén vacías
$usuario = $_POST["usuario"] ?? null;
$email = $_POST["email"] ?? null;
$nombre = $_POST["nombre"] ?? null;
$apellido1 = $_POST["apellido1"] ?? null;

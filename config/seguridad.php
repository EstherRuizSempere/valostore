<?php
session_start();
require_once 'ConexionBD.php';
require_once '../app/entidades/GestorUsuarios.php';
require_once '../app/entidades/UsuarioViejo.php';

//Verifico que los datos del formulario se han enviado:
if(isset($_POST['email']) && isset($_POST['password'])){
    $email = $_POST['email'];
    $password = $_POST['password'];


    try {

        $conexion = new conexionBD();
        $pdo = $conexion->conectar();
        $gestorUsuarios = new GestorUsuarios($pdo);

        //Verifico el login:
        $usuario = $gestorUsuarios ->verificarLogin($email);

        if($usuario != false && password_verify($password, $usuario->getPassword())){
            $_SESSION['email'] = $usuario->getEmail();
            $_SESSION['nombre'] = $usuario->getNombre();
            $_SESSION['rol'] = $usuario->getRol();
            //Dependiendo del rol lo redirigimos a un lugar, u otro:

            if ($usuario->getRol() == 'admin') {
                header('Location: ../vista/usuario/admin-editor/zonaUsuarioAdmin.php');
            }else if($usuario->getRol() == 'user'){
                header('Location: ../vista/usuario/normal/zonaUsuarioNormal.php');
            }else{
                header('Location: ../vista/usuario/admin-editor/zonaUsuarioEditor.php');
            }
            exit();
        }else{
            header("Location: ../public/login.php?error=NoHasPodidoIniciarSesion");
        }
    }catch (Exception $error){
        header("Location: ../public/login.php?error=".$error->getMessage());
    }

}
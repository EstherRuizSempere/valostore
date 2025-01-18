<?php


class Utilidades
{
    //Función para coger una contraseña texto plano y convertirla en hash, para guardarla en la base de datos en vez de la normal
    public static function hashContrasenya($contrasenya)
    {
        return password_hash($contrasenya, PASSWORD_DEFAULT);
    }

    //Función para verificar que la contraseña introducida por el usuario es la misma que la guardada en la base de datos
    public static function verificarContrasenya($contrasenya, $hash)
    {
        return password_verify($contrasenya, $hash);
    }
   //Requisito para crear la contraseña
    public static function validarContrasenya($contrasenya)
    {
        return strlen($contrasenya) >= 4;
    }

    //Comprobar teléfono
    public static function validarTelefono($telefono)
    {
        // Elimina espacios, guiones y parentesis
        $telefono = str_replace([' ', '-', '(', ')'], '', $telefono);

        // Verifica que el teléfono tenga  9 dígitos y que sean todos números
        if (preg_match('/^[0-9]{9}$/', $telefono)) {
            return true;
        } else {
            throw new Exception("El número de teléfono no es válido");
        }
    }



    public static function validarEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            throw new Exception("El email no es válido");
        }
    }
}


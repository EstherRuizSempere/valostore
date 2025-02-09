<?php
//TODO: -Función para comprobar la fecha de nacimiento

class Utilidades
{
    //Función para coger una contraseña texto plano y convertirla en hash, para guardarla en la base de datos en vez de la normal
    public static function hashContrasenya($contrasenya)
    {
        return hash('sha512', $contrasenya);
    }

    //Función para verificar que la contraseña introducida por el usuario es la misma que la guardada en la base de datos
    public static function verificarContrasenya($contrasenya, $hash)
    {
        return Utilidades::hashContrasenya($contrasenya) == $hash;
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

        // Verifica que el teléfono tenga 9 dígitos y que sean todos números
        if (preg_match('/^[0-9]{9}$/', $telefono)) {
            return true;
        } else {
            return false;
        }
    }

    //Validar nombre del usuario
    public static function validarNombreUsuario($usuario)
    {
        if (preg_match('/^[a-zA-Z0-9_]+$/', $usuario)) {
            return true;
        } else {
            return false;
        }
    }

    public static function validarNombre($nombre)
    {
        if (preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $nombre)) {
            return true;
        } else {
            return false;
        }

    }

    public static function validarFechaNacimiento($fechaNacimiento)
    {
        $fechaActual = new DateTime();
        $fechaNacimiento = DateTime::createFromFormat('Y-m-d', $fechaNacimiento);

        if (!$fechaNacimiento) {
            header("Location: ../../vista/usuario/normal/actualizarUsuarioNormal.php?error=FechaNacimientoInvalida");
            exit();
        }

        if ($fechaNacimiento > $fechaActual) {
            header("Location: ../../vista/usuario/normal/actualizarUsuarioNormal.php?error=FechaNacimientoInvalida");
            exit();
        }
    }

    //Comprobar imagenes:
    public static function subidaImagen($files, $directorio)
    {
        $imagen = $directorio . basename($files["name"]);
        $tipoImagen = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));


        //Verifico que el archivo es una imagen:
        $comprobacion = getimagesize($files["tmp_name"]);
        if ($comprobacion === false) {
            throw new Exception("El archivo no es una imagen");
        }

        //Verifico el tamaño del archivo
        if ($files["size"] > 500000) {
            throw new Exception("El archivo es demasiado grande");
        }

        //Verifico el tipo de archivo
        if ($tipoImagen != "jpg" && $tipoImagen != "png" && $tipoImagen != "jpeg") {
            throw new Exception("Solo se permiten archivos JPG, JPEG, PNG y GIF");
        }

        //Cambiar nombre a la imagen:
        $imagen = uniqid() . "." . $tipoImagen;

        //Subir la imagen
        if (!move_uploaded_file($files["tmp_name"], $directorio . $imagen)) {
            throw new Exception("Error al subir la imagen");
        }

        //Devuelvo la ruta de la imagen
        return $imagen;
    }

    public static function validarEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            throw new Exception("El email no es válido");
        }
    }
}


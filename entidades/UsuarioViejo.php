<?php
require_once '../../config/ConexionBD.php';
require_once '../../config/utilidades.php';
require_once 'UsuarioViejo.php';
require_once '../servicios/UsuarioControladorViejo.php';

class GestorUsuarios
{
    private $pdo;

    public function __construct()
    {
        $conexion = new ConexionBD();
        $this->pdo = $conexion->conectar();
    }

    public function login()
    {

    }







    public function editarContrasenya($email, $contrasenyaHash)
    {
        $sql = "UPDATE usuarios SET contrasenya = :contrasenya WHERE email = :email";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':contrasenya', $contrasenyaHash);
            $statement->bindValue(':email', $email);

            if (!$statement->execute()) {
                throw new Exception("Error al editar la contraseña");
            }
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }

    public function borrarUsuario($email)
    {
        //Esto nos indica que el usuario psará a estar inactivo, es como decirle que activo es false
        $sql = "UPDATE usuarios SET activo = 0 WHERE email = :email";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':email', $email);

            if (!$statement->execute()) {
                throw new Exception ("Error al marcar al usuario en inactivo");
            }
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }

    public function reactivarUsuario($email)
    {
        $sql = "UPDATE usuarios SET activo = 1 WHERE email = :email";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':email', $email);

            if (!$statement->execute()) {
                throw new Exception("Error al reactivar al usuario");
            }
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }

    public function listarUnUsuario($email)
    {
        if ($email == null) {
            throw new Exception("El usuario debe existir");
        }

        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':email', "$email", PDO::PARAM_STR);

        if (!$statement->execute()) {
            throw new Exception("Error al listar al usuario");
        }

        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
        if (count($resultado) == 0) {
            throw new Exception("No se ha encontrado al usuario");
        }

        $usuario = $resultado[0];
        return new Usuario($usuario['dni'], $usuario['nombre'], $usuario['apellido1'], $usuario['apellido2'], $usuario['direccion'], $usuario['localidad'], $usuario['provincia'], $usuario['telefono'], $usuario['email'], $usuario['contrasenya'], $usuario['rol']);
    }

    public function listarTodosUsuarios($email)
    {
        if ($email == null) {
            $sql = "SELECT * FROM usuarios ORDER BY nombre";
            $statement = $this->pdo->prepare($sql);
        } else {
            $sql = "SELECT * FROM usuarios WHERE email LIKE :email ORDER BY email";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':email', "%$email%", PDO::PARAM_STR);
        }

        try {
            if (!$statement->execute()) {
                throw new Exception("Error al listar los usuarios");
            }
            $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);

            //Creo el array de usuarios:
            $usuarios = [];
            foreach ($resultado as $usuario) {
                $usuarios[] = new Usuario($usuario['dni'], $usuario['nombre'], $usuario['apellido1'], $usuario['apellido2'], $usuario['direccion'], $usuario['localidad'], $usuario['provincia'], $usuario['telefono'], $usuario['email'], $usuario['contrasenya'], $usuario['rol']);
            }
            return $usuarios;
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }

    public function rellenarDatosUsuario(string $sql, Usuario $usuario)
    {
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':dni', $usuario->getDni());
        $statement->bindValue(':nombre', $usuario->getNombre());
        $statement->bindValue(':apellido1', $usuario->getApellido1());
        $statement->bindValue(':apellido2', $usuario->getApellido2());
        $statement->bindValue(':direccion', $usuario->getDireccion());
        $statement->bindValue(':localidad', $usuario->getLocalidad());
        $statement->bindValue(':provincia', $usuario->getProvincia());
        $statement->bindValue(':telefono', $usuario->getTelefono());
        $statement->bindValue(':email', $usuario->getEmail());
        $statement->bindValue(':fechaNacimiento', $usuario->getFechaNacimiento());
        return $statement;
    }

}
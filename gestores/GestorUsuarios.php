<?php
include_once __DIR__ . '/../config/ConexionBD.php';
include_once __DIR__ . '/../config/utilidades.php';
include_once __DIR__ . '/../entidades/Usuario.php';

class GestorUsuarios
{
    private $pdo;

    public function __construct()
    {
        $conexion = new ConexionBD();
        $this->pdo = $conexion->conectar();
    }

    public function nuevoUsuario(Usuario $usuario)
    {
        $sql = "INSERT INTO usuarios (usuario, email, nombre, apellido1, apellido2, direccion, localidad, provincia, telefono, contrasenya, fechaNacimiento, rol, activo) VALUES (:usuario, :email, :nombre, :apellido1, :apellido2, :direccion, :localidad, :provincia, :telefono, :contrasenya, :fechaNacimiento, :rol, :activo)";

        try {

            //Valido la contraseña antes de procesarla:
            if (!Utilidades::validarContrasenya($usuario->getContrasenya())) {
                throw new Exception("La contraseña debe tener al menos 4 caracteres");
            }
            if(!Utilidades::validarEmail($usuario->getEmail())){
                throw new Exception("El email no es válido");
            }
            if (!Utilidades::validarTelefono($usuario->getTelefono())) {
                throw new Exception("El teléfono no es válido");
            }

            //Antes de almacenar la contraseña hay que "hasearla"
            $contrasenyaHash = Utilidades::hashContrasenya($usuario->getContrasenya());

            //Preparamos la consulta
            $statement = $this->rellenarDatosUsuario($sql, $usuario);
            $statement->bindValue(':contrasenya', $contrasenyaHash);
            $statement->bindValue(':rol', $usuario->getRol());

            if (!$statement->execute()) {
                throw new Exception("Error al insertar al usuario");
            }
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }


    public function comprobarUsuarioExiste(string $usuario, string $email)
    {
        $sql = "SELECT id FROM usuarios WHERE usuario = :usuario OR email = :email";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':usuario', $usuario);
        $statement->bindValue(':email', $email);
        $statement->execute();

        if ($statement->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function rellenarDatosUsuario(string $sql, Usuario $usuario)
    {
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':usuario', $usuario->getUsuario());
        $statement->bindValue(':email', $usuario->getEmail());
        $statement->bindValue(':nombre', $usuario->getNombre());
        $statement->bindValue(':apellido1', $usuario->getApellido1());
        $statement->bindValue(':apellido2', $usuario->getApellido2());
        $statement->bindValue(':direccion', $usuario->getDireccion());
        $statement->bindValue(':localidad', $usuario->getLocalidad());
        $statement->bindValue(':provincia', $usuario->getProvincia());
        $statement->bindValue(':telefono', $usuario->getTelefono());
        $statement->bindValue(':fechaNacimiento', $usuario->getFechaNacimiento()->format('Y-m-d'));
        $statement->bindValue(':activo', $usuario->getActivo());
        return $statement;
    }
}
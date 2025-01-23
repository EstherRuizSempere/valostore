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
            if (!Utilidades::validarEmail($usuario->getEmail())) {
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

    public function editarUsuario(Usuario $usuario)
    {
        //Preparo la consulta
        $sql = "UPDATE usuarios SET usuario = :usuario, email = :email, nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, direccion = :direccion, localidad = :localidad, provincia = :provincia, telefono = :telefono, fechaNacimiento = :fechaNacimiento, activo = :activo WHERE id = :id";
        try {
            $statement = $this->rellenarDatosUsuario($sql, $usuario);
            $statement->bindValue(':id', $usuario->getId());

            //Si no se ejecuta, da fallo:
            if (!$statement->execute()) {
                throw new Exception("Error al editar al usuario");
            }
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }
    public function editarContrasenya($id, $contrasenya){
        //Preparo la consulta
        $sql = "UPDATE usuarios SET contrasenya = :contrasenya WHERE id = :id";

        try {
            $statement = $this->pdo->prepare($sql);
            $contrasenyaHash = Utilidades::hashContrasenya($contrasenya);
            $statement->bindValue(':contrasenya', $contrasenyaHash);
            $statement->bindValue(':id', $id);

            if (!$statement->execute()) {
                throw new Exception("Error al editar la contraseña");
            }
        }catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }

    public function getUsuario(int $id): Usuario
    {
        //Preparo la consulta
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);

        try {
            $statement->execute();
            $usuario_bd = $statement->fetch(PDO::FETCH_ASSOC);
            //Cambio el formato de fecha de nacimiento
            $fechaNacimiento = new DateTime($usuario_bd['fechaNacimiento']);

            $usuario = new Usuario($usuario_bd['id'], $usuario_bd['usuario'], $usuario_bd['email'], $usuario_bd['nombre'], $usuario_bd['apellido1'], $usuario_bd['apellido2'], $usuario_bd['direccion'], $usuario_bd['localidad'], $usuario_bd['provincia'], $usuario_bd['telefono'], $usuario_bd['contrasenya'], $fechaNacimiento, $usuario_bd['rol'], $usuario_bd['activo']);
            return $usuario;
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }


    public
    function verificarLogin($email, $contrasenya)
    {
        $email = strtolower($email);
        try {
            Utilidades::validarEmail($email);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return null;
        }

        //Consulto los datos del usuario
        $statement = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email AND contrasenya = :contrasenya AND activo = 1");
        $statement->bindParam(':email', $email);
        $contrasenyahash = Utilidades::hashContrasenya($contrasenya);
        $statement->bindParam(':contrasenya', $contrasenyahash);
        $statement->execute();

        //Verifico que el usuario existe
        $usuario_bd = $statement->fetch(PDO::FETCH_ASSOC);
        $fechaNacimiento = new DateTime($usuario_bd['fechaNacimiento']);


        if ($usuario_bd) {
            //Si el usuario existe creo la instancia del objeto con sus datos:
            $usuario = new Usuario($usuario_bd['id'], $usuario_bd['usuario'], $usuario_bd['email'], $usuario_bd['nombre'], $usuario_bd['apellido1'], $usuario_bd['apellido2'], $usuario_bd['direccion'], $usuario_bd['localidad'], $usuario_bd['provincia'], $usuario_bd['telefono'], $usuario_bd['contrasenya'], $fechaNacimiento, $usuario_bd['rol'], $usuario_bd['activo']);
            return $usuario;
        }
        return null; //En caso de fallo
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

    public function comprobarUserNameExiste(string $usuario, int $id)
    {
        $sql = "SELECT id FROM usuarios WHERE usuario = :usuario AND id != :id";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':usuario', $usuario);
        $statement->bindValue(':id', $id);
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
        $statement->bindValue(':usuario', strtolower($usuario->getUsuario()));
        $statement->bindValue(':email', strtolower($usuario->getEmail()));
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
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
        $sql = "UPDATE usuarios SET usuario = :usuario, email = :email, nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, direccion = :direccion, localidad = :localidad, provincia = :provincia, telefono = :telefono, fechaNacimiento = :fechaNacimiento, rol = :rol, activo = :activo WHERE id = :id";
        try {
            //Llamo a la función rellenarDatosUsuario para rellenar los datos del usuario
            $statement = $this->rellenarDatosUsuario($sql, $usuario);
            $statement->bindValue(':id', $usuario->getId());
            $statement->bindValue(':rol', $usuario->getRol());

            //Actualizo las variables de session coincidiendo con las de loguin
            if ($_SESSION['id'] == $usuario->getId()) {
                $_SESSION['nombre'] = $usuario->getNombre();
                $_SESSION['usuario'] = $usuario->getUsuario();
                $_SESSION['email'] = $usuario->getEmail();
                $_SESSION['rol'] = $usuario->getRol();
            }

            //Si no se ejecuta, da fallo:
            if (!$statement->execute()) {
                throw new Exception("Error al editar al usuario");
            }
        } catch (Throwable $error) {
            throw new Exception($error->getMessage());
        }
    }

    public function desactivarUsuario($id)
    {
        // Verificar que el usuario existe y está activo
        $sql = "SELECT activo FROM usuarios WHERE id = :id";
        // Preparar y ejecutar la consulta de selección
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Comprobar si el usuario existe
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$usuario) {
            throw new Exception("El usuario no existe");
        }

        // Comprobar si el usuario está activo
        if ($usuario['activo'] == 0) {
            throw new Exception("El usuario ya está desactivado");
        }

        // Desactivar el usuario en la base de datos
        $sql = "UPDATE usuarios SET activo = 0 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        //Manejar errores
        if (!$stmt->execute()) {
            throw new Exception("Error al desactivar el usuario");
        }

        // Comprobar si se ha desactivado el usuario
        if ($stmt->rowCount() === 0) {
            throw new Exception("No se pudo desactivar el usuario");
        }

    }

    public function editarContrasenya($id, $contrasenya)
    {
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
        } catch (Throwable $error) {
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



    public function verificarLogin($email, $contrasenya)
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

    public function listarUnUsuario($email)
    {
        if (empty(trim($email))) {
            throw new Exception("El email no puede estar vacío");
        }

        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':email', $email);

        if (!$statement->execute()) {
            throw new Exception("Error al listar el usuario");
        }

        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($resultado) == 0) {
            throw new Exception("No se ha encontrado el usuario");
        }

        $usuario = $resultado[0];
        return new Usuario(
            $usuario['id'],
            $usuario['usuario'],
            $usuario['email'],
            $usuario['nombre'],
            $usuario['apellido1'],
            $usuario['apellido2'],
            $usuario['direccion'],
            $usuario['localidad'],
            $usuario['provincia'],
            $usuario['telefono'],
            $usuario['contrasenya'],
            new DateTime($usuario['fechaNacimiento']),
            $usuario['rol'],
            $usuario['activo']
        );
    }

    public function listarUsuarios($email)
    {
        //Inicializo la consulta sql:
        $sql = "";

        if (empty($email)) {
            // Consulta sin filtro por email
            $sql = "SELECT * FROM usuarios ORDER BY nombre";
            $statement = $this->pdo->prepare($sql);
        } else {
            // Valido el parámetro $email que no tenga espacios y esté escrito
            $email = trim($email);
            // Consulta con filtro por email
            $sql = "SELECT * FROM usuarios WHERE email LIKE :email ORDER BY nombre";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':email', "%$email%", PDO::PARAM_STR);
        }

        try {
            // Ejecutar la consulta
            if (!$statement->execute()) {
                throw new Exception("Error al listar los usuarios");
            }

            // Obtengo los resultados
            $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Convierto los resultados en objetos Usuario
            $usuarios = [];
            foreach ($resultado as $usuario) {
                $usuarios[] = new Usuario(
                    $usuario['id'],
                    $usuario['usuario'],
                    $usuario['email'],
                    $usuario['nombre'],
                    $usuario['apellido1'],
                    $usuario['apellido2'],
                    $usuario['direccion'],
                    $usuario['localidad'],
                    $usuario['provincia'],
                    $usuario['telefono'],
                    $usuario['contrasenya'],
                    new DateTime($usuario['fechaNacimiento']),
                    $usuario['rol'],
                    $usuario['activo']
                );
            }

            return $usuarios;

        } catch (Exception $error) {
            // Lanza una excepción si ocurre un error
            throw new Exception("Error al procesar la consulta: " . $error->getMessage());
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

    public function comprobarEmailExiste(string $email, int $id)
    {
        $sql = "SELECT id FROM usuarios WHERE email = :email AND id != :id";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':email', $email);
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
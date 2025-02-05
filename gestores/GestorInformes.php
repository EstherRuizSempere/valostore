<?php
include_once __DIR__ . '/../config/ConexionBD.php';
include_once __DIR__ . '/../entidades/Categoria.php';
include_once __DIR__ . '/../entidades/Usuario.php';
include_once __DIR__ . '/../entidades/Producto.php';
include_once __DIR__ . '/../config/utilidades.php';

class   GestorInformes
{
    private $pdo;

    public function __construct()
    {
        $conexion = new ConexionBD();
        $this->pdo = $conexion->conectar();
    }

    public function getUsuariosDormidos()
    {
        // Consulta para obtener los usuarios que no están activos
        $sql = "SELECT * FROM usuarios WHERE activo = 0";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();

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

    public function getUsuariosDespiertos()
    {
        //Consulta para obtener a los usuarios activos
        $sql = "SELECT * FROM usuarios WHERE activo = 1";

        $statement = $this->pdo->prepare($sql);
        $statement->execute();
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
}
<?php
include_once __DIR__ . '/../config/ConexionBD.php';

class GestorUsuarioProducto {
    private $pdo;

    public function __construct()
    {
        $conexion = new ConexionBD();
        $this->pdo = $conexion->conectar();
    }

    public function nuevoUsuarioProducto(int $idUsuario, int $idProducto)
    {
        $sql = "INSERT INTO usuario_producto (idUsuario, idProducto) VALUES (:idUsuario, :idProducto)";
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':idUsuario', $idUsuario);
            $statement->bindValue(':idProducto', $idProducto);
            $statement->execute();
        } catch (PDOException $e) {
            echo "Error al insertar el usuario_producto: " . $e->getMessage();
            exit();
        }
    }

    //Función para devolver los personajes que no tengo
    public function productoNoEnPosesion(int $idUsuario, int $idProducto)
    {
        //Función que me lista los personajes que no tengo
        $sql = "SELECT p.* FROM productos p LEFT JOIN usuario_producto up ON p.id = up.idProducto AND up.idUsuario = :idUsuario WHERE up.idProducto IS NULL;";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':idUsuario', $idUsuario);
            $statement->execute();

            $productos_bd = $statement->fetchAll(PDO::FETCH_ASSOC);

            $productos = [];
            $gestorCategoria = new GestorCategoria();

            foreach ($productos_bd as $producto_bd) {
                $productos[] = new Producto(
                    $producto_bd['id'],
                    $producto_bd['nombre'],
                    $producto_bd['descripcion'],
                    $producto_bd['categoria_id'],
                    $gestorCategoria->getCategoria($producto_bd['categoria_id'])->getNombre(),
                    $producto_bd['precio'],
                    $producto_bd['imagen'],
                    $producto_bd['activo']
                );
            }

            return $productos;
        } catch (PDOException $e) {
            echo "Error al obtener los productos no en posesión: " . $e->getMessage();
            exit();
        }
    }

    public function borrarUsuarioProducto(int $idUsuario, int $idProducto)
    {
        $sql = "DELETE FROM usuario_producto WHERE idUsuario = :idUsuario AND idProducto = :idProducto";
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':idUsuario', $idUsuario);
            $statement->bindValue(':idProducto', $idProducto);
            $statement->execute();
        } catch (PDOException $e) {
            echo "Error al borrar el usuario_producto: " . $e->getMessage();
            exit();
        }
    }
}

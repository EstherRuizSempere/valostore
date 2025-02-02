<?php
include_once __DIR__ . '/../config/ConexionBD.php';
include_once __DIR__ . '/../config/utilidades.php';
include_once __DIR__ . '/../entidades/LineaPedido.php';


class GestorLineaPedido{
    private $pdo;

    public function __construct()
    {
        $conexion = new ConexionBD();
        $this->pdo = $conexion->conectar();
    }

    public function crearLineaPedido ( LineaPedido $lineaPedido){
        $sql = "INSERT INTO linea_pedido (idPedido, idProducto, nombre, descripcion, precio, imagen) VALUES (:idPedido, :idProducto, :nombre, :descripcion, :precio, :imagen)";
        try {
            $statement = $this->rellenarDatosLineaPedido($sql, $lineaPedido);
            $statement->execute();
        } catch (PDOException $e) {
            echo "Error al insertar la linea de pedido: " . $e->getMessage();
            exit();
        }
    }

    public function getLineasDePedido(int $idPedido){
        $sql = "SELECT * FROM linea_pedido WHERE idPedido = :idPedido";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':idPedido', $idPedido);
        try {
            $statement->execute();
            $lineasPedido_bd = $statement->fetchAll(PDO::FETCH_ASSOC);
            $lineasPedido = [];
            foreach ($lineasPedido_bd as $lineaPedido_bd) {
                $lineasPedido[] = new LineaPedido($lineaPedido_bd['id'], $lineaPedido_bd['idPedido'], $lineaPedido_bd['idProducto'], $lineaPedido_bd['nombre'], $lineaPedido_bd['descripcion'], $lineaPedido_bd['precio'], $lineaPedido_bd['imagen']);
            }
            return $lineasPedido;
        } catch (PDOException $e) {
            echo "Error al obtener las lineas de pedido: " . $e->getMessage();
            exit();
        }
    }



    public function rellenarDatosLineaPedido($sql, LineaPedido $lineaPedido){
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':idPedido', $lineaPedido->getIdPedido());
        $statement->bindValue(':idProducto', $lineaPedido->getIdProducto());
        $statement->bindValue(':nombre', $lineaPedido->getNombre());
        $statement->bindValue(':descripcion', $lineaPedido->getDescripcion());
        $statement->bindValue(':precio', $lineaPedido->getPrecio());
        $statement->bindValue(':imagen', $lineaPedido->getImagen());
        return $statement;
    }
}
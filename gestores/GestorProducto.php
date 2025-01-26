<?php
include_once __DIR__ . '/../config/ConexionBD.php';
include_once __DIR__ . '/../config/utilidades.php';
include_once __DIR__ . '/../entidades/Producto.php';

class GestorProducto{

    private $pdo;

    public function __construct()
    {
        $conexion = new ConexionBD();
        $this->pdo = $conexion->conectar();
    }

    public function nuevoProducto(Producto $producto) {

        $sql = "INSERT INTO productos (nombre, descripcion, categoria_id, precio, imagen, activo) VALUES (:nombre, :descripcion, :categoria_id, :precio, :imagen, :activo)";

        try {
            $statement = $this->rellenarDatosProducto($sql, $producto);
            $statement->execute();
        } catch (PDOException $e) {
            echo "Error al insertar el producto: " . $e->getMessage();
            exit();
        }
    }

    public function listarProductos($nombre = null, $orden = "ASC") {

        if($nombre){
            $sql = "SELECT * FROM productos WHERE nombre LIKE :nombre ORDER BY nombre :orden";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':orden', $orden);
        } else {
            $sql = "SELECT * FROM productos ORDER BY nombre $orden";
            $statement = $this->pdo->prepare($sql);
        }

        try {
            $statement->execute();
            $productos_bd = $statement->fetchAll(PDO::FETCH_ASSOC);

            $productos = [];

            //TODO: Rellenar categoría

            foreach ($productos_bd as $producto_bd) {
                $producto = new Producto($producto_bd['id'], $producto_bd['nombre'], $producto_bd['descripcion'], $producto_bd['categoria_id'], "", $producto_bd['precio'], $producto_bd['imagen'], $producto_bd['activo']);
                $productos[] = $producto;
            }

            return $productos;

        } catch (PDOException $e) {
            echo "Error al listar los productos: " . $e->getMessage();
            exit();
        }
    }

    public function getProducto(int $id): Producto {
        //Preparo la consulta
        $sql = "SELECT * FROM productos WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);

        try {
            $statement->execute();
            $producto_bd = $statement->fetch(PDO::FETCH_ASSOC);

            return new Producto($producto_bd['id'], $producto_bd['nombre'], $producto_bd['descripcion'], $producto_bd['categoria_id'], "", $producto_bd['precio'], $producto_bd['imagen'], $producto_bd['activo']);
        } catch (PDOException $e) {
            echo "Error al obtener el producto: " . $e->getMessage();
            exit();
        }
    }

    private function rellenarDatosProducto($sql, Producto $producto) {

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':nombre', strtolower($producto->getNombre()));
        $statement->bindValue(':descripcion', strtolower($producto->getDescripcion()));
        $statement->bindValue(':categoria_id', $producto->getCategoriaId());
        $statement->bindValue(':precio', $producto->getPrecio());
        $statement->bindValue(':imagen', $producto->getImagen());
        $statement->bindValue(':activo', $producto->getActivo());

        return $statement;

    }

}
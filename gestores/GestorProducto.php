<?php
include_once __DIR__ . '/../config/ConexionBD.php';
include_once __DIR__ . '/../config/utilidades.php';
include_once __DIR__ . '/../entidades/Producto.php';

class GestorProducto
{

    private $pdo;

    public function __construct()
    {
        $conexion = new ConexionBD();
        $this->pdo = $conexion->conectar();
    }

    //Función para comprobar que el producto no se repita, aunque esté puesto en la base de datos:
    public function comprobarArticulo($id)
    {
        try {
            $sql = "SELECT * FROM productos WHERE id = :id";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':id', $id);
            $statement->execute();

            //Verificamos que el articulo exista:
            $producto_bd = $statement->fetch(PDO::FETCH_ASSOC);

            if ($producto_bd) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al comprobar si existe el producto: " . $e->getMessage();
            exit();
        }
    }

    public function nuevoProducto(Producto $producto)
    {

        $sql = "INSERT INTO productos (nombre, descripcion, categoria_id, precio, imagen, activo) VALUES (:nombre, :descripcion, :categoria_id, :precio, :imagen, :activo)";

        try {
            $statement = $this->rellenarDatosProducto($sql, $producto);
            $statement->execute();
        } catch (PDOException $e) {
            echo "Error al insertar el producto: " . $e->getMessage();
            exit();
        }
    }

    public function editarProducto(Producto $producto)
    {
        //Preparo la consulta
        $sql = "UPDATE productos SET nombre = :nombre, descripcion = :descripcion, categoria_id = :categoria_id, precio = :precio, imagen = :imagen, activo = :activo WHERE id = :id";
        try {
            $statement = $this->rellenarDatosProducto($sql, $producto);
            $statement->bindValue(':id', $producto->getId());

            //Si no se ha ejecutado correctamente la consulta, lanzo una excepción
            if (!$statement->execute()) {
                throw new Exception("Error al editar el producto");
            }
        } catch (Exception $e) {
            throw new Exception("Error al editar el producto: " . $e->getMessage());
        }
    }

    public function desactivarProducto($id)
    {

        $sql = "UPDATE productos SET activo = 0 WHERE id = :id";

        //Manejo la consulta

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':id', $id);

            //Si ha ocurrido un error en la ejecución de la consulta, lanzo una excepción
            if (!$statement->execute()) {
                throw new Exception("Error al desactivar el producto");
            }
        } catch (Exception $e) {
            throw new Exception("Error al desactivar el producto: " . $e->getMessage());
        }
    }

    public function listarProductosPrecio($precio = null, $orden = "ASC")
    {
        // Validar que el orden sea válido
        $orden = strtoupper($orden);
        if ($orden !== "ASC" && $orden !== "DESC") {
            throw new Exception("El orden especificado no es válido. Use 'ASC' o 'DESC'.");
        }

        try {
            $sql = "SELECT * FROM productos ORDER BY precio $orden";
            $statement = $this->pdo->prepare($sql);
            $statement->execute();

            $productos_bd = $statement->fetchAll(PDO::FETCH_ASSOC);

            $productos = [];
            foreach ($productos_bd as $producto_bd) {
                $productos[] = new Producto(
                    $producto_bd['id'],
                    $producto_bd['nombre'],
                    $producto_bd['descripcion'],
                    $producto_bd['categoria_id'],
                    "",
                    $producto_bd['precio'],
                    $producto_bd['imagen'],
                    $producto_bd['activo']
                );
            }

            return $productos;
        } catch (PDOException $e) {
            throw new Exception("Error al listar los productos por precio: " . $e->getMessage());
        }
    }

    public function listarProductos($nombre = null, $orden = "ASC")
    {
        //Válido que el orden sea válido
        $orden = strtoupper($orden);
        if ($orden !== "ASC" && $orden !== "DESC") {
            throw new Exception("El orden especificado no es válido. Use 'ASC' o 'DESC'.");
        }

        try {
            if ($nombre !== null) {
                $sql = "SELECT * FROM productos WHERE nombre LIKE :nombre ORDER BY nombre $orden";
                $statement = $this->pdo->prepare($sql);
                $statement->bindValue(':nombre', '%' . $nombre . '%', PDO::PARAM_STR);
            } else {
                $sql = "SELECT * FROM productos ORDER BY nombre $orden";
                $statement = $this->pdo->prepare($sql);
            }

            // Ejecuto la consulta
            $statement->execute();

            // Obtener los resultados como un array asociativo
            $productos_bd = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Convierto los resultados en objetos de tipo Producto
            $productos = [];
            foreach ($productos_bd as $producto_bd) {
                $productos[] = new Producto(
                    $producto_bd['id'],
                    $producto_bd['nombre'],
                    $producto_bd['descripcion'],
                    $producto_bd['categoria_id'],
                    "",
                    $producto_bd['precio'],
                    $producto_bd['imagen'],
                    $producto_bd['activo']
                );
            }

            // Devuelvo la lista de productos
            return $productos;
        } catch (PDOException $e) {
            throw new Exception("Error al listar los productos: " . $e->getMessage());
        }
    }

    public function listarProductoUnico($id)
    {
        //valido que el id sea correcto, que no esté vacío, que sea un número y además mayor que 0
        if (empty($id) || !is_numeric($id) || $id <= 0) {
            throw new Exception("El código no puede estar vacío");
        }

        try {
            //Preparo la consulta para obtener el producto único
            $sql = "SELECT * FROM productos WHERE id = :id LIMIT 1";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);

            //Ejecuto la consulta y valoro si hay errores
            if (!$statement->execute()) {
                throw new Exception("Error al obtener el producto");
            }

            //Obtengo el resultado haciendo fetch ya que es un único resultado
            $producto_bd = $statement->fetch(PDO::FETCH_ASSOC);

            //Verifico que he encontrado el producto
            if (!$producto_bd) {
                throw new Exception("No se encontró el producto");
            }

            //Devuelvo el producto capturado en el array:
            return new Producto($producto_bd['id'], $producto_bd['nombre'], $producto_bd['descripcion'], $producto_bd['categoria_id'], "", $producto_bd['precio'], $producto_bd['imagen'], $producto_bd['activo']);
        } catch (Exception $e) {
            throw new Exception("Error al obtener el producto: " . $e->getMessage());
        }
    }

    public function listarProductosCategoria($categoria_id = null, $orden = "ASC")
    {
        //Valido que orden sea ascendente o desc
        $orden = strtoupper($orden);
        if ($orden !== "ASC" && $orden !== "DESC") {
            throw new Exception("El orden especificado no es válido. Use 'ASC' o 'DESC'.");
        }

        try {
            //Si especifico una categoría filtro por categoría y ordeno por el nombre
            if ($categoria_id !== null) {
                $sql = "SELECT * FROM productos WHERE categoria_id = :categoria_id ORDER BY nombre $orden";
                $statement = $this->pdo->prepare($sql);
                $statement->bindValue(':categoria_id', $categoria_id, PDO::PARAM_INT);
            } else {
                //Sino, se especifica sólo ordeno por el nombre
                $sql = "SELECT * FROM productos ORDER BY nombre $orden";
                $statement = $this->pdo->prepare($sql);
            }

            //Ejecuto la consulta
            $statement->execute();
            //Obtengo los datos como un array asociativo
            $productos_bd = $statement->fetchAll(PDO::FETCH_ASSOC);

            //Convierto los resultados en objetos de tipo Producto
            $productos = [];
            foreach ($productos_bd as $producto_bd) {
                $productos[] = new Producto(
                    $producto_bd['id'],
                    $producto_bd['nombre'],
                    $producto_bd['descripcion'],
                    $producto_bd['categoria_id'],
                    "",
                    $producto_bd['precio'],
                    $producto_bd['imagen'],
                    $producto_bd['activo']
                );
            }
            //Devuelvo la lista de productos
            return $productos;

        } catch (PDOException $e) {
            throw new Exception("Error al listar los productos por categoría: " . $e->getMessage());
        }
    }


    public function getProducto(int $id): Producto
    {
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

    private function rellenarDatosProducto($sql, Producto $producto)
    {

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
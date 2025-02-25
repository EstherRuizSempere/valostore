<?php
include_once __DIR__ . '/../config/ConexionBD.php';
include_once __DIR__ . '/../config/utilidades.php';
include_once __DIR__ . '/../entidades/Producto.php';
include_once __DIR__ . '/../gestores/GestorCategoria.php';

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
        } catch (Exception $e) {
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


    public function listarProductos($nombre = null, $orden = "ASC")
    {
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
            $gestorCategoria = new GestorCategoria();

            foreach ($productos_bd as $producto_bd) {

                $categoria = $gestorCategoria->getCategoria($producto_bd['categoria_id']);


                $productos[] = new Producto(
                    $producto_bd['id'],
                    $producto_bd['nombre'],
                    $producto_bd['descripcion'],
                    $producto_bd['categoria_id'],
                    $categoria->getNombre(),
                    $producto_bd['precio'],
                    $producto_bd['imagen'],
                    $producto_bd['activo']
                );
            }

            // Devuelvo la lista de productos
            return $productos;
        } catch (Exception $e) {
            throw new Exception("Error al listar los productos: " . $e->getMessage());
        }
    }


    public function filtrarProductos(?string $orden = null, ?string $nombre = null, int $inicio = 0, int $limite = 8): array
    {
        $sqlOrden = $orden ?? "nombre asc";
        $sqlNombre = $nombre ? "WHERE nombre LIKE :nombre" : "";

        $sqlProductos = "SELECT * FROM productos $sqlNombre ORDER BY $sqlOrden LIMIT :offset, :limit";
        $sqlTotalProductos = "SELECT * FROM productos $sqlNombre ORDER BY $sqlOrden";

        $gestorCategoria = new GestorCategoria();

        try {
            $statementProductos = $this->pdo->prepare($sqlProductos);
            $statementTotalProductos = $this->pdo->prepare($sqlTotalProductos);

            if ($nombre) {
                $statementProductos->bindValue(':nombre', "%$nombre%");
            }

            //Paginacion
            $statementProductos->bindValue(':offset', $inicio, PDO::PARAM_INT);
            $statementProductos->bindValue(':limit', $limite, PDO::PARAM_INT);

            $statementProductos->execute();
            $statementTotalProductos->execute();

            $productos_bd = $statementProductos->fetchAll(PDO::FETCH_ASSOC);
            $totalProductos_bd = count($statementTotalProductos->fetchAll(PDO::FETCH_ASSOC));

            $productos = [];
            foreach ($productos_bd as $producto_bd) {
                $categoria_bd = $gestorCategoria->getCategoria($producto_bd['categoria_id']);
                $productos[] = new Producto($producto_bd['id'], $producto_bd['nombre'], $producto_bd['descripcion'], $producto_bd['categoria_id'], $categoria_bd->getNombre(), $producto_bd['precio'], $producto_bd['imagen'], $producto_bd['activo']);
            }

            return ["productos" => $productos, "totalProductos" => $totalProductos_bd];
        } catch (PDOException $e) {
            echo "Error al filtrar los productos: " . $e->getMessage();
            exit();
        }
    }


    public
    function listarProductoUnico($id)
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


    public
    function getProducto(int $id): Producto
    {
        //Preparo la consulta
        $sql = "SELECT * FROM productos WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $gestorCategoria = new GestorCategoria();

        try {
            $statement->execute();
            $producto_bd = $statement->fetch(PDO::FETCH_ASSOC);

            return new Producto($producto_bd['id'], $producto_bd['nombre'], $producto_bd['descripcion'], $producto_bd['categoria_id'], $gestorCategoria->getCategoria($producto_bd['categoria_id'])->getNombre(), $producto_bd['precio'], $producto_bd['imagen'], $producto_bd['activo']);
        } catch (PDOException $e) {
            echo "Error al obtener el producto: " . $e->getMessage();
            exit();
        }
    }

    public
    function getProductosDeUsuario(int $idUsuario)
    {
        $sql = "
        SELECT productos.* 
        FROM productos
        INNER JOIN usuario_producto ON usuario_producto.idProducto = productos.id
        INNER JOIN usuarios ON usuario_producto.idUsuario = usuarios.id
        WHERE usuarios.id = $idUsuario;
        ";

        $statement = $this->pdo->prepare($sql);
        $productos = [];
        $gestorCategoria = new GestorCategoria();

        try {
            $statement->execute();

            $productos_bd = $statement->fetchAll(PDO::FETCH_ASSOC);

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
            echo "Error al obtener los productos del usuario: " . $e->getMessage();
            exit();
        }
    }


    private
    function rellenarDatosProducto($sql, Producto $producto)
    {

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':nombre', $producto->getNombre());
        $statement->bindValue(':descripcion', $producto->getDescripcion());
        $statement->bindValue(':categoria_id', $producto->getCategoriaId());
        $statement->bindValue(':precio', $producto->getPrecio());
        $statement->bindValue(':imagen', $producto->getImagen());
        $statement->bindValue(':activo', $producto->getActivo());

        return $statement;

    }

    public function listarProductosFiltro(?string $nombre, ?string $filtroOrden,  int $inicio = 0, int $limite = 5)
    {
        $filtroNombreQuery = ($nombre != null) ? "AND nombre LIKE :nombre" : "";
        $filtroOrdenQuery = ($filtroOrden != null) ? "ORDER BY $filtroOrden" : "";

        //Ponemos 1=! para que no de error si no hay ningún filtro
        $sqlProductos = "SELECT * FROM productos WHERE 1=1 $filtroNombreQuery $filtroOrdenQuery LIMIT :inicio, :limite";
        $sqlTotalProductos = "SELECT * FROM productos WHERE 1=1 $filtroNombreQuery";

        $gestorCategoria = new GestorCategoria();

        try {
            $statementProductos = $this->pdo->prepare($sqlProductos);
            $statementTotalProductos = $this->pdo->prepare($sqlTotalProductos);

            if ($nombre != null) {
                $statementProductos->bindValue(':nombre', "%$nombre%");
                $statementTotalProductos->bindValue(':nombre', "%$nombre%");
            }


            $statementProductos->bindValue(':inicio', $inicio, PDO::PARAM_INT);
            $statementProductos->bindValue(':limite', $limite, PDO::PARAM_INT);

            $statementProductos->execute();
            $statementTotalProductos->execute();

            $productos_bd = $statementProductos->fetchAll(PDO::FETCH_ASSOC);
            $totalProductos_bd = count($statementTotalProductos->fetchAll(PDO::FETCH_ASSOC));

            $productos = [];
            foreach ($productos_bd as $producto_bd) {
                $categoria_bd = $gestorCategoria->getCategoria($producto_bd['categoria_id']);
                $productos[] = new Producto($producto_bd['id'], $producto_bd['nombre'], $producto_bd['descripcion'], $producto_bd['categoria_id'], $categoria_bd->getNombre(), $producto_bd['precio'], $producto_bd['imagen'], $producto_bd['activo']);
            }

            return ["productos" => $productos, "totalProductos" => $totalProductos_bd];
        } catch (PDOException $e) {
            echo "Error al listar los productos: " . $e->getMessage();
            exit();
        }
    }

}
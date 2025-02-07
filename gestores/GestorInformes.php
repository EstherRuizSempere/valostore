<?php
include_once __DIR__ . '/../config/ConexionBD.php';
include_once __DIR__ . '/../entidades/Categoria.php';
include_once __DIR__ . '/../entidades/Usuario.php';
include_once __DIR__ . '/../entidades/Producto.php';
include_once __DIR__ . '/../config/utilidades.php';
include_once __DIR__ . '/GestorCategoria.php';

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
                //Le permito que tenga el valor null en caso de que así sea, o sino muestre la fecha
                $fechaNacimiento = $usuario['fechaNacimiento'] ? new DateTime($usuario['fechaNacimiento']) : null;
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
                    $fechaNacimiento,
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

    public function getProductosActivos()
    {
        //Consulta para obtener a los productos activos
        $sql = "SELECT * FROM productos WHERE activo = 1";

        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        try {
            // Ejecutar la consulta
            if (!$statement->execute()) {
                throw new Exception("Error al listar los productos");
            }

            // Obtengo los resultados
            $producto_bd = $statement->fetchAll(PDO::FETCH_ASSOC);


            // Convierto los resultados en objetos Usuario
            $productos = [];
            //Creo mi gestor Categoria
            $gestorCategoria = new GestorCategoria();

            foreach ($producto_bd as $producto) {
                //Ternaria para que nos devuelva el valor de la variable si existe y no sea null
                $categoriaId = isset($producto['categoria_id']) ? $producto['categoria_id'] : null;
                //Obtengo la categoría
                $categoria = $categoriaId ? $gestorCategoria->getCategoria($categoriaId) : null;
                //Creo un objeto de tipo Producto
                $productos[] = new Producto(
                    $producto['id'],
                    $producto['nombre'],
                    $producto['descripcion'],
                    $producto['categoria_id'],
                    $categoria->getNombre(),
                    $producto['precio'],
                    $producto['imagen'],
                    $producto['activo']
                );
            }

            return $productos;

        } catch (Exception $error) {
            throw new Exception("Error al procesar la consulta: " . $error->getMessage());
        }
    }

    public function getProductosDormidos()
    {
        //Consulta para obtener a los productos inactivos
        $sql = "SELECT * FROM productos WHERE activo = 0";

        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        try {
            // Ejecutar la consulta
            if (!$statement->execute()) {
                throw new Exception("Error al listar los productos");
            }

            // Obtengo los resultados
            $producto_bd = $statement->fetchAll(PDO::FETCH_ASSOC);


            // Convierto los resultados en objetos Usuario
            $productos = [];
            //Creo mi gestor Categoria
            $gestorCategoria = new GestorCategoria();

            foreach ($producto_bd as $producto) {
                //Ternaria para que nos devuelva el valor de la variable si existe y no sea null
                $categoriaId = isset($producto['categoria_id']) ? $producto['categoria_id'] : null;
                //Obtengo la categoría
                $categoria = $categoriaId ? $gestorCategoria->getCategoria($categoriaId) : null;
                //Creo un objeto de tipo Producto
                $productos[] = new Producto(
                    $producto['id'],
                    $producto['nombre'],
                    $producto['descripcion'],
                    $producto['categoria_id'],
                    $categoria->getNombre(),
                    $producto['precio'],
                    $producto['imagen'],
                    $producto['activo']
                );
            }

            return $productos;

        } catch (Exception $error) {
            throw new Exception("Error al procesar la consulta: " . $error->getMessage());
        }
    }

    public function getTotalVentas()
    {
        $sql = "SELECT SUM(total) FROM pedidos";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        // Obtengo el resultado de la consulta
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);

        return $resultado['SUM(total)'];
    }

    public function getTotalPedidosCompletados()
    {
        $sql = "SELECT COUNT(id) FROM pedidos WHERE estado = 'aprobado'";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        // Obtengo el resultado de la consulta
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);

        return $resultado['COUNT(id)'];
    }

    public function getCestaMedia()
    {
        $sql = "SELECT ROUND(SUM(total) / COUNT(id), 2)  FROM pedidos WHERE estado = 'aprobado'";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        // Obtengo el resultado de la consulta
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);

        return $resultado['ROUND(SUM(total) / COUNT(id), 2)'] ?? 0; //El cero es para en caso de que no hayan pedidos
    }

    public function totalVentasPersoajes()
    {
        $sql = "
            SELECT 
                productos.id,
                productos.nombre as nombreProducto,
                categoriasHija.nombre as nombreCategoriaHija,
                categoriasPadre.nombre as nombreCategoriaPadre,
                (SELECT COUNT(*) FROM linea_pedido WHERE linea_pedido.idProducto = productos.id) as unidadesVendidas,
                (SELECT SUM(precio) FROM linea_pedido WHERE linea_pedido.idProducto = productos.id) as total
            FROM productos
            JOIN categorias categoriasHija ON productos.categoria_id = categoriasHija.id
            JOIN categorias categoriasPadre ON categoriasHija.idCategoriaPadre = categoriasPadre.id
                
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);


    }
}
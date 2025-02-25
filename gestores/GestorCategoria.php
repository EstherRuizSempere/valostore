<?php
include_once __DIR__ . '/../config/ConexionBD.php';
include_once __DIR__ . '/../entidades/Categoria.php';
include_once __DIR__ . '/../config/utilidades.php';

class GestorCategoria
{

    //Hago la llamada a la BD
    private $pdo;

    public function __construct()
    {
        $conexion = new ConexionBD();
        $this->pdo = $conexion->conectar();
    }


    public function getCategoria(int $id): Categoria
    {
        $sql = "SELECT * FROM categorias WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);

        try{
            $statement->execute();
            $categoria_bd = $statement->fetch(PDO::FETCH_ASSOC);

            return new Categoria($categoria_bd['id'], $categoria_bd['nombre'], $categoria_bd['activo'], $categoria_bd['idCategoriaPadre']);
        }catch (PDOException $e){
            echo "Error al obtener la categoría: " . $e->getMessage();
            exit();
        }

    }
    //Función para comprobar si existe una categoría Padre y que no se repita
    public function comprobarCategoria($nombre, $id = null)
    {
        try {
            if ($id) {
                $sql = "SELECT  nombre FROM categorias WHERE idCategoriaPadre IS NULL AND nombre = :nombre AND id != :id";
                $statement = $this->pdo->prepare($sql);
                $statement->bindValue(':nombre', ucfirst(strtolower($nombre)), PDO::PARAM_STR);
                $statement->bindValue(':id', $id, PDO::PARAM_INT);
                $statement->execute();
            } else {
                $sql = "SELECT  nombre FROM categorias WHERE idCategoriaPadre IS NULL AND nombre = :nombre";
                $statement = $this->pdo->prepare($sql);
                $statement->bindValue(':nombre', ucfirst(strtolower($nombre)), PDO::PARAM_STR);
                $statement->execute();
            }


            //Verifico que exista o no
            $categoria_bd = $statement->fetch(PDO::FETCH_ASSOC);

            if ($categoria_bd) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al comprobar la categoría: " . $e->getMessage();
            exit();
        }
    }
    public function comprobarCategoriaHija($nombre, $id = null)
    {
        try {
            if ($id) {
                $sql = "SELECT  nombre FROM categorias WHERE idCategoriaPadre IS NOT NULL AND nombre = :nombre AND id != :id";
                $statement = $this->pdo->prepare($sql);
                $statement->bindValue(':nombre', ucfirst(strtolower($nombre)), PDO::PARAM_STR);
                $statement->bindValue(':id', $id, PDO::PARAM_INT);
                $statement->execute();
            } else {
                $sql = "SELECT  nombre FROM categorias WHERE idCategoriaPadre IS NOT NULL AND nombre = :nombre";
                $statement = $this->pdo->prepare($sql);
                $statement->bindValue(':nombre', ucfirst(strtolower($nombre)), PDO::PARAM_STR);
                $statement->execute();
            }

            //Verifico que exista o no
            $categoria_bd = $statement->fetch(PDO::FETCH_ASSOC);

            if ($categoria_bd) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo "Error al comprobar la categoría: " . $e->getMessage();
            exit();
        }
    }


    public function listarCategoriasPadre($id = null, $orden = "ASC")
    {
        //Valido que el orden sea correcto
        $orden = strtoupper($orden);
        if ($orden !== "ASC" && $orden !== "DESC") {
            throw new Exception("El orden especificado no es válido. Use 'ASC' o 'DESC'.");
        }

        try {
            //Valido que el nombre sea correcto y lanzo
            if ($id !== null) {
                //Consulta para que me ordene por nombre parcialmente escrito
                $sql = "SELECT * FROM categorias WHERE id LIKE :id AND idCategoriaPadre IS  NULL ORDER BY id $orden";
                $statement = $this->pdo->prepare($sql);
                $statement->bindValue(':id', "%$id%", PDO::PARAM_STR);
            } else {
                $sql = "SELECT * FROM categorias WHERE idCategoriaPadre IS NULL ORDER BY id $orden";
                $statement = $this->pdo->prepare($sql);
            }

            //Ejecuto la consulta
            $statement->execute();

            //Obtengo los datos como array asociativo
            $categorias_bd = $statement->fetchAll(PDO::FETCH_ASSOC);
            //Los convierto en un objeto de tipo Categoria
            $categorias = [];
            //Lo recorro en un bucle foreach
            foreach ($categorias_bd as $categoria_bd) {
                $categorias[] = new Categoria($categoria_bd['id'], $categoria_bd['nombre'], $categoria_bd['activo'], $categoria_bd['idCategoriaPadre']);
            }
            //Devuelvo la lista de categorías
            return $categorias;

        } catch (PDOException $e) {
            echo "Error al listar las categorías: " . $e->getMessage();
            exit();
        }


    }

    public function listarCategoriasHija($id = null, $orden = "ASC")
    {
        //Valido que el orden sea correcto
        $orden = strtoupper($orden);
        if ($orden !== "ASC" && $orden !== "DESC") {
            throw new Exception("El orden especificado no es válido. Use 'ASC' o 'DESC'.");
        }

        try {
            //Valido que el nombre sea correcto y lanzo
            if ($id !== null) {
                //Consulta para que me ordene por nombre parcialmente escrito
                $sql = "SELECT * FROM categorias WHERE id LIKE :id AND idCategoriaPadre IS NOT NULL ORDER BY id $orden";
                $statement = $this->pdo->prepare($sql);
                $statement->bindValue(':id', "%$id%", PDO::PARAM_STR);
            } else {
                $sql = "SELECT * FROM categorias WHERE idCategoriaPadre IS NOT NULL ORDER BY id $orden";
                $statement = $this->pdo->prepare($sql);
            }

            //Ejecuto la consulta
            $statement->execute();

            //Obtengo los datos como array asociativo
            $categorias_bd = $statement->fetchAll(PDO::FETCH_ASSOC);
            //Los convierto en un objeto de tipo Categoria
            $categorias = [];
            //Lo recorro en un bucle foreach
            foreach ($categorias_bd as $categoria_bd) {
                $categorias[] = new Categoria($categoria_bd['id'], $categoria_bd['nombre'], $categoria_bd['activo'], $categoria_bd['idCategoriaPadre']);
            }
            //Devuelvo la lista de categorías
            return $categorias;

        } catch (PDOException $e) {
            echo "Error al listar las categorías: " . $e->getMessage();
            exit();
        }


    }

    public function crearCategoriaPadre(string $nombre, string $activo)
    {
        try {
            //Creo la consulta
            $sql = "INSERT INTO categorias (nombre, activo) VALUES (:nombre, :activo)";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':nombre', ucfirst(strtolower($nombre)), PDO::PARAM_STR);
            $statement->bindValue(':activo', $activo, PDO::PARAM_INT);

            //Ejecuto la consulta
            $statement->execute();

            return;

        } catch (Exception $e) {
            echo "Error al crear la categoría Padre: " . $e->getMessage();
            exit();
        }
    }

    public function crearCategoriaHija(string $nombre, string $activo, string $categoria_padre)
    {
        try {
            //Creo la consulta
            $sql = "INSERT INTO categorias (nombre, activo, idCategoriaPadre) VALUES (:nombre, :activo, :categoria_padre)";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':nombre', ucfirst(strtolower($nombre)), PDO::PARAM_STR);
            $statement->bindValue(':activo', $activo, PDO::PARAM_INT);
            $statement->bindValue(':categoria_padre', $categoria_padre, PDO::PARAM_INT);

            //Ejecuto la consulta
            $statement->execute();

            return;

        } catch (Exception $e) {
            echo "Error al crear la categoría Hija: " . $e->getMessage();
            exit();
        }
    }

    public function editarCategoria(int $id, string $nombre, string $activo, ?string $categoria_padre)
    {
        try {
            //Creo la consulta
            $sql = "UPDATE categorias SET nombre = :nombre, activo = :activo, idCategoriaPadre = :categoria_padre WHERE id = :id";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->bindValue(':nombre', ucfirst(strtolower($nombre)), PDO::PARAM_STR);
            $statement->bindValue(':activo', $activo, PDO::PARAM_INT);
            $statement->bindValue(':categoria_padre', $categoria_padre, PDO::PARAM_INT);

            //Ejecuto la consulta
            $statement->execute();

            return;

        } catch (Exception $e) {
            echo "Error al editar la categoría: " . $e->getMessage();
            exit();
        }
    }

    public function listarCategoriasHijaDeCategoriaPadre(int $idCategoriaPadre)
    {
        try {
            //Creo la consulta
            $sql = "SELECT * FROM categorias WHERE idCategoriaPadre = :idCategoriaPadre";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':idCategoriaPadre', $idCategoriaPadre, PDO::PARAM_INT);

            //Ejecuto la consulta
            $statement->execute();

            //Obtengo los datos como array asociativo
            $categorias_bd = $statement->fetchAll(PDO::FETCH_ASSOC);
            //Los convierto en un objeto de tipo Categoria
            $categorias = [];
            //Lo recorro en un bucle foreach
            foreach ($categorias_bd as $categoria_bd) {
                $categorias[] = new Categoria($categoria_bd['id'], $categoria_bd['nombre'], $categoria_bd['activo'], $categoria_bd['idCategoriaPadre']);
            }
            //Devuelvo la lista de categorías
            return $categorias;

        } catch (PDOException $e) {
            echo "Error al listar las categorías: " . $e->getMessage();
            exit();
        }
    }


}
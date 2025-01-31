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

    //Función para comprobar si existe una categoría Padre y que no se repita
    public function comprobarCategoria($nombre)
    {
        try {
            $sql = "SELECT  nombre FROM categoria WHERE idCategoriaPadre = null";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(strtolower(':nombre'), $nombre, PDO::PARAM_STR);
            $statement->execute();

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

}
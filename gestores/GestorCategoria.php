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

    public function listarCategoriasPadre($nombre, $orden = "ASC")
    {
        //Valido que el orden sea asc
        $orden = strtoupper($orden);
        if ($orden != "ASC") {
            $orden = "DESC";
        }
        if ($orden !== "ASC" && $orden !== "DESC") {
            throw new Exception("El orden especificado no es válido. Use 'ASC' o 'DESC'.");
        }

        try {
            //preparo la consulta para que capture las categorías padre
            $sql = "SELECT * FROM categorias WHERE idCategoriaPadre IS NULL ORDER BY nombre $orden";
        }
    }


}
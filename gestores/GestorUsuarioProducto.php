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
}

<?php
include_once __DIR__ .'/../constantes/BaseDeDatos.php';
class ConexionBD{
    public function conectar(){
        try{
            $pdo = new PDO("mysql:host=" . BaseDeDatos::$host . ";dbname=" . BaseDeDatos::$db, BaseDeDatos::$user, BaseDeDatos::$password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        }catch (PDOException $error){
            throw new Exception("Error de conexión a la base de datos: " . $error->getMessage());
        }
    }

}
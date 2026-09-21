<?php
require_once __DIR__ . "/../../config/Database.php";

class Cliente {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->connect();
    }

    public function getAll() {
        $sql = "SELECT id, nombre, documento, correo, telefono, fecha_registro 
        FROM cliente 
        ORDER BY id";
        $consulta = $this->connection->query($sql);
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT id, nombre, documento, correo, telefono, fecha_registro 
        FROM cliente 
        WHERE id = :id";
        $consulta = $this->connection->prepare($sql);
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }
}
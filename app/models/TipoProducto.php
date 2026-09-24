<?php
require_once __DIR__ . "/../../config/Database.php";

class TipoProducto {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->connect();
    }

    public function getAll() {
        $sql = "SELECT idTipoProducto, nTipoProducto
                FROM tipoproducto
                ORDER BY idTipoProducto";
        $consulta = $this->connection->query($sql);
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT idTipoProducto, nTipoProducto
                FROM tipoproducto 
                WHERE idTipoProducto = :id";
        $consulta = $this->connection->prepare($sql);
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }
}
<?php
require_once __DIR__ . "/../../config/Database.php";

class Ciudad {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->connect();
    }

    public function getAll() {
        $sql = "SELECT id, nombre 
                FROM ciudad 
                ORDER BY id";
        $consulta = $this->connection->query($sql);
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT id, nombre
                FROM ciudad
                WHERE id = :id";
        $consulta = $this->connection->prepare($sql);
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $nombre) {
        try {
            $consulta = $this->connection->prepare(
                "UPDATE ciudad SET nombre = :nombre WHERE id = :id"
            );
            $consulta->execute([':nombre' => $nombre, ':id' => $id]);
            return $consulta->rowCount() > 0 || $this->getById($id) !== false;
        } catch (PDOException $e) {
            error_log('Error al actualizar ciudad: ' . $e->getMessage());
            return false;
        }
    }

    public function crear($nombre) {
        try {
            $consulta = $this->connection->prepare(
                "INSERT INTO ciudad (nombre) VALUES (:nombre)"
            );
            return $consulta->execute([':nombre' => $nombre]);
        } catch (PDOException $e) {
            error_log('Error al crear ciudad: ' . $e->getMessage());
            return false;
        }
    }

    public function eliminar($id) {
        try {
            $consulta = $this->connection->prepare("DELETE FROM ciudad WHERE id = :id");
            $consulta->execute([':id' => $id]);
            return $consulta->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Error al eliminar ciudad: ' . $e->getMessage());
            return false;
        }
    }
}
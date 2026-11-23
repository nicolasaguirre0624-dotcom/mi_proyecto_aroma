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

    public function actualizar($id, $nombre) {
        try {
            $consulta = $this->connection->prepare(
                "UPDATE tipoproducto SET nTipoProducto = :nombre WHERE idTipoProducto = :id"
            );
            $consulta->execute([':nombre' => $nombre, ':id' => $id]);
            return $consulta->rowCount() > 0 || $this->getById($id) !== false;
        } catch (PDOException $e) {
            error_log('Error al actualizar tipo de producto: ' . $e->getMessage());
            return false;
        }
    }

    public function crear($nombre) {
        try {
            $consulta = $this->connection->prepare(
                "INSERT INTO tipoproducto (nTipoProducto) VALUES (:nombre)"
            );
            return $consulta->execute([':nombre' => $nombre]);
        } catch (PDOException $e) {
            error_log('Error al crear tipo de producto: ' . $e->getMessage());
            return false;
        }
    }

    public function eliminar($id) {
        try {
            $consulta = $this->connection->prepare(
                "DELETE FROM tipoproducto WHERE idTipoProducto = :id"
            );
            $consulta->execute([':id' => $id]);
            return $consulta->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Error al eliminar tipo de producto: ' . $e->getMessage());
            return false;
        }
    }
}
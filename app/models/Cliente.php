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

    public function actualizar($id, $nombre, $documento, $correo, $telefono) {
        try {
            $sql = "UPDATE cliente
                    SET nombre = :nombre, documento = :documento,
                        correo = :correo, telefono = :telefono
                    WHERE id = :id";
            $consulta = $this->connection->prepare($sql);
            $consulta->execute([
                ':nombre' => $nombre,
                ':documento' => $documento,
                ':correo' => $correo,
                ':telefono' => $telefono,
                ':id' => $id
            ]);
            return $consulta->rowCount() > 0 || $this->getById($id) !== false;
        } catch (PDOException $e) {
            error_log('Error al actualizar cliente: ' . $e->getMessage());
            return false;
        }
    }

    public function crear($nombre, $documento, $correo, $telefono) {
        try {
            $consulta = $this->connection->prepare(
                "INSERT INTO cliente (nombre, documento, correo, telefono)
                 VALUES (:nombre, :documento, :correo, :telefono)"
            );
            return $consulta->execute([
                ':nombre' => $nombre,
                ':documento' => $documento,
                ':correo' => $correo,
                ':telefono' => $telefono
            ]);
        } catch (PDOException $e) {
            error_log('Error al crear cliente: ' . $e->getMessage());
            return false;
        }
    }

    public function eliminar($id) {
        try {
            $consulta = $this->connection->prepare("DELETE FROM cliente WHERE id = :id");
            $consulta->execute([':id' => $id]);
            return $consulta->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Error al eliminar cliente: ' . $e->getMessage());
            return false;
        }
    }
}
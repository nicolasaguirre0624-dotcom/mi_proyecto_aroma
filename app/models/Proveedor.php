<?php
require_once __DIR__ . "/../../config/Database.php";

class Proveedor {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->connect();
    }

    public function getAll() {
        $sql = "SELECT id, nombre, direccion, telefono, correo 
                FROM proveedor 
                ORDER BY id";
        $consulta = $this->connection->query($sql);
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT id, nombre, direccion, telefono, correo 
                FROM proveedor 
                WHERE id = :id";
        $consulta = $this->connection->prepare($sql);
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $nombre, $direccion, $telefono, $correo) {
        try {
            $sql = "UPDATE proveedor
                    SET nombre = :nombre, direccion = :direccion,
                        telefono = :telefono, correo = :correo
                    WHERE id = :id";
            $consulta = $this->connection->prepare($sql);
            $consulta->execute([
                ':nombre' => $nombre,
                ':direccion' => $direccion,
                ':telefono' => $telefono,
                ':correo' => $correo,
                ':id' => $id
            ]);
            return $consulta->rowCount() > 0 || $this->getById($id) !== false;
        } catch (PDOException $e) {
            error_log('Error al actualizar proveedor: ' . $e->getMessage());
            return false;
        }
    }

    public function crear($nombre, $direccion, $telefono, $correo) {
        try {
            $consulta = $this->connection->prepare(
                "INSERT INTO proveedor (nombre, direccion, telefono, correo)
                 VALUES (:nombre, :direccion, :telefono, :correo)"
            );
            return $consulta->execute([
                ':nombre' => $nombre,
                ':direccion' => $direccion,
                ':telefono' => $telefono,
                ':correo' => $correo
            ]);
        } catch (PDOException $e) {
            error_log('Error al crear proveedor: ' . $e->getMessage());
            return false;
        }
    }

    public function eliminar($id) {
        try {
            $consulta = $this->connection->prepare("DELETE FROM proveedor WHERE id = :id");
            $consulta->execute([':id' => $id]);
            return $consulta->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Error al eliminar proveedor: ' . $e->getMessage());
            return false;
        }
    }
}
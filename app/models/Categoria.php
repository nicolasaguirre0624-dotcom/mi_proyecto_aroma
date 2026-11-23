<?php

require_once __DIR__ . "/../../config/Database.php";

class Categoria {

    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->connect();
    }

    public function getAll() {
        try {
            
            $sql = "SELECT * FROM categorias ORDER BY id";
            
            $consulta = $this->connection->query($sql);
            return $consulta->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "Error al consultar las categorias: " . $e->getMessage();
        }
    }

    public function getById($id) {
        try {
            
            $sql = "SELECT * FROM categorias WHERE id = :id";
            $consulta = $this->connection->prepare($sql);
            $consulta->bindParam(
                ':id',
                $id,
                PDO::PARAM_INT
            );
            $consulta->execute();
            return $consulta->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "Error al consultar la categoria: " . $e->getMessage();
        }
    }

    public function actualizar($id, $nombre, $descripcion) {
        try {
            $consulta = $this->connection->prepare(
                "UPDATE categorias SET nombre = :nombre, descripcion = :descripcion WHERE id = :id"
            );
            $consulta->execute([
                ':nombre' => $nombre,
                ':descripcion' => $descripcion,
                ':id' => $id
            ]);
            return $consulta->rowCount() > 0 || $this->getById($id) !== false;
        } catch (PDOException $e) {
            error_log('Error al actualizar categoría: ' . $e->getMessage());
            return false;
        }
    }

    public function crear($nombre, $descripcion) {
        try {
            $consulta = $this->connection->prepare(
                "INSERT INTO categorias (nombre, descripcion) VALUES (:nombre, :descripcion)"
            );
            return $consulta->execute([
                ':nombre' => $nombre,
                ':descripcion' => $descripcion
            ]);
        } catch (PDOException $e) {
            error_log('Error al crear categoría: ' . $e->getMessage());
            return false;
        }
    }

    public function eliminar($id) {
        try {
            $consulta = $this->connection->prepare("DELETE FROM categorias WHERE id = :id");
            $consulta->execute([':id' => $id]);
            return $consulta->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Error al eliminar categoría: ' . $e->getMessage());
            return false;
        }
    }

}
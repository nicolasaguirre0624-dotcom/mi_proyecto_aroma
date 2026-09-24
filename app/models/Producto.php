<?php

require_once __DIR__ . "/../../config/Database.php";

class Producto {

    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->connect();
    }

    public function getAll() {
        try {
            $sql = "SELECT p.id,
                           p.nombre,
                           p.precio,
                           p.stock,
                           p.id_proveedor,
                           p.id_categoria,
                           pr.nombre AS nombre_proveedor,
                           c.nombre AS nombre_categoria
                    FROM productos p
                    LEFT JOIN proveedor pr ON p.id_proveedor = pr.id
                    LEFT JOIN categorias c ON p.id_categoria = c.id
                    ORDER BY p.id";

            $consulta = $this->connection->query($sql);
            return $consulta->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [
                "error" => "Hubo un error en la consulta de la tabla productos: " . $e->getMessage()
            ];
        }
    }

    public function getById($id) {
        try {
            $sql = "SELECT p.id,
                           p.nombre,
                           p.precio,
                           p.stock,
                           p.id_proveedor,
                           p.id_categoria,
                           pr.nombre AS nombre_proveedor,
                           c.nombre AS nombre_categoria
                    FROM productos p
                    LEFT JOIN proveedor pr ON p.id_proveedor = pr.id
                    LEFT JOIN categorias c ON p.id_categoria = c.id
                    WHERE p.id = :id";

            $consulta = $this->connection->prepare($sql);
            $consulta->bindParam(':id', $id, PDO::PARAM_INT);
            $consulta->execute();

            return $consulta->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [
                "error" => "Hubo un error al consultar el producto: " . $e->getMessage()
            ];
        }
    }

}
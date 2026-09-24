<?php

require_once __DIR__ . "/../../config/Database.php";

class Compra {

    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->connect();
    }

    public function getAll() {
        try {
            $sql = "SELECT c.idCompra,
                           c.int_proveedor,
                           c.fechaCompra,
                           c.idTipoPago,
                           c.ivaCompra,
                           c.valorCompra,
                           p.nombre AS nombre_proveedor
                    FROM compra c
                    LEFT JOIN proveedores p ON c.int_proveedor = p.id
                    ORDER BY c.idCompra DESC";

            $consulta = $this->connection->query($sql);
            $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
            
         

            return $resultados;

        } catch (PDOException $e) {
            return [
                "error" => "Error en la consulta: " . $e->getMessage()
            ];
        }
    }
}
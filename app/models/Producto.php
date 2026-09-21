<?php
require_once __DIR__ . '/../config/Database.php';

class Producto {
    private $conn;
    private $tabla = "producto";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection('mi_proyecto_aroma');
    }

    public function listar() {
        if (!$this->conn) {
            return [];
        }

        $query = "SELECT * FROM " . $this->tabla;
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll();
    }
}
?>
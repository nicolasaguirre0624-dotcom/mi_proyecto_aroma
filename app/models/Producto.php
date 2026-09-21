<?php
require_once __DIR__ . '/../../config/Database.php';

class Producto {
    private $conn;
    private $tabla = "producto";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    // Listar productos desde la base de datos
    public function listar() {
        $query = "SELECT * FROM " . $this->tabla;
        $resultado = $this->conn->query($query);
        return $resultado;
    }
}
?>
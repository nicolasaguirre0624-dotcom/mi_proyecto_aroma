<?php
require_once __DIR__ . "/../config/Database.php";

class Venta {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getAll() {
        $sql = "SELECT v.*, c.nombreCliente FROM ventas v JOIN clientes c ON v.nDocClient = c.noDocument";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
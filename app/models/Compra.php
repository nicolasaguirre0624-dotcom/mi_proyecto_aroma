<?php
require_once __DIR__ . "/../config/Database.php";

class Compra {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getAll() {
        $sql = "SELECT co.*, p.nombreProo FROM compra co JOIN proveedores p ON co.int_proveedor = p.nit_proveedor";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
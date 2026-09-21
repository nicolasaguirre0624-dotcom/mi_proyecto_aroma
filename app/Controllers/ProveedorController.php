<?php
require_once __DIR__ . "/../models/Proveedor.php";

class ProveedorController {
    private $model;

    public function __construct() {
        $this->model = new Proveedor();
    }

    public function index() {
        $proveedores = $this->model->getAll();
        require_once __DIR__ . "/../views/proveedor/index.php";
    }
}
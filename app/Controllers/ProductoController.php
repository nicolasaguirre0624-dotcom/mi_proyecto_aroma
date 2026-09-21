<?php
require_once __DIR__ . "/../models/Producto.php";

class ProductoController {
    private $model;

    public function __construct() {
        $this->model = new Producto();
    }

    public function index() {
        $productos = $this->model->getAll();
        require_once __DIR__ . "/../views/producto/index.php";
    }
}
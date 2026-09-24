<?php
require_once __DIR__ . "/../models/Compra.php";

class CompraController {
    private $model;

    public function __construct() {
        $this->model = new Compra();
    }

    public function index() {
        $compras = $this->model->getAll();
        require_once __DIR__ . "/../views/compra/index.php";
    }
    
}
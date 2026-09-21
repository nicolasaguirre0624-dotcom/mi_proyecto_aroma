<?php
require_once __DIR__ . "/../models/Venta.php";

class VentaController {
    private $model;

    public function __construct() {
        $this->model = new Venta();
    }

    public function index() {
        $ventas = $this->model->getAll();
        require_once __DIR__ . "/../views/venta/index.php";
    }
}
<?php
require_once __DIR__ . "/../models/TipoProducto.php";

class TipoProductoController {
    private $model;

    public function __construct() {
        $this->model = new TipoProducto();
    }

    public function index() {
        $tiposProducto = $this->model->getAll();
        require_once __DIR__ . "/../views/tipoproducto/index.php";
    }
}
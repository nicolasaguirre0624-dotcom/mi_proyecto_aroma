<?php
require_once __DIR__ . "/../models/Cliente.php";

class ClienteController {
    private $model;

    public function __construct() {
        $this->model = new Cliente();
    }

    public function index() {
        $clientes = $this->model->getAll();
        require_once __DIR__ . "/../views/cliente/index.php";
    }
}
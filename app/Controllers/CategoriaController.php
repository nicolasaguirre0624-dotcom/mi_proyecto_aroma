<?php
require_once __DIR__ . "/../models/Categoria.php";

class CategoriaController {
    private $model;

    public function __construct() {
        $this->model = new Categoria();
    }

    public function index() {
        
        $categorias = $this->model->getAll();
        
       
        require_once __DIR__ . "/../views/categoria/index.php";
    }
}
<?php
require_once __DIR__ . "/../models/Ciudad.php";

class CiudadController {
    private $model;

    public function __construct() {
        $this->model = new Ciudad();
    }

    public function index() {
        
        $ciudades = $this->model->getAll();
        
       
       require_once __DIR__ . "/../views/ciudad/index.php";
    }
}
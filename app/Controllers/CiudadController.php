<?php
require_once __DIR__ . "/../models/Ciudad.php";

class CiudadController {
    private $model;

    public function __construct() {
        $this->model = new Ciudad();
    }

    public function index() {
        $ciudades = $this->model->getAll();
        $mensajes = [
            'eliminado' => 'Ciudad eliminada correctamente.',
            'no_eliminado' => 'No se pudo eliminar la ciudad.',
            'creado' => 'Ciudad creada correctamente.',
            'no_creado' => 'No se pudo crear la ciudad. Verifica los datos.',
            'actualizado' => 'Ciudad actualizada correctamente.',
            'no_actualizado' => 'No se pudo actualizar la ciudad. Verifica los datos.'
        ];
        $mensaje = $mensajes[$_GET['resultado'] ?? ''] ?? '';
        require_once __DIR__ . "/../views/Ciudad/index.php";
    }

    public function editar() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $ciudad = ($id !== false && $id !== null && $id > 0)
            ? $this->model->getById($id)
            : false;
        if (!$ciudad) {
            header('Location: ' . APP_BASE_PATH . '/ciudades?resultado=no_actualizado');
            exit();
        }
        require_once __DIR__ . "/../views/Ciudad/editar.php";
        exit();
    }

    public function crear() {
        $nombre = trim($_POST['nombre'] ?? '');
        $valido = $_SERVER['REQUEST_METHOD'] === 'POST' && $nombre !== '';
        $creado = $valido && $this->model->crear($nombre);
        $resultado = $creado ? 'creado' : 'no_creado';
        header('Location: ' . APP_BASE_PATH . '/ciudades?resultado=' . $resultado);
        exit();
    }

    public function actualizar() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $nombre = trim($_POST['nombre'] ?? '');
        $valido = $_SERVER['REQUEST_METHOD'] === 'POST'
            && $id !== false && $id !== null && $id > 0 && $nombre !== '';
        $actualizado = $valido && $this->model->actualizar($id, $nombre);
        $resultado = $actualizado ? 'actualizado' : 'no_actualizado';
        header('Location: ' . APP_BASE_PATH . '/ciudades?resultado=' . $resultado);
        exit();
    }

    public function eliminar() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $eliminado = $_SERVER['REQUEST_METHOD'] === 'POST'
            && $id !== false && $id !== null && $id > 0
            && $this->model->eliminar($id);
        $resultado = $eliminado ? 'eliminado' : 'no_eliminado';
        header('Location: ' . APP_BASE_PATH . '/ciudades?resultado=' . $resultado);
        exit();
    }
}
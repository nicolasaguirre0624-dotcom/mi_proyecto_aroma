<?php
require_once __DIR__ . "/../models/TipoProducto.php";

class TipoProductoController {
    private $model;

    public function __construct() {
        $this->model = new TipoProducto();
    }

    public function index() {
        $tiposProducto = $this->model->getAll();
        $mensajes = [
            'eliminado' => 'Tipo de producto eliminado correctamente.',
            'no_eliminado' => 'No se pudo eliminar el tipo de producto.',
            'creado' => 'Tipo de producto creado correctamente.',
            'no_creado' => 'No se pudo crear el tipo de producto. Verifica los datos.',
            'actualizado' => 'Tipo de producto actualizado correctamente.',
            'no_actualizado' => 'No se pudo actualizar el tipo de producto. Verifica los datos.'
        ];
        $mensaje = $mensajes[$_GET['resultado'] ?? ''] ?? '';
        require_once __DIR__ . "/../views/tipoproducto/index.php";
    }

    public function editar() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $tipoProducto = ($id !== false && $id !== null && $id > 0)
            ? $this->model->getById($id)
            : false;
        if (!$tipoProducto) {
            header('Location: ' . APP_BASE_PATH . '/tipos-producto?resultado=no_actualizado');
            exit();
        }
        require_once __DIR__ . "/../views/tipoproducto/editar.php";
        exit();
    }

    public function crear() {
        $nombre = trim($_POST['nombre'] ?? '');
        $valido = $_SERVER['REQUEST_METHOD'] === 'POST' && $nombre !== '';
        $creado = $valido && $this->model->crear($nombre);
        $resultado = $creado ? 'creado' : 'no_creado';
        header('Location: ' . APP_BASE_PATH . '/tipos-producto?resultado=' . $resultado);
        exit();
    }

    public function actualizar() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $nombre = trim($_POST['nombre'] ?? '');
        $valido = $_SERVER['REQUEST_METHOD'] === 'POST'
            && $id !== false && $id !== null && $id > 0 && $nombre !== '';
        $actualizado = $valido && $this->model->actualizar($id, $nombre);
        $resultado = $actualizado ? 'actualizado' : 'no_actualizado';
        header('Location: ' . APP_BASE_PATH . '/tipos-producto?resultado=' . $resultado);
        exit();
    }

    public function eliminar() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $eliminado = $_SERVER['REQUEST_METHOD'] === 'POST'
            && $id !== false && $id !== null && $id > 0
            && $this->model->eliminar($id);
        $resultado = $eliminado ? 'eliminado' : 'no_eliminado';
        header('Location: ' . APP_BASE_PATH . '/tipos-producto?resultado=' . $resultado);
        exit();
    }
}
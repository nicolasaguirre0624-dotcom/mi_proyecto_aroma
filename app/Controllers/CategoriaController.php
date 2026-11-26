<?php
require_once __DIR__ . "/../models/Categoria.php";

class CategoriaController {
    private $model;

    public function __construct() {
        $this->model = new Categoria();
    }

    public function index() {
        $categorias = $this->model->getAll();
        $mensajes = [
            'eliminado' => 'Categoría eliminada correctamente.',
            'no_eliminado' => 'No se pudo eliminar la categoría.',
            'creado' => 'Categoría creada correctamente.',
            'no_creado' => 'No se pudo crear la categoría. Verifica los datos.',
            'actualizado' => 'Categoría actualizada correctamente.',
            'no_actualizado' => 'No se pudo actualizar la categoría. Verifica los datos.'
        ];
        $mensaje = $mensajes[$_GET['resultado'] ?? ''] ?? '';
        require_once __DIR__ . "/../views/categoria/index.php";
    }

    public function editar() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $categoria = ($id !== false && $id !== null && $id > 0)
            ? $this->model->getById($id)
            : false;
        if (!$categoria) {
            header('Location: ' . APP_BASE_PATH . '/categorias?resultado=no_actualizado');
            exit();
        }
        require_once __DIR__ . "/../views/categoria/editar.php";
        exit();
    }

    public function crear() {
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $valido = $_SERVER['REQUEST_METHOD'] === 'POST' && $nombre !== '';
        $creado = $valido && $this->model->crear($nombre, $descripcion);
        $resultado = $creado ? 'creado' : 'no_creado';
        $mensaje = $creado
            ? 'Categoría creada correctamente.'
            : 'No se pudo crear la categoría. Verifica los datos.';
        http_response_code($creado ? 200 : 400);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => $creado,
            'result' => $resultado,
            'message' => $mensaje
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit();
    }

    public function actualizar() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $valido = $_SERVER['REQUEST_METHOD'] === 'POST'
            && $id !== false && $id !== null && $id > 0 && $nombre !== '';
        $actualizado = $valido && $this->model->actualizar($id, $nombre, $descripcion);
        $resultado = $actualizado ? 'actualizado' : 'no_actualizado';
        $mensaje = $actualizado
            ? 'Categoría actualizada correctamente.'
            : 'No se pudo actualizar la categoría. Verifica los datos.';
        http_response_code($actualizado ? 200 : 400);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => $actualizado,
            'result' => $resultado,
            'message' => $mensaje
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit();
    }

    public function eliminar() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $eliminado = $_SERVER['REQUEST_METHOD'] === 'POST'
            && $id !== false && $id !== null && $id > 0
            && $this->model->eliminar($id);
        $resultado = $eliminado ? 'eliminado' : 'no_eliminado';
        $mensaje = $eliminado
            ? 'Categoría eliminada correctamente.'
            : 'No se pudo eliminar la categoría.';
        http_response_code($eliminado ? 200 : 400);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => $eliminado,
            'result' => $resultado,
            'message' => $mensaje
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit();
    }
}

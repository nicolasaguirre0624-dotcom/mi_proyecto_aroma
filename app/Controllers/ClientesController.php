<?php
require_once __DIR__ . "/../models/Cliente.php";

class ClientesController { 

    private $model;

    public function __construct() {
        $this->model = new Cliente();
    }

    public function index() {
        $clientes = $this->model->getAll();
        $mensajes = [
            'eliminado' => 'Cliente eliminado correctamente.',
            'no_eliminado' => 'No se pudo eliminar el cliente.',
            'creado' => 'Cliente creado correctamente.',
            'no_creado' => 'No se pudo crear el cliente. Verifica los datos.',
            'actualizado' => 'Cliente actualizado correctamente.',
            'no_actualizado' => 'No se pudo actualizar el cliente. Verifica los datos.'
        ];
        $mensaje = $mensajes[$_GET['resultado'] ?? ''] ?? '';
        require_once __DIR__ . "/../views/Cliente/index.php"; 
    }

    public function editar() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $cliente = ($id !== false && $id !== null && $id > 0)
            ? $this->model->getById($id)
            : false;
        if (!$cliente) {
            header('Location: ' . APP_BASE_PATH . '/clientes?resultado=no_actualizado');
            exit();
        }
        require_once __DIR__ . "/../views/Cliente/editar.php";
        exit();
    }

    public function crear() {
        $nombre = trim($_POST['nombre'] ?? '');
        $documento = trim($_POST['documento'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $valido = $_SERVER['REQUEST_METHOD'] === 'POST'
            && $nombre !== '' && $documento !== ''
            && ($correo === '' || filter_var($correo, FILTER_VALIDATE_EMAIL));
        $creado = $valido && $this->model->crear($nombre, $documento, $correo, $telefono);
        $resultado = $creado ? 'creado' : 'no_creado';
        header('Location: ' . APP_BASE_PATH . '/clientes?resultado=' . $resultado);
        exit();
    }

    public function actualizar() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $nombre = trim($_POST['nombre'] ?? '');
        $documento = trim($_POST['documento'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $valido = $_SERVER['REQUEST_METHOD'] === 'POST'
            && $id !== false && $id !== null && $id > 0
            && $nombre !== '' && $documento !== ''
            && ($correo === '' || filter_var($correo, FILTER_VALIDATE_EMAIL));
        $actualizado = $valido
            && $this->model->actualizar($id, $nombre, $documento, $correo, $telefono);
        $resultado = $actualizado ? 'actualizado' : 'no_actualizado';
        header('Location: ' . APP_BASE_PATH . '/clientes?resultado=' . $resultado);
        exit();
    }

    public function eliminar() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $eliminado = $_SERVER['REQUEST_METHOD'] === 'POST'
            && $id !== false && $id !== null && $id > 0
            && $this->model->eliminar($id);
        $resultado = $eliminado ? 'eliminado' : 'no_eliminado';
        header('Location: ' . APP_BASE_PATH . '/clientes?resultado=' . $resultado);
        exit();
    }
}
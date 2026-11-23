<?php
require_once __DIR__ . "/../models/Proveedor.php";

class ProveedorController {
    private $model;

    public function __construct() {
        $this->model = new Proveedor();
    }

    public function index() {
        $proveedores = $this->model->getAll();
        $mensajes = [
            'eliminado' => 'Proveedor eliminado correctamente.',
            'no_eliminado' => 'No se pudo eliminar el proveedor.',
            'creado' => 'Proveedor creado correctamente.',
            'no_creado' => 'No se pudo crear el proveedor. Verifica los datos.',
            'actualizado' => 'Proveedor actualizado correctamente.',
            'no_actualizado' => 'No se pudo actualizar el proveedor. Verifica los datos.'
        ];
        $mensaje = $mensajes[$_GET['resultado'] ?? ''] ?? '';
        require_once __DIR__ . "/../views/proveedor/index.php";
    }

    public function editar() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $proveedor = ($id !== false && $id !== null && $id > 0)
            ? $this->model->getById($id)
            : false;
        if (!$proveedor) {
            header('Location: ' . APP_BASE_PATH . '/proveedores?resultado=no_actualizado');
            exit();
        }
        require_once __DIR__ . "/../views/proveedor/editar.php";
        exit();
    }

    public function crear() {
        $nombre = trim($_POST['nombre'] ?? '');
        $direccion = trim($_POST['direccion'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $valido = $_SERVER['REQUEST_METHOD'] === 'POST'
            && $nombre !== ''
            && ($correo === '' || filter_var($correo, FILTER_VALIDATE_EMAIL));
        $creado = $valido && $this->model->crear($nombre, $direccion, $telefono, $correo);
        $resultado = $creado ? 'creado' : 'no_creado';
        header('Location: ' . APP_BASE_PATH . '/proveedores?resultado=' . $resultado);
        exit();
    }

    public function actualizar() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $nombre = trim($_POST['nombre'] ?? '');
        $direccion = trim($_POST['direccion'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $valido = $_SERVER['REQUEST_METHOD'] === 'POST'
            && $id !== false && $id !== null && $id > 0
            && $nombre !== ''
            && ($correo === '' || filter_var($correo, FILTER_VALIDATE_EMAIL));
        $actualizado = $valido
            && $this->model->actualizar($id, $nombre, $direccion, $telefono, $correo);
        $resultado = $actualizado ? 'actualizado' : 'no_actualizado';
        header('Location: ' . APP_BASE_PATH . '/proveedores?resultado=' . $resultado);
        exit();
    }

    public function eliminar() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $eliminado = $_SERVER['REQUEST_METHOD'] === 'POST'
            && $id !== false && $id !== null && $id > 0
            && $this->model->eliminar($id);
        $resultado = $eliminado ? 'eliminado' : 'no_eliminado';
        header('Location: ' . APP_BASE_PATH . '/proveedores?resultado=' . $resultado);
        exit();
    }
}
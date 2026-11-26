<?php
require_once __DIR__ . "/../models/Compra.php";

class CompraController {
    private $model;

    public function __construct() {
        $this->model = new Compra();
    }

    public function index() {
        $compras = $this->model->getAll();
        $mensajes = [
            'creado' => 'Compra creada correctamente.',
            'no_creado' => 'No se pudo crear la compra. Verifica los datos.',
            'actualizado' => 'Compra actualizada correctamente.',
            'no_actualizado' => 'No se pudo actualizar la compra. Verifica los datos.',
            'eliminado' => 'Compra eliminada correctamente.',
            'no_eliminado' => 'No se pudo eliminar la compra.'
        ];
        $mensaje = $mensajes[$_GET['resultado'] ?? ''] ?? '';
        require_once __DIR__ . '/../views/compra/index.php';
    }

    public function crear() {
        $datos = $this->leerDatos();
        $creado = $_SERVER['REQUEST_METHOD'] === 'POST'
            && $datos !== false
            && $this->model->crear(
                $datos['idProveedor'],
                $datos['fechaCompra'],
                $datos['idTipoPago'],
                $datos['ivaCompra'],
                $datos['valorCompra']
            );
        $resultado = $creado ? 'creado' : 'no_creado';
        $mensaje = $creado
            ? 'Compra creada correctamente.'
            : 'No se pudo crear la compra. Verifica los datos.';
        JsonResponse::send($creado, $resultado, $mensaje);
    }

    public function editar() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $compra = ($id !== false && $id !== null && $id > 0)
            ? $this->model->getById($id)
            : false;
        if (!$compra) {
            $this->redirigir('no_actualizado');
        }
        require_once __DIR__ . '/../views/compra/editar.php';
        exit();
    }

    public function actualizar() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $datos = $this->leerDatos();
        $actualizado = $_SERVER['REQUEST_METHOD'] === 'POST'
            && $id !== false && $id !== null && $id > 0
            && $datos !== false
            && $this->model->actualizar(
                $id,
                $datos['idProveedor'],
                $datos['fechaCompra'],
                $datos['idTipoPago'],
                $datos['ivaCompra'],
                $datos['valorCompra']
            );
        $resultado = $actualizado ? 'actualizado' : 'no_actualizado';
        $mensaje = $actualizado
            ? 'Compra actualizada correctamente.'
            : 'No se pudo actualizar la compra. Verifica los datos.';
        JsonResponse::send($actualizado, $resultado, $mensaje);
    }

    public function eliminar() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $eliminado = $_SERVER['REQUEST_METHOD'] === 'POST'
            && $id !== false && $id !== null && $id > 0
            && $this->model->eliminar($id);
        $resultado = $eliminado ? 'eliminado' : 'no_eliminado';
        $mensaje = $eliminado
            ? 'Compra eliminada correctamente.'
            : 'No se pudo eliminar la compra.';
        JsonResponse::send($eliminado, $resultado, $mensaje);
    }

    private function redirigir($resultado) {
        header('Location: ' . APP_BASE_PATH . '/compras?resultado=' . $resultado);
        exit();
    }

    private function leerDatos() {
        $idProveedor = filter_input(INPUT_POST, 'int_proveedor', FILTER_VALIDATE_INT);
        $idTipoPago = filter_input(INPUT_POST, 'idTipoPago', FILTER_VALIDATE_INT);
        $ivaCompra = filter_input(INPUT_POST, 'ivaCompra', FILTER_VALIDATE_FLOAT);
        $valorCompra = filter_input(INPUT_POST, 'valorCompra', FILTER_VALIDATE_FLOAT);
        $fechaCompra = trim($_POST['fechaCompra'] ?? '');
        $fechaValida = preg_match('/^\d{4}-\d{2}-\d{2}$/', $fechaCompra)
            && checkdate(
                (int) substr($fechaCompra, 5, 2),
                (int) substr($fechaCompra, 8, 2),
                (int) substr($fechaCompra, 0, 4)
            );

        if (
            $idProveedor === false || $idProveedor === null || $idProveedor < 1
            || $idTipoPago === false || $idTipoPago === null || $idTipoPago < 1
            || !$fechaValida
            || $ivaCompra === false || $ivaCompra === null || $ivaCompra < 0
            || $valorCompra === false || $valorCompra === null || $valorCompra < 0
        ) {
            return false;
        }

        return [
            'idProveedor' => $idProveedor,
            'fechaCompra' => $fechaCompra,
            'idTipoPago' => $idTipoPago,
            'ivaCompra' => $ivaCompra,
            'valorCompra' => $valorCompra
        ];
    }

}

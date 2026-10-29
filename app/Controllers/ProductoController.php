<?php
require_once __DIR__ . "/../models/Producto.php";

class ProductoController {
    private $model;

    public function __construct() {
        $this->model = new Producto();
    }

    public function index() {
        $productos = $this->model->getAll();
        $resultado = $_GET['resultado'] ?? '';
        $mensajes = [
            'eliminado' => 'Producto eliminado correctamente.',
            'no_eliminado' => 'No se pudo eliminar el producto.',
            'actualizado' => 'Producto actualizado correctamente.',
            'no_actualizado' => 'No se pudo actualizar el producto. Verifica los datos.'
        ];
        $mensaje = $mensajes[$resultado] ?? '';
        require_once __DIR__ . "/../views/producto/index.php";
    }

    public function eliminar() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $eliminado = $_SERVER['REQUEST_METHOD'] === 'POST'
            && $id !== false
            && $id !== null
            && $id > 0
            && $this->model->eliminarProducto($id);

        $resultado = $eliminado ? 'eliminado' : 'no_eliminado';
        header('Location: /aroma/public/productos?resultado=' . $resultado);
        exit();
    }

    public function editar() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $producto = ($id !== false && $id !== null && $id > 0)
            ? $this->model->obtenerPorId($id)
            : false;

        if (!$producto || isset($producto['error'])) {
            header('Location: /aroma/public/productos?resultado=no_actualizado');
            exit();
        }

        require_once __DIR__ . '/../views/producto/editar.php';
        exit();
    }

    public function actualizar() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $nombre = trim($_POST['nombre'] ?? '');
        $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
        $stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);
        $idProveedor = filter_input(INPUT_POST, 'id_proveedor', FILTER_VALIDATE_INT);
        $idCategoria = filter_input(INPUT_POST, 'id_categoria', FILTER_VALIDATE_INT);

        $datosValidos = $_SERVER['REQUEST_METHOD'] === 'POST'
            && $id !== false && $id !== null && $id > 0
            && $nombre !== ''
            && $precio !== false && $precio !== null && $precio >= 0
            && $stock !== false && $stock !== null && $stock >= 0
            && $idProveedor !== false && $idProveedor !== null && $idProveedor > 0
            && $idCategoria !== false && $idCategoria !== null && $idCategoria > 0;

        $actualizado = $datosValidos && $this->model->actualizarProducto(
            $id,
            $nombre,
            $precio,
            $stock,
            $idProveedor,
            $idCategoria
        );

        $resultado = $actualizado ? 'actualizado' : 'no_actualizado';
        header('Location: /aroma/public/productos?resultado=' . $resultado);
        exit();
    }

}

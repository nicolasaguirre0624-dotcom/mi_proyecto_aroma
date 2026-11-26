<?php
require_once __DIR__ . '/../models/Producto.php';

class TiendaController {
    private $model;

    public function __construct() {
        $this->model = new Producto();
    }

    public function index() {
        $productos = $this->model->getAll();
        $error = '';
        if (isset($productos['error'])) {
            error_log($productos['error']);
            $productos = [];
            $error = 'No se pudieron cargar los productos. Intenta de nuevo más tarde.';
        }

        $imagenes = [
            'sauvage' => ['archivo' => 'sauvage.jpg', 'codigo' => '3348901486392'],
            'la vie est belle' => ['archivo' => 'la-vie-est-belle.jpg', 'codigo' => '3605533286555'],
            'eros' => ['archivo' => 'versace-eros.jpg', 'codigo' => '8011003813858'],
            'good girl' => ['archivo' => 'good-girl.jpg', 'codigo' => '8411061819838'],
            'one million' => ['archivo' => 'one-million.jpg', 'codigo' => '3349666007921']
        ];
        $directorioImagenes = __DIR__ . '/../../public/img/imagenes/perfumes/';
        foreach ($productos as &$producto) {
            $nombre = strtolower($producto['nombre'] ?? '');
            foreach ($imagenes as $nombreProducto => $imagen) {
                if (strpos($nombre, $nombreProducto) === false) {
                    continue;
                }

                if (is_file($directorioImagenes . $imagen['archivo'])) {
                    $producto['image_url'] = APP_PUBLIC_PATH . '/img/imagenes/perfumes/' . $imagen['archivo'];
                    $producto['image_source'] = 'https://world.openbeautyfacts.org/product/' . $imagen['codigo'];
                    $producto['image_license'] = 'https://creativecommons.org/licenses/by-sa/3.0/';
                }
                break;
            }
        }
        unset($producto);

        $productosPorId = [];
        foreach ($productos as $producto) {
            $productosPorId[(int) $producto['id']] = $producto;
        }

        $carrito = is_array($_SESSION['carrito'] ?? null) ? $_SESSION['carrito'] : [];
        $articulosCarrito = [];
        $cantidadEnCarrito = 0;
        $totalCarrito = 0;

        foreach ($carrito as $id => $cantidad) {
            $idProducto = filter_var($id, FILTER_VALIDATE_INT);
            $cantidad = filter_var($cantidad, FILTER_VALIDATE_INT);
            if (
                $idProducto === false || $idProducto < 1
                || $cantidad === false || $cantidad < 1
                || !isset($productosPorId[$idProducto])
            ) {
                unset($carrito[$id]);
                continue;
            }

            $producto = $productosPorId[$idProducto];
            $stock = max(0, (int) $producto['stock']);
            if ($stock === 0) {
                unset($carrito[$id]);
                continue;
            }

            $cantidad = min($cantidad, $stock);
            $carrito[$idProducto] = $cantidad;
            $subtotal = (float) $producto['precio'] * $cantidad;
            $articulosCarrito[] = [
                'producto' => $producto,
                'cantidad' => $cantidad,
                'subtotal' => $subtotal
            ];
            $cantidadEnCarrito += $cantidad;
            $totalCarrito += $subtotal;
        }
        $_SESSION['carrito'] = $carrito;

        $mensajes = [
            'agregado' => 'Producto agregado al carrito.',
            'sin_stock' => 'Este producto no tiene existencias disponibles.',
            'limite_stock' => 'Ya agregaste todas las unidades disponibles.',
            'quitado' => 'Producto quitado del carrito.',
            'vaciado' => 'El carrito está vacío.',
            'no_disponible' => 'El producto ya no está disponible.',
            'accion_invalida' => 'No se pudo completar la acción del carrito.'
        ];
        $mensaje = $error !== ''
            ? $error
            : ($mensajes[$_GET['carrito'] ?? ''] ?? '');

        require __DIR__ . '/../views/tienda/index.php';
    }

    public function procesarCarrito() {
        $accion = $_POST['carrito_accion'] ?? '';
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $carrito = is_array($_SESSION['carrito'] ?? null) ? $_SESSION['carrito'] : [];

        if ($accion === 'vaciar') {
            $_SESSION['carrito'] = [];
            $this->redirigir('vaciado');
        }

        if ($accion === 'quitar') {
            if ($id === false || $id === null || $id < 1 || !isset($carrito[$id])) {
                $this->redirigir('accion_invalida');
            }
            unset($carrito[$id]);
            $_SESSION['carrito'] = $carrito;
            $this->redirigir('quitado');
        }

        if ($accion !== 'agregar' || $id === false || $id === null || $id < 1) {
            $this->redirigir('accion_invalida');
        }

        $producto = $this->model->getById($id);
        if (!$producto || isset($producto['error'])) {
            if (isset($producto['error'])) {
                error_log($producto['error']);
            }
            $this->redirigir('no_disponible');
        }

        $stock = max(0, (int) $producto['stock']);
        if ($stock === 0) {
            $this->redirigir('sin_stock');
        }

        $cantidadActual = filter_var($carrito[$id] ?? 0, FILTER_VALIDATE_INT);
        $cantidadActual = $cantidadActual === false ? 0 : max(0, $cantidadActual);
        if ($cantidadActual >= $stock) {
            $this->redirigir('limite_stock');
        }

        $carrito[$id] = $cantidadActual + 1;
        $_SESSION['carrito'] = $carrito;
        $this->redirigir('agregado');
    }

    private function redirigir($resultado) {
        header('Location: ' . APP_BASE_PATH . '/?carrito=' . $resultado);
        exit();
    }
}

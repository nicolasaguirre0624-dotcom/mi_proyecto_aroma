<?php

class JsonController {
    public function mostrar() {
        $comandos = $this->obtenerComandos();

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(
            $comandos,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR
        );
        exit();
    }

    public function mostrarVista() {
        $comandos = $this->obtenerComandos();

        header('Content-Type: text/html; charset=utf-8');
        require __DIR__ . '/../views/api/index.php';
        exit();
    }

    public function productos() {
        $this->listarModelo('Producto');
    }

    public function clientes() {
        $this->listarModelo('Cliente');
    }

    public function proveedores() {
        $this->listarModelo('Proveedor');
    }

    public function ciudades() {
        $this->listarModelo('Ciudad');
    }

    public function categorias() {
        $this->listarModelo('Categoria');
    }

    public function compras() {
        $this->listarModelo('Compra');
    }

    public function tiposProducto() {
        $this->listarModelo('TipoProducto');
    }

    private function listarModelo($claseModelo) {
        require_once __DIR__ . '/../models/' . $claseModelo . '.php';

        $nivelBufferInicial = ob_get_level();
        ob_start();
        $success = false;
        $result = null;
        $message = 'No se pudieron cargar los datos.';

        try {
            $modelo = new $claseModelo();
            $datos = $modelo->getAll();
            $salidaModelo = ob_get_clean();

            if ($salidaModelo !== '') {
                error_log(trim($salidaModelo));
            }
            if (isset($datos['error'])) {
                error_log($datos['error']);
            }

            if ($salidaModelo === '' && is_array($datos) && !isset($datos['error'])) {
                $success = true;
                $result = $datos;
                $message = 'Datos consultados correctamente.';
            } else {
                http_response_code(500);
            }
        } catch (PDOException $error) {
            if (ob_get_level() > $nivelBufferInicial) {
                ob_end_clean();
            }
            error_log('Error al consultar el modelo ' . $claseModelo . ': ' . $error->getMessage());
            http_response_code(500);
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => $success,
            'result' => $result,
            'message' => $message
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
        exit();
    }

    private function obtenerComandos() {
        $rutas = require __DIR__ . '/../../rutas/web.php';
        $comandos = [];

        foreach ($rutas as $metodo => $rutasDelMetodo) {
            foreach ($rutasDelMetodo as $ruta => $controlador) {
                $comandos[] = [
                    'metodo' => $metodo,
                    'ruta' => $ruta,
                    'controlador' => $controlador[0],
                    'accion' => $controlador[1]
                ];
            }
        }

        return $comandos;
    }
}

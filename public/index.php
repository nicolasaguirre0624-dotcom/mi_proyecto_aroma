<?php

session_start();

$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
define('APP_BASE_PATH', $basePath);
$scriptDirectory = basename(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])));
$publicBasePath = $scriptDirectory === 'public' ? $basePath : $basePath . '/public';
define('APP_PUBLIC_PATH', $publicBasePath);

$env = parse_ini_file(__DIR__ . '/../.env');
$loginUser = $env['LOGIN_USER'] ?? 'admin';
$loginPassword = $env['LOGIN_PASSWORD'] ?? 'admin123';

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = is_string($uri) ? $uri : '/';
if (
    $basePath !== ''
    && ($uri === $basePath || str_starts_with($uri, $basePath . '/'))
) {
    $uri = substr($uri, strlen($basePath)) ?: '/';
}
$action = $_GET['action'] ?? '';

if ($uri === '/logout') {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
    header('Location: ' . APP_BASE_PATH . '/login');
    exit();
}

if ($uri === '/login') {
    if (!empty($_SESSION['usuario'])) {
        header('Location: ' . APP_BASE_PATH . '/productos');
        exit();
    }

    $error = '';
    if ($method === 'POST' && $action === 'ingresar') {
        $usuario = trim($_POST['usuario'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($usuario === $loginUser && $password === $loginPassword) {
            session_regenerate_id(true);
            $_SESSION['usuario'] = $usuario;
            header('Location: ' . APP_BASE_PATH . '/productos');
            exit();
        }

        $error = 'Usuario o contraseña incorrectos.';
    }

    require_once __DIR__ . '/../app/views/auth/login.php';
    exit();
}

class JsonResponse {
    public static function send($success, $result, $message) {
        http_response_code($success ? 200 : 400);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => (bool) $success,
            'result' => $result,
            'message' => $message
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit();
    }
}

require_once __DIR__ . '/../app/controllers/ProductoController.php';
require_once __DIR__ . '/../app/controllers/ClientesController.php';
require_once __DIR__ . '/../app/controllers/ProveedorController.php';
require_once __DIR__ . '/../app/controllers/CiudadController.php';
require_once __DIR__ . '/../app/controllers/CategoriaController.php';
require_once __DIR__ . '/../app/controllers/CompraController.php';
require_once __DIR__ . '/../app/controllers/TiendaController.php';
require_once __DIR__ . '/../app/controllers/JsonController.php';

$rutas = require __DIR__ . '/../rutas/web.php';
$rutaSolicitada = rtrim($uri, '/') ?: '/';
if ($action !== '') {
    $rutaSolicitada = rtrim($rutaSolicitada, '/') . '/' . $action;
}

$rutasDelMetodo = $rutas[$method] ?? [];
$ruta = $rutasDelMetodo[$rutaSolicitada] ?? null;
if ($ruta !== null) {
    [$nombreControlador, $metodoControlador] = $ruta;
    $controlador = new $nombreControlador();
    if ($method !== 'GET' || $metodoControlador !== 'index') {
        $controlador->$metodoControlador();
    }
}

require __DIR__ . '/../app/views/layout.php';

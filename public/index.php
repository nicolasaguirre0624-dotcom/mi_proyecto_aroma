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

require_once __DIR__ . '/../app/controllers/ProductoController.php';
require_once __DIR__ . '/../app/controllers/ClientesController.php';
require_once __DIR__ . '/../app/controllers/ProveedorController.php';
require_once __DIR__ . '/../app/controllers/CiudadController.php';
require_once __DIR__ . '/../app/controllers/CategoriaController.php';
require_once __DIR__ . '/../app/controllers/CompraController.php';
require_once __DIR__ . '/../app/controllers/TiendaController.php';

$controllers = [
    '/' => new TiendaController(),
    '/productos' => new ProductoController(),
    '/clientes' => new ClientesController(),
    '/proveedores' => new ProveedorController(),
    '/ciudades' => new CiudadController(),
    '/categorias' => new CategoriaController(),
    '/compras' => new CompraController()
];

if ($uri === '/' && $method === 'POST') {
    $controllers['/']->procesarCarrito();
}

if (isset($controllers[$uri])) {
    $controller = $controllers[$uri];
    if ($method === 'POST' && in_array($action, ['crear', 'actualizar', 'eliminar'], true)) {
        $controller->$action();
    }
    if ($method === 'GET' && $action === 'editar') {
        $controller->editar();
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aroma</title>
    <style>
        :root {
            color-scheme: light;
            --color-primary: #48634f;
            --color-primary-dark: #354b3b;
            --color-accent: #b7794b;
            --color-background: #f5f4ef;
            --color-surface: #ffffff;
            --color-border: #dedfd7;
            --color-text: #30352f;
            --color-muted: #70776f;
        }

        * {
            box-sizing: border-box;
        }

        body {
            max-width: 1180px;
            margin: 0 auto;
            padding: 100px 32px 48px;
            background: var(--color-background);
            color: var(--color-text);
            font-family: "Segoe UI", Arial, sans-serif;
            line-height: 1.5;
        }

        .site-header {
            position: fixed;
            z-index: 1000;
            top: 0;
            right: 0;
            left: 0;
            display: flex;
            align-items: center;
            min-height: 72px;
            padding: 0 18px;
            background: #102a43;
            box-shadow: 0 3px 12px rgb(16 42 67 / 20%);
        }

        .site-header-inner {
            width: 100%;
            max-width: 1180px;
            margin: 0 auto;
        }

        .brand-link {
            display: inline-flex;
            align-items: center;
            gap: 11px;
            color: #fff;
            text-decoration: none;
        }

        .brand-mark {
            display: grid;
            width: 44px;
            height: 44px;
            place-items: center;
            border-radius: 12px;
            background: #e2b544;
            color: #102a43;
            font-size: 1.25rem;
            font-weight: 700;
        }

        .brand-name {
            font-size: 1.45rem;
            font-weight: 750;
            letter-spacing: -0.04em;
        }

        .brand-caption {
            color: #d7e0e8;
            font-size: 0.78rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        nav {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 0 0 30px;
            padding: 12px;
            border: 1px solid var(--color-border);
            border-radius: 12px;
            background: var(--color-surface);
        }

        nav a {
            display: inline-block;
            padding: 9px 13px;
            border-radius: 7px;
            color: var(--color-primary-dark);
            text-decoration: none;
            font-size: 0.94rem;
            font-weight: 600;
            transition: background-color 0.15s ease, color 0.15s ease;
        }

        nav a.session-link {
            margin-left: auto;
            background: var(--color-primary);
            color: #fff;
        }

        nav a.session-link:hover,
        nav a.session-link:focus-visible {
            background: var(--color-primary-dark);
            color: #fff;
        }

        nav a:hover,
        nav a:focus-visible {
            background: var(--color-primary);
            color: #fff;
        }

        body > h1 {
            margin: 0 0 22px;
            color: var(--color-primary-dark);
            font-size: clamp(1.8rem, 4vw, 2.4rem);
            letter-spacing: -0.04em;
        }

        h1,
        h2 {
            line-height: 1.2;
        }

        h2 {
            margin: 26px 0 14px;
            color: var(--color-primary-dark);
            font-size: 1.3rem;
        }

        form:not([style]) {
            display: flex;
            flex-wrap: wrap;
            align-items: end;
            gap: 14px;
            margin: 0 0 28px;
            padding: 20px;
            border: 1px solid var(--color-border);
            border-radius: 12px;
            background: var(--color-surface);
            box-shadow: 0 3px 12px rgb(39 48 39 / 5%);
        }

        form:not([style]) p {
            flex: 1 1 220px;
            min-width: 0;
            margin: 0;
        }

        form:not([style]) label {
            display: flex;
            flex: 1 1 170px;
            flex-direction: column;
            gap: 6px;
            color: var(--color-muted);
            font-size: 0.9rem;
            font-weight: 600;
        }

        input,
        select,
        textarea {
            min-height: 40px;
            padding: 9px 11px;
            border: 1px solid #cdd1c8;
            border-radius: 7px;
            background: #fff;
            color: var(--color-text);
            font: inherit;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--color-primary);
            outline: 3px solid rgb(72 99 79 / 15%);
        }

        button {
            min-height: 40px;
            padding: 9px 15px;
            border: 0;
            border-radius: 7px;
            background: var(--color-primary);
            color: #fff;
            font: inherit;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.15s ease, transform 0.15s ease;
        }

        button:hover {
            background: var(--color-primary-dark);
        }

        button:active {
            transform: translateY(1px);
        }

        form[action*="eliminar"] button {
            min-height: 32px;
            padding: 6px 10px;
            background: #a64c42;
            font-size: 0.88rem;
        }

        form[action*="eliminar"] button:hover {
            background: #873a32;
        }

        table {
            width: 100%;
            margin: 0 0 24px;
            overflow: hidden;
            border: 1px solid var(--color-border);
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 10px;
            background: var(--color-surface);
            box-shadow: 0 3px 12px rgb(39 48 39 / 5%);
        }

        .table-tools {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 0 0 10px;
        }

        .table-tools label {
            display: flex;
            flex: 1 1 240px;
            align-items: center;
            gap: 10px;
            color: var(--color-muted);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .table-tools input {
            width: min(100%, 320px);
        }

        .table-tools output {
            color: var(--color-muted);
            font-size: 0.88rem;
        }

        th,
        td {
            padding: 12px 14px;
            border-bottom: 1px solid #e8e9e3;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background: #edf0e9;
            color: var(--color-primary-dark);
            font-size: 0.88rem;
            font-weight: 700;
        }

        tbody tr:last-child td,
        table tr:last-child td {
            border-bottom: 0;
        }

        tbody tr:hover,
        table tr:hover {
            background: #fafbf8;
        }

        td a {
            margin-right: 8px;
            color: var(--color-primary);
            font-weight: 600;
            text-decoration: none;
        }

        td a:hover {
            color: var(--color-accent);
            text-decoration: underline;
        }

        .store-intro {
            margin: 0 0 24px;
            padding: 28px 32px;
            border-radius: 14px;
            background: linear-gradient(120deg, #354b3b, #58745e);
            color: #fff;
        }

        .store-intro .eyebrow {
            margin: 0 0 8px;
            color: #e2c5a5;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.12em;
        }

        .store-intro h1 {
            margin: 0 0 10px;
            color: #fff;
            font-size: clamp(1.8rem, 4vw, 2.5rem);
        }

        .store-intro p:last-child {
            margin: 0;
            color: #edf1ec;
        }

        .store-message {
            margin: 0 0 20px;
            padding: 12px 16px;
            border: 1px solid #c9d8c8;
            border-radius: 8px;
            background: #edf5ec;
            color: var(--color-primary-dark);
        }

        .store-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 310px;
            align-items: start;
            gap: 22px;
        }

        .store-products {
            min-width: 0;
        }

        .store-section-heading {
            display: flex;
            flex-wrap: wrap;
            align-items: end;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 16px;
        }

        .carousel-controls {
            display: flex;
            gap: 8px;
            margin-left: auto;
        }

        .carousel-control {
            display: grid;
            width: 40px;
            min-height: 40px;
            padding: 0;
            place-items: center;
            border: 1px solid var(--color-border);
            background: var(--color-surface);
            color: var(--color-primary-dark);
            font-size: 1.25rem;
        }

        .carousel-control:hover:not(:disabled) {
            background: var(--color-primary);
            color: #fff;
        }

        .carousel-control:disabled {
            opacity: 0.45;
            cursor: not-allowed;
        }

        .store-section-heading h2 {
            margin: 0 0 4px;
        }

        .store-section-heading p {
            margin: 0;
            color: var(--color-muted);
            font-size: 0.9rem;
        }

        .product-search {
            display: grid;
            gap: 5px;
            color: var(--color-muted);
            font-size: 0.88rem;
            font-weight: 600;
        }

        .product-search input {
            width: min(100%, 260px);
        }

        .product-grid {
            display: flex;
            gap: 16px;
            min-width: 0;
            overflow-x: auto;
            padding: 2px 2px 14px;
            scroll-behavior: smooth;
            scroll-snap-type: x mandatory;
            scrollbar-width: none;
            overscroll-behavior-x: contain;
        }

        .product-grid::-webkit-scrollbar {
            display: none;
        }

        .product-card {
            display: flex;
            flex: 0 0 calc((100% - 16px) / 2);
            min-width: 0;
            flex-direction: column;
            padding: 20px;
            border: 1px solid var(--color-border);
            border-radius: 12px;
            background: var(--color-surface);
            box-shadow: 0 3px 12px rgb(39 48 39 / 5%);
            scroll-snap-align: start;
        }

        .product-art {
            position: relative;
            display: grid;
            min-height: 180px;
            margin: -20px -20px 16px;
            overflow: hidden;
            place-items: center;
            border-radius: 12px 12px 0 0;
            background: linear-gradient(145deg, var(--art-light), var(--art-dark));
            color: var(--art-accent);
        }

        .product-art svg {
            width: 145px;
            height: 155px;
            filter: drop-shadow(0 8px 8px rgb(39 48 39 / 18%));
        }

        .product-art span {
            position: absolute;
            top: 50%;
            left: 50%;
            color: var(--art-label);
            font-size: 0.62rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            transform: translate(-50%, 10px);
        }

        .product-photo-frame {
            display: flex;
            width: calc(100% + 40px);
            height: 195px;
            flex-direction: column;
            justify-content: space-between;
            margin: -20px -20px 16px;
            overflow: hidden;
            border-radius: 12px 12px 0 0;
            background: #f8f8f6;
        }

        .product-photo {
            display: block;
            width: 100%;
            min-height: 0;
            flex: 1;
            padding: 8px;
            object-fit: contain;
        }

        .image-credits {
            margin-top: 24px;
            padding-top: 12px;
            border-top: 1px solid var(--color-border);
            color: var(--color-muted);
            font-size: 0.8rem;
        }

        .image-credits summary {
            cursor: pointer;
            font-weight: 600;
        }

        .image-credits ul {
            margin: 8px 0 0;
            padding-left: 20px;
        }

        .image-credits a {
            color: var(--color-primary-dark);
            text-decoration: underline;
        }

        .product-art--0 {
            --art-light: #f1e4d1;
            --art-dark: #d3b99a;
            --art-accent: #bb8b52;
            --art-label: #7a5735;
        }

        .product-art--1 {
            --art-light: #f3e3e5;
            --art-dark: #d9b8c0;
            --art-accent: #a96879;
            --art-label: #804653;
        }

        .product-art--2 {
            --art-light: #e2e9df;
            --art-dark: #b7c8b3;
            --art-accent: #6a866c;
            --art-label: #405d45;
        }

        .product-art--3 {
            --art-light: #e2e8ef;
            --art-dark: #b2c2d1;
            --art-accent: #6684a0;
            --art-label: #3e5b75;
        }

        .product-art--4 {
            --art-light: #e9e3f0;
            --art-dark: #c8b9d8;
            --art-accent: #8c71a4;
            --art-label: #5d4772;
        }

        .art-shadow {
            fill: rgb(48 53 47 / 15%);
        }

        .art-cap {
            fill: var(--art-accent);
        }

        .art-neck,
        .art-bottle {
            fill: rgb(255 255 255 / 68%);
            stroke: var(--art-accent);
            stroke-width: 3;
        }

        .art-shine {
            fill: rgb(255 255 255 / 54%);
        }

        .art-label {
            fill: rgb(255 255 255 / 78%);
            stroke: var(--art-accent);
            stroke-width: 1.5;
        }

        .art-label-line {
            fill: none;
            stroke: var(--art-accent);
            stroke-linecap: round;
            stroke-width: 1.5;
            opacity: 0.7;
        }

        .art-sparkle {
            fill: var(--art-accent);
            stroke: var(--art-accent);
            stroke-linecap: round;
            stroke-width: 2;
        }

        .product-card[hidden] {
            display: none;
        }

        .product-category {
            align-self: flex-start;
            padding: 4px 9px;
            border-radius: 999px;
            background: #edf0e9;
            color: var(--color-primary-dark);
            font-size: 0.77rem;
            font-weight: 700;
        }

        .product-card h2 {
            margin: 14px 0 8px;
            font-size: 1.08rem;
        }

        .product-price {
            margin: 0;
            color: var(--color-primary-dark);
            font-size: 1.25rem;
            font-weight: 700;
        }

        .product-stock {
            margin: 8px 0 0;
            color: var(--color-muted);
            font-size: 0.88rem;
        }

        .product-card form:not([style]),
        .cart-item form:not([style]),
        .cart-panel form:not([style]) {
            display: block;
            margin: 16px 0 0;
            padding: 0;
            border: 0;
            border-radius: 0;
            background: transparent;
            box-shadow: none;
        }

        .product-card button {
            width: 100%;
        }

        .product-card button:disabled {
            background: #a3aaa1;
            cursor: not-allowed;
        }

        .cart-panel {
            position: sticky;
            top: 18px;
            padding: 20px;
            border: 1px solid var(--color-border);
            border-radius: 12px;
            background: var(--color-surface);
            box-shadow: 0 3px 12px rgb(39 48 39 / 5%);
        }

        .cart-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding-bottom: 14px;
            border-bottom: 1px solid #e8e9e3;
        }

        .cart-heading h2 {
            margin: 0;
        }

        .cart-count {
            display: grid;
            min-width: 30px;
            min-height: 30px;
            place-items: center;
            border-radius: 50%;
            background: #edf0e9;
            color: var(--color-primary-dark);
            font-weight: 700;
        }

        .cart-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .cart-item {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 8px;
            padding: 14px 0;
            border-bottom: 1px solid #e8e9e3;
        }

        .cart-item > div {
            display: grid;
            gap: 3px;
        }

        .cart-item strong {
            font-size: 0.92rem;
        }

        .cart-item span {
            color: var(--color-muted);
            font-size: 0.84rem;
        }

        .cart-item .cart-subtotal {
            color: var(--color-text);
            font-weight: 700;
        }

        .cart-item form {
            flex: 0 0 auto;
        }

        .cart-item .remove-item {
            min-height: 32px;
            padding: 5px 8px;
            background: #a64c42;
            font-size: 0.8rem;
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            padding: 16px 0 4px;
        }

        .cart-total strong {
            color: var(--color-primary-dark);
        }

        .cart-panel .clear-cart {
            width: 100%;
            border: 1px solid var(--color-border);
            background: #fff;
            color: var(--color-text);
        }

        .cart-panel .clear-cart:hover {
            background: var(--color-background);
        }

        .cart-empty,
        .cart-hint,
        .store-empty {
            color: var(--color-muted);
        }

        .cart-empty {
            margin-bottom: 4px;
        }

        .cart-hint {
            margin-top: 0;
            font-size: 0.88rem;
        }

        .store-empty {
            flex: 0 0 100%;
            padding: 20px;
            border: 1px dashed var(--color-border);
            border-radius: 10px;
            text-align: center;
        }

        @media (max-width: 700px) {
            body {
                padding: 94px 14px 32px;
            }

            .store-layout {
                grid-template-columns: 1fr;
            }

            .cart-panel {
                position: static;
                grid-row: 1;
            }

            .product-card {
                flex-basis: 100%;
            }

            .store-intro {
                padding: 24px 20px;
            }

            nav {
                gap: 4px;
                margin-bottom: 22px;
                padding: 8px;
            }

            nav a {
                padding: 8px 10px;
                font-size: 0.88rem;
            }

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            th,
            td {
                padding: 10px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .product-grid {
                scroll-behavior: auto;
            }
        }
    </style>
</head>

<body>

    <header class="site-header">
        <div class="site-header-inner">
            <a class="brand-link" href="<?= APP_BASE_PATH ?>/">
                <span class="brand-mark" aria-hidden="true">A</span>
                <span>
                    <span class="brand-name">Aroma</span><br>
                    <span class="brand-caption">Perfumería</span>
                </span>
            </a>
        </div>
    </header>

    <nav>
        <a href="<?= APP_BASE_PATH ?>/">Inicio</a>
        <a href="<?= APP_BASE_PATH ?>/#carrito">Carrito</a>
        <a href="<?= APP_BASE_PATH ?>/productos">Productos</a>
        <a href="<?= APP_BASE_PATH ?>/clientes">Clientes</a>
        <a href="<?= APP_BASE_PATH ?>/proveedores">Proveedores</a>
        <a href="<?= APP_BASE_PATH ?>/ciudades">Ciudades</a>
        <a href="<?= APP_BASE_PATH ?>/categorias">Categorías</a>
        <a href="<?= APP_BASE_PATH ?>/compras">Compras</a>
        <?php if (!empty($_SESSION['usuario'])): ?>
            <a class="session-link" href="<?= APP_BASE_PATH ?>/logout">Cerrar sesión</a>
        <?php else: ?>
            <a class="session-link" href="<?= APP_BASE_PATH ?>/login">Iniciar sesión</a>
        <?php endif; ?>
    </nav>

    <?php if ($uri !== '/'): ?>
        <h1>Aroma</h1>
    <?php endif; ?>

    <?php

    if ($method === 'GET') {
        if (isset($controllers[$uri])) {
            $controllers[$uri]->index();
        }
    }

    ?>

    <script>
        (function () {
            function normalizeText(value) {
                return value
                    .toLocaleLowerCase('es')
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '');
            }

            document.querySelectorAll('table').forEach(function (table) {
                var body = table.tBodies[0];
                if (!body) {
                    return;
                }

                var rows = Array.prototype.slice.call(body.rows).filter(function (row) {
                    return !(row.cells.length === 1 && row.cells[0].colSpan > 1);
                });
                var tools = document.createElement('div');
                tools.className = 'table-tools';

                var label = document.createElement('label');
                label.appendChild(document.createTextNode('Buscar'));

                var search = document.createElement('input');
                search.type = 'search';
                search.placeholder = 'Escribe para filtrar...';
                search.setAttribute('aria-label', 'Buscar en esta tabla');
                label.appendChild(search);
                tools.appendChild(label);

                var count = document.createElement('output');
                count.setAttribute('aria-live', 'polite');
                tools.appendChild(count);

                table.parentNode.insertBefore(tools, table);

                var emptyRow = body.insertRow();
                emptyRow.hidden = true;
                var emptyCell = emptyRow.insertCell();
                emptyCell.colSpan = table.tHead && table.tHead.rows.length
                    ? table.tHead.rows[0].cells.length
                    : 1;
                emptyCell.textContent = 'No hay resultados que coincidan.';

                function filterRows() {
                    var query = normalizeText(search.value.trim());
                    var visibleCount = 0;

                    rows.forEach(function (row) {
                        var matches = normalizeText(row.textContent).indexOf(query) !== -1;
                        row.hidden = !matches;
                        if (matches) {
                            visibleCount += 1;
                        }
                    });

                    emptyRow.hidden = visibleCount > 0;
                    count.textContent = visibleCount
                        + (visibleCount === 1 ? ' registro' : ' registros');
                }

                search.addEventListener('input', filterRows);
                filterRows();
            });

            var productSearch = document.getElementById('product-search');
            var productGrid = document.getElementById('product-grid');
            if (productGrid) {
                var productCards = Array.prototype.slice.call(
                    document.querySelectorAll('[data-product-card]')
                );
                var noProductResults = document.getElementById('no-product-results');
                var previousButton = document.getElementById('carousel-previous');
                var nextButton = document.getElementById('carousel-next');
                var carouselRegion = productGrid.closest('.store-products');
                var prefersReducedMotion = window.matchMedia(
                    '(prefers-reduced-motion: reduce)'
                ).matches;
                var carouselTimer = null;

                function updateCarouselControls() {
                    var canScroll = productGrid.scrollWidth > productGrid.clientWidth + 1;
                    previousButton.disabled = !canScroll;
                    nextButton.disabled = !canScroll;
                }

                function moveCarousel(direction) {
                    var maxScroll = productGrid.scrollWidth - productGrid.clientWidth;
                    if (maxScroll <= 1) {
                        return;
                    }

                    var firstVisibleCard = productCards.find(function (card) {
                        return !card.hidden;
                    });
                    var styles = window.getComputedStyle(productGrid);
                    var gap = parseFloat(styles.columnGap || styles.gap) || 16;
                    var step = firstVisibleCard
                        ? firstVisibleCard.getBoundingClientRect().width + gap
                        : productGrid.clientWidth;
                    var target = productGrid.scrollLeft + step * direction;

                    if (direction > 0 && target > maxScroll + 2) {
                        target = 0;
                    } else if (direction < 0 && target < -2) {
                        target = maxScroll;
                    } else {
                        target = Math.max(0, Math.min(target, maxScroll));
                    }

                    productGrid.scrollTo({
                        left: target,
                        behavior: prefersReducedMotion ? 'auto' : 'smooth'
                    });
                }

                function stopCarousel() {
                    if (carouselTimer !== null) {
                        window.clearInterval(carouselTimer);
                        carouselTimer = null;
                    }
                }

                function startCarousel() {
                    if (
                        prefersReducedMotion
                        || document.hidden
                        || carouselTimer !== null
                        || productCards.length < 2
                    ) {
                        return;
                    }

                    carouselTimer = window.setInterval(function () {
                        moveCarousel(1);
                    }, 4500);
                }

                previousButton.addEventListener('click', function () {
                    moveCarousel(-1);
                });
                nextButton.addEventListener('click', function () {
                    moveCarousel(1);
                });

                if (carouselRegion) {
                    carouselRegion.addEventListener('mouseenter', stopCarousel);
                    carouselRegion.addEventListener('mouseleave', startCarousel);
                    carouselRegion.addEventListener('focusin', stopCarousel);
                    carouselRegion.addEventListener('focusout', function (event) {
                        if (!carouselRegion.contains(event.relatedTarget)) {
                            startCarousel();
                        }
                    });
                }

                document.addEventListener('visibilitychange', function () {
                    if (document.hidden) {
                        stopCarousel();
                    } else {
                        startCarousel();
                    }
                });
                window.addEventListener('resize', updateCarouselControls);

                if (productSearch) {
                    productSearch.addEventListener('input', function () {
                        var query = normalizeText(productSearch.value.trim());
                        var visibleCount = 0;

                        productCards.forEach(function (card) {
                            var matches = normalizeText(card.textContent).indexOf(query) !== -1;
                            card.hidden = !matches;
                            if (matches) {
                                visibleCount += 1;
                            }
                        });

                        noProductResults.hidden = visibleCount > 0 || productCards.length === 0;
                        productGrid.scrollTo({
                            left: 0,
                            behavior: prefersReducedMotion ? 'auto' : 'smooth'
                        });
                        updateCarouselControls();
                    });
                }

                updateCarouselControls();
                startCarousel();
            }

            document.addEventListener('submit', function (event) {
                var form = event.target;
                if (
                    form instanceof HTMLFormElement
                    && form.action.indexOf('action=eliminar') !== -1
                    && !window.confirm('¿Seguro que deseas eliminar este registro? Esta acción no se puede deshacer.')
                ) {
                    event.preventDefault();
                }
            });
        }());
    </script>
</body>

</html>

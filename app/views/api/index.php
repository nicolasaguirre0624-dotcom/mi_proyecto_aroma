<?php
if (!defined('APP_BASE_PATH') || !isset($comandos) || !is_array($comandos)) {
    http_response_code(404);
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>API de Aroma</title>
    <style>

    </style>
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="<?= htmlspecialchars(APP_BASE_PATH . '/', ENT_QUOTES, 'UTF-8') ?>">Aroma · API</a>
            <a class="json-link" href="<?= htmlspecialchars(APP_BASE_PATH . '/json', ENT_QUOTES, 'UTF-8') ?>">Ver JSON</a>
        </div>
    </header>

    <main>
        <section class="hero">
            <p class="eyebrow">Documentación de la API</p>
            <h1>Rutas disponibles</h1>
            <p class="hero-description">Consulta los métodos, las rutas y las acciones disponibles en Aroma. La respuesta JSON completa está disponible en /json.</p>
            <a class="hero-link" href="<?= htmlspecialchars(APP_BASE_PATH . '/json', ENT_QUOTES, 'UTF-8') ?>">Abrir respuesta JSON</a>
        </section>

        <section aria-labelledby="endpoints-heading">
            <div class="section-heading">
                <h2 id="endpoints-heading">Endpoints</h2>
                <span class="route-count"><?= count($comandos) ?> rutas registradas</span>
            </div>

            <div class="endpoint-list">
                <?php foreach ($comandos as $comando): ?>
                    <?php $metodo = strtolower($comando['metodo']); ?>
                    <article class="endpoint">
                        <span class="method method--<?= htmlspecialchars($metodo, ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($comando['metodo'], ENT_QUOTES, 'UTF-8') ?>
                        </span>
                        <?php if ($comando['metodo'] === 'GET' && strpos($comando['ruta'], '/api/') === 0): ?>
                            <a class="endpoint-path" href="<?= htmlspecialchars(APP_BASE_PATH . $comando['ruta'], ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars($comando['ruta'], ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        <?php else: ?>
                            <code class="endpoint-path"><?= htmlspecialchars($comando['ruta'], ENT_QUOTES, 'UTF-8') ?></code>
                        <?php endif; ?>
                        <span class="endpoint-target">
                            <?= htmlspecialchars($comando['controlador'], ENT_QUOTES, 'UTF-8') ?> ·
                            <code><?= htmlspecialchars($comando['accion'], ENT_QUOTES, 'UTF-8') ?></code>
                        </span>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</body>
</html>

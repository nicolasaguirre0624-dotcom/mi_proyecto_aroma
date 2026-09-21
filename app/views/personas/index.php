<?php
require_once __DIR__ . '/../../Controllers/PersonaController.php';

$controller = new PersonaController();

if (isset($_GET['action']) && $_GET['action'] === 'eliminar' && isset($_GET['id'])) {
    $controller->eliminar();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'])) {
    $controller->guardar();
}

$personas = $controller->listar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Personas</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <script src="../../public/js/main.js" defer></script>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Lista de Personas</h1>
            <a href="crear.php" class="btn">Crear Nueva Persona</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($personas)): ?>
                        <?php foreach ($personas as $persona): ?>
                            <tr>
                                <td><?php echo $persona['id']; ?></td>
                                <td><?php echo $persona['nombre']; ?></td>
                                <td><?php echo $persona['correo']; ?></td>
                                <td class="actions">
                                    <a href="editar.php?id=<?php echo $persona['id']; ?>">Editar</a>
                                    <a href="index.php?action=eliminar&id=<?php echo $persona['id']; ?>" class="delete-link delete">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="empty-state">No hay registros encontrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Personas</title>
    <link rel="stylesheet" href="../../public/css/style.css"> <!-- Ajusta tu ruta de CSS -->
</head>
<body>
    <div class="container">
        <h1>Lista de Personas</h1>
        <a href="crear.php" class="btn btn-primary">Crear Nueva Persona</a>
        
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
                        <td>
                            <a href="editar.php?id=<?php echo $persona['id']; ?>">Editar</a>
                            <a href="eliminar.php?id=<?php echo $persona['id']; ?>" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No hay registros encontrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
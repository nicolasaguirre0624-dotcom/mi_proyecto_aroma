<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Persona</title>
</head>
<body>
    <div class="container">
        <h1>Registrar Nueva Persona</h1>
        <form action="../../controllers/PersonaController.php?action=guardar" method="POST">
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div>
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" required>
            </div>
            <button type="submit">Guardar</button>
            <a href="index.php">Cancelar</a>
        </form>
    </div>
</body>
</html>
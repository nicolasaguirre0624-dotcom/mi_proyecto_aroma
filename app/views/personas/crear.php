<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Persona</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <script src="../../public/js/main.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Registrar Nueva Persona</h1>
        <form action="index.php?action=guardar" method="POST" class="form-grid">
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div>
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" required>
            </div>
            <div>
                <button type="submit">Guardar</button>
                <a href="index.php" class="btn secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
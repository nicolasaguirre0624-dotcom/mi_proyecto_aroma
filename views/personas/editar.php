<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Persona</title>
</head>
<body>
    <div class="container">
        <h1>Editar Persona</h1>
        <form action="../../controllers/PersonaController.php?action=actualizar" method="POST">
           
            <input type="hidden" name="id" value="<?php echo $persona['id'] ?? ''; ?>">
            
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $persona['nombre'] ?? ''; ?>" required>
            </div>
            <div>
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" value="<?php echo $persona['correo'] ?? ''; ?>" required>
            </div>
            <button type="submit">Actualizar</button>
            <a href="index.php">Cancelar</a>
        </form>
    </div>
</body>
</html>
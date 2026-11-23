<h1>Editar categoría #<?= (int) $categoria['id'] ?></h1>
<form action="<?= APP_BASE_PATH ?>/categorias?action=actualizar" method="POST">
    <input type="hidden" name="id" value="<?= (int) $categoria['id'] ?>">
    <p>
        <label for="nombre">Nombre</label>
        <input id="nombre" name="nombre" type="text" required value="<?= htmlspecialchars($categoria['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </p>
    <p>
        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion"><?= htmlspecialchars($categoria['descripcion'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
    </p>
    <button type="submit">Actualizar categoría</button>
    <a href="<?= APP_BASE_PATH ?>/categorias">Cancelar</a>
</form>

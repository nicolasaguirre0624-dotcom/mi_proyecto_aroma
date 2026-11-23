<h1>Editar ciudad #<?= (int) $ciudad['id'] ?></h1>
<form action="<?= APP_BASE_PATH ?>/ciudades?action=actualizar" method="POST">
    <input type="hidden" name="id" value="<?= (int) $ciudad['id'] ?>">
    <p>
        <label for="nombre">Nombre</label>
        <input id="nombre" name="nombre" type="text" required value="<?= htmlspecialchars($ciudad['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </p>
    <button type="submit">Actualizar ciudad</button>
    <a href="<?= APP_BASE_PATH ?>/ciudades">Cancelar</a>
</form>

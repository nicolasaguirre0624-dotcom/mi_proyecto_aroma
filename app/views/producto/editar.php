<h2>Editar producto</h2>
<form action="/aroma/public/productos?action=actualizar" method="POST">
    <input type="hidden" name="id" value="<?= (int) $producto['id'] ?>">

    <p>
        <label for="nombre">Nombre</label>
        <input id="nombre" name="nombre" type="text" required value="<?= htmlspecialchars($producto['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </p>
    <p>
        <label for="precio">Precio</label>
        <input id="precio" name="precio" type="number" min="0" step="0.01" required value="<?= htmlspecialchars($producto['precio'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </p>
    <p>
        <label for="stock">Stock</label>
        <input id="stock" name="stock" type="number" min="0" step="1" required value="<?= htmlspecialchars($producto['stock'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    </p>
    <p>
        <label for="id_proveedor">ID del proveedor</label>
        <input id="id_proveedor" name="id_proveedor" type="number" min="1" required value="<?= (int) ($producto['id_proveedor'] ?? 0) ?>">
    </p>
    <p>
        <label for="id_categoria">ID de la categoría</label>
        <input id="id_categoria" name="id_categoria" type="number" min="1" required value="<?= (int) ($producto['id_categoria'] ?? 0) ?>">
    </p>

    <button type="submit">Actualizar producto</button>
    <a href="/aroma/public/productos">Cancelar</a>
</form>

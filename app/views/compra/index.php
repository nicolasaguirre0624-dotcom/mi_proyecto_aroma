<h1>Listado de Compras</h1>
<?php if (!empty($mensaje)): ?>
    <p><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<h2>Crear compra</h2>
<form action="<?= APP_BASE_PATH ?>/compras?action=crear" method="POST">
    <label>ID del proveedor <input name="int_proveedor" type="number" min="1" required></label>
    <label>Fecha <input name="fechaCompra" type="date" value="<?= date('Y-m-d') ?>" required></label>
    <label>ID del tipo de pago <input name="idTipoPago" type="number" min="1" required></label>
    <label>IVA <input name="ivaCompra" type="number" min="0" step="0.01" required></label>
    <label>Valor total <input name="valorCompra" type="number" min="0" step="0.01" required></label>
    <button type="submit">Crear compra</button>
</form>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Proveedor</th>
            <th>Fecha</th>
            <th>ID tipo de pago</th>
            <th>IVA</th>
            <th>Valor total</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($compras as $compra): ?>
            <tr>
                <td><?= (int) $compra['idCompra'] ?></td>
                <td><?= htmlspecialchars($compra['nombre_proveedor'] ?? 'Proveedor #' . $compra['int_proveedor'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($compra['fechaCompra'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= (int) $compra['idTipoPago'] ?></td>
                <td><?= htmlspecialchars($compra['ivaCompra'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($compra['valorCompra'], ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <a href="<?= APP_BASE_PATH ?>/compras?action=editar&amp;id=<?= (int) $compra['idCompra'] ?>">Editar</a>
                    <form action="<?= APP_BASE_PATH ?>/compras?action=eliminar" method="POST" style="display:inline-block">
                        <input type="hidden" name="id" value="<?= (int) $compra['idCompra'] ?>">
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$compras): ?>
            <tr><td colspan="7">No hay compras para mostrar.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

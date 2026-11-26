<?php
if (!defined('APP_BASE_PATH') || !isset($compra) || !is_array($compra) || isset($compra['error'])) {
    http_response_code(404);
    exit();
}
?>
<h1>Editar compra #<?= (int) $compra['idCompra'] ?></h1>
<form action="<?= APP_BASE_PATH ?>/compras?action=actualizar" method="POST">
    <input type="hidden" name="id" value="<?= (int) $compra['idCompra'] ?>">
    <p>
        <label for="int_proveedor">ID del proveedor</label>
        <input id="int_proveedor" name="int_proveedor" type="number" min="1" required value="<?= (int) $compra['int_proveedor'] ?>">
    </p>
    <p>
        <label for="fechaCompra">Fecha</label>
        <input id="fechaCompra" name="fechaCompra" type="date" required value="<?= htmlspecialchars($compra['fechaCompra'], ENT_QUOTES, 'UTF-8') ?>">
    </p>
    <p>
        <label for="idTipoPago">ID del tipo de pago</label>
        <input id="idTipoPago" name="idTipoPago" type="number" min="1" required value="<?= (int) $compra['idTipoPago'] ?>">
    </p>
    <p>
        <label for="ivaCompra">IVA</label>
        <input id="ivaCompra" name="ivaCompra" type="number" min="0" step="0.01" required value="<?= htmlspecialchars($compra['ivaCompra'], ENT_QUOTES, 'UTF-8') ?>">
    </p>
    <p>
        <label for="valorCompra">Valor total</label>
        <input id="valorCompra" name="valorCompra" type="number" min="0" step="0.01" required value="<?= htmlspecialchars($compra['valorCompra'], ENT_QUOTES, 'UTF-8') ?>">
    </p>
    <button type="submit">Guardar cambios</button>
    <a href="<?= APP_BASE_PATH ?>/compras">Cancelar</a>
</form>

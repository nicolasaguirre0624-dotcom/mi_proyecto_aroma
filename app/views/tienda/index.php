<section class="store-intro">
    <p class="eyebrow">AROMA · PERFUMERÍA</p>
    <h1>Encuentra tu próxima fragancia</h1>
    <p>Explora nuestro catálogo y agrega tus productos favoritos al carrito.</p>
</section>

<?php if ($mensaje !== ''): ?>
    <p class="store-message" role="status"><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<div class="store-layout">
    <section class="store-products" aria-labelledby="products-heading">
        <div class="store-section-heading">
            <div>
                <h2 id="products-heading">Todos los productos</h2>
                <p><?= count($productos) ?> fragancias disponibles</p>
            </div>
            <label class="product-search">
                Buscar
                <input id="product-search" type="search" placeholder="Nombre o categoría" autocomplete="off">
            </label>
            <div class="carousel-controls" aria-label="Controles del carrusel">
                <button class="carousel-control" id="carousel-previous" type="button" aria-label="Perfumes anteriores">&larr;</button>
                <button class="carousel-control" id="carousel-next" type="button" aria-label="Siguientes perfumes">&rarr;</button>
            </div>
        </div>

        <div class="product-grid" id="product-grid" aria-label="Catálogo de perfumes" tabindex="0">
            <?php foreach ($productos as $indice => $producto): ?>
                <?php $stock = max(0, (int) $producto['stock']); ?>
                <article class="product-card" data-product-card>
                    <?php if (!empty($producto['image_url'])): ?>
                        <figure class="product-photo-frame">
                            <img
                                class="product-photo"
                                src="<?= htmlspecialchars($producto['image_url'], ENT_QUOTES, 'UTF-8') ?>"
                                alt="Foto del producto <?= htmlspecialchars($producto['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                loading="lazy"
                            >
                        </figure>
                    <?php else: ?>
                        <div class="product-art product-art--<?= $indice % 5 ?>" role="img" aria-label="Ilustración de un frasco de perfume">
                            <svg viewBox="0 0 180 190" aria-hidden="true" focusable="false">
                                <path class="art-shadow" d="M37 171h106l-12 9H49z" />
                                <rect class="art-cap" x="72" y="23" width="36" height="27" rx="5" />
                                <path class="art-neck" d="M76 49h28v18H76z" />
                                <path class="art-bottle" d="M61 65h58c12 0 21 9 21 21v67c0 10-8 18-18 18H58c-10 0-18-8-18-18V86c0-12 9-21 21-21z" />
                                <path class="art-shine" d="M56 89c0-8 6-14 14-14v75c0 6-4 10-10 10h-4z" />
                                <rect class="art-label" x="56" y="103" width="68" height="39" rx="4" />
                                <path class="art-label-line" d="M71 115h38M76 124h28M82 133h16" />
                                <circle class="art-sparkle" cx="139" cy="48" r="4" />
                                <path class="art-sparkle" d="M35 55v12m-6-6h12" />
                            </svg>
                            <span>AROMA</span>
                        </div>
                    <?php endif; ?>
                    <span class="product-category">
                        <?= htmlspecialchars($producto['nombre_categoria'] ?? 'Fragancia', ENT_QUOTES, 'UTF-8') ?>
                    </span>
                    <h2><?= htmlspecialchars($producto['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?></h2>
                    <p class="product-price">
                        $<?= number_format((float) $producto['precio'], 2, ',', '.') ?>
                    </p>
                    <p class="product-stock">
                        <?= $stock > 0 ? 'Disponibles: ' . $stock : 'Agotado' ?>
                    </p>
                    <form action="<?= APP_BASE_PATH ?>/" method="POST">
                        <input type="hidden" name="carrito_accion" value="agregar">
                        <input type="hidden" name="id" value="<?= (int) $producto['id'] ?>">
                        <button type="submit"<?= $stock === 0 ? ' disabled' : '' ?>>
                            <?= $stock > 0 ? 'Agregar al carrito' : 'Sin existencias' ?>
                        </button>
                    </form>
                </article>
            <?php endforeach; ?>

            <?php if (!$productos && $error === ''): ?>
                <p class="store-empty">Todavía no hay productos en el catálogo.</p>
            <?php endif; ?>
            <p class="store-empty" id="no-product-results" hidden>No encontramos productos con esa búsqueda.</p>
        </div>
    </section>

    <aside class="cart-panel" id="carrito" aria-labelledby="cart-heading">
        <div class="cart-heading">
            <h2 id="cart-heading">Tu carrito</h2>
            <span class="cart-count"><?= (int) $cantidadEnCarrito ?></span>
        </div>

        <?php if ($articulosCarrito): ?>
            <ul class="cart-list">
                <?php foreach ($articulosCarrito as $articulo): ?>
                    <?php $item = $articulo['producto']; ?>
                    <li class="cart-item">
                        <div>
                            <strong><?= htmlspecialchars($item['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?></strong>
                            <span><?= (int) $articulo['cantidad'] ?> × $<?= number_format((float) $item['precio'], 2, ',', '.') ?></span>
                            <span class="cart-subtotal">$<?= number_format($articulo['subtotal'], 2, ',', '.') ?></span>
                        </div>
                        <form action="<?= APP_BASE_PATH ?>/" method="POST">
                            <input type="hidden" name="carrito_accion" value="quitar">
                            <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                            <button class="remove-item" type="submit" aria-label="Quitar <?= htmlspecialchars($item['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?> del carrito">Quitar</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="cart-total">
                <span>Total</span>
                <strong>$<?= number_format($totalCarrito, 2, ',', '.') ?></strong>
            </div>
            <form action="<?= APP_BASE_PATH ?>/" method="POST">
                <input type="hidden" name="carrito_accion" value="vaciar">
                <button class="clear-cart" type="submit">Vaciar carrito</button>
            </form>
        <?php else: ?>
            <p class="cart-empty">Aún no agregas productos.</p>
            <p class="cart-hint">Elige una fragancia para verla aquí.</p>
        <?php endif; ?>
    </aside>
</div>

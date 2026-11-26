<style>
    .home-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 20px;
    }

    .home-actions a {
        display: inline-flex;
        min-height: 42px;
        align-items: center;
        padding: 9px 16px;
        border: 1px solid #e2b544;
        border-radius: 8px;
        background: #e2b544;
        color: #102a43;
        font-weight: 700;
        text-decoration: none;
    }

    .home-actions a.secondary {
        border-color: #d7e0e8;
        background: transparent;
        color: #fff;
    }
</style>

<section class="store-intro">
    <p class="eyebrow">AROMA · PERFUMERÍA</p>
    <h1>Bienvenido a Aroma</h1>
    <p>Encuentra tu próxima fragancia y explora nuestro catálogo de perfumes.</p>
    <div class="home-actions">
        <a href="<?= htmlspecialchars(APP_BASE_PATH . '/tienda', ENT_QUOTES, 'UTF-8') ?>">Visitar la tienda</a>
        <a class="secondary" href="<?= htmlspecialchars(APP_BASE_PATH . '/api', ENT_QUOTES, 'UTF-8') ?>">Explorar la API</a>
    </div>
</section>
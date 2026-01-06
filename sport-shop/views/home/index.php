<main class="main">
    <section class="hero">
        <div class="container">
            <h1>SportDay</h1>
            <p>Знайдіть ідеальний спортивний товар для будь-якого випадку</p>
            <a href="<?= base_url('/products') ?>" class="btn">Перейти до каталогу</a>
        </div>
    </section>

    <section class="featured">
        <div class="container">
            <h2>Рекомендовані товари</h2>
            <div class="products-grid">
                <?php foreach ($featuredProducts as $product): ?>
                    <div class="product-card">
                        <?php if (!empty($product['ImageURL'])): ?>
                            <img src="<?= htmlspecialchars($product['ImageURL']) ?>" alt="<?= htmlspecialchars($product['ProductName']) ?>" class="product-image">
                        <?php else: ?>
                            <img src="/path/to/default-image.jpg" alt="No image" class="product-image">
                        <?php endif; ?>

                        <h3><?= htmlspecialchars($product['ProductName']) ?></h3>
                        <p class="price"><?= number_format($product['Price'], 2) ?> грн</p>
                        <a href="<?= base_url('/product/detail/' . $product['ProductID']) ?>" class="btn">Детальніше</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>


    <section class="categories">
        <div class="container">
            <h2>Категорії</h2>
            <div class="categories-grid">
                <?php foreach ($categories as $category): ?>
                    <div class="category-card">
                        <h3><?= htmlspecialchars($category['CategoryName']) ?></h3>
                        <a href="<?= base_url('/products?category_id=' . $category['CategoryID']) ?>" class="btn">Переглянути</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>
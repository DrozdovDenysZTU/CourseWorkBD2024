<?php include(__DIR__ . '/../includes/header.php'); ?>
<?php include(__DIR__ . '/../includes/navbar.php'); ?>

<main class="main">
    <div class="container">
        <h1>Категорії товарів</h1>

        <div class="categories-grid">
            <?php foreach ($categories as $category): ?>
                <div class="category-card">
                    <h2><?php echo htmlspecialchars($category['CategoryName']); ?></h2>
                    <?php if (!empty($category['Description'])): ?>
                        <p><?php echo htmlspecialchars($category['Description']); ?></p>
                    <?php endif; ?>
                    <a href="<?php echo base_url('/products?category_id=' . $category['CategoryID']); ?>" class="btn">Переглянути товари</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
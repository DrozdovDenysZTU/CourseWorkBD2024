<?php include(__DIR__ . '/../includes/header.php'); ?>
<?php include(__DIR__ . '/../includes/navbar.php'); ?>

<main class="main">
    <div class="container">
        <h1>Мої відгуки</h1>
        
        <?php if (empty($reviews)): ?>
            <p>Ви ще не залишили жодного відгуку</p>
            <a href="<?php echo base_url('/products'); ?>" class="btn">Перейти до каталогу</a>
        <?php else: ?>
            <div class="reviews-list">
                <?php foreach ($reviews as $review): ?>
                    <div class="review">
                        <div class="review-header">
                            <h3>
                                <a href="<?php echo base_url('/product/detail/' . $review['ProductID']); ?>">
                                    <?php echo htmlspecialchars($review['ProductName']); ?>
                                </a>
                            </h3>
                            <div class="rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span class="<?php echo $i <= $review['Rating'] ? 'filled' : ''; ?>">★</span>
                                <?php endfor; ?>
                            </div>
                            <span class="date"><?php echo $review['ReviewDate']; ?></span>
                            <span class="status status-<?php echo strtolower($review['Status']); ?>">
                                <?php echo $review['Status']; ?>
                            </span>
                        </div>
                        <p><?php echo htmlspecialchars($review['ReviewText']); ?></p>
                        
                        <div class="review-actions">
                            <a href="<?php echo base_url('/review/edit/' . $review['ReviewID']); ?>" class="btn btn-edit">Редагувати</a>
                            <form method="post" action="<?php echo base_url('/review/delete/' . $review['ReviewID']); ?>" style="display:inline;">
                                <button type="submit" class="btn btn-danger">Видалити</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
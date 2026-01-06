<?php include(__DIR__ . '/../includes/header.php'); ?>
<?php include(__DIR__ . '/../includes/navbar.php'); ?>

<main class="main">
    <div class="container">
        <div class="product-detail">
            <div class="product-images">
                <?php if (!empty($product['ImageURL'])): ?>
                    <img src="<?php echo htmlspecialchars($product['ImageURL']); ?>" alt="<?php echo htmlspecialchars($product['ProductName']); ?>" />
                <?php endif; ?>
            </div>

            <div class="product-info">
                <h1><?php echo htmlspecialchars($product['ProductName']); ?></h1>

                <div class="rating">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <span class="<?php echo $i <= round($averageRating) ? 'filled' : ''; ?>">★</span>
                    <?php endfor; ?>
                    <span>(<?php echo $averageRating; ?>/5)</span>
                </div>

                <p class="price"><?php echo number_format($product['Price'], 2); ?> грн</p>
                <p class="stock"><?php echo $product['Stock'] > 0 ? 'Є в наявності' : 'Немає в наявності'; ?></p>
                <p class="description"><?php echo htmlspecialchars($product['Description']); ?></p>

                <?php if ($product['Stock'] > 0 && isset($_SESSION['user'])): ?>
                    <form action="<?php echo base_url('cart/add'); ?>" method="post">
                        <input type="hidden" name="id" value="<?php echo $product['ProductID']; ?>">
                        <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['Stock']; ?>" class="form-control" style="width: 100px;">
                        <button type="submit" class="btn btn-success mt-3">Додати до кошика</button>
                    </form>
                <?php elseif (!isset($_SESSION['user'])): ?>
                    <p><a href="<?php echo base_url('login'); ?>">Увійдіть</a>, щоб додати товар у кошик.</p>
                <?php else: ?>
                    <p>Немає товару в наявності.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</main>

<div class="product-reviews">
    <h2>Відгуки</h2>

    <?php if (isset($_SESSION['user'])): ?>
        <form action="<?php echo base_url('/review/add'); ?>" method="post" class="review-form">
            <input type="hidden" name="product_id" value="<?php echo $product['ProductID']; ?>">
            <div class="form-group">
                <label>Оцінка:</label>
                <select name="rating" required>
                    <option value="1">1 зірка</option>
                    <option value="2">2 зірки</option>
                    <option value="3">3 зірки</option>
                    <option value="4">4 зірки</option>
                    <option value="5" selected>5 зірок</option>
                </select>
            </div>
            <div class="form-group">
                <label>Відгук:</label>
                <textarea name="review_text" required></textarea>
            </div>
            <button type="submit" class="btn">Написати відгук</button>
        </form>
    <?php endif; ?>

    <?php if (empty($reviews)): ?>
        <p>Ще немає відгуків про цей товар</p>
    <?php else: ?>
        <div class="reviews-list">
            <?php foreach ($reviews as $review): ?>
                <div class="review">
                    <div class="review-header">
                        <strong><?php echo htmlspecialchars($review['Username']); ?></strong>
                        <div class="rating">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="<?php echo $i <= $review['Rating'] ? 'filled' : ''; ?>">★</span>
                            <?php endfor; ?>
                        </div>
                        <span class="date"><?php echo $review['ReviewDate']; ?></span>
                    </div>
                    <p><?php echo htmlspecialchars($review['ReviewText']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
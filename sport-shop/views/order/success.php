<?php include(__DIR__ . '/../includes/header.php'); ?>
<?php include(__DIR__ . '/../includes/navbar.php'); ?>

<main class="main">
    <div class="container">
        <div class="order-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="#4CAF50">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
            </svg>
            <h1>Дякуємо за ваше замовлення!</h1>
            <p>Ваше замовлення #<?php echo $_GET['order_id'] ?? ''; ?> успішно оформлено.</p>
            <p>Наш менеджер зв'яжеться з вами для підтвердження.</p>
            <div class="actions">
                <a href="<?php echo base_url('/order/history'); ?>" class="btn">Мої замовлення</a>
                <a href="<?php echo base_url('/products'); ?>" class="btn btn-secondary">Продовжити покупки</a>
            </div>
        </div>
    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
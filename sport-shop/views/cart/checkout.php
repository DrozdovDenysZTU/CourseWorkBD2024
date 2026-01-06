<?php include(__DIR__ . '/../includes/header.php'); ?>
<?php include(__DIR__ . '/../includes/navbar.php'); ?>

<main class="main">
    <div class="container">
        <h1>Оформлення замовлення</h1>
        
        <div class="order-success">
            <h2>Дякуємо за ваше замовлення!</h2>
            <p>Номер вашого замовлення: <strong>#<?php echo $orderId; ?></strong></p>
            <p>Наш менеджер зв'яжеться з вами для підтвердження.</p>
            <a href="<?php echo base_url('/'); ?>" class="btn">На головну</a>
        </div>
    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
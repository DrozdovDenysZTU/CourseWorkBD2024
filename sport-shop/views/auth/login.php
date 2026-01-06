<?php include(__DIR__ . '/../includes/header.php'); ?>
<?php include(__DIR__ . '/../includes/navbar.php'); ?>

<main class="main">
    <div class="container">
        <div class="auth-form">
            <h1>Вхід</h1>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['error'];
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('login') ?>">
                <div class="form-group">
                    <label>Логін:</label>
                    <input type="text" name="username" required>
                </div>

                <div class="form-group">
                    <label>Пароль:</label>
                    <input type="password" name="password" required>
                </div>

                <button type="submit" class="btn">Увійти</button>
            </form>

            <p>Ще не зареєстровані? <a href="<?= base_url('register') ?>">Створити акаунт</a></p>

        </div>
    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
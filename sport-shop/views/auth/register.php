<?php include(__DIR__ . '/../includes/header.php'); ?>
<?php include(__DIR__ . '/../includes/navbar.php'); ?>

<main class="main">
    <div class="container">
        <div class="auth-form">
            <h1>Реєстрація</h1>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
                </div>
            <?php endif; ?>
            
            <form method="post">
                <div class="form-group">
                    <label>Логін:</label>
                    <input type="text" name="username" required>
                </div>
                
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Пароль:</label>
                    <input type="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label>Ім'я:</label>
                    <input type="text" name="firstname" required>
                </div>
                
                <div class="form-group">
                    <label>Прізвище:</label>
                    <input type="text" name="lastname" required>
                </div>
                
                <div class="form-group">
                    <label>Телефон:</label>
                    <input type="text" name="phone" required>
                </div>
                
                <div class="form-group">
                    <label>Адреса:</label>
                    <input type="text" name="address" required>
                </div>
                
                <div class="form-group">
                    <label>Місто:</label>
                    <input type="text" name="city" required>
                </div>
                
                <div class="form-group">
                    <label>Країна:</label>
                    <input type="text" name="country" required>
                </div>
                
                <div class="form-group">
                    <label>Поштовий індекс:</label>
                    <input type="text" name="postalcode" required>
                </div>
                
                <button type="submit" class="btn">Зареєструватися</button>
            </form>
            
            <p>Вже зареєстровані? <a href="/login">Увійти</a></p>
        </div>
    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
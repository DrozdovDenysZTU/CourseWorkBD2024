<?php include(__DIR__ . '/../includes/header.php'); ?>
<?php include(__DIR__ . '/../includes/navbar.php'); ?>

<?php
if (!empty($_SESSION['message'])) {
    echo '<div class="alert alert-success text-center custom-alert">' . htmlspecialchars($_SESSION['message']) . '</div>';
    unset($_SESSION['message']);
}
if (!empty($_SESSION['error'])) {
    echo '<div class="alert alert-danger text-center custom-alert">' . htmlspecialchars($_SESSION['error']) . '</div>';
    unset($_SESSION['error']);
}
?>

<h1>Кошик</h1>

<?php if (empty($cartItems)): ?>

    <div class="empty-cart text-center">
        <p>Ваш кошик порожній.</p>
        <a href="<?php echo base_url('products'); ?>" class="btn btn-primary">Повернутися до товарів</a>
    </div>
<?php else: ?>
    <form action="<?php echo base_url('cart/update'); ?>" method="post">
        <table class="table">
            <thead>
                <tr>
                    <th>Назва товару</th>
                    <th>Ціна</th>
                    <th>Кількість</th>
                    <th>Сума</th>
                    <th>Дія</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['ProductName']) ?></td>
                        <td><?= number_format($item['Price'], 2) ?> грн</td>
                        <td>
                            <input type="number" name="quantity[<?= $item['CartID'] ?>]" value="<?= $item['Quantity'] ?>" min="1" class="form-control" style="width: 80px;">
                        </td>
                        <td><?= number_format($item['Price'] * $item['Quantity'], 2) ?> грн</td>
                        <td>
                            <a href="<?php echo base_url('cart/remove/' . $item['CartID']); ?>" onclick="return confirm('Видалити цей товар?')" class="btn btn-danger btn-sm">Видалити</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><strong>Загальна сума: <?= number_format($total, 2) ?> грн</strong></p>
        <button type="submit" class="btn btn-primary">Оновити кошик</button>
        <a href="<?php echo base_url('cart/clear'); ?>" onclick="return confirm('Очистити кошик?')" class="btn btn-warning">Очистити кошик</a>
        <a href="<?php echo base_url('cart/checkout'); ?>" class="btn btn-success">Оформити замовлення</a>
        <a href="<?php echo base_url('products'); ?>" class="btn btn-secondary">Повернутися до товарів</a>
    </form>
<?php endif; ?>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
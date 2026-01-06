<?php include(__DIR__ . '/../includes/header.php'); ?>
<?php include(__DIR__ . '/../includes/navbar.php'); ?>

<main class="main">
    <div class="container">
        <h1>Деталі замовлення #<?= htmlspecialchars($order['OrderID'] ?? ''); ?></h1>

        <div class="order-info">
            <p><strong>Клієнт:</strong> <?= htmlspecialchars($order['Username'] ?? ''); ?></p>
            <p><strong>Дата замовлення:</strong> <?= htmlspecialchars($order['OrderDate'] ?? ''); ?></p>
            <p><strong>Статус:</strong> <?= htmlspecialchars(ucfirst($order['Status'] ?? '')); ?></p>
            <p><strong>Загальна сума:</strong> <?= number_format($order['TotalAmount'] ?? 0, 2); ?> грн</p>
        </div>

        <h2>Товари в замовленні</h2>
        <?php if (!empty($orderItems)): ?>
            <table class="order-items-table">
                <thead>
                    <tr>
                        <th>Назва товару</th>
                        <th>Кількість</th>
                        <th>Ціна за одиницю</th>
                        <th>Сума</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderItems as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['ProductName'] ?? ''); ?></td>
                            <td><?= $item['Quantity'] ?? 0; ?></td>
                            <td><?= number_format($item['Price'] ?? 0, 2); ?> грн</td>
                            <td><?= number_format(
                                    ($item['Price'] ?? 0) * ($item['Quantity'] ?? 0),
                                    2
                                ); ?> грн</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>У цьому замовленні немає товарів.</p>
        <?php endif; ?>

        <?php if (isset($_SESSION['user'], $_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
            <h2>Адміністраторські дії</h2>
            <form method="post" action="<?= base_url('/admin/orders/update-status'); ?>" class="status-form">
                <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['OrderID'] ?? ''); ?>">
                <label for="status">Оновити статус:</label>
                <select name="status" id="status" onchange="this.form.submit()">
                    <option value="pending" <?= (isset($order['Status']) && $order['Status'] === 'pending') ? 'selected' : ''; ?>>Очікує</option>
                    <option value="processing" <?= (isset($order['Status']) && $order['Status'] === 'processing') ? 'selected' : ''; ?>>В обробці</option>
                    <option value="completed" <?= (isset($order['Status']) && $order['Status'] === 'completed') ? 'selected' : ''; ?>>Виконано</option>
                    <option value="cancelled" <?= (isset($order['Status']) && $order['Status'] === 'cancelled') ? 'selected' : ''; ?>>Скасовано</option>
                </select>
            </form>
        <?php endif; ?>

        <p>
            <?php if (isset($_SESSION['user']['Role']) && $_SESSION['user']['Role'] === 'admin'): ?>
                <a href="<?= base_url('/admin/orders?status=' . urlencode($currentStatus ?? '') . '&page=' . (int)($currentPage ?? 1)); ?>" class="btn">Назад до управління замовленнями</a>
            <?php endif; ?>
        </p>

    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
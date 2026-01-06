<?php include(__DIR__ . '/../includes/header.php'); ?>
<?php include(__DIR__ . '/../includes/navbar.php'); ?>

<main class="main">
    <div class="container">
        <h1>Управління замовленнями</h1>

        <?php if (!empty($_SESSION['message'])): ?>
            <div class="alert success">
                <?= htmlspecialchars($_SESSION['message']); ?>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Клієнт</th>
                    <th>Дата</th>
                    <th>Сума</th>
                    <th>Статус</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $order['OrderID']; ?></td>
                        <td><?= htmlspecialchars($order['Username']); ?></td>
                        <td><?= $order['OrderDate']; ?></td>
                        <td><?= number_format($order['TotalAmount'], 2); ?> грн</td>
                        <td>
                            <form method="post" action="<?= base_url('admin/orders') ?>" class="status-form">
                                <input type="hidden" name="order_id" value="<?= $order['OrderID']; ?>">
                                <select name="status" onchange="this.form.submit()">
                                    <option value="pending" <?= ($order['Status'] == 'pending') ? 'selected' : ''; ?>>Очікує</option>
                                    <option value="processing" <?= ($order['Status'] == 'processing') ? 'selected' : ''; ?>>В обробці</option>
                                    <option value="completed" <?= ($order['Status'] == 'completed') ? 'selected' : ''; ?>>Виконано</option>
                                    <option value="cancelled" <?= ($order['Status'] == 'cancelled') ? 'selected' : ''; ?>>Скасовано</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <a href="<?= base_url('/order/detail/' . $order['OrderID']); ?>" class="btn btn-sm btn-info">Деталі</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="<?= base_url('admin/orders?page=' . $i); ?>"
                        class="<?= ($currentPage == $i) ? 'active' : ''; ?>">
                        <?= $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
<?php include(__DIR__ . '/../includes/header.php'); ?>
<?php include(__DIR__ . '/../includes/navbar.php'); ?>

<main class="main">
    <div class="container">
        <h1>Історія замовлень</h1>
        
        <?php if (empty($orders)): ?>
            <p>У вас ще немає замовлень</p>
            <a href="<?php echo base_url('/products'); ?>" class="btn">Перейти до каталогу</a>
        <?php else: ?>
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Номер замовлення</th>
                        <th>Дата</th>
                        <th>Сума</th>
                        <th>Статус</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?php echo $order['OrderID']; ?></td>
                            <td><?php echo $order['OrderDate']; ?></td>
                            <td><?php echo number_format($order['TotalAmount'], 2); ?> грн</td>
                            <td>
                                <span class="status-<?php echo strtolower($order['Status']); ?>">
                                    <?php echo $order['Status']; ?>
                                </span>
                            </td>
                            <td>
                               <a href="<?php echo base_url('/order/detail/' . $order['OrderID']); ?>" class="btn">Деталі</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
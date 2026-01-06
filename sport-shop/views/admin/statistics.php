<?php include(__DIR__ . '/../includes/header.php'); ?>
<?php include(__DIR__ . '/../includes/navbar.php'); ?>

<main class="main">
    <div class="container">
        <h1>Статистика магазину</h1>

        <div class="stat-card">
            <h2>Середній рейтинг товарів</h2>
            <table class="table">
                <tr>
                    <th>Товар</th>
                    <th>Середній рейтинг</th>
                    <th>Кількість відгуків</th>
                </tr>
                <?php foreach ($avgRatings as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['ProductName']) ?></td>
                        <td><?= $r['AvgRating'] !== null ? number_format((float)$r['AvgRating'], 2) : '-' ?></td>
                        <td><?= $r['NumReviews'] ?? 0 ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="stat-card">
            <h2>Топ-5 проданих товарів</h2>
            <table class="table">
                <tr>
                    <th>Товар</th>
                    <th>Продано одиниць</th>
                    <th>Дохід</th>
                </tr>
                <?php foreach ($topProducts as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['ProductName']) ?></td>
                        <td><?= $p['TotalSold'] ?? 0 ?></td>
                        <td><?= isset($p['Revenue']) ? number_format((float)$p['Revenue'], 2) : '0.00' ?> грн</td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="stat-card">
            <h2>Найактивніші користувачі</h2>
            <table class="table">
                <tr>
                    <th>Користувач</th>
                    <th>Кількість відгуків</th>
                </tr>
                <?php foreach ($topUsers as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['Username']) ?></td>
                        <td><?= $u['NumReviews'] ?? 0 ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</main>



<?php include(__DIR__ . '/../includes/footer.php'); ?>
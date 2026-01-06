<?php include(__DIR__ . '/../includes/header.php'); ?>
<?php include(__DIR__ . '/../includes/navbar.php'); ?>

<main class="main">
    <div class="container">
        <h1>Управління відгуками</h1>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                ?>
            </div>
        <?php endif; ?>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Товар</th>
                    <th>Користувач</th>
                    <th>Рейтинг</th>
                    <th>Дата</th>
                    <th>Статус</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviews as $review): ?>
                    <tr>
                        <td><?php echo $review['ReviewID']; ?></td>
                        <td><?php echo htmlspecialchars($review['ProductName']); ?></td>
                        <td><?php echo htmlspecialchars($review['Username']); ?></td>
                        <td>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="<?php echo $i <= $review['Rating'] ? 'filled' : ''; ?>">★</span>
                            <?php endfor; ?>
                        </td>
                        <td><?php echo $review['ReviewDate']; ?></td>
                        <td>
                            <span class="status-<?php echo strtolower($review['Status']); ?>">
                                <?php echo $review['Status']; ?>
                            </span>
                        </td>
                        <td>
                            <form method="post" action="<?php echo base_url('admin/reviews/approve'); ?>" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $review['ReviewID']; ?>">
                                <button type="submit" class="btn btn-success">Схвалити</button>
                            </form>
                            <form method="post" action="<?php echo base_url('admin/reviews/reject'); ?>" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $review['ReviewID']; ?>">
                                <button type="submit" class="btn btn-warning">Відхилити</button>
                            </form>
                            <form method="post" action="<?php echo base_url('admin/reviews/delete'); ?>" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $review['ReviewID']; ?>">
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Ви впевнені, що хочете видалити цей відгук?');">
                                    Видалити
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="<?php echo base_url('admin/reviews?page=' . $i); ?>"
                        class="<?php echo $currentPage == $i ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
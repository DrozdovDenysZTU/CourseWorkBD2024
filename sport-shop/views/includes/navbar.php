<?php require_once __DIR__ . '/../../config/config.php'; ?>

<header class="header">
    <div class="container">
        <div class="header-inner">
            <a href="<?= base_url() ?>" class="logo">SportDay</a>

            <nav class="nav">
                <ul class="nav-list">
                    <li><a href="<?= base_url() ?>">Головна</a></li>
                    <li><a href="<?= base_url('products') ?>">Товари</a></li>
                    <li><a href="<?= base_url('categories') ?>">Категорії</a></li>

                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="dropdown">
                            <a href="#">Мій кабінет</a>
                            <ul class="dropdown-menu">
                                <li><a href="<?= base_url('cart') ?>">Кошик</a></li>
                                <li><a href="<?= base_url('order/history') ?>">Мої замовлення</a></li>
                                <li><a href="<?= base_url('profile') ?>">Профіль</a></li>
                            </ul>
                        </li>

                        <?php if ($_SESSION['user']['Role'] === 'admin'): ?>
                            <li class="dropdown">
                                <a href="#">Адмін-панель</a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?= base_url('admin/products') ?>">Управління товарами</a></li>
                                    <li><a href="<?= base_url('admin/categories') ?>">Управління категоріями</a></li>
                                    <li><a href="<?= base_url('admin/orders') ?>">Управління замовленнями</a></li>
                                    <li><a href="<?= base_url('admin/reviews') ?>">Управління відгуками</a></li>
                                    <li><a href="<?= base_url('admin/statistics') ?>">Статистика</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <li><a href="<?= base_url('logout') ?>">Вийти (<?= htmlspecialchars($_SESSION['user']['Username']) ?>)</a></li>
                    <?php else: ?>
                        <li><a href="<?= base_url('login') ?>">Увійти</a></li>
                        <li><a href="<?= base_url('register') ?>">Реєстрація</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</header>
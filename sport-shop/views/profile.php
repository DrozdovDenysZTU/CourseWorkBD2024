<?php include(__DIR__ . '/includes/header.php'); ?>
<?php include(__DIR__ . '/includes/navbar.php'); ?>

<main class="main py-5 bg-light">
    <div class="container">
        <div class="profile-card shadow-lg p-4 rounded bg-white">
            <h1 class="mb-4 text-primary">Профіль користувача</h1>

            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th scope="row">Логін:</th>
                        <td><?= htmlspecialchars($user['Username']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Email:</th>
                        <td><?= htmlspecialchars($user['Email']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Ім'я:</th>
                        <td><?= htmlspecialchars($user['FirstName']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Прізвище:</th>
                        <td><?= htmlspecialchars($user['LastName']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Телефон:</th>
                        <td><?= htmlspecialchars($user['Phone']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Адреса:</th>
                        <td><?= htmlspecialchars($user['Address']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Місто:</th>
                        <td><?= htmlspecialchars($user['City']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Країна:</th>
                        <td><?= htmlspecialchars($user['Country']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Поштовий індекс:</th>
                        <td><?= htmlspecialchars($user['PostalCode']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Дата реєстрації:</th>
                        <td><?= htmlspecialchars(date('Y-m-d', strtotime($user['RegistrationDate']))) ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-4">
                <a href="<?= BASE_URL ?>/logout" class="btn btn-danger">Вийти</a>
            </div>
        </div>
    </div>
</main>

<?php include(__DIR__ . '/includes/footer.php'); ?>
<?php include(__DIR__ . '/../includes/header.php'); ?>
<?php include(__DIR__ . '/../includes/navbar.php'); ?>

<main class="main">
    <div class="container">

        <?php if (!empty($_SESSION['message'])): ?>
            <div class="alert success">
                <?php
                echo htmlspecialchars($_SESSION['message'] ?? '');
                unset($_SESSION['message']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert success">
                <?php echo $_SESSION['message'] ?? '';
                unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>


        <h1>Управління товарами</h1>

        <div class="admin-actions">
            <button id="addProductBtn" class="btn">Додати товар</button>
        </div>
        <div id="productModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="modalTitle">Додати товар</h2>
                <form method="post" action="<?php echo base_url('/admin/products/save'); ?>">
                    <input type="hidden" name="action" id="formAction" value="add">
                    <input type="hidden" name="id" id="productId">

                    <div class="form-group">
                        <label>Назва:</label>
                        <input type="text" name="name" id="productName" required>
                    </div>

                    <div class="form-group">
                        <label>Опис:</label>
                        <textarea name="description" id="productDescription" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Ціна:</label>
                        <input type="number" step="0.01" name="price" id="productPrice" required>
                    </div>

                    <div class="form-group">
                        <label>Кількість:</label>
                        <input type="number" name="stock" id="productStock" required>
                    </div>

                    <div class="form-group">
                        <label>Категорія:</label>
                        <select name="category" id="productCategory" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['CategoryID']; ?>">
                                    <?php echo htmlspecialchars($category['CategoryName'] ?? ''); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Фото (URL):</label>
                        <input type="text" name="image" id="productImage" placeholder="Вставте URL зображення">
                    </div>

                    <button type="submit" class="btn">Зберегти</button>
                </form>
            </div>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Назва</th>
                    <th>Ціна</th>
                    <th>Кількість</th>
                    <th>Категорія</th>
                    <th>Фото</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['ProductID']; ?></td>
                        <td><?php echo htmlspecialchars($product['ProductName'] ?? ''); ?></td>
                        <td><?php echo number_format($product['Price'], 2); ?> грн</td>
                        <td><?php echo $product['Stock']; ?></td>
                        <td>
                            <?php
                            $categoryName = '';
                            foreach ($categories as $category) {
                                if ($category['CategoryID'] == $product['CategoryID']) {
                                    $categoryName = $category['CategoryName'] ?? '';
                                    break;
                                }
                            }
                            echo htmlspecialchars($categoryName);
                            ?>
                        </td>
                        <td>
                            <?php if (!empty($product['ImageURL'])): ?>
                                <img src="<?php echo htmlspecialchars($product['ImageURL'] ?? ''); ?>" alt="Фото товару" style="width: 50px; height: 50px; object-fit: cover;">
                            <?php else: ?>
                                <span>Немає фото</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button class="btn btn-edit" onclick="editProduct(
                        '<?php echo $product['ProductID']; ?>',
                        '<?php echo htmlspecialchars($product['ProductName'] ?? '', ENT_QUOTES); ?>',
                        '<?php echo htmlspecialchars($product['Description'] ?? '', ENT_QUOTES); ?>',
                        '<?php echo $product['Price']; ?>',
                        '<?php echo $product['Stock']; ?>',
                        '<?php echo $product['CategoryID']; ?>',
                        '<?php echo htmlspecialchars($product['ImageURL'] ?? '', ENT_QUOTES); ?>'
                    )">Редагувати</button>

                            <form method="post" action="<?php echo base_url('/admin/products/delete'); ?>" style="display:inline;" onsubmit="return confirm('Ви дійсно хочете видалити цей товар?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $product['ProductID']; ?>">
                                <button type="submit" class="btn btn-danger">Видалити</button>
                            </form>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<script>
    const modal = document.getElementById('productModal');
    const addBtn = document.getElementById('addProductBtn');
    const span = document.getElementsByClassName('close')[0];

    addBtn.onclick = function() {
        document.getElementById('modalTitle').innerText = 'Додати товар';
        document.getElementById('formAction').value = 'add';
        document.getElementById('productId').value = '';
        document.getElementById('productName').value = '';
        document.getElementById('productDescription').value = '';
        document.getElementById('productPrice').value = '';
        document.getElementById('productStock').value = '';
        document.getElementById('productCategory').value = '';
        modal.style.display = 'block';
    }

    span.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }

    function editProduct(id, name, description, price, stock, category, image) {
        document.getElementById('modalTitle').innerText = 'Редагувати товар';
        document.getElementById('formAction').value = 'edit';
        document.getElementById('productId').value = id;
        document.getElementById('productName').value = name;
        document.getElementById('productDescription').value = description;
        document.getElementById('productPrice').value = price;
        document.getElementById('productStock').value = stock;
        document.getElementById('productCategory').value = category;
        document.getElementById('productImage').value = image;
        modal.style.display = 'block';
    }
</script>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
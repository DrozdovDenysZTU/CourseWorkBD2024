<?php include(__DIR__ . '/../includes/header.php'); ?>
<?php include(__DIR__ . '/../includes/navbar.php'); ?>

<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success">
        <?php
        echo $_SESSION['message'];
        unset($_SESSION['message']);
        ?>
    </div>
<?php endif; ?>

<main class="main">
    <div class="container">
        <h1>Управління категоріями</h1>

        <div class="admin-actions">
            <button id="addCategoryBtn" class="btn">Додати категорію</button>
        </div>

        <div id="categoryModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="modalTitle">Додати категорію</h2>
                <form method="post" action="<?php echo base_url('/admin/categories/save'); ?>">
                    <input type="hidden" name="action" id="formAction" value="add">
                    <input type="hidden" name="id" id="categoryId">

                    <div class="form-group">
                        <label>Назва:</label>
                        <input type="text" name="name" id="categoryName" required>
                    </div>

                    <div class="form-group">
                        <label>Опис:</label>
                        <textarea name="description" id="categoryDescription"></textarea>
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
                    <th>Опис</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?php echo $category['CategoryID']; ?></td>
                        <td><?php echo htmlspecialchars($category['CategoryName']); ?></td>
                        <td><?php echo htmlspecialchars($category['Description'] ?? '-'); ?></td>
                        <td>
                            <button class="btn btn-edit"
                                data-id="<?php echo $category['CategoryID']; ?>"
                                data-name="<?php echo htmlspecialchars($category['CategoryName'], ENT_QUOTES); ?>"
                                data-description="<?php echo htmlspecialchars($category['Description'] ?? '', ENT_QUOTES); ?>"
                                onclick="editCategoryFromBtn(this)">
                                Редагувати
                            </button>

                            <form method="post" action="<?php echo base_url('/admin/categories/delete'); ?>" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $category['CategoryID']; ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Ви впевнені, що хочете видалити цю категорію?')">Видалити</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<script>
    const modal = document.getElementById('categoryModal');
    const addBtn = document.getElementById('addCategoryBtn');
    const span = document.getElementsByClassName('close')[0];

    addBtn.onclick = function() {
        document.getElementById('modalTitle').innerText = 'Додати категорію';
        document.getElementById('formAction').value = 'add';
        document.getElementById('categoryId').value = '';
        document.getElementById('categoryName').value = '';
        document.getElementById('categoryDescription').value = '';
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

    function editCategoryFromBtn(button) {
        document.getElementById('modalTitle').innerText = 'Редагувати категорію';
        document.getElementById('formAction').value = 'edit';
        document.getElementById('categoryId').value = button.dataset.id;
        document.getElementById('categoryName').value = button.dataset.name;
        document.getElementById('categoryDescription').value = button.dataset.description;
        modal.style.display = 'block';
    }

    function editCategory(id, name, description) {
        document.getElementById('modalTitle').innerText = 'Редагувати категорію';
        document.getElementById('formAction').value = 'edit';
        document.getElementById('categoryId').value = id;
        document.getElementById('categoryName').value = name;
        document.getElementById('categoryDescription').value = description;
        modal.style.display = 'block';
    }
</script>

<?php include(__DIR__ . '/../includes/footer.php'); ?>
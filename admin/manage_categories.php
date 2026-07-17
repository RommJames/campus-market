<?php
require_once __DIR__ . '/../includes/admin_auth_check.php';
require_once __DIR__ . '/../config/database.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = sanitize($_POST['category_name']);
    $category_type = sanitize($_POST['category_type']);

    if (empty($category_name)) {
        $errors[] = "Category name is required.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare(
            "INSERT INTO categories (category_name, category_type) VALUES (:name, :type)"
        );
        $stmt->execute(['name' => $category_name, 'type' => $category_type]);

        setFlashMessage("Category added successfully!", "success");
        redirect('manage_categories.php');
    }
}

$categories = $conn->query("SELECT * FROM categories ORDER BY category_type, category_name")
                    ->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../includes/admin_header.php';
?>

<div class="container py-4">

    <div class="page-header">
        <h1>Manage Categories</h1>
        <p>Organize how products and services are classified.</p>
    </div>

    <div class="form-card mb-5" style="max-width:none;">
        <h2>Add New Category</h2>
        <p class="form-subtitle">Categories help students browse and filter listings.</p>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger py-2 px-3 mb-3">
                <ul class="mb-0 ps-3">
                    <?php foreach ($errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="manage_categories.php" class="row g-3 align-items-end">
            <div class="col-md-6">
                <label>Category Name</label>
                <input type="text" name="category_name" class="form-control" placeholder="e.g. Lighting Equipment" required>
            </div>
            <div class="col-md-4">
                <label>Type</label>
                <select name="category_type" class="form-select">
                    <option value="academic">Academic</option>
                    <option value="entertainment_media">Entertainment &amp; Media</option>
                    <option value="general">General</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary-custom w-100">Add</button>
            </div>
        </form>
    </div>

    <h2 class="section-title">Existing Categories</h2>

    <div class="table-card">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td class="fw-semibold"><?= sanitize($cat['category_name']) ?></td>
                        <td><span class="badge-type"><?= sanitize($cat['category_type']) ?></span></td>
                        <td class="row-actions">
                            <a href="delete_category.php?id=<?= $cat['category_id'] ?>" class="action-delete"
                               onclick="return confirm('Delete this category? Products/services using it may be affected.');">
                               Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>

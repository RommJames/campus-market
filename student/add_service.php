<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

$errors = [];

$catStmt = $conn->prepare(
    "SELECT category_id, category_name FROM categories WHERE category_type = 'entertainment_media' ORDER BY category_name"
);
$catStmt->execute();
$categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $service_name = sanitize($_POST['service_name']);
    $description  = sanitize($_POST['description']);
    $category_id  = (int) $_POST['category_id'];
    $price        = (float) $_POST['price'];

    if (empty($service_name) || $category_id <= 0 || $price <= 0) {
        $errors[] = "Service name, category, and a valid price are required.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare(
            "INSERT INTO services (user_id, category_id, service_name, description, price)
             VALUES (:user_id, :category_id, :service_name, :description, :price)"
        );
        $stmt->execute([
            'user_id'      => $_SESSION['user_id'],
            'category_id'  => $category_id,
            'service_name' => $service_name,
            'description'  => $description,
            'price'        => $price
        ]);

        setFlashMessage("Service posted successfully!", "success");
        redirect('my_services.php');
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="container py-4">

    <div class="page-header text-center">
        <h1>Offer a Creative Service</h1>
        <p>List a skill or service other students can hire you for.</p>
    </div>

    <div class="form-card">

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger py-2 px-3 mb-3">
                <ul class="mb-0 ps-3">
                    <?php foreach ($errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="add_service.php">
            <div class="mb-3">
                <label>Service Name</label>
                <input type="text" name="service_name" class="form-control" placeholder='e.g. "Event Photography"' required>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="What's included, turnaround time, portfolio links, etc."></textarea>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label>Category</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['category_id'] ?>"><?= sanitize($cat['category_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Starting Price (₱)</label>
                    <input type="number" step="0.01" name="price" class="form-control" placeholder="0.00" required>
                </div>
            </div>

            <div class="form-actions">
                <a href="my_services.php" class="btn btn-outline-custom">Cancel</a>
                <button type="submit" class="btn btn-primary-custom">Post Service</button>
            </div>
        </form>
    </div>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

$product_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$errors = [];

$stmt = $conn->prepare(
    "SELECT * FROM products WHERE product_id = :id AND user_id = :user_id"
);
$stmt->execute(['id' => $product_id, 'user_id' => $_SESSION['user_id']]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    setFlashMessage("Product not found or you don't have permission to edit it.", "error");
    redirect('my_products.php');
}

$categories = $conn->query("SELECT category_id, category_name FROM categories ORDER BY category_name")
                    ->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $product_name    = sanitize($_POST['product_name']);
    $description     = sanitize($_POST['description']);
    $category_id     = (int) $_POST['category_id'];
    $price           = (float) $_POST['price'];
    $is_rental       = isset($_POST['is_rental']) ? 1 : 0;
    $rental_price    = $is_rental ? (float) $_POST['rental_price'] : null;
    $rental_duration = $is_rental ? sanitize($_POST['rental_duration']) : null;
    $status          = sanitize($_POST['status']);

    if (empty($product_name) || $category_id <= 0 || $price <= 0) {
        $errors[] = "Product name, category, and a valid price are required.";
    }

    $imageFileName = $product['product_image'];

    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];
        $extension = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedTypes)) {
            $errors[] = "Only JPG, JPEG, PNG, or WEBP images are allowed.";
        } else {
            $imageFileName = uniqid('product_', true) . '.' . $extension;
            move_uploaded_file($_FILES['product_image']['tmp_name'], __DIR__ . '/../uploads/' . $imageFileName);
        }
    }

    if (empty($errors)) {
        $updateStmt = $conn->prepare(
            "UPDATE products SET
                product_name = :product_name,
                description = :description,
                category_id = :category_id,
                price = :price,
                is_rental = :is_rental,
                rental_price = :rental_price,
                rental_duration = :rental_duration,
                product_image = :product_image,
                status = :status
             WHERE product_id = :product_id AND user_id = :user_id"
        );

        $updateStmt->execute([
            'product_name'    => $product_name,
            'description'     => $description,
            'category_id'     => $category_id,
            'price'           => $price,
            'is_rental'       => $is_rental,
            'rental_price'    => $rental_price,
            'rental_duration' => $rental_duration,
            'product_image'   => $imageFileName,
            'status'          => $status,
            'product_id'      => $product_id,
            'user_id'         => $_SESSION['user_id']
        ]);

        setFlashMessage("Product updated successfully!", "success");
        redirect('my_products.php');
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="container py-4">

    <div class="page-header text-center">
        <h1>Edit Product</h1>
        <p>Update your listing details, status, or photo.</p>
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

        <form method="POST" action="edit_product.php?id=<?= $product['product_id'] ?>" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Product Name</label>
                <input type="text" name="product_name" class="form-control" value="<?= sanitize($product['product_name']) ?>" required>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4"><?= sanitize($product['description']) ?></textarea>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label>Category</label>
                    <select name="category_id" class="form-select" required>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['category_id'] ?>" <?= $cat['category_id'] == $product['category_id'] ? 'selected' : '' ?>>
                                <?= sanitize($cat['category_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Price (₱)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="<?= $product['price'] ?>" required>
                </div>
            </div>

            <div class="form-check-custom mb-2">
                <input type="checkbox" name="is_rental" id="is_rental" <?= $product['is_rental'] ? 'checked' : '' ?> onclick="toggleRentalFields()">
                <label class="mb-0" for="is_rental">This item is for RENT</label>
            </div>

            <div id="rentalFields" class="rental-fields-box" style="display:<?= $product['is_rental'] ? 'block' : 'none' ?>;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Rental Price (₱)</label>
                        <input type="number" step="0.01" name="rental_price" class="form-control" value="<?= $product['rental_price'] ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Rental Duration</label>
                        <input type="text" name="rental_duration" class="form-control" value="<?= sanitize($product['rental_duration']) ?>">
                    </div>
                </div>
            </div>

            <hr class="form-section-divider">

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="available" <?= $product['status'] == 'available' ? 'selected' : '' ?>>Available</option>
                    <option value="rented" <?= $product['status'] == 'rented' ? 'selected' : '' ?>>Rented</option>
                    <option value="sold" <?= $product['status'] == 'sold' ? 'selected' : '' ?>>Sold</option>
                </select>
            </div>

            <div class="mb-4">
                <label>Photo</label><br>
                <img src="../uploads/<?= sanitize($product['product_image']) ?>" class="current-image-preview" alt="current image">
                <input type="file" name="product_image" class="form-control mt-2" accept=".jpg,.jpeg,.png,.webp">
                <p class="form-text-hint">Leave blank to keep the current photo.</p>
            </div>

            <div class="form-actions">
                <a href="my_products.php" class="btn btn-outline-custom">Cancel</a>
                <button type="submit" class="btn btn-primary-custom">Update Product</button>
            </div>
        </form>
    </div>

</div>

<script>
    function toggleRentalFields() {
        var checkbox = document.getElementById('is_rental');
        var fields = document.getElementById('rentalFields');
        fields.style.display = checkbox.checked ? 'block' : 'none';
    }
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

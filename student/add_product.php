<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

$errors = [];

$catStmt = $conn->query("SELECT category_id, category_name FROM categories ORDER BY category_name");
$categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $product_name    = sanitize($_POST['product_name']);
    $description     = sanitize($_POST['description']);
    $category_id     = (int) $_POST['category_id'];
    $price           = (float) $_POST['price'];
    $is_rental       = isset($_POST['is_rental']) ? 1 : 0;
    $rental_price    = $is_rental ? (float) $_POST['rental_price'] : null;
    $rental_duration = $is_rental ? sanitize($_POST['rental_duration']) : null;

    if (empty($product_name) || $category_id <= 0 || $price <= 0) {
        $errors[] = "Product name, category, and a valid price are required.";
    }
    if ($is_rental && $rental_price <= 0) {
        $errors[] = "Please provide a valid rental price.";
    }

    $imageFileName = 'no-image.png';

    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {

        $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];
        $originalName = $_FILES['product_image']['name'];
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedTypes)) {
            $errors[] = "Only JPG, JPEG, PNG, or WEBP images are allowed.";
        } else {
            $imageFileName = uniqid('product_', true) . '.' . $extension;
            $destination = __DIR__ . '/../uploads/' . $imageFileName;

            if (!move_uploaded_file($_FILES['product_image']['tmp_name'], $destination)) {
                $errors[] = "Failed to upload image. Please try again.";
            }
        }
    }

    if (empty($errors)) {
        $stmt = $conn->prepare(
            "INSERT INTO products
                (user_id, category_id, product_name, description, price,
                 is_rental, rental_price, rental_duration, product_image)
             VALUES
                (:user_id, :category_id, :product_name, :description, :price,
                 :is_rental, :rental_price, :rental_duration, :product_image)"
        );

        $stmt->execute([
            'user_id'         => $_SESSION['user_id'],
            'category_id'     => $category_id,
            'product_name'    => $product_name,
            'description'     => $description,
            'price'           => $price,
            'is_rental'       => $is_rental,
            'rental_price'    => $rental_price,
            'rental_duration' => $rental_duration,
            'product_image'   => $imageFileName
        ]);

        setFlashMessage("Product posted successfully!", "success");
        redirect('my_products.php');
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="container py-4">

    <div class="page-header text-center">
        <h1>Post a Product</h1>
        <p>List an item for sale or rent to fellow students.</p>
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

        <form method="POST" action="add_product.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Product Name</label>
                <input type="text" name="product_name" class="form-control" placeholder="e.g. Canon EOS M50 Camera" required>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Condition, included accessories, etc."></textarea>
            </div>

            <div class="row g-3 mb-3">
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
                    <label>Price (₱)</label>
                    <input type="number" step="0.01" name="price" class="form-control" placeholder="0.00" required>
                    <p class="form-text-hint">If this item is for rent, set the base price to 0 below.</p>
                </div>
            </div>

            <div class="form-check-custom mb-2">
                <input type="checkbox" name="is_rental" id="is_rental" onclick="toggleRentalFields()">
                <label class="mb-0" for="is_rental">This item is for RENT (not for sale)</label>
            </div>

            <div id="rentalFields" class="rental-fields-box" style="display:none;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Rental Price (₱)</label>
                        <input type="number" step="0.01" name="rental_price" class="form-control" placeholder="0.00">
                    </div>
                    <div class="col-md-6">
                        <label>Rental Duration</label>
                        <input type="text" name="rental_duration" class="form-control" placeholder='e.g. "per day"'>
                    </div>
                </div>
            </div>

            <hr class="form-section-divider">

            <div class="mb-4">
                <label>Product Image</label>
                <input type="file" name="product_image" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                <p class="form-text-hint">JPG, PNG, or WEBP. A clear photo helps your listing sell faster.</p>
            </div>

            <div class="form-actions">
                <a href="my_products.php" class="btn btn-outline-custom">Cancel</a>
                <button type="submit" class="btn btn-primary-custom">Post Product</button>
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

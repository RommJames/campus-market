<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

$product_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = $conn->prepare(
    "SELECT p.*, c.category_name, u.full_name AS seller_name, u.contact_number
     FROM products p
     JOIN categories c ON p.category_id = c.category_id
     JOIN users u ON p.user_id = u.user_id
     WHERE p.product_id = :id"
);
$stmt->execute(['id' => $product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    setFlashMessage("Product not found.", "error");
    redirect('browse_products.php');
}

$favStmt = $conn->prepare(
    "SELECT favorite_id FROM favorites WHERE user_id = :user_id AND product_id = :product_id"
);
$favStmt->execute(['user_id' => $_SESSION['user_id'], 'product_id' => $product_id]);
$isFavorited = $favStmt->rowCount() > 0;

require_once __DIR__ . '/../includes/header.php';
?>

<div class="container py-4">

    <a href="browse_products.php" class="text-decoration-none fw-semibold d-inline-block mb-3">&larr; Back to Browse</a>

    <div class="detail-card">
        <div class="row g-0">
            <div class="col-md-5">
                <img src="../uploads/<?= sanitize($product['product_image']) ?>" alt="<?= sanitize($product['product_name']) ?>">
            </div>
            <div class="col-md-7">
                <div class="detail-body">
                    <span class="badge-type mb-2"><?= sanitize($product['category_name']) ?></span>
                    <h1 class="mt-3 mb-2" style="font-size:28px; font-weight:700;"><?= sanitize($product['product_name']) ?></h1>

                    <span class="badge-status <?= sanitize($product['status']) ?>"><?= sanitize(ucfirst($product['status'])) ?></span>
                    <?php if ($product['is_rental']): ?>
                        <span class="badge-type">For Rent</span>
                    <?php else: ?>
                        <span class="badge-type">For Sale</span>
                    <?php endif; ?>

                    <div class="detail-price mt-3">
                        <?php if ($product['is_rental']): ?>
                            ₱<?= number_format($product['rental_price'], 2) ?> <small class="text-secondary fw-normal fs-6"><?= sanitize($product['rental_duration']) ?></small>
                        <?php else: ?>
                            ₱<?= number_format($product['price'], 2) ?>
                        <?php endif; ?>
                    </div>

                    <p class="text-secondary mt-3"><?= nl2br(sanitize($product['description'])) ?></p>

                    <div class="seller-box">
                        <p class="mb-1 fw-semibold"><i class="bi bi-person-circle"></i> <?= sanitize($product['seller_name']) ?></p>
                        <p class="mb-0 text-secondary small"><i class="bi bi-telephone"></i> <?= sanitize($product['contact_number']) ?></p>
                    </div>

                    <form method="POST" action="toggle_favorite.php" class="mt-4">
                        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                        <button type="submit" class="btn <?= $isFavorited ? 'btn-primary-custom' : 'btn-outline-custom' ?> w-100">
                            <i class="bi <?= $isFavorited ? 'bi-star-fill' : 'bi-star' ?>"></i>
                            <?= $isFavorited ? 'Remove from Favorites' : 'Add to Favorites' ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

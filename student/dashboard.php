<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

$stmt = $conn->prepare(
    "SELECT p.product_id, p.product_name, p.price, p.is_rental, p.rental_price,
            p.product_image, c.category_name
     FROM products p
     JOIN categories c ON p.category_id = c.category_id
     WHERE p.status = 'available'
     ORDER BY p.date_posted DESC
     LIMIT 6"
);
$stmt->execute();
$recentProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../includes/header.php';
?>

<div class="container py-4">

    <div class="hero mb-5">
        <h1>Hi, <?= sanitize($_SESSION['user_name']) ?> 👋</h1>
        <p>Buy, sell, rent, and offer creative services within your campus community.</p>

        <div class="search-box mt-4">
            <form method="GET" action="browse_products.php" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Search for textbooks, cameras, services...">
                <button type="submit" class="btn btn-primary-custom">Search</button>
            </form>
        </div>

        <div class="mt-4 d-flex gap-3 justify-content-center flex-wrap">
            <a href="add_product.php" class="btn btn-primary-custom"><i class="bi bi-plus-lg"></i> Post a Product</a>
            <a href="add_service.php" class="btn btn-outline-custom"><i class="bi bi-plus-lg"></i> Offer a Service</a>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="section-title mt-0 mb-0">Recently Posted</h2>
        <a href="browse_products.php" class="text-decoration-none fw-semibold">Browse All &rarr;</a>
    </div>

    <?php if (empty($recentProducts)): ?>
        <div class="empty-state">
            <i class="bi bi-bag empty-icon"></i>
            <h3>No products posted yet</h3>
            <p>Be the first to <a href="add_product.php">post something</a>.</p>
        </div>
    <?php else: ?>
        <div class="row g-4 mb-5">
            <?php foreach ($recentProducts as $product): ?>
            <div class="col-md-4">
                <a href="product_details.php?id=<?= $product['product_id'] ?>" class="text-decoration-none text-reset">
                    <div class="product-card">
                        <img src="../uploads/<?= sanitize($product['product_image']) ?>" alt="<?= sanitize($product['product_name']) ?>">
                        <div class="p-3">
                            <span class="badge-type mb-2"><?= sanitize($product['category_name']) ?></span>
                            <h5 class="mt-2 mb-1"><?= sanitize($product['product_name']) ?></h5>
                            <div class="price">
                                <?php if ($product['is_rental']): ?>
                                    ₱<?= number_format($product['rental_price'], 2) ?> <small class="text-secondary fw-normal">/ rental</small>
                                <?php else: ?>
                                    ₱<?= number_format($product['price'], 2) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

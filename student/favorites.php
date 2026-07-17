<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

$stmt = $conn->prepare(
    "SELECT p.product_id, p.product_name, p.price, p.is_rental, p.rental_price, p.product_image
     FROM favorites f
     JOIN products p ON f.product_id = p.product_id
     WHERE f.user_id = :user_id
     ORDER BY f.date_saved DESC"
);
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../includes/header.php';
?>

<div class="container py-4">

    <div class="page-header">
        <h1>My Favorites</h1>
        <p>Items you've saved for later.</p>
    </div>

    <?php if (empty($favorites)): ?>
        <div class="empty-state">
            <i class="bi bi-star empty-icon"></i>
            <h3>No favorites yet</h3>
            <p><a href="browse_products.php">Browse products</a> and save the ones you like.</p>
        </div>
    <?php else: ?>
        <div class="row g-4 mb-5">
            <?php foreach ($favorites as $item): ?>
            <div class="col-md-4">
                <a href="product_details.php?id=<?= $item['product_id'] ?>" class="text-decoration-none text-reset">
                    <div class="product-card">
                        <img src="../uploads/<?= sanitize($item['product_image']) ?>" alt="<?= sanitize($item['product_name']) ?>">
                        <div class="p-3">
                            <h5 class="mb-1"><?= sanitize($item['product_name']) ?></h5>
                            <div class="price">
                                <?php if ($item['is_rental']): ?>
                                    ₱<?= number_format($item['rental_price'], 2) ?> <small class="text-secondary fw-normal">/ rental</small>
                                <?php else: ?>
                                    ₱<?= number_format($item['price'], 2) ?>
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

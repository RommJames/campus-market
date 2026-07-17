<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

$stmt = $conn->prepare(
    "SELECT p.product_id, p.product_name, p.price, p.is_rental, p.rental_price,
            p.product_image, p.status, c.category_name
     FROM products p
     JOIN categories c ON p.category_id = c.category_id
     WHERE p.user_id = :user_id
     ORDER BY p.date_posted DESC"
);
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../includes/header.php';
?>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 mt-3">
        <div>
            <h1 class="mb-1" style="font-weight:700;">My Listings</h1>
            <p class="text-secondary mb-0">Manage the products you've posted.</p>
        </div>
        <a href="add_product.php" class="btn btn-primary-custom"><i class="bi bi-plus-lg"></i> Post a New Product</a>
    </div>

    <?php if (empty($products)): ?>
        <div class="empty-state">
            <i class="bi bi-bag empty-icon"></i>
            <h3>You haven't posted any products yet</h3>
            <p><a href="add_product.php">Post your first product</a> to get started.</p>
        </div>
    <?php else: ?>
        <div class="table-card">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><img src="../uploads/<?= sanitize($product['product_image']) ?>" class="table-thumb" alt="product image"></td>
                            <td class="fw-semibold"><?= sanitize($product['product_name']) ?></td>
                            <td><?= sanitize($product['category_name']) ?></td>
                            <td>
                                <?php if ($product['is_rental']): ?>
                                    ₱<?= number_format($product['rental_price'], 2) ?> <span class="text-secondary small">/ rental</span>
                                <?php else: ?>
                                    ₱<?= number_format($product['price'], 2) ?>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge-status <?= sanitize($product['status']) ?>"><?= sanitize(ucfirst($product['status'])) ?></span></td>
                            <td class="row-actions">
                                <a href="edit_product.php?id=<?= $product['product_id'] ?>" class="action-edit">Edit</a>
                                <a href="delete_product.php?id=<?= $product['product_id'] ?>" class="action-delete"
                                   onclick="return confirm('Are you sure you want to delete this listing?');">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

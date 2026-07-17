<?php
require_once __DIR__ . '/../includes/admin_auth_check.php';
require_once __DIR__ . '/../config/database.php';

$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';

$sql = "SELECT p.product_id, p.product_name, p.price, p.is_rental, p.rental_price,
               p.status, p.date_posted, c.category_name, u.full_name AS seller_name
        FROM products p
        JOIN categories c ON p.category_id = c.category_id
        JOIN users u ON p.user_id = u.user_id";
$params = [];

if (!empty($search)) {
    $sql .= " WHERE p.product_name LIKE :search OR u.full_name LIKE :search";
    $params['search'] = "%$search%";
}
$sql .= " ORDER BY p.date_posted DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../includes/admin_header.php';
?>

<div class="container py-4">

    <div class="page-header">
        <h1>Manage Products</h1>
        <p>Moderate all product listings across the marketplace.</p>
    </div>

    <form method="GET" action="manage_products.php" class="filter-bar">
        <input type="text" name="search" class="form-control" placeholder="Search by product or seller name" value="<?= sanitize($search) ?>">
        <button type="submit" class="btn btn-primary-custom">Search</button>
        <a href="manage_products.php" class="btn btn-outline-custom">Clear</a>
    </form>

    <?php if (empty($products)): ?>
        <div class="empty-state">
            <i class="bi bi-bag empty-icon"></i>
            <h3>No products found</h3>
        </div>
    <?php else: ?>
        <div class="table-card">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Seller</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Date Posted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td class="fw-semibold"><?= sanitize($product['product_name']) ?></td>
                            <td><?= sanitize($product['category_name']) ?></td>
                            <td><?= sanitize($product['seller_name']) ?></td>
                            <td>
                                <?php if ($product['is_rental']): ?>
                                    ₱<?= number_format($product['rental_price'], 2) ?> <span class="text-secondary small">/ rental</span>
                                <?php else: ?>
                                    ₱<?= number_format($product['price'], 2) ?>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge-status <?= sanitize($product['status']) ?>"><?= sanitize(ucfirst($product['status'])) ?></span></td>
                            <td class="text-secondary"><?= sanitize($product['date_posted']) ?></td>
                            <td class="row-actions">
                                <a href="delete_product.php?id=<?= $product['product_id'] ?>" class="action-delete"
                                   onclick="return confirm('Remove this product listing?');">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>

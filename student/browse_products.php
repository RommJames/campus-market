<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

$search      = isset($_GET['search']) ? sanitize($_GET['search']) : '';
$category_id = isset($_GET['category_id']) ? (int) $_GET['category_id'] : 0;

$sql = "SELECT p.product_id, p.product_name, p.price, p.is_rental, p.rental_price,
               p.product_image, c.category_name, u.full_name AS seller_name
        FROM products p
        JOIN categories c ON p.category_id = c.category_id
        JOIN users u ON p.user_id = u.user_id
        WHERE p.status = 'available'";

$params = [];

if (!empty($search)) {
    $sql .= " AND (p.product_name LIKE :search OR p.description LIKE :search)";
    $params['search'] = "%$search%";
}

if ($category_id > 0) {
    $sql .= " AND p.category_id = :category_id";
    $params['category_id'] = $category_id;
}

$sql .= " ORDER BY p.date_posted DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$categories = $conn->query("SELECT category_id, category_name FROM categories ORDER BY category_name")
                    ->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../includes/header.php';
?>

<div class="container py-4">

    <div class="page-header text-center">
        <h1>Browse Products</h1>
        <p>Find academic materials, gear, and equipment from fellow students.</p>
    </div>

    <form method="GET" action="browse_products.php" class="filter-bar">
        <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?= sanitize($search) ?>">

        <select name="category_id" class="form-select" style="max-width:240px;">
            <option value="0">All Categories</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['category_id'] ?>" <?= $category_id == $cat['category_id'] ? 'selected' : '' ?>>
                    <?= sanitize($cat['category_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn btn-primary-custom">Search</button>
        <a href="browse_products.php" class="btn btn-outline-custom">Clear</a>
    </form>

    <?php if (empty($products)): ?>
        <div class="empty-state">
            <i class="bi bi-search empty-icon"></i>
            <h3>No products found</h3>
            <p>Try a different search term or category.</p>
        </div>
    <?php else: ?>
        <div class="row g-4 mb-5">
            <?php foreach ($products as $product): ?>
            <div class="col-md-4">
                <a href="product_details.php?id=<?= $product['product_id'] ?>" class="text-decoration-none text-reset">
                    <div class="product-card">
                        <img src="../uploads/<?= sanitize($product['product_image']) ?>" alt="<?= sanitize($product['product_name']) ?>">
                        <div class="p-3">
                            <span class="badge-type mb-2"><?= sanitize($product['category_name']) ?></span>
                            <h5 class="mt-2 mb-1"><?= sanitize($product['product_name']) ?></h5>
                            <p class="text-secondary small mb-2">by <?= sanitize($product['seller_name']) ?></p>
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

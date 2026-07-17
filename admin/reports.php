<?php
require_once __DIR__ . '/../includes/admin_auth_check.php';
require_once __DIR__ . '/../config/database.php';

$productsByCategory = $conn->query(
    "SELECT c.category_name, COUNT(p.product_id) AS total
     FROM categories c
     LEFT JOIN products p ON c.category_id = p.category_id
     GROUP BY c.category_id, c.category_name
     ORDER BY total DESC"
)->fetchAll(PDO::FETCH_ASSOC);

$productsByStatus = $conn->query(
    "SELECT status, COUNT(*) AS total FROM products GROUP BY status"
)->fetchAll(PDO::FETCH_ASSOC);

$topSellers = $conn->query(
    "SELECT u.full_name, COUNT(p.product_id) AS total_listings
     FROM users u
     JOIN products p ON u.user_id = p.user_id
     GROUP BY u.user_id, u.full_name
     ORDER BY total_listings DESC
     LIMIT 5"
)->fetchAll(PDO::FETCH_ASSOC);

$rentalSplit = $conn->query(
    "SELECT is_rental, COUNT(*) AS total FROM products GROUP BY is_rental"
)->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../includes/admin_header.php';
?>

<div class="container py-4">

    <div class="page-header">
        <h1>Marketplace Reports</h1>
        <p>A snapshot of marketplace activity.</p>
    </div>

    <div class="row g-4">

        <div class="col-md-6">
            <div class="report-card">
                <h3><i class="bi bi-tags"></i> Products per Category</h3>
                <?php foreach ($productsByCategory as $row): ?>
                    <div class="report-row">
                        <span><?= sanitize($row['category_name']) ?></span>
                        <span class="report-count"><?= $row['total'] ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-md-6">
            <div class="report-card">
                <h3><i class="bi bi-clipboard-check"></i> Products by Status</h3>
                <?php if (empty($productsByStatus)): ?>
                    <p class="text-secondary mb-0">No products yet.</p>
                <?php endif; ?>
                <?php foreach ($productsByStatus as $row): ?>
                    <div class="report-row">
                        <span class="badge-status <?= sanitize($row['status']) ?>"><?= sanitize(ucfirst($row['status'])) ?></span>
                        <span class="report-count"><?= $row['total'] ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-md-6">
            <div class="report-card">
                <h3><i class="bi bi-arrow-left-right"></i> Sale vs. Rental Listings</h3>
                <?php if (empty($rentalSplit)): ?>
                    <p class="text-secondary mb-0">No products yet.</p>
                <?php endif; ?>
                <?php foreach ($rentalSplit as $row): ?>
                    <div class="report-row">
                        <span><?= $row['is_rental'] ? 'For Rent' : 'For Sale' ?></span>
                        <span class="report-count"><?= $row['total'] ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-md-6">
            <div class="report-card">
                <h3><i class="bi bi-trophy"></i> Top 5 Most Active Sellers</h3>
                <?php if (empty($topSellers)): ?>
                    <p class="text-secondary mb-0">No listings posted yet.</p>
                <?php endif; ?>
                <?php foreach ($topSellers as $row): ?>
                    <div class="report-row">
                        <span><?= sanitize($row['full_name']) ?></span>
                        <span class="report-count"><?= $row['total_listings'] ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

</div>

<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>

<?php
require_once __DIR__ . '/../includes/admin_auth_check.php';
require_once __DIR__ . '/../config/database.php';

$totalUsers      = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalProducts   = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalServices   = $conn->query("SELECT COUNT(*) FROM services")->fetchColumn();
$totalCategories = $conn->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$totalOrders     = $conn->query("SELECT COUNT(*) FROM orders")->fetchColumn();

$recentUsersStmt = $conn->query(
    "SELECT full_name, email, date_registered FROM users ORDER BY date_registered DESC LIMIT 5"
);
$recentUsers = $recentUsersStmt->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../includes/admin_header.php';
?>

<div class="container py-4">

    <div class="page-header">
        <h1>Admin Dashboard</h1>
        <p>Overview of marketplace activity.</p>
    </div>

    <div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-lg-5 mb-4">
        <div class="col">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-people"></i></div>
                <div>
                    <div class="stat-value"><?= $totalUsers ?></div>
                    <div class="stat-label">Students</div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-bag"></i></div>
                <div>
                    <div class="stat-value"><?= $totalProducts ?></div>
                    <div class="stat-label">Products</div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-stars"></i></div>
                <div>
                    <div class="stat-value"><?= $totalServices ?></div>
                    <div class="stat-label">Services</div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-tags"></i></div>
                <div>
                    <div class="stat-value"><?= $totalCategories ?></div>
                    <div class="stat-label">Categories</div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-receipt"></i></div>
                <div>
                    <div class="stat-value"><?= $totalOrders ?></div>
                    <div class="stat-label">Orders</div>
                </div>
            </div>
        </div>
    </div>

    <h2 class="section-title">Recently Registered Students</h2>

    <?php if (empty($recentUsers)): ?>
        <div class="empty-state">
            <i class="bi bi-person empty-icon"></i>
            <h3>No students registered yet</h3>
        </div>
    <?php else: ?>
        <div class="table-card">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentUsers as $user): ?>
                        <tr>
                            <td class="fw-semibold"><?= sanitize($user['full_name']) ?></td>
                            <td><?= sanitize($user['email']) ?></td>
                            <td class="text-secondary"><?= sanitize($user['date_registered']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>

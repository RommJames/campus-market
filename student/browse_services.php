<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';

$sql = "SELECT s.service_id, s.service_name, s.description, s.price, c.category_name, u.full_name AS provider_name
        FROM services s
        JOIN categories c ON s.category_id = c.category_id
        JOIN users u ON s.user_id = u.user_id
        WHERE s.status = 'available'";

$params = [];
if (!empty($search)) {
    $sql .= " AND (s.service_name LIKE :search OR s.description LIKE :search)";
    $params['search'] = "%$search%";
}
$sql .= " ORDER BY s.date_posted DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../includes/header.php';
?>

<div class="container py-4">

    <div class="page-header text-center">
        <h1>Creative Services Directory</h1>
        <p>Photography, editing, design, music, and more — offered by fellow students.</p>
    </div>

    <form method="GET" action="browse_services.php" class="filter-bar">
        <input type="text" name="search" class="form-control" placeholder="Search services..." value="<?= sanitize($search) ?>">
        <button type="submit" class="btn btn-primary-custom">Search</button>
        <a href="browse_services.php" class="btn btn-outline-custom">Clear</a>
    </form>

    <?php if (empty($services)): ?>
        <div class="empty-state">
            <i class="bi bi-stars empty-icon"></i>
            <h3>No services found</h3>
            <p>Try a different search, or <a href="add_service.php">offer your own service</a>.</p>
        </div>
    <?php else: ?>
        <div class="row g-4 mb-5">
            <?php foreach ($services as $service): ?>
            <div class="col-md-4">
                <div class="service-card">
                    <div class="service-icon"><i class="bi bi-camera-reels"></i></div>
                    <span class="badge-type mb-2"><?= sanitize($service['category_name']) ?></span>
                    <h5 class="mt-2"><?= sanitize($service['service_name']) ?></h5>
                    <p class="service-provider">by <?= sanitize($service['provider_name']) ?></p>
                    <p class="service-desc"><?= sanitize($service['description']) ?></p>
                    <div class="price">₱<?= number_format($service['price'], 2) ?> <small class="text-secondary fw-normal">starting</small></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

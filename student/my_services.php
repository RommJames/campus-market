<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

$stmt = $conn->prepare(
    "SELECT s.service_id, s.service_name, s.price, s.status, c.category_name
     FROM services s
     JOIN categories c ON s.category_id = c.category_id
     WHERE s.user_id = :user_id
     ORDER BY s.date_posted DESC"
);
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../includes/header.php';
?>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 mt-3">
        <div>
            <h1 class="mb-1" style="font-weight:700;">My Services</h1>
            <p class="text-secondary mb-0">Manage the creative services you offer.</p>
        </div>
        <a href="add_service.php" class="btn btn-primary-custom"><i class="bi bi-plus-lg"></i> Offer a New Service</a>
    </div>

    <?php if (empty($services)): ?>
        <div class="empty-state">
            <i class="bi bi-stars empty-icon"></i>
            <h3>You haven't posted any services yet</h3>
            <p><a href="add_service.php">Offer your first service</a> to get started.</p>
        </div>
    <?php else: ?>
        <div class="table-card">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($services as $service): ?>
                        <tr>
                            <td class="fw-semibold"><?= sanitize($service['service_name']) ?></td>
                            <td><?= sanitize($service['category_name']) ?></td>
                            <td>₱<?= number_format($service['price'], 2) ?></td>
                            <td><span class="badge-status <?= sanitize($service['status']) ?>"><?= sanitize(ucfirst($service['status'])) ?></span></td>
                            <td class="row-actions">
                                <a href="delete_service.php?id=<?= $service['service_id'] ?>" class="action-delete"
                                   onclick="return confirm('Delete this service?');">Delete</a>
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

<?php
require_once __DIR__ . '/../includes/admin_auth_check.php';
require_once __DIR__ . '/../config/database.php';

$stmt = $conn->query(
    "SELECT s.service_id, s.service_name, s.price, s.status, s.date_posted,
            c.category_name, u.full_name AS provider_name
     FROM services s
     JOIN categories c ON s.category_id = c.category_id
     JOIN users u ON s.user_id = u.user_id
     ORDER BY s.date_posted DESC"
);
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../includes/admin_header.php';
?>

<div class="container py-4">

    <div class="page-header">
        <h1>Manage Services</h1>
        <p>Moderate creative services offered by students.</p>
    </div>

    <?php if (empty($services)): ?>
        <div class="empty-state">
            <i class="bi bi-stars empty-icon"></i>
            <h3>No services posted yet</h3>
        </div>
    <?php else: ?>
        <div class="table-card">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Category</th>
                            <th>Provider</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Date Posted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($services as $service): ?>
                        <tr>
                            <td class="fw-semibold"><?= sanitize($service['service_name']) ?></td>
                            <td><?= sanitize($service['category_name']) ?></td>
                            <td><?= sanitize($service['provider_name']) ?></td>
                            <td>₱<?= number_format($service['price'], 2) ?></td>
                            <td><span class="badge-status <?= sanitize($service['status']) ?>"><?= sanitize(ucfirst($service['status'])) ?></span></td>
                            <td class="text-secondary"><?= sanitize($service['date_posted']) ?></td>
                            <td class="row-actions">
                                <a href="delete_service.php?id=<?= $service['service_id'] ?>" class="action-delete"
                                   onclick="return confirm('Remove this service listing?');">Delete</a>
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

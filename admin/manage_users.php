<?php
require_once __DIR__ . '/../includes/admin_auth_check.php';
require_once __DIR__ . '/../config/database.php';

$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';

$sql = "SELECT user_id, full_name, email, student_id, contact_number, date_registered FROM users";
$params = [];

if (!empty($search)) {
    $sql .= " WHERE full_name LIKE :search OR email LIKE :search OR student_id LIKE :search";
    $params['search'] = "%$search%";
}
$sql .= " ORDER BY date_registered DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../includes/admin_header.php';
?>

<div class="container py-4">

    <div class="page-header">
        <h1>Manage Users</h1>
        <p>View and remove student accounts.</p>
    </div>

    <form method="GET" action="manage_users.php" class="filter-bar">
        <input type="text" name="search" class="form-control" placeholder="Search by name, email, or student ID" value="<?= sanitize($search) ?>">
        <button type="submit" class="btn btn-primary-custom">Search</button>
        <a href="manage_users.php" class="btn btn-outline-custom">Clear</a>
    </form>

    <?php if (empty($users)): ?>
        <div class="empty-state">
            <i class="bi bi-person empty-icon"></i>
            <h3>No students found</h3>
        </div>
    <?php else: ?>
        <div class="table-card">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Student ID</th>
                            <th>Contact</th>
                            <th>Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="fw-semibold"><?= sanitize($user['full_name']) ?></td>
                            <td><?= sanitize($user['email']) ?></td>
                            <td><?= sanitize($user['student_id'] ?? '—') ?></td>
                            <td><?= sanitize($user['contact_number']) ?></td>
                            <td class="text-secondary"><?= sanitize($user['date_registered']) ?></td>
                            <td class="row-actions">
                                <a href="delete_user.php?id=<?= $user['user_id'] ?>" class="action-delete"
                                   onclick="return confirm('Delete this user? This will also remove all their products, services, favorites, and orders.');">
                                   Delete
                                </a>
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

<?php 
ob_start();
require_once __DIR__ . "/../sidebar.php";

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$role    = $_SESSION['role'] ?? '';

// Handle actions
if (isset($_GET['action'], $_GET['id'])) {
    $id = intval($_GET['id']);
    if ($_GET['action'] === 'read') {
        $conn->query("UPDATE notifications SET status='read' WHERE id=$id AND user_id=$user_id");
    } elseif ($_GET['action'] === 'unread') {
        $conn->query("UPDATE notifications SET status='unread' WHERE id=$id AND user_id=$user_id");
    } elseif ($_GET['action'] === 'delete') {
        $conn->query("DELETE FROM notifications WHERE id=$id AND user_id=$user_id");
    }
    header("Location: notifications.php");
    exit;
}

// Fetch notifications for this user
$result = $conn->query("SELECT * FROM notifications WHERE user_id=$user_id ORDER BY created_at DESC");
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
          <h3 class="text-danger fw-bold mb-4">🔔 My Notifications</h3>

          <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
              <thead class="table-danger text-center">
                <tr>
                  <th>#</th>
                  <th>Message</th>
                  <th>Type</th>
                  <th>Status</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($result->num_rows > 0): ?>
                  <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="<?= $row['status'] === 'unread' ? 'table-light fw-bold' : '' ?>">
                      <td class="text-center"><?= $row['id']; ?></td>
                      <td><?= htmlspecialchars($row['message']); ?></td>
                      <td class="text-capitalize text-center"><?= $row['type']; ?></td>
                      <td class="text-center">
                        <?php if ($row['status'] === 'unread'): ?>
                          <span class="badge bg-warning text-dark">Unread</span>
                        <?php else: ?>
                          <span class="badge bg-success">Read</span>
                        <?php endif; ?>
                      </td>
                      <td class="text-center"><?= $row['created_at']; ?></td>
                      <td class="text-center">
                        <?php if ($row['status'] === 'unread'): ?>
                          <a href="notifications.php?action=read&id=<?= $row['id']; ?>" class="btn btn-sm btn-primary">Mark Read</a>
                        <?php else: ?>
                          <a href="notifications.php?action=unread&id=<?= $row['id']; ?>" class="btn btn-sm btn-secondary">Mark Unread</a>
                        <?php endif; ?>
                        <a href="notifications.php?action=delete&id=<?= $row['id']; ?>" 
                           onclick="return confirm('Delete this notification?');" 
                           class="btn btn-sm btn-danger">Delete</a>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="text-center text-muted">No notifications yet.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php include "../footer.php"; ob_end_flush(); ?>

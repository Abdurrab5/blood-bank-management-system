<?php ob_start();
require_once __DIR__ ."/../sidebar.php";
is_Admin();
// Handle delete action
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $msg = '<div class="alert alert-success">✅ Message deleted successfully.</div>';
    } else {
        $msg = '<div class="alert alert-danger">❌ Failed to delete message.</div>';
    }
}

// Fetch all messages
$result = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
?>

<div class="container my-5">
  <h2 class="fw-bold mb-4 text-danger">📩 Contact Messages</h2>

  <?php if (!empty($msg)) echo $msg; ?>

  <div class="table-responsive shadow bg-white rounded p-3">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-danger text-center">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Subject</th>
          <th>Message</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td class="text-center"><?= $row['id']; ?></td>
              <td><?= htmlspecialchars($row['name']); ?></td>
              <td><?= htmlspecialchars($row['email']); ?></td>
              <td><?= htmlspecialchars($row['subject']); ?></td>
              <td><?= nl2br(htmlspecialchars($row['message'])); ?></td>
              <td class="text-center"><?= $row['created_at']; ?></td>
              <td class="text-center">
                <a href="contact_messages.php?delete=<?= $row['id']; ?>" 
                   onclick="return confirm('Are you sure you want to delete this message?');" 
                   class="btn btn-sm btn-danger">
                  Delete
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="text-center text-muted">No messages found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</div>
<?php include "../footer.php"; ob_end_flush();?>


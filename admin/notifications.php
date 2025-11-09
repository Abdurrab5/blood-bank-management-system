<?php ob_start();
require_once __DIR__ ."/../sidebar.php";
is_Admin();
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['send'])){
    $user_id = $_POST['user_id']; 
    $message = $_POST['message'];

    if($user_id == 'all'){
        $res = $conn->query("SELECT id FROM users");
        while($u = $res->fetch_assoc()){
            $s = $conn->prepare("INSERT INTO notifications (user_id, message, type) VALUES (?, ?, 'info')");
            $s->bind_param("is", $u['id'], $message); 
            $s->execute();
        }
    } else {
        $s = $conn->prepare("INSERT INTO notifications (user_id, message, type) VALUES (?, ?, 'info')");
        $s->bind_param("is", $user_id, $message); 
        $s->execute();
    }
    flash('msg','✅ Notification sent'); 
    redirect('notifications.php');
}

// fetch notifications
$res = $conn->query("SELECT n.*, u.full_name 
                     FROM notifications n 
                     JOIN users u ON n.user_id = u.id 
                     ORDER BY n.created_at DESC LIMIT 100");
$usersRes = $conn->query("SELECT id, full_name FROM users ORDER BY role DESC, full_name ASC");
?>

<div class="col-md-9 col-lg-10 p-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-danger mb-0"><i class="bi bi-bell-fill me-2"></i>Notifications</h3>
  </div>

  <?= flash('msg') ?>

  <!-- Send Notification Card -->
  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-danger text-white">
      <i class="bi bi-megaphone-fill me-2"></i> Send Notification
    </div>
    <div class="card-body">
      <form method="POST" class="row g-3 align-items-center">
        <div class="col-md-4">
          <label class="form-label fw-bold">Recipient</label>
          <select name="user_id" class="form-select">
            <option value="all">All Users</option>
            <?php while($u = $usersRes->fetch_assoc()): ?>
              <option value="<?= $u['id'] ?>"><?= e($u['full_name']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-bold">Message</label>
          <input name="message" class="form-control" placeholder="Type your notification..." required>
        </div>
        <div class="col-md-2 mt-4">
          <button name="send" class="btn btn-danger w-100">
            <i class="bi bi-send-fill"></i> Send
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Notifications List -->
  <div class="card shadow-sm border-0">
    <div class="card-header bg-light fw-bold">
      <i class="bi bi-list-ul me-2"></i> Recent Notifications
    </div>
    <div class="card-body p-0">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-danger text-center">
          <tr>
            <th>#</th>
            <th>User</th>
            <th>Message</th>
            <th>Type</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; while($row=$res->fetch_assoc()): ?>
          <tr>
            <td class="text-center fw-bold"><?= $i ?></td>
            <td><?= e($row['full_name']) ?></td>
            <td><?= e($row['message']) ?></td>
            <td class="text-center">
              <span class="badge bg-info text-dark px-3"><?= ucfirst($row['type']) ?></span>
            </td>
            <td><small class="text-muted"><i class="bi bi-clock-history me-1"></i><?= e($row['created_at']) ?></small></td>
          </tr>
          <?php $i++; endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>

<?php include "../footer.php"; ob_end_flush();?>

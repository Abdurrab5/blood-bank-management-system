<?php ob_start();
require_once __DIR__ ."/../sidebar.php";
is_Admin();
// Handle approve/reject/delete
if(isset($_GET['action']) && isset($_GET['id'])){
    $id = intval($_GET['id']);
    if($_GET['action'] === 'approve'){
        $stmt = $conn->prepare("UPDATE donors SET status='approved' WHERE id=?");
        $stmt->bind_param("i", $id); $stmt->execute();
        flash('msg', '✅ Donor approved successfully.');
        redirect('donors.php');
    } elseif($_GET['action'] === 'reject'){
        $stmt = $conn->prepare("UPDATE donors SET status='rejected' WHERE id=?");
        $stmt->bind_param("i", $id); $stmt->execute();
        flash('msg', '⚠️ Donor rejected.');
        redirect('donors.php');
    } elseif($_GET['action'] === 'delete'){
        $stmt = $conn->prepare("DELETE FROM donors WHERE id=?");
        $stmt->bind_param("i", $id); $stmt->execute();
        flash('msg', '🗑️ Donor deleted.');
        redirect('donors.php');
    }
}

// Add donor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_donor'])) {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $blood_group = $_POST['blood_group'];

    // Check for duplicate email or phone
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR phone = ?");
    $stmt->bind_param("ss", $email, $phone);
    $stmt->execute();
    $check = $stmt->get_result();

    if ($check->num_rows > 0) {
      flash('msg', '⚠️ Email or Phone already exists. Please use a different one.');
       
    } else {
        // Insert into users
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role, phone) VALUES (?, ?, ?, 'donor', ?)");
        $stmt->bind_param("ssss", $full_name, $email, $password, $phone);
        if ($stmt->execute()) {
            $userId = $conn->insert_id;
            $stmt2 = $conn->prepare("INSERT INTO donors (user_id, blood_group, status) VALUES (?, ?, 'approved')");
            $stmt2->bind_param("is", $userId, $blood_group);
            $stmt2->execute();

            flash('msg', '🎉 Donor added successfully.');
            redirect('donors.php');
        } else {
            $err = "Error: " . $conn->error;
        }
    }
}

// fetch donors
$stmt = $conn->prepare("SELECT d.*, u.full_name, u.email, u.phone FROM donors d JOIN users u ON d.user_id = u.id ORDER BY d.created_at DESC");
$stmt->execute();
$res = $stmt->get_result();
?>

<div class="col-md-9 col-lg-10 p-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-danger mb-0"><i class="bi bi-heart-fill me-2"></i>Donors</h3>
    <button class="btn btn-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#addDonorModal">
      <i class="bi bi-person-plus"></i> Add Donor
    </button>
  </div>

  <?= flash('msg') ?>

  <div class="card shadow border-0">
    <div class="card-body">
      <table class="table align-middle table-hover">
        <thead class="table-danger text-center">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Blood Group</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php $i=1; while($row = $res->fetch_assoc()): ?>
          <tr>
            <td class="text-center fw-bold"><?= $i ?></td>
            <td><?= e($row['full_name']) ?><br><small class="text-muted"><?= e($row['phone']) ?></small></td>
            <td><?= e($row['email']) ?></td>
            <td class="text-center"><span class="badge bg-danger rounded-pill px-3"><?= e($row['blood_group']) ?></span></td>
            <td class="text-center">
              <?php if($row['status'] === 'approved'): ?>
                <span class="badge bg-success">Approved</span>
              <?php elseif($row['status'] === 'rejected'): ?>
                <span class="badge bg-warning text-dark">Rejected</span>
              <?php else: ?>
                <span class="badge bg-secondary">Pending</span>
              <?php endif; ?>
            </td>
            <td class="text-center">
              <a class="btn btn-sm btn-success me-1" href="donors.php?action=approve&id=<?= $row['id'] ?>"><i class="bi bi-check-circle"></i></a>
              <a class="btn btn-sm btn-warning me-1" href="donors.php?action=reject&id=<?= $row['id'] ?>"><i class="bi bi-x-circle"></i></a>
              <a class="btn btn-sm btn-danger" href="donors.php?action=delete&id=<?= $row['id'] ?>" onclick="return confirm('Are you sure to delete this donor?')"><i class="bi bi-trash"></i></a>
            </td>
          </tr>
        <?php $i++; endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Add Donor Modal -->
<div class="modal fade" id="addDonorModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" class="modal-content shadow-lg border-0">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="bi bi-person-plus me-2"></i>Add Donor</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3"><label class="form-label fw-bold">Full Name</label><input name="full_name" class="form-control" required></div>
        <div class="mb-3"><label class="form-label fw-bold">Email</label><input name="email" type="email" class="form-control" required></div>
        <div class="mb-3"><label class="form-label fw-bold">Phone</label><input name="phone" class="form-control"></div>
        <div class="mb-3"><label class="form-label fw-bold">Password</label><input name="password" type="password" class="form-control" required></div>
        <div class="mb-3"><label class="form-label fw-bold">Blood Group</label>
          <select name="blood_group" class="form-select" required>
            <option value="">Select...</option>
            <option>A+</option><option>A-</option><option>B+</option><option>B-</option>
            <option>AB+</option><option>AB-</option><option>O+</option><option>O-</option>
          </select>
        </div>
        <?php if(isset($err)): ?><div class="alert alert-danger"><?= e($err) ?></div><?php endif; ?>
      </div>
      <div class="modal-footer">
        <button type="submit" name="add_donor" class="btn btn-danger"><i class="bi bi-save me-1"></i> Save</button>
      </div>
    </form>
  </div>
</div>
</div>
<?php include "../footer.php"; ob_end_flush();?>

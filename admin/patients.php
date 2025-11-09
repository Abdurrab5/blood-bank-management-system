<?php ob_start();
require_once __DIR__ ."/../sidebar.php";
is_Admin();
/* ------------------ Handle Actions ------------------ */

// Approve / Reject / Delete
if (isset($_GET['action'], $_GET['id'])) {
    $id = intval($_GET['id']);
    if ($_GET['action'] === 'approve') {
        $stmt = $conn->prepare("UPDATE patients SET status='approved' WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        flash('msg', '✅ Patient approved');
    } elseif ($_GET['action'] === 'reject') {
        $stmt = $conn->prepare("UPDATE patients SET status='rejected' WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        flash('msg', '⚠️ Patient rejected');
    } elseif ($_GET['action'] === 'delete') {
        $stmt = $conn->prepare("DELETE FROM patients WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        flash('msg', '🗑️ Patient deleted');
    }
    redirect('patients.php');
}

// Add patient
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_patient'])) {
    $name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $disease = trim($_POST['disease_info']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // ✅ Check for duplicate email or phone
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR phone = ?");
    $stmt->bind_param("ss", $email, $phone);
    $stmt->execute();
    $check = $stmt->get_result();

    if ($check->num_rows > 0) {
        flash('msg', '⚠️ Email or Phone already exists. Please use a different one.');
        redirect('patients.php');
    } else {
        // Insert into users
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, password, role) VALUES (?, ?, ?, ?, 'patient')");
        $stmt->bind_param("ssss", $name, $email, $phone, $password);

        if ($stmt->execute()) {
            $user_id = $conn->insert_id;

            // Insert into patients
            $stmt2 = $conn->prepare("INSERT INTO patients (user_id, disease_info, status) VALUES (?, ?, 'pending')");
            $stmt2->bind_param("is", $user_id, $disease);
            $stmt2->execute();

            flash('msg', '✅ Patient added successfully');
        } else {
            flash('msg', '❌ Error: ' . $conn->error);
        }
        redirect('patients.php');
    }
}

// Update patient
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_patient'])) {
    $id = intval($_POST['id']);
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $disease = $_POST['disease_info'];

    $stmt = $conn->prepare("UPDATE users u 
        JOIN patients p ON u.id = p.user_id 
        SET u.full_name=?, u.email=?, u.phone=?, p.disease_info=? 
        WHERE p.id=?");
    $stmt->bind_param("ssssi", $name, $email, $phone, $disease, $id);
    $stmt->execute();

    flash('msg', '✏️ Patient updated');
    redirect('patients.php');
}

/* ------------------ Fetch Patients ------------------ */
$stmt = $conn->prepare("SELECT p.*, u.full_name, u.email, u.phone 
                        FROM patients p 
                        JOIN users u ON p.user_id = u.id 
                        ORDER BY p.created_at DESC");
$stmt->execute();
$res = $stmt->get_result();
$patients = $res->fetch_all(MYSQLI_ASSOC);
?>

<div class="col-md-9 col-lg-10 p-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-danger mb-0"><i class="bi bi-people-fill me-2"></i>Patients</h3>
    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addPatientModal">
      <i class="bi bi-person-plus"></i> Add Patient
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
            <th>Disease</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; foreach($patients as $row): ?>
          <tr>
            <td class="text-center fw-bold"><?= $i ?></td>
            <td>
              <?= e($row['full_name']) ?><br>
              <small class="text-muted"><i class="bi bi-telephone"></i> <?= e($row['phone']) ?></small>
            </td>
            <td><?= e($row['email']) ?></td>
            <td><span class="badge bg-secondary px-3 py-2"><?= e($row['disease_info']) ?></span></td>
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
              <a class="btn btn-sm btn-success me-1" href="patients.php?action=approve&id=<?= $row['id'] ?>" title="Approve"><i class="bi bi-check-circle"></i></a>
              <a class="btn btn-sm btn-warning me-1" href="patients.php?action=reject&id=<?= $row['id'] ?>" title="Reject"><i class="bi bi-x-circle"></i></a>
              <button class="btn btn-sm btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editPatientModal<?= $row['id'] ?>"><i class="bi bi-pencil-square"></i></button>
              <a class="btn btn-sm btn-danger" href="patients.php?action=delete&id=<?= $row['id'] ?>" onclick="return confirm('Delete patient?')" title="Delete"><i class="bi bi-trash"></i></a>
            </td>
          </tr>
          <?php $i++; endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Add Patient Modal -->
<div class="modal fade" id="addPatientModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Patient</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3"><label>Full Name</label>
          <input type="text" name="full_name" class="form-control" required>
        </div>
        <div class="mb-3"><label>Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3"><label>Phone</label>
          <input type="text" name="phone" class="form-control">
        </div>
        <div class="mb-3"><label>Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3"><label>Disease Info</label>
          <input type="text" name="disease_info" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="add_patient" class="btn btn-danger">Add Patient</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Patient Modals (outside table loop) -->
<?php foreach($patients as $row): ?>
<div class="modal fade" id="editPatientModal<?= $row['id'] ?>" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Patient</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <div class="mb-3"><label>Full Name</label>
          <input type="text" name="full_name" class="form-control" value="<?= e($row['full_name']) ?>" required>
        </div>
        <div class="mb-3"><label>Email</label>
          <input type="email" name="email" class="form-control" value="<?= e($row['email']) ?>" required>
        </div>
        <div class="mb-3"><label>Phone</label>
          <input type="text" name="phone" class="form-control" value="<?= e($row['phone']) ?>">
        </div>
        <div class="mb-3"><label>Disease Info</label>
          <input type="text" name="disease_info" class="form-control" value="<?= e($row['disease_info']) ?>">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="update_patient" class="btn btn-primary">Save Changes</button>
      </div>
    </form>
  </div>
</div>
<?php endforeach; ?>
</div>
<?php include "../footer.php"; ob_end_flush();?>

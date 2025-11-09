<?php ob_start();
require_once __DIR__ . "/../sidebar.php";
is_Patient();
$user_id = $_SESSION['user_id'];
$message = "";

/* ---------------- Handle Update ---------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name    = trim($_POST['full_name'] ?? '');
    $phone        = trim($_POST['phone'] ?? '');
    $age          = intval($_POST['age'] ?? 0);
    $gender       = $_POST['gender'] ?? 'other';
    $disease_info = trim($_POST['disease_info'] ?? '');

    // Update users table
    $stmt = $conn->prepare("UPDATE users SET full_name = ?, phone = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("ssi", $full_name, $phone, $user_id);
    $stmt->execute();

    // Update patients table
    $stmt = $conn->prepare("UPDATE patients SET age = ?, gender = ?, disease_info = ?, updated_at = NOW() WHERE user_id = ?");
    $stmt->bind_param("issi", $age, $gender, $disease_info, $user_id);
    $stmt->execute();

    $message = "<div class='alert alert-success'>✅ Profile updated successfully!</div>";
      header("Location: dashboard.php?msg=profile_updated");
  exit;
}

/* ---------------- Fetch Updated Profile ---------------- */
$stmt = $conn->prepare("
    SELECT u.full_name, u.email, u.phone, p.*
    FROM users u 
    JOIN patients p ON u.id = p.user_id
    WHERE u.id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$profile = $stmt->get_result()->fetch_assoc();

/* --- Null safe defaults --- */
$full_name    = htmlspecialchars($profile['full_name'] ?? '');
$email        = htmlspecialchars($profile['email'] ?? '');
$phone        = htmlspecialchars($profile['phone'] ?? '');
$age          = $profile['age'] ?? '';
$gender       = $profile['gender'] ?? 'other';
$disease_info = htmlspecialchars($profile['disease_info'] ?? '');
$status       = ucfirst($profile['status'] ?? 'pending');
?>

<div class="container py-4">
    <h2 class="mb-4 text-danger"><i class="bi bi-person-circle me-2"></i>My Profile</h2>
    <?= $message ?>

    <div class="card shadow border-0 rounded-3">
        <div class="card-body p-4">
            <form method="POST" class="needs-validation" novalidate>
                <!-- User Info -->
                <h5 class="mb-3 text-primary">👤 Personal Information</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><strong>Full Name</strong></label>
                        <input type="text" name="full_name" class="form-control" value="<?= $full_name ?>" required>
                        <div class="invalid-feedback">Full name is required</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><strong>Email</strong></label>
                        <input type="email" class="form-control" value="<?= $email ?>" disabled>
                        <small class="text-muted">Email cannot be changed</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><strong>Phone</strong></label>
                        <input type="text" name="phone" class="form-control" value="<?= $phone ?>" required>
                        <div class="invalid-feedback">Phone number is required</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label"><strong>Age</strong></label>
                        <input type="number" name="age" class="form-control" value="<?= $age ?>" min="1" required>
                        <div class="invalid-feedback">Valid age is required</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label"><strong>Gender</strong></label>
                        <select name="gender" class="form-select">
                            <option value="male" <?= ($gender=='male')?'selected':'' ?>>Male</option>
                            <option value="female" <?= ($gender=='female')?'selected':'' ?>>Female</option>
                            <option value="other" <?= ($gender=='other')?'selected':'' ?>>Other</option>
                        </select>
                    </div>
                </div>

                <!-- Medical Info -->
                <h5 class="mb-3 text-primary mt-4">🩺 Medical Information</h5>
                <div class="mb-3">
                    <label class="form-label"><strong>Disease Info</strong></label>
                    <textarea name="disease_info" class="form-control" rows="3"><?= $disease_info ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Status</strong></label>
                    <input type="text" class="form-control" value="<?= $status ?>" disabled>
                </div>

                <!-- Save Button -->
                <div class="text-end">
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="bi bi-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script>
// Bootstrap client-side validation
(function () {
  'use strict'
  let forms = document.querySelectorAll('.needs-validation')
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }
      form.classList.add('was-validated')
    }, false)
  })
})()
</script>

<?php include "../footer.php"; ob_end_flush(); ?>

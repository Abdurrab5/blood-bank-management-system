<?php ob_start();
require_once __DIR__ ."/../sidebar.php";
is_Admin();
$adminId = $_SESSION['user_id'];
$msg = '';

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['update_profile'])){
        $name = $_POST['full_name']; $email = $_POST['email']; $phone = $_POST['phone'];
        $stmt = $conn->prepare("UPDATE users SET full_name=?, email=?, phone=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $email, $phone, $adminId); $stmt->execute();
        flash('msg','Profile updated'); redirect('profile.php');
    } elseif(isset($_POST['change_password'])){
        $current = $_POST['current_password']; $new = $_POST['new_password'];
        $s = $conn->prepare("SELECT password FROM users WHERE id=?"); 
        $s->bind_param("i",$adminId); $s->execute();
        $hash = $s->get_result()->fetch_assoc()['password'];
        if(password_verify($current, $hash)){
            $nh = password_hash($new, PASSWORD_BCRYPT);
            $up = $conn->prepare("UPDATE users SET password=? WHERE id=?"); 
            $up->bind_param("si",$nh,$adminId); $up->execute();
            flash('msg','Password changed'); redirect('profile.php');
        } else {
            $msg = 'Current password is incorrect';
        }
    }
}

// fetch current
$stmt = $conn->prepare("SELECT full_name,email,phone FROM users WHERE id=?");
$stmt->bind_param("i",$adminId); $stmt->execute(); 
$cur = $stmt->get_result()->fetch_assoc();
?>

<div class="col-md-9 col-lg-10 p-4">
  <h3 class="mb-4 text-danger fw-bold">👤 My Profile</h3>
  <?= flash('msg') ?>
  <?php if($msg): ?><div class="alert alert-danger"><?= e($msg) ?></div><?php endif; ?>

  <div class="row g-4">
    <!-- Profile Update Card -->
    <div class="col-md-6">
      <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
          <h5 class="card-title  mb-3" style="color:#5a0000">Update Profile</h5>
          <form method="POST">
            <div class="mb-3">
              <label class="form-label">Full Name</label>
              <input name="full_name" class="form-control form-control-lg rounded-3" 
                     value="<?= e($cur['full_name']) ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input name="email" type="email" class="form-control form-control-lg rounded-3" 
                     value="<?= e($cur['email']) ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Phone</label>
              <input name="phone" class="form-control form-control-lg rounded-3" 
                     value="<?= e($cur['phone']) ?>">
            </div>
            <button name="update_profile" class="btn btn-success w-100 rounded-3 py-2 fw-bold">
              💾 Save Changes
            </button>
          </form>
        </div>
      </div>
    </div>

    <!-- Password Change Card -->
    <div class="col-md-6">
      <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
          <h5 class="card-title text-secondary mb-3">Change Password</h5>
          <form method="POST">
            <div class="mb-3">
              <label class="form-label">Current Password</label>
              <input name="current_password" type="password" class="form-control form-control-lg rounded-3" required>
            </div>
            <div class="mb-3">
              <label class="form-label">New Password</label>
              <input name="new_password" type="password" class="form-control form-control-lg rounded-3" required>
            </div>
            <button name="change_password" class="btn btn-warning w-100 rounded-3 py-2 fw-bold">
              🔑 Change Password
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php include "../footer.php"; ob_end_flush();?>

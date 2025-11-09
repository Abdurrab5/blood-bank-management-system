<?php ob_start();
require_once __DIR__ . "/../sidebar.php"; 
is_Donor(); 

$user_id = $_SESSION['user_id'];

/* ---------------- Fetch Donor Info ---------------- */
$donor = $conn->query("
  SELECT d.*, u.full_name, u.email, u.phone 
  FROM donors d 
  JOIN users u ON d.user_id=u.id 
  WHERE d.user_id=$user_id
")->fetch_assoc();

/* ---------------- Handle Update ---------------- */
if (isset($_POST['update'])) {
  $phone = $conn->real_escape_string($_POST['phone']);
  $age = (int)$_POST['age'];
  $full_name = $conn->real_escape_string($_POST['full_name']);
  $gender = $conn->real_escape_string($_POST['gender']);
  $blood_group = $conn->real_escape_string($_POST['blood_group']);
  $medical_history = $conn->real_escape_string($_POST['medical_history']);

  $conn->query("UPDATE users SET phone='$phone',full_name='$full_name' WHERE id=$user_id");
  $conn->query("
    UPDATE donors 
    SET age=$age, gender='$gender', blood_group='$blood_group', medical_history='$medical_history' 
    WHERE user_id=$user_id
  ");

  $success = "Profile updated successfully!";
  header("Location: dashboard.php?msg=profile_updated");
  exit;
}

 
?>

<div class="container-fluid">
  <div class="row">
    
    <div class="col-md-9 p-4">
      <h2 class="text-danger">My Profile</h2>
      <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

      <form method="POST">
        <div class="mb-3">
          <label>Full Name</label>
          <input type="text" class="form-control"  name="full_name" value="<?php echo $donor['full_name']; ?>" >
        </div>
        <div class="mb-3">
          <label>Email</label>
          <input type="email" class="form-control" value="<?php echo $donor['email']; ?>" disabled>
        </div>
        <div class="mb-3">
          <label>Phone</label>
          <input type="text" name="phone" class="form-control" value="<?php echo $donor['phone']; ?>">
        </div>
        <div class="mb-3">
          <label>Age</label>
          <input type="number" name="age" class="form-control" value="<?php echo $donor['age']; ?>">
        </div>
        <div class="mb-3">
          <label>Gender</label>
          <select name="gender" class="form-select">
            <option value="male" <?php if($donor['gender']=="male") echo "selected"; ?>>Male</option>
            <option value="female" <?php if($donor['gender']=="female") echo "selected"; ?>>Female</option>
            <option value="other" <?php if($donor['gender']=="other") echo "selected"; ?>>Other</option>
          </select>
        </div>
        <div class="mb-3">
          <label>Blood Group</label>
          <select name="blood_group" class="form-select">
            <?php 
            $groups = ['A+','A-','B+','B-','AB+','AB-','O+','O-'];
            foreach($groups as $g){
              $sel = ($donor['blood_group']==$g) ? "selected" : "";
              echo "<option value='$g' $sel>$g</option>";
            }
            ?>
          </select>
        </div>
        <div class="mb-3">
          <label>Medical History</label>
          <textarea name="medical_history" class="form-control"><?php echo $donor['medical_history']; ?></textarea>
        </div>
        <button type="submit" name="update" class="btn btn-danger">Update</button>
         </form>
    </div>
  </div>
</div></div>
<?php include "../footer.php"; ob_end_flush();?>

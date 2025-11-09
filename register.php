<?php
include "db.php";
include "functions.php";

$message = ""; // for user feedback

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // ✅ Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "<div class='alert alert-danger text-center'>Email already exists. Please use another email.</div>";
    } else {
        // Insert into users
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role, phone) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $password, $role, $phone);

        if ($stmt->execute()) {
            $user_id = $stmt->insert_id;

            // Insert into donor or patient
            if ($role === 'donor') {
                $stmt2 = $conn->prepare("INSERT INTO donors (user_id, blood_group, status) VALUES (?, 'O+', 'pending')");
                $stmt2->bind_param("i", $user_id);
                $stmt2->execute();
            } elseif ($role === 'patient') {
                $stmt3 = $conn->prepare("INSERT INTO patients (user_id, status) VALUES (?, 'pending')");
                $stmt3->bind_param("i", $user_id);
                $stmt3->execute();
            }

            redirect("login.php");
        } else {
            $message = "<div class='alert alert-danger text-center'>Error: " . $conn->error . "</div>";
        }
    }
}
?>
<?php include "header.php"; ?>

<div class="d-flex justify-content-center align-items-center vh-100 bg-light mt-5 mb-5">
    <div class="card shadow-lg border-0 rounded-4 p-4" style="max-width: 500px; width: 100%;">
        <div class="text-center mb-4">
            <i class="bi bi-person-plus-fill text-danger" style="font-size: 3rem;"></i>
            <h3 class="mt-2 text-danger">Create an Account</h3>
            <p class="text-muted">Join us as a donor or patient</p>
        </div>

        <!-- ✅ Show error or success message -->
        <?php if (!empty($message)) echo $message; ?>

      <form method="POST" autocomplete="off">
    <div class="mb-3">
        <label class="form-label fw-semibold">Full Name</label>
        <input type="text" 
               name="full_name" 
               class="form-control" 
               placeholder="Enter your name" 
               autocomplete="off" 
               autocorrect="off" 
               autocapitalize="none" 
               spellcheck="false" 
               required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Email</label>
        <input type="email" 
               name="email" 
               class="form-control" 
               placeholder="Enter your email" 
               autocomplete="off" 
               autocorrect="off" 
               autocapitalize="none" 
               spellcheck="false" 
               required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Phone</label>
        <input type="text" 
               name="phone" 
               class="form-control" 
               placeholder="Enter your phone number" 
               autocomplete="off" 
               autocorrect="off" 
               autocapitalize="none" 
               spellcheck="false">
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Password</label>
        <input type="password" 
               name="password" 
               class="form-control" 
               placeholder="Choose a password" 
               autocomplete="new-password" 
               autocorrect="off" 
               autocapitalize="none" 
               spellcheck="false" 
               required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Role</label>
        <select name="role" 
                class="form-select" 
                autocomplete="off" 
                required>
            <option value="">-- Select Role --</option>
            <option value="donor">Donor</option>
            <option value="patient">Patient</option>
        </select>
    </div>

    <button type="submit" class="btn btn-danger w-100">Register</button>
</form>

        <div class="text-center mt-3">
            <small class="text-muted">Already have an account? 
                <a href="login.php" class="text-danger fw-semibold">Login</a>
            </small>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

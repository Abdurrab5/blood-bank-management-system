<?php
include "db.php";
include "functions.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if($res->num_rows == 1){
        $user = $res->fetch_assoc();
        if(password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if($user['role'] == 'admin'){
                redirect("admin/dashboard.php");
            } elseif($user['role'] == 'donor'){
                redirect("donor/dashboard.php");
            } elseif($user['role'] == 'patient'){
                redirect("patient/dashboard.php");
            } else {
                redirect("index.php");
            }
        } else {
            $error = "❌ Invalid password!";
        }
    } else {
        $error = "⚠️ User not found!";
    }
}
?>
<?php include "header.php"; ?>

<div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card shadow-lg border-0 rounded-4 p-4" style="max-width: 400px; width: 100%;">
        <div class="text-center mb-4">
            <i class="bi bi-droplet-fill text-danger" style="font-size: 3rem;"></i>
            <h3 class="mt-2 text-danger">Blood Bank Login</h3>
            <p class="text-muted">Please sign in to continue</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger text-center"><?= $error ?></div>
        <?php endif; ?>

  <form method="POST" autocomplete="off">
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
        <label class="form-label fw-semibold">Password</label>
        <input type="password" 
               name="password" 
               class="form-control" 
               placeholder="Enter your password" 
               autocomplete="new-password" 
               autocorrect="off" 
               autocapitalize="none" 
               spellcheck="false" 
               required>
    </div>
    <button type="submit" class="btn btn-danger w-100">Login</button>
</form>


        <div class="text-center mt-3">
            <small class="text-muted">Don’t have an account? 
                <a href="register.php" class="text-danger fw-semibold">Register</a>
            </small>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

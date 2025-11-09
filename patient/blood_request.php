<?php ob_start();
require_once __DIR__ ."/../sidebar.php";
is_Patient();
$user_id = $_SESSION['user_id'];
$message = "";

/* --- Fetch patient_id using user_id --- */
$stmt = $conn->prepare("SELECT id FROM patients WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();

if ($patient) {
    $patient_id = $patient['id']; 
} else {
    $message = "<div class='alert alert-danger shadow-sm rounded-3'>❌ Patient record not found. Please complete your profile first.</div>";
    $patient_id = null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $patient_id) {
    $blood_group = $_POST['blood_group'];
    $quantity = intval($_POST['quantity']);
    $urgency = $_POST['urgency'];

    $stmt = $conn->prepare("
        INSERT INTO blood_requests (patient_id, blood_group, quantity, urgency)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param("isis", $patient_id, $blood_group, $quantity, $urgency);

    if ($stmt->execute()) {
        $message = "<div class='alert alert-success shadow-sm rounded-3'>✅ Request submitted successfully.</div>";
    } else {
        $message = "<div class='alert alert-danger shadow-sm rounded-3'>❌ Failed to submit request.</div>";
    }
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-danger text-white text-center py-3 rounded-top-4">
                    <h4 class="mb-0">🩸 Request Blood</h4>
                </div>
                <div class="card-body p-4">
                    <?= $message ?>

                    <form method="POST">
                        <!-- Blood Group -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Blood Group</label>
                            <select name="blood_group" class="form-select form-select-lg rounded-3" required>
                                <option value="">-- Select Blood Group --</option>
                                <?php foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg): ?>
                                    <option value="<?= $bg ?>"><?= $bg ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Quantity -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Quantity (Units)</label>
                            <input type="number" name="quantity" class="form-control form-control-lg rounded-3" min="1" required placeholder="Enter number of units">
                        </div>

                        <!-- Urgency -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Urgency</label>
                            <select name="urgency" class="form-select form-select-lg rounded-3">
                                <option value="normal">🟢 Normal</option>
                                <option value="emergency">🔴 Emergency</option>
                            </select>
                        </div>

                        <!-- Submit -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger btn-lg rounded-3 shadow-sm">
                                🚑 Submit Request
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center text-muted small">
                    💡 Please ensure all details are correct before submitting.
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php include "../footer.php"; ob_end_flush();?>

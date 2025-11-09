<?php ob_start(); require_once __DIR__ ."/../sidebar.php"; ?>
<?php
is_Patient();
$user_id = $_SESSION['user_id'] ?? 0;

// Fetch patient info
$stmt = $conn->prepare("SELECT * FROM patients WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$patient = $stmt->get_result()->fetch_assoc();

// Count stats
$total_requests   = get_count("blood_requests", "patient_id", $patient['id']);
$pending_requests = get_count("blood_requests", "patient_id", $patient['id'], "status='pending'");
$approved_requests = get_count("blood_requests", "patient_id", $patient['id'], "status='approved'");
?>

<div class="container py-4">
  <!-- Heading -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <h2 class="fw-bold text-danger">🩸 Patient Dashboard</h2>
    <span class="text-muted">Welcome, <b><?= htmlspecialchars($patient['full_name'] ?? "Patient") ?></b></span>
  </div>

  <!-- Stats Row -->
  <div class="row g-4">
    <!-- Total Requests -->
    <div class="col-md-4">
      <div class="card shadow-lg border-0 rounded-4 h-100">
        <div class="card-body text-center">
          <div class="text-primary mb-2">
            <i class="bi bi-clipboard-data fs-1"></i>
          </div>
          <h6 class="text-muted">Total Requests</h6>
          <p class="display-6 fw-bold text-primary"><?= $total_requests ?></p>
        </div>
      </div>
    </div>

    <!-- Pending Requests -->
    <div class="col-md-4">
      <div class="card shadow-lg border-0 rounded-4 h-100">
        <div class="card-body text-center">
          <div class="text-warning mb-2">
            <i class="bi bi-hourglass-split fs-1"></i>
          </div>
          <h6 class="text-muted">Pending Requests</h6>
          <p class="display-6 fw-bold text-warning"><?= $pending_requests ?></p>
        </div>
      </div>
    </div>

    <!-- Approved Requests -->
    <div class="col-md-4">
      <div class="card shadow-lg border-0 rounded-4 h-100">
        <div class="card-body text-center">
          <div class="text-success mb-2">
            <i class="bi bi-check-circle fs-1"></i>
          </div>
          <h6 class="text-muted">Approved Requests</h6>
          <p class="display-6 fw-bold text-success"><?= $approved_requests ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="row mt-5">
    <div class="col-md-12">
      <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body text-center">
          <h5 class="text-secondary mb-3">⚡ Quick Actions</h5>
          <a href="blood_request.php" class="btn btn-danger px-4 m-2 rounded-3">➕ New Blood Request</a>
          <a href="blood_request.php" class="btn btn-primary px-4 m-2 rounded-3">📋 View My Requests</a>
          <a href="profile.php" class="btn btn-success px-4 m-2 rounded-3">✏️ Update Profile</a>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php include "../footer.php"; ob_end_flush();?>

<?php ob_start();
require_once __DIR__ . "/../sidebar.php";
require_once __DIR__ . "/../functions.php";
is_Donor();
$user_id = $_SESSION['user_id'] ?? 0;

// Fetch donor + user info in one query
$stmt = $conn->prepare("
    SELECT d.*, u.full_name, u.email, u.phone, u.role, u.created_at AS user_created_at
    FROM donors d
    INNER JOIN users u ON d.user_id = u.id
    WHERE d.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$donor = $stmt->get_result()->fetch_assoc();

// Handle missing donor record
if (!$donor) {
    echo "<div class='container mt-5'>
            <div class='alert alert-danger shadow-sm rounded-3'>
              Donor record not found. Please contact the administrator.
            </div>
          </div>";
    include "../footer.php";
    exit;
}

// Stats
$total_donations   = get_count("donation_history", "donor_id", $donor['id']);
$pending_requests  = get_count("blood_requests", "patient_id", $donor['id'], "status='pending'");
$approved_requests = get_count("blood_requests", "patient_id", $donor['id'], "status='approved'");
$last_donation_date = $donor['last_donation_date'] ?? "N/A";
// After fetching donor info
checkDonorEligibilityAndNotify($conn, $donor['id'], $user_id);


?>

<div class="container-fluid px-4 py-4">
  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-danger mb-0">🩸 Donor Dashboard</h2>
    <span class="badge bg-light text-dark border px-3 py-2 shadow-sm">
      Registered: <?= date("d M Y", strtotime($donor['user_created_at'])) ?>
    </span>
  </div>

  <!-- Stats Cards -->
  <div class="row g-4 mb-4">
    <div class="col-md-3">
      <div class="card shadow-sm border-0 rounded-4 text-center h-100 hover-card">
        <div class="card-body">
          <h6 class="text-muted">Blood Group</h6>
          <p class="display-6 fw-bold text-danger"><?= htmlspecialchars($donor['blood_group']) ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0 rounded-4 text-center h-100 hover-card">
        <div class="card-body">
          <h6 class="text-muted">Total Donations</h6>
          <p class="display-6 fw-bold text-primary"><?= $total_donations ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0 rounded-4 text-center h-100 hover-card">
        <div class="card-body">
          <h6 class="text-muted">Pending Requests</h6>
          <p class="display-6 fw-bold text-warning"><?= $pending_requests ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0 rounded-4 text-center h-100 hover-card">
        <div class="card-body">
          <h6 class="text-muted">Approved Requests</h6>
          <p class="display-6 fw-bold text-success"><?= $approved_requests ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Profile + Actions -->
  <div class="row g-4">
    <!-- Profile -->
    <div class="col-md-6">
      <div class="card shadow-sm border-0 rounded-4 h-100">
        <div class="card-body">
          <h5 class="card-title text-secondary mb-3">👤 Profile</h5>
          <p><b>Name:</b> <?= htmlspecialchars($donor['full_name']) ?></p>
          <p><b>Email:</b> <?= htmlspecialchars($donor['email']) ?></p>
          <p><b>Phone:</b> <?= htmlspecialchars($donor['phone']) ?></p>
          <p><b>Status:</b> 
            <span class="badge bg-<?= $donor['status']=='active'?'success':'secondary' ?> px-3 py-2">
              <?= ucfirst(htmlspecialchars($donor['status'])) ?>
            </span>
          </p>
          <p><b>Last Donation:</b> <?= htmlspecialchars($last_donation_date) ?></p>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-md-6">
      <div class="card shadow-sm border-0 rounded-4 h-100">
        <div class="card-body">
          <h5 class="card-title text-secondary mb-3">⚡ Quick Actions</h5>
          <div class="d-grid gap-2">
            <a href="donation_schedule.php" class="btn btn-danger rounded-3 shadow-sm">
              🗓 Schedule Next Donation
            </a>
            <a href="profile.php" class="btn btn-primary rounded-3 shadow-sm">
              ✏️ Update Profile
            </a>
            <a href="history.php" class="btn btn-success rounded-3 shadow-sm">
              📜 View Donation History
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<!-- Small Hover Effect -->
<style>
  .hover-card:hover {
    transform: translateY(-5px);
    transition: 0.3s ease;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
  }
</style>

<?php include "../footer.php"; ob_end_flush();?>

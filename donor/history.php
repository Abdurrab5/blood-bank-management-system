<?php ob_start();
require_once __DIR__ . "/../sidebar.php";
is_Donor();
$user_id = $_SESSION['user_id'];
$donor = $conn->query("SELECT id, blood_group FROM donors WHERE user_id=$user_id")->fetch_assoc();
$history = $conn->query("SELECT * FROM donation_history WHERE donor_id={$donor['id']} ORDER BY donation_date DESC");
?>

<div class="container-fluid px-4 py-4">
  <h2 class="fw-bold text-danger mb-4">🩸 Donation History</h2>

  <!-- Summary Card -->
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card shadow-lg border-0 rounded-4 text-center">
        <div class="card-body">
          <h6 class="text-muted">Blood Group</h6>
          <p class="display-6 fw-bold text-danger"><?= htmlspecialchars($donor['blood_group']) ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="alert alert-info shadow-sm rounded-4 mb-0">
        <i class="bi bi-info-circle"></i> Thank you for being a donor!  
        Your contributions save lives every day.
      </div>
    </div>
  </div>

  <!-- History Table -->
  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-body">
      <h5 class="card-title text-secondary mb-3">📜 Past Donations</h5>
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-danger text-center">
            <tr>
              <th>Date</th>
              <th>Blood Group</th>
              <th>Quantity</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($history->num_rows > 0): ?>
              <?php while($row = $history->fetch_assoc()): ?>
              <tr class="text-center">
                <td><span class="badge bg-light text-dark"><?= date("M d, Y", strtotime($row['donation_date'])) ?></span></td>
                <td><span class="fw-bold text-danger"><?= $row['blood_group'] ?></span></td>
                <td><?= $row['quantity'] ?> ml</td>
                <td>
                  <span class="badge bg-success">Completed</span>
                </td>
              </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="text-center text-muted">No donation history available.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="row mt-4">
    <div class="col-md-6">
      <a href="donation_schedule.php" class="btn btn-danger w-100 rounded-3 shadow">
        🗓 Schedule Next Donation
      </a>
    </div>
    <div class="col-md-6">
      <a href="profile.php" class="btn btn-primary w-100 rounded-3 shadow">
        👤 Update Profile
      </a>
    </div>
  </div>
</div>
</div>
<?php include "../footer.php"; ob_end_flush(); ?>

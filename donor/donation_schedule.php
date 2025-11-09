<?php ob_start();
require_once __DIR__ . "/../sidebar.php";
is_Donor();
$user_id = $_SESSION['user_id'] ?? 0;

// Fetch donor record
$donor = $conn->query("SELECT * FROM donors WHERE user_id=$user_id")->fetch_assoc();

// Handle missing donor
if (!$donor) {
    echo "<div class='container mt-5'>
            <div class='alert alert-danger shadow-sm'>
              Donor record not found. Please contact admin.
            </div>
          </div>";
    include "../footer.php";
    exit;
}

// Fetch last donation date
$lastDonationRow = $conn->query("SELECT donation_date FROM donation_history 
                                 WHERE donor_id={$donor['id']} 
                                 ORDER BY donation_date DESC LIMIT 1")->fetch_assoc();
$lastDonationDate = $lastDonationRow['donation_date'] ?? null;

// Eligibility (90 days gap)
$eligibleDate = $lastDonationDate ? date('Y-m-d', strtotime($lastDonationDate . ' +90 days')) : date('Y-m-d');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $donation_date = $_POST['donation_date'];
    $quantity = intval($_POST['quantity']);
    $blood_group = $donor['blood_group'];

    if ($donation_date < $eligibleDate) {
        $error = "You are only eligible to donate after <b>$eligibleDate</b>.";
    } else {
        $conn->query("INSERT INTO donation_history (donor_id, blood_group, quantity, donation_date) 
                      VALUES ({$donor['id']}, '$blood_group', $quantity, '$donation_date')");
        $success = "Donation scheduled successfully on <b>$donation_date</b>!";
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $donation_date = $_POST['donation_date'];
    $quantity = intval($_POST['quantity']);
    $blood_group = $donor['blood_group'];

    if ($donation_date < $eligibleDate) {
        $error = "You are only eligible to donate after <b>$eligibleDate</b>.";
    } else {
        // Save donation
        $conn->query("INSERT INTO donation_history (donor_id, blood_group, quantity, donation_date) 
                      VALUES ({$donor['id']}, '$blood_group', $quantity, '$donation_date')");
        
        // Save notification
        $message = "You have successfully scheduled a blood donation on $donation_date.";
        $stmt = $conn->prepare("INSERT INTO notifications (user_id, message, type, status) VALUES (?, ?, ?, ?)");
        $type = "donation";   // notification type
        $status = "unread";   // default status
        $stmt->bind_param("isss", $user_id, $message, $type, $status);
        $stmt->execute();

        $success = "Donation scheduled successfully on <b>$donation_date</b>!";
    }
}

      }
}
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
          <h3 class="text-danger fw-bold mb-4">🗓 Schedule Blood Donation</h3>

          <!-- Alerts -->
          <?php if(isset($success)): ?>
            <div class="alert alert-success rounded-3 shadow-sm"><?= $success ?></div>
          <?php elseif(isset($error)): ?>
            <div class="alert alert-danger rounded-3 shadow-sm"><?= $error ?></div>
          <?php endif; ?>

          <!-- Info Panel -->
          <div class="mb-4">
            <p><b>Blood Group:</b> <span class="badge bg-danger"><?= $donor['blood_group'] ?></span></p>
            <p><b>Last Donation:</b> <?= $lastDonationDate ? $lastDonationDate : "No donations yet" ?></p>
            <p><b>Next Eligible Date:</b> <span class="text-primary fw-bold"><?= $eligibleDate ?></span></p>
          </div>

          <!-- Form -->
          <form method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
              <label class="form-label fw-semibold">Donation Date</label>
              <input type="date" name="donation_date" class="form-control rounded-3" 
                     min="<?= $eligibleDate ?>" required>
              <div class="invalid-feedback">Please select a valid donation date.</div>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Quantity (ml)</label>
              <input type="number" name="quantity" class="form-control rounded-3" min="200" max="500" step="50" required>
              <small class="text-muted">Standard donation: 350-450 ml</small>
              <div class="invalid-feedback">Please enter a valid quantity between 200–500 ml.</div>
            </div>

            <button type="submit" class="btn btn-danger w-100 rounded-3 fw-bold">
              ✅ Confirm Donation
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script>
// Bootstrap form validation
(function () {
  'use strict';
  var forms = document.querySelectorAll('.needs-validation');
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>

<?php include "../footer.php"; ob_end_flush();?>

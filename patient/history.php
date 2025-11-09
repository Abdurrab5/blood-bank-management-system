<?php ob_start();
require_once __DIR__ ."/../sidebar.php";
is_Patient();
$user_id = $_SESSION['user_id'];

/* --- Fetch the correct patient_id --- */
$stmt = $conn->prepare("SELECT id FROM patients WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();

if ($patient) {
    $patient_id = $patient['id'];
} else {
    $patient_id = null;
}

$requests = [];
if ($patient_id) {
    $stmt = $conn->prepare("SELECT * FROM blood_requests WHERE patient_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $requests = $stmt->get_result();
}
?>

<div class="container py-4">
    <h2 class="mb-4 text-primary fw-bold">
        <i class="bi bi-droplet-half me-2"></i> My Blood Request History
    </h2>

    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body">
            
            <?php if ($patient_id && $requests->num_rows > 0): ?>
                
                <!-- Search & Filter -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" id="searchInput" class="form-control" placeholder="🔍 Search requests...">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="requestTable">
                        <thead class="table-light">
                            <tr>
                                <th>Blood Group</th>
                                <th>Quantity</th>
                                <th>Urgency</th>
                                <th>Status</th>
                                <th>Requested At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $requests->fetch_assoc()): ?>
                                <tr>
                                    <td class="fw-bold text-danger"><?= htmlspecialchars($row['blood_group']) ?></td>
                                    <td><?= htmlspecialchars($row['quantity']) ?> Unit(s)</td>
                                    <td>
                                        <span class="badge bg-<?= ($row['urgency']=='emergency')?'danger':'info' ?> px-3 py-2">
                                            <?= ucfirst(htmlspecialchars($row['urgency'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($row['status']=='approved'): ?>
                                            <span class="badge bg-success px-3 py-2">
                                                <i class="bi bi-check-circle me-1"></i> Approved
                                            </span>
                                        <?php elseif ($row['status']=='pending'): ?>
                                            <span class="badge bg-warning text-dark px-3 py-2">
                                                <i class="bi bi-hourglass-split me-1"></i> Pending
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-danger px-3 py-2">
                                                <i class="bi bi-x-circle me-1"></i> Rejected
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td><small class="text-muted"><?= date("M d, Y h:i A", strtotime($row['created_at'])) ?></small></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

            <?php elseif ($patient_id): ?>
                <div class="text-center py-5">
                    <img src="../uploads/images/empty.png" alt="No requests" class="mb-3" style="width:120px;">
                    <h5 class="text-muted">No blood requests found yet.</h5>
                    <p class="text-secondary">Submit a new request and track it here.</p>
                    <a href="blood_request.php" class="btn btn-danger">
                        <i class="bi bi-plus-circle me-1"></i> Request Blood
                    </a>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">
                    ❌ No patient record found. Please complete your profile first.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
<!-- Search Filter Script -->
<script>
document.getElementById("searchInput").addEventListener("keyup", function() {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll("#requestTable tbody tr");
    rows.forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(value) ? "" : "none";
    });
});
</script>

<?php include "../footer.php"; ob_end_flush();?>

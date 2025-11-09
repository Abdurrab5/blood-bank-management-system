<?php ob_start();
require_once __DIR__ ."/../sidebar.php";
is_Admin();
// fetch quick stats
$stats = [
    'donors' => 0,
    'patients' => 0,
    'stock_groups' => 0,
    'pending_requests' => 0
];

$result = $conn->query("SELECT COUNT(*) AS c FROM users WHERE role='donor'");
$stats['donors'] = $result->fetch_assoc()['c'] ?? 0;

$result = $conn->query("SELECT COUNT(*) AS c FROM users WHERE role='patient'");
$stats['patients'] = $result->fetch_assoc()['c'] ?? 0;

$result = $conn->query("SELECT SUM(quantity) AS q FROM blood_stock");
$stats['stock_groups'] = $result->fetch_assoc()['q'] ?? 0;

$result = $conn->query("SELECT COUNT(*) AS c FROM blood_requests WHERE status='pending'");
$stats['pending_requests'] = $result->fetch_assoc()['c'] ?? 0;
?>

<style>
  .dashboard-header {
    background: linear-gradient(45deg, #b30000, #ff4d4d);
    color: white;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 25px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
  }
  .stat-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
  }
  .stat-icon {
    font-size: 30px;
    color: #b30000;
    opacity: 0.8;
  }
</style>

<div class="col-md-9 col-lg-10 p-4">
  <div class="dashboard-header">
    <h3 class="fw-bold">Admin Dashboard</h3>
    <p class="mb-0">Manage donors, patients, stock, and blood requests efficiently.</p>
  </div>

  <!-- Quick Stats -->
  <div class="row g-3">
    <div class="col-sm-6 col-xl-3">
      <div class="card stat-card shadow-sm text-center">
        <div class="card-body">
          <div class="stat-icon mb-2"><i class="fas fa-user-friends"></i></div>
          <h6 class="card-title text-muted">Total Donors</h6>
          <h2 class="text-danger fw-bold"><?= e($stats['donors']) ?></h2>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card stat-card shadow-sm text-center">
        <div class="card-body">
          <div class="stat-icon mb-2"><i class="fas fa-procedures"></i></div>
          <h6 class="card-title text-muted">Total Patients</h6>
          <h2 class="text-danger fw-bold"><?= e($stats['patients']) ?></h2>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card stat-card shadow-sm text-center">
        <div class="card-body">
          <div class="stat-icon mb-2"><i class="fas fa-tint"></i></div>
          <h6 class="card-title text-muted">Available Units</h6>
          <h2 class="text-danger fw-bold"><?= e($stats['stock_groups']) ?></h2>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card stat-card shadow-sm text-center">
        <div class="card-body">
          <div class="stat-icon mb-2"><i class="fas fa-exclamation-circle"></i></div>
          <h6 class="card-title text-muted">Pending Requests</h6>
          <h2 class="text-danger fw-bold"><?= e($stats['pending_requests']) ?></h2>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Requests -->
  <div class="mt-5">
    <h5 class="fw-bold text-danger mb-3"><i class="fas fa-history me-2"></i>Recent Requests</h5>
    <div class="table-responsive shadow-sm">
      <table class="table table-striped align-middle">
        <thead class="table-danger">
          <tr>
            <th>#</th>
            <th>Patient</th>
            <th>Blood Group</th>
            <th>Qty</th>
            <th>Urgency</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $stmt = $conn->prepare("
          SELECT r.*, u.full_name AS patient_name 
          FROM blood_requests r 
          JOIN patients p ON r.patient_id = p.id 
          JOIN users u ON p.user_id = u.id 
          ORDER BY r.created_at DESC 
          LIMIT 8
        ");
        if($stmt->execute()){
            $res = $stmt->get_result();
            $i = 1;
            while($row = $res->fetch_assoc()){
                $statusBadge = match($row['status']){
                    'pending' => "<span class='badge bg-warning text-dark'>Pending</span>",
                    'approved' => "<span class='badge bg-success'>Approved</span>",
                    'rejected' => "<span class='badge bg-danger'>Rejected</span>",
                    default => "<span class='badge bg-secondary'>Unknown</span>"
                };
                echo "<tr>
                        <td>{$i}</td>
                        <td>".e($row['patient_name'])."</td>
                        <td><span class='badge bg-danger'>".e($row['blood_group'])."</span></td>
                        <td>".e($row['quantity'])."</td>
                        <td><span class='badge bg-info text-dark'>".e($row['urgency'])."</span></td>
                        <td>{$statusBadge}</td>
                      </tr>";
                $i++;
            }
        }
        ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
<?php include "../footer.php"; ob_end_flush();?>

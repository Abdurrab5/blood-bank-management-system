<?php ob_start();
require_once __DIR__ ."/../sidebar.php";
is_Admin();
if(isset($_GET['action']) && isset($_GET['id'])){
    $id = intval($_GET['id']);

    // fetch patient user_id from request
    $stmtP = $conn->prepare("
        SELECT u.id AS user_id, u.full_name, r.quantity, r.blood_group 
        FROM blood_requests r 
        JOIN patients p ON r.patient_id=p.id 
        JOIN users u ON p.user_id=u.id 
        WHERE r.id=?
    ");
    $stmtP->bind_param("i", $id);
    $stmtP->execute();
    $patientData = $stmtP->get_result()->fetch_assoc();
    $patient_user_id = $patientData['user_id'] ?? 0;

    if($_GET['action']=='reject'){
        $stmt = $conn->prepare("UPDATE blood_requests SET status='rejected' WHERE id=?");
        $stmt->bind_param("i",$id); 
        $stmt->execute();

        // 🔔 Insert notification
        if ($patient_user_id) {
            $msg = "Your blood request for {$patientData['quantity']} units of {$patientData['blood_group']} has been rejected.";
            $stmtN = $conn->prepare("INSERT INTO notifications (user_id, message, type, status) VALUES (?, ?, 'blood_request', 'unread')");
            $stmtN->bind_param("is", $patient_user_id, $msg);
            $stmtN->execute();
        }

        flash('msg','Request rejected'); 
        redirect('blood_requests.php');

    } elseif($_GET['action']=='approve' && isset($_GET['stock_id'])){
        $stock_id = intval($_GET['stock_id']);
        
        // assign stock and set request approved
        $conn->begin_transaction();
        $s1 = $conn->prepare("SELECT quantity FROM blood_stock WHERE id=? FOR UPDATE");
        $s1->bind_param("i",$stock_id); 
        $s1->execute(); 
        $r1 = $s1->get_result()->fetch_assoc();
        if(!$r1) { 
            $conn->rollback(); 
            flash('msg','Stock not found','alert-danger'); 
            redirect('blood_requests.php'); 
        }
        $stmtReq = $conn->prepare("SELECT quantity FROM blood_requests WHERE id=?");
        $stmtReq->bind_param("i",$id); 
        $stmtReq->execute(); 
        $rq = $stmtReq->get_result()->fetch_assoc();
        $req_qty = $rq['quantity'] ?? 0;
        if($r1['quantity'] < $req_qty){
            $conn->rollback(); 
            flash('msg','Not enough stock units','alert-danger'); 
            redirect('blood_requests.php');
        }
        $newQty = $r1['quantity'] - $req_qty;
        $s2 = $conn->prepare("UPDATE blood_stock SET quantity=? WHERE id=?");
        $s2->bind_param("ii",$newQty,$stock_id); 
        $s2->execute();
        $s3 = $conn->prepare("UPDATE blood_requests SET status='approved', assigned_stock_id=? WHERE id=?");
        $s3->bind_param("ii",$stock_id,$id); 
        $s3->execute();
        $conn->commit();

        // 🔔 Insert notification
        if ($patient_user_id) {
            $msg = "Your blood request for {$patientData['quantity']} units of {$patientData['blood_group']} has been approved.";
            $stmtN = $conn->prepare("INSERT INTO notifications (user_id, message, type, status) VALUES (?, ?, 'blood_request', 'unread')");
            $stmtN->bind_param("is", $patient_user_id, $msg);
            $stmtN->execute();
        }

        flash('msg','Request approved and stock assigned'); 
        redirect('blood_requests.php');
    }
}


// fetch requests
$stmt = $conn->prepare("SELECT r.*, u.full_name AS patient_name FROM blood_requests r JOIN patients p ON r.patient_id=p.id JOIN users u ON p.user_id=u.id ORDER BY r.created_at DESC");
$stmt->execute(); $res = $stmt->get_result();

// fetch available stocks for dropdown
$stockRes = $conn->query("SELECT * FROM blood_stock WHERE quantity>0 ORDER BY expiry_date ASC");
$stocks = $stockRes->fetch_all(MYSQLI_ASSOC);
?>

<div class="col-md-9 col-lg-10 p-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-danger fw-bold mb-0">
      <i class="fas fa-tint me-2"></i>Blood Requests
    </h3>
  </div>

  <?= flash('msg') ?>

  <div class="card shadow-sm border-0">
    <div class="card-body p-0">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-danger text-center">
          <tr>
            <th>#</th>
            <th>Patient</th>
            <th>Group</th>
            <th>Qty</th>
            <th>Urgency</th>
            <th>Status</th>
            <th style="width: 260px;">Actions</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php $i=1; while($row=$res->fetch_assoc()): ?>
          <tr>
            <td><?= $i ?></td>
            <td class="fw-semibold"><?= e($row['patient_name']) ?></td>
            <td>
              <span class="badge bg-danger"><?= e($row['blood_group']) ?></span>
            </td>
            <td><?= e($row['quantity']) ?> units</td>
            <td>
              <?php if($row['urgency'] === 'emergency'): ?>
                <span class="badge bg-danger">Emergency</span>
              <?php else: ?>
                <span class="badge bg-warning text-dark">Normal</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if($row['status'] === 'pending'): ?>
                <span class="badge bg-secondary">Pending</span>
              <?php elseif($row['status'] === 'approved'): ?>
                <span class="badge bg-success">Approved</span>
              <?php else: ?>
                <span class="badge bg-danger">Rejected</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if($row['status'] === 'pending'): ?>
                <div class="d-flex justify-content-center">
                  
                  <!-- Reject button -->
                  <form method="GET" class="me-2">
                    <input type="hidden" name="action" value="reject">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button class="btn btn-sm btn-outline-warning">
                      <i class="fas fa-times"></i> Reject
                    </button>
                  </form>

                  <!-- Approve & Assign -->
                  <form method="GET" class="d-flex">
                    <input type="hidden" name="action" value="approve">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <select name="stock_id" class="form-select form-select-sm me-2" required>
                      <option value="">Select stock</option>
                      <?php foreach($stocks as $s): ?>
                        <?php if($s['blood_group'] === $row['blood_group']): ?>
                          <option value="<?= $s['id'] ?>">
                            <?= e($s['blood_group'])." (".$s['quantity']." units) - ".e($s['expiry_date']) ?>
                          </option>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </select>
                    <button class="btn btn-sm btn-success">
                      <i class="fas fa-check"></i> Approve
                    </button>
                  </form>
                </div>
              <?php elseif($row['status'] === 'approved'): ?>
                <small class="text-muted">Assigned Stock ID: 
                  <span class="fw-bold"><?= e($row['assigned_stock_id']) ?></span>
                </small>
              <?php endif; ?>
            </td>
          </tr>
          <?php $i++; endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
              </div>

<?php include "../footer.php"; ob_end_flush();?>

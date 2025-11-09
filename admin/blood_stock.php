<?php ob_start();
require_once __DIR__ ."/../sidebar.php";
is_Admin();
// Add / Update / Delete
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['add_stock'])){
    $bg = $_POST['blood_group']; $qty = intval($_POST['quantity']);
    $col = $_POST['collection_date']; $exp = $_POST['expiry_date']; $loc = $_POST['storage_location'];
    $stmt = $conn->prepare("INSERT INTO blood_stock (blood_group, quantity, collection_date, expiry_date, storage_location) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sisss",$bg,$qty,$col,$exp,$loc); $stmt->execute();
    flash('msg','Stock added'); redirect('blood_stock.php');
}

if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM blood_stock WHERE id=?"); $stmt->bind_param("i",$id); $stmt->execute();
    flash('msg','Stock deleted'); redirect('blood_stock.php');
}

// fetch
$stmt = $conn->prepare("SELECT * FROM blood_stock ORDER BY expiry_date ASC");
$stmt->execute(); $res = $stmt->get_result();
?>
<div class="col-md-9 col-lg-10 p-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-danger fw-bold mb-0">
      <i class="fas fa-tint me-2"></i> Blood Stock
    </h3>
    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addStockModal">
      <i class="fas fa-plus-circle me-1"></i> Add Stock
    </button>
  </div>

  <?= flash('msg') ?>

  <div class="card shadow-sm border-0">
    <div class="card-body p-0">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-danger text-center">
          <tr>
            <th>#</th>
            <th>Group</th>
            <th>Quantity</th>
            <th>Collected</th>
            <th>Expiry</th>
            <th>Location</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php $i=1; while($row=$res->fetch_assoc()): 
            $is_expired = (strtotime($row['expiry_date']) < time());
            $is_near_expiry = (strtotime($row['expiry_date']) < strtotime('+7 days')) && !$is_expired;
          ?>
          <tr class="<?= $is_expired ? 'table-danger' : ($is_near_expiry ? 'table-warning' : '') ?>">
            <td><?= $i ?></td>
            <td><span class="badge bg-danger"><?= e($row['blood_group']) ?></span></td>
            <td><span class="fw-semibold"><?= e($row['quantity']) ?> units</span></td>
            <td><?= e($row['collection_date']) ?></td>
            <td>
              <?= e($row['expiry_date']) ?>
              <?php if($is_expired): ?>
                <span class="badge bg-dark ms-1">Expired</span>
              <?php elseif($is_near_expiry): ?>
                <span class="badge bg-warning text-dark ms-1">Expiring Soon</span>
              <?php endif; ?>
            </td>
            <td><?= e($row['storage_location']) ?: '-' ?></td>
            <td>
              <a class="btn btn-sm btn-outline-danger" 
                 href="blood_stock.php?delete=<?= $row['id'] ?>" 
                 onclick="return confirm('Are you sure you want to delete this stock?')">
                 <i class="fas fa-trash-alt"></i> Delete
              </a>
            </td>
          </tr>
          <?php $i++; endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Add Stock Modal -->
<div class="modal fade" id="addStockModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" class="modal-content shadow-lg border-0">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Add Blood Stock</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Blood Group</label>
            <select name="blood_group" class="form-select" required>
              <option value="">Select Group</option>
              <option>A+</option><option>A-</option>
              <option>B+</option><option>B-</option>
              <option>AB+</option><option>AB-</option>
              <option>O+</option><option>O-</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Quantity (units)</label>
            <input name="quantity" type="number" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Collection Date</label>
            <input name="collection_date" type="date" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Expiry Date</label>
            <input name="expiry_date" type="date" class="form-control" required>
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Storage Location</label>
            <input name="storage_location" type="text" class="form-control" placeholder="Refrigerator A, Shelf 3">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" name="add_stock">
          <i class="fas fa-save me-1"></i> Save Stock
        </button>
      </div>
    </form>
  </div>
</div>
              </div>
<?php include "../footer.php"; ob_end_flush();?>

<?php 
include "db.php";
include "header.php";
?>

<style>
  .sidebar {
    min-height: 100vh;
    background: #5a0000;
    border-right: 1px solid #dee2e6;
    padding: 20px 0;
    box-shadow: 2px 0 6px rgba(0,0,0,0.05);
  }
  .sidebar h5 {
    font-weight: bold;
    color: #f8f3f3ff;
    margin-bottom: 20px;
  }
  .sidebar a {
    display: flex;
    align-items: center;
    padding: 10px 15px;
    margin: 5px 10px;
    color: #d3e90fff;
    border-radius: 8px;
    transition: all 0.2s ease;
    font-size: 15px;
  }
  .sidebar a i {
    margin-right: 10px;
    font-size: 16px;
    color: #d9f011ff;
  }
  .sidebar a:hover {
    background: #b30000;
    color: #ffffffff !important;
    text-decoration: none;
  }
  .sidebar a:hover i {
    color: #fff;
  }
  .sidebar a.active {
    background: #b30000;
    color: #fff !important;
    font-weight: bold;
  }
  .sidebar a.active i {
    color: #fff;
  }
</style>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 sidebar">
      <h5 class="text-center">Dashboard</h5>

      <?php if($_SESSION['role'] == 'admin'): ?>
        <a href="<?= $base_url?>admin/dashboard.php" ><i class="fas fa-tachometer-alt"></i> Admin Dashboard</a>
        <a href="<?= $base_url?>admin/donors.php"><i class="fas fa-user-friends"></i> Manage Donors</a>
        <a href="<?= $base_url?>admin/patients.php"><i class="fas fa-procedures"></i> Manage Patients</a>
        <a href="<?= $base_url?>admin/blood_stock.php"><i class="fas fa-tint"></i> Blood Stock</a>
        <a href="<?= $base_url?>admin/blood_requests.php"><i class="fas fa-clipboard-list"></i> Requests</a>
        <a href="<?= $base_url?>admin/notifications.php"><i class="fas fa-bell"></i> Notifications</a>
         <a href="<?= $base_url?>admin/contact_messages.php"><i class="fas fa-bell"></i> Contact Message</a>
 <a href="<?= $base_url?>admin/profile.php"><i class="fas fa-user"></i> Profile</a>
      <?php elseif($_SESSION['role'] == 'donor'): ?>
        <a href="<?= $base_url?>donor/dashboard.php" ><i class="fas fa-tachometer-alt"></i> My Dashboard</a>
        <a href="<?= $base_url?>donor/profile.php"><i class="fas fa-user"></i> Profile</a>
        <a href="<?= $base_url?>donor/donation_schedule.php"><i class="fas fa-calendar-alt"></i> Donation Schedule</a>
        <a href="<?= $base_url?>donor/history.php"><i class="fas fa-history"></i> Donation History</a>
 <a href="<?= $base_url?>donor/notifications.php"><i class="fas fa-history"></i> Notifications</a>

      <?php elseif($_SESSION['role'] == 'patient'): ?>
        <a href="<?= $base_url?>patient/dashboard.php" ><i class="fas fa-tachometer-alt"></i> My Dashboard</a>
        <a href="<?= $base_url?>patient/profile.php"><i class="fas fa-user"></i> Profile</a>
        <a href="<?= $base_url?>patient/blood_request.php"><i class="fas fa-hand-holding-medical"></i> Request Blood</a>
        <a href="<?= $base_url?>patient/history.php"><i class="fas fa-history"></i> History</a>
     <a href="<?= $base_url?>patient/notifications.php"><i class="fas fa-history"></i> Notifications</a>
 
        <?php endif; ?>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 p-4">
      <!-- Your main content here -->

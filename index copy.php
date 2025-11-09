<?php include "header.php"; ?>

<!-- Hero Section -->
<section class="hero d-flex align-items-center text-center text-white" 
         style="background: linear-gradient(rgba(179,0,0,0.8), rgba(179,0,0,0.8)), url('<?=$base_url?>uploads/images/1.png') no-repeat center center/cover; height: 90vh;">
  <div class="container">
    <h1 class="display-3 fw-bold mb-3">Donate Blood, Save Lives</h1>
    <p class="lead mb-4">Join our mission to ensure that every patient has access to safe blood when they need it the most.</p>
    <a href="register.php" class="btn btn-lg btn-light px-5 shadow">Become a Donor</a>
  </div>
</section>

<!-- Stats Section -->
<section class="stats py-5 bg-light text-center">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-3">
        <div class="card shadow border-0 h-100">
          <div class="card-body">
            <i class="fas fa-users fa-2x text-danger mb-3"></i>
            <h3 class="fw-bold">1500+</h3>
            <p class="text-muted">Donors Registered</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow border-0 h-100">
          <div class="card-body">
            <i class="fas fa-hand-holding-heart fa-2x text-danger mb-3"></i>
            <h3 class="fw-bold">3000+</h3>
            <p class="text-muted">Lives Saved</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow border-0 h-100">
          <div class="card-body">
            <i class="fas fa-tint fa-2x text-danger mb-3"></i>
            <h3 class="fw-bold">1200+</h3>
            <p class="text-muted">Units Collected</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow border-0 h-100">
          <div class="card-body">
            <i class="fas fa-hospital fa-2x text-danger mb-3"></i>
            <h3 class="fw-bold">50+</h3>
            <p class="text-muted">Partner Hospitals</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="features py-5">
  <div class="container text-center">
    <h2 class="fw-bold mb-5">Our Services</h2>
    <div class="row g-4">
      <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm hover-card">
          <div class="card-body">
            <i class="fas fa-user-plus fa-2x text-danger mb-3"></i>
            <h5 class="fw-bold">Easy Registration</h5>
            <p class="text-muted">Quickly register as a donor or patient in just a few clicks.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm hover-card">
          <div class="card-body">
            <i class="fas fa-briefcase-medical fa-2x text-danger mb-3"></i>
            <h5 class="fw-bold">Blood Requests</h5>
            <p class="text-muted">Request blood units and track the status seamlessly.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm hover-card">
          <div class="card-body">
            <i class="fas fa-tint fa-2x text-danger mb-3"></i>
            <h5 class="fw-bold">Donation Camps</h5>
            <p class="text-muted">Participate in nearby blood donation drives organized regularly.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm hover-card">
          <div class="card-body">
            <i class="fas fa-bell fa-2x text-danger mb-3"></i>
            <h5 class="fw-bold">Instant Notifications</h5>
            <p class="text-muted">Stay updated with real-time alerts and reminders.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
  .hover-card { transition: transform .3s ease, box-shadow .3s ease; }
  .hover-card:hover { transform: translateY(-8px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
</style>

<?php include "footer.php"; ?>

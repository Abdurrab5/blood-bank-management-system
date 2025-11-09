<?php include "header.php"; ?>
<?php
include "db.php"; // DB connection file

$messageAlert = ""; // for success/error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {
            $messageAlert = '<div class="alert alert-success">✅ Your message has been sent successfully!</div>';
        } else {
            $messageAlert = '<div class="alert alert-danger">❌ Error saving message. Please try again.</div>';
        }
    } else {
        $messageAlert = '<div class="alert alert-warning">⚠️ Please fill in all fields.</div>';
    }
}
?>
<!-- Contact Hero -->
<section class="text-center text-white d-flex align-items-center justify-content-center" 
         style="background: linear-gradient(rgba(179,0,0,0.8), rgba(179,0,0,0.8)), url('<?=$base_url?>uploads/images/contact-bg.jpg') no-repeat center/cover; height: 40vh;">
  <div>
    <h1 class="display-4 fw-bold">Contact Us</h1>
    <p class="lead">We’d love to hear from you. Get in touch today!</p>
  </div>
</section>

<!-- Contact Section -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row g-5">
      
      <!-- Contact Info -->
      <div class="col-md-5">
        <div class="p-4 bg-white shadow rounded">
          <h3 class="fw-bold mb-4 text-danger">Get in Touch</h3>
          <p class="text-muted">Have questions about donating or requesting blood? Reach out to us anytime.</p>
          
          <div class="mb-3 d-flex align-items-start">
            <i class="fas fa-map-marker-alt text-danger me-3 mt-1"></i>
            <div>
              <h6 class="fw-bold">Our Office</h6>
              <p class="text-muted mb-0">123 Main Street, Lahore, Pakistan</p>
            </div>
          </div>
          
          <div class="mb-3 d-flex align-items-start">
            <i class="fas fa-envelope text-danger me-3 mt-1"></i>
            <div>
              <h6 class="fw-bold">Email Us</h6>
              <p class="text-muted mb-0">support@bms.org</p>
            </div>
          </div>
          
          <div class="mb-3 d-flex align-items-start">
            <i class="fas fa-phone text-danger me-3 mt-1"></i>
            <div>
              <h6 class="fw-bold">Call Us</h6>
              <p class="text-muted mb-0">+92 300 1234567</p>
            </div>
          </div>

          <div class="mt-4">
            <a href="#" class="btn btn-outline-danger btn-sm me-2"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="btn btn-outline-danger btn-sm me-2"><i class="fab fa-twitter"></i></a>
            <a href="#" class="btn btn-outline-danger btn-sm"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="col-md-7">
        <div class="p-4 bg-white shadow rounded">
          <h3 class="fw-bold mb-4 text-danger">Send a Message</h3>

          <!-- Show message alerts -->
          <?php if (!empty($messageAlert)) echo $messageAlert; ?>

          <form action="" method="post">
            <div class="mb-3">
              <label for="name" class="form-label fw-bold">Your Name</label>
              <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label fw-bold">Email Address</label>
              <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="subject" class="form-label fw-bold">Subject</label>
              <input type="text" name="subject" id="subject" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="message" class="form-label fw-bold">Message</label>
              <textarea name="message" id="message" rows="5" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-danger w-100 py-2">Send Message</button>
          </form>
        </div>
      </div>

    </div>
  </div>
</section>

<style>
  .btn-outline-danger {
    border-radius: 50%;
    width: 38px;
    height: 38px;
    padding: 8px;
  }
  .btn-outline-danger:hover {
    background: #b30000;
    color: #fff;
  }
</style>

<?php include "footer.php"; ?>

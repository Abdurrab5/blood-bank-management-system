<?php include_once "functions.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BMS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .navbar, .btn-danger { background-color: #910404ff!important; }
    .navbar-brand, .nav-link, .btn-danger { color: white !important; }
    .sidebar {
      height: 100vh;
      background-color: #f8d7da;
      padding-top: 20px;
    }
    .sidebar a {
      display: block;
      padding: 10px;
      color: #6a0f0fff;
      text-decoration: none;
    }
    .sidebar a:hover {
      background: #aa2626ff;
      color: white;
    }
   *{
      margin:0;
      padding:0;
      box-sizing:border-box;
      font-family: 'Poppins', sans-serif;
    }
    body {
      background:#fff;
      color:#333;
      line-height:1.6;
      overflow-x:hidden;
    }
    /* Navbar */
    .navbar {
      display:flex;
      justify-content:space-between;
      align-items:center;
      padding:1rem 5%;
      background:darkred;
      position:sticky;
      top:0;
      z-index:1000;
    }
    .navbar .logo {
      color:#fff;
      font-size:1.6rem;
      font-weight:700;
      text-decoration:none;
      display:flex;
      align-items:center;
    }
    .navbar .logo i {
      margin-right:10px;
      color: #0ef725ff;
    }
    .nav-links {
      display:flex;
      gap:20px;
    }
    .nav-links a {
      color:#fff;
      text-decoration:none;
      font-weight:500;
      transition:0.3s;
    }
    .nav-links a:hover {
      color: #4ce107ff;
    }

    /* Hero */
    .hero {
      display:flex;
      align-items:center;
      justify-content:space-between;
      flex-wrap:wrap;
      padding:80px 5%;
      background:linear-gradient(135deg,#fff0f0 0%,#ffe6e6 100%);
    }
    .hero-text {
      flex:1;
      padding-right:40px;
      animation:fadeInLeft 1s ease forwards;
    }
    .hero-text h1 {
      font-size:2.5rem;
      color:darkred;
      font-weight:800;
      margin-bottom:20px;
    }
    .hero-text p {
      font-size:1.2rem;
      margin-bottom:30px;
    }
    .hero-text .btn {
      background:darkred;
      color:#fff;
      padding:12px 25px;
      border:none;
      border-radius:8px;
      cursor:pointer;
      font-size:1rem;
      transition:0.3s;
      text-decoration:none;
    }
    .hero-text .btn:hover {
      background:#a40000;
    }
    .hero img {
      flex:1;
      max-width:450px;
      animation:float 4s ease-in-out infinite;
    }

    /* Stats */
    .stats {
      display:flex;
      justify-content:center;
      flex-wrap:wrap;
      gap:30px;
      padding:60px 5%;
      background:#fff;
    }
    .stat-box {
      background:#fff;
      border-radius:15px;
      box-shadow:0 5px 20px rgba(0,0,0,0.1);
      text-align:center;
      padding:30px;
      width:220px;
      transition:0.3s;
    }
    .stat-box:hover {
      transform:translateY(-10px);
      box-shadow:0 10px 30px rgba(0,0,0,0.15);
    }
    .stat-box i {
      font-size:2rem;
      color:darkred;
      margin-bottom:15px;
    }
    .stat-number {
      font-size:2rem;
      font-weight:700;
      color:darkred;
    }
    .stat-label {
      font-size:1rem;
      font-weight:500;
      color:#555;
    }

    /* Features */
    .features {
      padding:80px 5%;
      background:linear-gradient(135deg,#fff7f7,#ffeef0);
      text-align:center;
    }
    .features h2 {
      font-size:2rem;
      color:darkred;
      margin-bottom:40px;
      position:relative;
      display:inline-block;
    }
    .features h2::after {
      content:'';
      position:absolute;
      bottom:-10px;
      left:50%;
      transform:translateX(-50%);
      width:80px;
      height:4px;
      background:darkred;
      border-radius:5px;
    }
    .feature-boxes {
      display:flex;
      flex-wrap:wrap;
      justify-content:center;
      gap:30px;
    }
    .feature-box {
      background:#fff;
      border-radius:15px;
      box-shadow:0 5px 20px rgba(0,0,0,0.1);
      padding:30px 20px;
      width:260px;
      text-align:center;
      transition:0.3s;
    }
    .feature-box:hover {
      transform:translateY(-10px);
    }
    .feature-box i {
      font-size:2rem;
      color:darkred;
      margin-bottom:15px;
    }
    .feature-box h3 {
      font-size:1.2rem;
      margin-bottom:10px;
      color:#333;
    }
    .feature-box p {
      font-size:0.95rem;
      color:#555;
    }

    /* Footer */
    .footer {
      background: #e21010ff;
      color: #fff;
      text-align:center;
      padding:30px 20px;
     
    }
    .footer p {
      margin:5px 0;
    }

    /* Animations */
    @keyframes fadeInLeft {
      from{opacity:0; transform:translateX(-50px);}
      to{opacity:1; transform:translateX(0);}
    }
    @keyframes float {
      0% {transform:translateY(0);}
      50% {transform:translateY(-15px);}
      100% {transform:translateY(0);}
    }

    @media(max-width:768px){
      .hero {
        flex-direction:column;
        text-align:center;
      }
      .hero-text {
        padding-right:0;
        margin-bottom:40px;
      }
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
   <a href="<?=$base_url?>index.php" class="logo"><i class="fas fa-hand-holding-medical"></i> Blood Bank</a>
   <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li><a class="nav-link" href="<?= $base_url?>index.php">Home</a></li>
        <li><a class="nav-link" href="<?= $base_url?>about.php">About Us</a></li>
       
        <li><a class="nav-link" href="<?= $base_url?>contact.php">Contact Us</a></li>
        <?php if(isLoggedIn()): ?>
        <?php
$baseURL = "http://localhost/bms/"; // ✅ Change this to your actual site base URL
$role = $_SESSION['role'] ?? '';

if ($role == 'admin') {
    $dashboardLink = $baseURL . "admin/dashboard.php";
} elseif ($role == 'donor') {
    $dashboardLink = $baseURL . "donor/dashboard.php";
} elseif ($role == 'patient') {
    $dashboardLink = $baseURL . "patient/dashboard.php";
} else {
    $dashboardLink = $baseURL . "dashboard.php"; // fallback
}
?>

          <li><a class="nav-link" href="<?php echo $dashboardLink; ?>">Dashboard</a></li>
          <li><a class="nav-link" href="<?= $base_url?>logout.php">Logout</a></li>
        <?php else: ?>
          <li><a class="nav-link" href="<?= $base_url?>login.php">Login</a></li>
          <li><a class="nav-link" href="<?= $base_url?>register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

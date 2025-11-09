
<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - Digital Blood Bank</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    *{
      margin:0;
      padding:0;
      box-sizing:border-box;
      font-family:'Poppins',sans-serif;
    }
    body{
      background:#fff;
      color:#333;
      line-height:1.6;
    }
    header{
      background:darkred;
      color:#fff;
      padding:1rem 5%;
      text-align:center;
      font-size:1.5rem;
      font-weight:600;
    }
    header span{
      color:#ffcc00;
    }

    /* Hero */
    .abouthero{
      background:linear-gradient(rgba(139,0,0,0.7),rgba(139,0,0,0.7)),
        url('https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=1350&q=80') center/cover;
      color:#fff;
      text-align:center;
      padding:100px 20px;
    }
    .abouthero h1{
      font-size:3rem;
      margin-bottom:20px;
    }
    .abouthero p{
      font-size:1.2rem;
      max-width:700px;
      margin:auto;
    }

    /* About Section */
    .about{
      padding:80px 5%;
      display:grid;
      grid-template-columns:1fr 1fr;
      gap:40px;
      align-items:center;
    }
    .about img{
      width:100%;
      border-radius:15px;
      box-shadow:0 10px 25px rgba(0,0,0,0.15);
    }
    .about-text h2{
      color:darkred;
      font-size:2rem;
      margin-bottom:20px;
      position:relative;
    }
    .about-text h2::after{
      content:'';
      width:80px;
      height:4px;
      background:darkred;
      position:absolute;
      left:0;
      bottom:-10px;
      border-radius:2px;
    }
    .about-text p{
      margin-bottom:15px;
      color:#555;
    }

    /* Mission + Vision */
    .mission{
      background:#f8f8f8;
      padding:80px 5%;
      text-align:center;
    }
    .mission h2{
      font-size:2rem;
      color:darkred;
      margin-bottom:20px;
    }
    .mission p{
      max-width:800px;
      margin:auto;
      color:#555;
      font-size:1.1rem;
    }
    .mv-grid{
      display:grid;
      grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
      gap:30px;
      margin-top:40px;
    }
    .mv-card{
      background:#fff;
      padding:30px;
      border-radius:15px;
      box-shadow:0 8px 25px rgba(0,0,0,0.1);
      transition:transform 0.3s;
    }
    .mv-card:hover{
      transform:translateY(-10px);
    }
    .mv-card i{
      font-size:2rem;
      color:darkred;
      margin-bottom:15px;
    }
    .mv-card h3{
      margin-bottom:10px;
      color:#222;
    }
    .mv-card p{
      color:#555;
      font-size:0.95rem;
    }

    /* Stats */
    .stats{
      background:linear-gradient(rgba(139,0,0,0.8),rgba(139,0,0,0.8)),
        url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=1350&q=80') center/cover fixed;
      color:#fff;
      padding:80px 5%;
      text-align:center;
    }
    .stats h2{
      font-size:2rem;
      margin-bottom:40px;
    }
    .stats-grid{
      display:grid;
      grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
      gap:30px;
    }
    .stat-box{
      background:rgba(255,255,255,0.1);
      padding:30px;
      border-radius:15px;
      transition:0.3s;
    }
    .stat-box:hover{
      background:rgba(255,255,255,0.2);
      transform:scale(1.05);
    }
    .stat-box h3{
      font-size:2rem;
      margin-bottom:10px;
      color:#ffcc00;
    }

    /* Footer */
    footer{
      background:#111;
      color:#ccc;
      text-align:center;
      padding:30px 20px;
    }
    footer p{
      margin:5px 0;
      font-size:0.9rem;
    }

    @media(max-width:900px){
      .about{
        grid-template-columns:1fr;
        text-align:center;
      }
      .about-text h2::after{
        left:50%;
        transform:translateX(-50%);
      }
    }
  </style>
</head>
<body>
  

  <!-- Hero -->
  <section class="abouthero">
    <h1 class="h1">About Us</h1>
    <p>We are on a mission to bridge the gap between blood donors and recipients using technology, compassion, and innovation.</p>
  </section>

  <!-- About -->
  <section class="about">
    <img src="https://images.unsplash.com/photo-1581595219315-a187dd40c322?auto=format&fit=crop&w=1350&q=80" alt="Blood Donation">
    <div class="about-text">
      <h2>Who We Are</h2>
      <p>Digital Blood Bank is a next-generation platform designed to ensure no life is lost due to lack of timely blood availability. By connecting donors, patients, and hospitals on a single digital platform, we provide seamless access to life-saving resources.</p>
      <p>Our system leverages technology to manage donor records, blood requests, and inventory with accuracy and efficiency while keeping compassion at the heart of everything we do.</p>
    </div>
  </section>

  <!-- Mission + Vision -->
  <section class="mission">
    <h2>Our Mission & Vision</h2>
    <p>At Digital Blood Bank, we envision a world where every patient has access to safe and timely blood. Our mission is to save lives by simplifying the donation and request process with innovation, transparency, and community involvement.</p>
    <div class="mv-grid">
      <div class="mv-card">
        <i class="fas fa-bullseye"></i>
        <h3>Mission</h3>
        <p>To provide an accessible, efficient, and reliable blood bank management system that connects donors and patients in real time.</p>
      </div>
      <div class="mv-card">
        <i class="fas fa-eye"></i>
        <h3>Vision</h3>
        <p>To build a healthier future where technology and humanity unite to save millions of lives worldwide.</p>
      </div>
      <div class="mv-card">
        <i class="fas fa-heart"></i>
        <h3>Values</h3>
        <p>Compassion, transparency, innovation, and commitment to saving lives guide everything we do.</p>
      </div>
    </div>
  </section>

  <!-- Stats -->
  <section class="stats">
    <h2>Our Impact in Numbers</h2>
    <div class="stats-grid">
      <div class="stat-box">
        <h3>15,000+</h3>
        <p>Lives Saved</p>
      </div>
      <div class="stat-box">
        <h3>2,000+</h3>
        <p>Registered Donors</p>
      </div>
      <div class="stat-box">
        <h3>50+</h3>
        <p>Partner Hospitals</p>
      </div>
      <div class="stat-box">
        <h3>99.9%</h3>
        <p>Fulfillment Rate</p>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 Digital Blood Bank. All Rights Reserved.</p>
    <p>Designed with ❤️ to save lives</p>
  </footer>
</body>
</html>

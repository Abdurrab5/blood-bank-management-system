
<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Digital Blood Bank Management System</title>
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: darkred;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        header {
            background-color: darkred;
            color: white;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
        }

        .logo span {
            color: #ffcc00;
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin-left: 30px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #ffcc00;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(3, 49, 53, 0.8), rgba(3, 49, 53, 0.8)), url('https://images.unsplash.com/photo-1579684385127-1ef15d508118?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 20px;
            max-width: 800px;
            margin: 0 auto 30px;
        }

        .btn {
            display: inline-block;
            background-color: #ffcc00;
            color: #333;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
        }

        .btn:hover {
            background-color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Slideshow Section */
        .slideshow-section {
            padding: 80px 0;
            background-color: #3b0202;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 36px;
            color: darkred;
            margin-bottom: 15px;
        }

        .section-title p {
            color: white;
            max-width: 700px;
            margin: 0 auto;
        }

        .slideshow-container {
            max-width: 900px;
            position: relative;
            margin: auto;
            height: 500px;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .slide {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            display: flex;
            align-items: center;
            padding: 0 50px;
            background-size: cover;
            background-position: center;
        }

        .slide.active {
            opacity: 1;
        }

        .slide-content {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            max-width: 500px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .slide h3 {
            font-size: 24px;
            color: white;
            margin-bottom: 15px;
        }

        .slide p {
            color: #555;
            margin-bottom: 20px;
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background-color:white;
            
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .feature-card {
            background-color: rgb(46, 2, 2);
            color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(167, 35, 35, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 50px;
            color: white;
            margin-bottom: 20px;
        }

        .feature-card h3 {
            font-size: 22px;
            margin-bottom: 15px;
            color:yellow;
        }

        /* Stats Section */
        .stats {
            padding: 80px 0;
            background: linear-gradient(rgba(77, 78, 78, 0.8), rgba(3, 49, 53, 0.8)), url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            text-align: center;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .stat-item h3 {
            font-size: 50px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .stat-item p {
            font-size: 18px;
            opacity: 0.9;
        }

        /* Footer */
        footer {
            background-color: #222;
            color: #fff;
            padding: 50px 0 20px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .footer-column h3 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #ffcc00;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 10px;
        }

        .footer-column ul li a {
            color: #ddd;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-column ul li a:hover {
            color: #ffcc00;
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-links a {
            color: #fff;
            font-size: 20px;
            transition: color 0.3s;
        }

        .social-links a:hover {
            color: #ffcc00;
        }

        .copyright {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #444;
            color: #aaa;
            font-size: 14px;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }

            nav ul {
                margin-top: 20px;
                justify-content: center;
            }

            nav ul li {
                margin: 0 10px;
            }

            .hero h1 {
                font-size: 36px;
            }

            .hero p {
                font-size: 18px;
            }

            .slideshow-container {
                height: 400px;
            }

            .slide {
                padding: 0 20px;
            }

            .slide-content {
                max-width: 100%;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
   

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>About Our Digital Blood Bank</h1>
            <p>Connecting donors with recipients through advanced technology to save lives efficiently and effectively.</p>
            <a href="#features" class="btn">Explore Features</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-title">
                <h2>Our Core Features</h2>
                <p>Comprehensive digital solutions for all blood bank management needs</p>
            </div>

            <div class="features-grid">
                <!-- Donor Management -->
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <h3>Donor Management</h3>
                    <p>Complete donor profiles with medical history, donation records, eligibility status, and communication tools.</p>
                </div>

                <!-- Patient Management -->
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-procedures"></i>
                    </div>
                    <h3>Patient Management</h3>
                    <p>Track patient needs, blood requests, and transfusion history with comprehensive patient records.</p>
                </div>

                <!-- Blood Collection -->
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-syringe"></i>
                    </div>
                    <h3>Blood Collection</h3>
                    <p>Manage blood drives, collection appointments, and processing with detailed tracking at each stage.</p>
                </div>

                <!-- Blood Request -->
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-hand-holding-medical"></i>
                    </div>
                    <h3>Blood Request</h3>
                    <p>Streamlined process for hospitals to request specific blood products with priority management.</p>
                </div>

                <!-- Inventory Tracking -->
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <h3>Inventory Tracking</h3>
                    <p>Real-time monitoring of blood products including type, quantity, expiration dates, and storage locations.</p>
                </div>

                
            </div>
        </div>
    </section>

    <!-- Slideshow Section -->
    <section class="slideshow-section">
        <div class="container">
            <div class="section-title">
                <h2>System Highlights</h2>
                <p>Key aspects of our digital blood bank management platform</p>
            </div>

            <div class="slideshow-container">
                <!-- Slide 1 - Donor Management -->
                <div class="slide active" style="background-image: url('https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
                    <div class="slide-content">
                        <h3>Comprehensive Donor Management</h3>
                        <p>Maintain complete donor records including personal information, medical history, donation frequency, and eligibility status with automated reminders for eligible donations.</p>
                        <a href="#" class="btn">Learn More</a>
                    </div>
                </div>

                <!-- Slide 2 - Patient Management -->
                <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1581056771107-24ca5f033842?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
                    <div class="slide-content">
                        <h3>Integrated Patient Management</h3>
                        <p>Track patient blood requirements, transfusion history, and physician requests with hospital integration for seamless patient care coordination.</p>
                        <a href="#" class="btn">See How It Works</a>
                    </div>
                </div>

                <!-- Slide 3 - Blood Collection -->
                <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1581595219315-a187dd40c322?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
                    <div class="slide-content">
                        <h3>Efficient Blood Collection</h3>
                        <p>Schedule and manage blood drives, mobile collection units, and donor appointments with automated notifications and follow-up systems.</p>
                        <a href="#" class="btn">View Collection Process</a>
                    </div>
                </div>

                <!-- Slide 4 - Blood Request -->
                <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
                    <div class="slide-content">
                        <h3>Streamlined Blood Requests</h3>
                        <p>Hospital staff can quickly request specific blood products with priority tagging and real-time availability checking.</p>
                        <a href="#" class="btn">Request Process</a>
                    </div>
                </div>

                <!-- Slide 5 - Inventory Tracking -->
                <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1584473457409-ceb3f7c2c92f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
                    <div class="slide-content">
                        <h3>Real-Time Inventory Tracking</h3>
                        <p>Monitor all blood products with detailed information including blood type, Rh factor, collection date, expiration, and storage location.</p>
                        <a href="#" class="btn">Inventory Demo</a>
                    </div>
              

                <!-- Slide 7 - Donor Communication -->
                <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
                    <div class="slide-content">
                        <h3>Donor Communication</h3>
                        <p>Automated thank you messages, donation impact reports, and targeted appeals when specific blood types are needed.</p>
                        <a href="#" class="btn">Communication Tools</a>
                    </div>
                </div>

                <!-- Slide 8 - Reporting -->
                <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1581595219315-a187dd40c322?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
                    <div class="slide-content">
                        <h3>Comprehensive Reporting</h3>
                        <p>Generate reports on donation statistics, blood utilization, expiration rates, and donor demographics for better decision making.</p>
                        <a href="#" class="btn">Reporting Features</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="section-title">
                <h2>Our Impact</h2>
                <p>Numbers that demonstrate our commitment to saving lives through technology</p>
            </div>

            <div class="stats-grid">
                <div class="stat-item">
                    <h3>15000+</h3>
                    <p>Lives Saved</p>
                </div>

                <div class="stat-item">
                    <h3>1000+</h3>
                    <p>Registered Donors</p>
                </div>

                <div class="stat-item">
                    <h3>10</h3>
                    <p>Partner Hospitals</p>
                </div>

                <div class="stat-item">
                    <h3>99.8%</h3>
                    <p>Request Fulfillment Rate</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>BloodLink</h3>
                    <p>Revolutionizing blood bank management through digital innovation to ensure no patient goes without needed blood products.</p>
                    <div class="social-links">
                        <a href=" https://www.facebook.com"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter-cl.vercel.app/login"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.instagram.com/"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Contact Us</h3>
                    <ul>
                
                        <li><i class="fas fa-phone"></i>  0311-1222398</li>
                    
                        <li><i class="fas fa-clock"></i> 24/7 Emergency Support</li>
                    </ul>
                </div>
            </div>

            <div class="copyright">
                <p>&copy; 2025 BloodBank Digital Blood Bank Management System. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Slideshow functionality
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.slide');
            let currentSlide = 0;
            
            function showSlide(n) {
                slides.forEach(slide => slide.classList.remove('active'));
                currentSlide = (n + slides.length) % slides.length;
                slides[currentSlide].classList.add('active');
            }
            
            // Auto-advance slides every 3 seconds
            setInterval(() => {
                showSlide(currentSlide + 1);
            }, 3000);
            
            // Manual navigation (if you want to add buttons later)
            function nextSlide() {
                showSlide(currentSlide + 1);
            }
            
            function prevSlide() {
                showSlide(currentSlide - 1);
            }
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        });

        // Animation on scroll
        window.addEventListener('scroll', function() {
            const features = document.querySelectorAll('.feature-card');
            const windowHeight = window.innerHeight;
            
            features.forEach(feature => {
                const featurePosition = feature.getBoundingClientRect().top;
                if (featurePosition < windowHeight - 100) {
                    feature.style.opacity = '1';
                    feature.style.transform = 'translateY(0)';
                }
            });
        });

        // Initialize features with some opacity for animation
        document.querySelectorAll('.feature-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        });
    </script>
</body>
</html>
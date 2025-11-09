<?php include "header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Blood Bank Management System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }
    
    body {
      background:linear-gradient(135deg, white, white 100%);;
      color: #4a2c54;
      overflow-x: hidden;
      position: relative;
    }
    
    /* Decorative Elements */
    .circle {
      position: absolute;
      border-radius: 50%;
      background: rgba(163, 0, 64, 0.05);
      z-index: -1;
    }
    
    .circle-1 {
      width: 300px;
      height: 300px;
      top: 10%;
      left: 5%;
    }
    
    .circle-2 {
      width: 200px;
      height: 200px;
      bottom: 20%;
      right: 10%;
    }
    
    .circle-3 {
      width: 150px;
      height: 150px;
      top: 40%;
      right: 20%;
    }
    
    /* Navbar */
    .navbar {
      background: rgb(100, 14, 14);
      padding: 1rem 5%;
      display: flex;
      align-items: center;
      box-shadow: 0 2px 15px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 100;
    }
    
    .logo {
      display: flex;
      align-items: center;
      text-decoration: none;
      margin-right: auto;
    }
    
    .logo-icon {
      width: 40px;
      height: 40px;
      background: #fff;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 10px;
    }
    
    .logo-icon i {
      color: darkred;
      font-size: 20px;
    }
    
    .logo-text {
      color: white;
      font-size: 1.5rem;
      font-weight: 600;
      letter-spacing: 1px;
    }
    
    .nav-links {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .nav-item {
      color: white;
      text-decoration: none;
      padding: 0.6rem 1rem;
      border-radius: 5px;
      transition: all 0.3s ease;
      background: transparent;
      font-size: 0.95rem;
      font-weight: 500;
    }
    
    .nav-item:hover {
      background: rgba(255, 255, 255, 0.15);
    }
    
    .dropdown {
      position: relative;
      display: inline-block;
    }
    
    .dropdown-btn {
      background: rgba(255, 255, 255, 0.2);
      color: white;
      padding: 0.6rem 1rem;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-family: 'Poppins', sans-serif;
      font-size: 0.95rem;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: all 0.3s ease;
    }
    
    .dropdown-btn:hover {
      background: rgba(255, 255, 255, 0.3);
    }
    
    .dropdown-content {
      display: none;
      position: absolute;
      background: white;
      min-width: 200px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
      z-index: 1;
      border-radius: 8px;
      overflow: hidden;
      top: 100%;
      right: 0;
    }
    
    .dropdown-content a {
      color: #333;
      padding: 12px 16px;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 0.9rem;
      transition: all 0.3s ease;
    }
    
    .dropdown-content a:hover {
      background: #f8f0f5;
      color: darkred;
    }
    
    .dropdown:hover .dropdown-content {
      display: block;
    }
    
    /* Animation Keyframes */
    @keyframes slideInLeft {
      0% { opacity: 0; transform: translateX(-100px); }
      100% { opacity: 1; transform: translateX(0); }
    }
    
    @keyframes slideInRight {
      0% { opacity: 0; transform: translateX(100px); }
      100% { opacity: 1; transform: translateX(0); }
    }
    
    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(30px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes pulse {
      0% { box-shadow: 0 0 0 0 rgba(163, 0, 64, 0.7); }
      70% { box-shadow: 0 0 0 15px rgba(163, 0, 64, 0); }
      100% { box-shadow: 0 0 0 0 rgba(163, 0, 64, 0); }
    }
    
    /* New Animations for Text */
    @keyframes fadeInScale {
      0% {
        opacity: 0;
        transform: scale(0.8);
      }
      100% {
        opacity: 1;
        transform: scale(1);
      }
    }
    
    @keyframes slideInBottom {
      0% {
        opacity: 0;
        transform: translateY(30px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    @keyframes textGlow {
      0% {
        text-shadow: 0 0 5px rgba(163, 0, 64, 0.3);
      }
      50% {
        text-shadow: 0 0 20px rgba(163, 0, 64, 0.7);
      }
      100% {
        text-shadow: 0 0 5px rgba(163, 0, 64, 0.3);
      }
    }
    
    @keyframes letterWave {
      0%, 100% {
        transform: translateY(0);
      }
      25% {
        transform: translateY(-10px);
      }
      50% {
        transform: translateY(0);
      }
      75% {
        transform: translateY(5px);
      }
    }
    
    @keyframes float {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-15px); }
      100% { transform: translateY(0px); }
    }
    
    @keyframes colorShift {
      30% { color: yellow; }
      50% { color: darkred; }
      100% { color: darkgreen; }
    }
    
    /* Hero Section with Text Animation */
    .hero-section {
      padding: 100px 20px 60px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      max-width: 1200px;
      margin: 0 auto;
      flex-wrap: wrap;
      min-height: 80vh;
    }
    
    .hero-text {
      flex: 1 1 50%;
      padding-right: 40px;
      text-align: left;
    }
    
    .animated-heading {
      font-size: 2.2rem;
      color: darkred;
      font-weight: 850;
      margin-bottom: 25px;
      line-height: 1.2;
      position: relative;
      display: inline-block;
      overflow: hidden;
    }
    
    .animated-heading span {
      display: inline-block;
      opacity: 0;
      transform: translateY(20px);
      animation: fadeInScale 0.8s forwards;
    }
    
    .animated-heading:after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 0;
      width: 120px;
      height: 5px;
      background: linear-gradient(90deg, darkred, #b35cb3);
      border-radius: 5px;
      animation: slideInBottom 1.2s 1.5s forwards;
      opacity: 0;
    }
    
    .animated-subtitle {
      font-size: 1.25rem;
      font-weight: 500;
      margin: 30px 0;
      line-height: 1.7;
      background: rgba(255, 255, 255, 0.7);
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      opacity: 0;
      transform: translateY(20px);
      animation: fadeInScale 0.8s 0.8s forwards;
    }
    
    .highlight {
      font-weight: 700;
      color: darkred;
      position: relative;
      display: inline-block;
      animation: textGlow 3s infinite;
    }
    
    .image-container {
      flex: 1 1 40%;
      text-align: right;
      animation: slideInRight 1s ease forwards;
      position: relative;
    }
    
    .image-container img {
      max-width: 100%;
      height: auto;
      border-radius: 20px;
      transition: transform 0.4s ease, box-shadow 0.4s ease;
      cursor: pointer;
      border: 10px solid white;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
      animation: float 4s ease-in-out infinite;
    }
    
    /* Stats Section */
    .stats-section {
      padding: 60px 20px;
      background: linear-gradient(135deg, rgba(163, 0, 64, 0.1) 0%, rgba(179, 44, 191, 0.1) 100%);
      text-align: center;
    }
    
    .stats-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .stat-box {
      background: white;
      border-radius: 16px;
      padding: 30px;
      width: 250px;
      text-align: center;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      opacity: 0;
      transform: translateY(30px);
      animation: fadeInUp 0.8s forwards;
    }
    
    .stat-box:nth-child(1) { animation-delay: 0.1s; }
    .stat-box:nth-child(2) { animation-delay: 0.2s; }
    .stat-box:nth-child(3) { animation-delay: 0.3s; }
    .stat-box:nth-child(4) { animation-delay: 0.4s; }
    
    .stat-box:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 40px rgba(163, 0, 64, 0.2);
    }
    
    .stat-number {
      font-size: 3rem;
      font-weight: 700;
      color: darkred;
      margin-bottom: 10px;
      animation: letterWave 1.5s infinite;
    }
    
    .stat-text {
      font-size: 1.1rem;
      font-weight: 600;
      color: #4a0c36;
    }
    
    /* Features Section */
    .features-section {
      padding: 80px 20px;
      background: linear-gradient(135deg, #fef7fb 0%, #fff0f8 100%);
      text-align: center;
      position: relative;
    }
    
    .section-title {
      font-size: 2.5rem;
      color: darkred;
      margin-bottom: 60px;
      position: relative;
      display: inline-block;
      opacity: 0;
      transform: translateY(20px);
      animation: fadeInUp 0.8s 0.5s forwards;
    }
    
    .section-title:after {
      content: '';
      position: absolute;
      bottom: -15px;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 5px;
      background: darkred;
      border-radius: 5px;
      animation: slideInBottom 0.8s 1s forwards;
      opacity: 0;
    }
    
    .features-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
      margin-bottom: 30px;
      max-width: 1400px;
      margin: 0 auto;
    }
    
    .feature-box {
      background: linear-gradient(135deg, rgb(4, 25, 37) 0%, #1a2a4a 100%);
      border-radius: 16px;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
      padding: 30px 25px;
      width: 280px;
      text-align: center;
      transition: all 0.4s ease;
      position: relative;
      overflow: hidden;
      opacity: 0;
      transform: translateY(30px);
      animation: fadeInUp 0.8s forwards;
    }
    
    .feature-box:nth-child(1) { animation-delay: 0.1s; }
    .feature-box:nth-child(2) { animation-delay: 0.2s; }
    .feature-box:nth-child(3) { animation-delay: 0.3s; }
    .feature-box:nth-child(4) { animation-delay: 0.4s; }
    .feature-box:nth-child(5) { animation-delay: 0.5s; }
    .feature-box:nth-child(6) { animation-delay: 0.6s; }
    
    .feature-box:before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
      transition: all 0.6s ease;
      transform: rotate(45deg);
    }
    
    .feature-box:hover:before {
      transform: rotate(45deg) translate(20px, 20px);
    }
    
    .feature-box:hover {
      transform: translateY(-15px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
    }
    
    .feature-box img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 20px;
      border: 5px solid rgba(255,255,255,0.2);
      position: relative;
    }
    
    .feature-box h3 {
      font-size: 18px;
      color: white;
      line-height: 1.5;
      position: relative;
      animation: colorShift 3s infinite;
    }
    
    /* Feature Panel Section */
    .feature-panel-section {
      padding: 80px 20px;
      background: linear-gradient(135deg, darkred 0%, #fdf1fa 100%);
    }
    
    .container {
      display: flex;
      flex-wrap: wrap;
      gap: 40px;
      max-width: 1200px;
      margin: auto;
      padding: 40px 30px;
      background-color: rgb(10, 1, 32);
      border-radius: 20px;
      box-shadow: 0 20px 50px rgba(0,0,0,0.1);
      opacity: 0;
      transform: translateY(30px);
      animation: fadeInUp 0.8s 0.6s forwards;
    }
    
    .sidebar {
      width: 250px;
      background: linear-gradient(135deg, rgb(4, 18, 32) 0%, #0d1b2f 100%);
      border-radius: 16px;
      padding: 30px 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    
    .sidebar h2 {
      font-size: 24px;
      margin-bottom: 30px;
      color: white;
      text-align: center;
      position: relative;
      padding-bottom: 15px;
    }
    
    .sidebar h2:after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 50px;
      height: 3px;
      background: #e2535a;
    }
    
    .sidebar ul {
      list-style: none;
      padding: 0;
    }
    
    .sidebar li {
      padding: 15px 20px;
      margin: 10px 0;
      cursor: pointer;
      color: white;
      border-left: 4px solid transparent;
      transition: all 0.3s ease;
      border-radius: 0 8px 8px 0;
      font-size: 16px;
      display: flex;
      align-items: center;
    }
    
    .sidebar li i {
      margin-right: 12px;
      font-size: 18px;
      width: 25px;
      text-align: center;
    }
    
    .sidebar li:hover {
      background: rgba(255,255,255,0.1);
    }
    
    .sidebar li.active {
      border-left: 4px solid #e2535a;
      background: rgba(226, 83, 90, 0.15);
      color: lightpink;
      font-weight: 600;
    }
    
    .content {
      flex: 1;
      min-width: 300px;
    }
    
    .content h2 {
      color: #4a0c36;
      font-size: 28px;
      margin-bottom: 15px;
      position: relative;
      padding-bottom: 10px;
      animation: colorShift 3s infinite;
    }
    
    .content h2:after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 70px;
      height: 3px;
      background: darkred;
      animation: colorShift 3s infinite;
    }
    
    .content p {
      font-size: 16px;
      color: #555;
      margin-bottom: 30px;
      max-width: 700px;
      line-height: 1.7;
    }
    
    .feature-img {
      width: 100%;
      max-width: 700px;
      border-radius: 15px;
      margin-bottom: 40px;
      box-shadow: 0 15px 40px rgba(0,0,0,0.15);
      border: 1px solid rgba(0,0,0,0.05);
    }
    
    .card-row {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-top: 20px;
    }
    
    .card {
      flex: 1;
      min-width: 200px;
      text-align: center;
      background: linear-gradient(135deg, #b93e35 0%, #ffeef7 100%);
      padding: 25px 20px;
      border-radius: 16px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.08);
      transition: all 0.3s ease;
      border: 1px solid rgba(163, 0, 64, 0.1);
    }
    
    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(163, 0, 64, 0.15);
    }
    
    .card-icon {
      font-size: 42px;
      color: #a40040;
      margin-bottom: 15px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      animation: float 3s ease-in-out infinite;
    }
    
    .card-text {
      font-size: 16px;
      font-weight: 600;
      color: #4a0c36;
    }
    
    /* Side Tab */
    .side-tab {
      position: fixed;
      top: 20%;
      right: 20px;
      transform: translateY(-50%);
      background: darkred;
      color: white;
      padding: 15px 20px;
      font-size: 1rem;
      font-weight: 400;
      border-radius: 10px;
      box-shadow: 0 10px 30px rgba(139, 0, 0, 0.4);
      transition: all 0.3s ease;
      z-index: 9999;
      cursor: pointer;
      animation: pulse 2s infinite;
      writing-mode: vertical-lr;
      text-orientation: mixed;
      transform: rotate(180deg);
      height: 350px;
      width: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-transform: uppercase;
      letter-spacing: 2px;
      opacity: 0;
      animation: fadeInUp 1s 2s forwards, pulse 2s 3s infinite;
    }
    
    .side-tab:hover {
      right: 15px;
      background: linear-gradient(135deg, darkred, #b3005e);
      box-shadow: 0 15px 40px rgba(163, 0, 64, 0.5);
    }
    .container {
      max-width: 900px;
      width: 100%;
      background: white;
      border-radius: 20px;
      box-shadow: 0 15px 40px rgba(104, 33, 122, 0.15);
      overflow: hidden;
    }

    header {
      background: linear-gradient(to right, #68217a, #b5489e);
      color: white;
      padding: 40px 30px;
      text-align: center;
      position: relative;
    }

    header h1 {
      font-size: 2.5rem;
      margin-bottom: 10px;
      font-weight: 700;
      text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    header p {
      font-size: 1.1rem;
      opacity: 0.9;
      max-width: 600px;
      margin: 0 auto;
    }

    .search-container {
      margin: 25px auto 10px;
      max-width: 600px;
      position: relative;
    }

    .search-container input {
      width: 100%;
      padding: 15px 20px 15px 50px;
      border-radius: 50px;
      border: none;
      font-size: 1rem;
      box-shadow: 0 5px 15px rgba(104, 33, 122, 0.2);
    }

    .search-container i {
      position: absolute;
      left: 20px;
      top: 50%;
      transform: translateY(-50%);
      color: #b5489e;
      font-size: 1.2rem;
    }

    .faq-section {
      padding: 30px;
    }

    .faq-section h2 {
      text-align: center;
      color: #68217a;
      margin-bottom: 30px;
      font-size: 2rem;
      position: relative;
      display: inline-block;
      left: 50%;
      transform: translateX(-50%);
    }

    .faq-section h2:after {
      content: '';
      display: block;
      width: 60px;
      height: 1px;
      background: #d4a5d8;
      margin: 10px auto 0;
      border-radius: 2px;
    }

    .faq-item {
      background: white;
      border-radius: 12px;
      margin: 15px 0;
      border: 2px solid #e8d0ea;
      overflow: hidden;
      box-shadow: 0 3px 10px rgba(181, 72, 158, 0.08);
      transition: all 0.3s ease;
    }

    .faq-item:hover {
      border-color: #d4a5d8;
      box-shadow: 0 5px 15px rgba(181, 72, 158, 0.15);
    }

    .faq-question {
      background: white;
      color: darkgoldenrod;
      padding: 20px 60px 20px 25px;
      width: 100%;
      text-align: left;
      font-weight: 800;
      font-size: 1.1rem;
      border: none;
      cursor: pointer;
      outline: none;
      position: relative;
      transition: all 0.2s;
    }

    .faq-question:hover {
      background: rgb(12, 0, 0);
    }

    .faq-question:after {
      content: '\f067';
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
      position: absolute;
      right: 25px;
      top: 50%;
      transform: translateY(-50%);
      width: 24px;
      height: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s;
      color: #b5489e;
    }

    .faq-item.active .faq-question:after {
      content: '\f068';
      color: #68217a;
    }

    .faq-answer {
      padding: 0 25px;
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.4s ease-out, padding 0.4s ease-out;
      background: #fff;
      color: #555;
      line-height: 1.2;
      font-size: 1.05rem;
    }

    .faq-item.active .faq-answer {
      max-height: 500px;
      padding: 0 25px 25px;
    }

    .faq-item.active .faq-answer p {
      animation: fadeIn 0.5s ease-out;
    }

    .stats {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin: 30px 0;
      flex-wrap: wrap;
    }

    .stat-box {
      background: linear-gradient(to bottom right, #f8e9f7, #e8f4fe);
      border-radius: 15px;
      padding: 20px;
      text-align: center;
      min-width: 150x;
      box-shadow: 0 5px 15px rgba(104, 33, 122, 0.1);
      border: 1px solid #e8d0ea;
    }

    .stat-box .number {
      font-size: 2.5rem;
      font-weight: 700;
      color: #b5489e;
      line-height: 1;
      margin-bottom: 5px;
    }

    .stat-box .label {
      font-size: 1rem;
      color: #68217a;
      font-weight: 600;
    }


    .no-results {
      text-align: center;
      padding: 30px;
      color: #b5489e;
      font-size: 1.1rem;
      display: none;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
      header {
        padding: 30px 20px;
      }
      
      header h1 {
        font-size: 2rem;
      }
      
      .faq-section {
        padding: 20px;
      }
      
      .faq-question {
        padding-right: 50px;
        font-size: 1rem;
      }
      
      .stats {
        gap: 15px;
      }
      
      .stat-box {
        min-width: 120px;
        padding: 15px;
      }
      
      .stat-box .number {
        font-size: 2rem;
      }
    }

    @media (max-width: 480px) {
      .stats {
        flex-direction: column;
        align-items: center;
      }
      
      .stat-box {
        width: 100%;
        max-width: 250px;
      }
    }
    
    /* Footer */
    .footer {
      background: linear-gradient(135deg, #1a0d1c 0%, #2d0b21 100%);
      color: white;
      padding: 60px 20px 30px;
      text-align: center;
    }
    
    .footer-content {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      gap: 40px;
      text-align: left;
    }
    
    .footer-section {
      flex: 1;
      min-width: 250px;
    }
    
    .footer h3 {
      font-size: 1.5rem;
      margin-bottom: 25px;
      position: relative;
      padding-bottom: 10px;
    }
    
    .footer h3:after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 50px;
      height: 3px;
      background: darkred;
    }
    
    .footer-links {
      list-style: none;
      padding: 0;
    }
    
    .footer-links li {
      margin-bottom: 15px;
    }
    
    .footer-links a {
      color: #ccc;
      text-decoration: none;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .footer-links a:hover {
      color: white;
      transform: translateX(5px);
    }
    
    .social-icons {
      display: flex;
      gap: 15px;
      margin-top: 20px;
    }
    
    .social-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: rgba(255,255,255,0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 18px;
      transition: all 0.3s ease;
    }
    
    .social-icon:hover {
      background: darkred;
      transform: translateY(-5px);
    }
    
    .copyright {
      margin-top: 50px;
      padding-top: 20px;
      border-top: 1px solid rgba(255,255,255,0.1);
      font-size: 0.9rem;
      color: #aaa;
    }
    
    /* Responsive Design */
    @media (max-width: 900px) {
      .hero-section {
        flex-direction: column;
        text-align: center;
      }
      .hero-text {
        padding-right: 0;
        margin-bottom: 40px;
      }
      .animated-heading {
        font-size: 2.3rem;
      }
      .section-title {
        font-size: 2rem;
      }
      .image-container {
        width: 100%;
        text-align: center;
      }
      .container {
        flex-direction: column;
      }
      .sidebar {
        width: 100%;
      }
      .sidebar ul {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
      }
      .sidebar li {
        width: 45%;
        margin: 5px;
      }
      .side-tab {
        display: none;
      }
      .nav-links {
        flex-wrap: wrap;
        justify-content: center;
      }
    }
    
    @media (max-width: 600px) {
      .feature-box {
        width: 100%;
        max-width: 350px;
      }
      .sidebar li {
        width: 100%;
      }
      .card {
        min-width: 100%;
      margin-bottom: 15px;
      }
      .animated-heading {
        font-size: 2rem;
      }
      .section-title {
        font-size: 1.8rem;
      }
      .navbar {
        flex-direction: column;
        padding: 15px;
      }
      .logo {
        margin-bottom: 15px;
      }
      .nav-links {
        width: 100%;
        justify-content: center;
      }
      .dropdown {
        width: 100%;
      }
      .dropdown-btn {
        width: 100%;
        justify-content: center;
      }
      .dropdown-content {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <!-- Decorative Background Circles -->
  <div class="circle circle-1"></div>
  <div class="circle circle-2"></div>
  <div class="circle circle-3"></div>
  


  <!-- Hero Section -->
  <section class="hero-section">
    <div class="hero-text">
      <h class="animated-heading" id="main-heading">Digital Blood Bank Management System</h>
      <p class="animated-subtitle">
        <span class="highlight">Smarter And Safer Blood Management</span><br>
        Through Our Comprehensive Platform.<br><br>
        Digital Blood Bank Management System has been developed to streamline the operations of modern-day blood banks. This online solution replaces traditional paperwork with digital efficiency — offering <span class="highlight">streamlined functions</span>, improved patient care, <span class="highlight">secure and centralized administration</span>, and cost-effective operations.
      </p>
    </div>
    <div class="image-container">
      <img src="uploads/images/1.PNG">
    </div>
  </section>

 
  <!-- Stats Section -->
  <section class="stats-section">
    <div class="stats-container">
      <div class="stat-box">
        <div class="stat-number">0</div>
        <div class="stat-text">Blood Banks</div>
      </div>
      <div class="stat-box">
        <div class="stat-number">0</div>
        <div class="stat-text">Registered Donors</div>
      </div>
      <div class="stat-box">
        <div class="stat-number">24/7</div>
        <div class="stat-text">Emergency Support</div>
      </div>
      <div class="stat-box">
        <div class="stat-number">0</div>
        <div class="stat-text">Satisfied Clients</div>
      </div>
    </div>
  </section>

  <section class="features-section">
    <h2 class="section-title">Key Features</h2>
    <div class="features-container">
      <div class="feature-box">
        <img src="uploads/images/kha.PNG" alt="Donor Management" />
        <h3>Register and manage donor profiles, eligibility, history, and communication.</h3>
      </div>
      <div class="feature-box">
        <img src="uploads/images/slide2.jpg" alt="Blood Request" />
        <h3>Handle requests from hospitals or patients and manage allocation efficiently.</h3>
      </div>
      <div class="feature-box">
        <img src="uploads/images/slide3.jpg" alt="Blood Collection" />
        <h3>Track blood units collected with batch, donor, and date information.</h3>
      </div>
      <div class="feature-box">
        <img src="uploads/images/slide1.jpg" alt="Blood Stock" />
        <h3>>Monitor stock levels, expiry dates, and availability of blood components.</h3>
      </div>
      <div class="feature-box">
        <img src="uploads/images/images.jfif" alt="Donation Management" />
        <h3>Schedule and record donations with complete traceability and notifications.</h3>
      </div>
    <div class="feature-box">
        <img src="uploads/images/tec.jpg" alt="Notification" />
        <h3>Send alerts to donors, admins, or patients via email or SMS for updates.</h3>
      </div>

  
    
    <p class="animated-subtitle" style="max-width: 900px; margin: 50px auto 0;">
      <span class="highlight">Digital Blood Bank Management System</span> has been designed and developed for Blood Banks keeping in mind the current day scenario to <span class="highlight">help blood banks manage their operations more efficiently</span> and save more lives.
    </p>
  </section>

  <!-- Feature Panel Section -->
  <section class="feature-panel-section">
    <div class="container">
      <!-- Sidebar -->
      <div class="sidebar">
        <h2>Features</h2>
        <ul>
          <li class="active" onclick="showFeature('donor')"><i class="fas fa-user-injured"></i>Blood Donor</li>
          <li onclick="showFeature('request')"><i class="fas fa-warehouse"></i>Blood Request</li>
          <li onclick="showFeature('collection')"><i class="fas fa-vial"></i>Blood Collection</li>
          <li onclick="showFeature('inventroy')"><i class="fas fa-hand-holding-heart"></i>Blood inventroy</li>
          
          <li onclick="showFeature('report')"><i class="fas fa-clinic-medical"></i>Reports</li>
          <li onclick="showFeature('notification')"><i class="fas fa-chart-bar"></i>Notification</li>
        </ul>
      </div>

      <!-- Content -->
      <div class="content" id="featureContent">
        <h2>Blood Donor</h2>
        <p>
          Collect details of donors using a robust online blood bank management software that lists, searches and reaches out to donors on the go.
        </p>
        <img src="1...PNG" alt="Blood Donor Screenshot" class="feature-img">
        <div class="card-row">
          <div class="card"><div class="card-icon">🆘</div><div class="card-text">Reach for Donors in an Emergency</div></div>
          <div class="card"><div class="card-icon">⛔</div><div class="card-text">Blood Donor Deferment</div></div>
          <div class="card"><div class="card-icon">📄</div><div class="card-text">In-Built Templates</div></div>
        </div>
    </div>
      </div>
  </section>

  <!-- Side Tab -->
  <div class="side-tab">📦 Products and our service</div>
   <!-- FAQ Section -->
  <section class="faq-section">
    <h2>Frequently Asked Questions</h2>

    <div class="faq-item">
      <button class="faq-question">How can I register as a blood donor or patient?</button>
      <div class="faq-answer">
        <p>You can register as a donor or patient by clicking on the "Register" option in the navbar and filling out your personal and medical details.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-question">How is blood stock updated and managed?</button>
      <div class="faq-answer">
        <p>The admin can add, update, and delete stock entries with blood group, component type, quantity, collection date, expiry, and location.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-question">Can the system notify me when blood is about to expire?</button>
      <div class="faq-answer">
        <p>Yes, you will receive notifications before blood units expire to ensure timely usage or disposal.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-question">How are blood requests handled from patients?</button>
      <div class="faq-answer">
        <p>Patients can submit requests, and the admin reviews stock availability and either approves or denies based on urgency and stock levels.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-question">Can we track a donor’s donation history?</button>
      <div class="faq-answer">
        <p>Yes, the Donor Management module keeps a detailed log of each donor's donation dates, blood type, and eligibility for next donation.</p>
      </div>
    </div>
    </div>
  </section>
  </div>

</section>

        </div>
      </div>
      
      <div class="no-results" id="noResults">
        <i class="fas fa-search fa-2x" style="margin-bottom: 15px;"></i>
        <p>No matching questions found. Try different keywords.</p>
      </div>
    </section>
  
  
  <!-- Footer -->
  <footer class="footer">
    <div class="footer-content">
      <div class="footer-section">
        <h3>About DBBMS</h3>
        <p>Digital Blood Bank Management System is a comprehensive solution designed to modernize blood bank operations, improve efficiency, and save more lives through technology.</p>
        <div class="social-icons">
          <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
          <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
      
      <div class="footer-section">
        <h3>Quick Links</h3>
        <ul class="footer-links">
          <li><a href="#"><i class="fas fa-chevron-right"></i> Home</a></li>
          <li><a href="#"><i class="fas fa-chevron-right"></i> About Us</a></li>
          <li><a href="#"><i class="fas fa-chevron-right"></i> Features</a></li>
          <li><a href="#"><i class="fas fa-chevron-right"></i> Contact</a></li>
          <li><a href="#"><i class="fas fa-chevron-right"></i> Login</a></li>
        </ul>
      </div>
      
      <div class="footer-section">
        <h3>Contact Us</h3>
        <ul class="footer-links">
          <li><a href="#"><i class="fas fa-map-marker-alt"></i> 123 Medical Drive, Health City</a></li>
          <li><a href="#"><i class="fas fa-clock"></i> Mon-Fri: 8AM - 6PM</a></li>
        </ul>



      </div>
    </div>
    
    <div class="copyright">
      &copy; 2025 Digital Blood Bank Management System. All rights reserved.
    </div>
  </footer>

  <!-- Feature Panel Script -->
  <script>
    function showFeature(feature) {
      const items = document.querySelectorAll('.sidebar li');
      items.forEach(item => {
        item.classList.remove('active');
      });
      const selected = Array.from(items).find(i => i.textContent.replace(/\s/g, '').toLowerCase().includes(feature));
      if (selected) {
        selected.classList.add('active');
      }

      const content = document.getElementById('featureContent');
      let title = '', description = '', cards = '';

      switch (feature) {
        case 'donor':
          title = 'Blood Donor';
          description = 'Collect details of donors using a robust online blood bank management software that lists, searches and reaches out to donors on the go.';
          cards = `
            <div class="card"><div class="card-icon">🆘</div><div class="card-text">Reach for Donors in an Emergency</div></div>
            <div class="card"><div class="card-icon">⛔</div><div class="card-text">Blood Donor Deferment</div></div>
            <div class="card"><div class="card-icon">📄</div><div class="card-text">In-Built Templates</div></div>
          `;
          break;
        case 'stock':
          title = 'Blood Stock Management';
          description = 'Manage and monitor the real-time availability and expiration of all blood units.';
          cards = `
            <div class="card"><div class="card-icon">📦</div><div class="card-text">Real-Time Inventory</div></div>
            <div class="card"><div class="card-icon">🔄</div><div class="card-text">Auto Alerts</div></div>
          `;
          break;
        case 'collection':
          title = 'Blood Collection';
          description = 'Track and organize all collected units with batch records.';
          cards = `<div class="card"><div class="card-icon">🧪</div><div class="card-text">Batch & Barcode Management</div></div>`;
          break;
        case 'request':
          title = 'Blood Request Management';
          description = 'Receive and fulfill patient blood requests quickly and transparently.';
          cards = `<div class="card"><div class="card-icon">📬</div><div class="card-text">Online Request Forms</div></div>`;
          break;
        case 'lims':
          title = 'LIMS Integration';
          description = 'Connect with Laboratory Information Management Systems to automate test updates.';
          cards = `<div class="card"><div class="card-icon">🧬</div><div class="card-text">Automated Test Reports</div></div>`;
          break;
        case 'camp':
          title = 'Blood Donation Camps';
          description = 'Plan and execute outdoor donation events seamlessly.';
          cards = `
            <div class="card"><div class="card-icon">🎪</div><div class="card-text">Camp Scheduling</div></div>
            <div class="card"><div class="card-icon">🗺️</div><div class="card-text">Geo Mapping</div></div>
          `;
          break;
        case 'analytics':
          title = 'Analytics';
          description = 'Visualize blood usage, stock trends and donor activity with dashboards.';
          cards = `
            <div class="card"><div class="card-icon">📊</div><div class="card-text">Inventory Reports</div></div>
            <div class="card"><div class="card-icon">📈</div><div class="card-text">Donor Trends</div></div>
          `;
          break;
      }

      content.innerHTML = `
        <h2>${title}</h2>
        <p>${description}</p>
        <img src="https://images.unsplash.com/photo-1578500494191-8e5d8b6f2e3d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="${title} Screenshot" class="feature-img">
        <div class="card-row">${cards}</div>
      `;
    }
    
    // Text animation for hero section
   
      const heading = document.getElementById('main-heading');
      const text = heading.textContent;
      heading.textContent = '';
      
      for (let i = 0; i < text.length; i++) {
        const charSpan = document.createElement('span');
        charSpan.textContent = text[i];
        charSpan.style.animationDelay = `${i * 0.05}s`;
        heading.appendChild(charSpan);
      }
   document.addEventListener('DOMContentLoaded', function() {
      const faqItems = document.querySelectorAll('.faq-item');
      const searchInput = document.getElementById('searchInput');
      const noResults = document.getElementById('noResults');
      
      // Function to toggle FAQ items
      function toggleFAQ(item) {
        const isActive = item.classList.contains('active');
        
        // Close all items first
        faqItems.forEach(el => {
          el.classList.remove('active');
        });
        
        // Open clicked item if it wasn't active
        if (!isActive) {
          item.classList.add('active');
        }
      }
      
      // Add click event to each question
      faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        question.addEventListener('click', () => {
          toggleFAQ(item);
        });
      });
      
      // Search functionality
      searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        let hasMatches = false;
        
        faqItems.forEach(item => {
          const question = item.querySelector('.faq-question').textContent.toLowerCase();
          const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
          
          if (question.includes(searchTerm) || answer.includes(searchTerm)) {
            item.style.display = 'block';
            hasMatches = true;
          } else {
            item.style.display = 'none';
          }
        });
        
        // Show/hide no results message
        noResults.style.display = hasMatches || searchTerm === '' ? 'none' : 'block';
      });
      
      // Open first FAQ by default
      if (faqItems.length > 0) {
        faqItems[0].classList.add('active');
      }
    });
  </script>
</body>
</html>
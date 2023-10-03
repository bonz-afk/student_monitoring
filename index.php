<?php

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>

        <link rel="stylesheet" href="http://localhost/student_monitoring/common/css/common.css">
        <link rel="stylesheet" href="http://localhost/student_monitoring/common/css/landing.css">
    </head>
    <body class="landing-bg">
       <div class="top-container">
          <div class="top-logo">
              <img src="common/images/logo/lpu-logo.png" width="300px" height="200px">
          </div>
           <div class="top-right-container" style="margin-top: 10px">
               <div class="menu-toggle" onclick="toggleMenu()">
                   <div class="bar"></div>
                   <div class="bar"></div>
                   <div class="bar"></div>
               </div>
               <ul class="nav-links">
                   <li><span id="home" class="landing active" onclick="setActive('home')">Home</span></li>
                   <div class="nav-links divider"></div>
                   <li><a id="about" class="landing" href="https://lpubatangas.edu.ph/about-lpu-batangas/" target="_blank" onclick="setActive('about')">About Us</a></li>
                   <div class="nav-links divider"></div>
                   <li><a id="service" class="landing" href="https://lpubatangas.edu.ph/accounting-office/" target="_blank" onclick="setActive('services')">Service</a></li>
                   <div class="nav-links divider"></div>
                   <li><a id="contact" class="landing" href="https://lpubatangas.edu.ph/office-directory/" target="_blank" onclick="setActive('contact')">Contact</a></li>
                   <div class="nav-links divider"></div>
                   <li><a class="btn-signup" href="http://localhost/student_monitoring/signup.php">Sign Up</a></li>
               </ul>
           </div>
       </div>
       <div class="landing-page-container">
            <div class="left-container">
                <p class="title font-mont">Student Progress Monitoring System</p>
                <p class="non-title">"The secret of making progress is to get started." - Mark Twain</p>
                <a class="btn-login-sm"  href="http://localhost/student_monitoring/login.php">Log in</a>
            </div>
           <div class="right-container">
               <img src="common/images/landing-img.png" >
           </div>
       </div>
        <script src="common/js/external/jquery-3.7.1.min.js"></script>
        <script src="common/js/common.js"></script>
        <script src="common/js/toggle.js"></script>
        <script src="common/js/external/sweetalert2.min.js"></script>
    </body>
</html>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth.php';

$current_page = 'college-classes';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar with Logo</title>
    <link rel="stylesheet" href="../../common/css/common.css">
    <link rel="stylesheet" href="../../common/css/nav.css">
    <link rel="stylesheet" href="../../common/css/student/index.css">

</head>
<body>

<?php include_once $_SERVER["DOCUMENT_ROOT"]. "/student_monitoring/nav.php"?>
<div class="class-container">
    <div class="class-main">
        <div class="class-container-title">
            <div class="class-title">
                <p class="college font-mont">List of Colleges</p>
            </div>
        </div>
        <div class="list-class-container">
            <a href="#" class="class-item">
                <div class="class-item-content">
                    <p>College of Business Administration</p>
                    <img src="../../common/images/education.png" alt="College of Business Administration" style="width: 10rem;height: 10rem;margin-top: -10px;">
                </div>
            </a>
            <a href="http://localhost/student_monitoring/pages/student/class_science.php" class="class-item">
                <div class="class-item-content">
                    <p>College of Computer Studies</p>
                    <img src="../../common/images/css-logo.png" alt="College of Computer Studies" style="width: 10rem;height: 10rem;margin-top: -10px;">
                </div>
            </a>
            <a href="#" class="class-item">
                <div class="class-item-content">
                    <p>College of Engineering</p>
                    <img src="../../common/images/engineering.png" alt="College of Engineering" style="width: 10rem;height: 10rem;margin-top: 10px;">
                </div>
            </a>
        </div>
    </div>
</div>

<script src="../../common/js/external/jquery-3.7.1.min.js"></script>
<script src="../../common/js/common.js"></script>
<script src="../../common/js/nav.js"></script>
<script src="../../common/js/modal.js"></script>
<script src="../../common/js/external/sweetalert2.min.js"></script>
</body>
</html>


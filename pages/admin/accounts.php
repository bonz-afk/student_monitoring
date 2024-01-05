<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth_user.php';
$current_page = 'accounts';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="../../common/css/common.css">
        <link rel="stylesheet" href="../../common/css/nav.css">
        <link rel="stylesheet" href="../../common/css/admin/accounts.css">

    </head>
    <body>
        <?php include_once $_SERVER["DOCUMENT_ROOT"]. "/student_monitoring/nav.php"?>
        <div class="main-account">
           <div class="main-content">
               <div class="account-container-title">
                   <div class="account-title">
                       <p class="account font-mont">Type of Account</p>
                   </div>
                   <div class="account-container-item">
                       <a href="http://localhost/student_monitoring/pages/admin/student_account.php" class="account-item">
                               Student
                               <img src="../../common/images/student.png" alt="teacher" style="width: 10rem;height: 10rem">
                       </a>

                       <a  href="http://localhost/student_monitoring/pages/admin/teacher_account.php" class="account-item">
                           Teacher
                           <img src="../../common/images/teacher.png" alt="teacher" style="width: 10rem;height: 10rem">
                       </a>
                   </div>
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

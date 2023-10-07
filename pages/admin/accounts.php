<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth_user.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/course_list.php';
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

        <style>
            .main-account {
                margin-left: 400px;
                transition: margin-left 0.3s;
            }
            .main-content{
                margin: 100px auto;
            }
            .account-container-title{
                display: inline;
            }
            .account-title{
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .account.font-mont{
                font-size: 50px;
            }
            .account-container-item{
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 50px;
            }

            .account-item{
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                background: #FFFFFF;
                color: #000000;
                text-decoration: none;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                border-radius: 15px;
                padding: 10px;
                transition: width 0.3s, height 0.3s;
                cursor: pointer;
            }


            .account-item:hover img{
                width: 15rem !important;
                height: 15rem !important;
            }

            .account-item:hover{
                text-decoration: none;
                font-size: 30px;
            }
        </style>
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

                       <a class="account-item">
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

<?php
include_once  $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');
if(!empty($_SESSION['user_id'])){
    if($_SESSION['role'] == 'ADMIN'){

        header('Location: http://localhost/student_monitoring/pages/admin/college.php');
        exit();
    }
    if($_SESSION['role'] == 'TEACHER'){

        header('Location: http://localhost/student_monitoring/pages/teacher');
        exit();
    }
    if($_SESSION['role'] == 'STUDENT'){

        header('Location: http://localhost/student_monitoring/pages/student');
        exit();
    }
}
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>

        <link rel="stylesheet" href="common/css/login.css">
    </head>
    <body class="login-bg">
        <div class="container">
            <div class="login-form">
                <div class="login-logo">
                    <img src="common/images/logo/lpu-logo.png" width="300px" height="300px">
                </div>
                <div class="logo-title">
                    <p>Student Progress</p>
                    <p>Monitoring System</p>
                </div>
                <form method="post" id="loginForm">
                    <div class="form-input">
                        <input type="text" id="email" name="email" maxlength="100" placeholder="Email" >
                        <small class="email-message " hidden></small>
                        <input type="password" id="password" name="password" maxlength="18" placeholder="Password">
                        <small class="password-message " hidden></small>
                        <button type="button" class="btn-login" onclick="loginForm('loginForm')">Login</button>
                    </div>
                </form>
            </div>
            <div class="side-image">
                    <img src="common/images/login/login-side.png" width="100%" height="510px">
            </div>
        </div>
        <script src="common/js/external/jquery-3.7.1.min.js"></script>
        <script src="common/js/common.js"></script>
        <script src="common/js/external/sweetalert2.min.js"></script>
    </body>
</html>

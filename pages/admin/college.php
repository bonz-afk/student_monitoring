<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth_user.php';
$current_page = 'college';

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
        .college-container {
            margin-left: 400px;
            transition: margin-left 0.3s;
        }
        .college-container-title{
            display: flex;
            justify-content: center;
        }
        .college-title{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .college.font-mont {
            font-size: 50px;
        }
        .list-college-container{
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 50px;
        }
        .college-main{
            margin: 100px auto;
        }

        .college-item{
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

        .college-item:hover{
            text-decoration: none;
            font-size: 30px;
        }


        .college-item:hover img{
            width: 15rem !important;
            height: 15rem !important;
        }

        .college-item:hover p{
            width: 200px;
        }

        .college-item-content p{
            width: 130px;
            text-align: center;
            margin: 10px 0 0;
            letter-spacing: 1px;
        }

        .college-item-content{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
    </style>
    <script src="https://kit.fontawesome.com/0dffe12a1d.js" crossorigin="anonymous"></script>
</head>
    <body class="college-body">
    <?php include_once $_SERVER["DOCUMENT_ROOT"]. "/student_monitoring/nav.php"?>
    <div class="college-container">
        <div class="college-main">
            <div class="college-container-title">
                <div class="college-title">
                    <p class="college font-mont">List of Colleges</p>
                </div>
            </div>
            <div class="list-college-container">
                <a href="#" class="college-item">
                    <div class="college-item-content">
                        <p>College of Business Administration</p>
                        <img src="../../common/images/education.png" alt="College of Business Administration" style="width: 10rem;height: 10rem;margin-top: -10px;">
                    </div>
                </a>
                <a href="#" class="college-item">
                    <div class="college-item-content">
                        <p>College of Business Administration</p>
                        <img src="../../common/images/css-logo.png" alt="College of Computer Studies" style="width: 10rem;height: 10rem;margin-top: -10px;">
                    </div>
                </a>
                <a href="#" class="college-item">
                    <div class="college-item-content">
                        <p>College of Engineering</p>
                        <img src="../../common/images/engineering.png" alt="College of Engineering" style="width: 10rem;height: 10rem;margin-top: 10px;">
                    </div>
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

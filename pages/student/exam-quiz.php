<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth.php';
$current_page = 'assessment';
$current_dropdown = 'attendance'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Monitoring</title>
    <link rel="stylesheet" href="../../common/css/common.css">
    <link rel="stylesheet" href="../../common/css/nav.css">
    <link rel="stylesheet" href="../../common/css/modal.css">
    <style>
        .exam-container{
            transition: margin-left 0.3s;
        }

        .exam-content{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: 100%;
            margin: 0 auto;
            overflow-y: auto;
            overflow-x: hidden;
            background-color: #FFFFFF;
            border-radius: 20px;
            max-width: 1522px;
        }

        .exam-item-container{
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 50px;
            flex-wrap: wrap;
            width: 100%;
        }

        .exam-title{
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .exam-title p{
            font-size: 45px;
            font-weight: 900;
            font-family: 'Montserrat', sans-serif;
        }

        .exam.custom-select-class{
            display: block;
            position: relative;
            width: 100%;
            background-color: #e0e2e4;
            border-radius: 5px;
            cursor: pointer;
            margin: 15px 0;
            max-width: 370px;
        }

        .exam-select:focus{
            outline: 0;
        }

        .exam-select {
            appearance: none;
            width: 100%;
            height: 35px;
            margin: 10px 0;
            border-radius: 5px;
            border: 0;
            background-color: transparent;
            text-indent: 10px;
            font-size: 20px;
            color: #800000;
            padding: 0 48px 0 0;
            cursor: pointer;
        }
    </style>
    <script src="https://kit.fontawesome.com/0dffe12a1d.js" crossorigin="anonymous"></script>
</head>
    <body>
    <?php include_once $_SERVER["DOCUMENT_ROOT"]. "/student_monitoring/nav.php"?>
    <div class="exam-container">
        <div class="exam-title">
            <p>Exam & Quizzes</p>
        </div>

        <div class="exam-content">
            <div class="exam-item-container">
                <span class="exam custom-select-class">
                    <select  class="exam-select" id="update-create-section" name="update-create-section">
                        <option value="">Type</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                       </select>
                </span>
                <small class="message message-update-section"></small>
            </div>
            <button class="btn-save">Save</button>
        </div>
    </div>
    <script src="../../common/js/external/jquery-3.7.1.min.js"></script>
    <script src="../../common/js/common.js"></script>
    <script src="../../common/js/nav.js"></script>
    <script src="../../common/js/modal.js"></script>
    <script src="../../common/js/external/sweetalert2.min.js"></script>
    </body>
</html>

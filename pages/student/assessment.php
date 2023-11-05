<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth.php';

$current_page = 'assessment';
$current_dropdown = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Monitoring</title>
    <link rel="stylesheet" href="../../common/css/common.css">
    <link rel="stylesheet" href="../../common/css/nav.css">

    <style>
        .assessment-container {
            transition: margin-left 0.3s;
        }
        .assessment-container-title{
            display: flex;
            justify-content: center;
        }
        .assessment-title{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .assessment.font-mont {
            font-size: 50px;
        }
        .list-assessment-container{
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 50px;
        }
        .assessment-main{
            margin: 100px auto;
        }

        .assessment-item{
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

        .assessment-item:hover{
            text-decoration: none;
            font-size: 30px;
        }


        .assessment-item:hover img{
            width: 15rem !important;
            height: 15rem !important;
        }

        .assessment-item:hover p{
            width: 200px;
        }

        .assessment-item-content p{
            width: 130px;
            text-align: center;
            margin: 10px 0 0;
            letter-spacing: 1px;
        }

        .assessment-item-content{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
    </style>
</head>
<body>

<?php include_once $_SERVER["DOCUMENT_ROOT"]. "/student_monitoring/nav.php"?>
<div class="assessment-container">
    <div class="assessment-main">
        <div class="assessment-container-title">
            <div class="assessment-title">
                <p class="assessment font-mont">List of Assessment</p>
            </div>
        </div>
        <div class="list-assessment-container">
            <a href="http://localhost/student_monitoring/pages/student/attendance.php" class="assessment-item">
                <div class="assessment-item-content">
                    <p>Attendance</p>
                    <img src="../../common/images/attendance.png" alt="Attendance" style="width: 10rem;height: 10rem;margin-top: 10px;">
                </div>
            </a>
            <a href="http://localhost/student_monitoring/pages/teacher/class_science.php" class="assessment-item">
                <div class="assessment-item-content">
                    <p>Exam & Quizzes</p>
                    <img src="../../common/images/exam.png" alt="Exam and Quizzes" style="width: 10rem;height: 10rem;margin-top: -10px;">
                </div>
            </a>
            <a href="#" class="assessment-item">
                <div class="assessment-item-content">
                    <p>Activities & Others</p>
                    <img src="../../common/images/actothers.png" alt="Activities and Others" style="width: 10rem;height: 10rem;margin-top: -10px;">
                </div>
            </a>
        </div>
    </div>
</div>
<!--    <select>-->
<!--        <option>course</option>-->
<!--        <option>course</option>-->
<!--    </select>-->
<!--    <select>-->
<!--        <option>Class</option>-->
<!--        <option>course</option>-->
<!--    </select>-->
<!--    <p class="font-mont" id="time" style="color: #000;text-align: center">   </p>-->
<!--    <button style="">attendance</button>-->

<script src="../../common/js/external/jquery-3.7.1.min.js"></script>
<script src="../../common/js/common.js"></script>
<script src="../../common/js/nav.js"></script>
<script src="../../common/js/modal.js"></script>
<script src="../../common/js/external/sweetalert2.min.js"></script>
<script defer>
    // JavaScript code to display and update the current time in the Philippine timezone
    function displayCurrentTimeInPhilippines() {
        const timeZone = "Asia/Manila";

        function updateTime() {
            const currentTime = new Date();

            // Set the timezone offset for the Philippines (UTC+8)
            currentTime.setMinutes(currentTime.getMinutes() + currentTime.getTimezoneOffset() + 480);

            const day = new Intl.DateTimeFormat("en-US", { weekday: "long" }).format(currentTime);
            const timeString = currentTime.toLocaleTimeString('en-US');

            // Update the content of the "time" paragraph
            document.getElementById("time").textContent = `${day}, ${timeString}`;
        }

        // Call updateTime immediately and set it to update every second (1000 milliseconds)
        updateTime();
        setInterval(updateTime, 1000);
    }

    // Call the function to display and continuously update the current time when the script is executed
    displayCurrentTimeInPhilippines();
</script>
</body>
</html>


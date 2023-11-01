<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth_teacher.php';

$current_page = 'classes';
$current_dropdown = null;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Navbar with Logo</title>
        <link rel="stylesheet" href="../../common/css/common.css">
        <link rel="stylesheet" href="../../common/css/nav.css">

        <style>
            .class-container {
                transition: margin-left 0.3s;
            }
            .class-container-title{
                display: flex;
                justify-content: center;
            }
            .class-title{
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .college.font-mont {
                font-size: 50px;
            }
            .list-class-container{
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 50px;
            }
            .class-main{
                margin: 100px auto;
            }

            .class-item{
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

            .class-item:hover{
                text-decoration: none;
                font-size: 30px;
            }


            .class-item:hover img{
                width: 15rem !important;
                height: 15rem !important;
            }

            .class-item:hover p{
                width: 200px;
            }

            .class-item-content p{
                width: 130px;
                text-align: center;
                margin: 10px 0 0;
                letter-spacing: 1px;
            }

            .class-item-content{
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
            }
        </style>
        <script src="https://kit.fontawesome.com/0dffe12a1d.js" crossorigin="anonymous"></script>
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
                <a href="http://localhost/student_monitoring/pages/teacher/class_science.php" class="class-item">
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


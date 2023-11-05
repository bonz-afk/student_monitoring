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
        .attendance-container{
            transition: margin-left 0.3s;
        }

        .attendance-content{
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

        .attendance-title{
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .attendance-title p{
            font-size: 45px;
            font-weight: 900;
            font-family: 'Montserrat', sans-serif;
        }

        .attendance-item-container{
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 50px;
            flex-wrap: wrap;
            width: 100%;
        }
        .student-classes.custom-select-class{
            background-color: transparent;
            border-bottom: 1px solid #800000;
            border-radius: 0;
            max-width: 195px;
        }

        .student-classes-select:focus{
            outline: 0;
        }

        .student-classes-select {
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

        .student-class.font-mont{
            font-size: 45px;
        }

        @media only screen and (max-width: 1518px) {
            .attendance-content{
                max-width: 700px;
            }
        }


        @media only screen and (max-width: 802px) {
            .attendance-content{
                max-width: 600px !important;
            }
        }

        @media only screen and (max-width: 616px) {
            .attendance-content{
                max-width: 350px !important;
            }
        }
    </style>
    <script src="https://kit.fontawesome.com/0dffe12a1d.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include_once $_SERVER["DOCUMENT_ROOT"]. "/student_monitoring/nav.php"?>
    <div class="attendance-container">
        <div class="attendance-title">
            <p>Attendance</p>
        </div>
       <div class="attendance-content">
           <p class="student-class font-mont" id="time" style="color: #000;text-align: center">   </p>
           <div class="attendance-item-container">
            <span class="student-classes custom-select-class">
                <select  class="student-classes-select" id="student-classes-select" name="student-classes-select" >
                    <option value="">Class</option>
                    <?php foreach($studentClassList as $classAttend){ ?>
                        <option value="<?php echo $classAttend['classId'] ?>"><?php echo $classAttend['CLASS_NAME'] ?></option>
                    <?php } ?>
                </select>
            </span>
               <button class="btn-maroon" onclick="attendance()"><b>Attendance</b></button>
           </div>
       </div>
    </div>
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

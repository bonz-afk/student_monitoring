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
    <link rel="stylesheet" href="../../common/css/student/attendance.css">
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
                    <select  class="student-classes-select" id="student-classes-term" name="student-classes-term" >
                        <option value="">Term</option>
                        <option value="1">Prelims to Mid Terms</option>
                        <option value="2">Semifinals to Finals</option>
                    </select>
                </span>
               <span class="student-classes custom-select-class">
                    <select  class="student-classes-select" id="student-classes-select" name="student-classes-select" >
                        <option value="">Class</option>
                        <?php foreach($studentClassList as $classAttend){ ?>
                            <option value="<?php echo $classAttend['CLASS_CODE']  ?> | <?php echo $classAttend['TYPE']  ?>"><?php echo $classAttend['CLASS_NAME'].' '.substr($classAttend['TYPE'], 0,3); ?></option>
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

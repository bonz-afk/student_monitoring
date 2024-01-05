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
    <link rel="stylesheet" href="../../common/css/student/assessment.css">
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
            <a href="http://localhost/student_monitoring/pages/student/exam-quiz.php" class="assessment-item">
                <div class="assessment-item-content">
                    <p>Exam & Quizzes</p>
                    <img src="../../common/images/exam.png" alt="Exam and Quizzes" style="width: 10rem;height: 10rem;margin-top: -10px;">
                </div>
            </a>
            <a href="http://localhost/student_monitoring/pages/student/act_others.php" class="assessment-item">
                <div class="assessment-item-content">
                    <p>Activities & Others</p>
                    <img src="../../common/images/activites.png" alt="Activities and Others" style="width: 10rem;height: 10rem;margin-top: -10px;">
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


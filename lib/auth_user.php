<?php
if($_SESSION['role'] == 'STUDENT'){
        header('location:  http://localhost/student_monitoring/pages/student');
    exit();
}

if($_SESSION['role'] == 'TEACHER'){
        header('location:  http://localhost/student_monitoring/pages/teacher');
    exit();
}
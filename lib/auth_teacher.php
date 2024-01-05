<?php

if($_SESSION['role'] == 'STUDENT'){
    header('location:  http://localhost/student_monitoring/pages/student');
    exit();
}

if($_SESSION['role'] == 'ADMIN'){
    header('location:  http://localhost/student_monitoring/pages/admin/college.php');
    exit();
}

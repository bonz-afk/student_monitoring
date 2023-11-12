<?php

if($_SESSION['role'] == 'STUDENT' || $_SESSION['role'] == 'ADMIN'){
    header('location:  http://localhost/student_monitoring/pages/student');
    exit();
}

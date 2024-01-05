<?php

if(isset($_SESSION['user_id']) || !empty(($_SESSION['user_id']) )){
    $id = $_SESSION['user_id'];

    if($_SESSION['role'] == 'ADMIN'){
        $queryString = "";
    }else{
        $queryString = "AND TEACHER = '$id'";
    }

    $query = "SELECT *,CONCAT(UPPER(SUBSTRING(TYPE, 1, 1)), LOWER(SUBSTRING(TYPE, 2))) AS type_formatted FROM tb_class WHERE COLLEGE_ID = 2 AND TEACHER = $id AND STATUS = 'ON'";
    $result = mysqli_query($mysqli, $query);

    if (!$result) {
        die('Database query failed: ' . mysqli_error($mysqli));
    }

// Fetch and store the result data as an array
    $classScienceData = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $classScienceData[] = $row;
    }

    //lahat ng class ng student
    $queryClassStudent = "SELECT t.id as classId, t.CLASS_NAME,t.TYPE,CONCAT(UPPER(SUBSTRING(t.TYPE, 1, 1)), LOWER(SUBSTRING(t.TYPE, 2))) AS type_formatted, t.CLASS_CODE FROM `tb_class_enrolled` as e
                            left join tb_class as t
                            on t.id = e.CLASS_ID
                            where e.STUDENT = $id and t.STATUS = 'ON' AND e.STATUS = 'ON'";

    $resultClass = mysqli_query($mysqli, $queryClassStudent);

    if (!$resultClass) {
        die('Database query failed: ' . mysqli_error($mysqli));
    }

    $studentClassList = array();
    while ($row = mysqli_fetch_assoc($resultClass)) {
        $studentClassList[] = $row;
    }
}




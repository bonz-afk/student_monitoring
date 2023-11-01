<?php

if(isset($_SESSION['user_id']) || !empty(($_SESSION['user_id']) )){
    $id = $_SESSION['user_id'];

    if($_SESSION['role'] == 'ADMIN'){
        $queryString = "";
    }else{
        $queryString = "AND TEACHER = '$id'";
    }

    $query = "SELECT * FROM tb_class WHERE COLLEGE_ID = 2 AND TEACHER = $id AND STATUS = 'ON'";
    $result = mysqli_query($mysqli, $query);

    if (!$result) {
        die('Database query failed: ' . mysqli_error($mysqli));
    }

// Fetch and store the result data as an array
    $classScienceData = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $classScienceData[] = $row;
    }

}


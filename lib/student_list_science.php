<?php

if(isset($_SESSION['user_id']) || !empty(($_SESSION['user_id']) )){
    $id = $_SESSION['user_id'];

    $query = "SELECT CONCAT(
                UPPER(SUBSTRING(u.LASTNAME, 1, 1)), LOWER(SUBSTRING(u.LASTNAME, 2)),
                ' ',
                UPPER(SUBSTRING(u.FIRSTNAME, 1, 1)), LOWER(SUBSTRING(u.FIRSTNAME, 2)),
                ' ',
                UPPER(LEFT(u.MIDDLENAME, 1)),'.'
            ) as fullname, 
            e.id as enrolledid, a.CLASS_NAME,a.CLASS_CODE,a.YEAR,a.PROGRAM,a.SECTION,a.SEMESTER,a.ACADEMIC_YEAR,e.STATUS as enrollStatus, CONCAT(UPPER(SUBSTRING(a.TYPE, 1, 1)), LOWER(SUBSTRING(a.TYPE, 2))) AS type_formatted,
            a.id as enrollClass, u.id as uid
			 FROM tb_class_enrolled as e
            LEFT join tb_user as u on u.id = e.STUDENT
            LEFT join tb_class as a on a.id = e.CLASS_ID
            WHERE u.role = 'STUDENT' AND a.TEACHER = $id  AND a.COLLEGE_ID = 2 AND a.STATUS = 'ON' AND u.STATUS = 'ON' AND e.STATUS <> 'OFF'";
    $result = mysqli_query($mysqli, $query);

    if (!$result) {
        die('Database query failed: ' . mysqli_error($mysqli));
    }

// Fetch and store the result data as an array
    $studentEnrolled = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $studentEnrolled[] = $row;
    }

}




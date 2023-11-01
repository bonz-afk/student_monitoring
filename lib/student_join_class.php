<?php

if(!empty($_SESSION['user_id'])){
    $id =   $_SESSION['user_id'];


    $query = "SELECT 
            e.id as enrolledId,c.COURSE_CODE as c_code, c.COURSE_DESC,a.CLASS_NAME,a.SECTION,e.STATUS as statusEnroll FROM tb_class_enrolled as e
            LEFT join tb_user as u on u.id = e.STUDENT
            LEFT join tb_class as a on a.id = e.CLASS_ID
            LEFT join tb_course c on c.ID = e.id
            WHERE u.ID = $id AND e.STATUS <> 'OFF' AND c.STATUS = 'ON'";

    $result = mysqli_query($mysqli, $query);

    if (!$result) {
        die('Database query failed: ' . mysqli_error($mysqli));
    }

// Fetch and store the result data as an array
    $joinClass = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $joinClass[] = $row;
    }

}


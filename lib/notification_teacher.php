<?php

if(!empty($_SESSION['user_id']) && $_SESSION['role'] == 'TEACHER') {
    $id = $_SESSION['user_id'];

    $query = "SELECT COUNT(DISTINCT a.CLASS_CODE) as notifAdmitted
          FROM tb_class_enrolled AS e
          LEFT JOIN tb_class AS a ON a.id = e.CLASS_ID
          WHERE a.TEACHER = $id AND a.STATUS = 'ON' AND e.STATUS = 'PENDING'";

    $result = mysqli_query($mysqli, $query);

    if (!$result) {
        die('Database query failed: ' . mysqli_error($mysqli));
    }

    $row = mysqli_fetch_assoc($result);
    $notifTeacherCount = $row['notifAdmitted'];


    $content = "SELECT CONCAT(
                UPPER(SUBSTRING(u.LASTNAME, 1, 1)), LOWER(SUBSTRING(u.LASTNAME, 2)),
                ' ',
                UPPER(SUBSTRING(u.FIRSTNAME, 1, 1)), LOWER(SUBSTRING(u.FIRSTNAME, 2)),
                ' ',
                UPPER(LEFT(u.MIDDLENAME, 1)),'.'
            ) as fullname, 
            e.id as enrolledid, a.id as classid,u.id as studentid, a.CLASS_NAME,a.CLASS_CODE,a.YEAR,a.PROGRAM,a.SECTION,a.SEMESTER,a.ACADEMIC_YEAR,e.STATUS as enrollStatus
			 FROM tb_class_enrolled as e
            LEFT join tb_user as u on u.id = e.STUDENT
            LEFT join tb_class as a on a.id = e.CLASS_ID
            WHERE a.TEACHER = $id AND a.STATUS = 'ON' AND e.STATUS = 'PENDING'
            GROUP BY a.CLASS_NAME";

    $resultContent = mysqli_query($mysqli, $content);

    if (!$resultContent) {
        die('Database query failed: ' . mysqli_error($mysqli));
    }

    $notifContent = array();
    while ($row = mysqli_fetch_assoc($resultContent)) {
        $notifContent[] = $row;
    }

}

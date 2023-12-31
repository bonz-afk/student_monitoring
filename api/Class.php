<?php
include_once $_SERVER['DOCUMENT_ROOT']. '../student_monitoring/lib/client.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
$email = $_SESSION['email'];
$user = $_SESSION['user_id'];

$classProcess = '';
$classProcessGet = '';

if(isset($_POST['process'])){
    $classProcess = trim($_POST['process']);
}
if(isset($_GET['process'])){
    $classProcessGet = trim($_GET['process']);
}

if($classProcess == 'add'){
    $college = 2;
    $academic = trim($_POST['academic']);
    $class = trim($_POST['class']);
    $program = trim($_POST['program']);
    $semester = trim($_POST['semester']);
    $year = trim($_POST['year']);
    $course = trim($_POST['course']);
    $section = trim($_POST['section']);
    $type = trim($_POST['type']);
    $monday = trim($_POST['monday']);
    $tuesday = trim($_POST['tuesday']);
    $wednesday = trim($_POST['wednesday']);
    $thursday = trim($_POST['thursday']);
    $friday = trim($_POST['friday']);
    $saturday = trim($_POST['saturday']);
    $am = trim($_POST['am']);
    $pm = trim($_POST['pm']);
    $code  =  generateString::generateUniqueRandomString(6);
    $lec = 'LECTURE';
    $lab = 'LABORATORY';

    if(empty($type)){
        echo json_encode(['status' => false, 'message' => errorRequest::getErrorMessage(400) ]);
        exit;
    }


    if(empty($college) || empty($academic) || empty($class) || empty($program) || empty($semester) || empty($year) || empty($course) || empty($section) || empty($type)){
        echo json_encode(['status' => false, 'message' => errorRequest::getErrorMessage(400) ]);
        exit;
    }

    if (empty($monday) && empty($tuesday) && empty($wednesday) && empty($thursday) && empty($friday) && empty($saturday)) {
        echo json_encode(['status' => false, 'message' => 'Please Select At least one day' ]);
        exit();
    }

    if (empty($am) || empty($pm)) {
        echo json_encode(['status' => false, 'message' => 'The Time are required' ]);
        exit();
    } elseif (strtotime($am) >= strtotime($pm)) {
        echo json_encode(['status' => false, 'message' => 'The Time first input should be less than to the second input' ]);
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if($type == 'BOTH'){
            $sql1 = "INSERT INTO tb_class (COLLEGE_ID,ACADEMIC_YEAR,CLASS_NAME,PROGRAM,SEMESTER,YEAR,COURSE_CODE,SECTION,TYPE,
                                        MONDAY,TUESDAY,WEDNESDAY,THURSDAY,FRIDAY,SATURDAY,CLASS_CODE,AM,PM,CREATED_AT,CREATED_BY,TEACHER,STATUS) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),$user,$user,'ON')";
            $sql2 = "INSERT INTO tb_class (COLLEGE_ID,ACADEMIC_YEAR,CLASS_NAME,PROGRAM,SEMESTER,YEAR,COURSE_CODE,SECTION,TYPE,
                                        MONDAY,TUESDAY,WEDNESDAY,THURSDAY,FRIDAY,SATURDAY,CLASS_CODE,AM,PM,CREATED_AT,CREATED_BY,TEACHER,STATUS) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),$user,$user,'ON')";

// Create a prepared statement
            $stmtAdd1 = $mysqli->prepare($sql1);

            if ($stmtAdd1 === false) {
                echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error ]);
                exit;
            }

            $stmtAdd2 = $mysqli->prepare($sql2);

            if ($stmtAdd2 === false) {
                echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error ]);
                exit;
            }

// Bind parameters to the statement
            $stmtAdd1->bind_param("isssisssssssssssss", $college,$academic,$class,$program,$semester,$year,$course,$section,$lec,$monday,$tuesday,$wednesday,$thursday,$friday,$saturday,$code,$am,$pm);
            $stmtAdd2->bind_param("isssisssssssssssss", $college,$academic,$class,$program,$semester,$year,$course,$section,$lab,$monday,$tuesday,$wednesday,$thursday,$friday,$saturday,$code,$am,$pm);

// Execute the statement to insert data
            if ($stmtAdd1->execute() && $stmtAdd2->execute()) {
                $message = 'Successfully Added';
                $status = true;

            } else {
                $message = errorRequest::getErrorMessage(500);
                $status = false;
            }

            echo json_encode(['status' => $status, 'message' => $message]);

        }else{

            $sql1 = "INSERT INTO tb_class (COLLEGE_ID,ACADEMIC_YEAR,CLASS_NAME,PROGRAM,SEMESTER,YEAR,COURSE_CODE,SECTION,TYPE,
                                        MONDAY,TUESDAY,WEDNESDAY,THURSDAY,FRIDAY,SATURDAY,CLASS_CODE,AM,PM,CREATED_AT,CREATED_BY,TEACHER,STATUS) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),$user,$user,'ON')";

            $stmtAdd1 = $mysqli->prepare($sql1);

            if ($stmtAdd1 === false) {
                echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error ]);
                exit;
            }

            $stmtAdd1->bind_param("isssisssssssssssss", $college,$academic,$class,$program,$semester,$year,$course,$section,$type,$monday,$tuesday,$wednesday,$thursday,$friday,$saturday,$code,$am,$pm);

            if ($stmtAdd1->execute()) {
                $message = 'Successfully Added';
                $status = true;

            } else {
                $message = errorRequest::getErrorMessage(500);
                $status = false;
            }

            echo json_encode(['status' => $status, 'message' => $message]);
        }
        $stmtAdd1->close();
        $stmtAdd2->close();
    }else{
        $error = errorRequest::getErrorMessage(405); // Get the error message for 405 (Method Not Allowed)
        http_response_code(405); // Set the HTTP response code
        echo json_encode(['status' => false,'error' => $error]);
        exit;
    }
}

if($classProcess == 'delete'){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $classId = trim($_POST['id']);
        $classStatus = 'OFF';

        $sql = "UPDATE tb_class SET STATUS = ? WHERE ID = ?";

        // Create a prepared statement
        $stmtDel = $mysqli->prepare($sql);

        if ($stmtDel === false) {
            echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
            exit;
        }

        // Bind parameters to the statement
        $stmtDel->bind_param("si", $classStatus, $classId);

        // Execute the statement
        if ($stmtDel->execute()) {
            $message = 'Successfully Deleted'; // Update message text
            $status = true;
        } else {
            $message = 'Error deleting class'; // Update message text
            $status = false;
        }

        echo json_encode(['status' => $status, 'message' => $message]);
    } else {
        $error = errorRequest::getErrorMessage(405); // Get the error message for 405 (Method Not Allowed)
        http_response_code(405); // Set the HTTP response code
        echo json_encode(['status' => false, 'error' => $error]);
        exit;
    }

    $stmtDel->close();
}

if($classProcess == 'delete-enrolled'){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $enrolledId = trim($_POST['id']);
        $classCode = trim($_POST['classCode']);
        $enrolledStatus = 'OFF';

        $sql = "UPDATE tb_class_enrolled SET STATUS = ? WHERE CLASS_ID IN (SELECT id FROM tb_class where CLASS_CODE = '$classCode')";

        // Create a prepared statement
        $stmtDel = $mysqli->prepare($sql);

        if ($stmtDel === false) {
            echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
            exit;
        }

        // Bind parameters to the statement
        $stmtDel->bind_param("s", $enrolledStatus);

        // Execute the statement
        if ($stmtDel->execute()) {
            $message = 'Successfully Deleted'; // Update message text
            $status = true;
        } else {
            $message = 'Error deleting class'; // Update message text
            $status = false;
        }

        echo json_encode(['status' => $status, 'message' => $message]);
    } else {
        $error = errorRequest::getErrorMessage(405); // Get the error message for 405 (Method Not Allowed)
        http_response_code(405); // Set the HTTP response code
        echo json_encode(['status' => false, 'error' => $error]);
        exit;
    }

    $stmtDel->close();
}

if($classProcessGet == 'view') {
    $classId = trim($_GET['id']);

    $sql = "SELECT * FROM tb_class WHERE id = ? AND STATUS = 'ON'";

// Create a prepared statement
    $stmtView = $mysqli->prepare($sql);

    if (!$stmtView) {
        die('Database query failed: ' . mysqli_error($mysqli));
    }

    $stmtView->bind_param("i", $classId);
    $stmtView->execute();

// Check for errors
    if ($stmtView->errno) {
        die('SQL Error: ' . $stmt->error);
    }

// Fetch and store the result data as an array
    $result = $stmtView->get_result();
    $classList = array();

    while ($row = $result->fetch_assoc()) {
        $classList[] = $row;
    }

// Check if any data was found
    if (empty($classList)) {
        // No data found, return a message
        $response = array("message" => "No data available.");
    } else {
        // Send the data as JSON response
        header('Content-Type: application/json');
        echo json_encode($classList);
    }

    $stmtView->close();
}

if($classProcess == 'edit'){
    $id = trim($_POST['id']);
    $academic = trim($_POST['academic']);
    $class = trim($_POST['class']);
    $program = trim($_POST['program']);
    $semester = trim($_POST['semester']);
    $year = trim($_POST['year']);
    $course = trim($_POST['course']);
    $section = trim($_POST['section']);
    $attendance = trim($_POST['attendance']);
    $quiz = trim($_POST['quiz']);
    $actexp = trim($_POST['actexp']);
    $others = trim($_POST['others']);
    $monday = trim($_POST['monday']);
    $tuesday = trim($_POST['tuesday']);
    $wednesday = trim($_POST['wednesday']);
    $thursday = trim($_POST['thursday']);
    $friday = trim($_POST['friday']);
    $saturday = trim($_POST['saturday']);
    $am = trim($_POST['am']);
    $pm = trim($_POST['pm']);
    $code  =  generateString::generateUniqueRandomString(6);
//
//    if(empty($type)){
//        echo json_encode(['status' => false, 'message' => errorRequest::getErrorMessage(400) ]);
//        exit;
//    }


    if(empty($academic) || empty($class) || empty($program) || empty($semester) || empty($year) || empty($course) || empty($section)){
        echo json_encode(['status' => false, 'message' => errorRequest::getErrorMessage(400) ]);
        exit;
    }

    if (empty($monday) && empty($tuesday) && empty($wednesday) && empty($thursday) && empty($friday) && empty($saturday)) {
        echo json_encode(['status' => false, 'message' => 'Please Select At least one day' ]);
        exit();
    }

    if (empty($am) || empty($pm)) {
        echo json_encode(['status' => false, 'message' => 'The Time are required' ]);
        exit();
    } elseif (strtotime($am) >= strtotime($pm)) {
        echo json_encode(['status' => false, 'message' => 'The Time first input should be less than to the second input' ]);
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $sql = "UPDATE tb_class SET ACADEMIC_YEAR = ?,CLASS_NAME = ?,PROGRAM = ?,SEMESTER = ?,YEAR = ?,COURSE_CODE = ?,SECTION = ?,
                MONDAY = ?,TUESDAY = ?,WEDNESDAY = ?,THURSDAY = ?,FRIDAY = ?,SATURDAY = ?,CLASS_CODE = ?,AM = ?,PM = ?,CREATED_AT = NOW(),CREATED_BY = $user, TEACHER = $user, ATTENDANCE = ?, QUIZ = ?, ACTEXP = ? , OTHERS = ? WHERE id = $id";

// Create a prepared statement
        $stmtEdit = $mysqli->prepare($sql);

        if ($stmtEdit === false) {
            echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error ]);
            exit;
        }

// Bind parameters to the statement
        $stmtEdit->bind_param("sssissssssssssssssss", $academic,$class,$program,$semester,$year,$course,$section,$monday,$tuesday,$wednesday,$thursday,$friday,$saturday,$code,$am,$pm,$attendance,$quiz,$actexp,$others);

// Execute the statement to insert data
        if ($stmtEdit->execute()) {
            $message = 'Successfully Updated';
            $status = true;

        } else {
            $message = errorRequest::getErrorMessage(500);
            $status = false;
        }

        echo json_encode(['status' => $status, 'message' => $message]);

    }else{
        $error = errorRequest::getErrorMessage(405); // Get the error message for 405 (Method Not Allowed)
        http_response_code(405); // Set the HTTP response code
        echo json_encode(['status' => false,'error' => $error]);
        exit;
    }
    $stmtEdit->close();
}

if($classProcessGet == 'student-class-science'){
    if(!empty($_GET['id'])){
        $classId = trim($_GET['id']);
    }

    $sql = "SELECT CONCAT(
                UPPER(SUBSTRING(u.LASTNAME, 1, 1)), LOWER(SUBSTRING(u.LASTNAME, 2)),
                ' ',
                UPPER(SUBSTRING(u.FIRSTNAME, 1, 1)), LOWER(SUBSTRING(u.FIRSTNAME, 2)),
                ' ',
                UPPER(LEFT(u.MIDDLENAME, 1)),'.'
            ) as fullname, 
            e.id as enrolledid, a.CLASS_NAME,a.CLASS_CODE,a.YEAR,a.PROGRAM,a.SECTION,a.SEMESTER,a.ACADEMIC_YEAR,e.STATUS as enrollStatus, a.CLASS_CODE
			 FROM tb_class_enrolled as e
            LEFT join tb_user as u on u.id = e.STUDENT
            LEFT join tb_class as a on a.id = e.CLASS_ID
            WHERE u.role = 'STUDENT' AND a.id = ? AND a.COLLEGE_ID = 2 AND a.STATUS = 'ON' AND u.STATUS = 'ON' AND e.STATUS <> 'OFF'";

// Create a prepared statement
    $stmtScience = $mysqli->prepare($sql);

    if (!$stmtScience) {
        die('Database query failed: ' . mysqli_error($mysqli));
    }

    $stmtScience->bind_param("i", $classId);
    $stmtScience->execute();

// Check for errors
    if ($stmtScience->errno) {
        die('SQL Error: ' . $stmtScience->error);
    }

// Fetch and store the result data as an array
    $result = $stmtScience->get_result();
    $classList = array();

    while ($row = $result->fetch_assoc()) {
        $classList[] = $row;
    }

// Check if any data was found
    if (empty($classList)) {
        $sql = "SELECT CLASS_NAME, CLASS_CODE as first_code, YEAR,PROGRAM, SECTION, SEMESTER, ACADEMIC_YEAR
                FROM tb_class
                WHERE id = ?";


// Create a prepared statement
        $stmtCode = $mysqli->prepare($sql);

        if (!$stmtCode) {
            die('Database query failed: ' . mysqli_error($mysqli));
        }

        $stmtCode->bind_param("i", $classId);
        $stmtCode->execute();

// Check for errors
        if ($stmtScience->errno) {
            die('SQL Error: ' . $stmtCode->error);
        }

// Fetch and store the result data as an array
        $resultCode = $stmtCode->get_result();

        $classCode = array();

        while ($row = $resultCode->fetch_assoc()) {
            $classCode[] = $row;
        }
        if(empty($classCode)){
            echo json_encode("No data found");
        }else{
            header('Content-Type: application/json');
            echo json_encode($classCode);
        }
    } else {
        // Send the data as JSON response
        header('Content-Type: application/json');
        echo json_encode($classList);
    }

    $stmtScience->close();
}

if($classProcess == 'class_change'){
    if (!empty($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $academic = $_POST['academic'];

        if (empty($academic)) {
            $queryString = "";
        } else {
            $queryString = "AND ACADEMIC_YEAR = '$academic'";
        }

        $sql = "SELECT *,CONCAT(UPPER(SUBSTRING(TYPE, 1, 1)), LOWER(SUBSTRING(TYPE, 2))) AS type_formatted FROM tb_class WHERE TEACHER = ? AND STATUS = 'ON' $queryString";

        // Create a prepared statement
        $stmt = $mysqli->prepare($sql);

        if (!$stmt) {
            die('Database query failed: ' . mysqli_error($mysqli));
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $teacherClass = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $teacherClass[] = $row;
        }
        // Check if any data was found
        if (empty($teacherClass)) {
            // No data found, return a message
            $response = array("message" => "No data available.");
        } else {
            // Send the data as JSON response
            header('Content-Type: application/json');
            echo json_encode($teacherClass);
        }
    }
}

if($classProcess == 'admit'){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = trim($_POST['enrollid']);
        $classCode = trim($_POST['classCode']);
        $accept = 'ON';

        $checkCode = "SELECT id from tb_class where CLASS_CODE = '$classCode'";

        $resultCode = mysqli_query($mysqli, $checkCode);
        $checkCodeCount = mysqli_num_rows($resultCode);

        if ($checkCodeCount) {
            $ids = [];

            while ($row = mysqli_fetch_assoc($resultCode)) {
                $ids[] = $row['id'];
            }
            $sqlUpdate = "UPDATE tb_class_enrolled SET STATUS = ?, ADMITTED_BY = ?, ADMITTED_DATE = NOW() WHERE CLASS_ID = ?";

            foreach ($ids as $listId) {
                $stmtUpdate = $mysqli->prepare($sqlUpdate);

                if ($stmtUpdate === false) {
                    echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
                    exit;
                }

                $stmtUpdate->bind_param("sii", $accept, $user,$listId);

                if ($stmtUpdate->execute()) {
                    $message = 'Successfully Admitted'; // Update message text
                    $status = true;
                }
                else {
                    $message = 'Error Admitted in class'; // Update message text
                    $status = false;
                }
            }

            // Close the statement
            $stmtUpdate->close();

            echo json_encode(['status' => $status, 'message' => $message]);
        }else{
            echo json_encode(['status' => false, 'message' => 'Something went wrong' . $mysqli->error]);
            exit;
        }
    }else{
        $error = errorRequest::getErrorMessage(405); // Get the error message for 405 (Method Not Allowed)
        http_response_code(405); // Set the HTTP response code
        echo json_encode(['status' => false,'error' => $error]);
        exit;
    }
}

if($classProcessGet == 'filter-class-year'){
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $id = $_SESSION['user_id']; // Assuming you have a user session

        $selectedYear = isset($_GET['year']) ? $_GET['year'] : '';

        $queryClassStudent = "SELECT t.id as classId, t.CLASS_NAME, t.TYPE, t.CLASS_CODE FROM `tb_class_enrolled` as e
                      LEFT JOIN tb_class as t ON t.id = e.CLASS_ID
                      WHERE e.STUDENT = $id AND t.STATUS = 'ON' AND e.STATUS = 'ON'
                      AND t.ACADEMIC_YEAR = '$selectedYear'
                      GROUP BY t.CLASS_CODE";

        $resultClass = mysqli_query($mysqli, $queryClassStudent);

        if (!$resultClass) {
            die('Database query failed: ' . mysqli_error($mysqli));
        }

        $studentClassList = array();
        while ($row = mysqli_fetch_assoc($resultClass)) {
            $studentClassList[] = $row;
        }

// Output the filtered class list as JSON
        header('Content-Type: application/json');
        echo json_encode($studentClassList);
    }else{
        $error = errorRequest::getErrorMessage(405); // Get the error message for 405 (Method Not Allowed)
        http_response_code(405); // Set the HTTP response code
        echo json_encode(['status' => false,'error' => $error]);
        exit;
    }
}

$mysqli->close();


<?php
include_once $_SERVER['DOCUMENT_ROOT']. '../student_monitoring/lib/client.php';

if(isset($_POST['process'])){
   $process = $_POST['process'];
}

if(isset($_GET['process'])){
   $process = $_GET['process'];
}

if($process == 'search_filter'){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_SESSION['user_id'])) {
            $id = $_SESSION['user_id'];
            $academic = $_POST['academic'];
            $search = $_POST['search'];
            $searchPattern = "%$search%";

            $resultFilter = '';

            if(!empty($academic) && !empty($search)){
                $resultFilter = "AND a.ACADEMIC_YEAR =  '$academic' AND  (u.LASTNAME LIKE '%$search%' OR u.FIRSTNAME LIKE '%$search%' OR a.CLASS_NAME LIKE '%$search%')";
            }

            if(!empty($academic) && empty($search)){
                $resultFilter = "AND a.ACADEMIC_YEAR =  '$academic'";
            }

            if(empty($academic) && !empty($search)){
                $resultFilter = "AND (u.LASTNAME LIKE '%$search%' OR u.FIRSTNAME LIKE '%$search%' OR a.CLASS_NAME LIKE '%$search%')";
            }

            $queryString = $resultFilter;

            $sql = "SELECT CONCAT(
                UPPER(SUBSTRING(u.LASTNAME, 1, 1)), LOWER(SUBSTRING(u.LASTNAME, 2)),
                ' ',
                UPPER(SUBSTRING(u.FIRSTNAME, 1, 1)), LOWER(SUBSTRING(u.FIRSTNAME, 2)),
                ' ',
                UPPER(LEFT(u.MIDDLENAME, 1)),'.'
            ) as fullname, a.CLASS_CODE,
            e.id as enrolledId,c.COURSE_CODE as c_code, c.COURSE_DESC,a.CLASS_NAME,a.SECTION,e.STATUS as statusEnroll, a.id as enrollClass, u.id as uid, 
            CONCAT(UPPER(SUBSTRING(a.TYPE, 1, 1)), LOWER(SUBSTRING(a.TYPE, 2))) AS type_formatted,a.TYPE
            FROM tb_class_enrolled as e
            LEFT join tb_user as u on u.id = e.STUDENT
            LEFT join tb_class as a on a.id = e.CLASS_ID
            LEFT join tb_course c on c.ID = e.id
            WHERE e.STATUS = 'ON'  AND c.STATUS = 'ON'  $queryString";


            $result = mysqli_query($mysqli, $sql);


            if (!$result) {
                die('Database query failed: ' . mysqli_error($mysqli));
            }

            $studentEnrolledQuery = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $studentEnrolledQuery[] = $row;
            }
            // Check if any data was found
            if (empty($studentEnrolledQuery)) {
                // No data found, return a message
                $response = array("message" => "No data available.");
            } else {
                // Send the data as JSON response
                header('Content-Type: application/json');
                echo json_encode($studentEnrolledQuery);
            }
        }
    }
}

if($process == 'attendance'){
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $classId = $_GET['classId'];
        $studentId = $_GET['studentId'];
        $type = $_GET['type'];
        $idmoto = $_GET['id'];

        $sql = "SELECT CONCAT(
                UPPER(SUBSTRING(u.LASTNAME, 1, 1)), LOWER(SUBSTRING(u.LASTNAME, 2)),
                ' ',
                UPPER(SUBSTRING(u.FIRSTNAME, 1, 1)), LOWER(SUBSTRING(u.FIRSTNAME, 2)),
                ' ',
                UPPER(LEFT(u.MIDDLENAME, 1)),'.'
            ) as fullname, CONCAT(UPPER(SUBSTRING(c.TYPE, 1, 1)), LOWER(SUBSTRING(c.TYPE, 2))) AS type_formatted,
            a.id as attId, DATE(a.TIME_IN) as date_only, a.STATUS, c.CLASS_NAME FROM tb_attendance as a
            LEFT join tb_user as u on u.id = a.STUDENT_ID
            LEFT join tb_class as c on a.CLASS_CODE = c.CLASS_CODE
            WHERE a.CLASS_CODE = ? AND a.STUDENT_ID = ? AND a.TYPE = '$type' AND c.TYPE = '$type'";

// Create a prepared statement
        $stmtAtt = $mysqli->prepare($sql);

        if (!$stmtAtt) {
            die('Database query failed: ' . mysqli_error($mysqli));
        }

        $stmtAtt->bind_param("si", $classId, $studentId);
        $stmtAtt->execute();

// Check for errors
        if ($stmtAtt->errno) {
            die('SQL Error: ' . $stmtAtt->error);
        }

// Fetch and store the result data as an array
        $result = $stmtAtt->get_result();
        $attView = array();

        while ($row = $result->fetch_assoc()) {
            $attView[] = $row;
        }

// Check if any data was found
        if (empty($attView)) {
            $query = "SELECT CONCAT(
                UPPER(SUBSTRING(u.LASTNAME, 1, 1)), LOWER(SUBSTRING(u.LASTNAME, 2)),
                ' ',
                UPPER(SUBSTRING(u.FIRSTNAME, 1, 1)), LOWER(SUBSTRING(u.FIRSTNAME, 2)),
                ' ',
                UPPER(LEFT(u.MIDDLENAME, 1)),'.'
            ) as fullname, CONCAT(UPPER(SUBSTRING(c.TYPE, 1, 1)), LOWER(SUBSTRING(c.TYPE, 2))) AS type_formatted,
            a.id as attId, c.CLASS_NAME  FROM tb_class_enrolled as a
            LEFT join tb_user as u on u.id = a.STUDENT
            LEFT join tb_class as c on a.id = c.id
            WHERE c.id = $idmoto AND a.STUDENT = $studentId";

            $result = mysqli_query($mysqli, $query);

            if (!$result) {
                die('Database query failed: ' . mysqli_error($mysqli));
            }

// Fetch and store the result data as an array
            $getNameClass = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $getNameClass[] = $row;
            }

            if (empty($getNameClass) || count($getNameClass) < 0) {
                $response = array("message" => "No data available.");
            }else{
                header('Content-Type: application/json');
                echo json_encode($getNameClass);
            }
        } else {
            // Send the data as JSON response
            header('Content-Type: application/json');
            echo json_encode($attView);
        }
    }else {
        $error = errorRequest::getErrorMessage(405); // Get the error message for 405 (Method Not Allowed)
        http_response_code(405); // Set the HTTP response code
        echo json_encode(['status' => false, 'error' => $error]);
        exit;
    }
}

if($process == 'score'){
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $id = $_GET['id'];
        $classId = $_GET['classId'];
        $studentId = $_GET['studentId'];
        $type = $_GET['type'];

        $sql = "SELECT CONCAT(
                UPPER(SUBSTRING(u.LASTNAME, 1, 1)), LOWER(SUBSTRING(u.LASTNAME, 2)),
                ' ',
                UPPER(SUBSTRING(u.FIRSTNAME, 1, 1)), LOWER(SUBSTRING(u.FIRSTNAME, 2)),
                ' ',
                UPPER(LEFT(u.MIDDLENAME, 1)),'.'
            ) as fullname, CONCAT(UPPER(SUBSTRING(c.TYPE, 1, 1)), LOWER(SUBSTRING(c.TYPE, 2))) AS type_formatted,
            a.id as scoreId, DATE(a.EXAM_DATE) as date_only, c.CLASS_NAME, a.TERM, a.TYPE, a.SCORE FROM tb_score as a
            LEFT join tb_user as u on u.id = a.STUDENT_ID
            LEFT join tb_class as c on a.CLASS_CODE = c.CLASS_CODE
            WHERE a.CLASS_CODE = ? AND a.STUDENT_ID = ? AND c.TYPE ='$type' AND a.CLASS_TYPE = '$type' AND (a.TYPE = 'PE' OR a.TYPE = 'ME' OR a.TYPE = 'SE' OR a.TYPE = 'FE' OR a.TYPE = 'QUIZ')";

// Create a prepared statement
        $stmtScore = $mysqli->prepare($sql);

        if (!$stmtScore) {
            die('Database query failed: ' . mysqli_error($mysqli));
        }

        $stmtScore->bind_param("si", $classId, $studentId);
        $stmtScore->execute();

// Check for errors
        if ($stmtScore->errno) {
            die('SQL Error: ' . $stmtScore->error);
        }

// Fetch and store the result data as an array
        $result = $stmtScore->get_result();
        $scoreView = array();

        while ($row = $result->fetch_assoc()) {
            $scoreView[] = $row;
        }

// Check if any data was found
        if (empty($scoreView)) {
            $query = "SELECT CONCAT(
                UPPER(SUBSTRING(u.LASTNAME, 1, 1)), LOWER(SUBSTRING(u.LASTNAME, 2)),
                ' ',
                UPPER(SUBSTRING(u.FIRSTNAME, 1, 1)), LOWER(SUBSTRING(u.FIRSTNAME, 2)),
                ' ',
                UPPER(LEFT(u.MIDDLENAME, 1)),'.'
            ) as fullname, CONCAT(UPPER(SUBSTRING(c.TYPE, 1, 1)), LOWER(SUBSTRING(c.TYPE, 2))) AS type_formatted,
            a.id as attId, c.CLASS_NAME  FROM tb_class_enrolled as a
            LEFT join tb_user as u on u.id = a.STUDENT
            LEFT join tb_class as c on a.CLASS_ID = c.id
            WHERE a.CLASS_ID = $id AND a.STUDENT = $studentId";

            $result = mysqli_query($mysqli, $query);

            if (!$result) {
                die('Database query failed: ' . mysqli_error($mysqli));
            }

// Fetch and store the result data as an array
            $getNameClass = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $getNameClass[] = $row;
            }

            if (empty($getNameClass) || count($getNameClass) < 0) {
                $response = array("message" => "No data available.");
            }else{
                header('Content-Type: application/json');
                echo json_encode($getNameClass);
            }
        } else {
            // Send the data as JSON response
            header('Content-Type: application/json');
            echo json_encode($scoreView);
        }
    }else {
        $error = errorRequest::getErrorMessage(405); // Get the error message for 405 (Method Not Allowed)
        http_response_code(405); // Set the HTTP response code
        echo json_encode(['status' => false, 'error' => $error]);
        exit;
    }
}

if($process == 'others'){
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $id = $_GET['id'];
        $classId = $_GET['classId'];
        $studentId = $_GET['studentId'];
        $type = $_GET['type'];

        $sql = "SELECT CONCAT(
                UPPER(SUBSTRING(u.LASTNAME, 1, 1)), LOWER(SUBSTRING(u.LASTNAME, 2)),
                ' ',
                UPPER(SUBSTRING(u.FIRSTNAME, 1, 1)), LOWER(SUBSTRING(u.FIRSTNAME, 2)),
                ' ',
                UPPER(LEFT(u.MIDDLENAME, 1)),'.'
            ) as fullname, CONCAT(UPPER(SUBSTRING(c.TYPE, 1, 1)), LOWER(SUBSTRING(c.TYPE, 2))) AS type_formatted,
            a.id as scoreId, DATE(a.EXAM_DATE) as date_only, c.CLASS_NAME, a.TERM,CONCAT(UPPER(SUBSTRING(a.TYPE, 1, 1)), LOWER(SUBSTRING(a.TYPE, 2))) AS type_others, a.SCORE FROM tb_score as a
            LEFT join tb_user as u on u.id = a.STUDENT_ID
            LEFT join tb_class as c on a.CLASS_CODE = c.CLASS_CODE
            WHERE a.CLASS_CODE = ? AND a.STUDENT_ID = ? AND c.TYPE = '$type' AND  a.CLASS_TYPE = '$type' AND (a.TYPE = 'ACTIVITY' OR a.TYPE = 'EXPERIMENT' OR a.TYPE = 'OTHERS')";

// Create a prepared statement
        $stmtScore = $mysqli->prepare($sql);

        if (!$stmtScore) {
            die('Database query failed: ' . mysqli_error($mysqli));
        }

        $stmtScore->bind_param("si", $classId, $studentId);
        $stmtScore->execute();

// Check for errors
        if ($stmtScore->errno) {
            die('SQL Error: ' . $stmtScore->error);
        }

// Fetch and store the result data as an array
        $result = $stmtScore->get_result();
        $scoreView = array();

        while ($row = $result->fetch_assoc()) {
            $scoreView[] = $row;
        }


// Check if any data was found
        if (empty($scoreView)) {

            $query = "SELECT CONCAT(
                UPPER(SUBSTRING(u.LASTNAME, 1, 1)), LOWER(SUBSTRING(u.LASTNAME, 2)),
                ' ',
                UPPER(SUBSTRING(u.FIRSTNAME, 1, 1)), LOWER(SUBSTRING(u.FIRSTNAME, 2)),
                ' ',
                UPPER(LEFT(u.MIDDLENAME, 1)),'.'
            ) as fullname, CONCAT(UPPER(SUBSTRING(c.TYPE, 1, 1)), LOWER(SUBSTRING(c.TYPE, 2))) AS type_formatted,
            a.id as attId, c.CLASS_NAME  FROM tb_class_enrolled as a
            LEFT join tb_user as u on u.id = a.STUDENT
            LEFT join tb_class as c on a.CLASS_ID = c.id
            WHERE a.CLASS_ID = $id AND a.STUDENT = $studentId";

            $result = mysqli_query($mysqli, $query);

            if (!$result) {
                die('Database query failed: ' . mysqli_error($mysqli));
            }

// Fetch and store the result data as an array
            $getNameClass = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $getNameClass[] = $row;
            }

            if (empty($getNameClass) || count($getNameClass) < 0) {
                $response = array("message" => "No data available.");
            }else{
                header('Content-Type: application/json');
                echo json_encode($getNameClass);
            }
        } else {
            // Send the data as JSON response
            header('Content-Type: application/json');
            echo json_encode($scoreView);
        }
    }else {
        $error = errorRequest::getErrorMessage(405); // Get the error message for 405 (Method Not Allowed)
        http_response_code(405); // Set the HTTP response code
        echo json_encode(['status' => false, 'error' => $error]);
        exit;
    }
}

if($process == 'update-attendance'){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_SESSION['user_id'];
        $attId = trim($_POST['attendance']);
        $status = trim($_POST['status']);

        $sql = "UPDATE tb_attendance SET STATUS = ?, MODIFIED_AT = NOW(), MODIFIED_BY = $id WHERE id = $attId";

// Create a prepared statement
        $stmtEdit = $mysqli->prepare($sql);

        if ($stmtEdit === false) {
            echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error ]);
            exit;
        }

// Bind parameters to the statement
        $stmtEdit->bind_param("s", $status);

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


if($process == 'update-score'){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_SESSION['user_id'];
        $scoreId = trim($_POST['scoreId']);
        $score = trim($_POST['score']);

        if(strlen($score) > 5){
            echo json_encode(['status' => false, 'message' => 'Invalid Score (Limit 5)' ]);
            exit;
        }

        $sql = "UPDATE tb_score SET SCORE = ?, MODIFIED_AT = NOW(), MODIFIED_BY = $id WHERE id = $scoreId";

// Create a prepared statement
        $stmtEdit = $mysqli->prepare($sql);

        if ($stmtEdit === false) {
            echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error ]);
            exit;
        }

// Bind parameters to the statement
        $stmtEdit->bind_param("i", $score);

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

if($process == 'update-score_others'){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_SESSION['user_id'];
        $scoreId = trim($_POST['scoreId']);
        $score = trim($_POST['score']);

        if(strlen($score) > 5){
            echo json_encode(['status' => false, 'message' => 'Invalid Score (Limit 5)' ]);
            exit;
        }

        $sql = "UPDATE tb_score SET SCORE = ?, MODIFIED_AT = NOW(), MODIFIED_BY = $id WHERE id = $scoreId";

// Create a prepared statement
        $stmtEdit = $mysqli->prepare($sql);

        if ($stmtEdit === false) {
            echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error ]);
            exit;
        }

// Bind parameters to the statement
        $stmtEdit->bind_param("i", $score);

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


$mysqli->close();
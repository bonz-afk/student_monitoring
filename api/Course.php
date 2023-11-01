<?php
include_once $_SERVER['DOCUMENT_ROOT']. '../student_monitoring/lib/client.php';

$courseProcess = trim($_POST['process']);
$email = $_SESSION['email'];
$user = $_SESSION['user_id'];



if(isset($_POST['course_id'])){
    $courseID = trim($_POST['course_id']);
}
if(isset($_POST['course_desc']) && isset($_POST['course_code'])){
    $courseCode = trim($_POST['course_code']);
    $courseDesc = trim($_POST['course_desc']);
}





if($courseProcess == 'add'){
    if(empty($courseCode) || empty(($courseDesc))){
        echo json_encode(['status' => false, 'message' => errorRequest::getErrorMessage(400) ]);
        exit;
    }

    if(strlen($courseCode) > 255 || strlen($courseDesc) > 255){
        echo json_encode(['status' => false, 'message' => 'Maximum of 255 input only' ]);
        exit;
    }

    if(isset($_POST['course_id'])){
        $collegeID = trim($_POST['college_id']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sql = "INSERT INTO tb_course (COURSE_CODE, COURSE_DESC, STATUS,COLLEGE_ID, CREATED_AT, CREATED_BY) VALUES (?, ?, 'ON', ?, NOW(), ?)";

// Create a prepared statement
        $stmtAdd = $mysqli->prepare($sql);

        if ($stmtAdd === false) {
            echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error ]);
            exit;
        }

// Bind parameters to the statement
        $stmtAdd->bind_param("ssis", $courseCode, $courseDesc, $collegeID, $user);

// Execute the statement to insert data
        if ($stmtAdd->execute()) {
            $message = 'Successfully Added';
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
    $stmtAdd->close();
}
elseif ($courseProcess == 'edit'){
    if(empty($courseCode) || empty(($courseDesc))){
        echo json_encode(['status' => false, 'message' => errorRequest::getErrorMessage(400) ]);
        exit;
    }

    if(strlen($courseCode) > 255 || strlen($courseDesc) > 255){
        echo json_encode(['status' => false, 'message' => 'Maximum of 255 input only' ]);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $sql = "UPDATE tb_course SET COURSE_CODE = ?, COURSE_DESC = ?, MODIFIED_AT = NOW(), MODIFIED_BY = $user WHERE ID = ?";

        // Create a prepared statement
        $stmtEdit = $mysqli->prepare($sql);

        if ($stmtEdit === false) {
            echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
            exit;
        }

        // Bind parameters to the statement
        $stmtEdit->bind_param("ssi", $courseCode, $courseDesc, $courseID);

        // Execute the statement
        if ($stmtEdit->execute()) {
            $message = 'Successfully Updated'; // Update message text
            $status = true;
        } else {
            $message = 'Error updating the course'; // Update message text
            $status = false;
        }

        echo json_encode(['status' => $status, 'message' => $message]);
    } else {
        $error = errorRequest::getErrorMessage(405); // Get the error message for 405 (Method Not Allowed)
        http_response_code(405); // Set the HTTP response code
        echo json_encode(['status' => false, 'error' => $error]);
        exit;
    }

    $stmtEdit->close();
}
elseif($courseProcess == 'delete'){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $courseStatus = 'OFF';

        $sql = "UPDATE tb_course SET STATUS = ? WHERE ID = ?";

        // Create a prepared statement
        $stmtDel = $mysqli->prepare($sql);

        if ($stmtDel === false) {
            echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
            exit;
        }

        // Bind parameters to the statement
        $stmtDel->bind_param("si", $courseStatus, $courseID);

        // Execute the statement
        if ($stmtDel->execute()) {
            $message = 'Successfully Deleted'; // Update message text
            $status = true;
        } else {
            $message = 'Error deleting course'; // Update message text
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

$mysqli->close();


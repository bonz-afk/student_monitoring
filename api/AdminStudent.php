<?php
include_once $_SERVER['DOCUMENT_ROOT']. '../student_monitoring/lib/client.php';

$process = isset($_POST['process']) ? trim($_POST['process']) : null;
$id = isset($_POST['id']) ? trim($_POST['id']) : null;

$processGet = isset($_GET['process']) ? trim($_GET['process']) : null;
$idGet = isset($_GET['id']) ? trim($_GET['id']) : null;

if($process == 'delete'){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sql = "UPDATE tb_user SET STATUS = 'OFF' WHERE ID = ?";

        // Create a prepared statement
        $stmtDel = $mysqli->prepare($sql);

        if ($stmtDel === false) {
            echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
            exit;
        }

        // Bind parameters to the statement
        $stmtDel->bind_param("i", $id);

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
    $mysqli->close();
}

if($processGet == 'view'){
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $sql = "SELECT CONCAT(
                UPPER(SUBSTRING(u.LASTNAME, 1, 1)), LOWER(SUBSTRING(u.LASTNAME, 2)),
                ' ',
                UPPER(SUBSTRING(u.FIRSTNAME, 1, 1)), LOWER(SUBSTRING(u.FIRSTNAME, 2)),
                ' ',
                UPPER(LEFT(u.MIDDLENAME, 1)),'.'
            ) as fullname, 
            c.COURSE_CODE as c_code, c.COURSE_DESC FROM tb_course_enrolled as e
            LEFT join tb_user as u on u.id = e.STUDENT
            LEFT join tb_course c on c.ID = e.id
            WHERE u.ID = ? AND c.STATUS = 'ON'";


        // Create a prepared statement
        $stmt = $mysqli->prepare($sql);

        if (!$stmt) {
            die('Database query failed: ' . mysqli_error($mysqli));
        }

        $stmt->bind_param("i", $idGet);
        $stmt->execute();

        // Fetch and store the result data as an array
        $result = $stmt->get_result();
        $enrolledCourse = array();

        while ($row = $result->fetch_assoc()) {
            $enrolledCourse[] = $row;
        }

        // Close the statement and the database connection
        $stmt->close();
        $mysqli->close();

        // Check if any data was found
        if (empty($enrolledCourse)) {
            // No data found, return a message
            $response = array("message" => "No data available.");
        } else {
            // Send the data as JSON response
            header('Content-Type: application/json');
            echo json_encode($enrolledCourse);
        }
    }
}
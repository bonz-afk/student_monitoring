<?php
include_once $_SERVER['DOCUMENT_ROOT']. '../student_monitoring/lib/client.php';

$process = $_POST['process'];
$id = $_POST['id'];

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
}
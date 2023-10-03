<?php
include_once $_SERVER['DOCUMENT_ROOT']. '../student_monitoring/lib/client.php';

// Retrieve the POST data
// Retrieve the POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUsername = isset($_POST['email']) ? $_POST['email'] : '';
    $inputPassword = isset($_POST['password']) ? $_POST['password'] : '';

    // Prepare a SQL query to fetch user data by username
    $stmt = $mysqli->prepare('SELECT * FROM tb_user WHERE email = ?');
    $stmt->bind_param('s', $inputUsername);
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Fetch the user record
        $user = $result->fetch_assoc();

        // Hash the user-provided password with SHA-256
        $inputPasswordHash = strtoupper(hash('sha256', 'bonz'.$inputPassword));

        // Compare the generated hash with the stored hash
        if ($inputPasswordHash == $user['password']) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            // Authentication successful
            $status = true;
            $message = 'Authentication successful';
            $role =  $_SESSION['role'];
        } else {
            // Authentication failed
            $role = false;
            $status = false;
            $message = 'Invalid Password';
        }
    } else {
        // No user found with the provided username
        $role = false;
        $status = false;
        $message = 'User not found';
    }

    echo json_encode(['status' => $status, 'message' => $message, 'role' => $role]);
} else {
    $error = errorRequest::getErrorMessage(405); // Get the error message for 405 (Method Not Allowed)
    http_response_code(405); // Set the HTTP response code
    echo json_encode(['status' => false,'error' => $error]);
    exit;
}

// Close the database connection
$mysqli->close();

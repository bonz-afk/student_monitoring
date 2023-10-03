<?php
// Define database credentials
$hostname = "127.0.0.22"; // Replace with your database hostname or IP address
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$database = "studentmonitoring"; // Replace with your database name

// Create a MySQLi database connection
$mysqli = new mysqli($hostname, $username, $password, $database);

// Check if the connection was successful
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}


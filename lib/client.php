<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/config.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/course_list_science.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/class_list_science.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/student_list_science.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/student_join_class.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/account_list.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/student_list.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/teacher_list.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/notification_teacher.php';



class errorRequest
{
    private  static $errorCode = array(
        405 => 'Invalid Request Method',
        400 => 'Bad Request: The server cannot process the clients request due to invalid syntax or parameters.',
        404 => 'Not Found: Indicates that the requested resource could not be found on the server.',
        500 => 'Internal Server Error: A generic error message indicating that something went wrong on the server.'
    );

    public static function getErrorMessage($code)
    {
        if (array_key_exists($code, self::$errorCode)) {
            return self::$errorCode[$code];
        }
        return 'Unknown Error';
    }
}

class generateString{
    public static function generateUniqueRandomString($length) {

        global $mysqli;

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        do {
            $randomString = '';

            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }

            // Check if the generated string is unique (not in use)
            $isUnique = self::isStringUnique($randomString, $mysqli);
        } while (!$isUnique);

        // Return the unique random string
        return $randomString;
    }

    private static function isStringUnique($str) {

        global $mysqli;

        $query = "SELECT CLASS_CODE FROM tb_class WHERE CLASS_CODE = '$str'";
        $result = mysqli_query($mysqli, $query);

        if (!$result) {
            die('Database query failed: ' . mysqli_error($mysqli));
        }

        if (mysqli_num_rows($result) > 0) {
            return false;
        }

        return true;
    }
}

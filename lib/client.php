<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/config.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/course_list.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/account_list.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/student_list.php';



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
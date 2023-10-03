<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth_admin.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar with Logo</title>
    <link href="common/css/bootsrap-icon.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        /* Reset some default styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #e0e2e4;
        }

        /* Style the navbar container */
        nav {
            background-color: #f3f3f3;
            color: #fff;
            padding: 10px 0;
            display: flex;
            justify-content: start;
            align-items: center;
        }

        /* Style the logo */
        .logo {
            display: inline-block;
            margin-left: 20px; /* Add some space to the left of the logo */
            font-size: 24px;
            font-weight: bold;
        }

        /* Style the navigation list */
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex; /* Make the list items horizontal */
        }

        /* Style the navigation items */
        li {
            margin-right: 20px; /* Add space between each item */
        }

        /* Style the links */
        a {
            text-decoration: none; /* Remove underlines from links */
            color: #fff; /* Text color of links */
        }

        /* Style the links on hover */
        a:hover {
            text-decoration: underline; /* Add underline on hover */
        }
        .search-container {
            position: relative;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            color: #000000;
        }

        /* Style the input field */
        .search-container input[type="text"] {
            width: 100%;
            padding: 10px 30px; /* Add padding for the icon */
            border: 1px solid #ccc;
            border-radius: 20px;
            font-size: 16px;
        }

        /* Style the input field */
        .search-container input[type="text"]:focus {
            outline: 1px solid #800000;
            box-shadow: 0 0 4px #800000; /* Add a maroon-colored box shadow when focused */
        }


        .search-container img{
            position: relative;
            bottom: 30px;
            left: 820px;
        }

    </style>
</head>
<body>
<nav>
    <!-- Logo -->
    <div class="logo">
        <img src="../../common/images/logo/lpu-logo.png" alt="Logo" style="width: 10rem;height: 5rem">
    </div>
    <!-- Navigation Menu -->
    <div class="search-container">
        <input type="text" placeholder="Search">
        <img src="../../common/images/logo/magnifier.svg" width="20px" height="20px">
    </div>
</nav>
</body>
</html>

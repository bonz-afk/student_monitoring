<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth.php';
$current_page = 'college-classes';
$current_dropdown = 'class_science'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Monitoring</title>
    <link rel="stylesheet" href="../../common/css/common.css">
    <link rel="stylesheet" href="../../common/css/nav.css">
    <link rel="stylesheet" href="../../common/css/modal.css">
    <style>
        .join-class-container {
            transition: margin-left 0.3s; /* Add smooth transition for opening/closing sidebar */
        }
        .join-class-content{
            width: 100%;
            margin: 100px auto;
            background-color: transparent;
            text-align: center;
        }

        .font-mont{
            font-size: 50px;
        }

        .join-teacher-table,.join-student-list-table {
            width: 100%;
            background-color: transparent;
            border-collapse: collapse;
        }

        .join-teacher-table th{
            padding: 20px;
            font-size: 20px;
            max-width: 100px;
        }

        .join-student-list-table th{
            padding: 20px;
            font-size: 20px;
            width: 50%;
        }

        .join-teacher-table td{
            padding: 10px; /* Add padding to create spacing */
            font-size: 20px;
            width: auto;
        }

        .join-student-list-table td{
            padding: 10px; /* Add padding to create spacing */
            font-size: 20px;
            width: 50%;
        }

        .join-teacher-table thead,tbody,.join-student-list-table thead,tbody{
            text-align: center;
            padding: 20px 0;
        }

        .table-container{
            width: 100%;
            margin: 0 auto;
            height: 400px;
            overflow-y: auto;
            overflow-x: hidden;
            border-radius: 15px;
            background-color: #FFFFFF;
            max-width: 1522px;
        }

        .join-title{
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .join-title img{
            width: 250px;
            height: 250px;
        }

        .join-title p {
            font-size: 45px;
            font-weight: 900;
            font-family: 'Montserrat', sans-serif;
        }

        .join-button-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0 auto;
            max-width: 1522px;
        }

        @media only screen and (max-width: 1518px) {
            .table-container{
                max-width: 700px;
            }

            .join-button-content{
                max-width: 700px;
            }
        }


        @media only screen and (max-width: 802px) {
            .table-container{
                max-width: 600px !important;
            }
            .join-button-content{
                max-width: 600px;
            }
        }

        @media only screen and (max-width: 616px) {
            .table-container{
                max-width: 350px !important;
            }
            .join-button-content{
                max-width: 350px;
            }
        }

        @media only screen and (max-width: 1200px) {
            .join-title p {
                font-size: 30px;
            }
            .join-title img {
                width: 100px;
                height: 100px;
            }
        }


        .create-class{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-left: 15px;
            gap: 10px;
        }

        .create-class-item{
            display: flex;
            justify-content: start;
            align-items: center;
            width: 100%;
        }

        .create-class-item:nth-child(n+6){
            display: flex;
            justify-content: start;
            margin-bottom: -10px;
        }

        .create-class-item:nth-child(n+7){
            display: flex;
            justify-content: start;
            align-items: start;
            gap: 10px;
            margin-bottom: 5px;
            flex-wrap: wrap;
        }

        .create-class-item:last-child{
            margin-bottom: 20px;
        }

        .creat-class-input{
            width: 100%;
            height: 35px;
            max-width: 350px;
            margin: 10px 0;
            border-radius: 5px;
            border: 0;
            background-color: #e0e2e4;
            padding: 10px;
            text-indent: 10px;
            font-size: 20px;
            color: #800000;
        }
        .create-class-item .checkBoxes{
            width: 100% !important;
            max-width: 20px !important;
        }

        .creat-class-input::placeholder{
            color: #800000;
        }

        .checkbox-item{
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
        .create-schedule{
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 50px;
        }

        /* Style the time input */
        input[type="time"] {
            padding: 5px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Style the time input when focused */
        input[type="time"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        /* Style the labels */
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 200;
        }

        /* Add more styling as needed */
        .form-control {
            /* Add Bootstrap-like form control styling */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .create-class-item-content{
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: start;
            gap: 50px;
        }

        .create-class-item--content{
            display: flex;
            justify-content: start;
            flex-direction: column;
            align-items: start;
            width: 100%;
        }
        .creat-class-input:focus,.college-select:focus{
            outline: 0;
        }

        .college-select {
            appearance: none;
            width: 100%;
            height: 35px;
            margin: 10px 0;
            border-radius: 5px;
            border: 0;
            background-color: #e0e2e4;
            text-indent: 10px;
            font-size: 20px;
            color: #800000;
            padding: 0 48px 0 0;
        }
        .create-class-item label, input[type="checkbox"] {
            cursor: pointer;
        }

        .clear {
            clear: both;
        }

        .message-time {
            position: relative;
            top: 60px;
            left: -367px;
        }

        .join-button-content div{
            cursor: pointer;
        }

        .join-title{
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
        .join-title-item{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .join-title-content{
            max-width: 355px;
            width: 100%;
            background: #800000;
            color: #FFFFFF;
            padding: 20px;
            border-radius: 35px;
            font-size: 20px;
        }

        .join-title-code{
            display: flex;
            justify-content: center;
            align-items: center;
            letter-spacing: 1px;
            max-width: 200px;
            width: 100%;
            background: #A8A8A8;
            color: #FFFFFF;
            padding: 20px 10px;
            border-radius: 35px;
            font-size: 15px;
            cursor: pointer;
        }
        .btn-maroon.join{
            padding: 10px 0;
        }

        .search-container-student{
            display: flex;
            justify-content: end;
            align-items: center;
            gap: 10px;
            width: 100%;
        }

        .search-input{
            border-radius: 10px;
            outline: none;
            border: none;
            height: 40px;
            width: 100%;
            max-width: 400px;
            padding: 0 10px;
        }

        .join-class-input{
            width: 100%;
            height: 35px;
            max-width: 450px;
            margin: 40px 0;
            border-radius: 5px;
            border: 0;
            background-color: #e0e2e4;
            padding: 10px;
            text-indent: 10px;
            font-size: 20px;
            color: #800000;
        }

        .join-class-input:focus{
            border: none;
            outline: none;
        }

        .join-class-input::placeholder{
            color: #800000;
        }
        .btn-join-container{
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }

        .student-account-select:focus{
            outline: 0;
        }

        .student-account-select {
            appearance: none;
            width: 100%;
            height: 35px;
            margin: 10px 0;
            border-radius: 5px;
            border: 0;
            background-color: transparent;
            text-indent: 10px;
            font-size: 20px;
            color: #800000;
            padding: 0 48px 0 0;
            cursor: pointer;
        }

        .custom-select-class{
            background-color: transparent;
            border-bottom: 1px solid #800000;
            border-radius: 0;
            max-width: 195px;
        }
    </style>
    <script src="https://kit.fontawesome.com/0dffe12a1d.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include_once $_SERVER["DOCUMENT_ROOT"]. "/student_monitoring/nav.php"?>
<div class="join-class-container">
    <div class="join-title">
        <img src="../../common/images/logo/css-logo.png"  />

        <p>College Of Computer Studies</p>
    </div>
    <div class="join-class-content">
        <div class="join-button-content">
            <div style="width: 100%">
                <span class="custom-select-class">
                     <input type="text" id="student_id" readonly  hidden>
                     <select  class="student-account-select" id="join-class-select" name="join-class-select" onchange="classYearChange('join_change')">
                         <option value="">Academic Year</option>
                         <?php foreach($academicYear as $year){ ?>
                             <option value="<?php echo $year['ACADEMIC_YEAR'] ?>"><?php echo $year['ACADEMIC_YEAR'] ?></option>
                         <?php } ?>
                     </select>
                </span>
            </div>
            <div>
                <button class="btn-maroon openModalBtn" data-modal="joinClass">Join Class</button>
            </div>
        </div>
        <div class="table-container">
            <table class="join-teacher-table" >
                <thead>
                <tr>
                    <th>
                        <div class="sorting">
                            <img  id="sort-img" src="../../common/images/logo/dropdown-logo.svg" class="sort" width="50" height="50" onclick="sort('join-class-science');">
                            <span>Class Name</span>
                        </div>
                    </th>
                    <th>Course</th>
                    <th>Section</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($joinClass as $science) {?>
                    <tr>
                        <td><?php echo $science['CLASS_NAME']; ?></td>
                        <td><?php echo $science['c_code']; ?></td>
                        <td><?php echo $science['SECTION']; ?></td>
                        <td><?php echo $science['statusEnroll'] == 'ON' ? 'Joined' : 'Pending'; ?></td>
                        <td> <i class="fa-solid fa-trash fa-xl"  style="color: #800000;cursor: pointer" onclick="joinedClasses('leave',<?php echo $science['enrolledId'];?>)"></i></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/modal/student_science_class_modal.php'; ?>
<script src="../../common/js/external/jquery-3.7.1.min.js"></script>
<script src="../../common/js/common.js"></script>
<script src="../../common/js/nav.js"></script>
<script src="../../common/js/modal.js"></script>
<script src="../../common/js/external/sweetalert2.min.js"></script>
</body>
</html>

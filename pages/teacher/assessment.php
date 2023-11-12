<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth_teacher.php';
$current_page = 'assessment';
$current_dropdown = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../common/css/common.css">
    <link rel="stylesheet" href="../../common/css/nav.css">
    <link rel="stylesheet" href="../../common/css/modal.css">
    <style>
        .class-teacher-container {
            transition: margin-left 0.3s; /* Add smooth transition for opening/closing sidebar */
        }
        .teacher-content{
            width: 100%;
            margin: 100px auto;
            background-color: transparent;
            text-align: center;
        }

        .font-mont{
            font-size: 50px;
        }

        .student-enrolled-table,.class-student-attendance,.class-student-score ,.class-student-lab{
            width: 100%;
            background-color: transparent;
            border-collapse: collapse;
        }

        .student-enrolled-table th{
            padding: 20px;
            font-size: 20px;
            width: auto;
        }

        .class-student-list-table th{
            padding: 20px;
            font-size: 20px;
            width: 50%;
        }

        .class-student-attendance th ,.class-student-score th,.class-student-lab th{
            padding: 20px;
            font-size: 20px;
            width: auto;
        }

        .student-enrolled-table td{
            padding: 10px; /* Add padding to create spacing */
            font-size: 20px;
            width: auto;
        }

        .class-student-attendance td,.class-student-score td,.class-student-lab td{
            padding: 10px; /* Add padding to create spacing */
            font-size: 20px;
            width: auto;
        }

        .student-enrolled-table thead,tbody,.class-student-attendance thead,tbody, .class-student-score thead,tbody,.class-student-lab thead,tbody{
            text-align: center;
            padding: 20px 0;
        }

        .student-enrolled-table th{
            padding: 20px;
            font-size: 20px;
            max-width: 100px;
        }

        .list-teacher{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .list-teacher-item{
            background: #800000;
            padding: 10px 20px;
            border-radius: 15px;
            width: 100%;
            max-width: 150px;
            cursor: pointer;
        }
        .list-teacher-item p{
            font-size: 15px;
            font-weight: 200;
            font-family: unset;
            color: #FFFFFF;
        }
        .course-description {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }
        .course-description:hover {
            white-space: unset;
            max-width: 200px;
            overflow: unset;
            text-overflow: unset;
        }
        .table-container{
            width: 100%;
            margin: 0 auto;
            height: 400px;
            overflow-y: auto;
            border-radius: 15px;
            background-color: #FFFFFF;
            max-width: 1522px;
        }

        .table-container-modal{
            width: 100%;
            margin: 0 auto;
            height: 400px;
            overflow-y: auto;
            overflow-x: hidden;
            background-color: #FFFFFF;
            max-width: 665px;
        }

        .class-title{
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .class-title img{
            width: 250px;
            height: 250px;
        }

        .class-title p {
            font-size: 45px;
            font-weight: 900;
            font-family: 'Montserrat', sans-serif;
        }

        .class-button-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: nowrap;
            margin: 0 auto;
            max-width: 1522px;
        }

        @media only screen and (max-width: 2108px) {
            .table-container{
                max-width: 1180px;
            }

            .class-button-content{
                max-width: 1180px;
            }
        }

        @media only screen and (max-width: 1758px) {
            .table-container{
                max-width: 1000px;
            }

            .class-button-content{
                max-width: 1000px;
            }
        }

        @media only screen and (max-width: 1520px) {
            .table-container {
                max-width: 700px;
                overflow-x: scroll;
            }

            .class-button-content {
                max-width: 700px;
            }
        }

        @media only screen and (max-width: 1272px) {
            .class-title img{
                width: 200px;
                height: 200px;
            }

            .class-title p{
                font-size: 30px;
            }

            .table-container{
                max-width: 600px;
            }

            .class-button-content{
                max-width: 600px;
            }

            .class-button-content{
                gap: 40px !important;
            }

            .student-enrolled-table{
                width: 800px;
            }
        }


        @media only screen and (max-width: 802px) {
            .table-container{
                max-width: 600px !important;
            }
            .class-button-content{
                max-width: 600px;
            }


            .table-container-modal{
                overflow-x: auto;
            }
        }

        @media only screen and (max-width: 616px) {
            .table-container{
                max-width: 350px !important;
            }
            .class-button-content{
                max-width: 350px;
            }

            .class-title p{
                font-size: 20px;
                text-align: center;
            }

            .class-teacher-container{
                margin-left: 0 !important;
            }
        }

        @media only screen and (max-width: 1200px) {

            .class-title img {
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

        .class-button-content div{
            cursor: pointer;
        }

        .class-title{
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
        .class-title-item{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .class-title-content{
            max-width: 355px;
            width: 100%;
            background: #800000;
            color: #FFFFFF;
            padding: 20px;
            border-radius: 35px;
            font-size: 20px;
        }

        .class-title-code{
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
        .classes.custom-select-class{
            background-color: transparent;
            border-bottom: 1px solid #800000;
            border-radius: 0;
            max-width: 195px;
        }

        .teacher-account-select:focus{
            outline: 0;
        }

        .teacher-account-select {
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

        .select-container{
            width: 100%;
            display: flex;
            gap: 20px;
        }

        .search-input{
            height: 54px;
            border: none;
            background-color: transparent;
            text-indent: 10px;
            font-size: 20px;
            color: #800000;
            padding: 0 48px 0 0;
            width: 100%;
            max-width: 200px;
            border-bottom: solid 1px;
        }

        .search-input:focus{
            outline: none;
        }

        .attStatus{
            width: 100%;
            height: 40px;
            max-width: 134px;
            margin: 10px 0;
            border: 0;
            padding: 10px;
            text-indent: 14px;
            font-size: 20px;
            color: #800000;
            border-bottom: 1px solid;
        }

        .attStatus:focus{
            outline: none;
        }

        .score-class{
            width: 100%;
            height: 40px;
            max-width: 134px;
            margin: 10px 0;
            border: 0;
            padding: 10px;
            text-align: center;
            font-size: 20px;
            color: #800000;
            border-bottom: 1px solid;
        }

        .score-class:focus{
            outline: none;
        }
        .btn-save{
            width: 100%;
            height: 40px;
            text-align: center;
            max-width: 70px;
            padding: 10px;
        }
    </style>
    <script src="https://kit.fontawesome.com/0dffe12a1d.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include_once $_SERVER["DOCUMENT_ROOT"]. "/student_monitoring/nav.php"?>
<div class="class-teacher-container">
    <div class="class-title">
        <img src="../../common/images/logo/css-logo.png"  />

        <p>College Of Computer Studies</p>
    </div>
    <div class="teacher-content">
        <div class="class-button-content">
            <div class="select-container">
                <span class="classes custom-select-class">
                     <select  class="teacher-account-select" id="teacher-year--select" name="teacher-year--select" onchange="enrolledStudentFilter('search_filter')">
                         <option value="">Academic Year</option>
                         <?php foreach($academicYear as $year){ ?>
                             <option value="<?php echo $year['ACADEMIC_YEAR'] ?>"><?php echo $year['ACADEMIC_YEAR'] ?></option>
                         <?php } ?>
                     </select>
                </span>
            </div>
            <input class="search-input" id="search-input" placeholder="Search" onkeyup="enrolledStudentFilter('search_filter')">
        </div>
        <div class="table-container">
            <table class="student-enrolled-table" >
                <thead>
                <tr>
                    <th>
                        <div class="sorting">
                            <img  id="sort-img" src="../../common/images/logo/dropdown-logo.svg" class="sort" width="50" height="50" onclick="sort('student_classes_enrolled')">
                            <span>Student</span>
                        </div>
                    </th>
                    <th>Class</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($studentEnrolled as $science) {?>
                    <tr>
                        <td><?php echo $science['fullname']; ?></td>
                        <td><?php echo $science['CLASS_NAME']; ?></td>
                        <td><?php echo $science['type_formatted']; ?></td>
                        <td> <i class="fas fa-clipboard-user fa-xl openModalBtn" data-modal="studentAttendance"   style="color: #800000;cursor: pointer" onclick="studentClassDetails('attendance',<?php echo $science['enrollClass']; ?>, <?php echo $science['uid']; ?>)"></i> &nbsp; <i class="fa-solid fa-newspaper fa-xl openModalBtn" data-modal="studentScore"   style="color: #800000;cursor: pointer" onclick="studentClassDetails('score',<?php echo $science['enrollClass']; ?>, <?php echo $science['uid']; ?>)" ></i> &nbsp; <i class="fa-solid fa-computer fa-xl openModalBtn" data-modal="studentOthers"  style="color: #800000;cursor: pointer" onclick="studentClassDetails('others',<?php echo $science['enrollClass']; ?>, <?php echo $science['uid']; ?>)"></i></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/modal/student_attendance_modal.php'; ?>
<script src="../../common/js/external/jquery-3.7.1.min.js"></script>
<script src="../../common/js/common.js"></script>
<script src="../../common/js/nav.js"></script>
<script src="../../common/js/modal.js"></script>
<script src="../../common/js/external/sweetalert2.min.js"></script>
</body>
</html>

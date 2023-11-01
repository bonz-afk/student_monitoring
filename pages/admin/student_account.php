<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth_user.php';
$current_page = 'account';
$current_dropdown = 'student';
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
            .admin-student-container {
                transition: margin-left 0.3s; /* Add smooth transition for opening/closing sidebar */
            }
            .student-content{
                width: 100%;
                margin: 100px auto;
                background-color: transparent;
                max-width: 1522px;
                text-align: center;
            }

            .font-mont{
                font-size: 50px;
            }

            .admin-student-table, .admin-student-table-data {
                width: 100%;
                background-color: transparent;
                border-collapse: collapse;
            }

            .admin-student-table th{
                padding: 20px;
                font-size: 20px;
                width: 50%;
            }

            .admin-student-table-data th{
                padding: 20px;
                font-size: 20px;
                width: auto;
            }

            .admin-student-table td {
                padding: 10px; /* Add padding to create spacing */
                font-size: 20px;
                width: 50%;
            }

            .admin-student-table-data td {
                padding: 10px; /* Add padding to create spacing */
                font-size: 20px;
                width: auto;
            }

            .admin-student-table thead,tbody, .admin-student-table-data thead,tbody {
                text-align: center;
                padding: 20px 0;
            }

            .list-student{
                display: flex;
                justify-content: center;
                align-items: center;
                flex-wrap: wrap;
                gap: 10px;
            }
            .list-student-item{
                background: #800000;
                padding: 10px 20px;
                border-radius: 15px;
                width: 100%;
                max-width: 150px;
                cursor: pointer;
            }
            .list-student-item p{
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

            .modal-title p:last-child {
                font-size: 20px;
                font-weight: 200;
                font-family: unset;
            }

            .table-container{
                width: 100%;
                margin: 0 auto;
                height: 400px;
                overflow-y: auto;
                overflow-x: hidden;
                background-color: #FFFFFF;
                max-width: 1522px;
            }

            @media only screen and (max-width: 1518px) {
                .table-container{
                    max-width: 700px;
                }
                .student-sort{
                    max-width: 700px;
                }
            }

            @media only screen and (max-width: 802px) {
                .table-container{
                    max-width: 600px !important;
                }
                .student-sort{
                    max-width: 600px;
                }
            }

            @media only screen and (max-width: 616px) {
                .table-container{
                    max-width: 350px !important;
                }
                .student-sort{
                    max-width: 350px;
                }
            }


            @media  only screen and (max-width: 1148px) {
                .admin-student-container{
                    display: block;
                    margin-left: 0 !important;
                }

                .admin-student-container.hide{
                    display: none;
                }
                .table-container {
                    width: 100%;
                    margin: 0 auto;
                    height: 400px;
                    overflow-y: auto;
                    overflow-x: hidden;
                    background-color: #FFFFFF;
                    max-width: 800px;
                }

                .font-mont{
                    font-size: 30px;
                }
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

            .student-sort{
                display: flex;
                justify-content: start;
                margin: 0 auto;
            }
            .student-sort img{
                cursor: pointer;
            }

        </style>
        <script src="https://kit.fontawesome.com/0dffe12a1d.js" crossorigin="anonymous"></script>
    </head>
    <body>
    <?php include_once $_SERVER["DOCUMENT_ROOT"]. "/student_monitoring/nav.php"?>
        <div class="admin-student-container">
            <div class="student-content">
                <p class="font-mont">Student List</p>
                <div class="student-sort">
                    <img src="../../common/images/logo/dropdown-logo.svg" class="button-content-item" width="80" height="80" onclick="sort('student-account')" />
                </div>
                <div class="table-container">
                    <table class="admin-student-table">
                        <thead>
                        <tr>
                            <th>Name of Student</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($studentData as $student){ ?>
                            <tr>
                                <td id="fullval<?php echo $student['id']; ?>" data-fullname="<?php echo  $student['fullname']; ?>"><?php echo  $student['fullname']; ?></td>
                                <td><i class="fa-solid fa-eye fa-xl openModalBtn" data-modal="adminViewStudent" onclick="adminStudentProcess('view',<?php echo $student['id']; ?>)"  style="color: #800000;cursor: pointer" ></i> &nbsp; <i class="fa-solid fa-trash fa-xl"  style="color: #800000;cursor: pointer" onclick="adminStudentProcess('delete',<?php echo $student['id']; ?>)"></i></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <div class="modal" id="adminViewStudent">
        <div class="modal-content">
            <div class="modal-title">
                <p>Enrolled Classes</p>
                <p id="student_name"></p>
            </div>
            <div class="modal-body">
                 <span class="custom-select-class">
                     <input type="text" id="student_id" readonly  hidden>
                     <select  class="student-account-select" id="student-account-select" name="student-account-select" onchange="academicYear('view','student')">
                         <option value="">Academic Year</option>
                         <?php foreach($academicYear as $year){ ?>
                             <option value="<?php echo $year['ACADEMIC_YEAR'] ?>"><?php echo $year['ACADEMIC_YEAR'] ?></option>
                         <?php } ?>
                     </select>
                 </span>
                <div class="table-container">
                    <table class="admin-student-table-data">
                        <thead>
                        <tr>
                            <th>Class Name</th>
                            <th>Course</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="../../common/js/external/jquery-3.7.1.min.js"></script>
    <script src="../../common/js/common.js"></script>
    <script src="../../common/js/nav.js"></script>
    <script src="../../common/js/modal.js"></script>
    <script src="../../common/js/external/sweetalert2.min.js"></script>
    <script></script>
    </body>
</html>

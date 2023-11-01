<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth_user.php';
$current_page = 'account';
$current_dropdown = 'teacher';
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
            .admin-teacher-container {
                transition: margin-left 0.3s; /* Add smooth transition for opening/closing sidebar */
            }
            .teacher-content{
                width: 100%;
                margin: 100px auto;
                background-color: transparent;
                max-width: 1522px;
                text-align: center;
            }

            .font-mont{
                font-size: 50px;
            }

            .admin-teacher-table, .admin-teacher-table-data {
                width: 100%;
                background-color: transparent;
                border-collapse: collapse;
            }

            .admin-teacher-table th{
                padding: 20px;
                font-size: 20px;
                width: 50%;
            }

            .admin-teacher-table-data th{
                padding: 20px;
                font-size: 20px;
                width: auto;
            }

            .admin-teacher-table td {
                padding: 10px; /* Add padding to create spacing */
                font-size: 20px;
                width: 50%;
            }

            .admin-teacher-table-data td {
                padding: 10px; /* Add padding to create spacing */
                font-size: 20px;
                width: auto;
            }

            .admin-teacher-table thead,tbody, .admin-teacher-table-data thead,tbody {
                text-align: center;
                padding: 20px 0;
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
                overflow-x: hidden;
                background-color: #FFFFFF;
                max-width: 1522px;
            }

            @media only screen and (max-width: 1518px) {
                .table-container{
                    max-width: 700px;
                }

                .teacher-sort{
                    max-width: 700px;
                }
            }


            @media only screen and (max-width: 802px) {
                .table-container{
                    max-width: 600px !important;
                }
                .teacher-sort{
                    max-width: 600px;
                }
            }

            @media only screen and (max-width: 616px) {
                .table-container{
                    max-width: 350px !important;
                }
                .teacher-sort{
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

            .custom-select-class{
                background-color: transparent;
                border-bottom: 1px solid #800000;
                border-radius: 0;
                max-width: 195px;
            }

            .teacher-sort{
                display: flex;
                justify-content: start;
                margin: 0 auto;
            }
            .teacher-sort img{
                cursor: pointer;
            }

            .modal-title p:last-child {
                font-size: 20px;
                font-weight: 200;
                font-family: unset;
            }

        </style>
        <script src="https://kit.fontawesome.com/0dffe12a1d.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php include_once $_SERVER["DOCUMENT_ROOT"]. "/student_monitoring/nav.php"?>
        <div class="admin-teacher-container">
            <p class="teacher font-mont" style="text-align: center; margin: 100px auto;">Teacher List</p>
            <div class="teacher-content">
                <div class="teacher-sort">
                    <img src="../../common/images/logo/dropdown-logo.svg" class="button-content-item" width="80" height="80" onclick="sort('teacher-account')" />
                </div>
               <div class="table-container">
                   <table class="admin-teacher-table" >
                       <thead>
                       <tr>
                           <th>Name of teacher</th>
                           <th></th>
                       </tr>
                       </thead>
                       <tbody>
                       <?php foreach($teacherData as $teacher){ ?>
                           <tr>
                               <td id="fullteacher<?php echo $teacher['id']; ?>" data-teachername="<?php echo  $teacher['LASTNAME'].', '.$teacher['FIRSTNAME'].' '.substr($teacher['MIDDLENAME'], 0,1); ?>"><?php echo  $teacher['LASTNAME'].', '.$teacher['FIRSTNAME'].' '.substr($teacher['MIDDLENAME'], 0,1); ?></td>
                               <td><i class="fa-solid fa-eye fa-xl openModalBtn" data-modal="adminViewTeacher" onclick="adminTeacherProcess('view',<?php echo $teacher['id']; ?>)"  style="color: #800000;cursor: pointer" ></i> &nbsp; <i class="fa-solid fa-trash fa-xl"  style="color: #800000;cursor: pointer" onclick="adminTeacherProcess('delete',<?php echo $teacher['id']; ?>)"></i></td>
                           </tr>
                       <?php } ?>
                       </tbody>
                   </table>
               </div>
            </div>
        </div>
        <div class="modal" id="adminViewTeacher">
            <div class="modal-content">
                <div class="modal-title">
                    <p>List of Classes</p>
                    <p id="teacher_name"></p>
                </div>
                <div class="modal-body">
                 <span class="custom-select-class">
                     <input type="text" id="teacher_id" readonly  >
                     <select  class="teacher-account-select" id="teacher-account-select" name="teacher-account-select" onchange="academicYear('view','teacher')">
                         <option value="">Academic Year</option>
                         <?php foreach($academicYear as $year){ ?>
                             <option value="<?php echo $year['ACADEMIC_YEAR'] ?>"><?php echo $year['ACADEMIC_YEAR'] ?></option>
                         <?php } ?>
                     </select>
                 </span>
                    <div class="table-container">
                        <table class="admin-teacher-table-data">
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
    </body>
</html>

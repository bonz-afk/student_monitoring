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
                margin-left: 400px; /* Adjust the margin to match the sidebar width */
                transition: margin-left 0.3s; /* Add smooth transition for opening/closing sidebar */
            }
            .teacher-content{
                width: 100%;
                margin: 100px auto;
                height: 400px;
                overflow-y: auto;
                overflow-x: hidden;
                background-color: transparent;
                max-width: 1522px;
                text-align: center;
            }

            .font-mont{
                font-size: 50px;
            }

            .admin-teacher-table {
                width: 100%;
                background-color: transparent;
                border-collapse: collapse;
            }

            .admin-teacher-table th{
                padding: 20px;
                font-size: 20px;
                width: 50%;
            }

            .admin-teacher-table td {
                padding: 10px; /* Add padding to create spacing */
                font-size: 20px;
                width: 50%;
            }

            .admin-teacher-table thead,tbody {
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
        </style>
        <script src="https://kit.fontawesome.com/0dffe12a1d.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php include_once $_SERVER["DOCUMENT_ROOT"]. "/student_monitoring/nav.php"?>
        <div class="admin-teacher-container">
            <div class="teacher-content">
                <p class="teacher font-mont">Teacher List</p>
                <table class="admin-teacher-table">
                    <thead>
                    <tr>
                        <th>Name of teacher</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($teacherData as $teacher){ ?>
                        <tr>
                            <td><?php echo  $teacher['LASTNAME'].', '.$teacher['FIRSTNAME'].' '.substr($teacher['MIDDLENAME'], 0,1); ?></td>
                            <td><i class="fa-solid fa-eye fa-xl openModalBtn" data-modal="adminViewteacher" onclick="adminteacherProcess('view',<?php echo $teacher['id']; ?>)"  style="color: #800000;cursor: pointer" ></i> &nbsp; <i class="fa-solid fa-trash fa-xl"  style="color: #800000;cursor: pointer" onclick="adminteacherProcess('delete',<?php echo $teacher['id']; ?>)"></i></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script src="../../common/js/external/jquery-3.7.1.min.js"></script>
        <script src="../../common/js/common.js"></script>
        <script src="../../common/js/nav.js"></script>
        <script src="../../common/js/modal.js"></script>
        <script src="../../common/js/external/sweetalert2.min.js"></script>
    </body>
</html>

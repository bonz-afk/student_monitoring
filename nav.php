
    <nav>
        <div class="logo">
            <div class="logo-container">
                <div class="menu-icon" onclick="toggleSidenav()" >
                    &#9776;
                </div>
                <img src="../../common/images/logo/nav-logo.png" alt="Logo" style="width: 10rem;height: 10rem">
                <div class="logo-content">
                    <p>LPU</p>
                    <p>LYCEUM OF THE PHILIPPINES UNIVERSITY</p>
                    <p>BATANGAS</p>
                </div>
            </div>
        </div>
        <div class="nav-profile">
            <div class="notification" style="color: #800000; cursor: pointer; font-size: 36px;">
                <i class="fas fa-bell fa-xl" onclick="toggleNotif()"></i>
                <span class="badge"><?php echo $notifTeacherCount ? $notifTeacherCount : 0; ?></span>
                <div class="notification-dropdown" id="notificationDropdown">
                    <ul>
                        <?php if(!empty($notifContent)) { ?>
                            <?php foreach ($notifContent as $list) {?>
                                <li>
                                    <div style="margin-bottom: 10px">
                                       <small>Class: </small> <b ><?php echo $list['CLASS_NAME']; ?></b>
                                    </div>
                                    <div class="student-with-btn">
                                        <span style="text-align: start"><small>Student: </small> <b><?php echo $list['fullname']; ?></b></span>
                                        <button class="admit btn-cancel" onclick="createClass('admit',<?php echo $list['enrolledid'] ?>)">Admit</button>
                                    </div>

                                </li>
                            <?php }}else{?>
                                <li style="text-align: center">No Notifications</li>
                        <?php }?>
                    </ul>
                </div>
            </div>
            <img src="../../common/images/logo/circle-account.svg"  id="toggleLogout" onclick="toggleDropdown()" style="cursor: pointer">
            <!-- Dropdown menu -->
            <div class="dropdown-menu" id="profileDropdown">

                <a href="#" onclick="logout()" >Logout</a>
            </div>
        </div>
    </nav>

    <div class="sidenav hide">
        <div class="sidenav-item">
            <?php if($_SESSION['role'] === 'ADMIN') { ?>
            <a class="sidebar-link <?php echo $current_page === 'college' && $current_dropdown === null ? 'active-item' : ''; ?>" href="http://localhost/student_monitoring/pages/admin/college.php" style="color: white">College</a>
            <?php if ($current_page === 'college') { ?>
                <ul class="dropdown-container">
                    <li><a href="#" class="sidebar-link <?php echo $current_dropdown === 'college_business' ? 'active-item' : ''; ?>">College of Business Administration</a></li>
                    <li><a href="http://localhost/student_monitoring/pages/admin/computer_studies.php" class="sidebar-link <?php echo $current_dropdown === 'computer_studies' ? 'active-item' : ''; ?>">College of Computer Studies</a></li>
                    <li><a href="#" class="sidebar-link <?php echo $current_dropdown === 'college_engineering' ? 'active-item' : ''; ?>">College of Engineering</a></li>
                </ul>
            <?php }?>
            <a class="sidebar-link <?php echo $current_page === 'accounts' && $current_dropdown === null ? 'active-item' : ''; ?>" href="accounts.php" style="color: white">Accounts</a>
            <?php if ($current_page !== 'college') { ?>
                <ul class="dropdown-container">
                    <li><a href="http://localhost/student_monitoring/pages/admin/student_account.php" class="sidebar-link <?php echo $current_dropdown === 'student' ? 'active-item' : ''; ?>">Student</a></li>
                    <li><a href="http://localhost/student_monitoring/pages/admin/teacher_account.php" class="sidebar-link <?php echo $current_dropdown === 'teacher' ? 'active-item' : ''; ?>">Teacher</a></li>
                </ul>
            <?php }}?>
            <?php if($_SESSION['role'] === 'TEACHER' || $_SESSION['role'] === 'ADMIN') { ?>
                <a class="sidebar-link  <?php echo $current_page === 'classes' && $current_dropdown === null ? 'active-item' : ''; ?>" href="http://localhost/student_monitoring/pages/teacher/index.php" style="color: white">Classes</a>
                <?php if ($current_page === 'classes') { ?>
                    <ul class="dropdown-container">
                        <li><a href="#" class="sidebar-link <?php echo $current_dropdown === 'teacher' ? 'active-item' : ''; ?>">College of Business Administration</a></li>
                        <li><a href="http://localhost/student_monitoring/pages/teacher/class_science.php" class="sidebar-link <?php echo $current_dropdown === 'class_science' ? 'active-item' : ''; ?>">College of Computer Studies</a></li>
                        <li><a href="#" class="sidebar-link <?php echo $current_dropdown === 'teacher' ? 'active-item' : ''; ?>">College of Engineering</a></li>
                    </ul>
                <?php }?>
                <a class="sidebar-link  <?php echo $current_page === 'assessment' && $current_dropdown === null ? 'active-item' : ''; ?>" href="http://localhost/student_monitoring/pages/teacher/assessment.php" style="color: white">Assessment</a>
                <?php if ($current_page === 'assessment') { ?>
                    <ul class="dropdown-container">
                        <li><a href="assessment.php" class="sidebar-link <?php echo $current_dropdown === 'attendance' ? 'active-item' : ''; ?>">Attendance</a></li>
                        <li><a href="class_science.php" class="sidebar-link <?php echo $current_dropdown === 'exam' ? 'active-item' : ''; ?>">Exam & Quizzes</a></li>
                        <li><a href="#" class="sidebar-link <?php echo $current_dropdown === 'activities' ? 'active-item' : ''; ?>">Activities & Others</a></li>
                    </ul>
                <?php }}?>
            <?php if($_SESSION['role'] === 'STUDENT' || $_SESSION['role'] === 'ADMIN') { ?>
                <a class="sidebar-link  <?php echo $current_page === 'college-classes' && $current_dropdown === null ? 'active-item' : ''; ?>" href="http://localhost/student_monitoring/pages/student" style="color: white">Classes</a>
                <?php if ($current_page === 'college-classes') { ?>
                    <ul class="dropdown-container">
                        <li><a href="#" class="sidebar-link <?php echo $current_dropdown === 'college_business' ? 'active-item' : ''; ?>">College of Business Administration</a></li>
                        <li><a href="http://localhost/student_monitoring/pages/student/class_science.php" class="sidebar-link <?php echo $current_dropdown === 'class_science' ? 'active-item' : ''; ?>">College of Computer Studies</a></li>
                        <li><a href="#" class="sidebar-link <?php echo $current_dropdown === 'college_engineering' ? 'active-item' : ''; ?>">College of Engineering</a></li>
                    </ul>
                <?php }?>
                <a class="sidebar-link  <?php echo $current_page === 'assessment' && $current_dropdown === null ? 'active-item' : ''; ?>" href="http://localhost/student_monitoring/pages/student/assessment.php" style="color: white">Assessment</a>
                <?php if ($current_page === 'assessment') { ?>
                    <ul class="dropdown-container">
                        <li><a href="http://localhost/student_monitoring/pages/student/attendance.php" class="sidebar-link <?php echo $current_dropdown === 'attendance' ? 'active-item' : ''; ?>">Attendance</a></li>
                        <li><a href="http://localhost/student_monitoring/pages/student/exam-quiz.php" class="sidebar-link <?php echo $current_dropdown === 'exam' ? 'active-item' : ''; ?>">Exam & Quizzes</a></li>
                        <li><a href="#" class="sidebar-link <?php echo $current_dropdown === 'activities' ? 'active-item' : ''; ?>">Activities & Others</a></li>
                    </ul>
                <?php }}?>
<!--                <a class="sidebar-link --><?php //echo $current_page === 'assessment' && $current_dropdown === null ? 'active-item' : ''; ?><!--" href="assessment.php" style="color: white">Assessment</a>-->
<!--            --><?php //if ($current_page === 'assessment') { ?>
<!--            <ul class="dropdown-container">-->
<!--                <li><a href="#" class="sidebar-link --><?php //echo $current_dropdown === 'teacher' ? 'active-item' : ''; ?><!--">Attendance</a></li>-->
<!--                <li><a href="#" class="sidebar-link --><?php //echo $current_dropdown === 'major' ? 'active-item' : ''; ?><!--">Major Exam, Quizzes</a></li>-->
<!--                <li><a href="class_science.php" class="sidebar-link --><?php //echo $current_dropdown === 'quiz' ? 'active-item' : ''; ?><!--">Activities, Others</a></li>-->
<!--            </ul>-->
<!--            --><?php //}}?>
            <a href="#" class="sidebar-link logout"  onclick="logout()">Logout</a>
        </div>
    </div>

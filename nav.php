
    <nav>
        <div class="menu-icon" onclick="toggleSidenav()" >
            &#9776;
        </div>
        <div class="logo">
            <img src="../../common/images/logo/lpu-logo.png" alt="Logo" style="width: 10rem;height: 5rem">
        </div>
        <div class="search-container">
            <input type="text">
            <img src="../../common/images/logo/magnifier.svg" width="20px" height="20px">
        </div>
        <div class="nav-profile">
            <img src="../../common/images/logo/circle-account.svg" onclick="toggleDropdown()">
            <!-- Dropdown menu -->
            <div class="dropdown-menu" id="profileDropdown">
<!--                <a href="#">Profile</a>-->
<!--                <div class="divider"></div>-->
<!--                <a href="#">Settings</a>-->
<!--                <div class="divider"></div> -->
                <a href="#" onclick="logout()">Logout</a>
            </div>
        </div>
    </nav>

    <div class="sidenav">
        <div class="sidenav-item">
            <a class="sidebar-link <?php echo $current_page === 'college' ? 'active-item' : ''; ?>" href="college.php" style="color: white">College</a>
            <a class="sidebar-link <?php echo $current_page === 'accounts' ? 'active-item' : ''; ?>" href="accounts.php" style="color: white">Accounts</a>
            <?php if ($current_page !== 'college') { ?>
                <ul class="dropdown-container">
                    <li><a href="student_account.php" class="sidebar-link <?php echo $current_dropdown === 'student' ? 'active-item' : ''; ?>">Student</a></li>
                    <li><a href="teacher_account.php" class="sidebar-link <?php echo $current_dropdown === 'teacher' ? 'active-item' : ''; ?>">Teacher</a></li>
                </ul>
            <?php }?>
        </div>
    </div>

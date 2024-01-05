function toggleSidenav() {
    const sidenav = document.querySelector('.sidenav');
    const accountContainer = document.querySelector('.main-account');
    const collegeContainer = document.querySelector('.college-container');
    const classContainer = document.querySelector('.class-container');
    const teacherContainer = document.querySelector('.class-teacher-container');
    const joinClassContainer = document.querySelector('.join-class-container');
    const actContainer = document.querySelector('.act-container');
    const monitoringContainer = document.querySelector('.monitoring-container');
    const classButtonContent = document.querySelector('.class-button-content');
    const joinButtonContent = document.querySelector('.join-button-content');
    const adminStudentContainer = document.querySelector('.admin-student-container');
    const adminTeacherContainer = document.querySelector('.admin-teacher-container');
    const buttonContent = document.querySelector('.account-button-content');
    const assessmentStudent = document.querySelector('.assessment-container');
    const studentAttendance = document.querySelector('.attendance-container');
    const studentExam = document.querySelector('.exam-container');
    // Toggle the 'hide' class on the sidebar
    sidenav.classList.toggle('hide');


    // Adjust the left margin of the content based on sidebar visibility
    if(accountContainer){
        // const buttonContainer = document.querySelector('.account-button-content');
        // buttonContainer.classList.toggle('hide');
        accountContainer.classList.toggle('hide');
        if (sidenav.classList.contains('hide')) {
            accountContainer.style.marginLeft = '0';
            buttonContent.style.gap = '330px';
        } else {
            accountContainer.style.marginLeft = '400px'; // Adjust to match the sidebar width
            buttonContent.style.gap = '725px';
        }
    }

    if(adminStudentContainer){
        adminStudentContainer.classList.toggle('hide');
        if (sidenav.classList.contains('hide')) {
            adminStudentContainer.style.marginLeft = '0';
        } else {
            adminStudentContainer.style.marginLeft = '400px'; // Adjust to match the sidebar width
        }
    }

    if(adminTeacherContainer){
        adminTeacherContainer.classList.toggle('hide');
        if (sidenav.classList.contains('hide')) {
            adminTeacherContainer.style.marginLeft = '0';
        } else {
            adminTeacherContainer.style.marginLeft = '400px'; // Adjust to match the sidebar width
        }
    }


    if(collegeContainer){
        collegeContainer.classList.toggle('hide');
        if (sidenav.classList.contains('hide')) {
            collegeContainer.style.marginLeft = '0';
        } else {
            collegeContainer.style.marginLeft = '400px';
        }
    }

    if(classButtonContent){
        classButtonContent.classList.toggle('hide');
        if (sidenav.classList.contains('hide')) {
            classButtonContent.style.gap = '310px';
        } else {
            classButtonContent.style.gap = '725px';
        }
    }

    if(classContainer){
        if (sidenav.classList.contains('hide')) {
            classContainer.style.marginLeft = '0';
        } else {
            classContainer.style.marginLeft = '400px'; // Adjust to match the sidebar width
        }
    }

    if(teacherContainer){
        if (sidenav.classList.contains('hide')) {
            classButtonContent.style.gap = '310px';
            teacherContainer.style.marginLeft = '0';
        } else {
            teacherContainer.style.marginLeft = '330px'; // Adjust to match the sidebar width
            classButtonContent.style.gap = '725px';
        }
    }

    if(joinClassContainer){
        if (sidenav.classList.contains('hide')) {
            joinButtonContent.style.gap = '310px';
            joinClassContainer.style.marginLeft = '0';
        } else {
            joinClassContainer.style.marginLeft = '330px'; // Adjust to match the sidebar width
            joinButtonContent.style.gap = '725px';
        }
    }

    if(actContainer) {
        if (sidenav.classList.contains('hide')) {
            actContainer.style.marginLeft = '0';
        } else {
            actContainer.style.marginLeft = '330px'; // Adjust to match the sidebar width
        }
    }

    if(monitoringContainer){
        if (sidenav.classList.contains('hide')) {
            monitoringContainer.style.marginLeft = '0';
        } else {
            monitoringContainer.style.marginLeft = '330px'; // Adjust to match the sidebar width
        }
    }

    if(assessmentStudent){
        if (sidenav.classList.contains('hide')) {
            assessmentStudent.style.marginLeft = '0';
        } else {
            assessmentStudent.style.marginLeft = '330px'; // Adjust to match the sidebar width
        }
    }

    if(studentAttendance){
        if (sidenav.classList.contains('hide')) {
            studentAttendance.style.marginLeft = '0';
        } else {
            studentAttendance.style.marginLeft = '330px'; // Adjust to match the sidebar width
        }
    }

    if(studentExam){
        if (sidenav.classList.contains('hide')) {
            studentExam.style.marginLeft = '0';
        } else {
            studentExam.style.marginLeft = '330px'; // Adjust to match the sidebar width
        }
    }
}

function toggleDropdown() {
    const dropdown = document.getElementById('profileDropdown');
    dropdown.classList.toggle('show');
}

// Event listener to close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('profileDropdown');
    const profileImage = document.getElementById('toggleLogout');

    if (event.target !== dropdown && event.target !== profileImage) {
        dropdown.classList.remove('show');
    }
});

function toggleNotif() {
    var dropdown = document.getElementById('notificationDropdown');
    if (window.getComputedStyle(dropdown).display === 'none') {
        dropdown.style.display = 'block';
    } else {
        dropdown.style.display = 'none';
    }
}


var notification = document.querySelector('.notification');

if (notification) {
    document.addEventListener('click', function(event) {
        var dropdown = document.getElementById('notificationDropdown');
        if (event.target !== notification && !notification.contains(event.target)) {
            dropdown.style.display = 'none';
        }
    });
}
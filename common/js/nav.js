function toggleSidenav() {
    const sidenav = document.querySelector('.sidenav');
    const accountContainer = document.querySelector('.main-account');
    const adminStudentContainer = document.querySelector('.admin-student-container');
    // Toggle the 'hide' class on the sidebar
    sidenav.classList.toggle('hide');


    // Adjust the left margin of the content based on sidebar visibility
    if(accountContainer){
        const buttonContainer = document.querySelector('.account-button-content');
        buttonContainer.classList.toggle('hide');
        if (sidenav.classList.contains('hide')) {
            accountContainer.style.marginLeft = '0';
        } else {
            accountContainer.style.marginLeft = '400px'; // Adjust to match the sidebar width
        }
    }
    if(adminStudentContainer){
        if (sidenav.classList.contains('hide')) {
            adminStudentContainer.style.marginLeft = '0';
        } else {
            adminStudentContainer.style.marginLeft = '400px'; // Adjust to match the sidebar width
        }
    }
}


function toggleDropdown() {
    const dropdown = document.getElementById('profileDropdown');
    dropdown.classList.toggle('show');
}
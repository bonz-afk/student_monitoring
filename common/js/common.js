function isSecondYearGreaterThanFirst(dateRange) {
    // Split the date range string into two years
    const years = dateRange.split('-');

    if (years.length === 2) {
        // Parse the years as integers
        const firstYear = parseInt(years[0], 10);
        const secondYear = parseInt(years[1], 10);

        // Check if the second year is greater than the first year
        return secondYear > firstYear;
    }

    // Return false if the date range is not in the expected format
    return false;
}
function validateEmail(email) {
    // Regular expression for a valid email address
    const emailRegex = /^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/;

    // Test the email against the regex pattern
    return emailRegex.test(email);
}


const form = document.getElementById("loginForm");
const form2 = document.getElementById("signupForm");
if(form){
    form.addEventListener("keydown", function (event) {
        if (event.key === "Enter") {
            // Prevent the default form submission
            event.preventDefault();
            // Trigger the click event of the button
            const button = document.querySelector(".btn-login");
            button.click();
        }
    });
}
if(form2){
    form2.addEventListener("keydown", function (event) {
        if (event.key === "Enter") {
            // Prevent the default form submission
            event.preventDefault();
            // Trigger the click event of the button
            const button = document.querySelector(".btn-signup");
            button.click();
        }
    });
}

function loginForm (id){
    const url = "api/login.php";
    const emailMessage = document.querySelector('.email-message');
    const passwordMessage = document.querySelector('.password-message');

    let validEmail = 0;
    let validPass = 0;

    if($("#email").val() === "" || $("#email").val() === undefined){
        emailMessage.textContent = 'Email is Required';
        emailMessage.removeAttribute('hidden');
        emailMessage.classList.remove('valid');
        emailMessage.classList.add('error');

        validEmail = 0;

    } else if (!validateEmail($("#email").val())) {
        emailMessage.textContent = 'Invalid Email';
        emailMessage.removeAttribute('hidden');
        emailMessage.classList.remove('valid');
        emailMessage.classList.add('error');

        validEmail = 0;

    } else {
        emailMessage.classList.remove('error');
        emailMessage.classList.add('valid');
        emailMessage.textContent = 'Valid Email';
        // emailMessage.setAttribute('hidden', 'true');
        validEmail = 1;
    }

    if($("#password").val() === ""){
        passwordMessage.textContent = 'Password is Required';
        passwordMessage.removeAttribute('hidden');
        passwordMessage.classList.remove('valid');
        passwordMessage.classList.add('error');

        validPass = 0

    } else if($("#password").val().length <= 3){
        passwordMessage.textContent = 'Password must be greater than 3';
        passwordMessage.removeAttribute('hidden');
        passwordMessage.classList.remove('valid');
        passwordMessage.classList.add('error');

        validPass = 0
    }
    else{
        passwordMessage.classList.remove('error');
        passwordMessage.classList.add('valid');
        passwordMessage.textContent = 'Valid Password';
        // emailMessage.setAttribute('hidden', 'true');
        validPass = 1;
    }

    if(validEmail === 1 && validPass === 1){
        Swal.fire({
            title: 'Auto close alert!',
            html: 'Logging Account',
            timer: 1000,
            allowOutsideClick: false,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
            }
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                $.ajax({
                    url: url,
                    method: "POST",
                    data: {
                        email: $("#email").val(),
                        password: $("#password").val(),
                    },
                    success: function (data) {
                        const parsedData = JSON.parse(data); // Parse the response as JSON
                           if (parsedData.status === false) {
                               Swal.fire({
                                   icon: 'error',
                                   title: ''+parsedData.message,
                               })

                           } else {
                               if(parsedData.role === 'ADMIN'){
                                   window.location.href = 'http://localhost/student_monitoring/pages/admin/college.php';
                               }else if(parsedData.role === 'STUDENT'){
                                   window.location.href = 'http://localhost/student_monitoring/pages/student';
                               }else{
                                   window.location.href =  'http://localhost/student_monitoring/pages/teacher';
                               }
                           }

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error("AJAX Error:", textStatus, errorThrown);
                    }
                });
            }
        })

    }
}

function showCourse(id,college){
    $.ajax({
        type: 'POST',
        url: 'http://localhost/student_monitoring/api/CourseShow.php',
        data: { courseID: id, collegeID: college },
        success: function (data) {
            const parsedData = JSON.parse(data); // Parse the response as JSON
            if (parsedData.status && parsedData.courseData.length > 0) {
                const courseID = parsedData.courseData[0].ID;
                const courseCode = parsedData.courseData[0].COURSE_CODE;
                const courseDesc = parsedData.courseData[0].COURSE_DESC;

                $("#course_id").val(courseID);
                $("#course_code_edit").val(courseCode);
                $("#course_desc_edit").val(courseDesc);

            } else {
                Swal.fire({
                    icon: 'error',
                    title: ''+parsedData.message,
                })
            }
        },
        error: function () {
            console.error('An error occurred during the Ajax request.');
        }
    });
}

function courseProcess(process,id){
    const url = "http://localhost/student_monitoring/api/Course.php";

    if(process === 'add'){
        const codeMessage = document.querySelector('.code-message');
        const descMessage = document.querySelector('.desc-message');

        let validCode = 0;
        let validDesc = 0;

        if($("#add_course_code").val() === "" || $("#add_course_code").val() === undefined){
            codeMessage.textContent = 'Course Code is Required';
            codeMessage.removeAttribute('hidden');
            codeMessage.classList.remove('valid');
            codeMessage.classList.add('error');

            validCode = 0;

        }else if($("#add_course_code") > 255){
            codeMessage.textContent = 'Course Code Maximum input 255';
            codeMessage.removeAttribute('hidden');
            codeMessage.classList.remove('valid');
            codeMessage.classList.add('error');

            validCode = 0;
        }else{
            codeMessage.classList.remove('error');
            codeMessage.classList.add('valid');
            codeMessage.textContent = 'Valid Course Code';
            // emailMessage.setAttribute('hidden', 'true');
            validCode = 1;
        }

        if($("#add_course_desc").val() === "" || $("#add_course_desc").val() === undefined){
            descMessage.textContent = 'Course Description is Required';
            descMessage.removeAttribute('hidden');
            descMessage.classList.remove('valid');
            descMessage.classList.add('error');

            validDesc = 0;

        }else if($("#add_course_desc") > 255){
            descMessage.textContent = 'Course Description Maximum input 255';
            descMessage.removeAttribute('hidden');
            descMessage.classList.remove('valid');
            descMessage.classList.add('error');

            validDesc = 0;
        }else{
            descMessage.classList.remove('error');
            descMessage.classList.add('valid');
            descMessage.textContent = 'Valid Course Desc';
            // emailMessage.setAttribute('hidden', 'true');
            validDesc = 1;
        }

        if(validCode === 1 && validDesc === 1){
            Swal.fire({
                title: 'Adding Course!',
                html: 'Processing',
                timer: 1000,
                allowOutsideClick: false,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    $.ajax({
                        url: url,
                        method: "POST",
                        data: {
                            process: process,
                            course_code: $("#add_course_code").val(),
                            course_desc: $("#add_course_desc").val(),
                            college_id: $("#college_id").val(),
                        },
                        success: function (data) {
                            const parsedData = JSON.parse(data); // Parse the response as JSON
                            if (!parsedData.status) {
                                Swal.fire({
                                    icon: 'error',
                                    title: ''+parsedData.message,
                                })

                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: ''+parsedData.message,
                                    confirmButtonText: 'Close',
                                    allowOutsideClick: false,
                                }).then((result) => {
                                    /* Read more about isConfirmed, isDenied below */
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                })
                            }

                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.error("AJAX Error:", textStatus, errorThrown);
                        }
                    });
                }
            })
        }
    }

    else if(process === 'edit'){
        const codeMessageEdit = document.querySelector('.code-message-edit');
        const descMessageEdit = document.querySelector('.desc-message-edit');

        let validCodeEdit = 0;
        let validDescEdit = 0;

        if($("#course_code_edit").val() === "" || $("#course_code_edit").val() === undefined){
            codeMessageEdit.textContent = 'Course Code is Required';
            codeMessageEdit.removeAttribute('hidden');
            codeMessageEdit.classList.remove('valid');
            codeMessageEdit.classList.add('error');

            validCodeEdit = 0;

        }else if($("#course_code_edit").length > 255){
            codeMessageEdit.textContent = 'Course Code Maximum input 255';
            codeMessageEdit.removeAttribute('hidden');
            codeMessageEdit.classList.remove('valid');
            codeMessageEdit.classList.add('error');

            validCodeEdit = 0;
        }else{
            codeMessageEdit.classList.remove('error');
            codeMessageEdit.classList.add('valid');
            codeMessageEdit.textContent = 'Valid Course Code';
            // emailMessage.setAttribute('hidden', 'true');
            validCodeEdit = 1;
        }

        if($("#course_desc_edit").val() === "" || $("#course_desc_edit").val() === undefined){
            descMessageEdit.textContent = 'Course Code is Required';
            descMessageEdit.removeAttribute('hidden');
            descMessageEdit.classList.remove('valid');
            descMessageEdit.classList.add('error');

            validDescEdit = 0;

        }else if($("#course_desc_edit").length > 255){
            descMessageEdit.textContent = 'Course Code Maximum input 255';
            descMessageEdit.removeAttribute('hidden');
            descMessageEdit.classList.remove('valid');
            descMessageEdit.classList.add('error');

            validDescEdit = 0;
        }else{
            descMessageEdit.classList.remove('error');
            descMessageEdit.classList.add('valid');
            descMessageEdit.textContent = 'Valid Course Code';
            // emailMessage.setAttribute('hidden', 'true');
            validDescEdit = 1;
        }

        if(validCodeEdit === 1 && validDescEdit === 1){
            Swal.fire({
                title: 'Editing Course!',
                html: 'Processing',
                timer: 1000,
                allowOutsideClick: false,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    $.ajax({
                        url: url,
                        method: "POST",
                        data: {
                            process: process,
                            course_id: $("#course_id").val(),
                            course_code: $("#course_code_edit").val(),
                            course_desc: $("#course_desc_edit").val(),
                        },
                        success: function (data) {
                            const parsedData = JSON.parse(data); // Parse the response as JSON
                            if (!parsedData.status) {
                                Swal.fire({
                                    icon: 'error',
                                    title: ''+parsedData.message,
                                })

                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: ''+parsedData.message,
                                    confirmButtonText: 'Close',
                                    allowOutsideClick: false,
                                }).then((result) => {
                                    /* Read more about isConfirmed, isDenied below */
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                })
                            }

                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.error("AJAX Error:", textStatus, errorThrown);
                        }
                    });
                }
            })
        }
    }

    else if(process === 'delete'){
        Swal.fire({
            title: 'Do you want to delete this Course?',
            showDenyButton: true,
            confirmButtonText: 'Save',
            denyButtonText: `Don't save`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleting Course!',
                    html: 'Processing',
                    timer: 1000,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        $.ajax({
                            url: url,
                            method: "POST",
                            data: {
                                process: process,
                                course_id: id,
                            },
                            success: function (data) {
                                const parsedData = JSON.parse(data); // Parse the response as JSON
                                if (!parsedData.status) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: ''+parsedData.message,
                                    })

                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: ''+parsedData.message,
                                        confirmButtonText: 'Close',
                                        allowOutsideClick: false,
                                    }).then((result) => {
                                        /* Read more about isConfirmed, isDenied below */
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    })
                                }

                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.error("AJAX Error:", textStatus, errorThrown);
                            }
                        });
                    }
                })
            }
        });
    }
    else{
        Swal.fire({
            icon: 'error',
            title: 'Invalid Process',
        })
    }
}

function signUpProcess(){
    const url = "http://localhost/student_monitoring/api/Signup.php";
    const fnameMessage = document.querySelector('.fname-message');
    const mnameMessage = document.querySelector('.mname-message');
    const lnameMessage = document.querySelector('.lname-message');
    const emailMessage = document.querySelector('.email-message');
    const typeMessage = document.querySelector('.type-message');
    const passMessage = document.querySelector('.pass-message');
    let validation = 0;
    let validFname = 0;
    let validMname = 0;
    let validLname = 0;
    let validEmail = 0;
    let validType = 0;
    let validPassword = 0;

    if($("#fname").val() == '' || $("#fname").val() == undefined){
        fnameMessage.textContent = 'First Name is Required';
        fnameMessage.removeAttribute('hidden');
        fnameMessage.classList.remove('valid');
        fnameMessage.classList.add('error');

        validFname = 0;
    }else if($("#fname").val().length > 30){
        fnameMessage.textContent = 'First Name Maximum 30';
        fnameMessage.removeAttribute('hidden');
        fnameMessage.classList.remove('valid');
        fnameMessage.classList.add('error');

        validFname = 0;
    }else{
        fnameMessage.classList.remove('error');
        fnameMessage.classList.add('valid');
        fnameMessage.textContent = 'Valid First Name';
        // emailMessage.setAttribute('hidden', 'true');
        validFname = 1;
    }

    if($("#mname").val() != "" && $("#mname").val().length > 30){
        mnameMessage.textContent = 'First Name Maximum 30';
        mnameMessage.removeAttribute('hidden');
        mnameMessage.classList.remove('valid');
        mnameMessage.classList.add('error');

        validMname = 0;
    }else{
        if($("#mname").val() != ""){
            mnameMessage.classList.remove('error');
            mnameMessage.classList.add('valid');
            mnameMessage.textContent = 'Valid Middle Name';
            // emailMessage.setAttribute('hidden', 'true');
            validMname = 1;
        }else {
            mnameMessage.classList.remove('error');
            mnameMessage.classList.add('valid');
            mnameMessage.textContent = '';
            validMname = 1;
        }
    }

    if($("#lname").val() == '' || $("#lname").val() == undefined){
        lnameMessage.textContent = 'Last Name is Required';
        lnameMessage.removeAttribute('hidden');
        lnameMessage.classList.remove('valid');
        lnameMessage.classList.add('error');

        validLname = 0;
    }else if($("#lname").val().length > 30){
        lnameMessage.textContent = 'Last Name Maximum 30';
        lnameMessage.removeAttribute('hidden');
        lnameMessage.classList.remove('valid');
        lnameMessage.classList.add('error');

        validLname = 0;
    }else{
        lnameMessage.classList.remove('error');
        lnameMessage.classList.add('valid');
        lnameMessage.textContent = 'Valid Last Name';
        // emailMessage.setAttribute('hidden', 'true');
        validLname = 1;
    }

    if($("#email").val() == '' || $("#email").val() == undefined){
        emailMessage.textContent = 'Email is Required';
        emailMessage.removeAttribute('hidden');
        emailMessage.classList.remove('valid');
        emailMessage.classList.add('error');

        validEmail = 0;
    }else if($("#email").val().length > 30){
        emailMessage.textContent = 'Email Maximum 30';
        emailMessage.removeAttribute('hidden');
        emailMessage.classList.remove('valid');
        emailMessage.classList.add('error');

        validEmail = 0;
    }else if(!validateEmail($("#email").val())){
        emailMessage.textContent = 'Invalid Email';
        emailMessage.removeAttribute('hidden');
        emailMessage.classList.remove('valid');
        emailMessage.classList.add('error');

        validEmail = 0;
    }else{
        emailMessage.classList.remove('error');
        emailMessage.classList.add('valid');
        emailMessage.textContent = 'Valid Email';
        // emailMessage.setAttribute('hidden', 'true');
        validEmail = 1;
    }

    if($("#type").val() == '' || $("#type").val() == undefined){
        typeMessage.textContent = 'Type is Required';
        typeMessage.removeAttribute('hidden');
        typeMessage.classList.remove('valid');
        typeMessage.classList.add('error');

        validType = 0;
    }else{
        typeMessage.classList.remove('error');
        typeMessage.classList.add('valid');
        typeMessage.textContent = 'Valid Type';
        // emailMessage.setAttribute('hidden', 'true');
        validType = 1;
    }

    if($("#password").val() == '' || $("#password").val() == undefined){
        passMessage.textContent = 'Password is Required';
        passMessage.removeAttribute('hidden');
        passMessage.classList.remove('valid');
        passMessage.classList.add('error');

        validPassword = 0;
    }else if($("#password").val().length > 30){
        passMessage.textContent = 'Password Maximum 30';
        passMessage.removeAttribute('hidden');
        passMessage.classList.remove('valid');
        passMessage.classList.add('error');

        validPassword = 0;
    }else{
        passMessage.classList.remove('error');
        passMessage.classList.add('valid');
        passMessage.textContent = 'Valid Password';
        // emailMessage.setAttribute('hidden', 'true');
        validPassword = 1;
    }

    if(validFname === 1 && validMname === 1 && validLname && validEmail === 1 &&  validType === 1 && validPassword === 1){
        validation = 1;
    }
    if(validation === 1){
        Swal.fire({
            title: 'Auto close alert!',
            html: 'Adding Account',
            timer: 1000,
            allowOutsideClick: false,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
            }
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                $.ajax({
                    url: url,
                    method: "POST",
                    data: {
                        email: $("#email").val(),
                        password: $("#password").val(),
                        type: $("#type").val(),
                        fname: $("#fname").val(),
                        mname: $("#mname").val(),
                        lname: $("#lname").val(),

                    },
                    success: function (data) {
                        const parsedData = JSON.parse(data); // Parse the response as JSON
                        if (parsedData.status === false) {
                            Swal.fire({
                                icon: 'error',
                                title: ''+parsedData.message,
                            })

                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: ''+parsedData.message,
                                confirmButtonText: 'Close',
                                allowOutsideClick: false,
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    window.location.href = 'http://localhost/student_monitoring/login.php';
                                }
                            })

                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error("AJAX Error:", textStatus, errorThrown);
                    }
                });
            }
        })
    }
}

function adminStudentProcess(process,id){
    const url = "http://localhost/student_monitoring/api/AdminStudent.php";
    if(process == 'delete'){
        Swal.fire({
            title: 'Do you want to delete this Student?',
            showDenyButton: true,
            confirmButtonText: 'Save',
            denyButtonText: `Don't save`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleting Student!',
                    html: 'Processing',
                    timer: 1000,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        $.ajax({
                            url: url,
                            method: "POST",
                            data: {
                                process: process,
                                id: id,
                            },
                            success: function (data) {
                                const parsedData = JSON.parse(data); // Parse the response as JSON
                                if (!parsedData.status) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: ''+parsedData.message,
                                    })

                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: ''+parsedData.message,
                                        confirmButtonText: 'Close',
                                        allowOutsideClick: false,
                                    }).then((result) => {
                                        /* Read more about isConfirmed, isDenied below */
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    })
                                }

                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.error("AJAX Error:", textStatus, errorThrown);
                            }
                        });
                    }
                })
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    }

    if(process == 'view') {
        var tableBody = $(".admin-student-table-data tbody");
        const fullval = $("#fullval"+id).data('fullname');
        let selectYear = $("#student-account-select").val();
       $("#student_id").val(id);
        tableBody.empty();

        $.ajax({
           url: url,
           method: "GET",
            data: {process: process,id: id, academic: ''},
           success: function (data){

               if (data[0] && data[0].fullname) {
                   var fullname = data[0].fullname;
                   // Display the fullname if it has data
                   $("#student_name").text(fullname);
               }else{
                   $("#student_name").text(fullval);
               }
               if (Array.isArray(data) && data.length > 0) {
                   $.each(data, function (index, item) {
                       var row = $("<tr>");
                       row.html(
                           '<td>' + item.CLASS_NAME + '</td>' +
                           '<td>' + item.COURSE_DESC + '</td>' +
                           '<td>' +
                           // Add any additional table columns here if needed
                           '</td>'
                       );
                       tableBody.append(row);
                   });
               } else {
                   tableBody.html("No data available.");
               }
           }
        });
    }
}

function adminTeacherProcess(process,id){
    const url = "http://localhost/student_monitoring/api/AdminTeacher.php";
    if(process == 'delete'){
        Swal.fire({
            title: 'Do you want to delete this Teacher?',
            showDenyButton: true,
            confirmButtonText: 'Save',
            denyButtonText: `Don't save`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleting Teacher!',
                    html: 'Processing',
                    timer: 1000,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        $.ajax({
                            url: url,
                            method: "POST",
                            data: {
                                process: process,
                                id: id,
                            },
                            success: function (data) {
                                const parsedData = JSON.parse(data); // Parse the response as JSON
                                if (!parsedData.status) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: ''+parsedData.message,
                                    })

                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: ''+parsedData.message,
                                        confirmButtonText: 'Close',
                                        allowOutsideClick: false,
                                    }).then((result) => {
                                        /* Read more about isConfirmed, isDenied below */
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    })
                                }

                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.error("AJAX Error:", textStatus, errorThrown);
                            }
                        });
                    }
                })
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    }

    if(process == 'view') {
        var tableBody = $(".admin-teacher-table-data tbody");
        const fullval = $("#fullteacher"+id).data('teachername');
        let selectYear = $("#teacher-account-select").val();
        $("#teacher_id").val(id);
        tableBody.empty();

        $.ajax({
            url: url,
            method: "GET",
            data: {process: process,id: id, academic: ''},
            success: function (data){

                if (data[0] && data[0].fullname) {
                    var fullname = data[0].fullname;
                    // Display the fullname if it has data
                    $("#teacher_name").text(fullname);
                }else{
                    $("#teacher_name").text(fullval);
                }
                if (Array.isArray(data) && data.length > 0) {
                    $.each(data, function (index, item) {
                        var row = $("<tr>");
                        row.html(
                            '<td>' + item.CLASS_NAME + '</td>' +
                            '<td>' + item.COURSE_DESC + '</td>' +
                            '<td>' +
                            // Add any additional table columns here if needed
                            '</td>'
                        );
                        tableBody.append(row);
                    });
                } else {
                    tableBody.html("No data available.");
                }
            }
        });
    }
}

function academicYear(process,type){
    const url_student = "http://localhost/student_monitoring/api/AdminStudent.php";
    const url_teacher = "http://localhost/student_monitoring/api/AdminTeacher.php";

    if(type === 'student'){
        var tableBody = $(".admin-student-table-data tbody");
        var id = $("#student_id").val();
        let selectYear = $("#student-account-select").val();

        tableBody.empty();

        $.ajax({
            url: url_student,
            method: "GET",
            data: {process: process,id: id, academic: selectYear},
            success: function (data){
                var fullname = data[0] ? data[0].fullname : undefined;

                if (fullname !== '' && fullname !== undefined) {
                    $("#student_name").text(fullname);
                } else {
                    var dataFullname = $("#student_name").data("fullname");
                    if (dataFullname) {
                        $("#student_name").text(dataFullname);
                    }
                }
                if (Array.isArray(data) && data.length > 0) {
                    $.each(data, function (index, item) {
                        var row = $("<tr>");
                        row.html(
                            '<td>' + item.CLASS_NAME + '</td>' +
                            '<td>' + item.COURSE_DESC + '</td>' +
                            '<td>' +
                            // Add any additional table columns here if needed
                            '</td>'
                        );
                        tableBody.append(row);
                    });
                } else {
                    const fullval = $("#fullval").data('fullname');
                    $("#student_name").text(fullval);
                    tableBody.html("No data available.");
                }
            }
        });
    }

    if(type === 'teacher'){
        var tableBody = $(".admin-teacher-table-data tbody");
        var id = $("#teacher_id").val();
        let selectYear = $("#teacher-account-select").val();

        tableBody.empty();

        $.ajax({
            url: url_teacher,
            method: "GET",
            data: {process: process,id: id, academic: selectYear},
            success: function (data){
                var fullname = data[0] ? data[0].fullname : undefined;

                if (fullname !== '' && fullname !== undefined) {
                    $("#student_name").text(fullname);
                } else {
                    var dataFullname = $("#teacher_name").data("teachername");
                    if (dataFullname) {
                        $("#teacher_name").text(dataFullname);
                    }
                }
                if (Array.isArray(data) && data.length > 0) {
                    $.each(data, function (index, item) {
                        var row = $("<tr>");
                        row.html(
                            '<td>' + item.CLASS_NAME + '</td>' +
                            '<td>' + item.COURSE_DESC + '</td>' +
                            '<td>' +
                            // Add any additional table columns here if needed
                            '</td>'
                        );
                        tableBody.append(row);
                    });
                } else {
                    const fullval = $("#fullteacher").data('teachername');
                    $("#teacher_name").text(fullval);
                    tableBody.html("No data available.");
                }
            }
        });
    }
}

function logout(){
    Swal.fire({
        title: 'Logging Out!',
        html: 'Processing',
        timer: 1000,
        allowOutsideClick: false,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading()
        }
    }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
           window.location.href = 'http://localhost/student_monitoring/logout.php';
        }
    })
}

function  createClass(process,id) {

    const url = "http://localhost/student_monitoring/api/Class.php";


    if (process === 'add') {
        let validAcademic = 0;
        let validClassName = 0
        let validProgram = 0;
        let validSemester = 0;
        let validYear = 0;
        let validCourse = 0;
        let validSection = 0;
        let validType = 0;
        let validSchedule = 0;
        let validTime = 0;


        const createAcademicMessage = document.querySelector('.message-class-academic-year');
        const createClassName = document.querySelector('.message-className');
        const programMessage = document.querySelector('.message-program');
        const semesterMessage = document.querySelector('.message-semester');
        const yearMessage = document.querySelector('.message-year');
        const courseMessage = document.querySelector('.message-course');
        const sectionMessage = document.querySelector('.message-section');
        const typeMessage = document.querySelector('.message-type');
        const scheduleMessage = document.querySelector('.message-schedule');
        const timeMessage = document.querySelector('.message-time');
        const checkBoxes = document.querySelectorAll('.checkBoxes');
        const amTimeInput = document.getElementById('am');
        const pmTimeInput = document.getElementById('pm');

        Swal.fire({
            title: 'Do you want to add this Class?',
            showDenyButton: true,
            confirmButtonText: 'Save',
            denyButtonText: `Don't save`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                    if($("#class-academic-year").val() === "" || $("#class-academic-year").val() === undefined){
                        createAcademicMessage.textContent = 'Academic Year is Required';
                        createAcademicMessage.removeAttribute('hidden');
                        createAcademicMessage.classList.remove('valid');
                        createAcademicMessage.classList.add('error');

                        validAcademic = 0;

                    }else if($("#class-academic-year").val().length > 255){
                            createAcademicMessage.textContent = 'Academic Year is too long';
                            createAcademicMessage.removeAttribute('hidden');
                            createAcademicMessage.classList.remove('valid');
                            createAcademicMessage.classList.add('error');

                            validAcademic = 0;

                    }else if(!isSecondYearGreaterThanFirst($("#class-academic-year").val())){
                        createAcademicMessage.textContent = 'The Second year should be Greater than the first one';
                        createAcademicMessage.removeAttribute('hidden');
                        createAcademicMessage.classList.remove('valid');
                        createAcademicMessage.classList.add('error');

                        validAcademic = 0;
                    }
                    else{
                        createAcademicMessage.classList.remove('error');
                        createAcademicMessage.classList.add('valid');
                        createAcademicMessage.textContent = 'Valid Academic Year';
                        validAcademic = 1;
                    }


                    if($("#className").val() === "" || $("#className").val() === undefined){
                        createClassName.textContent = 'Class Name is Required';
                        createClassName.removeAttribute('hidden');
                        createClassName.classList.remove('valid');
                        createClassName.classList.add('error');

                        validClassName = 0;

                    }else if($("#className").val().length > 255){
                        createClassName.textContent = 'Class Name is too long';
                        createClassName.removeAttribute('hidden');
                        createClassName.classList.remove('valid');
                        createClassName.classList.add('error');

                        validClassName = 0;

                    }else{
                        createClassName.classList.remove('error');
                        createClassName.classList.add('valid');
                        createClassName.textContent = 'Valid Class Name';
                        validClassName = 1;
                    }
                }

                    if($("#create-program").val() === "" || $("#create-program").val() === undefined){
                        programMessage.textContent = 'Program is Required';
                        programMessage.removeAttribute('hidden');
                        programMessage.classList.remove('valid');
                        programMessage.classList.add('error');

                        validProgram = 0;

                    }else{
                        programMessage.classList.remove('error');
                        programMessage.classList.add('valid');
                        programMessage.textContent = 'Valid Program';
                        validProgram = 1;
                    }

                    if($("#create-sem").val() === "" || $("#create-sem").val() === undefined){
                        semesterMessage.textContent = 'Semester is Required';
                        semesterMessage.removeAttribute('hidden');
                        semesterMessage.classList.remove('valid');
                        semesterMessage.classList.add('error');

                        validSemester = 0;

                    }else{
                        semesterMessage.classList.remove('error');
                        semesterMessage.classList.add('valid');
                        semesterMessage.textContent = 'Valid Semester';
                        validSemester = 1;
                    }

                    if($("#create-year").val() === "" || $("#create-year").val() === undefined){
                        yearMessage.textContent = 'Year is Required';
                        yearMessage.removeAttribute('hidden');
                        yearMessage.classList.remove('valid');
                        yearMessage.classList.add('error');

                        validYear = 0;

                    }else{
                        yearMessage.classList.remove('error');
                        yearMessage.classList.add('valid');
                        yearMessage.textContent = 'Valid Year';
                        validYear = 1;
                    }


                    if($("#create-course").val() === "" || $("#create-course").val() === undefined){
                        courseMessage.textContent = 'Course is Required';
                        courseMessage.removeAttribute('hidden');
                        courseMessage.classList.remove('valid');
                        courseMessage.classList.add('error');

                        validCourse = 0;

                    }else{
                        courseMessage.classList.remove('error');
                        courseMessage.classList.add('valid');
                        courseMessage.textContent = 'Valid Course';
                        validCourse = 1;
                    }

                    if($("#create-section").val() === "" || $("#create-section").val() === undefined){
                        sectionMessage.textContent = 'Section is Required';
                        sectionMessage.removeAttribute('hidden');
                        sectionMessage.classList.remove('valid');
                        sectionMessage.classList.add('error');

                        validSection = 0;

                    }else{
                        sectionMessage.classList.remove('error');
                        sectionMessage.classList.add('valid');
                        sectionMessage.textContent = 'Valid Section';
                        validSection = 1;
                    }

                    if($("#create-type").val() === "" || $("#create-type").val() === undefined){
                        typeMessage.textContent = 'Type is Required';
                        typeMessage.removeAttribute('hidden');
                        typeMessage.classList.remove('valid');
                        typeMessage.classList.add('error');

                        validType = 0;

                    }else{
                        typeMessage.classList.remove('error');
                        typeMessage.classList.add('valid');
                        typeMessage.textContent = 'Valid Type';
                        validType = 1;
                    }

                    let atLeastOneChecked = false;
                    checkBoxes.forEach(function (checkbox) {
                        if (checkbox.checked) {
                            atLeastOneChecked = true;
                        }
                    });

                    if (!atLeastOneChecked){
                        scheduleMessage.textContent = "Please select at least one day";
                        scheduleMessage.removeAttribute('hidden');
                        scheduleMessage.classList.remove('valid');
                        scheduleMessage.classList.add('error');
                        validSchedule = 0;
                    }else {
                        scheduleMessage.classList.remove('error');
                        scheduleMessage.classList.add('valid');
                        scheduleMessage.textContent = '    Valid Schedule';
                        validSchedule = 1;
                    }

                const amTime = new Date(`2000-01-01T${amTimeInput.value}`);
                const pmTime = new Date(`2000-01-01T${pmTimeInput.value}`);

                if (amTimeInput.value.trim() === '' || pmTimeInput.value.trim() === '') {
                    timeMessage.textContent = "The Time is Required";
                    timeMessage.removeAttribute('hidden');
                    timeMessage.classList.remove('valid');
                    timeMessage.classList.add('error');
                    validTime = 0
                } else {
                    const amTime = new Date(`2000-01-01T${amTimeInput.value}`);
                    const pmTime = new Date(`2000-01-01T${pmTimeInput.value}`);

                    if (amTime >= pmTime) {
                        timeMessage.textContent = "The AM time should be less than the PM time.";
                        timeMessage.removeAttribute('hidden');
                        timeMessage.classList.remove('valid');
                        timeMessage.classList.add('error');
                        validTime = 0
                    } else {
                        timeMessage.classList.remove('error');
                        timeMessage.classList.add('valid');
                        timeMessage.textContent = 'Valid Type';
                        timeMessage.textContent = "Valid Time.";
                        validTime = 1;
                    }
                }

                let validated = validAcademic === 1 && validClassName === 1 && validProgram === 1 && validSemester === 1 && validYear === 1 && validCourse === 1 && validSection === 1 && validType === 1 && validSchedule === 1 && validTime === 1 ? 1 : 0;

                if (validated === 1) {
                    Swal.fire({
                        title: 'Adding Class!',
                        html: 'Processing',
                        timer: 1000,
                        allowOutsideClick: false,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            $.ajax({
                                url: url,
                                method: "POST",
                                data: {
                                    process: process,
                                    college: $("#create-college").val(),
                                    academic: $("#class-academic-year").val(),
                                    class: $("#className").val(),
                                    program: $("#create-program").val(),
                                    semester: $("#create-sem").val(),
                                    year: $("#create-year").val(),
                                    course: $("#create-course").val(),
                                    section: $("#create-section").val(),
                                    type: $("#create-type").val(),
                                    monday: $("#monday").is(":checked") ? "ON" : "OFF",
                                    tuesday: $("#tuesday").is(":checked") ? "ON" : "OFF",
                                    wednesday: $("#wednesday").is(":checked") ? "ON" : "OFF",
                                    thursday: $("#thursday").is(":checked") ? "ON" : "OFF",
                                    friday: $("#friday").is(":checked") ? "ON" : "OFF",
                                    saturday: $("#saturday").is(":checked") ? "ON" : "OFF",
                                    am: $("#am").val(),
                                    pm: $("#pm").val(),
                                },
                                success: function (data) {
                                    const parsedData = JSON.parse(data); // Parse the response as JSON
                                    if (!parsedData.status) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: '' + parsedData.message,
                                        })

                                    } else {
                                        Swal.fire({
                                            icon: 'success',
                                            title: '' + parsedData.message,
                                            confirmButtonText: 'Close',
                                            allowOutsideClick: false,
                                        }).then((result) => {
                                            /* Read more about isConfirmed, isDenied below */
                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        })
                                    }

                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.error("AJAX Error:", textStatus, errorThrown);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'An error occurred while processing your request.',
                                    });
                                }
                            });
                        }
                    })
                }
        })
    }

    if (process == 'delete'){
        Swal.fire({
            title: 'Do you want to delete this Class?',
            showDenyButton: true,
            confirmButtonText: 'Save',
            denyButtonText: `Don't save`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleting Class!',
                    html: 'Processing',
                    timer: 1000,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        $.ajax({
                            url: url,
                            method: "POST",
                            data: {
                                process: process,
                                id: id,
                            },
                            success: function (data) {
                                const parsedData = JSON.parse(data); // Parse the response as JSON
                                if (!parsedData.status) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '' + parsedData.message,
                                    })

                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: '' + parsedData.message,
                                        confirmButtonText: 'Close',
                                        allowOutsideClick: false,
                                    }).then((result) => {
                                        /* Read more about isConfirmed, isDenied below */
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    })
                                }

                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.error("AJAX Error:", textStatus, errorThrown);
                            }
                        });
                    }
                })
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    }

    if (process == 'delete-enrolled'){
        Swal.fire({
            title: 'Do you want to delete this Student in this Class?',
            showDenyButton: true,
            confirmButtonText: 'Save',
            denyButtonText: `Don't save`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleting Student!',
                    html: 'Processing',
                    timer: 1000,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        $.ajax({
                            url: url,
                            method: "POST",
                            data: {
                                process: process,
                                id: id,
                            },
                            success: function (data) {
                                const parsedData = JSON.parse(data); // Parse the response as JSON
                                if (!parsedData.status) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '' + parsedData.message,
                                    })

                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: '' + parsedData.message,
                                        confirmButtonText: 'Close',
                                        allowOutsideClick: false,
                                    }).then((result) => {
                                        /* Read more about isConfirmed, isDenied below */
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    })
                                }

                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.error("AJAX Error:", textStatus, errorThrown);
                            }
                        });
                    }
                })
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    }

    if(process == 'view') {
        $.ajax({
            url: url,
            method: "GET",
            data: {
                process: process,
                id: id,
            },
            success: function (data){
                console.log(data);
                if (Array.isArray(data) && data.length > 0) {
                   $("#classId").val(data[0].id);
                   $("#update-create-type").val(data[0].TYPE);
                   $("#update-class-academic-year").val(data[0].ACADEMIC_YEAR);
                   $("#update-className").val(data[0].CLASS_NAME);
                   $("#update-create-program").val(data[0].PROGRAM);
                   $("#update-create-sem").val(data[0].SEMESTER);
                   $("#update-create-year").val(data[0].YEAR);
                   $("#update-create-course").val(data[0].COURSE_CODE);
                   $("#update-create-section").val(data[0].SECTION);
                   $("#checkbox").val(data[0].SECTION);
                    $("#update-monday").prop("checked", data[0].MONDAY === "ON" ? true : false);
                    $("#update-tuesday").prop("checked", data[0].TUESDAY === "ON" ? true : false);
                    $("#update-wednesday").prop("checked", data[0].WEDNESDAY === "ON" ? true : false);
                    $("#update-thursday").prop("checked", data[0].THURSDAY === "ON" ? true : false);
                    $("#update-friday").prop("checked", data[0].FRIDAY === "ON" ? true : false);
                    $("#update-saturday").prop("checked", data[0].SATURDAY === "ON" ? true : false);
                    $("#update-am").val(data[0].AM);
                    $("#update-pm").val(data[0].PM);
                } else {
                    console.log("No data available or 'id' not found in the response.");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
            }

        });
    }

    if(process == 'edit'){
        let validCollege = 0;
        let validAcademic = 0;
        let validClassName = 0
        let validProgram = 0;
        let validSemester = 0;
        let validYear = 0;
        let validCourse = 0;
        let validSection = 0;
        let validType = 0;
        let validSchedule = 0;
        let validTime = 0;


        const updateAcademicMessage = document.querySelector('.message-update-class-academic-year');
        const updateClassName = document.querySelector('.message-update-className');
        const programMessage = document.querySelector('.message-update-program');
        const semesterMessage = document.querySelector('.message-update-semester');
        const yearMessage = document.querySelector('.message-update-year');
        const courseMessage = document.querySelector('.message-update-course');
        const sectionMessage = document.querySelector('.message-update-section');
        const typeMessage = document.querySelector('.message-update-type');
        const scheduleMessage = document.querySelector('.message-update-schedule');
        const timeMessage = document.querySelector('.message-update-time');
        const checkBoxes = document.querySelectorAll('.checkBoxes-update');
        const amTimeInput = document.getElementById('update-am');
        const pmTimeInput = document.getElementById('update-pm');


        Swal.fire({
            title: 'Do you want to edit this Class?',
            showDenyButton: true,
            confirmButtonText: 'Save',
            denyButtonText: `Don't save`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                if($("#update-class-academic-year").val() === "" || $("#update-class-academic-year").val() === undefined){
                    updateAcademicMessage.textContent = 'Academic Year is Required';
                    updateAcademicMessage.removeAttribute('hidden');
                    updateAcademicMessage.classList.remove('valid');
                    updateAcademicMessage.classList.add('error');

                    validAcademic = 0;
                }
                else if($("#update-class-academic-year").val().length > 255){
                    updateAcademicMessage.textContent = 'Academic Year is too long';
                    updateAcademicMessage.removeAttribute('hidden');
                    updateAcademicMessage.classList.remove('valid');
                    updateAcademicMessage.classList.add('error');

                    validAcademic = 0;

                }else if(!isSecondYearGreaterThanFirst($("#update-class-academic-year").val())){
                    updateAcademicMessage.textContent = 'The Second year should be Greater than the first one';
                    updateAcademicMessage.removeAttribute('hidden');
                    updateAcademicMessage.classList.remove('valid');
                    updateAcademicMessage.classList.add('error');

                    validAcademic = 0;
                }
                else{
                    updateAcademicMessage.classList.remove('error');
                    updateAcademicMessage.classList.add('valid');
                    updateAcademicMessage.textContent = 'Valid Academic Year';
                    validAcademic = 1;
                }


                if($("#update-className").val() === "" || $("#update-className").val() === undefined){
                    updateClassName.textContent = 'Class Name is Required';
                    updateClassName.removeAttribute('hidden');
                    updateClassName.classList.remove('valid');
                    updateClassName.classList.add('error');

                    validClassName = 0;
                }
                else if($("#update-className").val().length > 255){
                    updateClassName.textContent = 'Class Name is too long';
                    updateClassName.removeAttribute('hidden');
                    updateClassName.classList.remove('valid');
                    updateClassName.classList.add('error');

                    validClassName = 0;
                }
                else{
                    updateClassName.classList.remove('error');
                    updateClassName.classList.add('valid');
                    updateClassName.textContent = 'Valid Class Name';
                    validClassName = 1;
                }


                if($("#update-create-program").val() === "" || $("#update-create-program").val() === undefined){
                    programMessage.textContent = 'Program is Required';
                    programMessage.removeAttribute('hidden');
                    programMessage.classList.remove('valid');
                    programMessage.classList.add('error');

                    validProgram = 0;

                }
                else{
                    programMessage.classList.remove('error');
                    programMessage.classList.add('valid');
                    programMessage.textContent = 'Valid Program';
                    validProgram = 1;
                }

                if($("#update-create-sem").val() === "" || $("#update-create-sem").val() === undefined){
                    semesterMessage.textContent = 'Semester is Required';
                    semesterMessage.removeAttribute('hidden');
                    semesterMessage.classList.remove('valid');
                    semesterMessage.classList.add('error');

                    validSemester = 0;

                }
                else{
                    semesterMessage.classList.remove('error');
                    semesterMessage.classList.add('valid');
                    semesterMessage.textContent = 'Valid Semester';
                    validSemester = 1;
                }

                if($("#update-create-year").val() === "" || $("#update-create-year").val() === undefined){
                    yearMessage.textContent = 'Year is Required';
                    yearMessage.removeAttribute('hidden');
                    yearMessage.classList.remove('valid');
                    yearMessage.classList.add('error');

                    validYear = 0;

                }
                else{
                    yearMessage.classList.remove('error');
                    yearMessage.classList.add('valid');
                    yearMessage.textContent = 'Valid Year';
                    validYear = 1;
                }


                if($("#update-create-course").val() === "" || $("#update-create-course").val() === undefined){
                    courseMessage.textContent = 'Course is Required';
                    courseMessage.removeAttribute('hidden');
                    courseMessage.classList.remove('valid');
                    courseMessage.classList.add('error');

                    validCourse = 0;

                }else{
                    courseMessage.classList.remove('error');
                    courseMessage.classList.add('valid');
                    courseMessage.textContent = 'Valid Course';
                    validCourse = 1;
                }

                if($("#update-create-section").val() === "" || $("#update-create-section").val() === undefined){
                    sectionMessage.textContent = 'Section is Required';
                    sectionMessage.removeAttribute('hidden');
                    sectionMessage.classList.remove('valid');
                    sectionMessage.classList.add('error');

                    validSection = 0;

                }else{
                    sectionMessage.classList.remove('error');
                    sectionMessage.classList.add('valid');
                    sectionMessage.textContent = 'Valid Section';
                    validSection = 1;
                }

                if($("#update-create-type").val() === "" || $("#update-create-type").val() === undefined){
                    typeMessage.textContent = 'Type is Required';
                    typeMessage.removeAttribute('hidden');
                    typeMessage.classList.remove('valid');
                    typeMessage.classList.add('error');

                    validType = 0;

                }else{
                    typeMessage.classList.remove('error');
                    typeMessage.classList.add('valid');
                    typeMessage.textContent = 'Valid Type';
                    validType = 1;
                }

                let atLeastOneChecked = false;
                checkBoxes.forEach(function (checkbox) {
                    if (checkbox.checked) {
                        atLeastOneChecked = true;
                    }
                });

                if (!atLeastOneChecked){
                    scheduleMessage.textContent = "Please select at least one day";
                    scheduleMessage.removeAttribute('hidden');
                    scheduleMessage.classList.remove('valid');
                    scheduleMessage.classList.add('error');
                    validSchedule = 0;
                }else {
                    scheduleMessage.classList.remove('error');
                    scheduleMessage.classList.add('valid');
                    scheduleMessage.textContent = '    Valid Schedule';
                    validSchedule = 1;
                }

                const amTime = new Date(`2000-01-01T${amTimeInput.value}`);
                const pmTime = new Date(`2000-01-01T${pmTimeInput.value}`);

                if (amTimeInput.value.trim() === '' || pmTimeInput.value.trim() === '') {
                    timeMessage.textContent = "The Time is Required";
                    timeMessage.removeAttribute('hidden');
                    timeMessage.classList.remove('valid');
                    timeMessage.classList.add('error');
                    validTime = 0
                } else {
                    const amTime = new Date(`2000-01-01T${amTimeInput.value}`);
                    const pmTime = new Date(`2000-01-01T${pmTimeInput.value}`);

                    if (amTime >= pmTime) {
                        timeMessage.textContent = "The AM time should be less than the PM time.";
                        timeMessage.removeAttribute('hidden');
                        timeMessage.classList.remove('valid');
                        timeMessage.classList.add('error');
                        validTime = 0
                    } else {
                        timeMessage.classList.remove('error');
                        timeMessage.classList.add('valid');
                        timeMessage.textContent = 'Valid Type';
                        timeMessage.textContent = "Valid Time.";
                        validTime = 1;
                    }
                }

                let validated = validAcademic === 1 && validClassName === 1 && validProgram === 1 && validSemester === 1 && validYear === 1 && validCourse === 1 && validSection === 1 && validType === 1 && validSchedule === 1 && validTime === 1 ? 1 : 0;

                if(validated === 1){
                    Swal.fire({
                        title: 'Editing Class!',
                        html: 'Processing',
                        timer: 1000,
                        allowOutsideClick: false,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            $.ajax({
                                url: url,
                                method: "POST",
                                data: {
                                    process: process,
                                    id: $("#classId").val(),
                                    academic: $("#update-class-academic-year").val(),
                                    class: $("#update-className").val(),
                                    program: $("#update-create-program").val(),
                                    semester: $("#update-create-sem").val(),
                                    year: $("#update-create-year").val(),
                                    course: $("#update-create-course").val(),
                                    section: $("#update-create-section").val(),
                                    type: $("#update-create-type").val(),
                                    monday: $("#update-monday").is(":checked") ? "ON" : "OFF",
                                    tuesday: $("#update-tuesday").is(":checked") ? "ON" : "OFF",
                                    wednesday: $("#update-wednesday").is(":checked") ? "ON" : "OFF",
                                    thursday: $("#update-thursday").is(":checked") ? "ON" : "OFF",
                                    friday: $("#update-friday").is(":checked") ? "ON" : "OFF",
                                    saturday: $("#update-saturday").is(":checked") ? "ON" : "OFF",
                                    am: $("#update-am").val(),
                                    pm: $("#update-pm").val(),
                                },
                                success: function (data) {
                                    const parsedData = JSON.parse(data); // Parse the response as JSON
                                    if (!parsedData.status) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: '' + parsedData.message,
                                        })

                                    } else {
                                        Swal.fire({
                                            icon: 'success',
                                            title: '' + parsedData.message,
                                            confirmButtonText: 'Close',
                                            allowOutsideClick: false,
                                        }).then((result) => {
                                            /* Read more about isConfirmed, isDenied below */
                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        })
                                    }

                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.error("AJAX Error:", textStatus, errorThrown);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'An error occurred while processing your request.',
                                    });
                                }
                            });
                        }
                    })
                }
            }
        })

    }

    if(process == 'student-class-science'){
        var tableBody = $(".class-student-list-table tbody");
        tableBody.empty();

        $.ajax({
            url: url,
            method: "GET",
            data: {process: process,id: id},
            success: function (data){

                var yearLevel = data[0].YEAR ? data[0].YEAR  : '';
                var year = yearLevel == '' ? '' : yearLevel == 'I' ? '1 ' : yearLevel == 'II' ? '2 ' : yearLevel == 'III' ? '3 ' : yearLevel == 'IV' ? '4' : '';
                var yearLevelText = yearLevel == 'I' ? '1ST YEAR ' : yearLevel == 'II' ? '2ND YEAR ' : yearLevel == 'III' ? '3RD YEAR ' : yearLevel == 'IV' ? '4TH YEAR ' : '';
                var sem = data[0].SEMESTER ? data[0].SEMESTER : '';
                var semText =  sem == '1' ? '1ST SEMESTER' : sem == 2 ? '2ND SEMESTER ' : sem == 3 ? '3RD SEMESTER ' : sem == 4 ? '4TH SEMESTER ' : '';
                var prog = data[0].PROGRAM ? data[0].PROGRAM : '';
                var sec = data[0].SECTION ? '-' + data[0].SECTION : '';
                var ayear = data[0].ACADEMIC_YEAR ? data[0].ACADEMIC_YEAR : '';

                $("#class_name").text(data[0].CLASS_NAME ? data[0].CLASS_NAME : 'No Data');
                $("#secyear").text(yearLevelText + prog + ' ' + year  + sec);
                $("#sem").text(semText);
                $("#ayear").text(ayear);
                $("#classcode").text(data[0].CLASS_CODE ? data[0].CLASS_CODE : 'No Data');

                if (Array.isArray(data) && data.length > 0) {
                    $.each(data, function (index, item) {
                        var row = $("<tr>");
                        var enrollStatusIcon = ''; // Declare the variable

                        if (item.enrollStatus == 'PENDING') {
                            enrollStatusIcon = '<i class="fa-solid fa-person-circle-check fa-xl" style="color: #800000; cursor: pointer"></i>';
                        }

                        var statusCell = (item.enrollStatus == "ON") ? "Joined" : "Pending";

                        row.html(
                            '<td>' + item.fullname + '</td>' +
                            '<td>' + statusCell + '</td>' +
                            '<td>' + enrollStatusIcon + '&nbsp &nbsp' + '<i class="fa-solid fa-trash fa-xl" style="color: #800000; cursor: pointer" onclick="createClass(\'delete-enrolled\',' + item.enrolledid + ')"></i>' + '</td>'
                        );

                        tableBody.append(row);
                    });

                } else {
                    tableBody.html('<tr><td colspan="2">No data available.</td></tr>');
                }
            }
        });
    }
}

function joinedClasses(process,id){
    const url = 'http://localhost/student_monitoring/api/JoinedClass.php';
    if (process == 'leave'){
        Swal.fire({
            title: 'Do you want to leave this Class?',
            showDenyButton: true,
            confirmButtonText: 'Save',
            denyButtonText: `Don't save`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Leave Class!',
                    html: 'Processing',
                    timer: 1000,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        $.ajax({
                            url: url,
                            method: "POST",
                            data: {
                                process: process,
                                id: id,
                            },
                            success: function (data) {
                                const parsedData = JSON.parse(data); // Parse the response as JSON
                                if (!parsedData.status) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '' + parsedData.message,
                                    })

                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: '' + parsedData.message,
                                        confirmButtonText: 'Close',
                                        allowOutsideClick: false,
                                    }).then((result) => {
                                        /* Read more about isConfirmed, isDenied below */
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    })
                                }

                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.error("AJAX Error:", textStatus, errorThrown);
                            }
                        });
                    }
                })
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    }

    if (process == 'join'){
        Swal.fire({
            title: 'Do you want to Join this Class?',
            showDenyButton: true,
            confirmButtonText: 'Save',
            denyButtonText: `Don't save`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Joing Class!',
                    html: 'Processing',
                    timer: 1000,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        $.ajax({
                            url: url,
                            method: "POST",
                            data: {
                                process: process,
                                code: $("#code").val(),
                            },
                            success: function (data) {
                                const parsedData = JSON.parse(data); // Parse the response as JSON
                                if (!parsedData.status) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '' + parsedData.message,
                                    })

                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: '' + parsedData.message,
                                        confirmButtonText: 'Close',
                                        allowOutsideClick: false,
                                    }).then((result) => {
                                        /* Read more about isConfirmed, isDenied below */
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    })
                                }

                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.error("AJAX Error:", textStatus, errorThrown);
                            }
                        });
                    }
                })
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    }
}

function classYearChange(process){
   if(process == 'join_change'){
       const url = "http://localhost/student_monitoring/api/JoinedClass.php";
       var tableBody = $(".join-teacher-table tbody");
       let selectYear = $("#join-class-select").val();

       tableBody.empty();

       $.ajax({
           url: url,
           method: "POST",
           data: {process: process, academic: selectYear},
           success: function (data){

               if (Array.isArray(data) && data.length > 0) {
                   $.each(data, function (index, item) {
                       var row = $("<tr>");
                       row.html(
                           '<td>' + item.CLASS_NAME + '</td>' +
                           '<td>' + item.c_code + '</td>' +
                           '<td>' + item.SECTION + '</td>' +
                           '<td>' + (item.statusEnroll == "ON" ? "Joined" : "PENDING") + '</td>' +
                           '<td><i class="fas fa-trash fa-xl" style="color: #800000; cursor: pointer" onclick="joinedClasses(\'leave\', ' + item.SECTION + ')"></i></td>'
                       );

                       tableBody.append(row);
                   });
               } else {
                   tableBody.html("No data available.");
               }
           }
       });
   }
   if(process == 'class_change'){
       const url = "http://localhost/student_monitoring/api/Class.php";
       var tableBody = $(".class-teacher-table tbody");
       let selectYear = $("#teacher-class-select").val();

       tableBody.empty();

       $.ajax({
           url: url,
           method: "POST",
           data: {process: process, academic: selectYear},
           success: function (data){

               if (Array.isArray(data) && data.length > 0) {
                   $.each(data, function (index, item) {
                       var row = $("<tr>");
                       row.html(
                           '<td>' + item.CLASS_NAME + '</td>' +
                           '<td>' + item.COURSE_CODE + '</td>' +
                           '<td>' +
                           '<i class="fa-solid fa-eye fa-xl openModalBtn" data-modal="classView" onclick="createClass(\'student-class-science\',' + item.id + ')" style="color: #800000; cursor: pointer"></i> &nbsp;' +
                           '<i class="fa-solid fa-pen-to-square fa-xl openModalBtn" data-modal="classEdit" onclick="createClass(\'view\',' + item.id + ')" style="color: #800000; cursor: pointer"></i> &nbsp;' +
                           '<i class="fa-solid fa-trash fa-xl" style="color: #800000; cursor: pointer" onclick="createClass(\'delete\',' + item.id + ')"></i>' +
                           '</td>'
                   );


                       tableBody.append(row);
                       $(document).off('click', '.openModalBtn').on('click', '.openModalBtn', function() {
                           var modalType = $(this).data('modal');
                           var itemId = $(this).data('id');
                           openModal(modalType, itemId);
                       });
                   });
               } else {
                   tableBody.html("No data available.");
               }
           }
       });
   }
}


function copy() {
    const textToCopy = $("#classcode").text(); // Specify the text you want to copy
    navigator.clipboard.writeText(textToCopy)
        .then(() => {
            const notification = document.getElementById('notification');
            notification.innerText = 'Copied!';
            notification.style.display = 'block';

            setTimeout(() => {
                notification.style.display = 'none';
            }, 1000);
            console.log('Text copied to clipboard');
        })
        .catch((err) => {
            console.error('Unable to copy text: ', err);
        });
}

function sort(id) {
    var rows = [];

    switch (id) {
        case 'course':
            rows = $(".course-table tbody tr").get();
            break;
        case 'student-account':
            rows = $(".admin-student-table tbody tr").get();
            break;
        case 'teacher-account':
            rows = $(".admin-teacher-table tbody tr").get();
            break;
        case 'class-teacher':
            rows = $(".class-teacher-table tbody tr").get();
            break;
        case 'join-class-science':
            rows = $(".join-teacher-table tbody tr").get();
            break;
        default:
            break;
    }

    var column = 0; // Adjust this index to sort based on a different column if needed

    var isAscending = $('tbody').hasClass('asc');

    rows.sort(function(a, b) {
        var keyA = $(a).find("td").eq(column).text().toUpperCase();
        var keyB = $(b).find("td").eq(column).text().toUpperCase();

        if (keyA < keyB) return isAscending ? -1 : 1;
        if (keyA > keyB) return isAscending ? 1 : -1;
        return 0;
    });

    // Toggle the sorting order class for the table body
    $('tbody').toggleClass('asc', !isAscending).toggleClass('desc', isAscending);

    // Toggle the sorting order class for the image indicator (change 'imgSortIndicator' to your image class or ID)
    if (isAscending) {
        $('#sort-img').addClass('asc').removeClass('desc');
        // Change the image source for visual representation if needed
    } else {
        $('#sort-img').addClass('desc').removeClass('asc');
        // Change the image source for visual representation if needed
    }

    // Clear the table before appending sorted rows
    $('tbody').empty();

    // Append the sorted rows to the table
    $.each(rows, function(index, row) {
        $('tbody').append(row);
    });
}


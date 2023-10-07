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

function showCourse(id){
    $.ajax({
        type: 'POST',
        url: 'http://localhost/student_monitoring/api/CourseShow.php',
        data: { courseID: id },
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
        var resultDiv = $("#list-student");
        resultDiv.empty();

        $.ajax({
           url: url,
           method: "GET",
            data: {process: process,id: id},
           success: function (data){
               // Handle the response data and display it in the div

               if (Array.isArray(data) && data.length > 0) {
                       var studentLastName = data[0].fullname;
                       $("#student_name").text(studentLastName);

                   $.each(data, function (index, item) {
                       var courseDiv = $("<div>");
                       courseDiv.addClass("list-student-item");
                       courseDiv.html(
                           '<p>' + item.c_code + '</p>' +
                           '<p class="course-description">' + item.COURSE_DESC + '</p>'
                       );
                       resultDiv.append(courseDiv);
                   });
               } else {
                   const fullval = $("#fullval").data('fullname');
                   $("#student_name").text(fullval);
                   resultDiv.html("No data available.");
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
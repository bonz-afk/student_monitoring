<?php
include_once  $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="http://localhost/student_monitoring/common/css/common.css">
        <style>
            body{
                overflow: hidden;
            }
            .signup-container{
                display: flex;
                justify-content: center;
                align-items: start;
                margin-top: 65px;
                margin-left: -868px;
            }
            .signup-bg {
                background-image: url(common/images/background/signup-bg.png);
                background-repeat: no-repeat;
                min-height: 100%;
                overflow-y: hidden;
            }

            @media only screen and (max-width: 827px) {
                body{
                    background: #e0e2e4;
                }
                .signup-bg{

                    background: unset;
                    overflow-y: scroll;

                }
            }

            .img-bg{
                width: 95rem;
                height: 70rem;
            }

            .signup-form-container{
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                margin-top: 60px;
            }

            .font-mont.sign{
                margin: 0;
                color: #800000;
            }

            .sign-input{
                width: 100%;
                margin: 15px 0;
                border-radius: 10px;
                border: 0;
                background-color: #e0e2e4;
                height: 50px;
                color: #800000;
                text-indent: 10px;
                font-size: 20px;
                max-width: 725px;
            }
            .sign-input:focus,.sign-select:focus{
                outline: 0;
            }

            .sign-select {
                appearance: none;
                background: transparent;
                border-radius: 10px;
                border: 0;
                height: 50px;
                color: #800000;
                font-size: 20px;
                padding: 0 10px;
                width: 667px;
            }

            .sign-input::placeholder{
                color: #800000;
            }
            .sign.btn-signup{
                font-size: 25px;
                padding: 10px;
                align-self: end;
            }
            .signup-form-container small.valid{
                color: #5cb85c;
                align-self: start;
                margin-left: 7px;
            }
            .signup-form-container small.error{
                color: #ff0033;
                align-self: start;
                margin-left: 7px;
            }

            @media only screen and  (max-width: 2300px) {
                .img-bg{
                    width: 50rem;
                    height: 50rem;
                }

                .signup-container{
                    justify-content: space-evenly;
                    margin-left: 0;
                }
                .font-mont.sign{
                    font-size: 45px;
                }
            }

            @media only screen and  (max-width: 1024px) {
                .img-bg{
                    display: none;
                }

                .signup-bg{
                    background-image: url("common/images/signup-img.png");
                    background-repeat: no-repeat;
                    background-position: center top;
                    background-size: 100% 24%;
                    overflow-y: scroll;
                }

                .font-mont.sign{
                    font-size: 45px;
                }

                .sign-select {
                    width: 100%;
                    max-width: 345px;
                }
                .signup-container {
                    justify-content: center;
                    margin-top: 173px;
                }

            }

            @media only screen and  (max-width: 466px) {
                .font-mont.sign{
                    font-size: 20px;
                }
            }
        </style>
    </head>
    <body class="signup-bg">
        <form method="POST" id="signupForm">
            <div class="signup-container">
                   <img class="img-bg" src="common/images/signup-img.png" >
                   <div class="signup-form-container">

                           <p class="font-mont sign">Student Progress</p>
                           <p class="font-mont sign">Monitoring System</p>
                           <input type="text" class="sign-input" id="fname" name="fname" maxlength="255" placeholder="First Name">
                           <small class="fname-message"></small>
                           <input type="text" class="sign-input" id="mname" name="mname" maxlength="255" placeholder="Middle Name">
                           <small class="mname-message"></small>
                           <input type="text" class="sign-input" id="lname" name="lname" maxlength="255" placeholder="Last Name">
                           <small class="lname-message"></small>
                           <input type="text" class="sign-input" id="email" name="email" maxlength="255" placeholder="Email">
                           <small class="email-message"></small>
                           <div class="custom-dropdown">
                            <span class="custom-select">
                                <select  class="sign-select" id="type" name="type">
                                 <option value="">Type of Account</option>
                                    <?php foreach($accountData as $account) {?>
                                        <option value="<?php echo $account['TYPE']?>"><?php echo $account['TYPE']?></option>
                                    <?php }?>
                                </select>
                            </span>
                           </div>
                           <small class="type-message"></small>
                           <input type="password" class="sign-input" id="password" name="password" maxlength="255" placeholder="Password">
                           <small class="pass-message"></small>
                           <button type="button" class="sign btn-signup" onclick="signUpProcess()">Sign Up</button>
                   </div>
            </div>
        </form>

        <script src="common/js/external/jquery-3.7.1.min.js"></script>
        <script src="common/js/common.js"></script>
        <script src="common/js/select.js"></script>
        <script src="common/js/external/sweetalert2.min.js"></script>
    </body>
</html>

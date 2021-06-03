<!DOCTYPE html>
<html lang="en">

<head>
    <title>OrderBank | Register</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="/login/images/icons/favicon.ico" />

    <link rel="stylesheet" type="text/css" href="/login/vendor/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">

    <link rel="stylesheet" type="text/css" href="/login/vendor/animate/animate.css">

    <link rel="stylesheet" type="text/css" href="/login/vendor/css-hamburgers/hamburgers.min.css">

    <link rel="stylesheet" type="text/css" href="/login/vendor/animsition/css/animsition.min.css">

    <link rel="stylesheet" type="text/css" href="/login/vendor/select2/select2.min.css">

    <link rel="stylesheet" type="text/css" href="/login/vendor/daterangepicker/daterangepicker.css">

    <link rel="stylesheet" type="text/css" href="/login/css/util.css">
    <link rel="stylesheet" type="text/css" href="/login/css/main.css?v={{ time() }}">

</head>
<style>
.login100-form {
    width: 560px;
    min-height: 110vh;
    display: block;
    background-color: #5E2CED;
    padding: 53px 55px 55px 55px;
    color: #fff !important;
}

input::placeholder {
    color:#fff;
}

b {
    color:#fff;
}

input.input100 {
    height: 100%;
    -webkit-transition: all 0.4s;
    -o-transition: all 0.4s;
    -moz-transition: all 0.4s;
    transition: all 0.4s;
    color: #fff;
}
</style>
<body style="background-color: #f2f2f2;">
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">

                <form class="login100-form validate-form" action="" method="post">
                    @csrf
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <br>
                    <span class="login100-form-title p-b-43">

<b style="font-size: 30px;">Welcome to OrderBank</b> <br>
    <b style="font-size: 15px;">Enter Your Correct Details To Register.</b>
</span>

 <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                            <input class="input100" placeholder="First Name" type="text" name="firstname">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                            <input class="input100" placeholder="Last Name" type="text" name="lastname">
                            <span class="focus-input100"></span>
                        </div>

<div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                            <input class="input100" placeholder="Business Name" type="text" name="business_name">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                            <input class="input100" placeholder="Business Phone Number" type="text" name="business_phone_number">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                            <input class="input100" placeholder="Business Address" type="text" name="address">
                            <span class="focus-input100"></span>
                        </div>


                        <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                            <input class="input100" placeholder="E-mail" type="text" name="email">
                            <span class="focus-input100"></span>
                        </div>


                        <div class="wrap-input100 validate-input" data-validate="Password is required">
                            <input class="input100" placeholder="Password" type="password" name="pass">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn" style="background: #fff; color: #222; margin-bottom: 5px;">
                                Register
                            </button>
                            <br><br>
                            <a href="https://app.orderbank.com.ng/" class="login100-form-btn" style="background: #fff; color: #222;">
                                Login
                            </a>
                        </div>

                </form>
                <div class="login100-more" style="background-color: #5E2CED;">
                    <center><img src="/ORDERBANK IDENT logo white.png" style="width: 500px;
    margin-left: 140px;
    margin-top: 400px;" />
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>

    <script src="vendor/animsition/js/animsition.min.js"></script>

    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <script src="vendor/select2/select2.min.js"></script>

    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>

    <script src="vendor/countdowntime/countdowntime.js"></script>

    <script src="js/main.js"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
    <script>
       // $('.input100').on('keyup', function() {
       //      $('.label-input100').hide();
       // })

    </script>
</body>

</html>

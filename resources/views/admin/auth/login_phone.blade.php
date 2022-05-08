<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/toastr/build/toastr.min.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <style>
            /* Chrome, Safari, Edge, Opera */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
              -webkit-appearance: none;
              margin: 0;
            }
            
            /* Firefox */
            input[type=number] {
              -moz-appearance: textfield;
            }
            </style>
    </head>

    <body>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">Welcome Back !</h5>
                                            <p>Sign in to continue to {{ @App\Models\Setting::setting()->name }}.</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="{{ asset('assets/images/profile-img.png') }}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0"> 
                                <div class="auth-logo">
                                    <a href="#" class="auth-logo-light">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{ asset('storage/setting/'.@App\Models\Setting::setting()->logo) }}" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>

                                    <a href="#" class="auth-logo-dark">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{ asset('storage/setting/'.@App\Models\Setting::setting()->logo) }}" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                
                                <div class="p-2">

                                    <form class="form-horizontal" method="POST" action="">
                                        @csrf
        
                                        <div class="alert alert-danger" id="error" style="display: none;"></div>
                                        <div class="alert alert-success" id="sentSuccess" style="display: none;"></div>
                                        <div class="alert alert-success" id="successRegsiter" style="display: none;"></div>

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Phone Number</label>
                                            <input type="text" id="number" name="number" value="{{ old('number') }}" class="form-control" placeholder="+(code) number">
                                            <a href="{{ route('login.form') }}">Login with Email</a>
                                            @error('number')
                                                <span class="badge badge-soft-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div id="recaptcha-container"></div>
                                        
                                        <div class="mt-3 d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button class="btn btn-success" type="button" onclick="phoneSendAuth();">Send Code</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="p-2">
                                    <form class="form-horizontal" method="POST" action="">
                                        @csrf
        
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Verification code</label>
                                            <input type="text" id="verificationCode" class="form-control" placeholder="Enter verification code">
                                        </div>
                                        
                                        <div class="mt-3 d-grid">
                                            <button class="btn btn-primary waves-effect waves-light" type="button" onclick="codeverify();">Verify code & Login</button>
                                        </div>
                                    </form>
                                </div>
            
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            
                            <div>
                            {{--  <p>Don't have an account ? <a href="{{ route('register') }}" class="fw-medium text-primary"> Signup now </a> </p> --}}
                                <p>{!! @App\Models\Setting::setting()->copyright !!}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- end account-pages -->

        <!-- firebase script -->
        <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

        <script>
            var firebaseConfig = {
                apiKey: "AIzaSyBmQCoHWA1zCKWs2vpGnXnWOJvfhkZ_3Ss",
                authDomain: "drlive-65775.firebaseapp.com",
                projectId: "drlive-65775",
                storageBucket: "drlive-65775.appspot.com",
                messagingSenderId: "522336728724",
                appId: "1:522336728724:web:be7fe31f6cd53312f2e681",
                measurementId: "G-NDSW9XCPCS"
            };
            firebase.initializeApp(firebaseConfig);
          
        </script>

        {{-- <script>
            var firebaseConfig = {
            apiKey: "AIzaSyCgLXVa0XdzqO99MuNqxayegpwXBu_qAvo",
            authDomain: "mmwebsite-c97f7.firebaseapp.com",

            projectId: "mmwebsite-c97f7",

            storageBucket: "mmwebsite-c97f7.appspot.com",

            messagingSenderId: "124388740390",

            appId: "1:124388740390:web:c93fe39e868c7a755505e7",

            measurementId: "G-G72RQSHT2G"
        };
        firebase.initializeApp(firebaseConfig);
        
        </script> --}}

        <script type="text/javascript">
            window.onload=function () {
                render();
            };

            function render() {
                window.recaptchaVerifier=new firebase.auth.RecaptchaVerifier('recaptcha-container');
                recaptchaVerifier.render();
            }

            function phoneSendAuth() {  
                var number = $("#number").val();
                $.ajax({
                    url: "{{url('getuser')}}",
                    type: "GET",
                    data: {
                        number: number,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        if (result.result == true) {
                            firebase.auth().signInWithPhoneNumber(number,window.recaptchaVerifier).then(function (confirmationResult) {
                                window.confirmationResult=confirmationResult;
                                coderesult=confirmationResult;
                                //console.log(coderesult);
                                $("#error").hide();
                                $("#sentSuccess").hide();
                                $("#successRegsiter").hide();
                                $("#sentSuccess").text("Message Sent Successfully.");
                                $("#sentSuccess").show();
                            }).catch(function (error) {
                                $("#sentSuccess").hide();
                                $("#error").hide();
                                $("#successRegsiter").hide();
                                $("#error").text(error.message);
                                $("#error").show();
                            });
                        }
                        else {
                            $("#sentSuccess").hide();
                            $("#error").hide();
                            $("#successRegsiter").hide();
                            $("#error").text(result.message);
                            $("#error").show();
                        }
                    }
                });
            }


            function codeverify() {
                var code = $("#verificationCode").val();
                var number = $("#number").val();
                coderesult.confirm(code).then(function (result) {
                    var user=result.user;
                    $("#error").hide();
                    $("#sentSuccess").hide();
                    $("#successRegsiter").hide();
                    $("#successRegsiter").text("Code verified successfully.");
                    $("#successRegsiter").show();
                    $.ajax({
                        url: "{{url('phonelogin')}}",
                        type: "POST",
                        data: {
                            number: number,
                            _token: '{{csrf_token()}}'
                        },
                        dataType: 'json',
                        success: function (result) {
                            if (result.result == true) {
                                window.location = result.redirect;
                            }
                            else {
                                $("#sentSuccess").hide();
                                $("#error").hide();
                                $("#successRegsiter").hide();
                                $("#error").text(result.message);
                                $("#error").show();
                            }
                        }
                    });
                }).catch(function (error) {
                    $("#error").hide();
                    $("#sentSuccess").hide();
                    $("#successRegsiter").hide();
                    $("#error").text(error.message);
                    $("#error").show();
                });
            }
        </script>

        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
        
        <!-- App js -->
        <script src="{{ asset('assets/js/app.js') }}"></script>

        <script src="{{ asset('assets/libs/toastr/build/toastr.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/toastr.init.js') }}"></script>
        {!! Toastr::message() !!}
    </body>
</html>

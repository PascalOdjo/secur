
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from themesbox.in/admin-templates/olian/html/light-vertical/user-register.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 26 Aug 2024 11:08:47 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Olian is a bootstrap minimal & clean admin template">
    <meta name="keywords" content="admin, admin panel, admin template, admin dashboard, admin theme, bootstrap 4, responsive, sass support, ui kits, crm, ecommerce">
    <meta name="author" content="Themesbox17">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Olian - Bootstrap Minimal & Clean Admin Template</title>
    <!-- Fevicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- Start css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <!-- End css -->
</head>
<body class="vertical-layout">
    <!-- Start Containerbar -->
    <div id="containerbar" class="containerbar authenticate-bg">
        <!-- Start Container -->
        <div class="container">
            <div class="auth-box register-box">
                <!-- Start row -->
                <div class="row no-gutters align-items-center justify-content-center">
                    <!-- Start col -->
                    <div class="col-md-6 col-lg-5">
                        <!-- Start Auth Box -->
                        <div class="auth-box-right">
                            <div class="card">
                                <div class="card-body">
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <div class="form-head">
                                            <a href="{{ url('/') }}" class="logo"><img src="{{ asset('assets/images/logo.svg') }}" class="img-fluid" alt="logo"></a>
                                        </div> 
                                        <h4 class="text-primary my-4">Sign Up !</h4>
                                        <div class="form-group">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Username" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email ID" value="{{ old('email') }}" required autocomplete="email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required autocomplete="new-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="Re-Type Password" required autocomplete="new-password">
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="col-sm-12">
                                                <div class="custom-control custom-checkbox text-left">
                                                    <input type="checkbox" class="custom-control-input" id="terms" name="terms" required>
                                                    <label class="custom-control-label font-14" for="terms">I Agree to Terms & Conditions of Olian</label>
                                                </div>                                
                                            </div>
                                        </div>                          
                                        <button type="submit" class="btn btn-success btn-lg btn-block font-18">Register</button>
                                    </form>
                                    <p class="mb-0 mt-3">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
                                    
                                </div>
                            </div>
                        </div>
                        <!-- End Auth Box -->
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
        </div>
        <!-- End Container -->
    </div>
    <!-- End Containerbar -->
    <!-- Start js -->        
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('assets/js/detect.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
    <!-- End js -->
</body>

<!-- Mirrored from themesbox.in/admin-templates/olian/html/light-vertical/user-register.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 26 Aug 2024 11:08:47 GMT -->
</html>
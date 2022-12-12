<!DOCTYPE html>
<html lang="en">

<head>
<meta name="description" content="">
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <meta name="path_prefix" content="">

    <meta property="og:description" content="Astro Technology Group is the holdings company for eShagi financial services, Pulse Wellness and Astro Mobile, which seeks to enhance digital
                                      inclusion within Africa by pioneering innovation through localised creativity">
    <meta property="og:image" content="https://www.astroafrica.tech//assets/landing/img/logo.png">
    <meta property="og:title" content="AstroAfricaTech">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@AstroTechAfrica">
    <meta name="Revisit-After" content="1 day">
    <meta name="author" content="Munashe">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Pulse - OwnYourBeat</title>
    <!-- Favicon icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ env('APP_URL') }}assets/landing/icon/apple-touch-icon.png">
    <link rel="icon" href="{{ env('APP_URL') }}logo_icon.png" type="image/png">
	<link rel="manifest" href="{{ env('APP_URL') }}assets/landing/icon/site.webmanifest">
    <!-- Form step -->
    <link href="{{ env('APP_URL') }}assets/admin/vendor/jquery-smartwizard/src/css/smart_wizard_all.css" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="{{ env('APP_URL') }}assets/admin/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="{{ env('APP_URL') }}assets/admin/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body mx-auto w-75">
            <div class="container-fluid">
                <!-- row -->
                <div class="row">
                    <div class="col-xl-12 col-xxl-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="text-center mb-3">
                                    <a href="/"><img src="assets/landing/img/logoo.png" alt=""></a>
                                </div>
                                <h4 class="card-title">Register Today</h4>
                            </div>
                            <div class="card-body">
                                <div id="smartwizard" class="form-wizard order-create">
                                    <ul class="nav nav-wizard">
                                        <li>
                                            <a class="nav-link" href="#step1">
                                                <span class=""><i class="fa fa-arrow-right"></i></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="#step2">
                                                <span><i class="fa fa-flag"></i></span>
                                            </a>
                                        </li>
                                    </ul>
                                    <form id="registerForm" action="{{route('register')}}" method="post">
                                        @csrf
                                        <div class="tab-content">
                                            <div id="step1" class="tab-pane" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-lg-6 mb-2">
                                                        <div class="form-group">
                                                            <label class="text-label">Firstname</label>
                                                            <input
                                                                    type="text"
                                                                    name="firstname"
                                                                    class="form-control {{ $errors->has('firstname') ? 'is-invalid' : '' }}"
                                                                    placeholder="e.g John"
                                                                    value="{{ old('firstname') }}"
                                                                    required>
                                                            @if($errors->has('firstname'))
                                                                <div>
                                                                    <strong class="is-invalid text-red">{{ $errors->first('firstname') }}</strong>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-2">
                                                        <div class="form-group">
                                                            <label class="text-label">Lastname</label>
                                                            <input
                                                                    type="text"
                                                                    name="lastname"
                                                                    class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}"
                                                                    placeholder="e.g Doe"
                                                                    value="{{ old('lastname') }}"
                                                                    required>
                                                            @if($errors->has('lastname'))
                                                                <div>
                                                                    <strong class="is-invalid text-red">{{ $errors->first('lastname') }}</strong>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-2">
                                                        <div class="form-group">
                                                            <label class="text-label">Height</label>
                                                            <input
                                                                    type="number"
                                                                    class="form-control {{ $errors->has('height') ? 'is-invalid' : '' }}"
                                                                    id="height"
                                                                    name="height"
                                                                    placeholder="enter your height in centimetres"
                                                                    value="{{ old('height') }}"
                                                                    required>
                                                            @if($errors->has('height'))
                                                                <div>
                                                                    <strong class="is-invalid text-red">{{ $errors->first('height') }}</strong>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-2">
                                                        <div class="form-group">
                                                            <label class="text-label">Weight</label>
                                                            <input
                                                                    type="number"
                                                                    name="weight"
                                                                    class="form-control {{ $errors->has('weight') ? 'is-invalid' : '' }}"
                                                                    placeholder="enter your weight in Kilograms"
                                                                    value="{{ old('weight') }}"
                                                                    required>
                                                            @if($errors->has('weight'))
                                                                <div>
                                                                    <strong class="is-invalid text-red">{{ $errors->first('weight') }}</strong>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-2">
                                                        <div class="form-group">
                                                            <label class="text-label">Password</label>
                                                            <input
                                                                    type="password"
                                                                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                                                    name="password"
                                                                    id="password"
                                                                    required>
                                                            @if($errors->has('password'))
                                                                <div>
                                                                    <strong class="is-invalid text-red">{{ $errors->first('password') }}</strong>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-2">
                                                        <div class="form-group">
                                                            <label for="password_confirm" class="text-label">Confirm Password</label>
                                                            <input
                                                                    type="password"
                                                                    class="form-control"
                                                                    id="password_confirm"
                                                                    name="password_confirmation"
                                                                    >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="step2" class="tab-pane" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-lg-6 mb-2">
                                                        <div class="form-group">
                                                            <label for="email" class="text-label">Email Address*</label>
                                                            <input
                                                                    type="email"
                                                                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                                    id="email"
                                                                    name="email"
                                                                    placeholder="e.g ( john-doe@example.com )"
                                                                    value="{{ old('email') }}"
                                                                    required>
                                                            @if($errors->has('email'))
                                                                <div>
                                                                    <strong class="is-invalid text-red">{{ $errors->first('email') }}</strong>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-2">
                                                        <div class="form-group">
                                                            <label for="phone" class="text-label">Phone Number*</label>
                                                            <input
                                                                    type="text"
                                                                    name="phone"
                                                                    class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                                                    placeholder="start with your country code"
                                                                    value="{{ old('phone') }}"
                                                                    required>
                                                            @if($errors->has('phone'))
                                                                <div>
                                                                    <strong class="is-invalid text-red">{{ $errors->first('phone') }}</strong>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-2">
                                                        <div class="form-group">
                                                            <label for="gender" class="text-label">Choose Gender</label>
                                                            <div class="row">
                                                                <div class="custom-control check-switch custom-checkbox mr-4 mb-2">
                                                                    <input
                                                                            value="male"
                                                                            type="radio"
                                                                            name="gender"
                                                                            class="custom-control-input"
                                                                            id="male"
                                                                            checked="checked"
                                                                    >
                                                                    <label class="custom-control-label" for="male">Male</label>
                                                                </div>
                                                                <div class="custom-control check-switch custom-checkbox mr-4 mb-2">
                                                                    <input
                                                                            value="female"
                                                                            name="gender"
                                                                            type="radio"
                                                                            class="custom-control-input"
                                                                            id="female"
                                                                            >
                                                                    <label class="custom-control-label" for="female">Female</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 mb-2">
                                                        <div class="form-group">
                                                            <label for="dob" class="text-label">Set your age</label>
                                                            <input
                                                                    type="date"
                                                                    name="dob"
                                                                    class="date form-control {{ $errors->has('dob') ? 'is-invalid' : '' }}"
                                                                    value="{{ old('dob') }}"
                                                                    id="dob">
                                                            @if($errors->has('dob'))
                                                                <div>
                                                                    <strong class="is-invalid text-red">{{ $errors->first('dob') }}</strong>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 mb-2">
                                                        <div class="form-group">
                                                            <label for="dob" class="text-label">Membership Number</label>
                                                            <input
                                                                    type="text"
                                                                    name="membership_number"
                                                                    class="date form-control {{ $errors->has('membership_number') ? 'is-invalid' : '' }}"
                                                                    value="{{ old('membership_number') }}"
                                                                    placeholder="Enter your membership number"
                                                                    id="membership_number">
                                                            @if($errors->has('membership_number'))
                                                                <div>
                                                                    <strong class="is-invalid text-red">{{ $errors->first('membership_number') }}</strong>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="https://astroafrica.tech" target="_blank">AstroAfrica.tech</a> 2021</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ env('APP_URL') }}assets/admin/vendor/global/global.min.js"></script>
    <script src="{{ env('APP_URL') }}assets/admin/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="{{ env('APP_URL') }}assets/admin/js/custom.min.js"></script>
    <script src="{{ env('APP_URL') }}assets/admin/js/deznav-init.js"></script>
    <script src="{{ env('APP_URL') }}assets/admin/vendor/jquery-steps/build/jquery.steps.min.js"></script>
    <script src="{{ env('APP_URL') }}assets/admin/vendor/jquery-validation/jquery.validate.min.js"></script>
    <!-- Form validate init -->
    <script src="{{ env('APP_URL') }}assets/admin/js/plugins-init/jquery.validate-init.js"></script>
    <!-- Form Steps -->
    <script src="{{ env('APP_URL') }}assets/admin/vendor/jquery-smartwizard/src/js/jquery.smartWizard.js"></script>
    <script>
        $(document).ready(function() {
            // SmartWizard initialize
            $('#smartwizard').smartWizard();
        });
    </script>

</body>

</html>
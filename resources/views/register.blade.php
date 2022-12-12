<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>PulseHealth - Own your beat</title>
    <meta property="og:description" content="PulseHealth is a digital health and wellness solution designed 
                                             by PulseHealth a subsidairy of the AstroTechAfrica Group, to
                                             promote and reward healthy living through a dedicated reward system">
    <!-- Favicon icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="icon/apple-touch-icon.png">
    <link rel="icon" href="../../../logo_icon.png" type="image/png">
	<link rel="manifest" href="icon/site.webmanifest">
    <!-- Form step -->
    <link href="../assets/admin/vendor/jquery-smartwizard/dist/css/smart_wizard.min.css" rel="stylesheet">
    <link href="../../../assets/admin/vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <!-- Pick date -->
    <link href="../../../assets/admin/vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Clockpicker -->
    <link href="../../../assets/admin/vendor/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet">
    <!-- asColorpicker -->
    <link href="../../../assets/admin/vendor/jquery-asColorPicker/css/asColorPicker.min.css" rel="stylesheet">
    <!-- Material color picker -->
    <link href="../../../assets/admin/vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <!-- Pick date -->
    <link rel="stylesheet" href="../../../assets/admin/vendor/pickadate/themes/default.css">
    <link rel="stylesheet" href="../../../assets/admin/vendor/pickadate/themes/default.date.css">
    <!-- Custom Stylesheet -->
    <link href="../../../assets/admin/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="../../../assets/admin/css/style.css" rel="stylesheet">
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
        <div class="content-body">
            <div class="container-fluid">
                <!-- row -->
                <div class="row">
                @yield('content')
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
                 <div class="row">
                 <div class="col-md-2">
                 <p><a href="" target="_blank">Terms and Conditions</a></p>
                 </div>
                 <div class="col-md-2">
                 <p><a href="" target="_blank">Cookies</a></p>
                 </div>
                 <div class="col-md-2">
                 <p><a href="" target="_blank">Privacy Policy</a></p>
                 </div>
                 <div class="col-md-2">
                 <p><a href="" target="_blank">Help</a></p>
                 </div>
                 <div class="col-md-4">
                 <p>2021 PulseHealth. All rights reserved </p>
                 </div>
                 </div>
             
            
        </div>
      
    </div>
   

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="../../../assets/admin/vendor/global/global.min.js"></script>
    <script src="../../../assets/admin/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="../../../assets/admin/js/custom.min.js"></script>
    <script src="../../../assets/admin/js/deznav-init.js"></script>

    <script src="../../../assets/admin/vendor/jquery-steps/build/jquery.steps.min.js"></script>
    <script src="../../../assets/admin/vendor/jquery-validation/jquery.validate.min.js"></script>
    <!-- Form validate init -->
    <script src="./vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <!-- pickdate -->
    <script src="../../../assets/admin/vendor/pickadate/picker.js"></script>
    <script src="../../../assets/admin/vendor/pickadate/picker.time.js"></script>
    <script src="../../../assets/admin/vendor/pickadate/picker.date.js"></script>



    <!-- Daterangepicker -->
    <script src="../../../assets/admin/js/plugins-init/bs-daterange-picker-init.js"></script>
    <!-- Clockpicker init -->
    <script src="../../../assets/admin/js/plugins-init/clock-picker-init.js"></script>
    <!-- asColorPicker init -->
    <script src="../../../assets/admin/js/plugins-init/jquery-asColorPicker.init.js"></script>
    <!-- Material color picker init -->
    <script src="../../../assets/admin/js/plugins-init/material-date-picker-init.js"></script>
    <!-- Pickdate -->
    <script src="../../../assets/admin/js/plugins-init/pickadate-init.js"></script>





    <!-- Form Steps -->
    <script src="../assets/admin/vendor/jquery-smartwizard/dist/js/jquery.smartWizard.js"></script>
    <script>
		$(document).ready(function(){
			// SmartWizard initialize
			$('#registrationsteps').smartWizard(); 
		});
	</script>

</body>

</html>
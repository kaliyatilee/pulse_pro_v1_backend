<!doctype html>
<html lang="en">

<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title>Pulse Health - Own your beat</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">


    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="assets/login/css/style.css">
    <link rel="stylesheet" href="assets/login/css/uikit.css">
    <link rel="stylesheet" href="assets/login/css/uikit.css">

    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="assets/login/css/icons.css">
    <script src="https://kit.fontawesome.com/815e388c50.js" crossorigin="anonymous"></script>

    <!-- Google font
    ================================================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="icon/apple-touch-icon.png">
    <link rel="icon" href="../logo_icon.png" type="image/png">
	<link rel="manifest" href="icon/site.webmanifest">

</head>

<body class="bg-white">



    <!-- Content
    ================================================== -->
    <div uk-height-viewport class="uk-flex uk-flex-middle">
        <div class="uk-width-2-3@m uk-width-1-2@s m-auto rounded uk-overflow-hidden shadow-lg">
            <div class="uk-child-width-1-2@m uk-grid-collapse bg-gradient-primary" uk-grid>

                <!-- column one -->
                <div class="uk-margin-auto-vertical uk-text-center uk-animation-scale-up p-3 uk-light">
                    <a href="/"><img src="assets/landing/img/logoo.png" alt=""></a>

                </div>

                <!-- column two -->
                <div class="uk-card-default px-5 py-8">
                    <div class="mb-4 uk-text-center">
                        <h2 class="mb-0"> Welcome</h3>
                        <p class="my-2">Login to manage your account.</p>
                    </div>

                    @yield('content')

                </div><!--  End column two -->

            </div>
        </div>
    </div>

    <!-- Content -End
    ================================================== -->




    <!-- javaScripts
    ================================================== -->
    <script src="assets/login/js/uikit.js"></script>
    <script src="assets/login/js/simplebar.js"></script>



</body>

</html>

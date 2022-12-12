<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<!--<![endif]-->

<head>
    <!-- Basic Page Needs -->
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <title>Pulse Health - Own your beat </title>

    <meta name="author" content="Munashe">

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
    <meta name="author" content="themesflat.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Bootstrap  -->
    <link rel="stylesheet" type="text/css" href="{{ env('APP_URL') }}assets/landing/css/bootstrap.css">


    <!-- Theme Style -->
    <link rel="stylesheet" type="text/css" href="{{ env('APP_URL') }}assets/landing/css/style.css">

    <!-- Responsive -->
    <link rel="stylesheet" type="text/css" href="{{ env('APP_URL') }}assets/landing/css/responsive.css">

    <!-- Colors -->
    <link rel="stylesheet" type="text/css" href="{{ env('APP_URL') }}assets/landing/css/colors/color1.css" id="colors">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

    <!-- Animation Style -->
    <link rel="stylesheet" type="text/css" href="{{ env('APP_URL') }}assets/landing/css/animate.css">
    <!-- Favicon and touch icons  -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ env('APP_URL') }}assets/landing/icon/apple-touch-icon.png">
    <link rel="icon" href="../logo_icon.png" type="image/png">
    <link rel="manifest" href="{{ env('APP_URL') }}assets/landing/icon/site.webmanifest">



    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="header-sticky ">
    <!-- Boxed -->
    <div class="boxed">
        <div id="site-header">
            <header id="header" class="header clearfix">
                <div class="header-wrap clearfix">
                    <div class="container">
                        <div class="row">
                            <div class="flat-wrapper">
                                <div id="logo" class="logo">
                                    <a href="/">
                                        <img src="{{ env('APP_URL') }}assets/landing/img/logoo.png">
                                    </a>
                                </div><!-- /.logo -->
                                <div class="btn-menu">
                                    <span></span>
                                </div><!-- //mobile menu button -->

                                <div class="nav-wrap">
                                    <nav id="mainnav" class="mainnav">
                                        <div class="menu-extra">
                                            <ul>
                                                <li class="shopping-cart">
                                                    <a href="">
                                                        <i class="icon-basket icons"></i>
                                                    </a>

                                                </li>
                                                <li class="shopping-cart">
                                                    <a href="login">
                                                        <i class="icon-user icons"></i>
                                                    </a>
                                                </li>
                                            </ul>

                                        </div><!-- /.menu-extra -->
                                        <ul class="menu">
                                            <li class="has-mega-menu">
                                                <a class="has-mega" href="#mega">PRODUCTS</a>
                                                <div class="submenu mega-menu">
                                                    <div class="row">
                                                        <div class="container">
                                                            <div class="col-md-2">
                                                                <div class="mega-title">
                                                                    <h5 class="btn-mega">Products</h5>
                                                                </div>
                                                                <ul class="mega-menu-sub">
                                                                    <li><a href="{{route('wearables')}}">Wearables</a></li>
                                                                    <li><a href="{{route('scales')}}">Scales</a></li>
                                                                    <li><a href="{{route('services')}}">Services</a></li>
                                                                </ul>
                                                            </div><!-- /.col-md-2 -->
                                                            <div class="col-md-2">
                                                                <div class="mega-title">
                                                                    <h5 class="btn-mega">Experiences</h5>
                                                                </div>
                                                                <ul class="mega-menu-sub">
                                                                    <li><a href="{{route('setup')}}">Setup Process</a></li>
                                                                </ul>
                                                            </div><!-- /.col-md-2 -->
                                                            <div class="col-md-4">
                                                                <div class="iconbox style_3">
                                                                    <div class="box-header">
                                                                        <!-- <div class="box-icon"><i class="fa icons icon-speech"></i></div> -->
                                                                    </div>
                                                                    <div class="box-content">

                                                                        <p>
                                                                            <img src="{{ env('APP_URL') }}assets/landing/img/PulseSpirit.png " alt="slider-image" />
                                                                        </p>
                                                                        <p class="box-readmore">
                                                                        <h2>Pulse Spirit</h2>
                                                                        </p>
                                                                        <a href="#" class="button lg dark">Shop now <span class="fa fa-arrow-right"></a>
                                                                    </div>
                                                                </div><!-- /.iconbox -->
                                                            </div><!-- /.col-md-4 -->
                                                            <div class="col-md-4">
                                                                <div class="iconbox style_3">
                                                                    <div class="box-header">
                                                                        <!-- <div class="box-icon"><i class="fa icons icon-speech"></i></div> -->
                                                                    </div>
                                                                    <div class="box-content">

                                                                        <p>
                                                                            <img src="{{ env('APP_URL') }}assets/landing/img/force.jpeg " alt="slider-image" />
                                                                        </p>
                                                                        <p class="box-readmore">
                                                                        <h2>Pulse Force</h2>
                                                                        </p>
                                                                        <a href="#" class="button lg dark">Shop now <span class="fa fa-arrow-right"></a>
                                                                    </div>
                                                                </div><!-- /.iconbox -->
                                                            </div><!-- /.col-md-4 -->
                                                        </div><!-- /.container -->
                                                    </div><!-- /.row -->
                                                </div><!-- /.submenu -->
                                            </li><!-- /.flat-mega-menu -->
                                           <li>
                                                <a class="" href="">SERVICES</a>
                                                <ul class="submenu">
                                                    <li><a href="{{route('corporates')}}">Pulse for Corporates</a></li>
                                                    <li><a href="{{route('insurance')}}">Pulse for Insurance </a></li>
                                                    <li><a href="{{route('schools')}}">Pulse for Schools</a></li>
                                                </ul><!-- /.submenu -->
                                            </li><!-- /.flat-mega-menu -->
                                            <li><a href="">TECHNOLOGY</a>
                                                <ul class="submenu">
                                                    <li><a href="{{route('ecg')}}">ECG</a></li>
                                                    <li><a href="{{route('heartrate')}}">24/7 Heart Rate</a></li>
                                                    <li><a href="{{route('sleepmonitor')}}">Sleep Monitoring</a></li>
                                                </ul><!-- /.submenu -->
                                            </li>
                                            <li>
                                                <a class="" href="">MOTIVATION</a>
                                                <ul class="submenu">
                                                    <li><a href="{{route('stories')}}">Success Stories</a></li>
                                                    <li><a href="{{route('challenges')}}">Challenges</a></li>
                                                    <li><a href="{{route('webcommunity')}}">Community</a></li>
                                                </ul><!-- /.submenu -->
                                            </li><!-- /.flat-mega-menu -->


                                        </ul><!-- /.menu -->
                                    </nav><!-- /.mainnav -->
                                </div><!-- /.nav-wrap -->
                            </div><!-- /.flat-wrapper -->
                        </div><!-- /.row -->
                    </div><!-- /.container -->
                </div><!-- /.header-inner -->
            </header>
            <div class="tp-banner-container">
                <div class="tp-banner">
                    <ul>
                        <li data-transition="random-static" data-slotamount="7" data-masterspeed="1000" data-saveperformance="on">
                            <img src="{{ env('APP_URL') }}assets/landing/img/Health-4.png" alt="slider-image" />
                            <div class="tp-caption sfl title-slide text-left" data-x="50" data-y="203" data-speed="1000" data-start="1000" data-easing="Power3.easeInOut">
                                Discover what ECG is all about <br>
                                with PulseHealth
                            </div>

                        </li>
                    </ul>
                </div>
            </div>
        </div><!-- /.site-header -->
        <!-- Site content -->
        <div class="flat-row pad-top0px pad-bottom20px bg-f4f4f4 ">
            <div class="image-single style_1 clearfix">
                <div class="item-two-column section-iconlist">
                    <div class="title-section style_1">
                        <div class="page-title">
                            <h2 class="title" style="font-size: 30pt;font-weight:500"><b>Check your heart for artrial fibrillation with PulseHelath <br> and
                                    share your results with your health expert</b></h2>
                        </div>

                        <div class="desc">
                            <span style="font-size: 18pt;">With PulseHelath you can analyse your heartbeat and know if you show signs of AFib.</span>
                        </div>
                    </div>
                    <div class="flat-divider d30px"></div>


                </div><!-- /.item-two-column -->
                <div class="item-two-column mag-left flat-single-image-autoheight-style1">

                    <img src="assets/landing/img/Pulse-spirit.png">
                </div><!-- /.item-two-column -->
            </div><!-- /.image-single -->
        </div><!-- /.flat-row -->


    </div><!-- /#site-content -->

    </div>

    <!-- Site content -->
    <div id="site-content">
        <div id="page-header">
            <div class="container">
                <div class="row">
                    <div class="page-title">
                        <h2 class="title">Know more about ECG</h2>
                    </div>
                    <div id="page-breadcrumbs">
                        <nav class="breadcrumb-trail breadcrumbs">
                            <h2 class="trail-browse">Explore from here:</h2>

                        </nav>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container -->
        </div><!-- /#page-header -->
    </div>
    <div class="flat-row pad-top0px pad-bottom20px bg-f4f4f4 ">
            <div class="image-single style_1 clearfix">
                <div class="item-two-column section-iconlist">
                    <div class="title-section style_1">
                        <div class="page-title">
                            <h2 class="title" style="font-size: 30pt;font-weight:500"><b>
                            What’s an ECG?</b></h2>
                        </div>

                        <div class="desc">
                            <span style="font-size: 18pt;">An electrocardiogram (ECG or EKG) is a test that measures the electrical activity of your heart.</span>
                        </div>
                    </div>
                    <div class="title-section style_1">
                        <div class="page-title">
                            <h2 class="title" style="font-size: 30pt;font-weight:500"><b>
                            What does the PulseHealth ECG monitor do?</b></h2>
                        </div>

                        <div class="desc">
                            <span style="font-size: 18pt;">The app brings ECG technology to your wrist so you can record your heart’s rhythm when it’s convenient for you.</span>
                        </div>
                    </div>
                    <div class="flat-divider d30px"></div>


                </div><!-- /.item-two-column -->
                <div class="item-two-column mag-left flat-single-image-autoheight-style1">
                <div class="title-section style_1">
                <div class="flat-divider d30px"></div>
                <div class="flat-divider d30px"></div>
                        <div class="page-title">
                            <h2 class="title" style="font-size: 30pt;font-weight:500"><b>Why is assessing for AFib important?</b></h2>
                        </div>

                        <div class="desc">
                            <span style="font-size: 18pt;">During AFib, the upper chambers of the heart contract irregularly, increasing the risk of heart attack, blood clots, stroke and other heart conditions.</span>
                        </div>

                        <div class="desc">
                            <span style="font-size: 18pt;">AFib can be difficult to detect, but the PulseHealth app lets you check in on your heart rhythm right from your wrist—so you have a better chance of spotting and treating it. This assessment can’t diagnose AFib on its own, but your results can help you have a better conversation with your doctor.</span>
                        </div>
                    </div>
                </div><!-- /.item-two-column -->
            </div><!-- /.image-single -->
        </div><!-- /.flat-row -->
    <section class="row mobile-app">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-push-6 wow fadeIn">
                    <h2>Get the PulseHealth App</h2>
                    <p>Download the PulseHealth App for free and starting enjoying endless benefits</p>
                    <div class="row m0 downloads-btns">
                        <a href="" class="dload-link"><img src="{{ env('APP_URL') }}assets/landing/img/app-store.png" alt=""></a>
                        <a href="https://play.google.com/store/apps/details?id=com.algebratech.pulse_wellness" class="dload-link" target="_blank"><img src="{{ env('APP_URL') }}assets/landing/img/google-play.png" alt=""></a>
                    </div>
                </div>
                <div class="col-sm-6 col-sm-pull-6 wow fadeInUp">

                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="footer">
        <div class="footer-widgets">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="widget widget_text style_1">
                            <h3 class="widget-title"><span class="style_1">S</span>upport</h3>
                            <ul>
                                <li>
                                    <a href="">Product Help</a>

                                </li>
                                <li>
                                    <a href="">Enquiries</a>

                                </li>
                                <li>
                                    <a href="">Community</a>
                                </li>

                            </ul>
                        </div><!-- /.widget_text -->
                    </div><!-- /.col-md-3 -->

                    <div class="col-md-3">
                        <div class="widget widget_text style_1">
                            <h3 class="widget-title"><span class="style_1">L</span>egal</h3>
                            <ul>
                                <li>
                                    <a href=" ">Terms of Service</a>

                                </li>
                                <li>
                                    <a href=" ">Privacy Policy</a>

                                </li>
                                <li>
                                    <a href=" ">Cookie Policy</a>

                                </li>

                            </ul>
                        </div><!-- /.widget_text -->
                    </div><!-- /.col-md-3 -->

                    <div class="col-md-3">
                        <div class="widget widget_text style_1">
                            <h3 class="widget-title"><span class="style_1">P</span>artners</h3>
                            <ul>
                                <li>
                                    <a href=" ">Retailers</a>

                                </li>
                                <li>
                                    <a href=" ">For Developers</a>

                                </li>
                                <li>
                                    <a href=" ">Careers</a>

                                </li>

                            </ul>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="widget widget_text style_1">
                            <h3 class="widget-title"><span class="style_1">C</span>ompany</h3>
                            <ul>
                                <li>
                                    <a href="/about">About Us</a>

                                </li>
                                <li>
                                    <a href="">Careers</a>

                                </li>

                            </ul>
                        </div><!-- /.widget .widget_text information -->
                    </div><!-- /.col-md-3 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </div><!-- /.footer-content -->

    </footer>

    <!-- Go Top -->
    <a class="go-top">
    </a>

    </div>

    <!-- Javascript -->
    <script type="text/javascript" src="{{ env('APP_URL') }}assets/landing/js/jquery.min.js"></script>
    <script type="text/javascript" src="{{ env('APP_URL') }}assets/landing/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ env('APP_URL') }}assets/landing/js/jquery.easing.js"></script>
    <script type="text/javascript" src="{{ env('APP_URL') }}assets/landing/js/owl.carousel.js"></script>
    <script type="text/javascript" src="{{ env('APP_URL') }}assets/landing/js/jquery-waypoints.js"></script>
    <script type="text/javascript" src="{{ env('APP_URL') }}assets/landing/js/imagesloaded.min.js"></script>
    <script type="text/javascript" src="{{ env('APP_URL') }}assets/landing/js/jquery.isotope.min.js"></script>
    <script type="text/javascript" src="{{ env('APP_URL') }}assets/landing/js/jquery-countTo.js"></script>
    <script type="text/javascript" src="{{ env('APP_URL') }}assets/landing/js/jquery.fancybox.js"></script>
    <script type="text/javascript" src="{{ env('APP_URL') }}assets/landing/js/jquery.flexslider-min.js"></script>
    <script type="text/javascript" src="{{ env('APP_URL') }}assets/landing/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="{{ env('APP_URL') }}assets/landing/js/gmap3.min.js"></script>
    <script type="text/javascript" src="{{ env('APP_URL') }}assets/landing/js/jquery-validate.js"></script>
    <script type="text/javascript" src="{{ env('APP_URL') }}assets/landing/js/parallax.js"></script>
    <script type="text/javascript" src="{{ env('APP_URL') }}assets/landing/js/main.js"></script>


    <!-- Revolution Slider -->
    <script type="text/javascript" src="{{ env('APP_URL') }}assets/landing/js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="{{ env('APP_URL') }}assets/landing/js/jquery.themepunch.revolution.min.js"></script>
    <script type="text/javascript" src="{{ env('APP_URL') }}assets/landing/js/slider.js"></script>



</body>

</html>
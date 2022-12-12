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

                                            <li>
                                                <a class="" href="{{route('websubs')}}">SUBSCRIPTIONS</a>
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
                            <img src="{{ env('APP_URL') }}assets/landing/img/schools.png" alt="slider-image" />
                            <div class="tp-caption sfl title-slide text-left" data-x="left" data-y="203" data-speed="1000" data-start="1000" data-easing="Power3.easeInOut">
                                Wellnessplans for the young <br>
                                and energized
                            </div>

                        </li>

                        <li data-transition="random-static" data-slotamount="7" data-masterspeed="1000" data-saveperformance="on">
                            <img src="{{ env('APP_URL') }}assets/landing/img/corporates.png" alt="slider-image" />
                            <div class="tp-caption sfl title-slide text-left" data-x="50" data-y="203" data-speed="1000" data-start="1000" data-easing="Power3.easeInOut">
                               Wellnesplans for business<br>
                                enterprises
                            </div>

                        </li>

                        <li data-transition="slidedown" data-slotamount="7" data-masterspeed="1000" data-saveperformance="on">
                            <img src="{{ env('APP_URL') }}assets/landing/img/Healthedu.png" alt="slider-image" />
                            <div class="tp-caption sfl title-slide text-left" data-x="left" data-y="203" data-speed="1000" data-start="1000" data-easing="Power3.easeInOut">
                                Wellnessplans for <br>
                                everyone
                            </div>

                        </li>

                    </ul>
                </div>
            </div>

            <div id="site-content">
                <div id="page-header">
                    <div class="container">
                        <div class="row">
                            <div class="page-title">
                                <h2 class="title">Pulse Wellness Plans</h2>
                            </div>
                            <div id="page-breadcrumbs">
                                <nav class="breadcrumb-trail breadcrumbs">
                                    <h2 class="trail-browse">Explore from here:</h2>
                                </nav>
                            </div>
                        </div><!-- /.row -->
                    </div><!-- /.container -->
                </div><!-- /#page-header -->

                <div id="page-body">
                    <div class="flat-row pad-top0px pad-bottom80px bg-f4f4f4">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pricing-table three-columns">
                                        <div class="price-column">
                                            <div class="column-container">
                                                <div class="plan">PulseSilver</div>
                                                <div class="price">
                                                    <span class="symbol">$</span><span class="prices">5</span>
                                                    <div class="ide">Per user / month</div>
                                                </div>
                                                <ul class="features">
                                                    <li>Individualized weekly and monthly wellness targets personalized for you based on your age, weight, height and comorbidities.</li>
                                                    <li>Real-time activity tracking through Pulse Wearables that is automatically recorded on the Pulse Health App</li>
                                                    <li>Weekly activity reports to help you stay on top of your wellness targets</li>
                                                    <li> Earn up to 30 000 Pulse Points through achieving your monthly targets</li>
                                                    <li>Redeem points for Rewards and Purchases in the Pulse Store.</li>
                                                    <li>Exclusive access to Pulse marathons, Walkathons and Zumba Sessions.</li>
                                                    <li>Discounts of up to 10% at Pulse Partner Restaurants</li>
                                                </ul>
                                                <br>
                                                <div class="cta"><a class="button" href="{{route('pulsesilver')}}">Get Started</a></div>
                                            </div>
                                        </div><!-- /.price-column -->

                                        <div class="price-column highlight">
                                            <div class="column-container">
                                                <div class="plan">PulseGold</div>
                                                <div class="price">
                                                    <span class="symbol">$</span><span class="prices">10</span>
                                                    <div class="ide">Per user / month</div>
                                                </div>
                                                <ul class="features">
                                                    <li>Individualized weekly and monthly wellness targets personalized for you based on your age, weight, height and comorbidities.</li>
                                                    <li>Real-time activity tracking through Pulse Wearables that is automatically recorded on the Pulse Health App</li>
                                                    <li>Weekly activity reports to help you stay on top of your wellness targets</li>

                                                    <li>Earn up to 50 000 Pulse Points through achieving your monthly targets</li>
                                                    <li>Redeem points for Rewards and Purchases in the Pulse Store.</li>
                                                    <li>Exclusive access to Pulse marathons, Walkathons and Zumba Sessions.</li>
                                                    <li>Discounts of up to 20% at Pulse Partner Restaurants</li>
                                                </ul>
                                                <br>
                                                <div class="cta"><a class="button" href="{{route('pulsegold')}}">Get Started</a></div>
                                            </div>
                                        </div><!-- /.price-column -->

                                        <div class="price-column">
                                            <div class="column-container">
                                                <div class="plan">PulsePlatinum</div>
                                                <div class="price">
                                                    <span class="symbol">$</span><span class="prices">15</span>
                                                    <div class="ide">Per user / month</div>
                                                </div>
                                                <ul class="features">
                                                    <li> Individualized weekly and monthly wellness targets personalized for you based on your age, weight, height and comorbidities.</li>
                                                    <li>Access to Personal Pulse Fitness trainer to help encourage you towards your fitness goals</li>
                                                    <li>Access to a Personalized Diet and Eating Plan created exclusively for you by a Pulse Dietician</li>
                                                    <li>Earn up to 75 000 Pulse Points through achieving your monthly targets</li>
                                                    <li>Redeem points for Rewards and Purchases in the Pulse Store.</li>
                                                    <li>Discounts of up to 20% at Pulse Partner Restaurants</li>
                                                    <li>Redeem Pulse Points for Miles at Partner Airlines</li>

                                                </ul>

                                                <br><br>
                                              
                                                <div class="cta"><a class="button" href="{{route('pulseplatnum')}}">Get Started</a></div>
                                            </div>
                                        </div><!-- /.price-column -->
                                    </div><!-- /.pricing-table -->
                                </div><!-- /.col-md-12 -->
                            </div><!-- /.row -->
                        </div><!-- /.container -->
                    </div><!-- /.flat-row -->
                </div><!-- /.page-body -->
            </div><!-- /#site-content -->


            <div id="site-content">
                <div id="page-header">
                    <div class="container">
                        <div class="row">
                            <div class="page-title">
                                <h2 class="title">Get more with Pulse</h2>
                            </div>
                            <div id="page-breadcrumbs">
                                <nav class="breadcrumb-trail breadcrumbs">
                                    <h2 class="trail-browse">Explore More:</h2>

                                </nav>
                            </div>
                        </div><!-- /.row -->
                    </div><!-- /.container -->
                </div><!-- /#page-header -->


                <div class="flat-row parallax parallax4 pad-top40px pad-bottom60px">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="iconbox style_3">
                                    <div class="box-header">
                                        <!-- <div class="box-icon"><i class="fa icons icon-speech"></i></div> -->
                                    </div>
                                    <div class="box-content">

                                        <p>
                                            <img src="{{ env('APP_URL') }}assets/landing/img/service13.png" alt="slider-image" />
                                        </p>

                                        <p class="box-readmore">
                                            Get motivated as you engage with others in community wellness activities not just physically
                                            but also virtually on your PulseHealth App
                                        </p>

                                    </div>
                                </div><!-- /.iconbox -->
                            </div><!-- /.col-md-4 -->
                            <div class="col-md-6">
                                <div class="iconbox style_3">
                                    <div class="box-header">
                                        <!-- <div class="box-icon"><i class="fa icons icon-globe"></i></div> -->
                                        <h4 class="box-title"><a href="/astro_relations"></a></h4>
                                    </div>
                                    <div class="box-content">

                                        <p>
                                            <img src="{{ env('APP_URL') }}assets/landing/img/service9.png" alt="slider-image" />
                                        </p>
                                        <p class="box-readmore">
                                            With PulseHealth all your sweat pays out as you earn PulsePoints which
                                            you can redeem for selected products on the PulseHealth store.
                                        </p>

                                    </div>
                                </div><!-- /.iconbox -->
                            </div><!-- /.col-md-4 -->

                        </div><!-- /.row -->
                    </div><!-- /.container -->
                </div><!-- /.flat-row -->
                <div class="flat-row parallax parallax4 pad-top40px pad-bottom60px">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="iconbox style_3">
                                    <div class="box-header">
                                        <!-- <div class="box-icon"><i class="fa icons icon-speech"></i></div> -->
                                    </div>
                                    <div class="box-content">

                                        <p>
                                            <img src="{{ env('APP_URL') }}assets/landing/img/service15.png" alt="slider-image" />
                                        </p>

                                        <p class="box-readmore">
                                            PulseHealth helps monitor and accurately report health and wellness data of
                                            children doing sporting activities in the form of heartrates, average speed and distance
                                            covered per activity. You can monitor frequency of excercise for school children and device
                                            more helpful wellness plans.
                                        </p>

                                    </div>
                                </div><!-- /.iconbox -->
                            </div><!-- /.col-md-4 -->
                            <div class="col-md-6">
                                <div class="iconbox style_3">
                                    <div class="box-header">
                                        <!-- <div class="box-icon"><i class="fa icons icon-globe"></i></div> -->
                                        <h4 class="box-title"><a href="/astro_relations"></a></h4>
                                    </div>
                                    <div class="box-content">

                                        <p>
                                            <img src="{{ env('APP_URL') }}assets/landing/img/service14.png" alt="slider-image" />
                                        </p>
                                        <br>
                                        <p class="box-readmore">
                                            With recent lifestyle changes brought by the COVID pandemic, we at PulseHealth
                                            have seen the importance of encouraging corporates to keep their staff in physical
                                            wellness. As such we have tailored wellness packages fit to give corporates the right health
                                            and wellness drive to improve their work and sustain lives
                                        </p>

                                    </div>
                                </div><!-- /.iconbox -->
                            </div><!-- /.col-md-4 -->

                        </div><!-- /.row -->
                    </div><!-- /.container -->
                </div><!-- /.flat-row -->

            </div><!-- /#site-content -->
            <div id="site-content">
                <div id="page-header">
                    <div class="container">

                        <div class="row">
                            <div class="page-title">
                                <h2 class="title">See how PulseHealth is transforming lives</h2>
                            </div>
                            <div id="page-breadcrumbs">
                                <nav class="breadcrumb-trail breadcrumbs">
                                    <h2 class="trail-browse">Explore from here:</h2>
                                </nav>
                            </div>
                        </div><!-- /.row -->
                    </div><!-- /.container -->
                </div><!-- /#page-header -->

            </div><!-- /#site-content -->
            <div class="video-section flat-row parallax parallax4 pad-top60px pad-bottom60px">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Video Area Start -->
                            <div class="video-area" style="background-image: url(/assets/landing/img/story.png);background-repeat:no-repeat;background-size:cover">
                                <div class="video-play-btn">
                                    <a href="https://www.youtube.com/watch?v=f5BBJ4ySgpo" target="_blank" class="video_btn"><i class="fa fa-play" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <!-- Video Area Start -->
                            <div class="video-area" style="background-image: url(/assets/landing/img/story2.png);background-repeat:no-repeat;background-size:cover">
                                <div class="video-play-btn">
                                    <a href="https://www.youtube.com/watch?v=f5BBJ4ySgpo" target="_blank" class="video_btn"><i class="fa fa-play" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
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
                <div class="footer-content">
                    <div class="container">
                        <div class="row">
                            <div class="flat-wrapper">
                                <div class="ft-wrap clearfix">
                                    <div class="social-links">
                                        <a href="#"><i class="fas fa-twitter"></i></a>
                                        <a href="#"><i class="fas fa-facebook"></i></a>
                                        <a href="#"><i class="fas fa-youtube"></i></a>
                                        <a href="#"><i class="fas fa-linkedin"></i></a>
                                    </div>
                                    <div class="copyright">
                                        <div class="copyright-content">
                                            Copyright &copy;<script>
                                                document.write(new Date().getFullYear());
                                            </script> <a href="" target="_blank">AstroTechnologyGroup</a>
                                        </div>
                                    </div>
                                </div><!-- /.ft-wrap -->
                            </div><!-- /.flat-wrapper -->
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
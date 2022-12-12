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
                                            </li><!-- /.flat-mega-menu -->                                        </ul><!-- /.menu -->
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
                            <img src="{{ env('APP_URL') }}assets/landing/img/Health.png" alt="slider-image" />
                            <div class="tp-caption sfl title-slide text-left" data-x="left" data-y="203" data-speed="1000" data-start="1000" data-easing="Power3.easeInOut">
                                Fitness motivation<br> to get you in shape

                            </div>

                        </li>

                        <li data-transition="random-static" data-slotamount="7" data-masterspeed="1000" data-saveperformance="on">
                            <img src="{{ env('APP_URL') }}assets/landing/img/Health-4.png" alt="slider-image" />
                            <div class="tp-caption sfl title-slide text-left" data-x="50" data-y="203" data-speed="1000" data-start="1000" data-easing="Power3.easeInOut">
                                Tracking your activity <br>
                                in real-time
                            </div>

                        </li>

                        <li data-transition="slidedown" data-slotamount="7" data-masterspeed="1000" data-saveperformance="on">
                            <img src="{{ env('APP_URL') }}assets/landing/img/Health-5.png" alt="slider-image" />
                            <div class="tp-caption sfl title-slide text-left" data-x="left" data-y="203" data-speed="1000" data-start="1000" data-easing="Power3.easeInOut">
                                Engage with <br>
                                others
                            </div>

                        </li>
                        <li data-transition="slidedown" data-slotamount="7" data-masterspeed="1000" data-saveperformance="on">
                            <img src="{{ env('APP_URL') }}assets/landing/img/Health-6.png" alt="slider-image" />
                            <div class="tp-caption sfl title-slide text-left" data-x="left" data-y="203" data-speed="1000" data-start="1000" data-easing="Power3.easeInOut">
                                Earn more as you <br>
                                stay healthy
                            </div>

                        </li>
                    </ul>
                </div>
            </div>
        </div><!-- /.site-header -->
        <div class="site-content">
        <div id="site-content">
            <div id="page-header">
                <div class="container">
                    <div class="row">
                        <div class="page-title">

                            <h2 class="title">Explore the PulseHealth App</h2>

                        </div>
                        <div id="page-breadcrumbs">
                            <nav class="breadcrumb-trail breadcrumbs">

                            </nav>
                        </div>
                    </div><!-- /.row -->

                </div><!-- /.container -->
            </div><!-- /#page-header -->
     <section class="row left-right-contents">
        <div class="container">
            <div class="row ">
                <div class="col-sm-12 col-md-4 col-md-push-4 text-center wow fadeIn">
                    <img src="{{ env('APP_URL') }}assets/landing/img/screen7.jpeg" alt="">
                </div>
                <div class="col-md-4 col-sm-6 col-md-pull-4 left-content">
                    <div class="media wow fadeInUp">
                        <div class="media-left">
                            <span class="box-icon"><i class="fas fa-users"></i></span>
                        </div>
                        <div class="media-body">
                            <h4>Manage user profile</h4>
                            <p>Register an account with PulseHealth, make changes of your own prefernce
                            to your profile and control who see's and reacts to your profile  </p>
                        </div>
                    </div>
                    <div class="media wow fadeInUp" data-wow-delay="0.3s">
                        <div class="media-left">
                        <span class="box-icon"><i class="fas fa-newspaper"></i></span>
                        </div>
                        <div class="media-body">
                            <h4>Get updated with health and wellness newsfeed</h4>
                            <p>To be more informed on how to live healthy and stay healthy, PulseHealth keeps
                            all users posted and updated on health and wellness information  </p>
                        </div>
                    </div>
                    <div class="media wow fadeInUp" data-wow-delay="0.6s">
                        <div class="media-left">
                            <span class="box-icon"><i class="fas fa-fire"></i></span>
                        </div>
                        <div class="media-body">
                            <h4>Monitor and track calories burnt</h4>
                            <p>Pulse health has technologies and matrices that allow you to monitor
                            and track how you are progressing in maintainging a balanced weight through analysing your calories
                            count </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 right-content">
                    <div class="media wow fadeInUp">
                        <div class="media-left">
                             <span class="box-icon"><i class="fas fa-mobile-alt"></i></span>
                        </div>
                        <div class="media-body">
                            <h4>Scan and connect your wearable</h4>
                            <p>For a better and more informed digital wellness experience, PulseHealth comes
                            bundled with  tracker wearables and smartwatches that users can pair to
                            by scanning the wearable device name and connecting it to the PulseHealth App.  </p>
                        </div>
                    </div>
                    <div class="media wow fadeInUp" data-wow-delay="0.3s">
                        <div class="media-left">
                        <span class="box-icon"><i class="fas fa-road"></i></span>
                        </div>
                        <div class="media-body">
                            <h4>Monitor and track your steps and distance covered</h4>
                            <p>With PulseHealth you can monitor and track the daily steps you take
                            and the distance you cover when connected to the app and running the PulseHealth activities. Users are
                            able to receive notifications easily and also track wellness activities even without carrying their smartphones. </p>
                        </div>
                    </div>
                    <div class="media wow fadeInUp" data-wow-delay="0.6s">
                        <div class="media-left">
                        <span class="box-icon"><i class="fas fa-trophy"></i></span>
                        </div>
                        <div class="media-body">
                            <h4>Earn loyalty points</h4>
                            <p>PulseHealth allows you to earn PulsePoints as you engage in the app activities.
                            Your PulsePoints can then be redeemable from various PulseHealth partners </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
        </div><!-- /#site-content -->

        </div>

        <!-- Site content -->
        <div id="site-content">
            <div id="page-header">
                <div class="container">
                    <div class="row">
                        <div class="page-title">
                            <h2 class="title">See how it works</h2>
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

                <div class="flat-row bg-f4f4f4 pad-top60px pad-bottom20px">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="flat-iconbox-carousel" data-item="4" data-nav="false" data-dots="true" data-auto="true">
                                    <div class="iconbox style_3">
                                        <div class="box-header">
                                            <div class="box-icon">
                                                <img src="{{ env('APP_URL') }}assets/landing/img/screen5.jpg">
                                            </div>
                                            <br>
                                            <h5 class="box-title">Register and <br> Login</h5>
                                        </div>
                                        <div class="box-content">
                                            <span class="font-size-14px"></span>
                                        </div>
                                    </div>
                                    <div class="iconbox style_3">
                                        <div class="box-header">
                                            <div class="box-icon">
                                                <img src="{{ env('APP_URL') }}assets/landing/img/connect.jpg">
                                            </div>
                                            <br>
                                            <h5 class="box-title">Scan and connect <br> your wearable</h5>
                                        </div>
                                        <div class="box-content">
                                            <span class="font-size-14px"></span>
                                        </div>
                                    </div>
                                    <div class="iconbox style_3">
                                        <div class="box-header">
                                            <div class="box-icon">
                                                <img src="{{ env('APP_URL') }}assets/landing/img/screen7.jpeg">
                                            </div>
                                            <br>
                                            <h5 class="box-title">Review  your <br> PulseHealth Dashboard</h5>
                                        </div>
                                        <div class="box-content">
                                            <span class="font-size-14px"></span>
                                        </div>
                                    </div>
                                    <div class="iconbox style_3">
                                        <div class="box-header">
                                            <div class="box-icon">
                                                <img src="{{ env('APP_URL') }}assets/landing/img/screen1.jpg">
                                            </div>
                                            <br>
                                            <h5 class="box-title">Start an activity <br> of choice</h5>
                                        </div>
                                        <div class="box-content">
                                            <span class="font-size-14px"></span>
                                        </div>
                                    </div>
                                    <div class="iconbox style_3">
                                        <div class="box-header">
                                            <div class="box-icon">
                                                <img src="{{ env('APP_URL') }}assets/landing/img/screen4.jpg">
                                            </div>
                                            <br>
                                            <h5 class="box-title">Earn <br> Pulse Points</h5>
                                        </div>
                                        <div class="box-content">
                                            <span class="font-size-14px"></span>
                                        </div>
                                    </div>

                                </div><!-- /.flat-gallery-carousel -->
                            </div><!-- /.col-md-12 -->
                        </div><!-- /.row -->
                    </div><!-- /.container -->
                </div><!-- /.flat-row -->
                <div id="site-content">
            <div id="page-header">
                <div class="container">
                    <div class="row">
                        <div class="page-title">
                            <h2 class="title">Choose your own style </h2>
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
                                        <img src="{{ env('APP_URL') }}assets/landing/img/PulseSpirit.png" alt="slider-image" />
                                        </p>
                                        <p class="box-readmore">
                                        <h2>Trackers</h2>
                                        </p>
                                        <a href="#" class="button lg dark">Shop now <span class="fa fa-arrow-right"></a>
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
                                        <img src="{{ env('APP_URL') }}assets/landing/img/force.jpeg " alt="slider-image" />
                                        </p>
                                        <p class="box-readmore">
                                        <h2>Smartwatches</h2>
                                        </p>
                                        <a href="#" class="button lg dark">Shop now <span class="fa fa-arrow-right"></span></a>
                                    </div>
                                </div><!-- /.iconbox -->
                            </div><!-- /.col-md-4 -->

                        </div><!-- /.row -->
                    </div><!-- /.container -->
                </div><!-- /.flat-row -->


        </div><!-- /#site-content -->


    <div class="site-content">
    <div id="site-content">
                    <div id="page-header">
                        <div class="container">
                            <div class="row">
                                <div class="page-title">
                                    <h2 class="title">See the PulseHealth Stories</h2>
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
            </div>
        <div class="video-section flat-row parallax parallax4 pad-top60px pad-bottom60px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Video Area Start -->
                    <div class="video-area" style="background-image: url({{ env('APP_URL') }}assets/landing/img/pulse3.png);background-repeat:no-repeat;background-size:cover">
                        <div class="video-play-btn">
                            <a href="https://www.youtube.com/watch?v=f5BBJ4ySgpo" target="_blank" class="video_btn"><i class="fa fa-play" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="site-content">
        <div id="site-content">
                    <div id="page-header">
                        <div class="container">
                            <div class="row">
                                <div class="page-title">
                                    <h2 class="title">PulseHealth Benefits</h2>
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

                <div class="flat-row">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="iconbox style_4">
                                    <div class="box-header">
                                        <div class="box-icon">
                                            <i class="fas fa-medkit"></i>
                                        </div>
                                        <h2 class="box-title">Health Education</h2>
                                    </div>
                                    <div class="box-content">
                                        <span class="font-size-14px">Through our Newsfeed section, we aim to promote, maintain and
                                                   improve the health of the community. This entails areas like chronic disease awareness and prevention,
                                                   maternal and infant health, tobacco use and substance abuse,
                                                   injury and violence prevention, mental and behavioral health, nutrition etc.</span>
                                    </div>
                                </div>
                            </div><!-- /.col-md-3 -->
                            <div class="col-md-4">
                                <div class="iconbox style_4">
                                    <div class="box-header">
                                        <div class="box-icon">
                                            <i class="fas fa-heartbeat"></i>
                                        </div>
                                        <h2 class="box-title">Health Checkups</h2>
                                    </div>
                                    <div class="box-content">
                                        <span class="font-size-14px">Having regular health check ups helps to
                                        find problems before they even start. Early detection of any
                                        problems gives one the best chance of fighting diseaases
                                        off without any complications encountered.</span>
                                    </div>
                                </div>
                            </div><!-- /.col-md-3 -->
                            <div class="col-md-4">
                                <div class="iconbox style_4">
                                    <div class="box-header">
                                        <div class="box-icon">
                                        <i class="fas fa-chart-line"></i>
                                        </div>
                                        <h2 class="box-title">
                                            Activity Tracking
                                        </h2>
                                    </div>
                                    <div class="box-content">
                                        <span class="font-size-14px">Activity tracking which comes in many
                                        forms has been proven to improve health outcomes. Tracking motivates one throughout
                                        the day as one is able to track their progress. It is useful as a goal setting tool as it helps
                                        one focus on a clear goal and above all, it keeps one accountable.</span>
                                    </div>
                                </div>
                            </div><!-- /.col-md-3 -->

                        </div><!-- /.row -->

                        <div class="flat-divider d50px"></div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="iconbox style_4">
                                    <div class="box-header">
                                        <div class="box-icon">
                                            <i class="fas fa-bed"></i>
                                        </div>
                                        <h2 class="box-title">Sleep Monitoring</h2>
                                    </div>
                                    <div class="box-content">
                                        <span class="font-size-14px"> As much as being active is important, sleep is also of utmost importance .
                                         Monitoring of sleep will allow one to identify whether they are getting enough sleep as compared
                                         to the amount of activity they have done during the day. Lack of quality sleep affects one's mood, weight, exercise performance, brain health, etc..</span>
                                    </div>
                                </div>
                            </div><!-- /.col-md-3 -->
                            <div class="col-md-4">
                                <div class="iconbox style_4">
                                    <div class="box-header">
                                        <div class="box-icon">
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                        <h2 class="box-title">Data Analytics</h2>
                                    </div>
                                    <div class="box-content">
                                        <span class="font-size-14px">The data collected from the devices is converted into analytics to gain better insights.
                                        These insights assist different partners in coming up with informed wellness programs which are structured to suit
                                        their audience which will ensure a successful program.</span>
                                    </div>
                                </div>
                            </div><!-- /.col-md-3 -->
                            <div class="col-md-4">
                                <div class="iconbox style_4">
                                    <div class="box-header">
                                        <div class="box-icon">
                                        <i class="fas fa-trophy"></i>
                                        </div>
                                        <h2 class="box-title">
                                           Integrated Reward System
                                        </h2>
                                    </div>
                                    <div class="box-content">
                                        <span class="font-size-14px">
                                       Through PulseHealth helps to  incentivize client engagement
                                       in wellness activities by adoptions of an integrated reward system. The reward system allows the system
                                       users to earn points that can be redeemed for real products and services listed by our solution partners.
                                       Redeemeable products vary from fitness gear, groceries, to holiday trips and other accessories.

                                       </span>
                                    </div>
                                </div>
                            </div><!-- /.col-md-3 -->

                        </div><!-- /.row -->
                    </div><!-- /.container -->
                </div><!-- /.flat-row -->

        </div>

    <div  class="site-content">
            <div id="page-header">
                <div class="container">
                    <div class="row">
                        <div class="page-title">
                            <h2 class="title">Get the latest product news and updates from us</h2>
                        </div>
                        <div id="page-breadcrumbs">
                            <nav class="breadcrumb-trail breadcrumbs">
                          </nav>
                        </div>
                    </div><!-- /.row -->
                    <div class="flat-row pad-top40px pad-bottom60px">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <form id="contactform" class="flat-contact-form" method="post" action="./contact/contact-process.php">
                                        <div class="quick-appoinment">
                                     <div class="row">
                                                <div class="col-md-8">
                                                    <input type="text" id="name" name="name" class="input-text-name" placeholder="Enter your email address" required="required">

                                                </div><!-- /.col-md-6 -->
                                                <div class="col-md-4">
                                                    <input type="submit" name="submit" value="Send" class="input-submit">
                                                </div><!-- /.col-md-6 -->

                                            </div><!-- /.row -->

                                            <div class="flat-divider d30px"></div>
                                        </div>
                                    </form>
                                </div><!-- /.col-md-8 -->
                            </div><!-- /.row -->
                        </div><!-- /.container -->
                    </div><!-- /.flat-row -->
                </div><!-- /.container -->
            </div><!-- /#page-header -->
        </div><!-- /#site-content -->

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

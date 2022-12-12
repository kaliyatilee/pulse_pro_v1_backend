<?php

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $timezone = new DateTimeZone('UTC');
    $now->setTimezone($timezone);
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PulseHealth - Own your beat </title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="title" content="  PulseHealth - Own your beat"/>
    <meta name="description" content="PulseHealth - Own your beat"/>
    <meta name="keywords" content="social,socialnetwork,PulseHealth"/>
    <meta name="image" content="{{ env('APP_URL') }}client/img/logo.png"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


    <link rel="stylesheet" href="{{ env('APP_URL') }}client/css/libs/bootstrap-v4.0.0.min.css?v=1.0.8">
    <link rel="stylesheet" href="{{ env('APP_URL') }}client/css/libs/animate.min.css?v=1.0.8">
    <link rel="stylesheet" href="{{ env('APP_URL') }}client/css/libs/materialize.css?v=1.0.8">
    <link rel="stylesheet" href="{{ env('APP_URL') }}client/css/libs/emojionearea.css?v=1.0.8">
    <link rel="stylesheet" href="{{ env('APP_URL') }}client/css/preloader.min.css?v=1.0.8">
    <link rel="stylesheet" href="{{ env('APP_URL') }}client/css/libs/material_icon_fonts/material_icon.css?v=1.0.8">
    <link rel="stylesheet" href="{{ env('APP_URL') }}client/css/apps/common/style.master.css?v=1.0.8">
    <link rel="stylesheet" href="{{ env('APP_URL') }}client/css/apps/common/style.mq.css?v=1.0.8">
    <link rel="stylesheet" href="{{ env('APP_URL') }}client/css/apps/common/style.custom.css?v=1.0.8">
    <link rel="stylesheet" href="{{ env('APP_URL') }}client/css/libs/jquery.fancybox.css?v=1.0.8">
    <link rel="stylesheet" type="text/css" href="{{ env('APP_URL') }}client/css/apps/common/apexcharts.css">
    <link rel="icon" href="../logo_icon.png" type="image/png">

    <script src="{{ env('APP_URL') }}client/js/libs/jquery-3.5.1.min.js?v=1.0.8"></script>
    <script src="{{ env('APP_URL') }}client/js/libs/vuejs/vue-v2.6.11.min.js?v=1.0.8"></script>

    <script src="{{ env('APP_URL') }}client/js/libs/vuejs/vue-plugins/validators.min.js?v=1.0.8"></script>
    <script src="{{ env('APP_URL') }}client/js/libs/vuejs/vue-plugins/vuelidate.min.js?v=1.0.8"></script>
    <script src="{{ env('APP_URL') }}client/js/libs/jquery-plugins/jquery.form-v4.2.2.min.js?v=1.0.8"></script>
    <script src="{{ env('APP_URL') }}client/js/libs/popper.1.12.9.min.js?v=1.0.8"></script>
    <script src="{{ env('APP_URL') }}client/js/libs/bootstrap.v4.0.0.min.js?v=1.0.8"></script>
    <script src="{{ env('APP_URL') }}client/js/libs/afterglow/afterglow.min.js?v=1.0.8"></script>
    <script src="{{ env('APP_URL') }}client/js/libs/sticky-sidebar/source/jquery.sticky-sidebar.js?v=1.0.8"></script>
    <script src="{{ env('APP_URL') }}client/js/master.script.js?v=1.0.8"></script>
    <script src="{{ env('APP_URL') }}client/js/custom.js?v=1.0.8"></script>
    <script src="{{ env('APP_URL') }}client/js/libs/emojioneList.js?v=1.0.8"></script>
    <script src="{{ env('APP_URL') }}client/js/libs/emojionearea.js?v=1.0.8"></script>
    <script src="{{ env('APP_URL') }}client/js/libs/clipboard.min.js?v=1.0.8"></script>
    <script src="{{ env('APP_URL') }}client/js/libs/jquery-plugins/jquery.fancybox.min.js?v=1.0.8"></script>
    <script src="{{ env('APP_URL') }}client/js/libs/lozad.min.js"></script>
</head>

<body class="cl-app-home">

<div data-el="main-content-holder">
    <main class="main-content-container ">
        <div class="main-content-container-inner">
            <div class="left-sb-container sidebar" id="left-sb-container" data-app="left-sidebar">
                <div class="sidebar__inner">
                    <div class="user-info">
                        <div class="avatar">
                            @if(is_null($userdata->image) | $userdata->image == "")

                                <img src="{{$userdata->image}}"
                                     alt="PH">
                            @else
                                <img src="{{$userdata->image}}"
                                     alt="PH">

                            @endif

                        </div>
                        <div class="uname">
                            <h5>
                                    <span class="user-name-holder @if($userdata->is_verified) verified-badge @endif">
                                        {{$userdata->firstname." ".$userdata->lastname}} </span>
                            </h5>
                            <a href="/client/home" data-spa="true">
                                #{{$userdata->membership_number}} </a>
                        </div>
                    </div>
                    <div class="account-stats">
                        <div class="stat-holder">
                            <a href="client/home" data-spa="true">
                                <b data-an="total-posts">{{round($userdata->loyaltpoints,0)}}</b>
                                <span>Points</span>
                            </a>
                        </div>
                        <div class="stat-holder">
                            <b data-an="total-following">{{$friendsdata["count"]}}</b>
                            <span>Friends</span>
                        </div>
                        <div class="stat-holder">
                            <b data-an="total-followers">{{$activitydata["steps"]}}</b>
                            <span>Steps</span>
                        </div>
                    </div>
                    <div class="sidebar-v-nav-wrapper">
                        <ul class="sidebar-v-nav">
                            <li data-navitem="home" class="sidebar-v-nav-item active">
                                    <span class="icon">
                                        <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                             aria-labelledby="homeIconTitle" stroke-width="1.8" stroke-linecap="square"
                                             stroke-linejoin="miter" fill="none">
                                            <path d="M3 10.182V22h18V10.182L12 2z"/>
                                        </svg> </span>
                                <span class="nav-item-holder">
                                        <a href="https://trysoftcolib.com/" data-spa="true">
                                            Home </a>
                                    </span>
                            </li>
                            <li data-navitem="trending" class="sidebar-v-nav-item ">
                                    <span class="icon">
                                        <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                             aria-labelledby="activityIconTitle" stroke-width="1.8"
                                             stroke-linecap="square" stroke-linejoin="miter" fill="none">
                                            <polyline points="21 14 18 14 15 7 10 17 7 11 5 14 3 14"/>
                                        </svg> </span>
                                <span class="nav-item-holder">
                                        <a href="https://trysoftcolib.com//trending" data-spa="true">

                                            Community
                                        </a>
                                    </span>
                            </li>
                            <li data-navitem="search" class="sidebar-v-nav-item ">
                                    <span class="icon">
                                        <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                             aria-labelledby="exploreIconTitle" stroke-width="1.8"
                                             stroke-linecap="square" stroke-linejoin="miter" fill="none">
                                            <polygon points="14.121 14.121 7.05 16.95 9.879 9.879 16.95 7.05"/>
                                            <circle cx="12" cy="12" r="10"/>
                                        </svg> </span>
                                <span class="nav-item-holder">
                                        <a href="https://trysoftcolib.com//search" data-spa="true">
                                            Store</a>
                                    </span>
                            </li>

                            <li data-navitem="chat" class="sidebar-v-nav-item ">
                                    <span class="icon">
                                        <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                             aria-labelledby="envelopeIconTitle" stroke-width="1.8"
                                             stroke-linecap="square" stroke-linejoin="miter" fill="none">
                                            <rect width="20" height="14" x="2" y="5"/>
                                            <path stroke-linecap="round" d="M2 5l10 9 10-9"/>
                                            <path stroke-linecap="round" d="M2 19l6.825-7.8"/>
                                            <path stroke-linecap="round" d="M22 19l-6.844-7.822"/>
                                        </svg> </span>
                                <span class="nav-item-holder">
                                        <a href="https://trysoftcolib.com//chats" data-spa="true">
                                            Notifications <span class="info-indicators" data-an="new-messages"></span>
                                        </a>
                                    </span>
                            </li>
                            <li data-navitem="bookmarks" class="sidebar-v-nav-item ">
                                    <span class="icon">
                                        <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                             aria-labelledby="bookOpenedIconTitle" stroke-width="1.8"
                                             stroke-linecap="square" stroke-linejoin="miter" fill="none">
                                            <path d="M12 6s-2-2-4-2-5 2-5 2v14s3-2 5-2 4 2 4 2c1.333-1.333 2.667-2 4-2 1.333 0 3 .667 5 2V6c-2-1.333-3.667-2-5-2-1.333 0-2.667.667-4 2z"/>
                                            <path stroke-linecap="round" d="M12 6v14"/>
                                        </svg> </span>
                                <span class="nav-item-holder">
                                        <a href="https://trysoftcolib.com//bookmarks" data-spa="true">
                                            Subscriptions </a>
                                    </span>
                            </li>
                            <li data-navitem="profile" class="sidebar-v-nav-item ">
                                    <span class="icon">
                                        <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                             aria-labelledby="userIconTitle" stroke-width="1.8" stroke-linecap="square"
                                             stroke-linejoin="miter" fill="none">
                                            <path stroke-linecap="round"
                                                  d="M5.5,19.5 C7.83333333,18.5 9.33333333,17.6666667 10,17 C11,16 8,16 8,11 C8,7.66666667 9.33333333,6 12,6 C14.6666667,6 16,7.66666667 16,11 C16,16 13,16 14,17 C14.6666667,17.6666667 16.1666667,18.5 18.5,19.5"/>
                                            <circle cx="12" cy="12" r="10"/>
                                        </svg> </span>
                                <span class="nav-item-holder">
                                        <a href="#" data-spa="true">
                                            Profile </a>
                                    </span>
                            </li>
                            <li class="sidebar-v-nav-item">
                                    <span class="icon">
                                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                             aria-labelledby="appsIconTitle" stroke-width="1.8" stroke-linecap="square"
                                             stroke-linejoin="miter" fill="none">
                                            <circle cx="6" cy="6" r="1"/>
                                            <circle cx="12" cy="6" r="1"/>
                                            <circle cx="18" cy="6" r="1"/>
                                            <circle cx="6" cy="12" r="1"/>
                                            <circle cx="12" cy="12" r="1"/>
                                            <circle cx="18" cy="12" r="1"/>
                                            <circle cx="6" cy="18" r="1"/>
                                            <circle cx="12" cy="18" r="1"/>
                                            <circle cx="18" cy="18" r="1"/>
                                        </svg> </span>
                                <span class="nav-item-holder dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            More </a>
                                        <div class="dropdown-menu dropdown-icons">

                                            <a class="dropdown-item" href="https://trysoftcolib.com//settings"
                                               data-spa="true">
                                                <span class="flex-item dropdown-item-icon">
                                                    <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 24 24" aria-labelledby="settingsIconTitle"
                                                         stroke-width="1.8" stroke-linecap="square"
                                                         stroke-linejoin="miter" fill="none">
                                                        <path d="M5.03506429,12.7050339 C5.01187484,12.4731696 5,12.2379716 5,12 C5,11.7620284 5.01187484,11.5268304 5.03506429,11.2949661 L3.20577137,9.23205081 L5.20577137,5.76794919 L7.9069713,6.32070904 C8.28729123,6.0461342 8.69629298,5.80882212 9.12862533,5.61412402 L10,3 L14,3 L14.8713747,5.61412402 C15.303707,5.80882212 15.7127088,6.0461342 16.0930287,6.32070904 L18.7942286,5.76794919 L20.7942286,9.23205081 L18.9649357,11.2949661 C18.9881252,11.5268304 19,11.7620284 19,12 C19,12.2379716 18.9881252,12.4731696 18.9649357,12.7050339 L20.7942286,14.7679492 L18.7942286,18.2320508 L16.0930287,17.679291 C15.7127088,17.9538658 15.303707,18.1911779 14.8713747,18.385876 L14,21 L10,21 L9.12862533,18.385876 C8.69629298,18.1911779 8.28729123,17.9538658 7.9069713,17.679291 L5.20577137,18.2320508 L3.20577137,14.7679492 L5.03506429,12.7050339 Z"/>
                                                        <circle cx="12" cy="12" r="1"/>
                                                    </svg> </span>
                                                <span class="flex-item">
                                                    Profile settings </span>
                                            </a>
                                            <a class="dropdown-item" href="https://trysoftcolib.com//wallet"
                                               data-spa="true">
                                                <span class="flex-item dropdown-item-icon">
                                                    <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 24 24" aria-labelledby="creditCardIconTitle"
                                                         stroke-width="1.8" stroke-linecap="square"
                                                         stroke-linejoin="miter" fill="none">
                                                        <rect width="20" height="14" x="2" y="5" rx="2"/>
                                                        <path d="M2,14 L22,14"/>
                                                    </svg> </span>
                                                <span class="flex-item">
                                                    Wallet <b class="wallet">({{$userdata->loyaltpoints}})</b>
                                                </span>
                                            </a>
                                            <a class="dropdown-item" href="https://trysoftcolib.com//faqs">
                                                <span class="flex-item dropdown-item-icon">
                                                    <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 24 24" aria-labelledby="helpIconTitle"
                                                         stroke-width="1.8" stroke-linecap="square"
                                                         stroke-linejoin="miter" fill="none">
                                                        <path d="M12 14C12 12 13.576002 11.6652983 14.1186858 11.1239516 14.663127 10.5808518 15 9.82976635 15 9 15 7.34314575 13.6568542 6 12 6 11.1040834 6 10.2998929 6.39272604 9.75018919 7.01541737 9.49601109 7.30334431 9.29624369 7.64043912 9.16697781 8.01061095"/>
                                                        <line x1="12" y1="17" x2="12" y2="17"/>
                                                        <circle cx="12" cy="12" r="10"/>
                                                    </svg> </span>
                                                <span class="flex-item">
                                                    Help center </span>
                                            </a>
                                            <a class="dropdown-item" href="https://trysoftcolib.com//ads"
                                               data-spa="true">
                                                <span class="flex-item dropdown-item-icon">
                                                    <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 24 24" aria-labelledby="feedIconTitle"
                                                         stroke-width="1.8" stroke-linecap="square"
                                                         stroke-linejoin="miter" fill="none">
                                                        <circle cx="7.5" cy="7.5" r="2.5"/>
                                                        <path d="M22 13H2"/>
                                                        <path d="M18 6h-5m5 3h-5"/>
                                                        <path d="M5 2h14a3 3 0 0 1 3 3v17H2V5a3 3 0 0 1 3-3z"/>
                                                    </svg> </span>
                                                <span class="flex-item">
                                                    Promotions </span>
                                            </a>
                                            <div class="dropdown-divider"></div>

                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">

                                                <span class="flex-item dropdown-item-icon">
                                                    <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 24 24" aria-labelledby="exitIconTitle"
                                                         stroke-width="1.8" stroke-linecap="square"
                                                         stroke-linejoin="miter" fill="none">
                                                        <path d="M18 15l3-3-3-3"/>
                                                        <path d="M11.5 12H20"/>
                                                        <path stroke-linecap="round" d="M21 12h-1"/>
                                                        <path d="M15 4v16H4V4z"/>
                                                    </svg> </span>
                                                <span class="flex-item">
                                                    Logout </span>
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                  class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </span>
                            </li>
                        </ul>
                    </div>
                    <div class="mobile-sb-footer">
                        <div class="main-footer">
                            <ul class="footer-nav">
                                <li class="footer-nav-item">
                                    <a href="https://trysoftcolib.com//search">
                                        Explore </a>
                                </li>
                                <li class="footer-nav-item">
                                    <a href="https://trysoftcolib.com//ads">
                                        Advertising </a>
                                </li>
                                <li class="footer-nav-item">
                                    <a href="https://trysoftcolib.com//terms_of_use" data-spa="true">
                                        Terms of Use </a>
                                </li>
                                <li class="footer-nav-item">
                                    <a href="https://trysoftcolib.com//privacy_policy" data-spa="true">
                                        Privacy policy </a>
                                </li>
                                <li class="footer-nav-item">
                                    <a href="https://trysoftcolib.com//cookies_policy" data-spa="true">
                                        Cookies </a>
                                </li>
                                <li class="footer-nav-item">
                                    <a href="https://trysoftcolib.com//about_us" data-spa="true">
                                        About us </a>
                                </li>
                                <li class="footer-nav-item">
                                    <a href="https://trysoftcolib.com//api_docs">
                                        API
                                    </a>
                                </li>
                                <li class="footer-nav-item">
                                    <a href="https://trysoftcolib.com//faqs" data-spa="true">F.A.Q</a>
                                </li>
                                <li class="footer-nav-item dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        Language </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="https://trysoftcolib.com//language/english">
                                            English </a>
                                        <a class="dropdown-item" href="https://trysoftcolib.com//language/french">
                                            French </a>
                                        <a class="dropdown-item" href="https://trysoftcolib.com//language/german">
                                            German </a>
                                        <a class="dropdown-item" href="https://trysoftcolib.com//language/italian">
                                            Italian </a>
                                        <a class="dropdown-item" href="https://trysoftcolib.com//language/russian">
                                            Russian </a>
                                        <a class="dropdown-item" href="https://trysoftcolib.com//language/portuguese">
                                            Portuguese </a>
                                        <a class="dropdown-item" href="https://trysoftcolib.com//language/spanish">
                                            Spanish </a>
                                        <a class="dropdown-item" href="https://trysoftcolib.com//language/turkish">
                                            Turkish </a>
                                        <a class="dropdown-item" href="https://trysoftcolib.com//language/dutch">
                                            Dutch </a>
                                        <a class="dropdown-item" href="https://trysoftcolib.com//language/ukraine">
                                            Ukraine </a>
                                    </div>
                                </li>
                                <li class="footer-nav-item">
                                    <a href="#">&copy; Pulse Wellness, Inc., 2021.</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="publish-post-btn">
                        <button class="btn btn-custom main-inline lg btn-block" data-toggle="modal"
                                data-target="#add_new_post">
                            New post
                        </button>
                    </div>
                </div>
            </div>


            <div data-el="timeline-container-wrapper" class="timeline-container-wrapper">
                <div data-el="timeline-content" class="timeline-container-inner">
                    <div class="timeline-container" data-app="homepage">
                        <div class="timeline-header">
                            <div class="lp">
                                <div class="nav-link-holder">
                                    <a href="https://trysoftcolib.com/" data-spa="true">
                                        Home </a>
                                </div>
                            </div>
                            <div class="cp">
                                <a href="https://trysoftcolib.com/">
                                    <img src="{{ env('APP_URL') }}landing/img/logoo.png" alt="Logo">
                                </a>
                            </div>
                        </div>

                        <div class="main-timeline-pubbox-wrapper">
                            <div class="timeline-pubbox-container">
                                <div class="lp">
                                    <div class="avatar">
                                        @if(is_null($userdata->image) | $userdata->image == "")

                                            <img src=""
                                                 alt="PH">
                                        @else
                                            <img src="{{$userdata->image}}"
                                                 alt="PH">

                                        @endif
                                    </div>
                                </div>
                                <div class="rp">
                                    <form class="form" id="vue-pubbox-app-1" v-on:submit="publish($event)">
                                        <div class="input-holder">
                                            <textarea v-on:input="textarea_resize($event)" class="autoresize"
                                                      name="post_text" placeholder="What is happening? "></textarea>
                                        </div>
                                        <div v-if="show_og_data" class="preview-og-holder">
                                            <div class="preview-og-holder-inner">
                                                <div class="og-image">
                                                    <div v-if="og_data.image" class="og-image-holder"
                                                         v-bind:style="{'background-image': 'url(' + og_data.image + ')'}"></div>
                                                    <div v-else class="og-icon-holder">
                                                        <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                             viewBox="0 0 24 24" aria-labelledby="languageIconTitle"
                                                             stroke-width="1.8" stroke-linecap="square"
                                                             stroke-linejoin="miter" fill="none">
                                                            <circle cx="12" cy="12" r="10"/>
                                                            <path stroke-linecap="round"
                                                                  d="M12,22 C14.6666667,19.5757576 16,16.2424242 16,12 C16,7.75757576 14.6666667,4.42424242 12,2 C9.33333333,4.42424242 8,7.75757576 8,12 C8,16.2424242 9.33333333,19.5757576 12,22 Z"/>
                                                            <path stroke-linecap="round"
                                                                  d="M2.5 9L21.5 9M2.5 15L21.5 15"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="og-url-data">
                                                    <h5>

                                                    </h5>
                                                    <p>

                                                    </p>
                                                    <a v-bind:href="og_data.url" target="_blank">

                                                    </a>
                                                </div>
                                            </div>
                                            <button type="button" class="delete-preview-og" v-on:click="rm_preview_og">
                                                <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                     aria-labelledby="closeIconTitle" stroke-width="1.8"
                                                     stroke-linecap="square" stroke-linejoin="miter" fill="none">
                                                    <path d="M6.34314575 6.34314575L17.6568542 17.6568542M6.34314575 17.6568542L17.6568542 6.34314575"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div v-if="active_media == 'image'" class="preview-images-holder">
                                            <div class="preview-images-list" data-an="post-images">
                                                <div v-for="img in images" class="preview-images-list-item"
                                                     v-bind:style="{height: equal_height}">
                                                    <div class="li-inner-content">
                                                        <img v-bind:src="img.url" alt="Image">
                                                        <button type="button" class="delete-preview-image"
                                                                v-on:click="delete_image(img.id)">
                                                            <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                                 viewBox="0 0 24 24" aria-labelledby="closeIconTitle"
                                                                 stroke-width="1.8" stroke-linecap="square"
                                                                 stroke-linejoin="miter" fill="none">
                                                                <path d="M6.34314575 6.34314575L17.6568542 17.6568542M6.34314575 17.6568542L17.6568542 6.34314575"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="active_media == 'video'" class="preview-video-holder">
                                            <div class="video-player" id="preview-video">
                                                <video v-bind:poster="video.poster" data-el="colibrism-video"
                                                       width="550" height="300" controls="true" type="video/mp4">
                                                    <source type="video/mp4" v-bind:src="video.source"/>
                                                </video>
                                            </div>
                                            <button type="button" class="delete-preview-video"
                                                    v-on:click="delete_video">
                                                <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                     aria-labelledby="closeIconTitle" stroke-width="1.8"
                                                     stroke-linecap="square" stroke-linejoin="miter" fill="none">
                                                    <path d="M6.34314575 6.34314575L17.6568542 17.6568542M6.34314575 17.6568542L17.6568542 6.34314575"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div v-if="active_media == 'gifs'" class="preview-gifs-holder">
                                            <div class="preview-original-gif loading" v-if="gif_source">
                                                <img v-bind:src="gif_source" alt="GIF-Image"
                                                     v-on:load="rm_gif_preloader($event)">
                                                <div class="gif-preloader">
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                         viewBox="0 0 40 40" enable-background="new 0 0 40 40"
                                                         xml:space="preserve">
                                                            <path opacity="0.6" fill="#8EC741"
                                                                  d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946 s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634 c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"></path>
                                                        <path fill="#8EC741"
                                                              d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0 C22.32,8.481,24.301,9.057,26.013,10.047z"
                                                              transform="rotate(299.57 20 20)">
                                                            <animateTransform attributeType="xml"
                                                                              attributeName="transform" type="rotate"
                                                                              from="0 20 20" to="360 20 20" dur="0.7s"
                                                                              repeatCount="indefinite"></animateTransform>
                                                        </path>
                                                        </svg>
                                                </div>
                                                <button type="button" class="delete-preview-gif"
                                                        v-on:click="rm_preview_gif">
                                                    <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 24 24" aria-labelledby="closeIconTitle"
                                                         stroke-width="1.8" stroke-linecap="square"
                                                         stroke-linejoin="miter" fill="none">
                                                        <path d="M6.34314575 6.34314575L17.6568542 17.6568542M6.34314575 17.6568542L17.6568542 6.34314575"/>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="preview-gifs-loader" v-else-if="gifs">
                                                <div class="search-bar-holder">
                                                    <input v-on:input="search_gifs($event)" type="text"
                                                           class="form-control" placeholder="Search GIF-files">
                                                    <a href="#">
                                                        <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                             viewBox="0 0 24 24" aria-labelledby="searchIconTitle"
                                                             stroke-width="1.8" stroke-linecap="square"
                                                             stroke-linejoin="miter" fill="none">
                                                            <path d="M14.4121122,14.4121122 L20,20"/>
                                                            <circle cx="10" cy="10" r="6"/>
                                                        </svg>
                                                    </a>
                                                    <button type="button" v-on:click="close_gifs">
                                                        <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                             viewBox="0 0 24 24" aria-labelledby="closeIconTitle"
                                                             stroke-width="1.8" stroke-linecap="square"
                                                             stroke-linejoin="miter" fill="none">
                                                            <path d="M6.34314575 6.34314575L17.6568542 17.6568542M6.34314575 17.6568542L17.6568542 6.34314575"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="preview-gifs-list" data-an="post-gifs">
                                                    <div class="row-column row-1">
                                                        <div v-for="gif_data in gifs_r1" class="preview-gifs-list-item">
                                                            <div class="li-inner-content loading">
                                                                <img v-on:click="preview_gif($event)"
                                                                     v-bind:src="gif_data.thumb"
                                                                     v-bind:data-source="gif_data.src" alt="GIF-Image"
                                                                     v-on:load="rm_gif_preloader($event)">
                                                                <div class="gif-preloader">
                                                                    <svg version="1.1"
                                                                         xmlns="http://www.w3.org/2000/svg"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         x="0px" y="0px" viewBox="0 0 40 40"
                                                                         enable-background="new 0 0 40 40"
                                                                         xml:space="preserve">
                                                                            <path opacity="0.6" fill="#8EC741"
                                                                                  d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946 s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634 c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"></path>
                                                                        <path fill="#8EC741"
                                                                              d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0 C22.32,8.481,24.301,9.057,26.013,10.047z"
                                                                              transform="rotate(299.57 20 20)">
                                                                            <animateTransform attributeType="xml"
                                                                                              attributeName="transform"
                                                                                              type="rotate"
                                                                                              from="0 20 20"
                                                                                              to="360 20 20" dur="0.7s"
                                                                                              repeatCount="indefinite"></animateTransform>
                                                                        </path>
                                                                        </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row-column row-2">
                                                        <div v-for="gif_data in gifs_r2" class="preview-gifs-list-item">
                                                            <div class="li-inner-content loading">
                                                                <img v-on:click="preview_gif($event)"
                                                                     v-bind:src="gif_data.thumb"
                                                                     v-bind:data-source="gif_data.src" alt="GIF-Image"
                                                                     v-on:load="rm_gif_preloader($event)">
                                                                <div class="gif-preloader">
                                                                    <svg version="1.1"
                                                                         xmlns="http://www.w3.org/2000/svg"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         x="0px" y="0px" viewBox="0 0 40 40"
                                                                         enable-background="new 0 0 40 40"
                                                                         xml:space="preserve">
                                                                            <path opacity="0.6" fill="#8EC741"
                                                                                  d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946 s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634 c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"></path>
                                                                        <path fill="#8EC741"
                                                                              d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0 C22.32,8.481,24.301,9.057,26.013,10.047z"
                                                                              transform="rotate(299.57 20 20)">
                                                                            <animateTransform attributeType="xml"
                                                                                              attributeName="transform"
                                                                                              type="rotate"
                                                                                              from="0 20 20"
                                                                                              to="360 20 20" dur="0.7s"
                                                                                              repeatCount="indefinite"></animateTransform>
                                                                        </path>
                                                                        </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-ctrls-holder">
                                            <button type="button" class="ctrl-item" v-on:click="select_images"
                                                    v-bind:disabled="image_ctrl != true">
                                                <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                     aria-labelledby="imageIconTitle" stroke-width="1.8"
                                                     stroke-linecap="square" stroke-linejoin="miter" fill="none">
                                                    <rect width="18" height="18" x="3" y="3"/>
                                                    <path stroke-linecap="round" d="M3 14l4-4 11 11"/>
                                                    <circle cx="13.5" cy="7.5" r="2.5"/>
                                                    <path stroke-linecap="round" d="M13.5 16.5L21 9"/>
                                                </svg>
                                            </button>
                                            <button type="button" class="ctrl-item" v-on:click="select_video"
                                                    v-bind:disabled="video_ctrl != true">
                                                <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                     aria-labelledby="filmIconTitle" stroke-width="1.8"
                                                     stroke-linecap="square" stroke-linejoin="miter" fill="none">
                                                    <path stroke-linecap="round"
                                                          d="M16 10.087l5-1.578v7.997l-4.998-1.578"/>
                                                    <path d="M16 7H3v11h13z"/>
                                                </svg>
                                            </button>
                                            <button v-on:click="emoji_picker('toggle')" type="button" class="ctrl-item">
                                                <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                     aria-labelledby="happyFaceIconTitle" stroke-width="1.8"
                                                     stroke-linecap="square" stroke-linejoin="miter" fill="none">
                                                    <path d="M7.3010863,14.0011479 C8.0734404,15.7578367 9.98813711,17 11.9995889,17 C14.0024928,17 15.913479,15.7546194 16.6925307,14.0055328"/>
                                                    <line stroke-linecap="round" x1="9" y1="9" x2="9" y2="9"/>
                                                    <line stroke-linecap="round" x1="15" y1="9" x2="15" y2="9"/>
                                                    <circle cx="12" cy="12" r="10"/>
                                                </svg>
                                            </button>

                                        </div>
                                        <div class="post-privacy-holder">
                                            <div class="d-flex align-items-center flex-wn">
                                                <div class="flex-item" v-if="post_privacy">
                                                    <button class="privacy-settings dropdown" type="button">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                                <span class="d-inline-flex align-items-center flex-wn">
                                                                    <span class="flex-item icon"
                                                                          v-if="post_privacy == 'everyone'">
                                                                        <svg role="img"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             viewBox="0 0 24 24"
                                                                             aria-labelledby="languageIconTitle"
                                                                             stroke-width="1.8" stroke-linecap="square"
                                                                             stroke-linejoin="miter" fill="none">
                                                                            <circle cx="12" cy="12" r="10"/>
                                                                            <path stroke-linecap="round"
                                                                                  d="M12,22 C14.6666667,19.5757576 16,16.2424242 16,12 C16,7.75757576 14.6666667,4.42424242 12,2 C9.33333333,4.42424242 8,7.75757576 8,12 C8,16.2424242 9.33333333,19.5757576 12,22 Z"/>
                                                                            <path stroke-linecap="round"
                                                                                  d="M2.5 9L21.5 9M2.5 15L21.5 15"/>
                                                                        </svg> </span>
                                                                    <span class="flex-item icon"
                                                                          v-else-if="post_privacy == 'mentioned'">
                                                                        <svg viewBox="0 0 24 24"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             aria-labelledby="earIconTitle"
                                                                             stroke-width="1.8" stroke-linecap="square"
                                                                             stroke-linejoin="miter" fill="none">
                                                                            <path d="M6 10C6 6.13401 9.13401 3 13 3C16.866 3 20 6.13401 20 10C20 12.8721 18.2043 15.0806 16.5 17C15.0668 18.6141 14.5 22 11 22C9.87418 22 8.83526 21.6279 7.99951 21"/>
                                                                            <path d="M10 10C10 8.34315 11.3431 7 13 7C14.6569 7 16 8.34315 16 10C16 10.7684 15.7111 11.4692 15.2361 12"/>
                                                                        </svg> </span>
                                                                    <span class="flex-item icon" v-else>
                                                                        <svg role="img"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             viewBox="0 0 24 24"
                                                                             aria-labelledby="peopleIconTitle"
                                                                             stroke-width="1.8" stroke-linecap="square"
                                                                             stroke-linejoin="miter" fill="none">
                                                                            <path d="M1 18C1 15.75 4 15.75 5.5 14.25 6.25 13.5 4 13.5 4 9.75 4 7.25025 4.99975 6 7 6 9.00025 6 10 7.25025 10 9.75 10 13.5 7.75 13.5 8.5 14.25 10 15.75 13 15.75 13 18M12.7918114 15.7266684C13.2840551 15.548266 13.6874862 15.3832994 14.0021045 15.2317685 14.552776 14.9665463 15.0840574 14.6659426 15.5 14.25 16.25 13.5 14 13.5 14 9.75 14 7.25025 14.99975 6 17 6 19.00025 6 20 7.25025 20 9.75 20 13.5 17.75 13.5 18.5 14.25 20 15.75 23 15.75 23 18"/>
                                                                            <path stroke-linecap="round"
                                                                                  d="M12,16 C12.3662741,15.8763472 12.6302112,15.7852366 12.7918114,15.7266684"/>
                                                                        </svg> </span>
                                                                    <span class="flex-item flex-grow-1 label">

                                                                    </span>
                                                                </span>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-icons">
                                                            <a class="dropdown-item" href="javascript:void(0);"
                                                               v-on:click="post_privacy = 'everyone'">
                                                                    <span class="flex-item dropdown-item-icon">
                                                                        <svg role="img"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             viewBox="0 0 24 24"
                                                                             aria-labelledby="languageIconTitle"
                                                                             stroke-width="1.8" stroke-linecap="square"
                                                                             stroke-linejoin="miter" fill="none">
                                                                            <circle cx="12" cy="12" r="10"/>
                                                                            <path stroke-linecap="round"
                                                                                  d="M12,22 C14.6666667,19.5757576 16,16.2424242 16,12 C16,7.75757576 14.6666667,4.42424242 12,2 C9.33333333,4.42424242 8,7.75757576 8,12 C8,16.2424242 9.33333333,19.5757576 12,22 Z"/>
                                                                            <path stroke-linecap="round"
                                                                                  d="M2.5 9L21.5 9M2.5 15L21.5 15"/>
                                                                        </svg> </span>
                                                                <span class="flex-item ">
                                                                        Everyone </span>
                                                            </a>

                                                            <a class="dropdown-item" href="javascript:void(0);"
                                                               v-on:click="post_privacy = 'followers'">
                                                                    <span class="flex-item dropdown-item-icon">
                                                                        <svg role="img"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             viewBox="0 0 24 24"
                                                                             aria-labelledby="peopleIconTitle"
                                                                             stroke-width="1.8" stroke-linecap="square"
                                                                             stroke-linejoin="miter" fill="none">
                                                                            <path d="M1 18C1 15.75 4 15.75 5.5 14.25 6.25 13.5 4 13.5 4 9.75 4 7.25025 4.99975 6 7 6 9.00025 6 10 7.25025 10 9.75 10 13.5 7.75 13.5 8.5 14.25 10 15.75 13 15.75 13 18M12.7918114 15.7266684C13.2840551 15.548266 13.6874862 15.3832994 14.0021045 15.2317685 14.552776 14.9665463 15.0840574 14.6659426 15.5 14.25 16.25 13.5 14 13.5 14 9.75 14 7.25025 14.99975 6 17 6 19.00025 6 20 7.25025 20 9.75 20 13.5 17.75 13.5 18.5 14.25 20 15.75 23 15.75 23 18"/>
                                                                            <path stroke-linecap="round"
                                                                                  d="M12,16 C12.3662741,15.8763472 12.6302112,15.7852366 12.7918114,15.7266684"/>
                                                                        </svg> </span>
                                                                <span class="flex-item ">
                                                                        Only my followers </span>
                                                            </a>
                                                        </div>
                                                    </button>
                                                </div>
                                                <div class="flex-item ml-auto">
                                                    <button v-bind:disabled="valid_form != true" type="submit"
                                                            class="btn-custom main-inline md post-pub-btn">
                                                        Publish
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <input multiple="multiple" type="file" class="d-none" data-an="images-input"
                                               accept="image/*" v-on:change="myuploads_images($event)">
                                        <input type="file" class="d-none" data-an="video-input" accept="video/*"
                                               v-on:change="myuploads_video($event)">
                                        <input type="hidden" class="d-none"
                                               value="1621282486:d05785002742a30502dde3731b28883334e46040" name="hash">
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="timeline-posts-container">
                            <div class="timeline-posts-ls" data-an="entry-list">


                                @if(is_null($posts))
                                    {{--    if post empty   --}}
                                    <div class="empty-user-timeline">
                                        <div class="icon">
                                            <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 aria-labelledby="feedIconTitle" stroke-width="1.8"
                                                 stroke-linecap="square" stroke-linejoin="miter" fill="none">
                                                <circle cx="7.5" cy="7.5" r="2.5"></circle>
                                                <path d="M22 13H2"></path>
                                                <path d="M18 6h-5m5 3h-5"></path>
                                                <path d="M5 2h14a3 3 0 0 1 3 3v17H2V5a3 3 0 0 1 3-3z"></path>
                                            </svg>
                                        </div>
                                        <div class="pl-message">
                                            <h4>
                                                No posts yet! </h4>
                                            <p>
                                                It looks like there are no posts on your feed yet. All your posts and
                                                publications of people you follow will be displayed here. </p>
                                        </div>
                                        <div class="c2action-single">
                                            <button class="btn btn-custom main-outline lg" data-toggle="modal"
                                                    data-target="#add_new_post">
                                                Create my first post
                                            </button>
                                        </div>
                                    </div>
                                    {{--    if post empty   --}}
                                @else

                                    @foreach($posts as $post)
                                        @if($post->type == "text")
                                            <div class="post-list-item" data-list-item="1" data-post-offset="1">
                                                <div class="post-list-item-content">
                                                    <div class="publisher-avatar">
                                                        <div class="avatar-holder">
                                                            <img class="lozad"
                                                                 data-src="{{$post->image}}">
                                                        </div>
                                                    </div>
                                                    <div class="publication-data">

                                                        <div class="publication-data-inner">
                                                            <div class="publisher-info">
                                                                <div class="lp">

                                                                    <b>
										<span class="user-name-holder ">
											{{$post->name}}										</span>
                                                                    </b>
                                                                    <span>
										{{$post->title}}
									</span>
                                                                </div>
                                                                <div class="rp">
								<span class="posted-time">
									<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         aria-labelledby="calendarIconTitle" stroke-width="1.8" stroke-linecap="square"
                                         stroke-linejoin="miter" fill="none">  <path d="M3 5H21V21H3V5Z"/> <path
                                                d="M21 9H3"/> <path d="M7 5V3"/> <path d="M17 5V3"/> </svg>									<time>
										6 hours ago									</time>
								</span>
                                                                </div>
                                                            </div>


                                                            <div class="publication-content">
                                                                <div class="publication-text">
                                                                    <p>
                                                                        {{$post->text}} </p>
                                                                </div>

                                                            </div>

                                                            <div class="publication-footer-ctrls">
                                                                <button class="ctrls-item">
                                                                    <a class="icon"
                                                                       href="https://trysoftcolib.com//thread/1"
                                                                       data-spa="true">
									<span class="icon">
										<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                             aria-labelledby="chatAltIconTitle" stroke-width="1.8"
                                             stroke-linecap="square" stroke-linejoin="miter" fill="none">  <path
                                                    d="M13,17 L7,21 L7,17 L3,17 L3,4 L21,4 L21,17 L13,17 Z"/> </svg>									</span>
                                                                        <span class="num">0</span>
                                                                    </a>
                                                                </button>

                                                                <button class="ctrls-item liked"
                                                                        onclick="SMColibri.like_post('1', this);">
									<span class="icon">
										<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                             aria-labelledby="favouriteIconTitle" stroke-width="1.8"
                                             stroke-linecap="square" stroke-linejoin="miter" fill="none">  <path
                                                    d="M12,21 L10.55,19.7051771 C5.4,15.1242507 2,12.1029973 2,8.39509537 C2,5.37384196 4.42,3 7.5,3 C9.24,3 10.91,3.79455041 12,5.05013624 C13.09,3.79455041 14.76,3 16.5,3 C19.58,3 22,5.37384196 22,8.39509537 C22,12.1029973 18.6,15.1242507 13.45,19.7149864 L12,21 Z"/> </svg>									</span>
                                                                    <span class="num" data-an="likes-count">
										1									</span>
                                                                </button>

                                                                <button onclick="SMColibri.repost('1', this);"
                                                                        class="ctrls-item" data-an="repost-ctrl">
									<span class="icon">
										<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                             aria-labelledby="repeatIconTitle" stroke-width="1.8"
                                             stroke-linecap="square" stroke-linejoin="miter" fill="none">  <path
                                                    d="M2 13.0399V11C2 7.68629 4.68629 5 8 5H21V5"/> <path
                                                    d="M19 2L22 5L19 8"/> <path
                                                    d="M22 9.98004V12.02C22 15.3337 19.3137 18.02 16 18.02H3V18.02"/> <path
                                                    d="M5 21L2 18L5 15"/> </svg>									</span>
                                                                    <span class="num" data-an="reposts-count">
										0									</span>
                                                                </button>

                                                                <button class="ctrls-item"
                                                                        onclick="SMColibri.share_post('https://trysoftcolib.com//thread/1','https%3A%2F%2Ftrysoftcolib.com%2F%2Fthread%2F1');">
								<span class="icon">
									<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                         aria-labelledby="shareIconTitle" stroke-width="1.8" stroke-linecap="square"
                                         stroke-linejoin="miter" fill="none">  <path d="M12 14V6"/> <path
                                                d="M9 8L12 5L15 8"/> <path d="M5 13V18H19V13"/> </svg>								</span>
                                                                </button>
                                                                <button class="ctrls-item dropleft">
                                                                    <a href="#" class="dropdown-toggle icon"
                                                                       data-toggle="dropdown">
                                                                        <svg role="img"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             viewBox="0 0 24 24"
                                                                             aria-labelledby="chevronDownIconTitle"
                                                                             stroke-width="1.8" stroke-linecap="square"
                                                                             stroke-linejoin="miter" fill="none">
                                                                            <polyline points="6 10 12 16 18 10"/>
                                                                        </svg>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-icons">
                                                                        <a class="dropdown-item"
                                                                           href="https://trysoftcolib.com//thread/1"
                                                                           data-spa="true">
										<span class="flex-item dropdown-item-icon">
											<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 aria-labelledby="arrowRightTopIconTitle" stroke-width="1.8"
                                                 stroke-linecap="square" stroke-linejoin="miter" fill="none">  <path
                                                        d="M19 13V5h-8"/> <path stroke-linecap="round" d="M19 5l-1 1"/> <path
                                                        d="M18 6L5 19"/> </svg>										</span>
                                                                            <span class="flex-item">
											Show thread										</span>
                                                                        </a>
                                                                        <a onclick="SMColibri.delete_post('1');"
                                                                           class="dropdown-item col-red"
                                                                           href="javascript:void(0);">
											<span class="flex-item dropdown-item-icon">
												<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                     aria-labelledby="binIconTitle" stroke-width="1.8"
                                                     stroke-linecap="square" stroke-linejoin="miter" fill="none">  <path
                                                            d="M19 6L5 6M14 5L10 5M6 10L6 20C6 20.6666667 6.33333333 21 7 21 7.66666667 21 11 21 17 21 17.6666667 21 18 20.6666667 18 20 18 19.3333333 18 16 18 10"/> </svg>											</span>
                                                                            <span class="flex-item">
												Delete											</span>
                                                                        </a>
                                                                        <a onclick="SMColibri.show_likes('1');"
                                                                           class="dropdown-item"
                                                                           href="javascript:void(0);">
										<span class="flex-item dropdown-item-icon">
											<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 aria-labelledby="favouriteIconTitle" stroke-width="1.8"
                                                 stroke-linecap="square" stroke-linejoin="miter" fill="none">  <path
                                                        d="M12,21 L10.55,19.7051771 C5.4,15.1242507 2,12.1029973 2,8.39509537 C2,5.37384196 4.42,3 7.5,3 C9.24,3 10.91,3.79455041 12,5.05013624 C13.09,3.79455041 14.76,3 16.5,3 C19.58,3 22,5.37384196 22,8.39509537 C22,12.1029973 18.6,15.1242507 13.45,19.7149864 L12,21 Z"/> </svg>										</span>
                                                                            <span class="flex-item">
											Show likes										</span>
                                                                        </a>
                                                                        <a class="dropdown-item"
                                                                           href="javascript:void(0);">
										<span class="flex-item dropdown-item-icon">
											<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 aria-labelledby="bookmarkIconTitle" stroke-width="1.8"
                                                 stroke-linecap="square" stroke-linejoin="miter" fill="none">  <path
                                                        d="M17,6.65881537 L17,19.5857864 L12,16.4078051 L7,19.5857864 L7,6.65881537 C7,5.19039219 8.11928813,4 9.5,4 L14.5,4 C15.8807119,4 17,5.19039219 17,6.65881537 Z"/> </svg>										</span>
                                                                            <span class="flex-item"
                                                                                  onclick="SMColibri.bookmark_post('1', this);">
											Bookmark										</span>
                                                                        </a>
                                                                        <a data-clipboard-text="https://trysoftcolib.com//thread/1"
                                                                           class="dropdown-item clip-board-copy"
                                                                           href="javascript:void(0);">
										<span class="flex-item dropdown-item-icon">
											<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 aria-labelledby="copyIconTitle" stroke-width="1.8"
                                                 stroke-linecap="square" stroke-linejoin="miter" fill="none">  <rect
                                                        width="12" height="14" x="8" y="7"/> <polyline
                                                        points="16 3 4 3 4 17"/> </svg>										</span>
                                                                            <span class="flex-item">
											Copy link										</span>
                                                                        </a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a onclick="SMColibri.share_post('https://trysoftcolib.com//thread/1','https%3A%2F%2Ftrysoftcolib.com%2F%2Fthread%2F1');"
                                                                           class="dropdown-item"
                                                                           href="javascript:void(0);">
										<span class="flex-item dropdown-item-icon">
											<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                 aria-labelledby="shareIconTitle" stroke-width="1.8"
                                                 stroke-linecap="square" stroke-linejoin="miter" fill="none">  <path
                                                        d="M12 14V6"/> <path d="M9 8L12 5L15 8"/> <path
                                                        d="M5 13V18H19V13"/> </svg>										</span>
                                                                            <span class="flex-item">
											Share										</span>
                                                                        </a>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($post->type == "video")
                                            <div class="post-list-item" data-list-item="3" data-post-offset="4">
                                                <div class="post-list-item-content">
                                                    <div class="publisher-avatar">
                                                        <div class="avatar-holder">
                                                            <img class="lozad"
                                                                 data-src="{{$post->image}}">
                                                        </div>
                                                    </div>
                                                    <div class="publication-data">

                                                        <div class="publication-data-inner">
                                                            <div class="publisher-info">
                                                                <div class="lp">
                                                                        <b>
										<span class="user-name-holder @if($post->firstname == "Trynos") verified-badge @endif">
											{{$post->name}}										</span>
                                                                        </b>
                                                                </div>
                                                                <div class="rp">
								<span class="posted-time">
									<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         aria-labelledby="calendarIconTitle" stroke-width="1.8" stroke-linecap="square"
                                         stroke-linejoin="miter" fill="none">  <path d="M3 5H21V21H3V5Z"/> <path
                                                d="M21 9H3"/> <path d="M7 5V3"/> <path d="M17 5V3"/> </svg>

                                    <time>
										{{time_elapsed_string($post->created_at)}}								</time>
								</span>
                                                                </div>
                                                            </div>

                                                            <div style="margin-top: 4%;margin-bottom: 3%;margin-left: 0px">
                                                                <button class="btn-custom main-inline md post-pub-btn">
                                                                    {{$post->title}}
                                                                </button>
                                                            </div>


                                                            <div class="publication-content">
                                                                <div class="publication-text">
                                                                    <p>
                                                                        {{$post->text}} </p>
                                                                </div>

                                                                <div class="lozad-media" data-lozad-media="loading">
                                                                    <div class="publication-image">
                                                                        <a href="{{$post->media_url}}"
                                                                           class="fbox-media">
                                                                            <img class="lozad"
                                                                                 onload="cl_load_media(this);"
                                                                                 onerror="cl_load_media(this);"
                                                                                 src="https://roadmaptoprofit.com/wp-content/uploads/2018/10/video-placeholder.jpg"
                                                                                 alt="Video">
                                                                            <div class="video-icon">
												<span>
													<svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 24 24" aria-labelledby="playIconTitle"
                                                         stroke-width="1.8" stroke-linecap="square"
                                                         stroke-linejoin="miter" fill="none">  <path
                                                                d="M20 12L5 21V3z"/> </svg>												</span>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                    <div class="lozad-preloader"
                                                                         data-lozad-preloader="icon">
                                                                        <div class="icon">
                                                                            <svg role="img"
                                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                                 viewBox="0 0 24 24"
                                                                                 aria-labelledby="videoIconTitle"
                                                                                 stroke-width="1.8"
                                                                                 stroke-linecap="square"
                                                                                 stroke-linejoin="miter" fill="none">
                                                                                <polygon points="18 12 9 16.9 9 7"/>
                                                                                <circle cx="12" cy="12" r="10"/>
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="publication-footer-ctrls">

                                                                <button class="ctrls-item"
                                                                        onclick="SMColibri.like_post('3', this);">
									<span class="icon">
										<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                             aria-labelledby="favouriteIconTitle" stroke-width="1.8"
                                             stroke-linecap="square" stroke-linejoin="miter" fill="none">  <path
                                                    d="M12,21 L10.55,19.7051771 C5.4,15.1242507 2,12.1029973 2,8.39509537 C2,5.37384196 4.42,3 7.5,3 C9.24,3 10.91,3.79455041 12,5.05013624 C13.09,3.79455041 14.76,3 16.5,3 C19.58,3 22,5.37384196 22,8.39509537 C22,12.1029973 18.6,15.1242507 13.45,19.7149864 L12,21 Z"/> </svg>									</span>
                                                                    <span class="num" data-an="likes-count">
										0									</span>
                                                                </button>


                                                                <button class="ctrls-item"
                                                                        onclick="SMColibri.share_post('https://trysoftcolib.com//thread/3','https%3A%2F%2Ftrysoftcolib.com%2F%2Fthread%2F3');">
								<span class="icon">
									<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                         aria-labelledby="shareIconTitle" stroke-width="1.8" stroke-linecap="square"
                                         stroke-linejoin="miter" fill="none">  <path d="M12 14V6"/> <path
                                                d="M9 8L12 5L15 8"/> <path d="M5 13V18H19V13"/> </svg>								</span>
                                                                </button>
                                                                <button class="ctrls-item dropleft">
                                                                    <a href="#" class="dropdown-toggle icon"
                                                                       data-toggle="dropdown">
                                                                        <svg role="img"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             viewBox="0 0 24 24"
                                                                             aria-labelledby="chevronDownIconTitle"
                                                                             stroke-width="1.8" stroke-linecap="square"
                                                                             stroke-linejoin="miter" fill="none">
                                                                            <polyline points="6 10 12 16 18 10"/>
                                                                        </svg>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-icons">
                                                                        <a class="dropdown-item"
                                                                           href="https://trysoftcolib.com//thread/3"
                                                                           data-spa="true">
										<span class="flex-item dropdown-item-icon">
											<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 aria-labelledby="arrowRightTopIconTitle" stroke-width="1.8"
                                                 stroke-linecap="square" stroke-linejoin="miter" fill="none">  <path
                                                        d="M19 13V5h-8"/> <path stroke-linecap="round" d="M19 5l-1 1"/> <path
                                                        d="M18 6L5 19"/> </svg>										</span>
                                                                            <span class="flex-item">
											Show thread										</span>
                                                                        </a>
                                                                        <a onclick="SMColibri.delete_post('3');"
                                                                           class="dropdown-item col-red"
                                                                           href="javascript:void(0);">
											<span class="flex-item dropdown-item-icon">
												<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                     aria-labelledby="binIconTitle" stroke-width="1.8"
                                                     stroke-linecap="square" stroke-linejoin="miter" fill="none">  <path
                                                            d="M19 6L5 6M14 5L10 5M6 10L6 20C6 20.6666667 6.33333333 21 7 21 7.66666667 21 11 21 17 21 17.6666667 21 18 20.6666667 18 20 18 19.3333333 18 16 18 10"/> </svg>											</span>
                                                                            <span class="flex-item">
												Delete											</span>
                                                                        </a>
                                                                        <a onclick="SMColibri.show_likes('3');"
                                                                           class="dropdown-item"
                                                                           href="javascript:void(0);">
										<span class="flex-item dropdown-item-icon">
											<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 aria-labelledby="favouriteIconTitle" stroke-width="1.8"
                                                 stroke-linecap="square" stroke-linejoin="miter" fill="none">  <path
                                                        d="M12,21 L10.55,19.7051771 C5.4,15.1242507 2,12.1029973 2,8.39509537 C2,5.37384196 4.42,3 7.5,3 C9.24,3 10.91,3.79455041 12,5.05013624 C13.09,3.79455041 14.76,3 16.5,3 C19.58,3 22,5.37384196 22,8.39509537 C22,12.1029973 18.6,15.1242507 13.45,19.7149864 L12,21 Z"/> </svg>										</span>
                                                                            <span class="flex-item">
											Show likes										</span>
                                                                        </a>
                                                                        <a class="dropdown-item"
                                                                           href="javascript:void(0);">
										<span class="flex-item dropdown-item-icon">
											<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 aria-labelledby="bookmarkIconTitle" stroke-width="1.8"
                                                 stroke-linecap="square" stroke-linejoin="miter" fill="none">  <path
                                                        d="M17,6.65881537 L17,19.5857864 L12,16.4078051 L7,19.5857864 L7,6.65881537 C7,5.19039219 8.11928813,4 9.5,4 L14.5,4 C15.8807119,4 17,5.19039219 17,6.65881537 Z"/> </svg>										</span>
                                                                            <span class="flex-item"
                                                                                  onclick="SMColibri.bookmark_post('3', this);">
											Bookmark										</span>
                                                                        </a>
                                                                        <a data-clipboard-text="https://trysoftcolib.com//thread/3"
                                                                           class="dropdown-item clip-board-copy"
                                                                           href="javascript:void(0);">
										<span class="flex-item dropdown-item-icon">
											<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 aria-labelledby="copyIconTitle" stroke-width="1.8"
                                                 stroke-linecap="square" stroke-linejoin="miter" fill="none">  <rect
                                                        width="12" height="14" x="8" y="7"/> <polyline
                                                        points="16 3 4 3 4 17"/> </svg>										</span>
                                                                            <span class="flex-item">
											Copy link										</span>
                                                                        </a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a onclick="SMColibri.share_post('https://trysoftcolib.com//thread/3','https%3A%2F%2Ftrysoftcolib.com%2F%2Fthread%2F3');"
                                                                           class="dropdown-item"
                                                                           href="javascript:void(0);">
										<span class="flex-item dropdown-item-icon">
											<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                 aria-labelledby="shareIconTitle" stroke-width="1.8"
                                                 stroke-linecap="square" stroke-linejoin="miter" fill="none">  <path
                                                        d="M12 14V6"/> <path d="M9 8L12 5L15 8"/> <path
                                                        d="M5 13V18H19V13"/> </svg>										</span>
                                                                            <span class="flex-item">
											Share										</span>
                                                                        </a>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($post->type == "image")
                                            <div class="post-list-item" data-list-item="2" data-post-offset="3">
                                                <div class="post-list-item-content">
                                                    <div class="publisher-avatar">
                                                        <div class="avatar-holder">
                                                            <img class="lozad"
                                                                 data-src="{{$post->image}}">
                                                        </div>
                                                    </div>
                                                    <div class="publication-data">

                                                        <div class="publication-data-inner">
                                                            <div class="publisher-info">
                                                                <div class="lp">

                                                                    <b>
										<span class="user-name-holder ">
											{{$post->name}}									</span>
                                                                    </b>

                                                                </div>
                                                                <div class="rp">
								<span class="posted-time">
									<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         aria-labelledby="calendarIconTitle" stroke-width="1.8" stroke-linecap="square"
                                         stroke-linejoin="miter" fill="none">  <path d="M3 5H21V21H3V5Z"/> <path
                                                d="M21 9H3"/> <path d="M7 5V3"/> <path d="M17 5V3"/> </svg>									<time>
										{{time_elapsed_string($post->created_at)}}								</time>
								</span>
                                                                </div>
                                                            </div>
                                                            <div style="margin-top: 4%;margin-bottom: 3%;margin-left: 0px">
                                                                <button class="btn-custom main-inline md post-pub-btn">
                                                                    {{$post->title}}
                                                                </button>
                                                            </div>

                                                            <div class="publication-content">
                                                                <div class="publication-text">
                                                                    <p>
                                                                        {{$post->text}}</p>
                                                                </div>

                                                                <div class="lozad-media" data-lozad-media="loading">
                                                                    <div class="publication-image">
                                                                        <a href="{{$post->media_url}}"
                                                                           class="fbox-media">
                                                                            <img onload="cl_load_media(this);"
                                                                                 onerror="cl_load_media(this);"
                                                                                 class="lozad"
                                                                                 data-src="{{$post->media_url}}"
                                                                                 alt="Picture">
                                                                        </a>
                                                                    </div>
                                                                    <div class="lozad-preloader"
                                                                         data-lozad-preloader="icon">
                                                                        <div class="icon">
                                                                            <svg role="img"
                                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                                 viewBox="0 0 24 24"
                                                                                 aria-labelledby="imageIconTitle"
                                                                                 stroke-width="1.8"
                                                                                 stroke-linecap="square"
                                                                                 stroke-linejoin="miter" fill="none">
                                                                                <rect width="18" height="18" x="3"
                                                                                      y="3"/>
                                                                                <path stroke-linecap="round"
                                                                                      d="M3 14l4-4 11 11"/>
                                                                                <circle cx="13.5" cy="7.5" r="2.5"/>
                                                                                <path stroke-linecap="round"
                                                                                      d="M13.5 16.5L21 9"/>
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="publication-footer-ctrls">


                                                                <button class="ctrls-item"
                                                                        onclick="SMColibri.like_post('2', this);">
									<span class="icon">
										<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                             aria-labelledby="favouriteIconTitle" stroke-width="1.8"
                                             stroke-linecap="square" stroke-linejoin="miter" fill="none">  <path
                                                    d="M12,21 L10.55,19.7051771 C5.4,15.1242507 2,12.1029973 2,8.39509537 C2,5.37384196 4.42,3 7.5,3 C9.24,3 10.91,3.79455041 12,5.05013624 C13.09,3.79455041 14.76,3 16.5,3 C19.58,3 22,5.37384196 22,8.39509537 C22,12.1029973 18.6,15.1242507 13.45,19.7149864 L12,21 Z"/> </svg>									</span>
                                                                    <span class="num" data-an="likes-count">
										0									</span>
                                                                </button>


                                                                <button class="ctrls-item"
                                                                        onclick="SMColibri.share_post('https://trysoftcolib.com//thread/2','https%3A%2F%2Ftrysoftcolib.com%2F%2Fthread%2F2');">
								<span class="icon">
									<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                         aria-labelledby="shareIconTitle" stroke-width="1.8" stroke-linecap="square"
                                         stroke-linejoin="miter" fill="none">  <path d="M12 14V6"/> <path
                                                d="M9 8L12 5L15 8"/> <path d="M5 13V18H19V13"/> </svg>								</span>
                                                                </button>
                                                                <button class="ctrls-item dropleft">
                                                                    <a href="#" class="dropdown-toggle icon"
                                                                       data-toggle="dropdown">
                                                                        <svg role="img"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             viewBox="0 0 24 24"
                                                                             aria-labelledby="chevronDownIconTitle"
                                                                             stroke-width="1.8" stroke-linecap="square"
                                                                             stroke-linejoin="miter" fill="none">
                                                                            <polyline points="6 10 12 16 18 10"/>
                                                                        </svg>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-icons">
                                                                        <a class="dropdown-item"
                                                                           href="https://trysoftcolib.com//thread/2"
                                                                           data-spa="true">
										<span class="flex-item dropdown-item-icon">
											<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 aria-labelledby="arrowRightTopIconTitle" stroke-width="1.8"
                                                 stroke-linecap="square" stroke-linejoin="miter" fill="none">  <path
                                                        d="M19 13V5h-8"/> <path stroke-linecap="round" d="M19 5l-1 1"/> <path
                                                        d="M18 6L5 19"/> </svg>										</span>
                                                                            <span class="flex-item">
											Show thread										</span>
                                                                        </a>
                                                                        <a onclick="SMColibri.delete_post('2');"
                                                                           class="dropdown-item col-red"
                                                                           href="javascript:void(0);">
											<span class="flex-item dropdown-item-icon">
												<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                     aria-labelledby="binIconTitle" stroke-width="1.8"
                                                     stroke-linecap="square" stroke-linejoin="miter" fill="none">  <path
                                                            d="M19 6L5 6M14 5L10 5M6 10L6 20C6 20.6666667 6.33333333 21 7 21 7.66666667 21 11 21 17 21 17.6666667 21 18 20.6666667 18 20 18 19.3333333 18 16 18 10"/> </svg>											</span>
                                                                            <span class="flex-item">
												Delete											</span>
                                                                        </a>
                                                                        <a onclick="SMColibri.show_likes('2');"
                                                                           class="dropdown-item"
                                                                           href="javascript:void(0);">
										<span class="flex-item dropdown-item-icon">
											<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 aria-labelledby="favouriteIconTitle" stroke-width="1.8"
                                                 stroke-linecap="square" stroke-linejoin="miter" fill="none">  <path
                                                        d="M12,21 L10.55,19.7051771 C5.4,15.1242507 2,12.1029973 2,8.39509537 C2,5.37384196 4.42,3 7.5,3 C9.24,3 10.91,3.79455041 12,5.05013624 C13.09,3.79455041 14.76,3 16.5,3 C19.58,3 22,5.37384196 22,8.39509537 C22,12.1029973 18.6,15.1242507 13.45,19.7149864 L12,21 Z"/> </svg>										</span>
                                                                            <span class="flex-item">
											Show likes										</span>
                                                                        </a>
                                                                        <a class="dropdown-item"
                                                                           href="javascript:void(0);">
										<span class="flex-item dropdown-item-icon">
											<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 aria-labelledby="bookmarkIconTitle" stroke-width="1.8"
                                                 stroke-linecap="square" stroke-linejoin="miter" fill="none">  <path
                                                        d="M17,6.65881537 L17,19.5857864 L12,16.4078051 L7,19.5857864 L7,6.65881537 C7,5.19039219 8.11928813,4 9.5,4 L14.5,4 C15.8807119,4 17,5.19039219 17,6.65881537 Z"/> </svg>										</span>
                                                                            <span class="flex-item"
                                                                                  onclick="SMColibri.bookmark_post('2', this);">
											Bookmark										</span>
                                                                        </a>
                                                                        <a data-clipboard-text="https://trysoftcolib.com//thread/2"
                                                                           class="dropdown-item clip-board-copy"
                                                                           href="javascript:void(0);">
										<span class="flex-item dropdown-item-icon">
											<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 aria-labelledby="copyIconTitle" stroke-width="1.8"
                                                 stroke-linecap="square" stroke-linejoin="miter" fill="none">  <rect
                                                        width="12" height="14" x="8" y="7"/> <polyline
                                                        points="16 3 4 3 4 17"/> </svg>										</span>
                                                                            <span class="flex-item">
											Copy link										</span>
                                                                        </a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a onclick="SMColibri.share_post('https://trysoftcolib.com//thread/2','https%3A%2F%2Ftrysoftcolib.com%2F%2Fthread%2F2');"
                                                                           class="dropdown-item"
                                                                           href="javascript:void(0);">
										<span class="flex-item dropdown-item-icon">
											<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                 aria-labelledby="shareIconTitle" stroke-width="1.8"
                                                 stroke-linecap="square" stroke-linejoin="miter" fill="none">  <path
                                                        d="M12 14V6"/> <path d="M9 8L12 5L15 8"/> <path
                                                        d="M5 13V18H19V13"/> </svg>										</span>
                                                                            <span class="flex-item">
											Share										</span>
                                                                        </a>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach




                                @endif

                            </div>
                        </div>

                        <div class="swift-app-container" id="cl-play-swift-vue-app" v-bind:class="{'show': status}">
                            <div class="swift-data-cont">
                                <div class="swift-data">
                                    <div class="swift-data-header">
                                        <div class="swift-data-sliders">
                                            <div v-for="(val, index) in swift_data.swift" class="slider-item"
                                                 v-on:click="slide_to(index)">
                                                <span v-if="curr_swift_id == index"
                                                      v-bind:style="{width: slide_bar_status + '%'}"></span>
                                                <span v-else v-bind:style="{width: val.slide_bar + '%'}"></span>
                                            </div>
                                        </div>
                                        <div class="swift-data-ctrls">
                                            <div class="d-flex flex-row align-items-center flex-wn">
                                                <div class="flex-item">
                                                    <div class="swift-user-info">
                                                        <div class="d-flex ov-h flex-row align-items-center flex-wn">
                                                            <div class="flex-item">
                                                                <div class="avatar">
                                                                    <img v-bind:src="swift_data.avatar" alt="Avatar">
                                                                </div>
                                                            </div>
                                                            <div class="flex-item ov-h flex-grow-1">
                                                                <div class="uname">
                                                                    <h6>
                                                                        <a v-bind:href="swift_data.url"></a> •
                                                                        <time></time>
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-item flex-grow-1">
                                                    <div class="ctrl-group">
                                                        <div class="d-flex flex-row align-items-center flex-wn justify-content-end">
                                                            <div class="flex-item"
                                                                 v-if="swift_data.is_user && curr_swift_views > 0">
                                                                <div class="swift-data-ctrl-item">
                                                                    <button class="dropleft">
                                                                        <a href="#" class="dropdown-toggle icon"
                                                                           data-toggle="dropdown">
                                                                            <svg viewBox="0 0 24 24"
                                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                                 aria-labelledby="eyeIconTitle"
                                                                                 stroke-width="1.8"
                                                                                 stroke-linecap="square"
                                                                                 stroke-linejoin="miter" fill="none">
                                                                                <path d="M22 12C22 12 19 18 12 18C5 18 2 12 2 12C2 12 5 6 12 6C19 6 22 12 22 12Z"/>
                                                                                <circle cx="12" cy="12" r="3"/>
                                                                            </svg>
                                                                        </a>
                                                                        <div class="dropdown-menu">
                                                                            <div class="swift-views">
                                                                                <div class="swift-views-header">
                                                                                    <h6>Views</h6>
                                                                                </div>
                                                                                <div class="swift-views-body">
                                                                                    <div v-for="user in curr_swift.views"
                                                                                         class="view-li">
                                                                                        <div class="d-flex flex-wn align-items-center">
                                                                                            <div class="flex-item">
                                                                                                <div class="avatar">
                                                                                                    <img v-bind:src="user.avatar"
                                                                                                         alt="Img">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="flex-item">
                                                                                                <div class="user-name">
                                                                                                    <a href="#"></a>
                                                                                                    <time></time>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="flex-item" v-if="swift_data.is_user">
                                                                <div class="swift-data-ctrl-item">
                                                                    <button class="btn" v-on:click="delete_swift">
                                                                        <svg role="img"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             viewBox="0 0 24 24"
                                                                             aria-labelledby="binIconTitle"
                                                                             stroke-width="1.8" stroke-linecap="square"
                                                                             stroke-linejoin="miter" fill="none">
                                                                            <path d="M19 6L5 6M14 5L10 5M6 10L6 20C6 20.6666667 6.33333333 21 7 21 7.66666667 21 11 21 17 21 17.6666667 21 18 20.6666667 18 20 18 19.3333333 18 16 18 10"/>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="flex-item">
                                                                <div class="swift-data-ctrl-item">
                                                                    <button class="btn"
                                                                            v-on:click="CLPlaySwift.close();">
                                                                        <svg role="img"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             viewBox="0 0 24 24"
                                                                             aria-labelledby="closeIconTitle"
                                                                             stroke-width="1.8" stroke-linecap="square"
                                                                             stroke-linejoin="miter" fill="none">
                                                                            <path d="M6.34314575 6.34314575L17.6568542 17.6568542M6.34314575 17.6568542L17.6568542 6.34314575"/>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swift-data-body">
                                        <div class="swift-data-item">
                                            <div v-if="curr_swift.type == 'image'" class="swift-data-image">
                                                <img v-bind:src="curr_swift.media.src" alt="swift-img"
                                                     v-on:load="swift_loaded = true" v-on:error="swift_loaded = true">
                                            </div>
                                            <div v-else-if="curr_swift.type == 'video'" class="swift-data-video">
                                                <video ref="video" v-on:loadeddata="swift_loaded = true"
                                                       v-on:error="swift_loaded = true">
                                                    <source type="video/mp4" v-bind:src="curr_swift.media.source"/>
                                                    <source type="video/webm" v-bind:src="curr_swift.media.source"/>
                                                    <source type="video/mov" v-bind:src="curr_swift.media.source"/>
                                                    <source type="video/3gp" v-bind:src="curr_swift.media.source"/>
                                                    <source type="video/ogg" v-bind:src="curr_swift.media.source"/>
                                                </video>
                                            </div>
                                        </div>
                                        <button v-if="has_prev" class="swift-data-slide-ctrl prev"
                                                v-on:click="slide_prev">
                                                <span>
                                                    <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 24 24" aria-labelledby="chevronLeftIconTitle"
                                                         stroke-width="1.8" stroke-linecap="square"
                                                         stroke-linejoin="miter" fill="none">
                                                        <polyline points="14 18 8 12 14 6 14 6"/>
                                                    </svg> </span>
                                        </button>
                                        <button class="swift-data-slide-ctrl pause">
                                                <span v-if="slide_bar_pause" v-on:click="un_pause">
                                                    <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 24 24" aria-labelledby="playIconTitle"
                                                         stroke-width="1.8" stroke-linecap="square"
                                                         stroke-linejoin="miter" fill="none">
                                                        <path d="M20 12L5 21V3z"/>
                                                    </svg> </span>
                                            <span v-else v-on:click="do_pause">
                                                    <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 24 24" aria-labelledby="pauseIconTitle"
                                                         stroke-width="1.8" stroke-linecap="square"
                                                         stroke-linejoin="miter" fill="none">
                                                        <rect width="4" height="16" x="5" y="4"/>
                                                        <rect width="4" height="16" x="15" y="4"/>
                                                    </svg> </span>
                                        </button>
                                        <button v-if="has_next" class="swift-data-slide-ctrl next"
                                                v-on:click="slide_next">
                                                <span>
                                                    <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 24 24" aria-labelledby="chevronRightIconTitle"
                                                         stroke-width="1.8" stroke-linecap="square"
                                                         stroke-linejoin="miter" fill="none">
                                                        <polyline points="10 6 16 12 10 18 10 18"/>
                                                    </svg> </span>
                                        </button>
                                    </div>
                                    <div class="swift-data-footer">
                                        <div v-if="curr_swift.text" class="swift-caption">
                                            <p></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fadeIn vh-center modal-swift-pubbox" data-an="swift-pubbox" tabindex="-1"
                             role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="main---mh--block">
                                            <h5 class="modal-title">Create new swift</h5>
                                            <span class="dismiss-modal" data-dismiss="modal">
                                                    <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 24 24" aria-labelledby="closeIconTitle"
                                                         stroke-width="1.8" stroke-linecap="square"
                                                         stroke-linejoin="miter" fill="none">
                                                        <path d="M6.34314575 6.34314575L17.6568542 17.6568542M6.34314575 17.6568542L17.6568542 6.34314575"/>
                                                    </svg> </span>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form" id="cl-new-swift-vue-app" v-on:submit="publish($event)">
                                            <div class="input-holder">
                                                <textarea v-on:input="textarea_resize($event)" class="autoresize"
                                                          name="swift_text" maxlength="200"
                                                          placeholder="Add signature to swift (Optional)"></textarea>
                                            </div>
                                            <div v-if="active_media == 'image'" class="preview-image-holder">
                                                <div class="preview-image-inner">
                                                    <img v-bind:src="image.url" alt="Image">
                                                    <button type="button" class="delete-preview-image"
                                                            v-on:click="delete_image">
                                                        <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                             viewBox="0 0 24 24" aria-labelledby="closeIconTitle"
                                                             stroke-width="1.8" stroke-linecap="square"
                                                             stroke-linejoin="miter" fill="none">
                                                            <path d="M6.34314575 6.34314575L17.6568542 17.6568542M6.34314575 17.6568542L17.6568542 6.34314575"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div v-if="active_media == 'video'" class="preview-video-holder">
                                                <div class="video-player" id="preview-video">
                                                    <video v-bind:poster="video.poster" data-el="colibrism-video"
                                                           width="550" height="300" controls="true" type="video/mp4">
                                                        <source type="video/mp4" v-bind:src="video.source"/>
                                                    </video>
                                                </div>
                                                <button type="button" class="delete-preview-video"
                                                        v-on:click="delete_video">
                                                    <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 24 24" aria-labelledby="closeIconTitle"
                                                         stroke-width="1.8" stroke-linecap="square"
                                                         stroke-linejoin="miter" fill="none">
                                                        <path d="M6.34314575 6.34314575L17.6568542 17.6568542M6.34314575 17.6568542L17.6568542 6.34314575"/>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="swift-ctrls-holder">
                                                <button type="button" class="ctrl-item" v-on:click="select_images"
                                                        v-bind:disabled="image_ctrl != true">
                                                    <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 24 24" aria-labelledby="imageIconTitle"
                                                         stroke-width="1.8" stroke-linecap="square"
                                                         stroke-linejoin="miter" fill="none">
                                                        <rect width="18" height="18" x="3" y="3"/>
                                                        <path stroke-linecap="round" d="M3 14l4-4 11 11"/>
                                                        <circle cx="13.5" cy="7.5" r="2.5"/>
                                                        <path stroke-linecap="round" d="M13.5 16.5L21 9"/>
                                                    </svg>
                                                </button>
                                                <button type="button" class="ctrl-item" v-on:click="select_video"
                                                        v-bind:disabled="video_ctrl != true">
                                                    <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 24 24" aria-labelledby="filmIconTitle"
                                                         stroke-width="1.8" stroke-linecap="square"
                                                         stroke-linejoin="miter" fill="none">
                                                        <path stroke-linecap="round"
                                                              d="M16 10.087l5-1.578v7.997l-4.998-1.578"/>
                                                        <path d="M16 7H3v11h13z"/>
                                                    </svg>
                                                </button>
                                                <button v-on:click="emoji_picker('toggle')" type="button"
                                                        class="ctrl-item">
                                                    <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 24 24" aria-labelledby="happyFaceIconTitle"
                                                         stroke-width="1.8" stroke-linecap="square"
                                                         stroke-linejoin="miter" fill="none">
                                                        <path d="M7.3010863,14.0011479 C8.0734404,15.7578367 9.98813711,17 11.9995889,17 C14.0024928,17 15.913479,15.7546194 16.6925307,14.0055328"/>
                                                        <line stroke-linecap="round" x1="9" y1="9" x2="9" y2="9"/>
                                                        <line stroke-linecap="round" x1="15" y1="9" x2="15" y2="9"/>
                                                        <circle cx="12" cy="12" r="10"/>
                                                    </svg>
                                                </button>
                                                <button type="button" class="ctrl-item text-length ml-auto">
                                                    <small v-bind:class="{'len-error': (text.length >= 200) }">

                                                    </small>
                                                </button>
                                            </div>
                                            <div class="swift-publisher">
                                                <button v-bind:disabled="valid_form != true" type="submit"
                                                        class="btn-custom main-inline lg btn-block">
                                                    Publish
                                                </button>
                                            </div>

                                            <input type="file" class="d-none" data-an="images-input" accept="image/*"
                                                   v-on:change="upload_images($event)">
                                            <input type="file" class="d-none" data-an="video-input" accept="video/*"
                                                   v-on:change="upload_video($event)">
                                            <input type="hidden" class="d-none"
                                                   value="1621282486:d05785002742a30502dde3731b28883334e46040"
                                                   name="hash">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            /** * Owl Carousel v2.3.4 * Copyright 2013-2018 David Deutsch * Licensed under: SEE LICENSE IN https://github.com/OwlCarousel2/OwlCarousel2/blob/master/LICENSE */ !function (a, b, c, d) {
                                function e(b, c) {
                                    this.settings = null, this.options = a.extend({}, e.Defaults, c), this.$element = a(b), this._handlers = {}, this._plugins = {}, this._supress = {}, this._current = null, this._speed = null, this._coordinates = [], this._breakpoint = null, this._width = null, this._items = [], this._clones = [], this._mergers = [], this._widths = [], this._invalidated = {}, this._pipe = [], this._drag = {
                                        time: null,
                                        target: null,
                                        pointer: null,
                                        stage: {
                                            start: null,
                                            current: null
                                        },
                                        direction: null
                                    }, this._states = {
                                        current: {},
                                        tags: {
                                            initializing: ["busy"],
                                            animating: ["busy"],
                                            dragging: ["interacting"]
                                        }
                                    }, a.each(["onResize", "onThrottledResize"], a.proxy(function (b, c) {
                                        this._handlers[c] = a.proxy(this[c], this)
                                    }, this)), a.each(e.Plugins, a.proxy(function (a, b) {
                                        this._plugins[a.charAt(0).toLowerCase() + a.slice(1)] = new b(this)
                                    }, this)), a.each(e.Workers, a.proxy(function (b, c) {
                                        this._pipe.push({
                                            filter: c.filter,
                                            run: a.proxy(c.run, this)
                                        })
                                    }, this)), this.setup(), this.initialize()
                                }

                                e.Defaults = {
                                    items: 3,
                                    loop: !1,
                                    center: !1,
                                    rewind: !1,
                                    checkVisibility: !0,
                                    mouseDrag: !0,
                                    touchDrag: !0,
                                    pullDrag: !0,
                                    freeDrag: !1,
                                    margin: 0,
                                    stagePadding: 0,
                                    merge: !1,
                                    mergeFit: !0,
                                    autoWidth: !1,
                                    startPosition: 0,
                                    rtl: !1,
                                    smartSpeed: 250,
                                    fluidSpeed: !1,
                                    dragEndSpeed: !1,
                                    responsive: {},
                                    responsiveRefreshRate: 200,
                                    responsiveBaseElement: b,
                                    fallbackEasing: "swing",
                                    slideTransition: "",
                                    info: !1,
                                    nestedItemSelector: !1,
                                    itemElement: "div",
                                    stageElement: "div",
                                    refreshClass: "owl-refresh",
                                    loadedClass: "owl-loaded",
                                    loadingClass: "owl-loading",
                                    rtlClass: "owl-rtl",
                                    responsiveClass: "owl-responsive",
                                    dragClass: "owl-drag",
                                    itemClass: "owl-item",
                                    stageClass: "owl-stage",
                                    stageOuterClass: "owl-stage-outer",
                                    grabClass: "owl-grab"
                                }, e.Width = {
                                    Default: "default",
                                    Inner: "inner",
                                    Outer: "outer"
                                }, e.Type = {
                                    Event: "event",
                                    State: "state"
                                }, e.Plugins = {}, e.Workers = [{
                                    filter: ["width", "settings"],
                                    run: function () {
                                        this._width = this.$element.width()
                                    }
                                }, {
                                    filter: ["width", "items", "settings"],
                                    run: function (a) {
                                        a.current = this._items && this._items[this.relative(this._current)]
                                    }
                                }, {
                                    filter: ["items", "settings"],
                                    run: function () {
                                        this.$stage.children(".cloned").remove()
                                    }
                                }, {
                                    filter: ["width", "items", "settings"],
                                    run: function (a) {
                                        var b = this.settings.margin || "",
                                            c = !this.settings.autoWidth,
                                            d = this.settings.rtl,
                                            e = {
                                                width: "auto",
                                                "margin-left": d ? b : "",
                                                "margin-right": d ? "" : b
                                            };
                                        !c && this.$stage.children().css(e), a.css = e
                                    }
                                }, {
                                    filter: ["width", "items", "settings"],
                                    run: function (a) {
                                        var b = (this.width() / this.settings.items).toFixed(3) - this.settings.margin,
                                            c = null,
                                            d = this._items.length,
                                            e = !this.settings.autoWidth,
                                            f = [];
                                        for (a.items = {
                                            merge: !1,
                                            width: b
                                        }; d--;) c = this._mergers[d], c = this.settings.mergeFit && Math.min(c, this.settings.items) || c, a.items.merge = c > 1 || a.items.merge, f[d] = e ? b * c : this._items[d].width();
                                        this._widths = f
                                    }
                                }, {
                                    filter: ["items", "settings"],
                                    run: function () {
                                        var b = [],
                                            c = this._items,
                                            d = this.settings,
                                            e = Math.max(2 * d.items, 4),
                                            f = 2 * Math.ceil(c.length / 2),
                                            g = d.loop && c.length ? d.rewind ? e : Math.max(e, f) : 0,
                                            h = "",
                                            i = "";
                                        for (g /= 2; g > 0;) b.push(this.normalize(b.length / 2, !0)), h += c[b[b.length - 1]][0].outerHTML, b.push(this.normalize(c.length - 1 - (b.length - 1) / 2, !0)), i = c[b[b.length - 1]][0].outerHTML + i, g -= 1;
                                        this._clones = b, a(h).addClass("cloned").appendTo(this.$stage), a(i).addClass("cloned").prependTo(this.$stage)
                                    }
                                }, {
                                    filter: ["width", "items", "settings"],
                                    run: function () {
                                        for (var a = this.settings.rtl ? 1 : -1, b = this._clones.length + this._items.length, c = -1, d = 0, e = 0, f = []; ++c < b;) d = f[c - 1] || 0, e = this._widths[this.relative(c)] + this.settings.margin, f.push(d + e * a);
                                        this._coordinates = f
                                    }
                                }, {
                                    filter: ["width", "items", "settings"],
                                    run: function () {
                                        var a = this.settings.stagePadding,
                                            b = this._coordinates,
                                            c = {
                                                width: Math.ceil(Math.abs(b[b.length - 1])) + 2 * a,
                                                "padding-left": a || "",
                                                "padding-right": a || ""
                                            };
                                        this.$stage.css(c)
                                    }
                                }, {
                                    filter: ["width", "items", "settings"],
                                    run: function (a) {
                                        var b = this._coordinates.length,
                                            c = !this.settings.autoWidth,
                                            d = this.$stage.children();
                                        if (c && a.items.merge)
                                            for (; b--;) a.css.width = this._widths[this.relative(b)], d.eq(b).css(a.css);
                                        else c && (a.css.width = a.items.width, d.css(a.css))
                                    }
                                }, {
                                    filter: ["items"],
                                    run: function () {
                                        this._coordinates.length < 1 && this.$stage.removeAttr("style")
                                    }
                                }, {
                                    filter: ["width", "items", "settings"],
                                    run: function (a) {
                                        a.current = a.current ? this.$stage.children().index(a.current) : 0, a.current = Math.max(this.minimum(), Math.min(this.maximum(), a.current)), this.reset(a.current)
                                    }
                                }, {
                                    filter: ["position"],
                                    run: function () {
                                        this.animate(this.coordinates(this._current))
                                    }
                                }, {
                                    filter: ["width", "position", "items", "settings"],
                                    run: function () {
                                        var a, b, c, d, e = this.settings.rtl ? 1 : -1,
                                            f = 2 * this.settings.stagePadding,
                                            g = this.coordinates(this.current()) + f,
                                            h = g + this.width() * e,
                                            i = [];
                                        for (c = 0, d = this._coordinates.length; c < d; c++) a = this._coordinates[c - 1] || 0, b = Math.abs(this._coordinates[c]) + f * e, (this.op(a, "<=", g) && this.op(a, ">", h) || this.op(b, "<", g) && this.op(b, ">", h)) && i.push(c);
                                        this.$stage.children(".active").removeClass("active"), this.$stage.children(":eq(" + i.join("), :eq(") + ")").addClass("active"), this.$stage.children(".center").removeClass("center"), this.settings.center && this.$stage.children().eq(this.current()).addClass("center")
                                    }
                                }], e.prototype.initializeStage = function () {
                                    this.$stage = this.$element.find("." + this.settings.stageClass), this.$stage.length || (this.$element.addClass(this.options.loadingClass), this.$stage = a("<" + this.settings.stageElement + ">", {
                                        class: this.settings.stageClass
                                    }).wrap(a("<div/>", {
                                        class: this.settings.stageOuterClass
                                    })), this.$element.append(this.$stage.parent()))
                                }, e.prototype.initializeItems = function () {
                                    var b = this.$element.find(".owl-item");
                                    if (b.length) return this._items = b.get().map(function (b) {
                                        return a(b)
                                    }), this._mergers = this._items.map(function () {
                                        return 1
                                    }), void this.refresh();
                                    this.replace(this.$element.children().not(this.$stage.parent())), this.isVisible() ? this.refresh() : this.invalidate("width"), this.$element.removeClass(this.options.loadingClass).addClass(this.options.loadedClass)
                                }, e.prototype.initialize = function () {
                                    if (this.enter("initializing"), this.trigger("initialize"), this.$element.toggleClass(this.settings.rtlClass, this.settings.rtl), this.settings.autoWidth && !this.is("pre-loading")) {
                                        var a, b, c;
                                        a = this.$element.find("img"), b = this.settings.nestedItemSelector ? "." + this.settings.nestedItemSelector : d, c = this.$element.children(b).width(), a.length && c <= 0 && this.preloadAutoWidthImages(a)
                                    }
                                    this.initializeStage(), this.initializeItems(), this.registerEventHandlers(), this.leave("initializing"), this.trigger("initialized")
                                }, e.prototype.isVisible = function () {
                                    return !this.settings.checkVisibility || this.$element.is(":visible")
                                }, e.prototype.setup = function () {
                                    var b = this.viewport(),
                                        c = this.options.responsive,
                                        d = -1,
                                        e = null;
                                    c ? (a.each(c, function (a) {
                                        a <= b && a > d && (d = Number(a))
                                    }), e = a.extend({}, this.options, c[d]), "function" == typeof e.stagePadding && (e.stagePadding = e.stagePadding()), delete e.responsive, e.responsiveClass && this.$element.attr("class", this.$element.attr("class").replace(new RegExp("(" + this.options.responsiveClass + "-)\\S+\\s", "g"), "$1" + d))) : e = a.extend({}, this.options), this.trigger("change", {
                                        property: {
                                            name: "settings",
                                            value: e
                                        }
                                    }), this._breakpoint = d, this.settings = e, this.invalidate("settings"), this.trigger("changed", {
                                        property: {
                                            name: "settings",
                                            value: this.settings
                                        }
                                    })
                                }, e.prototype.optionsLogic = function () {
                                    this.settings.autoWidth && (this.settings.stagePadding = !1, this.settings.merge = !1)
                                }, e.prototype.prepare = function (b) {
                                    var c = this.trigger("prepare", {
                                        content: b
                                    });
                                    return c.data || (c.data = a("<" + this.settings.itemElement + "/>").addClass(this.options.itemClass).append(b)), this.trigger("prepared", {
                                        content: c.data
                                    }), c.data
                                }, e.prototype.update = function () {
                                    for (var b = 0, c = this._pipe.length, d = a.proxy(function (a) {
                                        return this[a]
                                    }, this._invalidated), e = {}; b < c;) (this._invalidated.all || a.grep(this._pipe[b].filter, d).length > 0) && this._pipe[b].run(e), b++;
                                    this._invalidated = {}, !this.is("valid") && this.enter("valid")
                                }, e.prototype.width = function (a) {
                                    switch (a = a || e.Width.Default) {
                                        case e.Width.Inner:
                                        case e.Width.Outer:
                                            return this._width;
                                        default:
                                            return this._width - 2 * this.settings.stagePadding + this.settings.margin
                                    }
                                }, e.prototype.refresh = function () {
                                    this.enter("refreshing"), this.trigger("refresh"), this.setup(), this.optionsLogic(), this.$element.addClass(this.options.refreshClass), this.update(), this.$element.removeClass(this.options.refreshClass), this.leave("refreshing"), this.trigger("refreshed")
                                }, e.prototype.onThrottledResize = function () {
                                    b.clearTimeout(this.resizeTimer), this.resizeTimer = b.setTimeout(this._handlers.onResize, this.settings.responsiveRefreshRate)
                                }, e.prototype.onResize = function () {
                                    return !!this._items.length && (this._width !== this.$element.width() && (!!this.isVisible() && (this.enter("resizing"), this.trigger("resize").isDefaultPrevented() ? (this.leave("resizing"), !1) : (this.invalidate("width"), this.refresh(), this.leave("resizing"), void this.trigger("resized")))))
                                }, e.prototype.registerEventHandlers = function () {
                                    a.support.transition && this.$stage.on(a.support.transition.end + ".owl.core", a.proxy(this.onTransitionEnd, this)), !1 !== this.settings.responsive && this.on(b, "resize", this._handlers.onThrottledResize), this.settings.mouseDrag && (this.$element.addClass(this.options.dragClass), this.$stage.on("mousedown.owl.core", a.proxy(this.onDragStart, this)), this.$stage.on("dragstart.owl.core selectstart.owl.core", function () {
                                        return !1
                                    })), this.settings.touchDrag && (this.$stage.on("touchstart.owl.core", a.proxy(this.onDragStart, this)), this.$stage.on("touchcancel.owl.core", a.proxy(this.onDragEnd, this)))
                                }, e.prototype.onDragStart = function (b) {
                                    var d = null;
                                    3 !== b.which && (a.support.transform ? (d = this.$stage.css("transform").replace(/.*\(|\)| /g, "").split(","), d = {
                                        x: d[16 === d.length ? 12 : 4],
                                        y: d[16 === d.length ? 13 : 5]
                                    }) : (d = this.$stage.position(), d = {
                                        x: this.settings.rtl ? d.left + this.$stage.width() - this.width() + this.settings.margin : d.left,
                                        y: d.top
                                    }), this.is("animating") && (a.support.transform ? this.animate(d.x) : this.$stage.stop(), this.invalidate("position")), this.$element.toggleClass(this.options.grabClass, "mousedown" === b.type), this.speed(0), this._drag.time = (new Date).getTime(), this._drag.target = a(b.target), this._drag.stage.start = d, this._drag.stage.current = d, this._drag.pointer = this.pointer(b), a(c).on("mouseup.owl.core touchend.owl.core", a.proxy(this.onDragEnd, this)), a(c).one("mousemove.owl.core touchmove.owl.core", a.proxy(function (b) {
                                        var d = this.difference(this._drag.pointer, this.pointer(b));
                                        a(c).on("mousemove.owl.core touchmove.owl.core", a.proxy(this.onDragMove, this)), Math.abs(d.x) < Math.abs(d.y) && this.is("valid") || (b.preventDefault(), this.enter("dragging"), this.trigger("drag"))
                                    }, this)))
                                }, e.prototype.onDragMove = function (a) {
                                    var b = null,
                                        c = null,
                                        d = null,
                                        e = this.difference(this._drag.pointer, this.pointer(a)),
                                        f = this.difference(this._drag.stage.start, e);
                                    this.is("dragging") && (a.preventDefault(), this.settings.loop ? (b = this.coordinates(this.minimum()), c = this.coordinates(this.maximum() + 1) - b, f.x = ((f.x - b) % c + c) % c + b) : (b = this.settings.rtl ? this.coordinates(this.maximum()) : this.coordinates(this.minimum()), c = this.settings.rtl ? this.coordinates(this.minimum()) : this.coordinates(this.maximum()), d = this.settings.pullDrag ? -1 * e.x / 5 : 0, f.x = Math.max(Math.min(f.x, b + d), c + d)), this._drag.stage.current = f, this.animate(f.x))
                                }, e.prototype.onDragEnd = function (b) {
                                    var d = this.difference(this._drag.pointer, this.pointer(b)),
                                        e = this._drag.stage.current,
                                        f = d.x > 0 ^ this.settings.rtl ? "left" : "right";
                                    a(c).off(".owl.core"), this.$element.removeClass(this.options.grabClass), (0 !== d.x && this.is("dragging") || !this.is("valid")) && (this.speed(this.settings.dragEndSpeed || this.settings.smartSpeed), this.current(this.closest(e.x, 0 !== d.x ? f : this._drag.direction)), this.invalidate("position"), this.update(), this._drag.direction = f, (Math.abs(d.x) > 3 || (new Date).getTime() - this._drag.time > 300) && this._drag.target.one("click.owl.core", function () {
                                        return !1
                                    })), this.is("dragging") && (this.leave("dragging"), this.trigger("dragged"))
                                }, e.prototype.closest = function (b, c) {
                                    var e = -1,
                                        f = 30,
                                        g = this.width(),
                                        h = this.coordinates();
                                    return this.settings.freeDrag || a.each(h, a.proxy(function (a, i) {
                                        return "left" === c && b > i - f && b < i + f ? e = a : "right" === c && b > i - g - f && b < i - g + f ? e = a + 1 : this.op(b, "<", i) && this.op(b, ">", h[a + 1] !== d ? h[a + 1] : i - g) && (e = "left" === c ? a + 1 : a), -1 === e
                                    }, this)), this.settings.loop || (this.op(b, ">", h[this.minimum()]) ? e = b = this.minimum() : this.op(b, "<", h[this.maximum()]) && (e = b = this.maximum())), e
                                }, e.prototype.animate = function (b) {
                                    var c = this.speed() > 0;
                                    this.is("animating") && this.onTransitionEnd(), c && (this.enter("animating"), this.trigger("translate")), a.support.transform3d && a.support.transition ? this.$stage.css({
                                        transform: "translate3d(" + b + "px,0px,0px)",
                                        transition: this.speed() / 1e3 + "s" + (this.settings.slideTransition ? " " + this.settings.slideTransition : "")
                                    }) : c ? this.$stage.animate({
                                        left: b + "px"
                                    }, this.speed(), this.settings.fallbackEasing, a.proxy(this.onTransitionEnd, this)) : this.$stage.css({
                                        left: b + "px"
                                    })
                                }, e.prototype.is = function (a) {
                                    return this._states.current[a] && this._states.current[a] > 0
                                }, e.prototype.current = function (a) {
                                    if (a === d) return this._current;
                                    if (0 === this._items.length) return d;
                                    if (a = this.normalize(a), this._current !== a) {
                                        var b = this.trigger("change", {
                                            property: {
                                                name: "position",
                                                value: a
                                            }
                                        });
                                        b.data !== d && (a = this.normalize(b.data)), this._current = a, this.invalidate("position"), this.trigger("changed", {
                                            property: {
                                                name: "position",
                                                value: this._current
                                            }
                                        })
                                    }
                                    return this._current
                                }, e.prototype.invalidate = function (b) {
                                    return "string" === a.type(b) && (this._invalidated[b] = !0, this.is("valid") && this.leave("valid")), a.map(this._invalidated, function (a, b) {
                                        return b
                                    })
                                }, e.prototype.reset = function (a) {
                                    (a = this.normalize(a)) !== d && (this._speed = 0, this._current = a, this.suppress(["translate", "translated"]), this.animate(this.coordinates(a)), this.release(["translate", "translated"]))
                                }, e.prototype.normalize = function (a, b) {
                                    var c = this._items.length,
                                        e = b ? 0 : this._clones.length;
                                    return !this.isNumeric(a) || c < 1 ? a = d : (a < 0 || a >= c + e) && (a = ((a - e / 2) % c + c) % c + e / 2), a
                                }, e.prototype.relative = function (a) {
                                    return a -= this._clones.length / 2, this.normalize(a, !0)
                                }, e.prototype.maximum = function (a) {
                                    var b, c, d, e = this.settings,
                                        f = this._coordinates.length;
                                    if (e.loop) f = this._clones.length / 2 + this._items.length - 1;
                                    else if (e.autoWidth || e.merge) {
                                        if (b = this._items.length)
                                            for (c = this._items[--b].width(), d = this.$element.width(); b-- && !((c += this._items[b].width() + this.settings.margin) > d);) ;
                                        f = b + 1
                                    } else f = e.center ? this._items.length - 1 : this._items.length - e.items;
                                    return a && (f -= this._clones.length / 2), Math.max(f, 0)
                                }, e.prototype.minimum = function (a) {
                                    return a ? 0 : this._clones.length / 2
                                }, e.prototype.items = function (a) {
                                    return a === d ? this._items.slice() : (a = this.normalize(a, !0), this._items[a])
                                }, e.prototype.mergers = function (a) {
                                    return a === d ? this._mergers.slice() : (a = this.normalize(a, !0), this._mergers[a])
                                }, e.prototype.clones = function (b) {
                                    var c = this._clones.length / 2,
                                        e = c + this._items.length,
                                        f = function (a) {
                                            return a % 2 == 0 ? e + a / 2 : c - (a + 1) / 2
                                        };
                                    return b === d ? a.map(this._clones, function (a, b) {
                                        return f(b)
                                    }) : a.map(this._clones, function (a, c) {
                                        return a === b ? f(c) : null
                                    })
                                }, e.prototype.speed = function (a) {
                                    return a !== d && (this._speed = a), this._speed
                                }, e.prototype.coordinates = function (b) {
                                    var c, e = 1,
                                        f = b - 1;
                                    return b === d ? a.map(this._coordinates, a.proxy(function (a, b) {
                                        return this.coordinates(b)
                                    }, this)) : (this.settings.center ? (this.settings.rtl && (e = -1, f = b + 1), c = this._coordinates[b], c += (this.width() - c + (this._coordinates[f] || 0)) / 2 * e) : c = this._coordinates[f] || 0, c = Math.ceil(c))
                                }, e.prototype.duration = function (a, b, c) {
                                    return 0 === c ? 0 : Math.min(Math.max(Math.abs(b - a), 1), 6) * Math.abs(c || this.settings.smartSpeed)
                                }, e.prototype.to = function (a, b) {
                                    var c = this.current(),
                                        d = null,
                                        e = a - this.relative(c),
                                        f = (e > 0) - (e < 0),
                                        g = this._items.length,
                                        h = this.minimum(),
                                        i = this.maximum();
                                    this.settings.loop ? (!this.settings.rewind && Math.abs(e) > g / 2 && (e += -1 * f * g), a = c + e, (d = ((a - h) % g + g) % g + h) !== a && d - e <= i && d - e > 0 && (c = d - e, a = d, this.reset(c))) : this.settings.rewind ? (i += 1, a = (a % i + i) % i) : a = Math.max(h, Math.min(i, a)), this.speed(this.duration(c, a, b)), this.current(a), this.isVisible() && this.update()
                                }, e.prototype.next = function (a) {
                                    a = a || !1, this.to(this.relative(this.current()) + 1, a)
                                }, e.prototype.prev = function (a) {
                                    a = a || !1, this.to(this.relative(this.current()) - 1, a)
                                }, e.prototype.onTransitionEnd = function (a) {
                                    if (a !== d && (a.stopPropagation(), (a.target || a.srcElement || a.originalTarget) !== this.$stage.get(0))) return !1;
                                    this.leave("animating"), this.trigger("translated")
                                }, e.prototype.viewport = function () {
                                    var d;
                                    return this.options.responsiveBaseElement !== b ? d = a(this.options.responsiveBaseElement).width() : b.innerWidth ? d = b.innerWidth : c.documentElement && c.documentElement.clientWidth ? d = c.documentElement.clientWidth : console.warn("Can not detect viewport width."), d
                                }, e.prototype.replace = function (b) {
                                    this.$stage.empty(), this._items = [], b && (b = b instanceof jQuery ? b : a(b)), this.settings.nestedItemSelector && (b = b.find("." + this.settings.nestedItemSelector)), b.filter(function () {
                                        return 1 === this.nodeType
                                    }).each(a.proxy(function (a, b) {
                                        b = this.prepare(b), this.$stage.append(b), this._items.push(b), this._mergers.push(1 * b.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1)
                                    }, this)), this.reset(this.isNumeric(this.settings.startPosition) ? this.settings.startPosition : 0), this.invalidate("items")
                                }, e.prototype.add = function (b, c) {
                                    var e = this.relative(this._current);
                                    c = c === d ? this._items.length : this.normalize(c, !0), b = b instanceof jQuery ? b : a(b), this.trigger("add", {
                                        content: b,
                                        position: c
                                    }), b = this.prepare(b), 0 === this._items.length || c === this._items.length ? (0 === this._items.length && this.$stage.append(b), 0 !== this._items.length && this._items[c - 1].after(b), this._items.push(b), this._mergers.push(1 * b.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1)) : (this._items[c].before(b), this._items.splice(c, 0, b), this._mergers.splice(c, 0, 1 * b.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1)), this._items[e] && this.reset(this._items[e].index()), this.invalidate("items"), this.trigger("added", {
                                        content: b,
                                        position: c
                                    })
                                }, e.prototype.remove = function (a) {
                                    (a = this.normalize(a, !0)) !== d && (this.trigger("remove", {
                                        content: this._items[a],
                                        position: a
                                    }), this._items[a].remove(), this._items.splice(a, 1), this._mergers.splice(a, 1), this.invalidate("items"), this.trigger("removed", {
                                        content: null,
                                        position: a
                                    }))
                                }, e.prototype.preloadAutoWidthImages = function (b) {
                                    b.each(a.proxy(function (b, c) {
                                        this.enter("pre-loading"), c = a(c), a(new Image).one("load", a.proxy(function (a) {
                                            c.attr("src", a.target.src), c.css("opacity", 1), this.leave("pre-loading"), !this.is("pre-loading") && !this.is("initializing") && this.refresh()
                                        }, this)).attr("src", c.attr("src") || c.attr("data-src") || c.attr("data-src-retina"))
                                    }, this))
                                }, e.prototype.destroy = function () {
                                    this.$element.off(".owl.core"), this.$stage.off(".owl.core"), a(c).off(".owl.core"), !1 !== this.settings.responsive && (b.clearTimeout(this.resizeTimer), this.off(b, "resize", this._handlers.onThrottledResize));
                                    for (var d in this._plugins) this._plugins[d].destroy();
                                    this.$stage.children(".cloned").remove(), this.$stage.unwrap(), this.$stage.children().contents().unwrap(), this.$stage.children().unwrap(), this.$stage.remove(), this.$element.removeClass(this.options.refreshClass).removeClass(this.options.loadingClass).removeClass(this.options.loadedClass).removeClass(this.options.rtlClass).removeClass(this.options.dragClass).removeClass(this.options.grabClass).attr("class", this.$element.attr("class").replace(new RegExp(this.options.responsiveClass + "-\\S+\\s", "g"), "")).removeData("owl.carousel")
                                }, e.prototype.op = function (a, b, c) {
                                    var d = this.settings.rtl;
                                    switch (b) {
                                        case "<":
                                            return d ? a > c : a < c;
                                        case ">":
                                            return d ? a < c : a > c;
                                        case ">=":
                                            return d ? a <= c : a >= c;
                                        case "<=":
                                            return d ? a >= c : a <= c
                                    }
                                }, e.prototype.on = function (a, b, c, d) {
                                    a.addEventListener ? a.addEventListener(b, c, d) : a.attachEvent && a.attachEvent("on" + b, c)
                                }, e.prototype.off = function (a, b, c, d) {
                                    a.removeEventListener ? a.removeEventListener(b, c, d) : a.detachEvent && a.detachEvent("on" + b, c)
                                }, e.prototype.trigger = function (b, c, d, f, g) {
                                    var h = {
                                            item: {
                                                count: this._items.length,
                                                index: this.current()
                                            }
                                        },
                                        i = a.camelCase(a.grep(["on", b, d], function (a) {
                                            return a
                                        }).join("-").toLowerCase()),
                                        j = a.Event([b, "owl", d || "carousel"].join(".").toLowerCase(), a.extend({
                                            relatedTarget: this
                                        }, h, c));
                                    return this._supress[b] || (a.each(this._plugins, function (a, b) {
                                        b.onTrigger && b.onTrigger(j)
                                    }), this.register({
                                        type: e.Type.Event,
                                        name: b
                                    }), this.$element.trigger(j), this.settings && "function" == typeof this.settings[i] && this.settings[i].call(this, j)), j
                                }, e.prototype.enter = function (b) {
                                    a.each([b].concat(this._states.tags[b] || []), a.proxy(function (a, b) {
                                        this._states.current[b] === d && (this._states.current[b] = 0), this._states.current[b]++
                                    }, this))
                                }, e.prototype.leave = function (b) {
                                    a.each([b].concat(this._states.tags[b] || []), a.proxy(function (a, b) {
                                        this._states.current[b]--
                                    }, this))
                                }, e.prototype.register = function (b) {
                                    if (b.type === e.Type.Event) {
                                        if (a.event.special[b.name] || (a.event.special[b.name] = {}), !a.event.special[b.name].owl) {
                                            var c = a.event.special[b.name]._default;
                                            a.event.special[b.name]._default = function (a) {
                                                return !c || !c.apply || a.namespace && -1 !== a.namespace.indexOf("owl") ? a.namespace && a.namespace.indexOf("owl") > -1 : c.apply(this, arguments)
                                            }, a.event.special[b.name].owl = !0
                                        }
                                    } else b.type === e.Type.State && (this._states.tags[b.name] ? this._states.tags[b.name] = this._states.tags[b.name].concat(b.tags) : this._states.tags[b.name] = b.tags, this._states.tags[b.name] = a.grep(this._states.tags[b.name], a.proxy(function (c, d) {
                                        return a.inArray(c, this._states.tags[b.name]) === d
                                    }, this)))
                                }, e.prototype.suppress = function (b) {
                                    a.each(b, a.proxy(function (a, b) {
                                        this._supress[b] = !0
                                    }, this))
                                }, e.prototype.release = function (b) {
                                    a.each(b, a.proxy(function (a, b) {
                                        delete this._supress[b]
                                    }, this))
                                }, e.prototype.pointer = function (a) {
                                    var c = {
                                        x: null,
                                        y: null
                                    };
                                    return a = a.originalEvent || a || b.event, a = a.touches && a.touches.length ? a.touches[0] : a.changedTouches && a.changedTouches.length ? a.changedTouches[0] : a, a.pageX ? (c.x = a.pageX, c.y = a.pageY) : (c.x = a.clientX, c.y = a.clientY), c
                                }, e.prototype.isNumeric = function (a) {
                                    return !isNaN(parseFloat(a))
                                }, e.prototype.difference = function (a, b) {
                                    return {
                                        x: a.x - b.x,
                                        y: a.y - b.y
                                    }
                                }, a.fn.owlCarousel = function (b) {
                                    var c = Array.prototype.slice.call(arguments, 1);
                                    return this.each(function () {
                                        var d = a(this),
                                            f = d.data("owl.carousel");
                                        f || (f = new e(this, "object" == typeof b && b), d.data("owl.carousel", f), a.each(["next", "prev", "to", "destroy", "refresh", "replace", "add", "remove"], function (b, c) {
                                            f.register({
                                                type: e.Type.Event,
                                                name: c
                                            }), f.$element.on(c + ".owl.carousel.core", a.proxy(function (a) {
                                                a.namespace && a.relatedTarget !== this && (this.suppress([c]), f[c].apply(this, [].slice.call(arguments, 1)), this.release([c]))
                                            }, f))
                                        })), "string" == typeof b && "_" !== b.charAt(0) && f[b].apply(f, c)
                                    })
                                }, a.fn.owlCarousel.Constructor = e
                            }(window.Zepto || window.jQuery, window, document),
                                function (a, b, c, d) {
                                    var e = function (b) {
                                        this._core = b, this._interval = null, this._visible = null, this._handlers = {
                                            "initialized.owl.carousel": a.proxy(function (a) {
                                                a.namespace && this._core.settings.autoRefresh && this.watch()
                                            }, this)
                                        }, this._core.options = a.extend({}, e.Defaults, this._core.options), this._core.$element.on(this._handlers)
                                    };
                                    e.Defaults = {
                                        autoRefresh: !0,
                                        autoRefreshInterval: 500
                                    }, e.prototype.watch = function () {
                                        this._interval || (this._visible = this._core.isVisible(), this._interval = b.setInterval(a.proxy(this.refresh, this), this._core.settings.autoRefreshInterval))
                                    }, e.prototype.refresh = function () {
                                        this._core.isVisible() !== this._visible && (this._visible = !this._visible, this._core.$element.toggleClass("owl-hidden", !this._visible), this._visible && this._core.invalidate("width") && this._core.refresh())
                                    }, e.prototype.destroy = function () {
                                        var a, c;
                                        b.clearInterval(this._interval);
                                        for (a in this._handlers) this._core.$element.off(a, this._handlers[a]);
                                        for (c in Object.getOwnPropertyNames(this)) "function" != typeof this[c] && (this[c] = null)
                                    }, a.fn.owlCarousel.Constructor.Plugins.AutoRefresh = e
                                }(window.Zepto || window.jQuery, window, document),
                                function (a, b, c, d) {
                                    var e = function (b) {
                                        this._core = b, this._loaded = [], this._handlers = {
                                            "initialized.owl.carousel change.owl.carousel resized.owl.carousel": a.proxy(function (b) {
                                                if (b.namespace && this._core.settings && this._core.settings.lazyLoad && (b.property && "position" == b.property.name || "initialized" == b.type)) {
                                                    var c = this._core.settings,
                                                        e = c.center && Math.ceil(c.items / 2) || c.items,
                                                        f = c.center && -1 * e || 0,
                                                        g = (b.property && b.property.value !== d ? b.property.value : this._core.current()) + f,
                                                        h = this._core.clones().length,
                                                        i = a.proxy(function (a, b) {
                                                            this.load(b)
                                                        }, this);
                                                    for (c.lazyLoadEager > 0 && (e += c.lazyLoadEager, c.loop && (g -= c.lazyLoadEager, e++)); f++ < e;) this.load(h / 2 + this._core.relative(g)), h && a.each(this._core.clones(this._core.relative(g)), i), g++
                                                }
                                            }, this)
                                        }, this._core.options = a.extend({}, e.Defaults, this._core.options), this._core.$element.on(this._handlers)
                                    };
                                    e.Defaults = {
                                        lazyLoad: !1,
                                        lazyLoadEager: 0
                                    }, e.prototype.load = function (c) {
                                        var d = this._core.$stage.children().eq(c),
                                            e = d && d.find(".owl-lazy");
                                        !e || a.inArray(d.get(0), this._loaded) > -1 || (e.each(a.proxy(function (c, d) {
                                            var e, f = a(d),
                                                g = b.devicePixelRatio > 1 && f.attr("data-src-retina") || f.attr("data-src") || f.attr("data-srcset");
                                            this._core.trigger("load", {
                                                element: f,
                                                url: g
                                            }, "lazy"), f.is("img") ? f.one("load.owl.lazy", a.proxy(function () {
                                                f.css("opacity", 1), this._core.trigger("loaded", {
                                                    element: f,
                                                    url: g
                                                }, "lazy")
                                            }, this)).attr("src", g) : f.is("source") ? f.one("load.owl.lazy", a.proxy(function () {
                                                this._core.trigger("loaded", {
                                                    element: f,
                                                    url: g
                                                }, "lazy")
                                            }, this)).attr("srcset", g) : (e = new Image, e.onload = a.proxy(function () {
                                                f.css({
                                                    "background-image": 'url("' + g + '")',
                                                    opacity: "1"
                                                }), this._core.trigger("loaded", {
                                                    element: f,
                                                    url: g
                                                }, "lazy")
                                            }, this), e.src = g)
                                        }, this)), this._loaded.push(d.get(0)))
                                    }, e.prototype.destroy = function () {
                                        var a, b;
                                        for (a in this.handlers) this._core.$element.off(a, this.handlers[a]);
                                        for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null)
                                    }, a.fn.owlCarousel.Constructor.Plugins.Lazy = e
                                }(window.Zepto || window.jQuery, window, document),
                                function (a, b, c, d) {
                                    var e = function (c) {
                                        this._core = c, this._previousHeight = null, this._handlers = {
                                            "initialized.owl.carousel refreshed.owl.carousel": a.proxy(function (a) {
                                                a.namespace && this._core.settings.autoHeight && this.update()
                                            }, this),
                                            "changed.owl.carousel": a.proxy(function (a) {
                                                a.namespace && this._core.settings.autoHeight && "position" === a.property.name && this.update()
                                            }, this),
                                            "loaded.owl.lazy": a.proxy(function (a) {
                                                a.namespace && this._core.settings.autoHeight && a.element.closest("." + this._core.settings.itemClass).index() === this._core.current() && this.update()
                                            }, this)
                                        }, this._core.options = a.extend({}, e.Defaults, this._core.options), this._core.$element.on(this._handlers), this._intervalId = null;
                                        var d = this;
                                        a(b).on("load", function () {
                                            d._core.settings.autoHeight && d.update()
                                        }), a(b).resize(function () {
                                            d._core.settings.autoHeight && (null != d._intervalId && clearTimeout(d._intervalId), d._intervalId = setTimeout(function () {
                                                d.update()
                                            }, 250))
                                        })
                                    };
                                    e.Defaults = {
                                        autoHeight: !1,
                                        autoHeightClass: "owl-height"
                                    }, e.prototype.update = function () {
                                        var b = this._core._current,
                                            c = b + this._core.settings.items,
                                            d = this._core.settings.lazyLoad,
                                            e = this._core.$stage.children().toArray().slice(b, c),
                                            f = [],
                                            g = 0;
                                        a.each(e, function (b, c) {
                                            f.push(a(c).height())
                                        }), g = Math.max.apply(null, f), g <= 1 && d && this._previousHeight && (g = this._previousHeight), this._previousHeight = g, this._core.$stage.parent().height(g).addClass(this._core.settings.autoHeightClass)
                                    }, e.prototype.destroy = function () {
                                        var a, b;
                                        for (a in this._handlers) this._core.$element.off(a, this._handlers[a]);
                                        for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null)
                                    }, a.fn.owlCarousel.Constructor.Plugins.AutoHeight = e
                                }(window.Zepto || window.jQuery, window, document),
                                function (a, b, c, d) {
                                    var e = function (b) {
                                        this._core = b, this._videos = {}, this._playing = null, this._handlers = {
                                            "initialized.owl.carousel": a.proxy(function (a) {
                                                a.namespace && this._core.register({
                                                    type: "state",
                                                    name: "playing",
                                                    tags: ["interacting"]
                                                })
                                            }, this),
                                            "resize.owl.carousel": a.proxy(function (a) {
                                                a.namespace && this._core.settings.video && this.isInFullScreen() && a.preventDefault()
                                            }, this),
                                            "refreshed.owl.carousel": a.proxy(function (a) {
                                                a.namespace && this._core.is("resizing") && this._core.$stage.find(".cloned .owl-video-frame").remove()
                                            }, this),
                                            "changed.owl.carousel": a.proxy(function (a) {
                                                a.namespace && "position" === a.property.name && this._playing && this.stop()
                                            }, this),
                                            "prepared.owl.carousel": a.proxy(function (b) {
                                                if (b.namespace) {
                                                    var c = a(b.content).find(".owl-video");
                                                    c.length && (c.css("display", "none"), this.fetch(c, a(b.content)))
                                                }
                                            }, this)
                                        }, this._core.options = a.extend({}, e.Defaults, this._core.options), this._core.$element.on(this._handlers), this._core.$element.on("click.owl.video", ".owl-video-play-icon", a.proxy(function (a) {
                                            this.play(a)
                                        }, this))
                                    };
                                    e.Defaults = {
                                        video: !1,
                                        videoHeight: !1,
                                        videoWidth: !1
                                    }, e.prototype.fetch = function (a, b) {
                                        var c = function () {
                                                return a.attr("data-vimeo-id") ? "vimeo" : a.attr("data-vzaar-id") ? "vzaar" : "youtube"
                                            }(),
                                            d = a.attr("data-vimeo-id") || a.attr("data-youtube-id") || a.attr("data-vzaar-id"),
                                            e = a.attr("data-width") || this._core.settings.videoWidth,
                                            f = a.attr("data-height") || this._core.settings.videoHeight,
                                            g = a.attr("href");
                                        if (!g) throw new Error("Missing video URL.");
                                        if (d = g.match(/(http:|https:|)\/\/(player.|www.|app.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com|be\-nocookie\.com)|vzaar\.com)\/(video\/|videos\/|embed\/|channels\/.+\/|groups\/.+\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/), d[3].indexOf("youtu") > -1) c = "youtube";
                                        else if (d[3].indexOf("vimeo") > -1) c = "vimeo";
                                        else {
                                            if (!(d[3].indexOf("vzaar") > -1)) throw new Error("Video URL not supported.");
                                            c = "vzaar"
                                        }
                                        d = d[6], this._videos[g] = {
                                            type: c,
                                            id: d,
                                            width: e,
                                            height: f
                                        }, b.attr("data-video", g), this.thumbnail(a, this._videos[g])
                                    }, e.prototype.thumbnail = function (b, c) {
                                        var d, e, f,
                                            g = c.width && c.height ? "width:" + c.width + "px;height:" + c.height + "px;" : "",
                                            h = b.find("img"),
                                            i = "src",
                                            j = "",
                                            k = this._core.settings,
                                            l = function (c) {
                                                e = '<div class="owl-video-play-icon"></div>', d = k.lazyLoad ? a("<div/>", {
                                                    class: "owl-video-tn " + j,
                                                    srcType: c
                                                }) : a("<div/>", {
                                                    class: "owl-video-tn",
                                                    style: "opacity:1;background-image:url(" + c + ")"
                                                }), b.after(d), b.after(e)
                                            };
                                        if (b.wrap(a("<div/>", {
                                            class: "owl-video-wrapper",
                                            style: g
                                        })), this._core.settings.lazyLoad && (i = "data-src", j = "owl-lazy"), h.length) return l(h.attr(i)), h.remove(), !1;
                                        "youtube" === c.type ? (f = "//img.youtube.com/vi/" + c.id + "/hqdefault.jpg", l(f)) : "vimeo" === c.type ? a.ajax({
                                            type: "GET",
                                            url: "//vimeo.com/api/v2/video/" + c.id + ".json",
                                            jsonp: "callback",
                                            dataType: "jsonp",
                                            success: function (a) {
                                                f = a[0].thumbnail_large, l(f)
                                            }
                                        }) : "vzaar" === c.type && a.ajax({
                                            type: "GET",
                                            url: "//vzaar.com/api/videos/" + c.id + ".json",
                                            jsonp: "callback",
                                            dataType: "jsonp",
                                            success: function (a) {
                                                f = a.framegrab_url, l(f)
                                            }
                                        })
                                    }, e.prototype.stop = function () {
                                        this._core.trigger("stop", null, "video"), this._playing.find(".owl-video-frame").remove(), this._playing.removeClass("owl-video-playing"), this._playing = null, this._core.leave("playing"), this._core.trigger("stopped", null, "video")
                                    }, e.prototype.play = function (b) {
                                        var c, d = a(b.target),
                                            e = d.closest("." + this._core.settings.itemClass),
                                            f = this._videos[e.attr("data-video")],
                                            g = f.width || "100%",
                                            h = f.height || this._core.$stage.height();
                                        this._playing || (this._core.enter("playing"), this._core.trigger("play", null, "video"), e = this._core.items(this._core.relative(e.index())), this._core.reset(e.index()), c = a('<iframe frameborder="0" allowfullscreen mozallowfullscreen webkitAllowFullScreen ></iframe>'), c.attr("height", h), c.attr("width", g), "youtube" === f.type ? c.attr("src", "//www.youtube.com/embed/" + f.id + "?autoplay=1&rel=0&v=" + f.id) : "vimeo" === f.type ? c.attr("src", "//player.vimeo.com/video/" + f.id + "?autoplay=1") : "vzaar" === f.type && c.attr("src", "//view.vzaar.com/" + f.id + "/player?autoplay=true"), a(c).wrap('<div class="owl-video-frame" />').insertAfter(e.find(".owl-video")), this._playing = e.addClass("owl-video-playing"))
                                    }, e.prototype.isInFullScreen = function () {
                                        var b = c.fullscreenElement || c.mozFullScreenElement || c.webkitFullscreenElement;
                                        return b && a(b).parent().hasClass("owl-video-frame")
                                    }, e.prototype.destroy = function () {
                                        var a, b;
                                        this._core.$element.off("click.owl.video");
                                        for (a in this._handlers) this._core.$element.off(a, this._handlers[a]);
                                        for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null)
                                    }, a.fn.owlCarousel.Constructor.Plugins.Video = e
                                }(window.Zepto || window.jQuery, window, document),
                                function (a, b, c, d) {
                                    var e = function (b) {
                                        this.core = b, this.core.options = a.extend({}, e.Defaults, this.core.options), this.swapping = !0, this.previous = d, this.next = d, this.handlers = {
                                            "change.owl.carousel": a.proxy(function (a) {
                                                a.namespace && "position" == a.property.name && (this.previous = this.core.current(), this.next = a.property.value)
                                            }, this),
                                            "drag.owl.carousel dragged.owl.carousel translated.owl.carousel": a.proxy(function (a) {
                                                a.namespace && (this.swapping = "translated" == a.type)
                                            }, this),
                                            "translate.owl.carousel": a.proxy(function (a) {
                                                a.namespace && this.swapping && (this.core.options.animateOut || this.core.options.animateIn) && this.swap()
                                            }, this)
                                        }, this.core.$element.on(this.handlers)
                                    };
                                    e.Defaults = {
                                        animateOut: !1,
                                        animateIn: !1
                                    }, e.prototype.swap = function () {
                                        if (1 === this.core.settings.items && a.support.animation && a.support.transition) {
                                            this.core.speed(0);
                                            var b, c = a.proxy(this.clear, this),
                                                d = this.core.$stage.children().eq(this.previous),
                                                e = this.core.$stage.children().eq(this.next),
                                                f = this.core.settings.animateIn,
                                                g = this.core.settings.animateOut;
                                            this.core.current() !== this.previous && (g && (b = this.core.coordinates(this.previous) - this.core.coordinates(this.next), d.one(a.support.animation.end, c).css({
                                                left: b + "px"
                                            }).addClass("animated owl-animated-out").addClass(g)), f && e.one(a.support.animation.end, c).addClass("animated owl-animated-in").addClass(f))
                                        }
                                    }, e.prototype.clear = function (b) {
                                        a(b.target).css({
                                            left: ""
                                        }).removeClass("animated owl-animated-out owl-animated-in").removeClass(this.core.settings.animateIn).removeClass(this.core.settings.animateOut), this.core.onTransitionEnd()
                                    }, e.prototype.destroy = function () {
                                        var a, b;
                                        for (a in this.handlers) this.core.$element.off(a, this.handlers[a]);
                                        for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null)
                                    }, a.fn.owlCarousel.Constructor.Plugins.Animate = e
                                }(window.Zepto || window.jQuery, window, document),
                                function (a, b, c, d) {
                                    var e = function (b) {
                                        this._core = b, this._call = null, this._time = 0, this._timeout = 0, this._paused = !0, this._handlers = {
                                            "changed.owl.carousel": a.proxy(function (a) {
                                                a.namespace && "settings" === a.property.name ? this._core.settings.autoplay ? this.play() : this.stop() : a.namespace && "position" === a.property.name && this._paused && (this._time = 0)
                                            }, this),
                                            "initialized.owl.carousel": a.proxy(function (a) {
                                                a.namespace && this._core.settings.autoplay && this.play()
                                            }, this),
                                            "play.owl.autoplay": a.proxy(function (a, b, c) {
                                                a.namespace && this.play(b, c)
                                            }, this),
                                            "stop.owl.autoplay": a.proxy(function (a) {
                                                a.namespace && this.stop()
                                            }, this),
                                            "mouseover.owl.autoplay": a.proxy(function () {
                                                this._core.settings.autoplayHoverPause && this._core.is("rotating") && this.pause()
                                            }, this),
                                            "mouseleave.owl.autoplay": a.proxy(function () {
                                                this._core.settings.autoplayHoverPause && this._core.is("rotating") && this.play()
                                            }, this),
                                            "touchstart.owl.core": a.proxy(function () {
                                                this._core.settings.autoplayHoverPause && this._core.is("rotating") && this.pause()
                                            }, this),
                                            "touchend.owl.core": a.proxy(function () {
                                                this._core.settings.autoplayHoverPause && this.play()
                                            }, this)
                                        }, this._core.$element.on(this._handlers), this._core.options = a.extend({}, e.Defaults, this._core.options)
                                    };
                                    e.Defaults = {
                                        autoplay: !1,
                                        autoplayTimeout: 5e3,
                                        autoplayHoverPause: !1,
                                        autoplaySpeed: !1
                                    }, e.prototype._next = function (d) {
                                        this._call = b.setTimeout(a.proxy(this._next, this, d), this._timeout * (Math.round(this.read() / this._timeout) + 1) - this.read()), this._core.is("interacting") || c.hidden || this._core.next(d || this._core.settings.autoplaySpeed)
                                    }, e.prototype.read = function () {
                                        return (new Date).getTime() - this._time
                                    }, e.prototype.play = function (c, d) {
                                        var e;
                                        this._core.is("rotating") || this._core.enter("rotating"), c = c || this._core.settings.autoplayTimeout, e = Math.min(this._time % (this._timeout || c), c), this._paused ? (this._time = this.read(), this._paused = !1) : b.clearTimeout(this._call), this._time += this.read() % c - e, this._timeout = c, this._call = b.setTimeout(a.proxy(this._next, this, d), c - e)
                                    }, e.prototype.stop = function () {
                                        this._core.is("rotating") && (this._time = 0, this._paused = !0, b.clearTimeout(this._call), this._core.leave("rotating"))
                                    }, e.prototype.pause = function () {
                                        this._core.is("rotating") && !this._paused && (this._time = this.read(), this._paused = !0, b.clearTimeout(this._call))
                                    }, e.prototype.destroy = function () {
                                        var a, b;
                                        this.stop();
                                        for (a in this._handlers) this._core.$element.off(a, this._handlers[a]);
                                        for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null)
                                    }, a.fn.owlCarousel.Constructor.Plugins.autoplay = e
                                }(window.Zepto || window.jQuery, window, document),
                                function (a, b, c, d) {
                                    "use strict";
                                    var e = function (b) {
                                        this._core = b, this._initialized = !1, this._pages = [], this._controls = {}, this._templates = [], this.$element = this._core.$element, this._overrides = {
                                            next: this._core.next,
                                            prev: this._core.prev,
                                            to: this._core.to
                                        }, this._handlers = {
                                            "prepared.owl.carousel": a.proxy(function (b) {
                                                b.namespace && this._core.settings.dotsData && this._templates.push('<div class="' + this._core.settings.dotClass + '">' + a(b.content).find("[data-dot]").addBack("[data-dot]").attr("data-dot") + "</div>")
                                            }, this),
                                            "added.owl.carousel": a.proxy(function (a) {
                                                a.namespace && this._core.settings.dotsData && this._templates.splice(a.position, 0, this._templates.pop())
                                            }, this),
                                            "remove.owl.carousel": a.proxy(function (a) {
                                                a.namespace && this._core.settings.dotsData && this._templates.splice(a.position, 1)
                                            }, this),
                                            "changed.owl.carousel": a.proxy(function (a) {
                                                a.namespace && "position" == a.property.name && this.draw()
                                            }, this),
                                            "initialized.owl.carousel": a.proxy(function (a) {
                                                a.namespace && !this._initialized && (this._core.trigger("initialize", null, "navigation"), this.initialize(), this.update(), this.draw(), this._initialized = !0, this._core.trigger("initialized", null, "navigation"))
                                            }, this),
                                            "refreshed.owl.carousel": a.proxy(function (a) {
                                                a.namespace && this._initialized && (this._core.trigger("refresh", null, "navigation"), this.update(), this.draw(), this._core.trigger("refreshed", null, "navigation"))
                                            }, this)
                                        }, this._core.options = a.extend({}, e.Defaults, this._core.options), this.$element.on(this._handlers)
                                    };
                                    e.Defaults = {
                                        nav: !1,
                                        navText: ['<span aria-label="Previous">&#x2039;</span>', '<span aria-label="Next">&#x203a;</span>'],
                                        navSpeed: !1,
                                        navElement: 'button type="button" role="presentation"',
                                        navContainer: !1,
                                        navContainerClass: "owl-nav",
                                        navClass: ["owl-prev", "owl-next"],
                                        slideBy: 1,
                                        dotClass: "owl-dot",
                                        dotsClass: "owl-dots",
                                        dots: !0,
                                        dotsEach: !1,
                                        dotsData: !1,
                                        dotsSpeed: !1,
                                        dotsContainer: !1
                                    }, e.prototype.initialize = function () {
                                        var b, c = this._core.settings;
                                        this._controls.$relative = (c.navContainer ? a(c.navContainer) : a("<div>").addClass(c.navContainerClass).appendTo(this.$element)).addClass("disabled"), this._controls.$previous = a("<" + c.navElement + ">").addClass(c.navClass[0]).html(c.navText[0]).prependTo(this._controls.$relative).on("click", a.proxy(function (a) {
                                            this.prev(c.navSpeed)
                                        }, this)), this._controls.$next = a("<" + c.navElement + ">").addClass(c.navClass[1]).html(c.navText[1]).appendTo(this._controls.$relative).on("click", a.proxy(function (a) {
                                            this.next(c.navSpeed)
                                        }, this)), c.dotsData || (this._templates = [a('<button role="button">').addClass(c.dotClass).append(a("<span>")).prop("outerHTML")]), this._controls.$absolute = (c.dotsContainer ? a(c.dotsContainer) : a("<div>").addClass(c.dotsClass).appendTo(this.$element)).addClass("disabled"), this._controls.$absolute.on("click", "button", a.proxy(function (b) {
                                            var d = a(b.target).parent().is(this._controls.$absolute) ? a(b.target).index() : a(b.target).parent().index();
                                            b.preventDefault(), this.to(d, c.dotsSpeed)
                                        }, this));
                                        for (b in this._overrides) this._core[b] = a.proxy(this[b], this)
                                    }, e.prototype.destroy = function () {
                                        var a, b, c, d, e;
                                        e = this._core.settings;
                                        for (a in this._handlers) this.$element.off(a, this._handlers[a]);
                                        for (b in this._controls) "$relative" === b && e.navContainer ? this._controls[b].html("") : this._controls[b].remove();
                                        for (d in this.overides) this._core[d] = this._overrides[d];
                                        for (c in Object.getOwnPropertyNames(this)) "function" != typeof this[c] && (this[c] = null)
                                    }, e.prototype.update = function () {
                                        var a, b, c, d = this._core.clones().length / 2,
                                            e = d + this._core.items().length,
                                            f = this._core.maximum(!0),
                                            g = this._core.settings,
                                            h = g.center || g.autoWidth || g.dotsData ? 1 : g.dotsEach || g.items;
                                        if ("page" !== g.slideBy && (g.slideBy = Math.min(g.slideBy, g.items)), g.dots || "page" == g.slideBy)
                                            for (this._pages = [], a = d, b = 0, c = 0; a < e; a++) {
                                                if (b >= h || 0 === b) {
                                                    if (this._pages.push({
                                                        start: Math.min(f, a - d),
                                                        end: a - d + h - 1
                                                    }), Math.min(f, a - d) === f) break;
                                                    b = 0, ++c
                                                }
                                                b += this._core.mergers(this._core.relative(a))
                                            }
                                    }, e.prototype.draw = function () {
                                        var b, c = this._core.settings,
                                            d = this._core.items().length <= c.items,
                                            e = this._core.relative(this._core.current()),
                                            f = c.loop || c.rewind;
                                        this._controls.$relative.toggleClass("disabled", !c.nav || d), c.nav && (this._controls.$previous.toggleClass("disabled", !f && e <= this._core.minimum(!0)), this._controls.$next.toggleClass("disabled", !f && e >= this._core.maximum(!0))), this._controls.$absolute.toggleClass("disabled", !c.dots || d), c.dots && (b = this._pages.length - this._controls.$absolute.children().length, c.dotsData && 0 !== b ? this._controls.$absolute.html(this._templates.join("")) : b > 0 ? this._controls.$absolute.append(new Array(b + 1).join(this._templates[0])) : b < 0 && this._controls.$absolute.children().slice(b).remove(), this._controls.$absolute.find(".active").removeClass("active"), this._controls.$absolute.children().eq(a.inArray(this.current(), this._pages)).addClass("active"))
                                    }, e.prototype.onTrigger = function (b) {
                                        var c = this._core.settings;
                                        b.page = {
                                            index: a.inArray(this.current(), this._pages),
                                            count: this._pages.length,
                                            size: c && (c.center || c.autoWidth || c.dotsData ? 1 : c.dotsEach || c.items)
                                        }
                                    }, e.prototype.current = function () {
                                        var b = this._core.relative(this._core.current());
                                        return a.grep(this._pages, a.proxy(function (a, c) {
                                            return a.start <= b && a.end >= b
                                        }, this)).pop()
                                    }, e.prototype.getPosition = function (b) {
                                        var c, d, e = this._core.settings;
                                        return "page" == e.slideBy ? (c = a.inArray(this.current(), this._pages), d = this._pages.length, b ? ++c : --c, c = this._pages[(c % d + d) % d].start) : (c = this._core.relative(this._core.current()), d = this._core.items().length, b ? c += e.slideBy : c -= e.slideBy), c
                                    }, e.prototype.next = function (b) {
                                        a.proxy(this._overrides.to, this._core)(this.getPosition(!0), b)
                                    }, e.prototype.prev = function (b) {
                                        a.proxy(this._overrides.to, this._core)(this.getPosition(!1), b)
                                    }, e.prototype.to = function (b, c, d) {
                                        var e;
                                        !d && this._pages.length ? (e = this._pages.length, a.proxy(this._overrides.to, this._core)(this._pages[(b % e + e) % e].start, c)) : a.proxy(this._overrides.to, this._core)(b, c)
                                    }, a.fn.owlCarousel.Constructor.Plugins.Navigation = e
                                }(window.Zepto || window.jQuery, window, document),
                                function (a, b, c, d) {
                                    "use strict";
                                    var e = function (c) {
                                        this._core = c, this._hashes = {}, this.$element = this._core.$element, this._handlers = {
                                            "initialized.owl.carousel": a.proxy(function (c) {
                                                c.namespace && "URLHash" === this._core.settings.startPosition && a(b).trigger("hashchange.owl.navigation")
                                            }, this),
                                            "prepared.owl.carousel": a.proxy(function (b) {
                                                if (b.namespace) {
                                                    var c = a(b.content).find("[data-hash]").addBack("[data-hash]").attr("data-hash");
                                                    if (!c) return;
                                                    this._hashes[c] = b.content
                                                }
                                            }, this),
                                            "changed.owl.carousel": a.proxy(function (c) {
                                                if (c.namespace && "position" === c.property.name) {
                                                    var d = this._core.items(this._core.relative(this._core.current())),
                                                        e = a.map(this._hashes, function (a, b) {
                                                            return a === d ? b : null
                                                        }).join();
                                                    if (!e || b.location.hash.slice(1) === e) return;
                                                    b.location.hash = e
                                                }
                                            }, this)
                                        }, this._core.options = a.extend({}, e.Defaults, this._core.options), this.$element.on(this._handlers), a(b).on("hashchange.owl.navigation", a.proxy(function (a) {
                                            var c = b.location.hash.substring(1),
                                                e = this._core.$stage.children(),
                                                f = this._hashes[c] && e.index(this._hashes[c]);
                                            f !== d && f !== this._core.current() && this._core.to(this._core.relative(f), !1, !0)
                                        }, this))
                                    };
                                    e.Defaults = {
                                        URLhashListener: !1
                                    }, e.prototype.destroy = function () {
                                        var c, d;
                                        a(b).off("hashchange.owl.navigation");
                                        for (c in this._handlers) this._core.$element.off(c, this._handlers[c]);
                                        for (d in Object.getOwnPropertyNames(this)) "function" != typeof this[d] && (this[d] = null)
                                    }, a.fn.owlCarousel.Constructor.Plugins.Hash = e
                                }(window.Zepto || window.jQuery, window, document),
                                function (a, b, c, d) {
                                    function e(b, c) {
                                        var e = !1,
                                            f = b.charAt(0).toUpperCase() + b.slice(1);
                                        return a.each((b + " " + h.join(f + " ") + f).split(" "), function (a, b) {
                                            if (g[b] !== d) return e = !c || b, !1
                                        }), e
                                    }

                                    function f(a) {
                                        return e(a, !0)
                                    }

                                    var g = a("<support>").get(0).style,
                                        h = "Webkit Moz O ms".split(" "),
                                        i = {
                                            transition: {
                                                end: {
                                                    WebkitTransition: "webkitTransitionEnd",
                                                    MozTransition: "transitionend",
                                                    OTransition: "oTransitionEnd",
                                                    transition: "transitionend"
                                                }
                                            },
                                            animation: {
                                                end: {
                                                    WebkitAnimation: "webkitAnimationEnd",
                                                    MozAnimation: "animationend",
                                                    OAnimation: "oAnimationEnd",
                                                    animation: "animationend"
                                                }
                                            }
                                        },
                                        j = {
                                            csstransforms: function () {
                                                return !!e("transform")
                                            },
                                            csstransforms3d: function () {
                                                return !!e("perspective")
                                            },
                                            csstransitions: function () {
                                                return !!e("transition")
                                            },
                                            cssanimations: function () {
                                                return !!e("animation")
                                            }
                                        };
                                    j.csstransitions() && (a.support.transition = new String(f("transition")), a.support.transition.end = i.transition.end[a.support.transition]), j.cssanimations() && (a.support.animation = new String(f("animation")), a.support.animation.end = i.animation.end[a.support.animation]), j.csstransforms() && (a.support.transform = new String(f("transform")), a.support.transform3d = j.csstransforms3d())
                                }(window.Zepto || window.jQuery, window, document);
                        </script>

                        <style>
                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.main-timeline-pubbox-wrapper {
                                width: 100%;
                                display: block;
                                line-height: 0;
                                border-bottom: 10px solid #e6ecf0;
                                padding: 15px;
                            }

                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.timeline-swifts-holder {
                                width: 100%;
                                display: block;
                                border-bottom: 2px solid #e6ecf0;
                                padding: 15px;
                                background: #fff;
                            }

                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.timeline-swifts-holder div.timeline-swifts-cr {
                                width: 100%;
                                display: block;
                            }

                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.timeline-swifts-holder div.timeline-swifts-cr.owl-carousel {
                                width: 100%;
                            }

                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.timeline-swifts-holder div.timeline-swifts-cr.owl-carousel div.owl-stage-outer div.owl-stage div.owl-item div.swift-item {
                                display: flex;
                                flex-direction: column;
                                flex-wrap: nowrap;
                                justify-content: center;
                                align-items: center;
                                width: 65px;
                                min-width: 65px;
                                overflow: hidden;
                                cursor: pointer;
                            }

                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.timeline-swifts-holder div.timeline-swifts-cr.owl-carousel div.owl-stage-outer div.owl-stage div.owl-item div.swift-item div.swift-item-body {
                                line-height: 0;
                                margin-bottom: 5px;
                            }

                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.timeline-swifts-holder div.timeline-swifts-cr.owl-carousel div.owl-stage-outer div.owl-stage div.owl-item div.swift-item div.swift-item-body div.avatar {
                                width: 55px;
                                height: 55px;
                                min-width: 55px;
                                min-height: 55px;
                                border-radius: 10em;
                                border: 2px solid #b5c0c7;
                                overflow: hidden;
                                line-height: 0;
                            }

                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.timeline-swifts-holder div.timeline-swifts-cr.owl-carousel div.owl-stage-outer div.owl-stage div.owl-item div.swift-item div.swift-item-body div.avatar img {
                                width: 100%;
                                height: 100%;
                                object-fit: cover;
                                border-radius: 10em;
                                border: 2px solid #fff;
                            }

                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.timeline-swifts-holder div.timeline-swifts-cr.owl-carousel div.owl-stage-outer div.owl-stage div.owl-item div.swift-item div.swift-item-body.create-swift {
                                position: relative;
                            }

                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.timeline-swifts-holder div.timeline-swifts-cr.owl-carousel div.owl-stage-outer div.owl-stage div.owl-item div.swift-item div.swift-item-body.create-swift span.add-ikon {
                                position: absolute;
                                width: 20px;
                                height: 20px;
                                background: #8EC741;
                                border-radius: 10em;
                                bottom: 0;
                                right: 0;
                                line-height: 0;
                            }

                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.timeline-swifts-holder div.timeline-swifts-cr.owl-carousel div.owl-stage-outer div.owl-stage div.owl-item div.swift-item div.swift-item-body.create-swift span.add-ikon svg {
                                width: 100%;
                                height: 100%;
                                stroke: #fff;
                                stroke-width: 2;
                            }

                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.timeline-swifts-holder div.timeline-swifts-cr.owl-carousel div.owl-stage-outer div.owl-stage div.owl-item div.swift-item div.swift-item-footer {
                                line-height: 0px;
                                max-width: 100%;
                            }

                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.timeline-swifts-holder div.timeline-swifts-cr.owl-carousel div.owl-stage-outer div.owl-stage div.owl-item div.swift-item div.swift-item-footer span {
                                display: block;
                                max-width: 100%;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                font-size: 11px;
                                line-height: 11px;
                                white-space: nowrap;
                                color: #5b7083;
                            }

                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.timeline-swifts-holder div.timeline-swifts-cr.owl-carousel div.owl-stage-outer div.owl-stage div.owl-item div.swift-item.active div.swift-item-body div.avatar {
                                border-color: #f6546a;
                            }

                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.empty-user-timeline {
                                width: 100%;
                                display: flex;
                                flex-direction: column;
                                flex-wrap: nowrap;
                                justify-content: center;
                                align-items: center;
                                line-height: 0px;
                                padding: 50px;
                                height: 350px;
                                overflow: hidden;
                            }

                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.empty-user-timeline div.icon {
                                line-height: 0px;
                                margin-bottom: 15px;
                                width: 100%;
                                text-align: center;
                            }

                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.empty-user-timeline div.icon svg {
                                width: 50px;
                                height: 50px;
                                stroke: #8EC741;
                            }

                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.empty-user-timeline div.pl-message {
                                line-height: 0px;
                                width: 100%;
                                margin-bottom: 50px;
                            }

                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.empty-user-timeline div.pl-message h4 {
                                font-size: 20px;
                                padding: 0;
                                margin: 0 0 15px 0;
                                line-height: 20px;
                                color: #14171a;
                                font-weight: 700;
                                text-align: center;
                            }

                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.empty-user-timeline div.pl-message p {
                                font-size: 13px;
                                line-height: 20px;
                                padding: 0;
                                margin: 0;
                                color: #5b7083;
                                text-align: center;
                                overflow-wrap: break-word;
                            }

                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.empty-user-timeline div.c2action-single {
                                width: 100%;
                                line-height: 0px;
                                text-align: center;
                            }

                            body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.empty-user-timeline div.c2action-single button {
                                padding-left: 40px;
                                padding-right: 40px;
                            }

                            body.cl-app-home div.swift-app-container {
                                display: none;
                                visibility: hidden;
                            }

                            body.cl-app-home div.swift-app-container.show {
                                display: block;
                                visibility: visible;
                                -webkit-backface-visibility: hidden;
                                height: 100%;
                                width: 100%;
                                left: 0;
                                top: 0;
                                bottom: 0;
                                right: 0;
                                outline: none;
                                position: fixed;
                                -webkit-tap-highlight-color: transparent;
                                -ms-touch-action: manipulation;
                                touch-action: manipulation;
                                transform: translateZ(0);
                                z-index: 99992;
                                background: rgba(0, 0, 0, 0.7);
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont {
                                width: 100vw;
                                height: 100vh;
                                display: flex;
                                justify-content: center;
                                line-height: 0px;
                                padding: 30px;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data {
                                max-width: 500px;
                                min-width: 500px;
                                background: #081725;
                                height: 100%;
                                position: relative;
                                box-shadow: rgba(0, 0, 0, 0.15) 0px 1px 10px 0px;
                                border-radius: 10px;
                                overflow: hidden;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header {
                                position: absolute;
                                left: 0;
                                top: 0;
                                width: 100%;
                                display: block;
                                padding: 20px;
                                z-index: 100;
                                background: -webkit-gradient(linear, left top, left bottom, from(rgba(38, 38, 38, 0.8)), to(rgba(38, 38, 38, 0)));
                                background: -webkit-linear-gradient(top, rgba(38, 38, 38, 0.8) 0%, rgba(38, 38, 38, 0) 100%);
                                background: linear-gradient(180deg, rgba(38, 38, 38, 0.8) 0%, rgba(38, 38, 38, 0) 100%);
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-sliders {
                                width: 100%;
                                display: flex;
                                flex-direction: row;
                                flex-wrap: nowrap;
                                align-items: center;
                                justify-content: center;
                                margin-bottom: 20px;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-sliders div.slider-item {
                                flex: 1;
                                margin-right: 5px;
                                height: 2px;
                                border-radius: 2px;
                                background: rgba(255, 255, 255, 0.3);
                                max-width: 100%;
                                min-width: 10px;
                                cursor: pointer;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-sliders div.slider-item span {
                                height: 100%;
                                display: block;
                                background: #fff;
                                border-radius: inherit;
                                width: 0px;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-sliders div.slider-item:last-child {
                                margin-right: 0px;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls {
                                width: 100%;
                                display: block;
                                line-height: 0;
                                overflow: hidden;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.swift-user-info {
                                width: 100%;
                                display: block;
                                line-height: 0;
                                overflow: hidden;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.swift-user-info div.avatar {
                                width: 35px;
                                height: 35px;
                                overflow: hidden;
                                border-radius: 10em;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.swift-user-info div.avatar img {
                                width: 100%;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.swift-user-info div.uname {
                                display: block;
                                width: 100%;
                                line-height: 0;
                                padding-left: 15px;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.swift-user-info div.uname h6 {
                                padding: 0;
                                margin: 0;
                                font-size: 14px;
                                line-height: 22px;
                                color: #fff;
                                white-space: nowrap;
                                font-weight: 500;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.swift-user-info div.uname h6 a {
                                color: inherit;
                                display: inline-block;
                                overflow: hidden;
                                max-width: 150px;
                                text-overflow: ellipsis;
                                vertical-align: middle;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.swift-user-info div.uname h6 time {
                                display: inline-block;
                                vertical-align: middle;
                                font-size: 13px;
                                opacity: 0.9;
                                font-weight: normal;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.ctrl-group {
                                width: 100%;
                                display: block;
                                line-height: 0;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.ctrl-group div.swift-data-ctrl-item button {
                                padding: 0;
                                margin: 0;
                                background: transparent;
                                line-height: 0;
                                width: 20px;
                                height: 20px;
                                outline: 0;
                                border: none;
                                box-shadow: none;
                                margin-left: 15px;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.ctrl-group div.swift-data-ctrl-item button > svg {
                                width: 100%;
                                height: 100%;
                                stroke: #fff;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.ctrl-group div.swift-data-ctrl-item button a.dropdown-toggle {
                                text-decoration: none;
                                padding: 0;
                                margin: 0;
                                line-height: 0;
                                width: 20px;
                                height: 20px;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.ctrl-group div.swift-data-ctrl-item button a.dropdown-toggle:before,
                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.ctrl-group div.swift-data-ctrl-item button a.dropdown-toggle:after {
                                display: none;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.ctrl-group div.swift-data-ctrl-item button a.dropdown-toggle svg {
                                width: 100%;
                                height: 100%;
                                stroke: #fff;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.ctrl-group div.swift-data-ctrl-item button div.dropdown-menu {
                                overflow: hidden;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.ctrl-group div.swift-data-ctrl-item button div.dropdown-menu div.swift-views {
                                width: 300px;
                                display: block;
                                line-height: 0px;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.ctrl-group div.swift-data-ctrl-item button div.dropdown-menu div.swift-views div.swift-views-header {
                                width: 100%;
                                display: block;
                                padding: 15px;
                                line-height: 0;
                                border-bottom: 1px solid #e6ecf0;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.ctrl-group div.swift-data-ctrl-item button div.dropdown-menu div.swift-views div.swift-views-header h6 {
                                font-size: 13px;
                                color: #14171a;
                                line-height: 13px;
                                padding: 0;
                                margin: 0;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.ctrl-group div.swift-data-ctrl-item button div.dropdown-menu div.swift-views div.swift-views-body {
                                width: 100%;
                                max-height: 300px;
                                overflow-x: hidden;
                                overflow-y: auto;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.ctrl-group div.swift-data-ctrl-item button div.dropdown-menu div.swift-views div.swift-views-body div.view-li {
                                width: 100%;
                                display: block;
                                padding: 10px 15px;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.ctrl-group div.swift-data-ctrl-item button div.dropdown-menu div.swift-views div.swift-views-body div.view-li div.avatar {
                                width: 35px;
                                height: 35px;
                                border-radius: 10em;
                                overflow: hidden;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.ctrl-group div.swift-data-ctrl-item button div.dropdown-menu div.swift-views div.swift-views-body div.view-li div.avatar img {
                                width: 100%;
                                display: block;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.ctrl-group div.swift-data-ctrl-item button div.dropdown-menu div.swift-views div.swift-views-body div.view-li div.user-name {
                                padding-left: 15px;
                                display: block;
                                width: 100%;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.ctrl-group div.swift-data-ctrl-item button div.dropdown-menu div.swift-views div.swift-views-body div.view-li div.user-name a {
                                color: inherit;
                                display: block;
                                font-size: 13px;
                                line-height: 13px;
                                color: #14171a;
                                margin-bottom: 3px;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-header div.swift-data-ctrls div.ctrl-group div.swift-data-ctrl-item button div.dropdown-menu div.swift-views div.swift-views-body div.view-li div.user-name time {
                                font-weight: 300;
                                display: block;
                                font-size: 11px;
                                line-height: 11px;
                                color: #5b7083;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-body {
                                width: 100%;
                                height: 100%;
                                display: block;
                                position: relative;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-body div.swift-data-item {
                                width: 100%;
                                height: 100%;
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                justify-content: center;
                                overflow: hidden;
                                position: relative;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-body div.swift-data-item div.swift-data-image {
                                width: 100%;
                                overflow: hidden;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-body div.swift-data-item div.swift-data-image img {
                                width: 100%;
                                display: block;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-body div.swift-data-item div.swift-data-video {
                                width: 100%;
                                overflow: hidden;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-body div.swift-data-item div.swift-data-video video {
                                display: block;
                                width: 100%;
                                height: 100%;
                                border: none;
                                outline: 0;
                                object-fit: cover;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-body button.swift-data-slide-ctrl {
                                padding: 0;
                                margin: 0;
                                width: 30px;
                                height: 30px;
                                border: none;
                                box-shadow: rgba(0, 0, 0, 0.15) 0px 1px 10px 0px;
                                outline: 0;
                                background: rgba(0, 0, 0, 0.7);
                                position: absolute;
                                top: calc(50% - 15px);
                                cursor: pointer;
                                border-radius: 10em;
                                visibility: hidden;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-body button.swift-data-slide-ctrl.prev {
                                left: 20px;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-body button.swift-data-slide-ctrl.next {
                                right: 20px;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-body button.swift-data-slide-ctrl.pause {
                                top: calc(50% - 25px);
                                left: calc(50% - 25px);
                                width: 50px;
                                height: 50px;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-body button.swift-data-slide-ctrl span {
                                width: 100%;
                                height: 100%;
                                display: flex;
                                flex-direction: row;
                                align-items: center;
                                justify-content: center;
                                line-height: 0;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-body button.swift-data-slide-ctrl span svg {
                                width: 20px;
                                height: 20px;
                                stroke: #fff;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-body:hover button.swift-data-slide-ctrl,
                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-body:active button.swift-data-slide-ctrl {
                                visibility: visible;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-footer {
                                position: absolute;
                                left: 0;
                                bottom: 0;
                                width: 100%;
                                display: block;
                                padding: 20px;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-footer div.swift-caption {
                                width: 100%;
                                display: block;
                            }

                            body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data div.swift-data-footer div.swift-caption p {
                                padding: 0;
                                margin: 0;
                                text-align: center;
                                font-size: 13px;
                                line-height: 18px;
                                color: #fff;
                                font-weight: normal;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form {
                                width: 100%;
                                max-width: 100%;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.input-holder {
                                width: 100%;
                                margin-bottom: 10px;
                                max-width: 100%;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.input-holder textarea {
                                display: none !important;
                                visibility: hidden !important;
                                opacity: 0 !important;
                                white-space: nowrap;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.preview-image-holder {
                                width: 100%;
                                display: block;
                                line-height: 0;
                                margin-bottom: 10px;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.preview-image-holder div.preview-image-inner {
                                border-radius: 15px;
                                border: 1px solid #e6ecf0;
                                overflow: hidden;
                                position: relative;
                                background: #e6ecf0;
                                height: 100%;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.preview-image-holder div.preview-image-inner img {
                                width: 100%;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.preview-image-holder div.preview-image-inner button.delete-preview-image {
                                position: absolute;
                                padding: 0;
                                margin: 0;
                                line-height: 0;
                                top: 5px;
                                right: 5px;
                                width: 25px;
                                height: 25px;
                                border-radius: 10em;
                                cursor: pointer;
                                transition: visibility 0.1s linear, opacity 0.1s linear;
                                display: flex;
                                flex-direction: row;
                                justify-content: center;
                                align-items: center;
                                background-color: #8EC741;
                                border: none;
                                box-shadow: none;
                                outline: 0;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.preview-image-holder div.preview-image-inner button.delete-preview-image:disabled {
                                cursor: wait !important;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.preview-image-holder div.preview-image-inner button.delete-preview-image svg {
                                width: 17px;
                                height: 17px;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.preview-image-holder div.preview-image-inner button.delete-preview-image svg * {
                                stroke: #fff;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.preview-video-holder {
                                width: 100%;
                                display: block;
                                line-height: 0;
                                margin-bottom: 10px;
                                position: relative;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.preview-video-holder button.delete-preview-video {
                                position: absolute;
                                padding: 0;
                                margin: 0;
                                line-height: 0;
                                top: 5px;
                                right: 5px;
                                width: 25px;
                                height: 25px;
                                border-radius: 10em;
                                cursor: pointer;
                                transition: visibility 0.1s linear, opacity 0.1s linear;
                                display: flex;
                                flex-direction: row;
                                justify-content: center;
                                align-items: center;
                                background-color: #8EC741;
                                border: none;
                                box-shadow: none;
                                outline: 0;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.preview-video-holder button.delete-preview-video:disabled {
                                cursor: wait !important;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.preview-video-holder button.delete-preview-video svg {
                                width: 17px;
                                height: 17px;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.preview-video-holder button.delete-preview-video svg * {
                                stroke: #fff;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.preview-video-holder div.video-player {
                                width: 100%;
                                display: block;
                                max-height: 50%;
                                background: #e6ecf0;
                                border-radius: 10px;
                                border: 1px solid #e6ecf0;
                                overflow: hidden;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.swift-ctrls-holder {
                                width: 100%;
                                display: flex;
                                flex-direction: row;
                                flex-wrap: nowrap;
                                align-items: center;
                                margin-bottom: 10px;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.swift-ctrls-holder button.ctrl-item {
                                background: transparent;
                                border: none;
                                outline: none;
                                padding: 0px;
                                margin: 0 15px 0 0;
                                box-shadow: none;
                                line-height: 0px;
                                width: 20px;
                                height: 35px;
                                border-radius: 10em;
                                position: relative;
                                cursor: pointer;
                                transition: all 0.10s ease-in-out;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.swift-ctrls-holder button.ctrl-item svg {
                                width: 22px;
                                height: 22px;
                                position: absolute;
                                left: 0;
                                top: 0;
                                bottom: 0;
                                right: 0;
                                margin: auto;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.swift-ctrls-holder button.ctrl-item svg * {
                                stroke: #8EC741;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.swift-ctrls-holder button.ctrl-item.text-length {
                                text-align: center;
                                border: none;
                                padding: 0px;
                                width: auto;
                                margin-right: 0;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.swift-ctrls-holder button.ctrl-item.text-length:hover,
                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.swift-ctrls-holder button.ctrl-item.text-length:active,
                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.swift-ctrls-holder button.ctrl-item.text-length:focus {
                                background: transparent;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.swift-ctrls-holder button.ctrl-item.text-length:hover:after,
                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.swift-ctrls-holder button.ctrl-item.text-length:active:after,
                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.swift-ctrls-holder button.ctrl-item.text-length:focus:after {
                                display: none;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.swift-ctrls-holder button.ctrl-item.text-length small {
                                color: #5b7083;
                                font-weight: normal;
                                font-size: 13px;
                                line-height: 35px;
                                vertical-align: middle;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.swift-ctrls-holder button.ctrl-item.text-length small.len-error {
                                color: #f6546a;
                                font-weight: bold;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.swift-ctrls-holder button.ctrl-item:hover::after,
                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.swift-ctrls-holder button.ctrl-item:active::after,
                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.swift-ctrls-holder button.ctrl-item:focus::after {
                                width: 35px;
                                height: 35px;
                                position: absolute;
                                left: -7px;
                                top: 0;
                                bottom: 0;
                                right: -7px;
                                background: #0074b01f;
                                content: "";
                                border-radius: 5em;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.swift-ctrls-holder button.ctrl-item:disabled {
                                cursor: not-allowed;
                                opacity: 0.5;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.swift-publisher {
                                display: block;
                                line-height: 0;
                                width: 100%;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.emojionearea {
                                border: none !important;
                                outline: 0 !important;
                                box-shadow: none !important;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.emojionearea div.emojionearea-editor {
                                border: none !important;
                                outline: 0 !important;
                                box-shadow: none !important;
                                padding: 0px;
                                resize: none;
                                font-size: 13px;
                                color: #002237;
                                line-height: 20px;
                                min-height: 40px !important;
                                max-height: unset !important;
                                white-space: normal !important;
                                max-width: 100%;
                                overflow: hidden;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.emojionearea div.emojionearea-editor::before {
                                color: #5b7083;
                                font-size: 17px;
                                font-weight: normal;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.emojionearea div.emojionearea-button {
                                display: none !important;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.emojionearea div.emojionearea-picker {
                                left: 0px !important;
                            }

                            body.cl-app-home div.modal.modal-swift-pubbox div.modal-body form div.emojionearea div.emojionearea-picker div.emojionearea-wrapper:after {
                                right: auto !important;
                                left: 78px !important;
                            }

                            /*# sourceMappingURL=style.master.css.map */

                            @media (max-width: 1024px) {
                                body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.timeline-swifts-holder div.timeline-swifts-cr.owl-carousel div.owl-stage-outer div.owl-stage div.owl-item div.swift-item {
                                    width: 55px;
                                    min-width: 55px;
                                }

                                body.cl-app-home main.main-content-container div.main-content-container-inner div.timeline-container div.timeline-swifts-holder div.timeline-swifts-cr.owl-carousel div.owl-stage-outer div.owl-stage div.owl-item div.swift-item div.swift-item-body div.avatar {
                                    width: 45px;
                                    height: 45px;
                                    min-width: 45px;
                                    min-height: 45px;
                                }

                                body.cl-app-home div.swift-app-container.show div.swift-data-cont {
                                    padding: 0px;
                                }

                                body.cl-app-home div.swift-app-container.show div.swift-data-cont div.swift-data {
                                    width: 100%;
                                    max-width: 100%;
                                    min-width: 300px;
                                    border-radius: 0px;
                                }
                            }

                            /*# sourceMappingURL=style.mq.css.map */
                            /*# sourceMappingURL=style.custom.css.map */
                            /** * Owl Carousel v2.3.4 * Copyright 2013-2018 David Deutsch * Licensed under: SEE LICENSE IN https://github.com/OwlCarousel2/OwlCarousel2/blob/master/LICENSE */

                            .owl-carousel,
                            .owl-carousel .owl-item {
                                -webkit-tap-highlight-color: transparent;
                                position: relative
                            }

                            .owl-carousel {
                                display: none;
                                width: 100%;
                                z-index: 1
                            }

                            .owl-carousel .owl-stage {
                                position: relative;
                                -ms-touch-action: pan-Y;
                                touch-action: manipulation;
                                -moz-backface-visibility: hidden
                            }

                            .owl-carousel .owl-stage:after {
                                content: ".";
                                display: block;
                                clear: both;
                                visibility: hidden;
                                line-height: 0;
                                height: 0
                            }

                            .owl-carousel .owl-stage-outer {
                                position: relative;
                                overflow: hidden;
                                -webkit-transform: translate3d(0, 0, 0)
                            }

                            .owl-carousel .owl-item,
                            .owl-carousel .owl-wrapper {
                                -webkit-backface-visibility: hidden;
                                -moz-backface-visibility: hidden;
                                -ms-backface-visibility: hidden;
                                -webkit-transform: translate3d(0, 0, 0);
                                -moz-transform: translate3d(0, 0, 0);
                                -ms-transform: translate3d(0, 0, 0)
                            }

                            .owl-carousel .owl-item {
                                min-height: 1px;
                                float: left;
                                -webkit-backface-visibility: hidden;
                                -webkit-touch-callout: none
                            }

                            .owl-carousel .owl-item img {
                                display: block;
                                width: 100%
                            }

                            .owl-carousel .owl-dots.disabled,
                            .owl-carousel .owl-nav.disabled {
                                display: none
                            }

                            .no-js .owl-carousel,
                            .owl-carousel.owl-loaded {
                                display: block
                            }

                            .owl-carousel .owl-dot,
                            .owl-carousel .owl-nav .owl-next,
                            .owl-carousel .owl-nav .owl-prev {
                                cursor: pointer;
                                -webkit-user-select: none;
                                -khtml-user-select: none;
                                -moz-user-select: none;
                                -ms-user-select: none;
                                user-select: none
                            }

                            .owl-carousel .owl-nav button.owl-next,
                            .owl-carousel .owl-nav button.owl-prev,
                            .owl-carousel button.owl-dot {
                                background: 0 0;
                                color: inherit;
                                border: none;
                                padding: 0 !important;
                                font: inherit
                            }

                            .owl-carousel.owl-loading {
                                opacity: 0;
                                display: block
                            }

                            .owl-carousel.owl-hidden {
                                opacity: 0
                            }

                            .owl-carousel.owl-refresh .owl-item {
                                visibility: hidden
                            }

                            .owl-carousel.owl-drag .owl-item {
                                -ms-touch-action: pan-y;
                                touch-action: pan-y;
                                -webkit-user-select: none;
                                -moz-user-select: none;
                                -ms-user-select: none;
                                user-select: none
                            }

                            .owl-carousel.owl-grab {
                                cursor: move;
                                cursor: grab
                            }

                            .owl-carousel.owl-rtl {
                                direction: rtl
                            }

                            .owl-carousel.owl-rtl .owl-item {
                                float: right
                            }

                            .owl-carousel .animated {
                                animation-duration: 1s;
                                animation-fill-mode: both
                            }

                            .owl-carousel .owl-animated-in {
                                z-index: 0
                            }

                            .owl-carousel .owl-animated-out {
                                z-index: 1
                            }

                            .owl-carousel .fadeOut {
                                animation-name: fadeOut
                            }

                            @keyframes fadeOut {
                                0% {
                                    opacity: 1
                                }

                                100% {
                                    opacity: 0
                                }
                            }

                            .owl-height {
                                transition: height .5s ease-in-out
                            }

                            .owl-carousel .owl-item .owl-lazy {
                                opacity: 0;
                                transition: opacity .4s ease
                            }

                            .owl-carousel .owl-item .owl-lazy:not([src]),
                            .owl-carousel .owl-item .owl-lazy[src^=""] {
                                max-height: 0
                            }

                            .owl-carousel .owl-item img.owl-lazy {
                                transform-style: preserve-3d
                            }

                            .owl-carousel .owl-video-wrapper {
                                position: relative;
                                height: 100%;
                                background: #000
                            }

                            .owl-carousel .owl-video-play-icon {
                                position: absolute;
                                height: 80px;
                                width: 80px;
                                left: 50%;
                                top: 50%;
                                margin-left: -40px;
                                margin-top: -40px;
                                background: url(owl.video.play.png) no-repeat;
                                cursor: pointer;
                                z-index: 1;
                                -webkit-backface-visibility: hidden;
                                transition: transform .1s ease
                            }

                            .owl-carousel .owl-video-play-icon:hover {
                                -ms-transform: scale(1.3, 1.3);
                                transform: scale(1.3, 1.3)
                            }

                            .owl-carousel .owl-video-playing .owl-video-play-icon,
                            .owl-carousel .owl-video-playing .owl-video-tn {
                                display: none
                            }

                            .owl-carousel .owl-video-tn {
                                opacity: 0;
                                height: 100%;
                                background-position: center center;
                                background-repeat: no-repeat;
                                background-size: contain;
                                transition: opacity .4s ease
                            }

                            .owl-carousel .owl-video-frame {
                                position: relative;
                                z-index: 1;
                                height: 100%;
                                width: 100%
                            }

                            /** * Owl Carousel v2.3.4 * Copyright 2013-2018 David Deutsch * Licensed under: SEE LICENSE IN https://github.com/OwlCarousel2/OwlCarousel2/blob/master/LICENSE */
                            /* *Default theme - Owl Carousel CSS File */

                            .owl-theme .owl-nav {
                                margin-top: 10px;
                                text-align: center;
                                -webkit-tap-highlight-color: transparent;
                            }

                            .owl-theme .owl-nav [class*='owl-'] {
                                color: #FFF;
                                font-size: 14px;
                                margin: 5px;
                                padding: 4px 7px;
                                background: #D6D6D6;
                                display: inline-block;
                                cursor: pointer;
                                border-radius: 3px;
                            }

                            .owl-theme .owl-nav [class*='owl-']:hover {
                                background: #869791;
                                color: #FFF;
                                text-decoration: none;
                            }

                            .owl-theme .owl-nav .disabled {
                                opacity: 0.5;
                                cursor: default;
                            }

                            .owl-theme .owl-nav.disabled + .owl-dots {
                                margin-top: 10px;
                            }

                            .owl-theme .owl-dots {
                                text-align: center;
                                -webkit-tap-highlight-color: transparent;
                            }

                            .owl-theme .owl-dots .owl-dot {
                                display: inline-block;
                                zoom: 1;
                                *display: inline;
                            }

                            .owl-theme .owl-dots .owl-dot span {
                                width: 10px;
                                height: 10px;
                                margin: 5px 7px;
                                background: #D6D6D6;
                                display: block;
                                -webkit-backface-visibility: visible;
                                transition: opacity 200ms ease;
                                border-radius: 30px;
                            }

                            .owl-theme .owl-dots .owl-dot.active span,
                            .owl-theme .owl-dots .owl-dot:hover span {
                                background: #869791;
                            }
                        </style>
                        <script>
                            "use strict";

                            $(document).ready(function ($) {
                                var _app = $('[data-app="homepage"]');
                                var loading = false;
                                var loadmore = true;

                                $(window).on('scroll', function () {
                                    if (($(window).scrollTop() + $(window).height()) > ($(document).height() - 100)) {
                                        if (cl_empty(loading) && loadmore) {

                                            var post_ls = _app.find('[data-an="entry-list"]');
                                            var offset = 0;

                                            if (post_ls.find('div[data-post-offset]').length) {
                                                offset = post_ls.find('div[data-post-offset]').last().data('post-offset');
                                            }

                                            if ($.isNumeric(offset) && offset) {
                                                $.ajax({
                                                    url: 'https://trysoftcolib.com//native_api/home/load_more',
                                                    type: 'GET',
                                                    dataType: 'json',
                                                    data: {
                                                        offset: offset
                                                    },
                                                    beforeSend: function () {
                                                        loading = true;
                                                    }
                                                }).done(function (data) {
                                                    if (data.status == 200) {
                                                        post_ls.append($(data.html));
                                                    } else {
                                                        loadmore = false;
                                                    }
                                                }).always(function () {
                                                    loading = false;
                                                });
                                            }
                                        }
                                    }
                                });

                                /* @*************************************************************************@// @ @author Mansur Altamirov (Mansur_TL) @// @ @author_url 1: https://www.instagram.com/mansur_tl@// @ @author_url 2: http://codecanyon.net/user/mansur_tl@// @ @author_email: highexpresstore@gmail.com@// @*************************************************************************@// @ ColibriSM - The Ultimate Modern Social Media Sharing Platform@// @ Copyright (c) 21.03.2020 ColibriSM. All rights reserved.@// @*************************************************************************@*/
                                var pubbox_form_app_mixin = Object({
                                    data: function () {
                                        return {
                                            text: "",
                                            images: [],
                                            video: {},
                                            poll: [],
                                            gifs_r1: [],
                                            gifs_r2: [],
                                            image_ctrl: true,
                                            video_ctrl: true,
                                            poll_ctrl: true,
                                            gif_ctrl: true,
                                            submitting: false,
                                            active_media: null,
                                            gif_source: null,
                                            post_privacy: "everyone",
                                            og_imported: false,
                                            og_data: {},
                                            og_hidden: [],
                                            settings: {
                                                max_length: "600"
                                            },
                                            sdds: {
                                                privacy: {
                                                    everyone: "Everyone ",
                                                    followers: "Only my followers",
                                                }
                                            },
                                            data_temp: {
                                                poll: {
                                                    title: "Option - ",
                                                    value: ""
                                                }
                                            }
                                        };
                                    },
                                    computed: {
                                        valid_form: function () {
                                            var _app_ = this;
                                            if (_app_.active_media == 'image') {
                                                if (_app_.images.length >= 1 && cl_empty(_app_.submitting)) {
                                                    return true;
                                                } else {
                                                    return false;
                                                }
                                            } else if (_app_.active_media == 'gifs') {
                                                if (cl_empty(_app_.gif_source) != true && cl_empty(_app_.submitting)) {
                                                    return true;
                                                } else {
                                                    return false;
                                                }
                                            } else if (_app_.active_media == 'video') {
                                                if ($.isEmptyObject(_app_.video) != true && cl_empty(_app_.submitting)) {
                                                    return true;
                                                } else {
                                                    return false;
                                                }
                                            } else if (_app_.active_media == 'poll') {
                                                if (_app_.text.length > 0 && _app_.valid_poll && cl_empty(_app_.submitting)) {
                                                    return true;
                                                } else {
                                                    return false;
                                                }
                                            } else if ((_app_.active_media == null && _app_.text.length > 0) || _app_.og_imported) {
                                                return true;
                                            } else {
                                                return false;
                                            }
                                        },
                                        equal_height: function () {
                                            var app_el = $(this.$el);
                                            return "{0}px".format((app_el.innerWidth() / 4));
                                        },
                                        preview_video: function () {
                                            if ($.isEmptyObject(this.video)) {
                                                return false;
                                            }
                                            return true;
                                        },
                                        gifs: function () {
                                            if (this.gifs_r1.length || this.gifs_r2.length) {
                                                return true;
                                            }
                                            return false;
                                        },
                                        show_og_data: function () {
                                            if (this.og_imported == true && this.active_media == null && this.og_hidden.contains(this.og_data.url) != true) {
                                                return true;
                                            } else {
                                                return false;
                                            }
                                        },
                                        valid_poll: function () {
                                            var _app_ = this;
                                            if (cl_empty(_app_.poll.length)) {
                                                return false;
                                            } else {
                                                for (var i = 0; i < _app_.poll.length; i++) {
                                                    if (cl_empty(_app_.poll[i].value)) {
                                                        return false;
                                                    }
                                                }
                                                return true;
                                            }
                                        }
                                    },
                                    methods: {
                                        emoji_picker: function (action = "toggle") {
                                            var app_el = $(this.$el);
                                            var _app_ = this;
                                            if (app_el.length) {
                                                if (action == "toggle") {
                                                    if (app_el.find('textarea').get(0).emojioneArea.isOpened()) {
                                                        app_el.find('textarea').get(0).emojioneArea.hidePicker();
                                                    } else {
                                                        app_el.find('textarea').get(0).emojioneArea.showPicker();
                                                        _app_.rep_emoji_picker();
                                                    }
                                                } else if (action == "open") {
                                                    if (app_el.find('textarea').get(0).emojioneArea.isOpened() != true) {
                                                        app_el.find('textarea').get(0).emojioneArea.showPicker();
                                                        _app_.rep_emoji_picker();
                                                    }
                                                } else if (action == "close") {
                                                    if (app_el.find('textarea').get(0).emojioneArea.isOpened()) {
                                                        app_el.find('textarea').get(0).emojioneArea.hidePicker();
                                                    }
                                                }
                                            }
                                        },
                                        rep_emoji_picker: function () {
                                            var app_el = $(this.$el);
                                            app_el.find('div.emojionearea-picker').css("top", "{0}px".format(app_el.height() - 40));
                                        },
                                        textarea_resize: function (_self = null) {
                                            autosize($(_self.target));
                                        },
                                        publish: function (_self = null) {
                                            _self.preventDefault();
                                            var form = $(_self.$el);
                                            var _app_ = this;
                                            var main_left_sb = $('div[data-app="left-sidebar"]');
                                            $(_self.target).ajaxSubmit({
                                                url: "https://trysoftcolib.com//native_api/main/publish_new_post",
                                                type: 'POST',
                                                dataType: 'json',
                                                data: {
                                                    gif_src: _app_.gif_source,
                                                    thread_id: ((_app_.thread_id) ? _app_.thread_id : 0),
                                                    curr_pn: SMColibri.curr_pn,
                                                    og_data: _app_.og_data,
                                                    privacy: _app_.post_privacy,
                                                    poll_data: _app_.poll
                                                },
                                                beforeSend: function () {
                                                    _app_.submitting = true;
                                                },
                                                success: function (data) {
                                                    if (data.status == 200) {
                                                        if (SMColibri.curr_pn == "home") {
                                                            var home_timeline = $('div[data-app="homepage"]');
                                                            var new_post = $(data.html).addClass('animated fadeIn');
                                                            if (home_timeline.find('div[data-an="entry-list"]').length) {
                                                                home_timeline.find('div[data-an="entry-list"]').prepend(new_post).promise().done(function () {
                                                                    setTimeout(function () {
                                                                        home_timeline.find('div[data-an="entry-list"]').find('[data-list-item]').first().removeClass('animated fadeIn');
                                                                    }, 1000);
                                                                });
                                                            } else {
                                                                SMColibri.spa_reload();
                                                            }
                                                        } else if (SMColibri.curr_pn == "thread" && _app_.thread_id) {
                                                            _app_.thread_id = 0;
                                                            var thread_timeline = $('div[data-app="thread"]');
                                                            var new_post = $(data.html).addClass('animated fadeIn');
                                                            if (thread_timeline.find('div[data-an="replys-list"]').length) {
                                                                thread_timeline.find('div[data-an="replys-list"]').prepend(new_post).promise().done(function () {
                                                                    setTimeout(function () {
                                                                        thread_timeline.find('div[data-an="replys-list"]').find('[data-list-item]').first().removeClass('animated fadeIn');
                                                                    }, 1000);
                                                                });
                                                            } else {
                                                                SMColibri.spa_reload();
                                                            }
                                                            thread_timeline.find('[data-an="pub-replys-total"]').text(data.replys_total);
                                                        } else {
                                                            cl_bs_notify("Your new publication has been posted on your timeline", 1200);
                                                        }
                                                        if ($(_app_.$el).attr('id') == 'vue-pubbox-app-2') {
                                                            $(_app_.$el).parents("div#add_new_post").modal('hide');
                                                        }
                                                        if (data.posts_total) {
                                                            main_left_sb.find('b[data-an="total-posts"]').text(data.posts_total);
                                                        }
                                                    } else {
                                                        _app_.submitting = false;
                                                        SMColibri.errorMSG();
                                                    }
                                                },
                                                complete: function () {
                                                    _app_.submitting = false;
                                                    _app_.reset_data();
                                                }
                                            });
                                        },
                                        create_poll: function () {
                                            var _app_ = this;
                                            if (cl_empty(_app_.active_media)) {
                                                if (_app_.poll_ctrl) {
                                                    _app_.active_media = "poll";
                                                    _app_.poll_option();
                                                    _app_.poll_option();
                                                    _app_.disable_ctrls();
                                                }
                                            }
                                        },
                                        poll_option: function () {
                                            var _app_ = this;
                                            if (_app_.poll.length < 4) {
                                                var poll_option_data = Object({
                                                    title: _app_.data_temp.poll.title,
                                                    value: _app_.data_temp.poll.value
                                                });
                                                _app_.poll.push(poll_option_data);
                                            } else {
                                                return false;
                                            }
                                        },
                                        cancel_poll: function () {
                                            var _app_ = this;
                                            _app_.active_media = null;
                                            _app_.poll = [];
                                            _app_.disable_ctrls();
                                        },
                                        select_images: function () {
                                            var _app_ = this;
                                            if (_app_.active_media == 'image' || cl_empty(_app_.active_media)) {
                                                if (_app_.image_ctrl) {
                                                    var app_el = $(_app_.$el);
                                                    app_el.find('input[data-an="images-input"]').trigger('click');
                                                }
                                            }
                                        },
                                        select_video: function () {
                                            var _app_ = this;
                                            if (cl_empty(_app_.active_media)) {
                                                if (_app_.video_ctrl) {
                                                    var app_el = $(_app_.$el);
                                                    app_el.find('input[data-an="video-input"]').trigger('click');
                                                }
                                            }
                                        },
                                        select_gifs: function () {
                                            var _app_ = this;
                                            var step = false;
                                            if (cl_empty(_app_.active_media)) {
                                                $.ajax({
                                                    url: 'https://api.giphy.com/v1/gifs/trending',
                                                    type: 'GET',
                                                    dataType: 'json',
                                                    data: {
                                                        api_key: 'EEoFiCosGuyEIWlXnRuw4McTLxfjCrl1',
                                                        limit: 50,
                                                        lang: cl_get_ulang(),
                                                        fmt: 'json'
                                                    },
                                                }).done(function (data) {
                                                    if (data.meta.status == 200 && data.data.length > 0) {
                                                        for (var i = 0; i < data.data.length; i++) {
                                                            if (step) {
                                                                _app_.gifs_r1.push({
                                                                    thumb: data['data'][i]['images']['preview_gif']['url'],
                                                                    src: data['data'][i]['images']['original']['url'],
                                                                });
                                                            } else {
                                                                _app_.gifs_r2.push({
                                                                    thumb: data['data'][i]['images']['preview_gif']['url'],
                                                                    src: data['data'][i]['images']['original']['url'],
                                                                });
                                                            }
                                                            step = !step;
                                                        }
                                                    }
                                                }).always(function () {
                                                    if (_app_.gifs && cl_empty(_app_.active_media)) {
                                                        _app_.active_media = "gifs";
                                                    }
                                                    _app_.disable_ctrls();
                                                });
                                            }
                                        },
                                        search_gifs: function (_self = null) {
                                            if (_self.target.value.length >= 2) {
                                                var query = $.trim(_self.target.value);
                                                var step = false;
                                                var _app_ = this;
                                                var gifs_r1 = _app_.gifs_r1;
                                                var gifs_r2 = _app_.gifs_r2;
                                                $.ajax({
                                                    url: 'https://api.giphy.com/v1/gifs/search',
                                                    type: 'GET',
                                                    dataType: 'json',
                                                    data: {
                                                        q: query,
                                                        api_key: 'EEoFiCosGuyEIWlXnRuw4McTLxfjCrl1',
                                                        limit: 50,
                                                        lang: 'en',
                                                        fmt: 'json'
                                                    }
                                                }).done(function (data) {
                                                    if (data.meta.status == 200 && data.data.length > 0) {
                                                        _app_.gifs_r1 = [];
                                                        _app_.gifs_r2 = [];
                                                        for (var i = 0; i < data.data.length; i++) {
                                                            if (step) {
                                                                _app_.gifs_r1.push({
                                                                    thumb: data['data'][i]['images']['preview_gif']['url'],
                                                                    src: data['data'][i]['images']['original']['url'],
                                                                });
                                                            } else {
                                                                _app_.gifs_r2.push({
                                                                    thumb: data['data'][i]['images']['preview_gif']['url'],
                                                                    src: data['data'][i]['images']['original']['url'],
                                                                });
                                                            }
                                                            step = !step;
                                                        }
                                                    } else {
                                                        _app_.gifs_r1 = gifs_r1;
                                                        _app_.gifs_r2 = gifs_r2;
                                                    }
                                                });
                                            }
                                        },
                                        preview_gif: function (_self = null) {
                                            var _app_ = this;
                                            if (_self.target) {
                                                _app_.gif_source = $(_self.target).data('source');
                                            }
                                        },
                                        rm_preview_gif: function () {
                                            var _app_ = this;
                                            _app_.gif_source = null;
                                        },
                                        close_gifs: function () {
                                            var _app_ = this;
                                            _app_.gifs_r1 = [];
                                            _app_.gifs_r2 = [];
                                            _app_.active_media = null;
                                            _app_.disable_ctrls();
                                        },
                                        rm_gif_preloader(_self = null) {
                                            if (_self.target) {
                                                $(_self.target).siblings('div').remove();
                                                $(_self.target).parent('div').removeClass('loading');
                                            }
                                        },
                                        upload_images: function (event = null) {
                                            var _app_ = this;
                                            var app_el = $(_app_.$el);
                                            if (cl_empty(_app_.active_media) || _app_.active_media == 'image') {
                                                var images = event.target.files;
                                                if (SMColibri.curr_pn == 'thread') {
                                                    $('div[data-app="modal-pubbox"]').addClass('vis-hidden');
                                                }
                                                SMColibri.upload_progress_bar('show', "Uploading images");
                                                if (images.length) {
                                                    for (var i = 0; i < images.length; i++) {
                                                        var form_data = new FormData();
                                                        var break_loop = false;
                                                        form_data.append('delay', 1);
                                                        form_data.append('image', images[i]);
                                                        form_data.append('hash', "1621282486:d05785002742a30502dde3731b28883334e46040");
                                                        $.ajax({
                                                            url: 'https://trysoftcolib.com//native_api/main/upload_post_image',
                                                            type: 'POST',
                                                            dataType: 'json',
                                                            enctype: 'multipart/form-data',
                                                            data: form_data,
                                                            cache: false,
                                                            contentType: false,
                                                            processData: false,
                                                            timeout: 600000,
                                                            beforeSend: function () {
                                                                _app_.submitting = true;
                                                            },
                                                            success: function (data) {
                                                                if (data.status == 200) {
                                                                    _app_.images.push(data.img);
                                                                } else if (data.err_code == "total_limit_exceeded") {
                                                                    cl_bs_notify("You cannot attach more than 10 images to this post.", 1500);
                                                                    break_loop = true;
                                                                } else {
                                                                    cl_bs_notify("An error occurred while processing your request. Please try again later.", 3000);
                                                                }
                                                            },
                                                            complete: function () {
                                                                if (_app_.images.length && cl_empty(_app_.active_media)) {
                                                                    _app_.active_media = "image";
                                                                }
                                                                _app_.disable_ctrls();
                                                                _app_.submitting = false;
                                                            }
                                                        });
                                                        if (break_loop) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                setTimeout(function () {
                                                    SMColibri.upload_progress_bar('end');
                                                    if (SMColibri.curr_pn == 'thread') {
                                                        $('div[data-app="modal-pubbox"]').removeClass('vis-hidden');
                                                    }
                                                }, 1500);
                                                app_el.find('input[data-an="images-input"]').val('');
                                            }
                                        },
                                        upload_video: function (event = null) {
                                            var _app_ = this;
                                            var app_el = $(_app_.$el);
                                            if (cl_empty(_app_.active_media)) {
                                                var video = event.target.files[0];
                                                if (video) {
                                                    var form_data = new FormData();
                                                    form_data.append('video', video);
                                                    form_data.append('hash', "1621282486:d05785002742a30502dde3731b28883334e46040");
                                                    $.ajax({
                                                        url: 'https://trysoftcolib.com//native_api/main/upload_post_video',
                                                        type: 'POST',
                                                        dataType: 'json',
                                                        enctype: 'multipart/form-data',
                                                        data: form_data,
                                                        cache: false,
                                                        contentType: false,
                                                        processData: false,
                                                        timeout: 600000,
                                                        beforeSend: function () {
                                                            SMColibri.upload_progress_bar('show', "Uploading video");
                                                            if (SMColibri.curr_pn == 'thread') {
                                                                $('div[data-app="modal-pubbox"]').addClass('vis-hidden');
                                                            }
                                                        },
                                                        success: function (data) {
                                                            if (data.status == 200) {
                                                                _app_.video = data.video;
                                                            } else if (data.err_code == "total_limit_exceeded") {
                                                                cl_bs_notify("You cannot attach more than 1 video to this post.", 1500);
                                                            } else {
                                                                cl_bs_notify("An error occurred while processing your request. Please try again later.", 3000);
                                                            }
                                                        },
                                                        complete: function () {
                                                            if ($.isEmptyObject(_app_.video) != true && cl_empty(_app_.active_media)) {
                                                                _app_.active_media = "video";
                                                            }
                                                            _app_.disable_ctrls();
                                                            app_el.find('input[data-an="video-input"]').val('');
                                                            setTimeout(function () {
                                                                SMColibri.upload_progress_bar('end');
                                                                if (SMColibri.curr_pn == 'thread') {
                                                                    $('div[data-app="modal-pubbox"]').removeClass('vis-hidden');
                                                                }
                                                            }, 1500);
                                                        }
                                                    });
                                                }
                                            }
                                        },
                                        delete_image: function (id = null) {
                                            if (cl_empty(id)) {
                                                return false;
                                            } else {
                                                var _app_ = this;
                                                for (var i = 0; i < _app_.images.length; i++) {
                                                    if (_app_.images[i]['id'] == id) {
                                                        _app_.images.splice(i, 1);
                                                    }
                                                }
                                                $.ajax({
                                                    url: 'https://trysoftcolib.com//native_api/main/delete_post_image',
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data: {
                                                        image_id: id
                                                    },
                                                }).done(function (data) {
                                                    if (data.status != 200) {
                                                        SMColibri.errorMSG();
                                                    }
                                                }).always(function () {
                                                    if (cl_empty(_app_.images.length)) {
                                                        _app_.active_media = null;
                                                    }
                                                    _app_.disable_ctrls();
                                                });
                                            }
                                        },
                                        delete_video: function () {
                                            var _app_ = this;
                                            $.ajax({
                                                url: 'https://trysoftcolib.com//native_api/main/delete_post_video',
                                                type: 'POST',
                                                dataType: 'json',
                                            }).done(function (data) {
                                                if (data.status != 200) {
                                                    SMColibri.errorMSG();
                                                } else {
                                                    _app_.video = Object({});
                                                }
                                            }).always(function () {
                                                if ($.isEmptyObject(_app_.video)) {
                                                    _app_.active_media = null;
                                                }
                                                _app_.disable_ctrls();
                                            });
                                        },
                                        disable_ctrls: function () {
                                            var _app_ = this;
                                            if (_app_.active_media == 'image' && _app_.images.length >= 10) {
                                                _app_.image_ctrl = false;
                                                _app_.gif_ctrl = false;
                                                _app_.video_ctrl = false;
                                                _app_.poll_ctrl = false;
                                            } else if (_app_.active_media == 'image' && _app_.images.length < 10) {
                                                _app_.image_ctrl = true;
                                                _app_.gif_ctrl = false;
                                                _app_.video_ctrl = false;
                                                _app_.poll_ctrl = false;
                                            } else if (_app_.active_media != null) {
                                                _app_.image_ctrl = false;
                                                _app_.gif_ctrl = false;
                                                _app_.video_ctrl = false;
                                                _app_.poll_ctrl = false;
                                            } else {
                                                _app_.image_ctrl = true;
                                                _app_.gif_ctrl = true;
                                                _app_.video_ctrl = true;
                                                _app_.poll_ctrl = true;
                                            }
                                        },
                                        reset_data: function () {
                                            var _app_ = this;
                                            _app_.image_ctrl = true;
                                            _app_.gif_ctrl = true;
                                            _app_.poll_ctrl = true;
                                            _app_.video_ctrl = true;
                                            _app_.og_imported = false;
                                            _app_.text = "";
                                            _app_.images = [];
                                            _app_.video = Object({});
                                            _app_.og_data = Object({});
                                            _app_.poll = [];
                                            _app_.active_media = null;
                                            _app_.gif_source = null;
                                            _app_.gifs_r1 = [];
                                            _app_.gifs_r2 = [];
                                            _app_.og_hidden = [];
                                            $(_app_.$el).find('textarea').get(0).emojioneArea.setText("");
                                            _app_.rep_emoji_picker();
                                        },
                                        rm_preview_og: function () {
                                            var _app_ = this;
                                            _app_.og_hidden.push(_app_.og_data.url);
                                            _app_.og_imported = false;
                                            _app_.og_data = Object({});
                                        }
                                    },
                                    updated: function () {
                                        var _app_ = this;
                                        _app_.rep_emoji_picker();
                                        delay(function () {
                                            if (_app_.og_imported != true) {
                                                var text_links = _app_.text.match(/(https?:\/\/[^\s]+)/);
                                                if (text_links && text_links.length > 0 && _app_.og_hidden.contains(text_links[0]) != true) {
                                                    $.ajax({
                                                        url: 'https://trysoftcolib.com//native_api/main/import_og_data',
                                                        type: 'POST',
                                                        dataType: 'json',
                                                        data: {
                                                            url: text_links[0]
                                                        }
                                                    }).done(function (data) {
                                                        if (data.status == 200) {
                                                            _app_.og_imported = true;
                                                            _app_.og_data = data.og_data;
                                                        }
                                                    });
                                                }
                                            }
                                        }, 800);
                                    },
                                    mounted: function () {
                                    }
                                });
                                var emoji_filters = Object({
                                    recent: {
                                        title: "Recent"
                                    },
                                    smileys_people: {
                                        title: "Emoticons and People",
                                    },
                                    animals_nature: {
                                        title: "Animals & Nature",
                                    },
                                    food_drink: {
                                        title: "Food & Drink",
                                    },
                                    activity: {
                                        title: "Activity",
                                    },
                                    travel_places: {
                                        title: "Travel & Places",
                                    },
                                    objects: {
                                        title: "Objects",
                                    },
                                    symbols: {
                                        title: "Symbols",
                                    },
                                    flags: {
                                        title: "Flags",
                                    }
                                });
                                if ($("form#vue-pubbox-app-1").length) {
                                    var pubbox_app_1 = new Vue({
                                        el: "#vue-pubbox-app-1",
                                        mixins: [pubbox_form_app_mixin]
                                    });

                                    $(pubbox_app_1.$el).find('textarea').emojioneArea({
                                        pickerPosition: "bottom",
                                        search: false,
                                        filters: emoji_filters
                                    });

                                    $(pubbox_app_1.$el).find('textarea').get(0).emojioneArea.on('emojibtn.click', function (event) {
                                        pubbox_app_1.text = $(pubbox_app_1.$el).find('textarea').get(0).emojioneArea.getText();
                                    });

                                    $(pubbox_app_1.$el).find('textarea').get(0).emojioneArea.on('keyup', function (event) {
                                        pubbox_app_1.text = $(pubbox_app_1.$el).find('textarea').get(0).emojioneArea.getText();
                                    });
                                }

                                _app.find('[data-an="homepage-swifts-slider"]').owlCarousel({
                                    autoWidth: true,
                                    center: false,
                                    loop: false,
                                    dots: false,
                                    margin: 0,
                                    autoplay: false,
                                    nav: false,
                                    navText: ["", ""],
                                    slideBy: 3
                                });

                                var CLNewSwift = new Vue({
                                    el: "#cl-new-swift-vue-app",
                                    data: {
                                        text: "",
                                        image: {},
                                        video: {},
                                        gifs_r1: [],
                                        gifs_r2: [],
                                        image_ctrl: true,
                                        video_ctrl: true,
                                        gif_ctrl: true,
                                        submitting: false,
                                        active_media: null,
                                        gif_source: null
                                    },
                                    computed: {
                                        valid_form: function () {
                                            if (this.active_media != null && cl_empty(this.submitting)) {
                                                return true;
                                            } else {
                                                return false;
                                            }
                                        }
                                    },
                                    methods: {
                                        add_swift: function () {
                                            _app.find('[data-an="swift-pubbox"]').modal("show");
                                        },
                                        emoji_picker: function (action = "toggle") {
                                            var app_el = $(this.$el);
                                            var _app_ = this;

                                            if (app_el.length) {
                                                if (action == "toggle") {
                                                    if (app_el.find('textarea').get(0).emojioneArea.isOpened()) {
                                                        app_el.find('textarea').get(0).emojioneArea.hidePicker();
                                                    } else {
                                                        app_el.find('textarea').get(0).emojioneArea.showPicker();
                                                        _app_.rep_emoji_picker();
                                                    }
                                                } else if (action == "open") {
                                                    if (app_el.find('textarea').get(0).emojioneArea.isOpened() != true) {
                                                        app_el.find('textarea').get(0).emojioneArea.showPicker();
                                                        _app_.rep_emoji_picker();
                                                    }
                                                } else if (action == "close") {
                                                    if (app_el.find('textarea').get(0).emojioneArea.isOpened()) {
                                                        app_el.find('textarea').get(0).emojioneArea.hidePicker();
                                                    }
                                                }
                                            }
                                        },
                                        rep_emoji_picker: function () {
                                            var app_el = $(this.$el);
                                            app_el.find('div.emojionearea-picker').css("top", "{0}px".format(app_el.height() + 20));
                                        },
                                        textarea_resize: function (_self = null) {
                                            autosize($(_self.target));
                                        },
                                        publish: function (_self = null) {
                                            _self.preventDefault();

                                            var form = $(_self.$el);
                                            var _app_ = this;

                                            $(_self.target).ajaxSubmit({
                                                url: "https://trysoftcolib.com//native_api/swift/publish_new_swift",
                                                type: 'POST',
                                                dataType: 'json',
                                                beforeSend: function () {
                                                    _app_.submitting = true;
                                                },
                                                success: function (data) {
                                                    if (data.status != 200) {
                                                        _app_.submitting = false;
                                                        SMColibri.errorMSG();
                                                    } else {
                                                        SMColibri.spa_reload();
                                                    }
                                                },
                                                complete: function () {
                                                    _app_.submitting = false;
                                                    _app_.reset_data();

                                                    _app.find('[data-an="swift-pubbox"]').modal("hide");
                                                }
                                            });
                                        },
                                        select_images: function () {
                                            var _app_ = this;

                                            if (_app_.active_media == 'image' || cl_empty(_app_.active_media)) {
                                                if (_app_.image_ctrl) {
                                                    var app_el = $(_app_.$el);
                                                    app_el.find('input[data-an="images-input"]').trigger('click');
                                                }
                                            }
                                        },
                                        select_video: function () {
                                            var _app_ = this;

                                            if (cl_empty(_app_.active_media)) {
                                                if (_app_.video_ctrl) {
                                                    var app_el = $(_app_.$el);
                                                    app_el.find('input[data-an="video-input"]').trigger('click');
                                                }
                                            }
                                        },
                                        upload_images: function (event = null) {
                                            var _app_ = this;
                                            var app_el = $(_app_.$el);

                                            if (cl_empty(_app_.active_media) || _app_.active_media == 'image') {
                                                SMColibri.upload_progress_bar('show', "Uploading image");

                                                var form_data = new FormData();

                                                form_data.append('delay', 1);
                                                form_data.append('image', event.target.files[0]);
                                                form_data.append('hash', "1621282486:d05785002742a30502dde3731b28883334e46040");

                                                $.ajax({
                                                    url: 'https://trysoftcolib.com//native_api/swift/upload_swift_image',
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    enctype: 'multipart/form-data',
                                                    data: form_data,
                                                    cache: false,
                                                    contentType: false,
                                                    processData: false,
                                                    timeout: 600000,
                                                    beforeSend: function () {
                                                        _app_.submitting = true;
                                                    },
                                                    success: function (data) {
                                                        if (data.status == 200) {
                                                            _app_.image = data.img;
                                                        } else {
                                                            SMColibri.errorMSG();
                                                        }
                                                    },
                                                    complete: function () {
                                                        if (cl_empty(_app_.active_media)) {
                                                            _app_.active_media = "image";
                                                        }

                                                        _app_.disable_ctrls();

                                                        _app_.submitting = false;
                                                    }
                                                });

                                                setTimeout(function () {
                                                    SMColibri.upload_progress_bar('end');
                                                }, 1500);

                                                app_el.find('input[data-an="images-input"]').val('');
                                            }
                                        },
                                        upload_video: function (event = null) {
                                            var _app_ = this;
                                            var app_el = $(_app_.$el);

                                            if (cl_empty(_app_.active_media)) {
                                                var video = event.target.files[0];
                                                if (video) {
                                                    var form_data = new FormData();
                                                    form_data.append('video', video);
                                                    form_data.append('hash', "1621282486:d05785002742a30502dde3731b28883334e46040");

                                                    $.ajax({
                                                        url: 'https://trysoftcolib.com//native_api/swift/upload_swift_video',
                                                        type: 'POST',
                                                        dataType: 'json',
                                                        enctype: 'multipart/form-data',
                                                        data: form_data,
                                                        cache: false,
                                                        contentType: false,
                                                        processData: false,
                                                        timeout: 600000,
                                                        beforeSend: function () {
                                                            SMColibri.upload_progress_bar('show', "Uploading video");
                                                        },
                                                        success: function (data) {
                                                            if (data.status == 200) {
                                                                _app_.video = data.video;
                                                            } else {
                                                                SMColibri.errorMSG();
                                                            }
                                                        },
                                                        complete: function () {
                                                            if ($.isEmptyObject(_app_.video) != true && cl_empty(_app_.active_media)) {
                                                                _app_.active_media = "video";
                                                            }

                                                            _app_.disable_ctrls();
                                                            app_el.find('input[data-an="video-input"]').val('');

                                                            setTimeout(function () {
                                                                SMColibri.upload_progress_bar('end');
                                                            }, 1500);
                                                        }
                                                    });
                                                }
                                            }
                                        },
                                        delete_image: function () {
                                            var _app_ = this;

                                            $.ajax({
                                                url: 'https://trysoftcolib.com//native_api/swift/delete_swift_image',
                                                type: 'POST',
                                                dataType: 'json',
                                            }).done(function (data) {
                                                if (data.status != 200) {
                                                    SMColibri.errorMSG();
                                                } else {
                                                    _app_.video = Object({});
                                                }
                                            }).always(function () {
                                                _app_.active_media = null;

                                                _app_.disable_ctrls();
                                            });
                                        },
                                        delete_video: function () {
                                            var _app_ = this;

                                            $.ajax({
                                                url: 'https://trysoftcolib.com//native_api/swift/delete_swift_video',
                                                type: 'POST',
                                                dataType: 'json',
                                            }).done(function (data) {
                                                if (data.status != 200) {
                                                    SMColibri.errorMSG();
                                                } else {
                                                    _app_.video = Object({});
                                                }
                                            }).always(function () {
                                                if ($.isEmptyObject(_app_.video)) {
                                                    _app_.active_media = null;
                                                }

                                                _app_.disable_ctrls();
                                            });
                                        },
                                        disable_ctrls: function () {
                                            var _app_ = this;

                                            if (_app_.active_media != null) {
                                                _app_.image_ctrl = false;
                                                _app_.video_ctrl = false;
                                            } else {
                                                _app_.image_ctrl = true;
                                                _app_.video_ctrl = true;
                                            }
                                        },
                                        reset_data: function () {
                                            var _app_ = this;
                                            _app_.image_ctrl = true;
                                            _app_.video_ctrl = true;
                                            _app_.text = "";
                                            _app_.images = Object({});
                                            _app_.video = Object({});
                                            _app_.active_media = null;

                                            $(_app_.$el).find('textarea').get(0).emojioneArea.setText("");
                                            _app_.rep_emoji_picker();
                                        }
                                    },
                                    mounted: function () {
                                        var _app_ = this;

                                        $(_app_.$el).find('textarea').emojioneArea({
                                            pickerPosition: "bottom",
                                            search: false,
                                            filters: emoji_filters
                                        });

                                        $(_app_.$el).find('textarea').get(0).emojioneArea.on('keyup', function (event) {
                                            _app_.text = $(_app_.$el).find('textarea').get(0).emojioneArea.getText();
                                        });
                                    }
                                });
                                window.CLNewSwift = CLNewSwift;

                            });
                        </script>
                    </div>
                </div>

                <div data-el="spa-preloader" class="spa-preloader d-none">
                    <div class="spa-preloader-inner">
                            <span class="spinner-icon">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 40 40"
                                     enable-background="new 0 0 40 40" xml:space="preserve">
                                    <path opacity="0.6" fill="#8EC741"
                                          d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946 s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634 c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"></path>
                                    <path fill="#8EC741"
                                          d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0 C22.32,8.481,24.301,9.057,26.013,10.047z"
                                          transform="rotate(299.57 20 20)">
                                        <animateTransform attributeType="xml" attributeName="transform" type="rotate"
                                                          from="0 20 20" to="360 20 20" dur="0.7s"
                                                          repeatCount="indefinite"></animateTransform>
                                    </path>
                                </svg>
                            </span>
                    </div>
                </div>
            </div>

            <div class="right-sb-container sidebar" id="right-sb-container" data-app="right-sidebar">
                <div class="sidebar__inner">
                    <div class="main-search-bar-container">
                        <form class="form" id="vue-main-search-app" v-on:submit="search_onsubmit" autocomplete="off">
                            <div class="input-holder">
                                <input v-model="search_query" v-on:input="search" type="text" class="form-control"
                                       placeholder="Search for people, hashtags..">
                                <a href="#">
                                    <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         aria-labelledby="searchIconTitle" stroke-width="1.8" stroke-linecap="square"
                                         stroke-linejoin="miter" fill="none">
                                        <path d="M14.4121122,14.4121122 L20,20"/>
                                        <circle cx="10" cy="10" r="6"/>
                                    </svg>
                                </a>
                                <span class="spinner-icon" v-if="searching">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
                                            <path opacity="0.6" fill="#8EC741"
                                                  d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946 s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634 c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"></path>
                                            <path fill="#8EC741"
                                                  d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0 C22.32,8.481,24.301,9.057,26.013,10.047z"
                                                  transform="rotate(299.57 20 20)">
                                                <animateTransform attributeType="xml" attributeName="transform"
                                                                  type="rotate" from="0 20 20" to="360 20 20" dur="0.7s"
                                                                  repeatCount="indefinite"></animateTransform>
                                            </path>
                                        </svg>
                                    </span>
                                <span v-on:click="cancel" class="clear-result" v-else-if="search_result">
                                        <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                             aria-labelledby="closeIconTitle" stroke-width="1.8" stroke-linecap="square"
                                             stroke-linejoin="miter" fill="none">
                                            <path d="M6.34314575 6.34314575L17.6568542 17.6568542M6.34314575 17.6568542L17.6568542 6.34314575"/>
                                        </svg> </span>
                            </div>
                            <div class="search-result-holder" v-show="search_result">
                                <div class="search-result-body">
                                    <ul class="result-list" data-an="result"></ul>
                                </div>
                                <div class="search-result-footer"
                                     v-bind:class="{'disabled': (advanced_search != true) }">
                                    <a v-bind:href="search_page_url" data-spa="true">
                                        Advanced search </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="announcement-holder" data-an="announcement"></div>
                    <div class="topical-posts-container">
                        <ul class="list-group">
                            <li class="list-group-item main">
                                <h4>Goals Overview</h4>
                            </li>
                            <li style=" height: 300px !important;" class="list-group-item items-placeholder">
                                {{--                                <div class="icon">--}}
                                {{--                                    <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"--}}
                                {{--                                         aria-labelledby="hashIconTitle" stroke-width="1.8" stroke-linecap="square"--}}
                                {{--                                         stroke-linejoin="miter" fill="none">--}}
                                {{--                                        <path d="M11 3L5 21M19 3L13 21M3 16L19 16M5 8L21 8"/>--}}
                                {{--                                    </svg>--}}
                                {{--                                </div>--}}
                                {{--                                <h5>--}}
                                {{--                                    Here will be a (#hashtag) list of the most relevant topics and events </h5>--}}

                                <div class="card-content">
                                    <div class="card-body px-0 pb-0">
                                        <div id="goal-overview-chart" class="mt-75"></div>
                                        <div class="row text-center mx-0">
                                            <div class="col-6 border-top border-right d-flex align-items-between flex-column py-1">
                                                <p class="mb-50">Target {{$goals["type"]}}</p>
                                                <p class="font-large-1 text-bold-700">{{$goals["target"]}}</p>
                                            </div>
                                            <div class="col-6 border-top d-flex align-items-between flex-column py-1">
                                                <p class="mb-50">Current {{$goals["type"]}}</p>
                                                <p class="font-large-1 text-bold-700">{{$goals["current"]}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="follow-suggestion-container">
                        <ul class="list-group">
                            <li class="list-group-item main">
                                <h4>
                                    Who to follow </h4>
                            </li>
                            <li class="list-group-item items-placeholder">
                                <div class="icon">
                                    <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         aria-labelledby="peopleIconTitle" stroke-width="1.8" stroke-linecap="square"
                                         stroke-linejoin="miter" fill="none">
                                        <path d="M1 18C1 15.75 4 15.75 5.5 14.25 6.25 13.5 4 13.5 4 9.75 4 7.25025 4.99975 6 7 6 9.00025 6 10 7.25025 10 9.75 10 13.5 7.75 13.5 8.5 14.25 10 15.75 13 15.75 13 18M12.7918114 15.7266684C13.2840551 15.548266 13.6874862 15.3832994 14.0021045 15.2317685 14.552776 14.9665463 15.0840574 14.6659426 15.5 14.25 16.25 13.5 14 13.5 14 9.75 14 7.25025 14.99975 6 17 6 19.00025 6 20 7.25025 20 9.75 20 13.5 17.75 13.5 18.5 14.25 20 15.75 23 15.75 23 18"/>
                                        <path stroke-linecap="round"
                                              d="M12,16 C12.3662741,15.8763472 12.6302112,15.7852366 12.7918114,15.7266684"/>
                                    </svg>
                                </div>
                                <h5>
                                    Here will be a list of the most recommended people to follow </h5>
                            </li>
                        </ul>
                    </div>
                    <div class="main-footer">
                        <ul class="footer-nav">
                            <li class="footer-nav-item">
                                <a href="https://trysoftcolib.com//search">
                                    Explore </a>
                            </li>
                            <li class="footer-nav-item">
                                <a href="https://trysoftcolib.com//ads">
                                    Advertising </a>
                            </li>
                            <li class="footer-nav-item">
                                <a href="https://trysoftcolib.com//terms_of_use" data-spa="true">
                                    Terms of Use </a>
                            </li>
                            <li class="footer-nav-item">
                                <a href="https://trysoftcolib.com//privacy_policy" data-spa="true">
                                    Privacy policy </a>
                            </li>
                            <li class="footer-nav-item">
                                <a href="https://trysoftcolib.com//cookies_policy" data-spa="true">
                                    Cookies </a>
                            </li>
                            <li class="footer-nav-item">
                                <a href="https://trysoftcolib.com//about_us" data-spa="true">
                                    About us </a>
                            </li>
                            <li class="footer-nav-item">
                                <a href="https://trysoftcolib.com//api_docs">
                                    API
                                </a>
                            </li>
                            <li class="footer-nav-item">
                                <a href="https://trysoftcolib.com//faqs" data-spa="true">F.A.Q</a>
                            </li>
                            <li class="footer-nav-item dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    Language </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="https://trysoftcolib.com//language/english">
                                        English </a>
                                    <a class="dropdown-item" href="https://trysoftcolib.com//language/french">
                                        French </a>
                                    <a class="dropdown-item" href="https://trysoftcolib.com//language/german">
                                        German </a>
                                    <a class="dropdown-item" href="https://trysoftcolib.com//language/italian">
                                        Italian </a>
                                    <a class="dropdown-item" href="https://trysoftcolib.com//language/russian">
                                        Russian </a>
                                    <a class="dropdown-item" href="https://trysoftcolib.com//language/portuguese">
                                        Portuguese </a>
                                    <a class="dropdown-item" href="https://trysoftcolib.com//language/spanish">
                                        Spanish </a>
                                    <a class="dropdown-item" href="https://trysoftcolib.com//language/turkish">
                                        Turkish </a>
                                    <a class="dropdown-item" href="https://trysoftcolib.com//language/dutch">
                                        Dutch </a>
                                    <a class="dropdown-item" href="https://trysoftcolib.com//language/ukraine">
                                        Ukraine </a>
                                </div>
                            </li>
                            <li class="footer-nav-item">
                                <a href="#">&copy; Pulse Wellness, Inc., 2021.</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="mobile-bottom-navbar" data-app="mobile-navbar">
        <div class="mobile-bottom-navbar-inner">
            <button class="navbar-ctrl" data-an="show-lsb">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-labelledby="appsAltIconTitle"
                     stroke-width="1.8" stroke-linecap="square" stroke-linejoin="miter" fill="none">
                    <rect x="5" y="5" width="2" height="2"/>
                    <rect x="11" y="5" width="2" height="2"/>
                    <rect x="17" y="5" width="2" height="2"/>
                    <rect x="5" y="11" width="2" height="2"/>
                    <rect x="11" y="11" width="2" height="2"/>
                    <rect x="17" y="11" width="2" height="2"/>
                    <rect x="5" y="17" width="2" height="2"/>
                    <rect x="11" y="17" width="2" height="2"/>
                    <rect x="17" y="17" width="2" height="2"/>
                </svg>
            </button>
            <button class="navbar-ctrl" data-anchor="https://trysoftcolib.com//notifications">
                <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-labelledby="bellIconTitle"
                     stroke-width="1.8" stroke-linecap="square" stroke-linejoin="miter" fill="none">
                    <path stroke-linejoin="round"
                          d="M10.5,4.5 C12.1666667,4.5 13.8333333,4.5 15.5,4.5 C17.5,4.5 18.8333333,3.83333333 19.5,2.5 L19.5,18.5 C18.8333333,17.1666667 17.5,16.5 15.5,16.5 C13.8333333,16.5 12.1666667,16.5 10.5,16.5 L10.5,16.5 C7.1862915,16.5 4.5,13.8137085 4.5,10.5 L4.5,10.5 C4.5,7.1862915 7.1862915,4.5 10.5,4.5 Z"
                          transform="rotate(90 12 10.5)"/>
                    <path d="M11,21 C12.1045695,21 13,20.1045695 13,19 C13,17.8954305 12.1045695,17 11,17"
                          transform="rotate(90 12 19)"/>
                </svg>
                <span class="info-indicators" data-an="new-notifs"></span>
            </button>
            <button class="navbar-ctrl" data-toggle="modal" data-target="#add_new_post">
                <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-labelledby="addIconTitle"
                     stroke-width="1.8" stroke-linecap="square" stroke-linejoin="miter" fill="none">
                    <path d="M17 12L7 12M12 17L12 7"/>
                    <circle cx="12" cy="12" r="10"/>
                </svg>
            </button>
            <button class="navbar-ctrl" data-anchor="https://trysoftcolib.com//chats">
                <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                     aria-labelledby="chatAltIconTitle" stroke-width="1.8" stroke-linecap="square"
                     stroke-linejoin="miter" fill="none">
                    <path d="M13,17 L7,21 L7,17 L3,17 L3,4 L21,4 L21,17 L13,17 Z"/>
                </svg>
                <span class="info-indicators" data-an="new-messages"></span>
            </button>
            <button class="navbar-ctrl" data-anchor="https://trysoftcolib.com//search">
                <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                     aria-labelledby="exploreIconTitle" stroke-width="1.8" stroke-linecap="square"
                     stroke-linejoin="miter" fill="none">
                    <polygon points="14.121 14.121 7.05 16.95 9.879 9.879 16.95 7.05"/>
                    <circle cx="12" cy="12" r="10"/>
                </svg>
            </button>
        </div>
    </div>

    <script>
        $(document).ready(function ($) {
            var _app = $('[data-app="mobile-navbar"]');

            _app.find('[data-an="show-lsb"]').on('click', function (event) {
                event.preventDefault();

                $('div[data-app="left-sidebar"]').addClass('show').promise().done(function () {
                    var attrs = Object({});
                    attrs['class'] = 'sb-open-overlay';
                    attrs['data-app'] = 'lsb-back-drop';

                    $('body').addClass('ov-h').append($('<div>', attrs));
                });
            });

            $(document).on('click', 'div[data-app="lsb-back-drop"]', function (event) {
                event.preventDefault();
                var _self = $(this);

                $('div[data-app="left-sidebar"]').removeClass('show').promise().done(function () {
                    _self.remove();
                    $('body').removeClass('ov-h');
                });
            });
        });
    </script>
    <input id="csrf-token" type="hidden" class="hidden d-none"
           value="1621282486:d05785002742a30502dde3731b28883334e46040">

    <div class="modal fadeIn vh-center modal-pubbox" data-app="modal-pubbox" id="add_new_post" tabindex="-1"
         role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="main---mh--block">
                        <h5 class="modal-title">New post</h5>
                        <span class="dismiss-modal" data-dismiss="modal">
                                <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     aria-labelledby="closeIconTitle" stroke-width="1.8" stroke-linecap="square"
                                     stroke-linejoin="miter" fill="none">
                                    <path d="M6.34314575 6.34314575L17.6568542 17.6568542M6.34314575 17.6568542L17.6568542 6.34314575"/>
                                </svg> </span>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="timeline-pubbox-container">
                        <div class="lp">
                            <div class="avatar">
                                @if(is_null($userdata->image) | $userdata->image == "")

                                    <img src=""
                                         alt="PH">
                                @else
                                    <img src="{{$userdata->image}}"
                                         alt="PH">
                                @endif
                            </div>
                        </div>
                        <div class="rp">
                            <form class="form" id="vue-pubbox-app-2" v-on:submit="publish($event)">
                                <div class="input-holder">
                                    <textarea v-on:input="textarea_resize($event)" class="autoresize" name="post_text"
                                              placeholder="What is happening? "></textarea>
                                </div>
                                <div v-if="show_og_data" class="preview-og-holder">
                                    <div class="preview-og-holder-inner">
                                        <div class="og-image">
                                            <div v-if="og_data.image" class="og-image-holder"
                                                 v-bind:style="{'background-image': 'url(' + og_data.image + ')'}"></div>
                                            <div v-else class="og-icon-holder">
                                                <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                     aria-labelledby="languageIconTitle" stroke-width="1.8"
                                                     stroke-linecap="square" stroke-linejoin="miter" fill="none">
                                                    <circle cx="12" cy="12" r="10"/>
                                                    <path stroke-linecap="round"
                                                          d="M12,22 C14.6666667,19.5757576 16,16.2424242 16,12 C16,7.75757576 14.6666667,4.42424242 12,2 C9.33333333,4.42424242 8,7.75757576 8,12 C8,16.2424242 9.33333333,19.5757576 12,22 Z"/>
                                                    <path stroke-linecap="round" d="M2.5 9L21.5 9M2.5 15L21.5 15"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="og-url-data">
                                            <h5>

                                            </h5>
                                            <p>

                                            </p>
                                            <a v-bind:href="og_data.url" target="_blank">

                                            </a>
                                        </div>
                                    </div>
                                    <button type="button" class="delete-preview-og" v-on:click="rm_preview_og">
                                        <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                             aria-labelledby="closeIconTitle" stroke-width="1.8" stroke-linecap="square"
                                             stroke-linejoin="miter" fill="none">
                                            <path d="M6.34314575 6.34314575L17.6568542 17.6568542M6.34314575 17.6568542L17.6568542 6.34314575"/>
                                        </svg>
                                    </button>
                                </div>
                                <div v-if="active_media == 'image'" class="preview-images-holder">
                                    <div class="preview-images-list" data-an="post-images">
                                        <div v-for="img in images" class="preview-images-list-item"
                                             v-bind:style="{height: equal_height}">
                                            <div class="li-inner-content">
                                                <img v-bind:src="img.url" alt="Image">
                                                <button type="button" class="delete-preview-image"
                                                        v-on:click="delete_image(img.id)">
                                                    <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 24 24" aria-labelledby="closeIconTitle"
                                                         stroke-width="1.8" stroke-linecap="square"
                                                         stroke-linejoin="miter" fill="none">
                                                        <path d="M6.34314575 6.34314575L17.6568542 17.6568542M6.34314575 17.6568542L17.6568542 6.34314575"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="active_media == 'video'" class="preview-video-holder">
                                    <div class="video-player" id="preview-video">
                                        <video v-bind:poster="video.poster" data-el="colibrism-video" width="550"
                                               height="300" controls="true" type="video/mp4">
                                            <source type="video/mp4" v-bind:src="video.source"/>
                                        </video>
                                    </div>
                                    <button type="button" class="delete-preview-video" v-on:click="delete_video">
                                        <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                             aria-labelledby="closeIconTitle" stroke-width="1.8" stroke-linecap="square"
                                             stroke-linejoin="miter" fill="none">
                                            <path d="M6.34314575 6.34314575L17.6568542 17.6568542M6.34314575 17.6568542L17.6568542 6.34314575"/>
                                        </svg>
                                    </button>
                                </div>
                                <div v-if="active_media == 'poll'" class="preview-poll-holder">
                                    <div class="poll-data-title">
                                        <div class="d-flex align-items-center flex-wn justify-content-between">
                                            <div class="flex-item">
                                                <h5>Create a new poll</h5>
                                            </div>
                                            <div class="flex-item">
                                                <button v-on:click="cancel_poll" type="button" class="cancel-poll"
                                                        title="Cancel poll">
                                                    <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 24 24" aria-labelledby="closeIconTitle"
                                                         stroke-width="1.8" stroke-linecap="square"
                                                         stroke-linejoin="miter" fill="none">
                                                        <path d="M6.34314575 6.34314575L17.6568542 17.6568542M6.34314575 17.6568542L17.6568542 6.34314575"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="poll-data-inputs">
                                        <div class="data-input-item" v-for="(v, k) in poll">
                                            <input v-model.trim="v.value" type="text"
                                                   v-bind:placeholder="v.title + (k += 1)" maxlength="25">
                                            <small></small>
                                        </div>
                                    </div>
                                    <div class="poll-data-ctrls">
                                        <button v-bind:disabled="poll.length >= 4" type="button"
                                                class="btn btn-custom main-outline md" v-on:click="poll_option">
                                            Add option
                                        </button>
                                    </div>
                                </div>
                                <div v-if="active_media == 'gifs'" class="preview-gifs-holder">
                                    <div class="preview-original-gif loading" v-if="gif_source">
                                        <img v-bind:src="gif_source" alt="GIF-Image"
                                             v-on:load="rm_gif_preloader($event)">
                                        <div class="gif-preloader">
                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 40 40" enable-background="new 0 0 40 40"
                                                 xml:space="preserve">
                                                    <path opacity="0.6" fill="#8EC741"
                                                          d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946 s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634 c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"></path>
                                                <path fill="#8EC741"
                                                      d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0 C22.32,8.481,24.301,9.057,26.013,10.047z"
                                                      transform="rotate(299.57 20 20)">
                                                    <animateTransform attributeType="xml" attributeName="transform"
                                                                      type="rotate" from="0 20 20" to="360 20 20"
                                                                      dur="0.7s"
                                                                      repeatCount="indefinite"></animateTransform>
                                                </path>
                                                </svg>
                                        </div>
                                        <button type="button" class="delete-preview-gif" v-on:click="rm_preview_gif">
                                            <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                 aria-labelledby="closeIconTitle" stroke-width="1.8"
                                                 stroke-linecap="square" stroke-linejoin="miter" fill="none">
                                                <path d="M6.34314575 6.34314575L17.6568542 17.6568542M6.34314575 17.6568542L17.6568542 6.34314575"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="preview-gifs-loader" v-else-if="gifs">
                                        <div class="search-bar-holder">
                                            <input v-on:input="search_gifs($event)" type="text" class="form-control"
                                                   placeholder="Search GIF-files">
                                            <a href="#">
                                                <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                     aria-labelledby="searchIconTitle" stroke-width="1.8"
                                                     stroke-linecap="square" stroke-linejoin="miter" fill="none">
                                                    <path d="M14.4121122,14.4121122 L20,20"/>
                                                    <circle cx="10" cy="10" r="6"/>
                                                </svg>
                                            </a>
                                            <button type="button" v-on:click="close_gifs">
                                                <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                     aria-labelledby="closeIconTitle" stroke-width="1.8"
                                                     stroke-linecap="square" stroke-linejoin="miter" fill="none">
                                                    <path d="M6.34314575 6.34314575L17.6568542 17.6568542M6.34314575 17.6568542L17.6568542 6.34314575"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="preview-gifs-list" data-an="post-gifs">
                                            <div class="row-column row-1">
                                                <div v-for="gif_data in gifs_r1" class="preview-gifs-list-item">
                                                    <div class="li-inner-content loading">
                                                        <img v-on:click="preview_gif($event)"
                                                             v-bind:src="gif_data.thumb"
                                                             v-bind:data-source="gif_data.src" alt="GIF-Image"
                                                             v-on:load="rm_gif_preloader($event)">
                                                        <div class="gif-preloader">
                                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                                                 y="0px" viewBox="0 0 40 40"
                                                                 enable-background="new 0 0 40 40" xml:space="preserve">
                                                                    <path opacity="0.6" fill="#8EC741"
                                                                          d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946 s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634 c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"></path>
                                                                <path fill="#8EC741"
                                                                      d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0 C22.32,8.481,24.301,9.057,26.013,10.047z"
                                                                      transform="rotate(299.57 20 20)">
                                                                    <animateTransform attributeType="xml"
                                                                                      attributeName="transform"
                                                                                      type="rotate" from="0 20 20"
                                                                                      to="360 20 20" dur="0.7s"
                                                                                      repeatCount="indefinite"></animateTransform>
                                                                </path>
                                                                </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-column row-2">
                                                <div v-for="gif_data in gifs_r2" class="preview-gifs-list-item">
                                                    <div class="li-inner-content loading">
                                                        <img v-on:click="preview_gif($event)"
                                                             v-bind:src="gif_data.thumb"
                                                             v-bind:data-source="gif_data.src" alt="GIF-Image"
                                                             v-on:load="rm_gif_preloader($event)">
                                                        <div class="gif-preloader">
                                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                                                 y="0px" viewBox="0 0 40 40"
                                                                 enable-background="new 0 0 40 40" xml:space="preserve">
                                                                    <path opacity="0.6" fill="#8EC741"
                                                                          d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946 s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634 c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"></path>
                                                                <path fill="#8EC741"
                                                                      d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0 C22.32,8.481,24.301,9.057,26.013,10.047z"
                                                                      transform="rotate(299.57 20 20)">
                                                                    <animateTransform attributeType="xml"
                                                                                      attributeName="transform"
                                                                                      type="rotate" from="0 20 20"
                                                                                      to="360 20 20" dur="0.7s"
                                                                                      repeatCount="indefinite"></animateTransform>
                                                                </path>
                                                                </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="post-ctrls-holder">
                                    <button type="button" class="ctrl-item" v-on:click="select_images"
                                            v-bind:disabled="image_ctrl != true">
                                        <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                             aria-labelledby="imageIconTitle" stroke-width="1.8" stroke-linecap="square"
                                             stroke-linejoin="miter" fill="none">
                                            <rect width="18" height="18" x="3" y="3"/>
                                            <path stroke-linecap="round" d="M3 14l4-4 11 11"/>
                                            <circle cx="13.5" cy="7.5" r="2.5"/>
                                            <path stroke-linecap="round" d="M13.5 16.5L21 9"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="ctrl-item" v-on:click="select_video"
                                            v-bind:disabled="video_ctrl != true">
                                        <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                             aria-labelledby="filmIconTitle" stroke-width="1.8" stroke-linecap="square"
                                             stroke-linejoin="miter" fill="none">
                                            <path stroke-linecap="round" d="M16 10.087l5-1.578v7.997l-4.998-1.578"/>
                                            <path d="M16 7H3v11h13z"/>
                                        </svg>
                                    </button>
                                    <button v-on:click="emoji_picker('toggle')" type="button" class="ctrl-item">
                                        <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                             aria-labelledby="happyFaceIconTitle" stroke-width="1.8"
                                             stroke-linecap="square" stroke-linejoin="miter" fill="none">
                                            <path d="M7.3010863,14.0011479 C8.0734404,15.7578367 9.98813711,17 11.9995889,17 C14.0024928,17 15.913479,15.7546194 16.6925307,14.0055328"/>
                                            <line stroke-linecap="round" x1="9" y1="9" x2="9" y2="9"/>
                                            <line stroke-linecap="round" x1="15" y1="9" x2="15" y2="9"/>
                                            <circle cx="12" cy="12" r="10"/>
                                        </svg>
                                    </button>

                                    <button type="button" class="ctrl-item text-length ml-auto">
                                        <small v-show="text.length"
                                               v-bind:class="{'len-error': (text.length > settings.max_length) }">

                                        </small>
                                    </button>
                                </div>
                                <div class="post-privacy-holder">
                                    <div class="d-flex align-items-center flex-wn">
                                        <div class="flex-item" v-if="post_privacy">
                                            <button class="privacy-settings dropdown" type="button">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                        <span class="d-inline-flex align-items-center flex-wn">
                                                            <span class="flex-item icon"
                                                                  v-if="post_privacy == 'everyone'">
                                                                <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                                     viewBox="0 0 24 24"
                                                                     aria-labelledby="languageIconTitle"
                                                                     stroke-width="1.8" stroke-linecap="square"
                                                                     stroke-linejoin="miter" fill="none">
                                                                    <circle cx="12" cy="12" r="10"/>
                                                                    <path stroke-linecap="round"
                                                                          d="M12,22 C14.6666667,19.5757576 16,16.2424242 16,12 C16,7.75757576 14.6666667,4.42424242 12,2 C9.33333333,4.42424242 8,7.75757576 8,12 C8,16.2424242 9.33333333,19.5757576 12,22 Z"/>
                                                                    <path stroke-linecap="round"
                                                                          d="M2.5 9L21.5 9M2.5 15L21.5 15"/>
                                                                </svg> </span>

                                                            <span class="flex-item icon" v-else>
                                                                <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                                     viewBox="0 0 24 24"
                                                                     aria-labelledby="peopleIconTitle"
                                                                     stroke-width="1.8" stroke-linecap="square"
                                                                     stroke-linejoin="miter" fill="none">
                                                                    <path d="M1 18C1 15.75 4 15.75 5.5 14.25 6.25 13.5 4 13.5 4 9.75 4 7.25025 4.99975 6 7 6 9.00025 6 10 7.25025 10 9.75 10 13.5 7.75 13.5 8.5 14.25 10 15.75 13 15.75 13 18M12.7918114 15.7266684C13.2840551 15.548266 13.6874862 15.3832994 14.0021045 15.2317685 14.552776 14.9665463 15.0840574 14.6659426 15.5 14.25 16.25 13.5 14 13.5 14 9.75 14 7.25025 14.99975 6 17 6 19.00025 6 20 7.25025 20 9.75 20 13.5 17.75 13.5 18.5 14.25 20 15.75 23 15.75 23 18"/>
                                                                    <path stroke-linecap="round"
                                                                          d="M12,16 C12.3662741,15.8763472 12.6302112,15.7852366 12.7918114,15.7266684"/>
                                                                </svg> </span>
                                                            <span class="flex-item flex-grow-1 label">

                                                            </span>
                                                        </span>
                                                    <span class="flex-item flex-grow-1 label">
									</span>
                                                </a>
                                                <div class="dropdown-menu dropdown-icons">
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                       v-on:click="post_privacy = 'everyone'">
                                                            <span class="flex-item dropdown-item-icon">
                                                                <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                                     viewBox="0 0 24 24"
                                                                     aria-labelledby="languageIconTitle"
                                                                     stroke-width="1.8" stroke-linecap="square"
                                                                     stroke-linejoin="miter" fill="none">
                                                                    <circle cx="12" cy="12" r="10"/>
                                                                    <path stroke-linecap="round"
                                                                          d="M12,22 C14.6666667,19.5757576 16,16.2424242 16,12 C16,7.75757576 14.6666667,4.42424242 12,2 C9.33333333,4.42424242 8,7.75757576 8,12 C8,16.2424242 9.33333333,19.5757576 12,22 Z"/>
                                                                    <path stroke-linecap="round"
                                                                          d="M2.5 9L21.5 9M2.5 15L21.5 15"/>
                                                                </svg> </span>
                                                        <span class="flex-item ">
                                                                Everyone </span>
                                                    </a>

                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                       v-on:click="post_privacy = 'followers'">
                                                            <span class="flex-item dropdown-item-icon">
                                                                <svg role="img" xmlns="http://www.w3.org/2000/svg"
                                                                     viewBox="0 0 24 24"
                                                                     aria-labelledby="peopleIconTitle"
                                                                     stroke-width="1.8" stroke-linecap="square"
                                                                     stroke-linejoin="miter" fill="none">
                                                                    <path d="M1 18C1 15.75 4 15.75 5.5 14.25 6.25 13.5 4 13.5 4 9.75 4 7.25025 4.99975 6 7 6 9.00025 6 10 7.25025 10 9.75 10 13.5 7.75 13.5 8.5 14.25 10 15.75 13 15.75 13 18M12.7918114 15.7266684C13.2840551 15.548266 13.6874862 15.3832994 14.0021045 15.2317685 14.552776 14.9665463 15.0840574 14.6659426 15.5 14.25 16.25 13.5 14 13.5 14 9.75 14 7.25025 14.99975 6 17 6 19.00025 6 20 7.25025 20 9.75 20 13.5 17.75 13.5 18.5 14.25 20 15.75 23 15.75 23 18"/>
                                                                    <path stroke-linecap="round"
                                                                          d="M12,16 C12.3662741,15.8763472 12.6302112,15.7852366 12.7918114,15.7266684"/>
                                                                </svg> </span>
                                                        <span class="flex-item ">
                                                                Only my followers </span>
                                                    </a>
                                                </div>
                                            </button>
                                        </div>
                                        <div class="flex-item ml-auto">
                                            <button v-bind:disabled="valid_form != true" type="submit"
                                                    class="btn-custom main-inline md post-pub-btn">
                                                Publish
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <input multiple="multiple" type="file" class="d-none" data-an="images-input"
                                       accept="image/*" v-on:change="upload_images($event)">
                                <input type="file" class="d-none" data-an="video-input" accept="video/*"
                                       v-on:change="upload_video($event)">
                                <input type="hidden" class="d-none"
                                       value="1621282486:d05785002742a30502dde3731b28883334e46040" name="hash">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ env('APP_URL') }}client/js/apexcharts.min.js"></script>
    <script>
        ///Trynos

        // Goal Overview  Chart
        // -----------------------------
        var $success = '#8EC741';
        var $strok_color = '#b9c3cd';
        var goalChartoptions = {
            chart: {
                height: 250,
                type: 'radialBar',
                sparkline: {
                    enabled: true,
                },
                dropShadow: {
                    enabled: true,
                    blur: 3,
                    left: 1,
                    top: 1,
                    opacity: 0.1
                },
            },
            colors: [$success],
            plotOptions: {
                radialBar: {
                    size: 110,
                    startAngle: -150,
                    endAngle: 150,
                    hollow: {
                        size: '77%',
                    },
                    track: {
                        background: $strok_color,
                        strokeWidth: '50%',
                    },
                    dataLabels: {
                        name: {
                            show: false
                        },
                        value: {
                            offsetY: 18,
                            color: '#99a2ac',
                            fontSize: '4rem'
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'horizontal',
                    shadeIntensity: 0.5,
                    gradientToColors: ['#b2e73c'],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100]
                },
            },
            series: [{!! $goals["percentage"] !!}],
            stroke: {
                lineCap: 'round'
            },

        }

        var goalChart = new ApexCharts(
            document.querySelector("#goal-overview-chart"),
            goalChartoptions
        );

        goalChart.render();
    </script>
    <script>
        "use strict";

        $(document).ready(function ($) {


            /* @*************************************************************************@// @ @author Mansur Altamirov (Mansur_TL) @// @ @author_url 1: https://www.instagram.com/mansur_tl@// @ @author_url 2: http://codecanyon.net/user/mansur_tl@// @ @author_email: highexpresstore@gmail.com@// @*************************************************************************@// @ ColibriSM - The Ultimate Modern Social Media Sharing Platform@// @ Copyright (c) 21.03.2020 ColibriSM. All rights reserved.@// @*************************************************************************@*/
            var pubbox_form_app_mixin = Object({
                data: function () {
                    return {
                        text: "",
                        images: [],
                        video: {},
                        poll: [],
                        gifs_r1: [],
                        gifs_r2: [],
                        image_ctrl: true,
                        video_ctrl: true,
                        poll_ctrl: true,
                        gif_ctrl: true,
                        submitting: false,
                        active_media: null,
                        gif_source: null,
                        post_privacy: "everyone",
                        og_imported: false,
                        og_data: {},
                        og_hidden: [],
                        settings: {
                            max_length: "600"
                        },
                        sdds: {
                            privacy: {
                                everyone: "Everyone can reply",
                                mentioned: "Only mentioned people",
                                followers: "Only my followers",
                            }
                        },
                        data_temp: {
                            poll: {
                                title: "Option - ",
                                value: ""
                            }
                        }
                    };
                },
                computed: {
                    valid_form: function () {
                        var _app_ = this;
                        if (_app_.active_media == 'image') {
                            if (_app_.images.length >= 1 && cl_empty(_app_.submitting)) {
                                return true;
                            } else {
                                return false;
                            }
                        } else if (_app_.active_media == 'gifs') {
                            if (cl_empty(_app_.gif_source) != true && cl_empty(_app_.submitting)) {
                                return true;
                            } else {
                                return false;
                            }
                        } else if (_app_.active_media == 'video') {
                            if ($.isEmptyObject(_app_.video) != true && cl_empty(_app_.submitting)) {
                                return true;
                            } else {
                                return false;
                            }
                        } else if (_app_.active_media == 'poll') {
                            if (_app_.text.length > 0 && _app_.valid_poll && cl_empty(_app_.submitting)) {
                                return true;
                            } else {
                                return false;
                            }
                        } else if ((_app_.active_media == null && _app_.text.length > 0) || _app_.og_imported) {
                            return true;
                        } else {
                            return false;
                        }
                    },
                    equal_height: function () {
                        var app_el = $(this.$el);
                        return "{0}px".format((app_el.innerWidth() / 4));
                    },
                    preview_video: function () {
                        if ($.isEmptyObject(this.video)) {
                            return false;
                        }
                        return true;
                    },
                    gifs: function () {
                        if (this.gifs_r1.length || this.gifs_r2.length) {
                            return true;
                        }
                        return false;
                    },
                    show_og_data: function () {
                        if (this.og_imported == true && this.active_media == null && this.og_hidden.contains(this.og_data.url) != true) {
                            return true;
                        } else {
                            return false;
                        }
                    },
                    valid_poll: function () {
                        var _app_ = this;
                        if (cl_empty(_app_.poll.length)) {
                            return false;
                        } else {
                            for (var i = 0; i < _app_.poll.length; i++) {
                                if (cl_empty(_app_.poll[i].value)) {
                                    return false;
                                }
                            }
                            return true;
                        }
                    }
                },
                methods: {
                    emoji_picker: function (action = "toggle") {
                        var app_el = $(this.$el);
                        var _app_ = this;
                        if (app_el.length) {
                            if (action == "toggle") {
                                if (app_el.find('textarea').get(0).emojioneArea.isOpened()) {
                                    app_el.find('textarea').get(0).emojioneArea.hidePicker();
                                } else {
                                    app_el.find('textarea').get(0).emojioneArea.showPicker();
                                    _app_.rep_emoji_picker();
                                }
                            } else if (action == "open") {
                                if (app_el.find('textarea').get(0).emojioneArea.isOpened() != true) {
                                    app_el.find('textarea').get(0).emojioneArea.showPicker();
                                    _app_.rep_emoji_picker();
                                }
                            } else if (action == "close") {
                                if (app_el.find('textarea').get(0).emojioneArea.isOpened()) {
                                    app_el.find('textarea').get(0).emojioneArea.hidePicker();
                                }
                            }
                        }
                    },
                    rep_emoji_picker: function () {
                        var app_el = $(this.$el);
                        app_el.find('div.emojionearea-picker').css("top", "{0}px".format(app_el.height() - 40));
                    },
                    textarea_resize: function (_self = null) {
                        autosize($(_self.target));
                    },
                    publish: function (_self = null) {
                        _self.preventDefault();
                        var form = $(_self.$el);
                        var _app_ = this;
                        var main_left_sb = $('div[data-app="left-sidebar"]');
                        $(_self.target).ajaxSubmit({
                            url: "https://trysoftcolib.com//native_api/main/publish_new_post",
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                gif_src: _app_.gif_source,
                                thread_id: ((_app_.thread_id) ? _app_.thread_id : 0),
                                curr_pn: SMColibri.curr_pn,
                                og_data: _app_.og_data,
                                privacy: _app_.post_privacy,
                                poll_data: _app_.poll
                            },
                            beforeSend: function () {
                                _app_.submitting = true;
                            },
                            success: function (data) {
                                if (data.status == 200) {
                                    if (SMColibri.curr_pn == "home") {
                                        var home_timeline = $('div[data-app="homepage"]');
                                        var new_post = $(data.html).addClass('animated fadeIn');
                                        if (home_timeline.find('div[data-an="entry-list"]').length) {
                                            home_timeline.find('div[data-an="entry-list"]').prepend(new_post).promise().done(function () {
                                                setTimeout(function () {
                                                    home_timeline.find('div[data-an="entry-list"]').find('[data-list-item]').first().removeClass('animated fadeIn');
                                                }, 1000);
                                            });
                                        } else {
                                            SMColibri.spa_reload();
                                        }
                                    } else if (SMColibri.curr_pn == "thread" && _app_.thread_id) {
                                        _app_.thread_id = 0;
                                        var thread_timeline = $('div[data-app="thread"]');
                                        var new_post = $(data.html).addClass('animated fadeIn');
                                        if (thread_timeline.find('div[data-an="replys-list"]').length) {
                                            thread_timeline.find('div[data-an="replys-list"]').prepend(new_post).promise().done(function () {
                                                setTimeout(function () {
                                                    thread_timeline.find('div[data-an="replys-list"]').find('[data-list-item]').first().removeClass('animated fadeIn');
                                                }, 1000);
                                            });
                                        } else {
                                            SMColibri.spa_reload();
                                        }
                                        thread_timeline.find('[data-an="pub-replys-total"]').text(data.replys_total);
                                    } else {
                                        cl_bs_notify("Your new publication has been posted on your timeline", 1200);
                                    }
                                    if ($(_app_.$el).attr('id') == 'vue-pubbox-app-2') {
                                        $(_app_.$el).parents("div#add_new_post").modal('hide');
                                    }
                                    if (data.posts_total) {
                                        main_left_sb.find('b[data-an="total-posts"]').text(data.posts_total);
                                    }
                                } else {
                                    _app_.submitting = false;
                                    SMColibri.errorMSG();
                                }
                            },
                            complete: function () {
                                _app_.submitting = false;
                                _app_.reset_data();
                            }
                        });
                    },
                    create_poll: function () {
                        var _app_ = this;
                        if (cl_empty(_app_.active_media)) {
                            if (_app_.poll_ctrl) {
                                _app_.active_media = "poll";
                                _app_.poll_option();
                                _app_.poll_option();
                                _app_.disable_ctrls();
                            }
                        }
                    },
                    poll_option: function () {
                        var _app_ = this;
                        if (_app_.poll.length < 4) {
                            var poll_option_data = Object({
                                title: _app_.data_temp.poll.title,
                                value: _app_.data_temp.poll.value
                            });
                            _app_.poll.push(poll_option_data);
                        } else {
                            return false;
                        }
                    },
                    cancel_poll: function () {
                        var _app_ = this;
                        _app_.active_media = null;
                        _app_.poll = [];
                        _app_.disable_ctrls();
                    },
                    select_images: function () {
                        var _app_ = this;
                        if (_app_.active_media == 'image' || cl_empty(_app_.active_media)) {
                            if (_app_.image_ctrl) {
                                var app_el = $(_app_.$el);
                                app_el.find('input[data-an="images-input"]').trigger('click');
                            }
                        }
                    },
                    select_video: function () {
                        var _app_ = this;
                        if (cl_empty(_app_.active_media)) {
                            if (_app_.video_ctrl) {
                                var app_el = $(_app_.$el);
                                app_el.find('input[data-an="video-input"]').trigger('click');
                            }
                        }
                    },
                    select_gifs: function () {
                        var _app_ = this;
                        var step = false;
                        if (cl_empty(_app_.active_media)) {
                            $.ajax({
                                url: 'https://api.giphy.com/v1/gifs/trending',
                                type: 'GET',
                                dataType: 'json',
                                data: {
                                    api_key: 'EEoFiCosGuyEIWlXnRuw4McTLxfjCrl1',
                                    limit: 50,
                                    lang: cl_get_ulang(),
                                    fmt: 'json'
                                },
                            }).done(function (data) {
                                if (data.meta.status == 200 && data.data.length > 0) {
                                    for (var i = 0; i < data.data.length; i++) {
                                        if (step) {
                                            _app_.gifs_r1.push({
                                                thumb: data['data'][i]['images']['preview_gif']['url'],
                                                src: data['data'][i]['images']['original']['url'],
                                            });
                                        } else {
                                            _app_.gifs_r2.push({
                                                thumb: data['data'][i]['images']['preview_gif']['url'],
                                                src: data['data'][i]['images']['original']['url'],
                                            });
                                        }
                                        step = !step;
                                    }
                                }
                            }).always(function () {
                                if (_app_.gifs && cl_empty(_app_.active_media)) {
                                    _app_.active_media = "gifs";
                                }
                                _app_.disable_ctrls();
                            });
                        }
                    },
                    search_gifs: function (_self = null) {
                        if (_self.target.value.length >= 2) {
                            var query = $.trim(_self.target.value);
                            var step = false;
                            var _app_ = this;
                            var gifs_r1 = _app_.gifs_r1;
                            var gifs_r2 = _app_.gifs_r2;
                            $.ajax({
                                url: 'https://api.giphy.com/v1/gifs/search',
                                type: 'GET',
                                dataType: 'json',
                                data: {
                                    q: query,
                                    api_key: 'EEoFiCosGuyEIWlXnRuw4McTLxfjCrl1',
                                    limit: 50,
                                    lang: 'en',
                                    fmt: 'json'
                                }
                            }).done(function (data) {
                                if (data.meta.status == 200 && data.data.length > 0) {
                                    _app_.gifs_r1 = [];
                                    _app_.gifs_r2 = [];
                                    for (var i = 0; i < data.data.length; i++) {
                                        if (step) {
                                            _app_.gifs_r1.push({
                                                thumb: data['data'][i]['images']['preview_gif']['url'],
                                                src: data['data'][i]['images']['original']['url'],
                                            });
                                        } else {
                                            _app_.gifs_r2.push({
                                                thumb: data['data'][i]['images']['preview_gif']['url'],
                                                src: data['data'][i]['images']['original']['url'],
                                            });
                                        }
                                        step = !step;
                                    }
                                } else {
                                    _app_.gifs_r1 = gifs_r1;
                                    _app_.gifs_r2 = gifs_r2;
                                }
                            });
                        }
                    },
                    preview_gif: function (_self = null) {
                        var _app_ = this;
                        if (_self.target) {
                            _app_.gif_source = $(_self.target).data('source');
                        }
                    },
                    rm_preview_gif: function () {
                        var _app_ = this;
                        _app_.gif_source = null;
                    },
                    close_gifs: function () {
                        var _app_ = this;
                        _app_.gifs_r1 = [];
                        _app_.gifs_r2 = [];
                        _app_.active_media = null;
                        _app_.disable_ctrls();
                    },
                    rm_gif_preloader(_self = null) {
                        if (_self.target) {
                            $(_self.target).siblings('div').remove();
                            $(_self.target).parent('div').removeClass('loading');
                        }
                    },
                    upload_images: function (event = null) {
                        var _app_ = this;
                        var app_el = $(_app_.$el);
                        if (cl_empty(_app_.active_media) || _app_.active_media == 'image') {
                            var images = event.target.files;
                            if (SMColibri.curr_pn == 'thread') {
                                $('div[data-app="modal-pubbox"]').addClass('vis-hidden');
                            }
                            SMColibri.upload_progress_bar('show', "Uploading images");
                            if (images.length) {
                                for (var i = 0; i < images.length; i++) {
                                    var form_data = new FormData();
                                    var break_loop = false;
                                    form_data.append('delay', 1);
                                    form_data.append('image', images[i]);
                                    form_data.append('hash', "1621282486:d05785002742a30502dde3731b28883334e46040");
                                    $.ajax({
                                        url: 'https://trysoftcolib.com//native_api/main/upload_post_image',
                                        type: 'POST',
                                        dataType: 'json',
                                        enctype: 'multipart/form-data',
                                        data: form_data,
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        timeout: 600000,
                                        beforeSend: function () {
                                            _app_.submitting = true;
                                        },
                                        success: function (data) {
                                            if (data.status == 200) {
                                                _app_.images.push(data.img);
                                            } else if (data.err_code == "total_limit_exceeded") {
                                                cl_bs_notify("You cannot attach more than 10 images to this post.", 1500);
                                                break_loop = true;
                                            } else {
                                                cl_bs_notify("An error occurred while processing your request. Please try again later.", 3000);
                                            }
                                        },
                                        complete: function () {
                                            if (_app_.images.length && cl_empty(_app_.active_media)) {
                                                _app_.active_media = "image";
                                            }
                                            _app_.disable_ctrls();
                                            _app_.submitting = false;
                                        }
                                    });
                                    if (break_loop) {
                                        break;
                                    }
                                }
                            }
                            setTimeout(function () {
                                SMColibri.upload_progress_bar('end');
                                if (SMColibri.curr_pn == 'thread') {
                                    $('div[data-app="modal-pubbox"]').removeClass('vis-hidden');
                                }
                            }, 1500);
                            app_el.find('input[data-an="images-input"]').val('');
                        }
                    },
                    upload_video: function (event = null) {
                        var _app_ = this;
                        var app_el = $(_app_.$el);
                        if (cl_empty(_app_.active_media)) {
                            var video = event.target.files[0];
                            if (video) {
                                var form_data = new FormData();
                                form_data.append('video', video);
                                form_data.append('hash', "1621282486:d05785002742a30502dde3731b28883334e46040");
                                $.ajax({
                                    url: 'https://trysoftcolib.com//native_api/main/upload_post_video',
                                    type: 'POST',
                                    dataType: 'json',
                                    enctype: 'multipart/form-data',
                                    data: form_data,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    timeout: 600000,
                                    beforeSend: function () {
                                        SMColibri.upload_progress_bar('show', "Uploading video");
                                        if (SMColibri.curr_pn == 'thread') {
                                            $('div[data-app="modal-pubbox"]').addClass('vis-hidden');
                                        }
                                    },
                                    success: function (data) {
                                        if (data.status == 200) {
                                            _app_.video = data.video;
                                        } else if (data.err_code == "total_limit_exceeded") {
                                            cl_bs_notify("You cannot attach more than 1 video to this post.", 1500);
                                        } else {
                                            cl_bs_notify("An error occurred while processing your request. Please try again later.", 3000);
                                        }
                                    },
                                    complete: function () {
                                        if ($.isEmptyObject(_app_.video) != true && cl_empty(_app_.active_media)) {
                                            _app_.active_media = "video";
                                        }
                                        _app_.disable_ctrls();
                                        app_el.find('input[data-an="video-input"]').val('');
                                        setTimeout(function () {
                                            SMColibri.upload_progress_bar('end');
                                            if (SMColibri.curr_pn == 'thread') {
                                                $('div[data-app="modal-pubbox"]').removeClass('vis-hidden');
                                            }
                                        }, 1500);
                                    }
                                });
                            }
                        }
                    },
                    delete_image: function (id = null) {
                        if (cl_empty(id)) {
                            return false;
                        } else {
                            var _app_ = this;
                            for (var i = 0; i < _app_.images.length; i++) {
                                if (_app_.images[i]['id'] == id) {
                                    _app_.images.splice(i, 1);
                                }
                            }
                            $.ajax({
                                url: 'https://trysoftcolib.com//native_api/main/delete_post_image',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    image_id: id
                                },
                            }).done(function (data) {
                                if (data.status != 200) {
                                    SMColibri.errorMSG();
                                }
                            }).always(function () {
                                if (cl_empty(_app_.images.length)) {
                                    _app_.active_media = null;
                                }
                                _app_.disable_ctrls();
                            });
                        }
                    },
                    delete_video: function () {
                        var _app_ = this;
                        $.ajax({
                            url: 'https://trysoftcolib.com//native_api/main/delete_post_video',
                            type: 'POST',
                            dataType: 'json',
                        }).done(function (data) {
                            if (data.status != 200) {
                                SMColibri.errorMSG();
                            } else {
                                _app_.video = Object({});
                            }
                        }).always(function () {
                            if ($.isEmptyObject(_app_.video)) {
                                _app_.active_media = null;
                            }
                            _app_.disable_ctrls();
                        });
                    },
                    disable_ctrls: function () {
                        var _app_ = this;
                        if (_app_.active_media == 'image' && _app_.images.length >= 10) {
                            _app_.image_ctrl = false;
                            _app_.gif_ctrl = false;
                            _app_.video_ctrl = false;
                            _app_.poll_ctrl = false;
                        } else if (_app_.active_media == 'image' && _app_.images.length < 10) {
                            _app_.image_ctrl = true;
                            _app_.gif_ctrl = false;
                            _app_.video_ctrl = false;
                            _app_.poll_ctrl = false;
                        } else if (_app_.active_media != null) {
                            _app_.image_ctrl = false;
                            _app_.gif_ctrl = false;
                            _app_.video_ctrl = false;
                            _app_.poll_ctrl = false;
                        } else {
                            _app_.image_ctrl = true;
                            _app_.gif_ctrl = true;
                            _app_.video_ctrl = true;
                            _app_.poll_ctrl = true;
                        }
                    },
                    reset_data: function () {
                        var _app_ = this;
                        _app_.image_ctrl = true;
                        _app_.gif_ctrl = true;
                        _app_.poll_ctrl = true;
                        _app_.video_ctrl = true;
                        _app_.og_imported = false;
                        _app_.text = "";
                        _app_.images = [];
                        _app_.video = Object({});
                        _app_.og_data = Object({});
                        _app_.poll = [];
                        _app_.active_media = null;
                        _app_.gif_source = null;
                        _app_.gifs_r1 = [];
                        _app_.gifs_r2 = [];
                        _app_.og_hidden = [];
                        $(_app_.$el).find('textarea').get(0).emojioneArea.setText("");
                        _app_.rep_emoji_picker();
                    },
                    rm_preview_og: function () {
                        var _app_ = this;
                        _app_.og_hidden.push(_app_.og_data.url);
                        _app_.og_imported = false;
                        _app_.og_data = Object({});
                    }
                },
                updated: function () {
                    var _app_ = this;
                    _app_.rep_emoji_picker();
                    delay(function () {
                        if (_app_.og_imported != true) {
                            var text_links = _app_.text.match(/(https?:\/\/[^\s]+)/);
                            if (text_links && text_links.length > 0 && _app_.og_hidden.contains(text_links[0]) != true) {
                                $.ajax({
                                    url: 'https://trysoftcolib.com//native_api/main/import_og_data',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        url: text_links[0]
                                    }
                                }).done(function (data) {
                                    if (data.status == 200) {
                                        _app_.og_imported = true;
                                        _app_.og_data = data.og_data;
                                    }
                                });
                            }
                        }
                    }, 800);
                },
                mounted: function () {
                }
            });
            var emoji_filters = Object({
                recent: {
                    title: "Recent"
                },
                smileys_people: {
                    title: "Emoticons and People",
                },
                animals_nature: {
                    title: "Animals & Nature",
                },
                food_drink: {
                    title: "Food & Drink",
                },
                activity: {
                    title: "Activity",
                },
                travel_places: {
                    title: "Travel & Places",
                },
                objects: {
                    title: "Objects",
                },
                symbols: {
                    title: "Symbols",
                },
                flags: {
                    title: "Flags",
                }
            });
            if ($("form#vue-pubbox-app-2").length) {
                var pubbox_app_2 = new Vue({
                    el: "#vue-pubbox-app-2",
                    mixins: [pubbox_form_app_mixin]
                });

                $(pubbox_app_2.$el).find('textarea').emojioneArea({
                    pickerPosition: "bottom",
                    search: false,
                    filters: emoji_filters
                });

                $(pubbox_app_2.$el).find('textarea').get(0).emojioneArea.on('emojibtn.click', function (event) {
                    pubbox_app_2.text = $(pubbox_app_2.$el).find('textarea').get(0).emojioneArea.getText();
                });

                $(pubbox_app_2.$el).find('textarea').get(0).emojioneArea.on('keyup', function (event) {
                    pubbox_app_2.text = $(pubbox_app_2.$el).find('textarea').get(0).emojioneArea.getText();
                });

                SMColibri.extend_vue('pubbox2', pubbox_app_2);

                $(document).on('hidden.bs.modal', 'div#add_new_post', function () {
                    pubbox_app_2.thread_id = 0;
                    pubbox_app_2.post_privacy = "everyone";
                });
            }
        });
    </script>

    <div data-app="black-hole"></div>

    <script>
        /* @*************************************************************************@
                                                                                                                // @ @author Mansur Altamirov (Mansur_TL)									 @
                                                                                                                // @ @author_url 1: https://www.instagram.com/mansur_tl                      @
                                                                                                                // @ @author_url 2: http://codecanyon.net/user/mansur_tl                     @
                                                                                                                // @ @author_email: highexpresstore@gmail.com                                @
                                                                                                                // @*************************************************************************@
                                                                                                                // @ ColibriSM - The Ultimate Modern Social Media Sharing Platform           @
                                                                                                                // @ Copyright (c) 21.03.2020 ColibriSM. All rights reserved.                @
                                                                                                                // @*************************************************************************@
                                                                                                                */

        "use strict";

        (function (window) {
            function _SMColibri() {
                var _evh = {};
                var data = {
                    url: "https://trysoftcolib.com/"
                };

                var _smc = Object({
                    curr_pn: "home",
                    vue: Object({}),
                    is_logged_user: '1',
                    back_url: data.url,
                    upload_progress_int: false
                });

                if (_smc.curr_pn != "chat") {
                    if ($(window).width() > 1024) {
                        _smc.lsb = new StickySidebar('div#left-sb-container', {
                            topSpacing: 0,
                            bottomSpacing: 0
                        });

                        _smc.rsb = new StickySidebar('div#right-sb-container', {
                            topSpacing: 0,
                            bottomSpacing: 0
                        });
                    }
                }

                _smc.init = function () {
                    _smc.fix_sidebars();
                    _smc.update_msb_indicators();

                    if (cl_empty(window.history.state)) {
                        window.history.pushState({
                            state: "new",
                            back_url: window.location.href
                        }, "", window.location.href);
                    }
                }

                _smc.fix_sidebars = function () {
                    if (_smc.curr_pn != "chat" && _smc.curr_pn != "notifications") {
                        if ($(window).width() > 1024) {
                            if (_smc.lsb) {
                                _smc.lsb.updateSticky();
                            }

                            if (_smc.rsb) {
                                _smc.rsb.updateSticky();
                            }
                        }
                    }
                }

                _smc.get_cookie = function (name = "") {
                    var matches = document.cookie.match(new RegExp(
                        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
                    ));

                    return (matches ? decodeURIComponent(matches[1]) : undefined);
                }

                _smc.is_logged = function () {
                    if (_smc.is_logged_user == '1') {
                        return true;
                    }

                    return false;
                }

                _smc.post_privacy = function (priv = "everyone", id = false) {
                    if ($.isNumeric(id)) {
                        $.ajax({
                            url: 'https://trysoftcolib.com//native_api/main/post_privacy',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                id: id,
                                priv: priv
                            },
                            beforeSend: function () {
                                _smc.upload_progress_bar("show", "Changing post privacy settings");
                            }
                        }).done(function (data) {
                            if (data.status == 200) {
                                _smc.spa_reload();
                            } else {
                                _smc.errorMSG();
                            }
                        }).always(function () {
                            setTimeout(function () {
                                _smc.upload_progress_bar("end");
                            }, 1500);
                        });
                    } else {
                        return false;
                    }
                }

                _smc.confirm_action = function (data = {}) {
                    var modal = "<div class='modal fadeIn confirm-actions-modal' tabindex='-1' data-onclose='remove' role='dialog' aria-hidden='true' data-keyboard='false' data-backdrop='static'><div class='modal-dialog modal-md' role='document'><div class='modal-content'><div class='modal-body'><h4>{0}</h4><p>{1}</p></div><div class='modal-footer'><button id='confirm-actions-cancel' type='button' class='btn btn-custom main-grey lg'>{2}</button><button id='confirm-actions-confirm' type='button' class='btn btn-custom main-inline lg'>{3}</button></div></div></div></div>";
                    var title = data['title'];
                    var message = data['message'];
                    var btn_1 = data['btn_1'];
                    var btn_2 = data['btn_2'];
                    var modal = modal.format(title, message, btn_1, btn_2);
                    var deferred = new $.Deferred();

                    $(document).on('click', '#confirm-actions-confirm', function (event) {
                        $(this).attr("disabled", true).text("Please wait");
                        deferred.resolve();
                    });

                    $(document).on('click', '#confirm-actions-cancel', function (event) {
                        deferred.reject();
                    });

                    $('div[data-app="black-hole"]').append($(modal)).find('div.confirm-actions-modal').modal('show');

                    return deferred.promise();
                }

                _smc.req_auth = function () {
                    var modal = "<div class='modal fadeIn info-popup-modal vh-center' tabindex='-1' data-onclose='remove' role='dialog' aria-hidden='true' data-keyboard='false' data-backdrop='static'><div class='modal-dialog modal-md' role='document'><div class='modal-content'><div class='modal-body'><h4>This action requires authorization!</h4><p>Please log in to your account in order to perform this action, or register if you do not already have an account on - <b >Pulse Wellness</b></p></div><div class='modal-footer'><button data-dismiss='modal' type='button' class='btn btn-block btn-custom main-inline lg'>Okey!</button></div></div></div></div>";

                    $('div[data-app="black-hole"]').append($(modal)).find('div.info-popup-modal').modal('show');
                }

                _smc.info = function (title = "", body = "") {
                    var modal = "<div class='modal fadeIn info-popup-modal vh-center' tabindex='-1' data-onclose='remove' role='dialog' aria-hidden='true' data-keyboard='false' data-backdrop='static'><div class='modal-dialog modal-md' role='document'><div class='modal-content'><div class='modal-body'><h4>{0}</h4><p>{1}</p></div><div class='modal-footer'><button data-dismiss='modal' type='button' class='btn btn-block btn-custom main-inline lg'>Okey!</button></div></div></div></div>";
                    var modal = modal.format(title, body);

                    $('div[data-app="black-hole"]').append($(modal)).find('div.info-popup-modal').modal('show');
                }

                _smc.vote_poll = function (id = false, index = false) {
                    if (_smc.is_logged()) {
                        if ($.isNumeric(id) && $.isNumeric(index)) {
                            var post_poll = $('[data-post-poll="{0}"]'.format(id));

                            if (post_poll.length && post_poll.data("status") != 1) {
                                post_poll.data("status", 1);

                                $.ajax({
                                    url: 'https://trysoftcolib.com//native_api/main/vote_poll',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        id: id,
                                        option: index
                                    }
                                }).done(function (data) {
                                    if (data.status == 200) {
                                        for (var i = 0; i < data.poll.options.length; i++) {
                                            var poll_option = post_poll.find('[data-poll-option="{0}"]'.format(i));
                                            var data_option = data.poll.options[i];

                                            if (poll_option && poll_option.length) {
                                                if (data_option.active != undefined) {
                                                    poll_option.addClass("active");
                                                }

                                                poll_option.find('b').text("{0}%".format(data_option.percentage));
                                                poll_option.find('span').css("width", "{0}%".format(data_option.percentage));
                                            }
                                        }
                                    } else {
                                        _smc.errorMSG();
                                    }
                                });
                            } else {
                                return false;
                            }
                        }
                    } else {
                        _smc.req_auth();
                    }
                }

                _smc.pub_reply = function (id = false) {
                    if (_smc.is_logged()) {
                        if ($.isNumeric(id) && id) {
                            _smc.vue.pubbox2.post_privacy = false;
                            _smc.vue.pubbox2.thread_id = id;

                            $("div#add_new_post").modal('show');
                        }
                    } else {
                        _smc.req_auth();
                    }
                }

                _smc.show_post = function (id = false) {
                    if ($.isNumeric(id) && id) {
                        var promise = SMColibri.confirm_action({
                            btn_1: "Cancel",
                            btn_2: "View",
                            title: "Please confirm your actions!",
                            message: "Are you sure you want to see the content of this post? Please note that the owner of the post is on your blacklist."
                        });

                        promise.done(function () {
                            $('[data-post-blocker="{0}"]'.format(id)).remove();
                            $("div.confirm-actions-modal").modal("hide");
                        });

                        promise.fail(function () {
                            $("div.confirm-actions-modal").modal("hide");
                        });
                    }
                }

                _smc.delete_post = function (id = false) {
                    if ($.isNumeric(id) && id) {
                        if (_smc.is_logged()) {
                            var main_left_sb = $('div[data-app="left-sidebar"]');
                            var promise = SMColibri.confirm_action({
                                btn_1: "Cancel",
                                btn_2: "Delete",
                                title: "Please confirm your actions!",
                                message: "Please note that if you delete this post, then with the removal of this post all posts related to this thread will also be permanently deleted!"
                            });

                            promise.done(function () {
                                $.ajax({
                                    url: 'https://trysoftcolib.com//native_api/main/delete_post',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        id: id
                                    },
                                }).done(function (data) {
                                    if (data.status != 200) {
                                        cl_bs_notify("An error occurred while processing your request. Please try again later.", 3000);
                                    } else {
                                        if (_smc.curr_pn == 'home') {
                                            var hp_tl_app = $('div[data-app="homepage"]');

                                            hp_tl_app.find('div[data-an="entry-list"]').find('div[data-list-item="{0}"]'.format(id)).slideUp(200, function () {
                                                $(this).remove();

                                                if (hp_tl_app.find('div[data-an="entry-list"]').find('div[data-list-item]').length < 1) {
                                                    $(window).reloadPage(50);
                                                }
                                            });

                                            if (data.hasOwnProperty('posts_total')) {
                                                main_left_sb.find('b[data-an="total-posts"]').text(data.posts_total);
                                            }
                                        } else if (_smc.curr_pn == 'profile') {
                                            var profile_app = $('div[data-app="profile"]');

                                            profile_app.find('div[data-an="entry-list"]').find('div[data-list-item="{0}"]'.format(id)).slideUp(200, function () {
                                                $(this).remove();

                                                if (profile_app.find('div[data-an="entry-list"]').find('div[data-list-item]').length < 1) {
                                                    $(window).reloadPage(50);
                                                }
                                            });

                                            if (data.hasOwnProperty('posts_total')) {
                                                main_left_sb.find('b[data-an="total-posts"]').text(data.posts_total);
                                            }
                                        } else if (_smc.curr_pn == 'bookmarks') {
                                            var bookmarks_app = $('div[data-app="bookmarks"]');

                                            bookmarks_app.find('div[data-an="entry-list"]').find('div[data-list-item="{0}"]'.format(id)).slideUp(200, function () {
                                                $(this).remove();

                                                if (bookmarks_app.find('div[data-an="entry-list"]').find('div[data-list-item]').length < 1) {
                                                    $(window).reloadPage(50);
                                                }
                                            });

                                            if (data.hasOwnProperty('posts_total')) {
                                                main_left_sb.find('b[data-an="total-posts"]').text(data.posts_total);
                                            }
                                        } else if (_smc.curr_pn == 'search') {
                                            var search_app = $('div[data-app="search"]');

                                            search_app.find('div[data-an="entry-list"]').find('div[data-list-item="{0}"]'.format(id)).slideUp(200, function () {
                                                $(this).remove();
                                            });

                                            if (data.hasOwnProperty('posts_total')) {
                                                main_left_sb.find('b[data-an="total-posts"]').text(data.posts_total);
                                            }
                                        } else {
                                            cl_redirect(data.url);
                                        }
                                    }
                                }).always(function () {
                                    $("div.confirm-actions-modal").modal("hide");
                                });
                            });

                            promise.fail(function () {
                                $("div.confirm-actions-modal").modal("hide");
                            });
                        } else {
                            _smc.req_auth();
                        }
                    }
                }

                _smc.like_post = function (id = false, event = false) {
                    if (_smc.is_logged()) {
                        if ($.isNumeric(id) && id) {
                            $(event).attr('disabled', 'true');

                            $.ajax({
                                url: 'https://trysoftcolib.com//native_api/main/like_post',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    id: id
                                },
                            }).done(function (data) {
                                if (data.status == 200) {
                                    if ($(event).hasClass('liked')) {
                                        $(event).removeClass('liked');

                                        $(event).removeClass('liked').addClass('animated bounceIn').promise().done(function () {
                                            delay(function () {
                                                $(event).removeClass('animated bounceIn');
                                            }, 1000);
                                        });

                                        $(event).find('span[data-an="likes-count"]').text(data.likes_count);
                                    } else {
                                        $(event).addClass('liked').addClass('animated bounceIn').promise().done(function () {
                                            delay(function () {
                                                $(event).removeClass('animated bounceIn');
                                            }, 1000);
                                        });

                                        $(event).find('span[data-an="likes-count"]').text(data.likes_count);
                                    }
                                } else {
                                    cl_bs_notify("An error occurred while processing your request. Please try again later.", 3000);
                                }

                            }).always(function () {
                                $(event).removeAttr('disabled');
                            });
                        }
                    } else {
                        _smc.req_auth();
                    }
                }

                _smc.repost = function (id = false, event = false) {
                    if (_smc.is_logged()) {
                        if ($.isNumeric(id) && id) {
                            $(event).attr('disabled', 'true');

                            $.ajax({
                                url: 'https://trysoftcolib.com//native_api/main/repost',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    id: id
                                },
                            }).done(function (data) {
                                if (data.status == 200) {
                                    if ($(event).hasClass('reposted')) {
                                        $(event).removeClass('reposted');

                                        $(event).removeClass('reposted').addClass('animated bounceIn').promise().done(function () {
                                            delay(function () {
                                                $(event).removeClass('animated bounceIn');
                                            }, 1000);
                                        });

                                        $(event).find('span[data-an="reposts-count"]').text(data.reposts_count);

                                        if (_smc.curr_pn == 'home' || _smc.curr_pn == 'profile') {

                                            var timeline_app = ((_smc.curr_pn == 'home') ? $('div[data-app="homepage"]') : $('div[data-app="profile"]'));
                                            var orig_post = timeline_app.find('div[data-an="entry-list"]').find('[data-list-item="{0}"]'.format(id));
                                            var repost = timeline_app.find('div[data-an="entry-list"]').find('[data-repost="{0}"]'.format(data.repost_id));

                                            if (repost.length) {
                                                repost.slideUp(200, function () {
                                                    $(this).remove();
                                                });
                                            }

                                            if (orig_post.length) {
                                                orig_post.find('button[data-an="repost-ctrl"]').removeClass('reposted');
                                                orig_post.find('span[data-an="reposts-count"]').text(data.reposts_count);
                                                orig_post.find('span[data-an="reposts-count"]').addClass('animated bounceIn').promise().done(function () {
                                                    delay(function () {
                                                        $(event).removeClass('animated bounceIn');
                                                    }, 1000);
                                                });
                                            }
                                        }
                                    } else {
                                        $(event).addClass('reposted').addClass('animated bounceIn').promise().done(function () {
                                            delay(function () {
                                                $(event).removeClass('animated bounceIn');
                                            }, 1000);
                                        });

                                        $(event).find('span[data-an="reposts-count"]').text(data.reposts_count);
                                    }
                                } else {
                                    cl_bs_notify("An error occurred while processing your request. Please try again later.", 3000);
                                }
                            }).always(function () {
                                $(event).removeAttr('disabled');
                            });
                        }
                    } else {
                        _smc.req_auth();
                    }
                }

                _smc.share_post = function (url = false, encoded_url = false) {
                    if (url && encoded_url) {
                        var modal = "<div class='modal fadeIn share-post-modal vh-center' data-an='share-post' tabindex='-1' data-onclose='remove' role='dialog' aria-hidden='true' data-keyboard='false' data-backdrop='static'><div class='modal-dialog modal-md' role='document'><div class='modal-content'><div class='modal-header'><div class='main---mh--block'><h5 class='modal-title'>Share post</h5><span class='dismiss-modal' data-dismiss='modal'><svg role='img' xmlns='http://www.w3.org/2000/svg'  viewBox='0 0 24 24' aria-labelledby='closeIconTitle'  stroke-width='1.8' stroke-linecap='square' stroke-linejoin='miter' fill='none' >  <path d='M6.34314575 6.34314575L17.6568542 17.6568542M6.34314575 17.6568542L17.6568542 6.34314575'/> </svg></span></div></div><div class='modal-body'><div class='social-media-links'><a href='https://twitter.com/intent/tweet?url={0}' target='_black' class='link-item twitter'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><path d='M492 109.5c-17.4 7.7-36 12.9-55.6 15.3 20-12 35.4-31 42.6-53.6-18.7 11.1-39.4 19.2-61.5 23.5C399.8 75.8 374.6 64 346.8 64c-53.5 0-96.8 43.4-96.8 96.9 0 7.6.8 15 2.5 22.1-80.5-4-151.9-42.6-199.6-101.3-8.3 14.3-13.1 31-13.1 48.7 0 33.6 17.2 63.3 43.2 80.7-16-.4-31-4.8-44-12.1v1.2c0 47 33.4 86.1 77.7 95-8.1 2.2-16.7 3.4-25.5 3.4-6.2 0-12.3-.6-18.2-1.8 12.3 38.5 48.1 66.5 90.5 67.3-33.1 26-74.9 41.5-120.3 41.5-7.8 0-15.5-.5-23.1-1.4C62.8 432 113.7 448 168.3 448 346.6 448 444 300.3 444 172.2c0-4.2-.1-8.4-.3-12.5C462.6 146 479 129 492 109.5z'/></svg></a><a href='https://www.facebook.com/sharer.php?u={0}' target='_black' class='link-item facebook'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><path d='M426.8 64H85.2C73.5 64 64 73.5 64 85.2v341.6c0 11.7 9.5 21.2 21.2 21.2H256V296h-45.9v-56H256v-41.4c0-49.6 34.4-76.6 78.7-76.6 21.2 0 44 1.6 49.3 2.3v51.8h-35.3c-24.1 0-28.7 11.4-28.7 28.2V240h57.4l-7.5 56H320v152h106.8c11.7 0 21.2-9.5 21.2-21.2V85.2c0-11.7-9.5-21.2-21.2-21.2z'/></svg></a><a href='https://www.linkedin.com/shareArticle?mini=true&url={0}' target='_black' class='link-item linkedin'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><path d='M417.2 64H96.8C79.3 64 64 76.6 64 93.9V415c0 17.4 15.3 32.9 32.8 32.9h320.3c17.6 0 30.8-15.6 30.8-32.9V93.9C448 76.6 434.7 64 417.2 64zM183 384h-55V213h55v171zm-25.6-197h-.4c-17.6 0-29-13.1-29-29.5 0-16.7 11.7-29.5 29.7-29.5s29 12.7 29.4 29.5c0 16.4-11.4 29.5-29.7 29.5zM384 384h-55v-93.5c0-22.4-8-37.7-27.9-37.7-15.2 0-24.2 10.3-28.2 20.3-1.5 3.6-1.9 8.5-1.9 13.5V384h-55V213h55v23.8c8-11.4 20.5-27.8 49.6-27.8 36.1 0 63.4 23.8 63.4 75.1V384z'/></svg></a><a href='https://www.pinterest.ru/pin/create/button/?url={0}' target='_black' class='link-item pinterest'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><path d='M256 32C132.3 32 32 132.3 32 256c0 91.7 55.2 170.5 134.1 205.2-.6-15.6-.1-34.4 3.9-51.4 4.3-18.2 28.8-122.1 28.8-122.1s-7.2-14.3-7.2-35.4c0-33.2 19.2-58 43.2-58 20.4 0 30.2 15.3 30.2 33.6 0 20.5-13.1 51.1-19.8 79.5-5.6 23.8 11.9 43.1 35.4 43.1 42.4 0 71-54.5 71-119.1 0-49.1-33.1-85.8-93.2-85.8-67.9 0-110.3 50.7-110.3 107.3 0 19.5 5.8 33.3 14.8 43.9 4.1 4.9 4.7 6.9 3.2 12.5-1.1 4.1-3.5 14-4.6 18-1.5 5.7-6.1 7.7-11.2 5.6-31.3-12.8-45.9-47-45.9-85.6 0-63.6 53.7-139.9 160.1-139.9 85.5 0 141.8 61.9 141.8 128.3 0 87.9-48.9 153.5-120.9 153.5-24.2 0-46.9-13.1-54.7-27.9 0 0-13 51.6-15.8 61.6-4.7 17.3-14 34.5-22.5 48 20.1 5.9 41.4 9.2 63.5 9.2 123.7 0 224-100.3 224-224C480 132.3 379.7 32 256 32z'/></svg></a><a href='https://www.reddit.com/submit?url={0}' target='_black' class='link-item reddit'><svg xmlns='http://www.w3.org/2000/svg' class='ionicon' viewBox='0 0 512 512'><title>Logo Reddit</title><path d='M324 256a36 36 0 1036 36 36 36 0 00-36-36z'/><circle cx='188' cy='292' r='36' transform='rotate(-22.5 187.997 291.992)'/><path d='M496 253.77c0-31.19-25.14-56.56-56-56.56a55.72 55.72 0 00-35.61 12.86c-35-23.77-80.78-38.32-129.65-41.27l22-79 66.41 13.2c1.9 26.48 24 47.49 50.65 47.49 28 0 50.78-23 50.78-51.21S441 48 413 48c-19.53 0-36.31 11.19-44.85 28.77l-90-17.89-31.1 109.52-4.63.13c-50.63 2.21-98.34 16.93-134.77 41.53A55.38 55.38 0 0072 197.21c-30.89 0-56 25.37-56 56.56a56.43 56.43 0 0028.11 49.06 98.65 98.65 0 00-.89 13.34c.11 39.74 22.49 77 63 105C146.36 448.77 199.51 464 256 464s109.76-15.23 149.83-42.89c40.53-28 62.85-65.27 62.85-105.06a109.32 109.32 0 00-.84-13.3A56.32 56.32 0 00496 253.77zM414 75a24 24 0 11-24 24 24 24 0 0124-24zM42.72 253.77a29.6 29.6 0 0129.42-29.71 29 29 0 0113.62 3.43c-15.5 14.41-26.93 30.41-34.07 47.68a30.23 30.23 0 01-8.97-21.4zM390.82 399c-35.74 24.59-83.6 38.14-134.77 38.14S157 423.61 121.29 399c-33-22.79-51.24-52.26-51.24-83A78.5 78.5 0 0175 288.72c5.68-15.74 16.16-30.48 31.15-43.79a155.17 155.17 0 0114.76-11.53l.3-.21.24-.17c35.72-24.52 83.52-38 134.61-38s98.9 13.51 134.62 38l.23.17.34.25A156.57 156.57 0 01406 244.92c15 13.32 25.48 28.05 31.16 43.81a85.44 85.44 0 014.31 17.67 77.29 77.29 0 01.6 9.65c-.01 30.72-18.21 60.19-51.25 82.95zm69.6-123.92c-7.13-17.28-18.56-33.29-34.07-47.72A29.09 29.09 0 01440 224a29.59 29.59 0 0129.41 29.71 30.07 30.07 0 01-8.99 21.39z'/><path d='M323.23 362.22c-.25.25-25.56 26.07-67.15 26.27-42-.2-66.28-25.23-67.31-26.27a4.14 4.14 0 00-5.83 0l-13.7 13.47a4.15 4.15 0 000 5.89c3.4 3.4 34.7 34.23 86.78 34.45 51.94-.22 83.38-31.05 86.78-34.45a4.16 4.16 0 000-5.9l-13.71-13.47a4.13 4.13 0 00-5.81 0z'/></svg></a></div><div class='raw-link'><p>Or copy link</p><div class='link-input'><input type='text' readonly='true' value='{1}' id='copy-link-input'><button data-clipboard-target='#copy-link-input' data-clipboard-action='copy' class='clip-board-copy copy-link'><svg role='img' xmlns='http://www.w3.org/2000/svg'  viewBox='0 0 24 24' aria-labelledby='copyIconTitle'  stroke-width='1.8' stroke-linecap='square' stroke-linejoin='miter' fill='none' >  <rect width='12' height='14' x='8' y='7'/> <polyline points='16 3 4 3 4 17'/> </svg></button></div></div></div></div></div></div>";
                        var modal = modal.format(encoded_url, url);

                        $('body').find('[data-app="black-hole"]').append($(modal)).promise().done(function () {
                            $('body').find('[data-app="black-hole"]').find('[data-an="share-post"]').modal('show');
                        });
                    }
                }

                _smc.isURL = function (str = "") {
                    var regex = new RegExp("^(https?:\\/\\/)?((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|((\\d{1,3}\\.){3}\\d{1,3}))(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*(\\?[;&a-z\\d%_.~+=-]*)?(\\#[-a-z\\d_]*)?$", "i");
                    return regex.test(str);
                }

                _smc.show_likes = function (id = false) {
                    if ($.isNumeric(id) && id) {
                        $.ajax({
                            url: 'https://trysoftcolib.com//native_api/main/show_likes',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                id: id
                            },
                        }).done(function (data) {
                            if (data.status == 200) {
                                $('div[data-app="black-hole"]').append($(data.html)).find('div[data-app="post-likes-list"]').modal('show');
                            } else {
                                cl_bs_notify("An error occurred while processing your request. Please try again later.", 3000);
                            }
                        });
                    }
                }

                _smc.bookmark_post = function (id = false, _self = false) {
                    if (_smc.is_logged()) {
                        if ($.isNumeric(id) && id) {
                            $.ajax({
                                url: 'https://trysoftcolib.com//native_api/main/bookmark_post',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    id: id,
                                    a: 'save'
                                },
                            }).done(function (data) {
                                if (data.status == 200) {
                                    if (data.status_code == '1') {
                                        cl_bs_notify("Post has been bookmarked!", 500);

                                        $(_self).text("Unbookmark");
                                    } else {
                                        cl_bs_notify("Post has been deleted from bookmarks!", 500);
                                        $(_self).text("Bookmark");
                                    }
                                } else {
                                    cl_bs_notify("An error occurred while processing your request. Please try again later.", 3000);
                                }
                            });
                        }
                    } else {
                        _smc.req_auth();
                    }
                }

                _smc.load_likes = function (id = false, event = false) {
                    if ($.isNumeric(id) && id) {
                        var _self = $(event);
                        var likes_ls = $('div[data-app="post-likes-list"]');
                        var last_item = likes_ls.find('div[data-list-item]').last();

                        if (last_item.length) {
                            $.ajax({
                                url: 'https://trysoftcolib.com//native_api/main/load_likes',
                                type: 'GET',
                                dataType: 'json',
                                data: {
                                    id: id,
                                    offset: last_item.data('list-item')
                                },
                                beforeSend: function () {
                                    _self.attr('disabled', 'true').text("Please wait");
                                }
                            }).done(function (data) {
                                if (data.status == 200) {
                                    likes_ls.find('div[data-an="users-ls"]').append($(data.html));

                                    _self.removeAttr('disabled').text("Show more");
                                } else {
                                    _self.text("That is all for now!");
                                }
                            });
                        }
                    }
                }

                _smc.follow = function (event = false) {
                    if (event) {
                        if (_smc.is_logged()) {
                            var target = $(event);
                            var main_left_sb = $('div[data-app="left-sidebar"]');

                            if (target.data('action') == 'unfollow') {
                                var promise = SMColibri.confirm_action({
                                    btn_1: "Cancel",
                                    btn_2: "Unfollow",
                                    title: "Please confirm your actions!",
                                    message: "Please note that, if you unsubscribe then this user's posts will no longer appear in the feed on your main page.",
                                });

                                promise.done(function () {
                                    target.data('action', 'follow');
                                    target.text("Follow");
                                    target.replaceClass('main-inline', 'main-outline');

                                    $.ajax({
                                        url: 'https://trysoftcolib.com//native_api/main/follow',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            id: target.data('id')
                                        },
                                    }).done(function (data) {
                                        if (data.status != 200) {
                                            cl_bs_notify("An error occurred while processing your request. Please try again later.", 3000);
                                        } else {
                                            main_left_sb.find('b[data-an="total-following"]').text(data.total_following);

                                            if (_smc.curr_pn == "profile") {
                                                if (data.refresh != undefined) {
                                                    $(window).reloadPage(1000);
                                                }
                                            }
                                        }
                                    }).always(function () {
                                        $("div.confirm-actions-modal").modal("hide");
                                    });
                                });

                                promise.fail(function () {
                                    $("div.confirm-actions-modal").modal("hide");
                                });
                            } else {
                                target.data('action', 'unfollow');
                                target.text("Following");
                                target.replaceClass('main-outline', 'main-inline');

                                delay(function () {
                                    target.text("Unfollow");
                                }, 1500);

                                $.ajax({
                                    url: 'https://trysoftcolib.com//native_api/main/follow',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        id: target.data('id')
                                    },
                                }).done(function (data) {
                                    if (data.status != 200) {
                                        cl_bs_notify("An error occurred while processing your request. Please try again later.", 3000);
                                    } else {
                                        main_left_sb.find('b[data-an="total-following"]').text(data.total_following);

                                        if (_smc.curr_pn == "profile") {
                                            if (data.refresh != undefined) {
                                                $(window).reloadPage(1000);
                                            }
                                        }
                                    }
                                });
                            }
                        } else {
                            _smc.req_auth();
                        }
                    }
                }

                _smc.req_follow = function (event = false) {
                    if (event) {
                        if (_smc.is_logged()) {
                            var target = $(event);

                            if (target.data('action') == 'unfollow') {
                                var promise = SMColibri.confirm_action({
                                    btn_1: "Cancel",
                                    btn_2: "Unfollow",
                                    title: "Please confirm your actions!",
                                    message: "Please note that, if you unsubscribe then this user's posts will no longer appear in the feed on your main page.",
                                });

                                promise.done(function () {
                                    target.data('action', 'follow');
                                    target.text("Follow");
                                    target.replaceClass('main-inline', 'main-outline');

                                    $.ajax({
                                        url: 'https://trysoftcolib.com//native_api/main/follow',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            id: target.data('id')
                                        },
                                    }).done(function (data) {
                                        if (data.status != 200) {
                                            cl_bs_notify("An error occurred while processing your request. Please try again later.", 3000);
                                        }
                                    }).always(function () {
                                        $("div.confirm-actions-modal").modal("hide");
                                    });
                                });

                                promise.fail(function () {
                                    $("div.confirm-actions-modal").modal("hide");
                                });
                            } else if (target.data('action') == 'cancel') {
                                var promise = SMColibri.confirm_action({
                                    btn_1: "Cancel",
                                    btn_2: "Cancel request",
                                    title: "Please confirm your actions!",
                                    message: "This will cancel your pending request and this user will no longer see it.",
                                });

                                promise.done(function () {
                                    target.data('action', 'follow');
                                    target.text("Follow");
                                    target.replaceClass('main-inline', 'main-outline');

                                    $.ajax({
                                        url: 'https://trysoftcolib.com//native_api/main/follow',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            id: target.data('id')
                                        },
                                    }).done(function (data) {
                                        if (data.status != 200) {
                                            cl_bs_notify("An error occurred while processing your request. Please try again later.", 3000);
                                        }
                                    }).always(function () {
                                        $("div.confirm-actions-modal").modal("hide");
                                    });
                                });

                                promise.fail(function () {
                                    $("div.confirm-actions-modal").modal("hide");
                                });
                            } else {
                                target.data('action', 'cancel');
                                target.text("Requested");
                                target.replaceClass('main-outline', 'main-inline');

                                delay(function () {
                                    target.text("Pending");
                                }, 1500);

                                $.ajax({
                                    url: 'https://trysoftcolib.com//native_api/main/follow',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        id: target.data('id')
                                    },
                                }).done(function (data) {
                                    if (data.status != 200) {
                                        cl_bs_notify("An error occurred while processing your request. Please try again later.", 3000);
                                    }
                                });
                            }
                        } else {
                            _smc.req_auth();
                        }
                    }
                }

                _smc.block = function (event = false) {
                    if (event) {
                        if (_smc.is_logged()) {
                            var target = $(event);

                            if (target.data('action') == 'block') {
                                var promise = SMColibri.confirm_action({
                                    btn_1: "Cancel",
                                    btn_2: "Block",
                                    title: "Please confirm your actions!",
                                    message: "Blocked users will no longer be able to write a message to you, follow you, or see your profile and publications, etc.",
                                });

                                promise.done(function () {
                                    target.data('action', 'unblock');
                                    target.text("Unblock");

                                    if (target.hasClass('toggle-class')) {
                                        target.replaceClass('main-inline', 'main-outline');
                                    }

                                    $.ajax({
                                        url: 'https://trysoftcolib.com//native_api/main/block',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            id: target.data('id')
                                        },
                                    }).done(function (data) {
                                        if (data.status != 200) {
                                            SMColibri.errorMSG();
                                        } else {
                                            if (_smc.curr_pn == 'profile') {
                                                $(window).reloadPage();
                                            }
                                        }
                                    }).always(function () {
                                        $("div.confirm-actions-modal").modal("hide");
                                    });
                                });

                                promise.fail(function () {
                                    $("div.confirm-actions-modal").modal("hide");
                                });
                            } else if (target.data('action') == 'unblock') {
                                var promise = SMColibri.confirm_action({
                                    btn_1: "Cancel",
                                    btn_2: "Unblock",
                                    title: "Please confirm your actions!",
                                    message: "Are you sure you want to unblock this user? Now they can follow you or see your posts, etc.",
                                });

                                promise.done(function () {
                                    target.data('action', 'block');
                                    target.text("Block");

                                    if (target.hasClass('toggle-class')) {
                                        target.replaceClass('main-outline', 'main-inline');
                                    }

                                    $.ajax({
                                        url: 'https://trysoftcolib.com//native_api/main/block',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            id: target.data('id')
                                        },
                                    }).done(function (data) {
                                        if (data.status != 200) {
                                            SMColibri.errorMSG();
                                        } else {
                                            if (_smc.curr_pn == 'profile') {
                                                $(window).reloadPage();
                                            }
                                        }
                                    }).always(function () {
                                        $("div.confirm-actions-modal").modal("hide");
                                    });
                                });

                                promise.fail(function () {
                                    $("div.confirm-actions-modal").modal("hide");
                                });
                            }
                        } else {
                            _smc.req_auth();
                        }
                    }
                }

                _smc.errorMSG = function () {
                    cl_bs_notify("An error occurred while processing your request. Please try again later.", 3000);
                }

                _smc.extend_vue = function (app_name = "", vue_instance = {}) {
                    _smc.vue[app_name] = vue_instance;
                }

                _smc.upload_progress_bar = function (a = 'show', title = "") {
                    if (a == 'show') {
                        var modal = "<div data-app='upload-progress-bar' class='modal fadeIn upload-progress-bar vh-center' tabindex='-1' data-onclose='remove' role='dialog' aria-hidden='true' data-keyboard='false' data-backdrop='static'><div class='modal-dialog modal-md' role='document'><div class='modal-content'><div class='modal-body'><div class='progress-bar-title'><h3>{0} (<b data-an='num'>0</b>)<span>Please wait...</span></h3></div><div class='progress-bar-state'><div class='progress-bar-bg'><div data-an='slider' class='progress-bar-slider'></div></div></div></div></div></div></div>";
                        var modal = modal.format(title);
                        var random = cl_randint(30, 80);

                        $('div[data-app="black-hole"]').append($(modal)).find('div[data-app="upload-progress-bar"]').modal('show');

                        setTimeout(function () {
                            _smc.update_progress_bar(random);
                        }, 500);
                    } else {
                        _smc.update_progress_bar(100);
                    }
                }

                _smc.destroy_progress_bar = function () {
                    $('div[data-app="upload-progress-bar"]').modal('hide');
                    clearInterval(_smc.upload_progress_int);
                }

                _smc.update_progress_bar = function (num = 0) {
                    let prog_bar = $('[data-app="upload-progress-bar"]');

                    if (prog_bar.length) {
                        if (num == 100) {
                            var bar_status = prog_bar.data('status');
                            var bar_status = Number(bar_status);
                            _smc.upload_progress_int = setInterval(function () {
                                if (bar_status >= 100) {
                                    setTimeout(function () {
                                        _smc.destroy_progress_bar();
                                    }, 500);
                                } else {
                                    bar_status++;

                                    prog_bar.find('[data-an="num"]').text("{0}%".format(bar_status));
                                    prog_bar.find('[data-an="slider"]').css("width", "{0}%".format(bar_status));
                                    prog_bar.find('[data-an="slider"]').css("min-width", "{0}%".format(bar_status));
                                }
                            }, 10);
                        } else {
                            prog_bar.attr('data-status', num);

                            var i = 1;

                            _smc.upload_progress_int = setInterval(function () {
                                if (i >= num) {
                                    clearInterval(_smc.upload_progress_int);
                                } else {
                                    i++;

                                    prog_bar.find('[data-an="num"]').text("{0}%".format(i));
                                    prog_bar.find('[data-an="slider"]').css("width", "{0}%".format(i));
                                    prog_bar.find('[data-an="slider"]').css("min-width", "{0}%".format(i));
                                }
                            }, 10);
                        }
                    }
                }

                _smc.update_msb_indicators = function () {
                    if (_smc.is_logged()) {
                        var main_left_sb = $('div[data-app="left-sidebar"]');
                        var main_bottom_nb = $('div[data-app="mobile-navbar"]');
                        var timer_id = setInterval(function () {
                            $.ajax({
                                url: 'https://trysoftcolib.com//native_api/main/update_msb_indicators',
                                type: 'GET',
                                dataType: 'json',
                            }).done(function (data) {
                                if (data.status == 200) {
                                    if (data.notifications > 0) {
                                        var notifs_total = data.notifications;

                                        if (data.notifications > 99) {
                                            notifs_total = "99+";
                                        }

                                        main_left_sb.find('[data-an="new-notifs"]').text($.trim(notifs_total));
                                        main_bottom_nb.find('[data-an="new-notifs"]').text($.trim(notifs_total));
                                    } else {
                                        main_left_sb.find('[data-an="new-notifs"]').empty();
                                        main_bottom_nb.find('[data-an="new-notifs"]').empty();
                                    }

                                    if (data.messages) {

                                        var messages_total = data.messages;

                                        if (data.messages > 99) {
                                            messages_total = "99+";
                                        }

                                        main_left_sb.find('[data-an="new-messages"]').text($.trim(messages_total));
                                        main_bottom_nb.find('[data-an="new-messages"]').text($.trim(messages_total));
                                    } else {
                                        main_left_sb.find('[data-an="new-messages"]').empty();
                                        main_bottom_nb.find('[data-an="new-messages"]').empty();
                                    }
                                } else {
                                    clearInterval(timer_id);
                                }
                            });
                        }, (30 * 1000));
                    }
                }

                _smc.hide_sb = function () {
                    $('div[data-app="lsb-back-drop"]').trigger('click');
                }

                _smc.spa_load = function (url = "", push_state = true) {
                    var timeline = $('[data-el="timeline-container-wrapper"]');
                    var preloader = timeline.find('[data-el="spa-preloader"]');

                    if (push_state == true) {
                        window.history.pushState({
                            state: "new",
                            back_url: url
                        }, "", url);
                    }

                    if (window.mobileCheck()) {
                        _smc.hide_sb();
                    }

                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            spa_load: '1'
                        },
                        dataType: 'json',
                        async: true,
                        beforeSend: function () {
                            $("html, body").animate({
                                scrollTop: 0
                            }, 10).promise().done(function () {
                                preloader.removeClass('d-none');
                            });
                        }
                    }).done(function (data = {}) {

                        if (data.status == 200) {
                            var left_sidebar = $('[data-app="left-sidebar"]');
                            var prevapp = _smc.curr_pn;
                            var json_data = data.json_data;
                            _smc.curr_pn = json_data.pn;

                            $('head').find('title').text(json_data.page_title);
                            $('head').find('meta[name="title"]').attr('content', json_data.page_title);
                            $('head').find('meta[name="description"]').attr('content', json_data.page_desc);
                            $('head').find('meta[name="keywords"]').attr('content', json_data.page_kw);

                            if (json_data.page_img) {
                                $('head').find('meta[name="image"]').attr('content', json_data.page_img);
                            }

                            if ($('body').hasClass('cl-app-{0}'.format(prevapp))) {
                                $('body').removeClass('cl-app-{0}'.format(prevapp));
                                $('body').addClass('cl-app-{0}'.format(json_data.pn));
                            } else {
                                $('body').addClass('cl-app-{0}'.format(json_data.pn));
                            }

                            timeline.find('[data-el="timeline-content"]').html(data.html);

                            left_sidebar.find('[data-navitem]').each(function (index, el) {
                                $(el).removeClass('active');
                            }).promise().done(function () {
                                left_sidebar.find('[data-navitem="{0}"]'.format(_smc.curr_pn)).addClass('active');
                            });
                        } else if (data.status == 302) {
                            _smc.spa_load(data.redirect_url);
                        } else {
                            _smc.spa_load("https://trysoftcolib.com//404");
                        }
                    }).always(function () {
                        setTimeout(function () {
                            preloader.addClass('d-none');
                        }, 500);
                    });

                    return false;
                }

                _smc.spa_reload = function () {
                    if (window.location.href != undefined) {
                        _smc.spa_load(window.location.href);
                    } else {
                        _smc.spa_load(data['url']);
                    }

                    return false;
                }

                _smc.go_back = function () {
                    history.back();
                }

                _smc.jump_back = function (step = 1) {
                    history.go(step);
                }

                _smc.ad_conversion = function (e = false) {
                    if (e) {
                        var _self = $(e);
                        var id = _self.data('ad-id');
                        var url = _self.data('ad-url');

                        if (_self.data('conversed') == undefined) {
                            $.ajax({
                                url: 'https://trysoftcolib.com//native_api/ads/ad_conversion',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    id: id
                                },
                            });

                            _self.data('conversed', 'true');
                        }

                        window.open(url, '_blank');
                    }
                }

                return _smc;
            }

            if (window.SMColibri === undefined) {
                window.SMColibri = _SMColibri();
            }
        })(window);

        $(document).ready(function ($) {

            SMColibri.init();

            var clipboard = new ClipboardJS('.clip-board-copy');
            var page_height = $(document).height();

            clipboard.on('success', function (event) {
                cl_bs_notify("Copied to your clipboard!", 500);
            });

            clipboard.on('error', function (event) {
                cl_bs_notify("Failed to copy to clipboard!", 3000);
            });

            if (navigator.cookieEnabled == false) {
                $('[data-app="right-sidebar"]').find('[data-an="announcement"]').html("<div class='announcement-item disabled-cookies'>Oops! It looks like you have cookies disabled. For this site to work properly, you need to enable cookies.</div>");
            }

            setInterval(function () {

                var new_page_height = $(document).height();
                var _lozad_ = lozad();

                _lozad_.observe();

                if (page_height != new_page_height) {
                    page_height = page_height;
                    SMColibri.fix_sidebars();
                }

                $("a.fbox-media").fancybox({
                    arrows: true,
                    i18n: {
                        en: {
                            ERROR: "The requested content could not be loaded. <br/> Please try again later.",
                        }
                    }
                });

                if ($('video[data-el="colibrism-video"]').length) {
                    $('video[data-el="colibrism-video"]').each(function (index, el) {
                        if ($(el).hasClass('afterglow') != true) {
                            var video_src = $(el).find("source").first().attr("src");
                            $(el).width("100%").height("100%").addClass('afterglow');

                            $(el).find("source").remove();

                            $(el).append($("<source>", {
                                type: "video/mp4",
                                src: video_src
                            }));

                            $(el).append($("<source>", {
                                type: "video/webm",
                                src: video_src
                            }));

                            $(el).append($("<source>", {
                                type: "video/mov",
                                src: video_src
                            }));


                            $(el).append($("<source>", {
                                type: "video/3gp",
                                src: video_src
                            }));

                            $(el).append($("<source>", {
                                type: "video/ogg",
                                src: video_src
                            }));

                            afterglow.init();
                        }
                    });
                }
            }, 500);

            $(document).on('click tap', 'a[data-spa]', function (event) {
                event.preventDefault();

                var page_url_source = $(this).attr('href');

                SMColibri.spa_load(page_url_source);

                return false;
            });

            $(window).on("popstate", function () {
                if (history.state) {
                    if ($.isEmptyObject(history.state.back_url) != true) {
                        SMColibri.spa_load(history.state.back_url, false);
                    }
                }

                return false;
            });
        });

        var search_bar_app = new Vue({
            el: "#vue-main-search-app",
            data: {
                searching: false,
                search_query: "",
                advanced_search: false,
                search_result: false
            },
            computed: {
                search_page_url: function () {
                    if (this.search_query.length > 2) {
                        var search_htags_url = "https://trysoftcolib.com//search/htags?q={0}";
                        var search_users_url = "https://trysoftcolib.com//search/people?q={0}";
                        this.advanced_search = true;

                        if (this.search_query.charAt(0) == '#') {
                            return search_htags_url.format(this.search_query.replace('#', ''));
                        } else {
                            return search_users_url.format(this.search_query);
                        }
                    } else {

                        this.advanced_search = false;

                        return "javascript:void(0);";
                    }
                },
                query_type: function () {
                    if (this.search_query.charAt(0) == '#') {
                        return 'htags';
                    } else {
                        return 'users';
                    }
                }
            },
            methods: {
                search_onsubmit: function (e = false) {
                    e.preventDefault();

                    this.search();
                },
                search: function () {
                    if (this.search_query.length > 2) {
                        var _app_ = this;
                        delay(function () {
                            $.ajax({
                                url: 'https://trysoftcolib.com//native_api/main/search',
                                type: 'GET',
                                dataType: 'json',
                                data: {
                                    query: _app_.search_query.replace('#', ''),
                                    type: _app_.query_type
                                },
                                beforeSend: function () {
                                    _app_.searching = true;
                                }
                            }).done(function (data) {
                                if (data.status == 200) {
                                    _app_.search_result = true;
                                    $(_app_.$el).find('[data-an="result"]').html($(data.html));
                                } else {
                                    $(_app_.$el).find('[data-an="result"]').empty('');
                                    _app_.search_result = false;
                                }
                            }).always(function () {
                                _app_.searching = false;
                            });
                        }, 800);
                    }
                },
                cancel: function () {
                    var _app_ = this;
                    _app_.searching = false;
                    _app_.search_query = "";
                    _app_.advanced_search = false;
                    _app_.search_result = false;

                    $(_app_.$el).find('[data-an="result"]').empty('');
                }
            }
        });
    </script>


</div>
</body>

</html>

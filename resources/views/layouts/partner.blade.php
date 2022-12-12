<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{$partnerdata["name"]}} - Admin Dashboard</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{$partnerdata["logo"]}}">
    <link rel="stylesheet" href="{{ env('APP_URL') }}assets/admin/vendor/chartist/css/chartist.min.css">
    <link href="{{ env('APP_URL') }}assets/admin/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="{{ env('APP_URL') }}assets/admin/vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link href="{{ env('APP_URL') }}assets/admin/css/style.css" rel="stylesheet">
    <link href="{{ env('APP_URL') }}assets/admin/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

{{--    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">--}}
{{--    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">--}}
    <style>

        :root {
            --mainprimary: {{$partnerdata["pri_color"]}};
        }

        .select-box {
            display: flex;
            flex-direction: column;
            position: relative;
            width: 160px;
        }

        .select-box .options-container {
            background: #ffffff;
            /*color: #f5f6fa;*/
            max-height: 0;
            width: 100%;
            opacity: 0;
            transition: all 0.4s;
            border-radius: 8px;
            /*overflow: hidden;*/
            position: absolute;
            order: 1;
            top: 60px;
            min-width: 120px;
            z-index: 10;
            padding-top: 5px;
            box-shadow: 2px 5px 5px #c6c6c6;
        }

        .selected {
            /*background: #2f3640;*/
            border-radius: 8px;
            margin-bottom: 8px;
            /*color: #f5f6fa;*/
            position: relative;
            min-width: 120px;
            order: 0;
            display: flex;
            align-items: center;
            justify-content: space-around;
        }
        .selected::after {
            content: "";
            /*background: url("img/arrow-down.svg");*/
            background-size: contain;
            background-repeat: no-repeat;

            position: absolute;
            height: 100%;
            width: 32px;
            right: 10px;
            top: 5px;

            transition: all 0.4s;
        }

        .select-box .options-container.active {
            max-height: 240px;
            opacity: 1;
            /*overflow-y: scroll;*/
        }

        .select-box .options-container.active + .selected::after {
            transform: rotateX(180deg);
            top: -6px;
        }

        .select-box .options-container::-webkit-scrollbar {
            width: 8px;
            background: #ffffff;
            border-radius: 0 8px 8px 0;
        }

        .select-box .options-container::-webkit-scrollbar-thumb {
            background: #ffffff;
            border-radius: 0 8px 8px 0;
        }

        .select-box .option,
        .selected {
            /*padding: 12px 24px;*/
            cursor: pointer;
        }

        .select-box .option:hover {
            background: #ffffff;
        }

        .select-box label {
            cursor: pointer;
        }

        .select-box .option .radio {
            display: none;
        }
        .select-box .option label {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-around;
        }
        canvas.lineChart-active {
            display: block
        }
        canvas.lineChart-hidden {
            display: none !important;
        }		.form-control{color:#495057 !important;}
    </style>
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
        Nav header start
    ***********************************-->
    <div class="nav-header">
        <a href="{{ route('dashboard') }}" class="brand-logo">
            @if(is_null($partnerdata["logo"]) && $partnerdata["logo"] == "")
                <img class="logo-abbr" src="../logo_icon.png" alt="">
                <img class="logo-compact" src="../logo-text.png" alt="">
                <img class="brand-title" src="../logo-text.png" alt="">
            @else

<!--                 <h1 style="color:{{$partnerdata["pri_color"]}} !important;" class="brand-title">{{$partnerdata["name"]}}</h1> -->
                <img class="brand-title"  src="{{$partnerdata['logo']}}">

            @endif
        </a>

        <div class="nav-control">
            <div class="hamburger">
                <span class="line"></span><span class="line"></span><span class="line"></span>
            </div>
        </div>
    </div>
    <!--**********************************
        Nav header end
    ***********************************-->



    <!--**********************************
        Header start
    ***********************************-->
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">

                    </div>
                    <ul class="navbar-nav header-right">
                        <li class="nav-item">
                            <div class="input-group search-area d-xl-inline-flex d-none">
                                <div class="input-group-append">
                                    <span class="input-group-text"><a href=""><i class="flaticon-381-search-2"></i></a></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Search here...">
                            </div>
                        </li>
                        <li class="nav-item dropdown notification_dropdown">
                            <a class="nav-link  ai-icon" href="" role="button" data-toggle="dropdown">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.75 15.8385V13.0463C22.7471 10.8855 21.9385 8.80353 20.4821 7.20735C19.0258 5.61116 17.0264 4.61555 14.875 4.41516V2.625C14.875 2.39294 14.7828 2.17038 14.6187 2.00628C14.4546 1.84219 14.2321 1.75 14 1.75C13.7679 1.75 13.5454 1.84219 13.3813 2.00628C13.2172 2.17038 13.125 2.39294 13.125 2.625V4.41534C10.9736 4.61572 8.97429 5.61131 7.51794 7.20746C6.06159 8.80361 5.25291 10.8855 5.25 13.0463V15.8383C4.26257 16.0412 3.37529 16.5784 2.73774 17.3593C2.10019 18.1401 1.75134 19.1169 1.75 20.125C1.75076 20.821 2.02757 21.4882 2.51969 21.9803C3.01181 22.4724 3.67904 22.7492 4.375 22.75H9.71346C9.91521 23.738 10.452 24.6259 11.2331 25.2636C12.0142 25.9013 12.9916 26.2497 14 26.2497C15.0084 26.2497 15.9858 25.9013 16.7669 25.2636C17.548 24.6259 18.0848 23.738 18.2865 22.75H23.625C24.321 22.7492 24.9882 22.4724 25.4803 21.9803C25.9724 21.4882 26.2492 20.821 26.25 20.125C26.2486 19.117 25.8998 18.1402 25.2622 17.3594C24.6247 16.5786 23.7374 16.0414 22.75 15.8385ZM7 13.0463C7.00232 11.2113 7.73226 9.45223 9.02974 8.15474C10.3272 6.85726 12.0863 6.12732 13.9212 6.125H14.0788C15.9137 6.12732 17.6728 6.85726 18.9703 8.15474C20.2677 9.45223 20.9977 11.2113 21 13.0463V15.75H7V13.0463ZM14 24.5C13.4589 24.4983 12.9316 24.3292 12.4905 24.0159C12.0493 23.7026 11.716 23.2604 11.5363 22.75H16.4637C16.284 23.2604 15.9507 23.7026 15.5095 24.0159C15.0684 24.3292 14.5411 24.4983 14 24.5ZM23.625 21H4.375C4.14298 20.9999 3.9205 20.9076 3.75644 20.7436C3.59237 20.5795 3.50014 20.357 3.5 20.125C3.50076 19.429 3.77757 18.7618 4.26969 18.2697C4.76181 17.7776 5.42904 17.5008 6.125 17.5H21.875C22.571 17.5008 23.2382 17.7776 23.7303 18.2697C24.2224 18.7618 24.4992 19.429 24.5 20.125C24.4999 20.357 24.4076 20.5795 24.2436 20.7436C24.0795 20.9076 23.857 20.9999 23.625 21Z" fill="{{$partnerdata["pri_color"]}}"/>
                                </svg>
                                <div class="pulse-css"></div>
                            </a>

                        </li>
                        <li class="nav-item dropdown notification_dropdown">
                            <a class="nav-link bell bell-link" href="{{route('showposts')}}">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.4605 3.84888H5.31688C4.64748 3.84961 4.00571 4.11586 3.53237 4.58919C3.05903 5.06253 2.79279 5.7043 2.79205 6.3737V18.1562C2.79279 18.8256 3.05903 19.4674 3.53237 19.9407C4.00571 20.4141 4.64748 20.6803 5.31688 20.6811C5.54005 20.6812 5.75404 20.7699 5.91184 20.9277C6.06964 21.0855 6.15836 21.2995 6.15849 21.5227V23.3168C6.15849 23.6215 6.24118 23.9204 6.39774 24.1818C6.5543 24.4431 6.77886 24.6571 7.04747 24.8009C7.31608 24.9446 7.61867 25.0128 7.92298 24.9981C8.22729 24.9834 8.52189 24.8863 8.77539 24.7173L14.6173 20.8224C14.7554 20.7299 14.918 20.6807 15.0842 20.6811H19.187C19.7383 20.68 20.2743 20.4994 20.7137 20.1664C21.1531 19.8335 21.4721 19.3664 21.6222 18.8359L24.8966 7.05011C24.9999 6.67481 25.0152 6.28074 24.9414 5.89856C24.8675 5.51637 24.7064 5.15639 24.4707 4.84663C24.235 4.53687 23.931 4.28568 23.5823 4.11263C23.2336 3.93957 22.8497 3.84931 22.4605 3.84888ZM23.2733 6.60304L20.0006 18.3847C19.95 18.5614 19.8432 18.7168 19.6964 18.8275C19.5496 18.9381 19.3708 18.9979 19.187 18.9978H15.0842C14.5856 18.9972 14.0981 19.1448 13.6837 19.4219L7.84171 23.3168V21.5227C7.84097 20.8533 7.57473 20.2115 7.10139 19.7382C6.62805 19.2648 5.98628 18.9986 5.31688 18.9978C5.09371 18.9977 4.87972 18.909 4.72192 18.7512C4.56412 18.5934 4.4754 18.3794 4.47527 18.1562V6.3737C4.4754 6.15054 4.56412 5.93655 4.72192 5.77874C4.87972 5.62094 5.09371 5.53223 5.31688 5.5321H22.4605C22.5905 5.53243 22.7188 5.56277 22.8353 5.62076C22.9517 5.67875 23.0532 5.76283 23.1318 5.86646C23.2105 5.97008 23.2642 6.09045 23.2887 6.21821C23.3132 6.34597 23.308 6.47766 23.2733 6.60304Z" fill="{{$partnerdata["pri_color"]}}"/>
                                    <path d="M7.84173 11.4233H12.0498C12.273 11.4233 12.4871 11.3347 12.6449 11.1768C12.8027 11.019 12.8914 10.8049 12.8914 10.5817C12.8914 10.3585 12.8027 10.1444 12.6449 9.98661C12.4871 9.82878 12.273 9.74011 12.0498 9.74011H7.84173C7.61852 9.74011 7.40446 9.82878 7.24662 9.98661C7.08879 10.1444 7.00012 10.3585 7.00012 10.5817C7.00012 10.8049 7.08879 11.019 7.24662 11.1768C7.40446 11.3347 7.61852 11.4233 7.84173 11.4233Z" fill="{{$partnerdata["pri_color"]}}"/>
                                    <path d="M15.4162 13.1066H7.84173C7.61852 13.1066 7.40446 13.1952 7.24662 13.3531C7.08879 13.5109 7.00012 13.725 7.00012 13.9482C7.00012 14.1714 7.08879 14.3855 7.24662 14.5433C7.40446 14.7011 7.61852 14.7898 7.84173 14.7898H15.4162C15.6394 14.7898 15.8535 14.7011 16.0113 14.5433C16.1692 14.3855 16.2578 14.1714 16.2578 13.9482C16.2578 13.725 16.1692 13.5109 16.0113 13.3531C15.8535 13.1952 15.6394 13.1066 15.4162 13.1066Z" fill="{{$partnerdata["pri_color"]}}"/>
                                </svg>
                                <div class="pulse-css"></div>
                            </a>
                        </li>
                        <li class="nav-item dropdown notification_dropdown">
                            <a class="nav-link" href="{{route('showrewards')}}" data-toggle="dropdown">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M23.625 6.12506H22.75V2.62506C22.75 2.47268 22.7102 2.32295 22.6345 2.19068C22.5589 2.05841 22.45 1.94819 22.3186 1.87093C22.1873 1.79367 22.0381 1.75205 21.8857 1.75019C21.7333 1.74832 21.5831 1.78629 21.4499 1.86031L14 5.99915L6.55007 1.86031C6.41688 1.78629 6.26667 1.74832 6.11431 1.75019C5.96194 1.75205 5.8127 1.79367 5.68136 1.87093C5.55002 1.94819 5.44113 2.05841 5.36547 2.19068C5.28981 2.32295 5.25001 2.47268 5.25 2.62506V6.12506H4.375C3.67904 6.12582 3.01181 6.40263 2.51969 6.89475C2.02757 7.38687 1.75076 8.0541 1.75 8.75006V11.3751C1.75076 12.071 2.02757 12.7383 2.51969 13.2304C3.01181 13.7225 3.67904 13.9993 4.375 14.0001H5.25V23.6251C5.25076 24.321 5.52757 24.9882 6.01969 25.4804C6.51181 25.9725 7.17904 26.2493 7.875 26.2501H20.125C20.821 26.2493 21.4882 25.9725 21.9803 25.4804C22.4724 24.9882 22.7492 24.321 22.75 23.6251V14.0001H23.625C24.321 13.9993 24.9882 13.7225 25.4803 13.2304C25.9724 12.7383 26.2492 12.071 26.25 11.3751V8.75006C26.2492 8.0541 25.9724 7.38687 25.4803 6.89475C24.9882 6.40263 24.321 6.12582 23.625 6.12506ZM21 6.12506H17.3769L21 4.11256V6.12506ZM7 4.11256L10.6231 6.12506H7V4.11256ZM7 23.6251V14.0001H13.125V24.5001H7.875C7.64303 24.4998 7.42064 24.4075 7.25661 24.2434C7.09258 24.0794 7.0003 23.857 7 23.6251ZM21 23.6251C20.9997 23.857 20.9074 24.0794 20.7434 24.2434C20.5794 24.4075 20.357 24.4998 20.125 24.5001H14.875V14.0001H21V23.6251ZM24.5 11.3751C24.4997 11.607 24.4074 11.8294 24.2434 11.9934C24.0794 12.1575 23.857 12.2498 23.625 12.2501H4.375C4.14303 12.2498 3.92064 12.1575 3.75661 11.9934C3.59258 11.8294 3.5003 11.607 3.5 11.3751V8.75006C3.5003 8.51809 3.59258 8.2957 3.75661 8.13167C3.92064 7.96764 4.14303 7.87536 4.375 7.87506H23.625C23.857 7.87536 24.0794 7.96764 24.2434 8.13167C24.4074 8.2957 24.4997 8.51809 24.5 8.75006V11.3751Z" fill="{{$partnerdata["pri_color"]}}"/>
                                </svg>
                                <div class="pulse-css"></div>
                            </a>

                        </li>
                        <li class="nav-item dropdown header-profile">
                            <a class="nav-link" href="javascript:void(0)" role="button" data-toggle="dropdown">
                                @if(is_null($userdata->profileurl) | $userdata->profileurl == "")
                                     <img  src="{{$partnerdata['logo']}}">

                                @else
                                    <img src="{{$partnerdata['logo']}}">

                                @endif
                                <div class="header-info">
                                    <span class="text-black"><strong>{{$userdata->firstname." ".$userdata->lastname}}</strong></span>
                                   

                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="#l" class="dropdown-item ai-icon">
                                    <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <span class="ml-2">Profile </span>
                                </a>
                                <a href="#" class="dropdown-item ai-icon">
                                    <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                    <span class="ml-2">Inbox </span>
                                </a>
                                <a  href="{{ route('logout') }}" onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();" class="dropdown-item ai-icon">
                                    <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                    <span class="ml-2">Logout </span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <!--**********************************
        Header end ti-comment-alt
    ***********************************-->

    <!--**********************************
        Sidebar start
    ***********************************-->
    <div class="deznav">
        <div class="deznav-scroll">
            <ul class="metismenu" id="menu">
                <li ><a class="ai-icon" href="{{route('dashboard')}}" aria-expanded="false">
                        <i class="flaticon-381-networking"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li><a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                        <i class="flaticon-381-user"></i>
                        <span class="nav-text">Members</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('addmember')}}">Add New Member</a></li>
                        <li><a href="{{route('showmembers')}}">Show Members</a></li>
                        <li><a href="{{route('assigngoals')}}">Assign Member Goal</a></li>
                     
                    </ul>
                </li>
                <li><a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                        <i class="flaticon-381-promotion"></i>
                        <span class="nav-text">Notification</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('compose')}}">Email</a></li>
                        <li><a href="{{route('sms')}}">Sms</a></li>
                       
                    </ul>
                </li>
                <li><a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                        <i class="flaticon-381-diamond"></i>
                        <span class="nav-text">Wellness Goals</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('addmastergoals')}}">Add Master Goals</a></li>
                        <li><a href="{{route('showgoals')}}">Show Goals</a></li>
                        <li><a href="#">Assign Goals</a></li>
                    </ul>
                </li>
                <li><a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                        <i class="flaticon-381-heart"></i>
                        <span class="nav-text">Wellness Plans</span>
                    </a>
                    <ul aria-expanded="false">

                            <li><a href="{{route('addplan')}}">Add Wellness Plan</a></li>
                            <li><a href="{{route('showplans')}}"> WellnessPlans List</a></li>

                    </ul>
                </li>
               <li><a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                            <i class="flaticon-381-heart"></i>
                            <span class="nav-text">NewsFeed</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('addpost')}}">Add Post</a></li>
                            <li><a href="{{route('showposts')}}">Show Posts</a></li>
                        </ul>
                    </li>
                <li><a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                        <i class="flaticon-381-gift"></i>
                        <span class="nav-text">Rewards </span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('showrewards')}}">Show All Rewards</a></li>
                        <li><a href="{{route('addreward')}}">Add New Reward </a></li>
                        <li><a href="{{route('rewardsallocation')}}">Rewards Allocation</a></li>
                        <li><a href="{{route('redeemed_rewards')}}">Redeemed Rewards </a></li>
                    </ul>
                </li>
                <li><a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa fa-shopping-basket"></i>
                        <span class="nav-text">Store Manager</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('showproduct')}}">Show All Products</a></li>
                        <li><a href="{{route('addproduct')}}">Add Product</a></li>
                    </ul>
                </li>
                <li><a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                        <i class="flaticon-381-layer-1"></i>
                        <span class="nav-text">Reports</span>
                    </a>
                    <ul aria-expanded="false">
                         <li><a href="{{route('memberreports')}}">Members</a></li>
                            <li><a href="{{route('activityreports')}}">Activities</a></li>
                            <li><a href="{{route('goalreports')}}">Target & Goals</a></li>
                            <li><a href="{{route('subscriptions')}}">Subscriptions</a></li>
                            <li><a href="{{route('newsfeedreport')}}">News Feeds</a></li>
                            <li><a href="{{route('rewardsreport')}}">Rewards</a></li>
                            <li><a href="{{route('activitylog')}}">System Active Log</a></li>
                    </ul>
                </li>
                <li><a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                        <i class="flaticon-381-settings-2"></i>
                        <span class="nav-text">Settings</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('general')}}">General</a></li>
                        <li><a href="#">User Management</a></li>
                        <li><a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Roles & Permissions</a>
                            <ul aria-expanded="false">
                                <li><a href="{{route('roles')}}">Add Role & Permission</a></li>

                            </ul>
                        </li>
                        <li><a href="#">API Integration</a></li>
                    </ul>
                </li>

            </ul>
            <a href="" target="_blank">
            <div class="add-menu-sidebar">

                <img src="{{ env('APP_URL') }}assets/admin/images/calendar.png" alt="" class="mr-3">
                <p class="	font-w500 mb-0">System User Manual</p>

            </div>
            </a>
            <div class="copyright">
                <p><strong>Pulse Health</strong> © 2021 All Rights Reserved</p>
            </div>
        </div>
    </div>
    <!--**********************************
        Sidebar end
    ***********************************-->

    <!--**********************************
        Content body start
    ***********************************-->
    <div class="content-body">
        <!-- row -->
        @yield('content')
    </div>
    <!--**********************************
        Content body end
    ***********************************-->

    <!--**********************************
        Footer start
    ***********************************-->
    <div class="footer">
        <div class="copyright">
            <p>Copyright © <a href="https://astroafrica.tech/" target="_blank">Astro Tech</a> 2021</p>
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
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script src="{{ env('APP_URL') }}assets/admin/vendor/global/global.min.js"></script>
<link rel="stylesheet" href="{{ env('APP_URL') }}assets/admin/vendor/chartist/css/chartist.min.css">
<script src="{{ env('APP_URL') }}assets/admin/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="{{ env('APP_URL') }}assets/admin/vendor/chart.js/Chart.bundle.min.js"></script>
<script src="{{ env('APP_URL') }}assets/admin/js/dashboard/workout-statistic.js"></script>
<script src="{{ env('APP_URL') }}assets/admin/js/custom.min.js"></script>
<script src="{{ env('APP_URL') }}assets/admin/js/deznav-init.js"></script>
<script src="{{ env('APP_URL') }}assets/admin/vendor/owl-carousel/owl.carousel.js"></script>
<script src="{{ env('APP_URL') }}assets/admin/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="{{ env('APP_URL') }}assets/admin/js/plugins-init/datatables.init.js"></script>
<script src="{{ env('APP_URL') }}assets/admin/vendor/morris/raphael-min.js"></script>
<script src="{{ env('APP_URL') }}assets/admin/vendor/morris/morris.min.js"></script>
<script src="{{ env('APP_URL') }}assets/admin/js/plugins-init/morris-init.js"></script>


<!-- Chart piety plugin files -->
<script src="{{ env('APP_URL') }}assets/admin/vendor/peity/jquery.peity.min.js"></script>

<!-- Apex Chart -->
<script src="{{ env('APP_URL') }}assets/admin/vendor/apexchart/apexchart.js"></script>

<!-- Dashboard 1 -->
<script src="{{ env('APP_URL') }}assets/admin/js/dashboard/dashboard-1.js"></script>

<script src="{{ env('APP_URL') }}assets/admin/js/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!--**********************************
    Scripts For DataTable Start Here!
***********************************-->
{{--<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>--}}
<script src="{{ env('APP_URL') }}assets/admin/js/datatable/dataTables.buttons.min.js"></script>
<script src="{{ env('APP_URL') }}assets/admin/vendor/chart.js/Chart.bundle.min.js"></script>
<script src="{{ env('APP_URL') }}assets/admin/js/plugins-init/chartjs-init.js"></script>
<script src="{{ env('APP_URL') }}assets/admin/vendor/chartist/js/chartist.min.js"></script>
<script src="{{ env('APP_URL') }}assets/admin/vendor/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js"></script>
<script src="{{ env('APP_URL') }}assets/admin/js/plugins-init/chartist-init.js"></script>



<script src="{{ env('APP_URL') }}assets/admin/js/datatable/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>


<!--**********************************
    Scripts For DataTable End Here!
***********************************-->

<script>
    function carouselReview(){
        /*  testimonial one function by = owl.carousel.js */
        jQuery('.testimonial-one').owlCarousel({
            loop:true,
            autoplay:true,
            margin:30,
            nav:false,
            dots: false,
            left:true,
            navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
            responsive:{
                0:{
                    items:1
                },
                484:{
                    items:2
                },
                882:{
                    items:3
                },
                1200:{
                    items:2
                },

                1540:{
                    items:3
                },
                1740:{
                    items:4
                }
            }
        })
    }
    jQuery(window).on('load',function(){
        setTimeout(function(){
            carouselReview();
        }, 1000);
    });
</script>


<script type="text/javascript">
    function deleteConfirmation(id, route, token, next) {
        swal({
            title: "Delete!",
            text: "You are about to delete a record",
            dangerMode: true,
            icon: "warning",
            buttons: true
        }).then(function (e) {
            if (e === true) {
                $.ajax({
                    type: 'POST',
                    url: route,
                    data: {_token: token},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: swal({
                        title: "Successfully Deleted",
                        text: "Record Successfully Deleted",
                        icon: "success",
                    }).then(function(e) {
                        window.location.href = next;
                    })
                })
            } else {
                e.dismiss;
            }
        }, function (dismiss) {
            return false;
        })
    }



</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>

</body>
</html>
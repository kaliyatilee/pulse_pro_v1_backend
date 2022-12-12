<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Pulse - Merchant Dashboard</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{$partnerdata["logo"]}}">
    <link rel="stylesheet" href="{{ env('APP_URL') }}assets/admin/vendor/chartist/css/chartist.min.css">
    <link href="{{ env('APP_URL') }}assets/admin/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="{{ env('APP_URL') }}assets/admin/vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link href="{{ env('APP_URL') }}assets/admin/css/style.css" rel="stylesheet">
    <link href="{{ env('APP_URL') }}assets/admin/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ env('APP_URL') }}assets/admin/vendor/chartist/css/chartist.min.css">
    <style>
        :root {
            --mainprimary: {
                    {
                    $partnerdata["pri_color"]
                }
            }

            ;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ env('APP_URL') }}assets/admin/css/styledash.css">

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
            <a href="{{ route('superAdminDashboard') }}" class="brand-logo">

                <img class="logo-abbr" src="{{$partnerdata["logo"]}}" alt="">
                <h1 style="color:{{$partnerdata["pri_color"]}} !important;" class="brand-title">{{$partnerdata["name"]}}</h1>

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
                            <div class="dashboard_bar">
                                Dashboard
                            </div>
                        </div>
                        <ul class="navbar-nav header-right">
                            <li class="nav-item">
                                <div class="input-group search-area d-xl-inline-flex d-none">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Search here...">
                                </div>
                            </li>
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link  ai-icon" href="javascript:void(0)" role="button" data-toggle="dropdown">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22.75 15.8385V13.0463C22.7471 10.8855 21.9385 8.80353 20.4821 7.20735C19.0258 5.61116 17.0264 4.61555 14.875 4.41516V2.625C14.875 2.39294 14.7828 2.17038 14.6187 2.00628C14.4546 1.84219 14.2321 1.75 14 1.75C13.7679 1.75 13.5454 1.84219 13.3813 2.00628C13.2172 2.17038 13.125 2.39294 13.125 2.625V4.41534C10.9736 4.61572 8.97429 5.61131 7.51794 7.20746C6.06159 8.80361 5.25291 10.8855 5.25 13.0463V15.8383C4.26257 16.0412 3.37529 16.5784 2.73774 17.3593C2.10019 18.1401 1.75134 19.1169 1.75 20.125C1.75076 20.821 2.02757 21.4882 2.51969 21.9803C3.01181 22.4724 3.67904 22.7492 4.375 22.75H9.71346C9.91521 23.738 10.452 24.6259 11.2331 25.2636C12.0142 25.9013 12.9916 26.2497 14 26.2497C15.0084 26.2497 15.9858 25.9013 16.7669 25.2636C17.548 24.6259 18.0848 23.738 18.2865 22.75H23.625C24.321 22.7492 24.9882 22.4724 25.4803 21.9803C25.9724 21.4882 26.2492 20.821 26.25 20.125C26.2486 19.117 25.8998 18.1402 25.2622 17.3594C24.6247 16.5786 23.7374 16.0414 22.75 15.8385ZM7 13.0463C7.00232 11.2113 7.73226 9.45223 9.02974 8.15474C10.3272 6.85726 12.0863 6.12732 13.9212 6.125H14.0788C15.9137 6.12732 17.6728 6.85726 18.9703 8.15474C20.2677 9.45223 20.9977 11.2113 21 13.0463V15.75H7V13.0463ZM14 24.5C13.4589 24.4983 12.9316 24.3292 12.4905 24.0159C12.0493 23.7026 11.716 23.2604 11.5363 22.75H16.4637C16.284 23.2604 15.9507 23.7026 15.5095 24.0159C15.0684 24.3292 14.5411 24.4983 14 24.5ZM23.625 21H4.375C4.14298 20.9999 3.9205 20.9076 3.75644 20.7436C3.59237 20.5795 3.50014 20.357 3.5 20.125C3.50076 19.429 3.77757 18.7618 4.26969 18.2697C4.76181 17.7776 5.42904 17.5008 6.125 17.5H21.875C22.571 17.5008 23.2382 17.7776 23.7303 18.2697C24.2224 18.7618 24.4992 19.429 24.5 20.125C24.4999 20.357 24.4076 20.5795 24.2436 20.7436C24.0795 20.9076 23.857 20.9999 23.625 21Z" fill="{{$partnerdata["pri_color"]}}" />
                                    </svg>
                                    <div class="pulse-css"></div>
                                </a>

                            </li>

                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link" href="javascript:void(0)" data-toggle="dropdown">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M23.625 6.12506H22.75V2.62506C22.75 2.47268 22.7102 2.32295 22.6345 2.19068C22.5589 2.05841 22.45 1.94819 22.3186 1.87093C22.1873 1.79367 22.0381 1.75205 21.8857 1.75019C21.7333 1.74832 21.5831 1.78629 21.4499 1.86031L14 5.99915L6.55007 1.86031C6.41688 1.78629 6.26667 1.74832 6.11431 1.75019C5.96194 1.75205 5.8127 1.79367 5.68136 1.87093C5.55002 1.94819 5.44113 2.05841 5.36547 2.19068C5.28981 2.32295 5.25001 2.47268 5.25 2.62506V6.12506H4.375C3.67904 6.12582 3.01181 6.40263 2.51969 6.89475C2.02757 7.38687 1.75076 8.0541 1.75 8.75006V11.3751C1.75076 12.071 2.02757 12.7383 2.51969 13.2304C3.01181 13.7225 3.67904 13.9993 4.375 14.0001H5.25V23.6251C5.25076 24.321 5.52757 24.9882 6.01969 25.4804C6.51181 25.9725 7.17904 26.2493 7.875 26.2501H20.125C20.821 26.2493 21.4882 25.9725 21.9803 25.4804C22.4724 24.9882 22.7492 24.321 22.75 23.6251V14.0001H23.625C24.321 13.9993 24.9882 13.7225 25.4803 13.2304C25.9724 12.7383 26.2492 12.071 26.25 11.3751V8.75006C26.2492 8.0541 25.9724 7.38687 25.4803 6.89475C24.9882 6.40263 24.321 6.12582 23.625 6.12506ZM21 6.12506H17.3769L21 4.11256V6.12506ZM7 4.11256L10.6231 6.12506H7V4.11256ZM7 23.6251V14.0001H13.125V24.5001H7.875C7.64303 24.4998 7.42064 24.4075 7.25661 24.2434C7.09258 24.0794 7.0003 23.857 7 23.6251ZM21 23.6251C20.9997 23.857 20.9074 24.0794 20.7434 24.2434C20.5794 24.4075 20.357 24.4998 20.125 24.5001H14.875V14.0001H21V23.6251ZM24.5 11.3751C24.4997 11.607 24.4074 11.8294 24.2434 11.9934C24.0794 12.1575 23.857 12.2498 23.625 12.2501H4.375C4.14303 12.2498 3.92064 12.1575 3.75661 11.9934C3.59258 11.8294 3.5003 11.607 3.5 11.3751V8.75006C3.5003 8.51809 3.59258 8.2957 3.75661 8.13167C3.92064 7.96764 4.14303 7.87536 4.375 7.87506H23.625C23.857 7.87536 24.0794 7.96764 24.2434 8.13167C24.4074 8.2957 24.4997 8.51809 24.5 8.75006V11.3751Z" fill="{{$partnerdata["pri_color"]}}" />
                                    </svg>
                                    <div class="pulse-css"></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right rounded">
                                    <div id="DZ_W_TimeLine11Home" class="widget-timeline dz-scroll style-1 p-3 height370 ps ps--active-y">

                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="javascript:void(0)" role="button" data-toggle="dropdown">
                                    @if(is_null($userdata->profileurl) | $userdata->profileurl == "")
                                    <img src="{{$userdata->profileurl}}" width="20" alt="" />

                                    @else
                                    <img src="{{$userdata->profileurl}}" width="20" alt="" />

                                    @endif
                                    <div class="header-info">
                                        <span class="text-black"><strong>{{$userdata->firstname." ".$userdata->lastname}}</strong></span>

                                        <p class="fs-12 mb-0">Admin</p>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#l" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <span class="ml-2">Profile </span>
                                    </a>
                                    <a href="#" class="dropdown-item ai-icon">
                                        <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                            <polyline points="22,6 12,13 2,6"></polyline>
                                        </svg>
                                        <span class="ml-2">Inbox </span>
                                    </a>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12"></line>
                                        </svg>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
                    <li><a class="ai-icon" href="{{route('superAdminDashboard')}}" aria-expanded="true">
                            <i class="flaticon-381-networking"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-381-heart"></i>
                            <span class="nav-text">Store Manager</span>
                        </a>
                        <ul aria-expanded="false">
                        <li><a href="{{route('productlist')}}">Show Productlist</a></li>
                            <li><a href="{{route('super_addproduct')}}">Add Product</a></li>
                            <!-- <li><a href="{{route('manageproducts')}}">Manage Products</a></li> -->

                        </ul>
                    </li>
                    
                </ul>
               
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
    <script src="{{ env('APP_URL') }}assets/admin/vendor/global/global.min.js"></script>
    <script src="{{ env('APP_URL') }}assets/admin/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="{{ env('APP_URL') }}assets/admin/vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="{{ env('APP_URL') }}assets/admin/js/custom.min.js"></script>
    <script src="{{ env('APP_URL') }}assets/admin/js/deznav-init.js"></script>
    <script src="{{ env('APP_URL') }}assets/admin/vendor/owl-carousel/owl.carousel.js"></script>
    <script src="{{ env('APP_URL') }}assets/admin/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="{{ env('APP_URL') }}assets/admin/js/plugins-init/datatables.init.js"></script>


    <!-- Chart piety plugin files -->
    <script src="{{ env('APP_URL') }}assets/admin/vendor/peity/jquery.peity.min.js"></script>

    <!-- Apex Chart -->
    <script src="{{ env('APP_URL') }}assets/admin/vendor/apexchart/apexchart.js"></script>

    <!-- Dashboard 1 -->
    <script src="{{ env('APP_URL') }}assets/admin/js/dashboard/dashboard-1.js"></script>
    <script src="{{ env('APP_URL') }}assets/admin/js/dashboard/workout-statistic.js"></script>

    <script>
        function carouselReview() {
            /*  testimonial one function by = owl.carousel.js */
            jQuery('.testimonial-one').owlCarousel({
                loop: true,
                autoplay: true,
                margin: 30,
                nav: false,
                dots: false,
                left: true,
                navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
                responsive: {
                    0: {
                        items: 1
                    },
                    484: {
                        items: 2
                    },
                    882: {
                        items: 3
                    },
                    1200: {
                        items: 2
                    },

                    1540: {
                        items: 3
                    },
                    1740: {
                        items: 4
                    }
                }
            })
        }
        jQuery(window).on('load', function() {
            setTimeout(function() {
                carouselReview();
            }, 1000);
        });
    </script>
</body>

</html>
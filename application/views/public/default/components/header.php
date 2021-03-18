<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=9">
    <meta name="description" content="Edubrain Olympiad">
    <meta name="author" content="Edubrain Olympiad">
    <title><?php print ucwords($this->config->item('app_name'));?> </title>

    <!-- Favicon Icon -->
    <link rel="icon" type="image/png" href="<?php print $this->RES_ROOT;?>images/fav.png">

    <!-- Stylesheets -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet'>

    <!--====== Bootstrap css ======-->
    <link href="<?php print $this->RES_ROOT;?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!--====== Animate css ======-->
    <link rel="stylesheet" href="<?php print $this->RES_ROOT;?>edubrain/css/animate.css">

    <!--====== Fontawesome css ======-->
    <link href="<?php print $this->RES_ROOT;?>vendor/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!--====== Magnific Popup css ======-->
    <link rel="stylesheet" href="<?php print $this->RES_ROOT;?>edubrain/css/magnific-popup.css">

    <!--====== Nice Select css ======-->
    <link rel="stylesheet" href="<?php print $this->RES_ROOT;?>edubrain/css/nice-select.css">

    <!--====== Slick css ======-->
    <link rel="stylesheet" href="<?php print $this->RES_ROOT;?>edubrain/css/slick.css">

    <!--====== Default css ======-->
    <link rel="stylesheet" href="<?php print $this->RES_ROOT;?>edubrain/css/default.css">

    <!--====== Style css ======-->
    <link rel="stylesheet" href="<?php print $this->RES_ROOT;?>edubrain/css/style.css">

    <!--====== Responsive css ======-->
    <link rel="stylesheet" href="<?php print $this->RES_ROOT;?>edubrain/css/responsive.css">

</head>

<body>

    <!--====== PRELOADER PART START ======-->

    <div id="preloader">
        <div class="preloader">
            <span></span>
            <span></span>
        </div>
    </div>

    <!--====== PRELOADER PART ENDS ======-->

    <!--====== Header PART START ======-->

    <section class="header_area">
        <div class="header_top">
            <div class="container">
                <div class="header_top_wrapper d-flex justify-content-center justify-content-md-between">
                    <div class="header_top_info d-none d-md-block">
                        <ul>
                            <li><img src="<?php echo $this->RES_ROOT; ?>edubrain/images/call.png" alt="call"><a
                                    href="#">+91
                                    9821-778-808</a></li>
                            <li><img src="<?php echo $this->RES_ROOT; ?>edubrain/images/mail.png" alt="mail"><a
                                    href="#">info@edubrainolympiad.com</a></li>
                        </ul>
                    </div>
                    <div class="header_top_login">
                        <ul>
                            <li><a href="#">Create An Account</a></li>
                            <li><a class="main-btn" href="#"><i class="fa fa-user-o"></i> Log In</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="header_menu">
            <div class="container">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand" href="index.html">
                        <img src="<?php echo $this->RES_ROOT; ?>edubrain/images/edubrain_logo.png" alt="logo"
                            width="100">
                    </a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="toggler-icon"></span>
                        <span class="toggler-icon"></span>
                        <span class="toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                        <ul class="navbar-nav m-auto">
                            <!--
                            <li>
                                <a class="active" href="index.html">Home <i class="fa fa-chevron-down"></i></a>
                                
                                <ul class="sub-menu">
                                    <li><a class="active" href="index.html">Home 01</a></li>
                                    <li><a href="index-2.html">Home 02</a></li>
                                    <li><a href="index-3.html">Home 03</a></li>
                                    <li><a href="index-4.html">Home 04</a></li>
                                </ul>
                            </li>
-->

                            <li><a class="active" href="index.html">Home</a></li>
                            <li>
                                <a href="about.html">About</a>
                            </li>
                            <li>
                                <a href="courses.html">Olympiads <i class="fa fa-chevron-down"></i></a>

                                <ul class="sub-menu">
                                    <li><a href="#">Olympiad 1</a></li>
                                    <li><a href="#">Olympiad 2</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="blog.html">More Links <i class="fa fa-chevron-down"></i></a>

                                <ul class="sub-menu">
                                    <li><a href="#">Olympiad Dates</a></li>
                                    <li><a href="#">Gallery</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Contact</a>
                            </li>
                        </ul>
                    </div>

                    <div class="navbar_meta">
                        <ul>
                            <li>
                                <a id="search" href="#"><img
                                        src="<?php echo $this->RES_ROOT; ?>edubrain/images/search.png" alt="search"></a>
                                <div class="search_bar">
                                    <input type="text" placeholder="Search">
                                    <button><i class="fa fa-search"></i></button>
                                </div>
                            </li>
                            <!--                             <li><a href="#"><img src="assets/images/cart.png" alt="cart"> <span>0</span></a></li> -->
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </section>

    <!--====== Header PART ENDS ======-->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="author" content="TechyDevs">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>AskMyBrands - Social Questions and Answers</title>

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" sizes="16x16" href="images\favicon.png">

    <!-- inject:css -->
    <link rel="stylesheet" href="vendors/fontawesome-pro-5/css/all.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/line-awesome.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="css/leaflet.css">
    <link rel="stylesheet" href="css/chosen.min.css">
    <link rel="stylesheet" href="css/jquery-te-1.4.0.css">
    <link rel="stylesheet" href="css/tagsinput.css">
    <link rel="stylesheet" href="css/upvotejs.min.css">
    <link rel="stylesheet" href="css/intlTelInput.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css">



    <style>
    @media only screen and (max-width: 1200px) {
        .logo {
    width: 60%;
  }
}
    </style>


    <!-- end inject -->

</head>

<body>

    <!-- start cssload-loader -->
    <!-- <div id="preloader">
        <div class="loader">
            <svg class="spinner" viewbox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>
        </div>
    </div> -->
    <!-- end cssload-loader -->

    <!--======================================
        START HEADER AREA
    ======================================-->
    <header class="header-area bg-dark">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-2">
                    <div class="logo-box">
                        <a href="index.php" class="logo"><img class="logo-img" src="images\logo-white.png" alt="logo"></a>
                        <div class="user-action">
                            <div class="search-menu-toggle icon-element icon-element-xs shadow-sm mr-1"
                                data-toggle="tooltip" data-placement="top" title="Search">
                                <i class="la la-search"></i>
                            </div>
                            <div class="off-canvas-menu-toggle icon-element icon-element-xs shadow-sm"
                                data-toggle="tooltip" data-placement="top" title="Main menu">
                                <i class="la la-bars"></i>
                            </div>
                        </div>
                    </div>
                </div><!-- end col-lg-2 -->
                <div class="col-lg-10">
                    <div class="menu-wrapper">
                        <nav class="menu-bar mr-auto  menu-bar-white">
                            <ul>
                                <li>
                                    <a href="index.php">Home</a>
                                </li>
                                <li>
                                    <a href="posts.php">Posts</a>
                                </li>
       
                            </ul><!-- end ul -->
                        </nav><!-- end main-menu -->
                        <form action="posts.php" method="get" class="mr-4">
                            <div class="form-group mb-0">
                                <input class="form-control form--control form--control-bg-gray text-white" type="text"
                                name="search" placeholder="Type your search words...">
                                <button class="form-btn text-white-50"><i type="submit" class="la la-search"></i></button>
                            </div>
                        </form>
                        <div class="nav-right-button">
                            <?php if(isset($_SESSION["Userid"])) {
                                ?>
                            <a href="user-profile.php" class="btn theme-btn theme-btn-outline theme-btn-outline-white mr-2"><i class="la la-sign-in mr-1"></i> Dashboard</a>
                            <a href="logout.php" class="btn theme-btn theme-btn-white"><i class="la la-user mr-1"></i> Logout</a>
                                <?php
                            } elseif(isset($_SESSION["adminUserid"])){
                                ?>
                            <a href="login.php" class="btn theme-btn theme-btn-outline theme-btn-outline-white mr-2"><i class="la la-sign-in mr-1"></i> Dashboard</a>
                            <a href="logout.php" class="btn theme-btn theme-btn-white"><i class="la la-user mr-1"></i> Logout</a>
                                <?php
                            } else {
                                ?>
                            <a href="login.php" class="btn theme-btn theme-btn-outline theme-btn-outline-white mr-2"><i class="la la-sign-in mr-1"></i> Login</a>
                            <a href="signup.php" class="btn theme-btn theme-btn-white"><i class="la la-user mr-1"></i> Sign up</a>
                                <?php
                            } ?>
                            
                        </div><!-- end nav-right-button -->
                    </div><!-- end menu-wrapper -->
                </div><!-- end col-lg-10 -->
            </div><!-- end row -->
        </div><!-- end container -->
        <div class="off-canvas-menu custom-scrollbar-styled">
            <div class="off-canvas-menu-close icon-element icon-element-sm shadow-sm" data-toggle="tooltip"
                data-placement="left" title="Close menu">
                <i class="la la-times"></i>
            </div><!-- end off-canvas-menu-close -->
            <ul class="generic-list-item off-canvas-menu-list pt-90px">
                        <li>
                            <a href="index.php">Home</a>
                        </li>
                        <li>
                            <a href="posts.php">Posts</a>
                        </li>
            </ul>
            <div class="off-canvas-btn-box px-4 pt-5 text-center">

                             <?php if(isset($_SESSION["Userid"])) {
                                ?>
                            <a href="user-profile.php" class="btn theme-btn theme-btn-sm theme-btn-outline"><i class="la la-sign-in mr-1"></i> Dashboard</a>
                            <a href="logout.php" class="btn theme-btn theme-btn-white"><i class="la la-user mr-1"></i> Logout</a>
                                <?php
                            } elseif(isset($_SESSION["adminUserid"])){
                                ?>
                            <a href="login.php" class="btn theme-btn theme-btn-sm theme-btn-outline"><i class="la la-sign-in mr-1"></i> Dashboard</a>
                            <a href="logout.php" class="btn theme-btn theme-btn-white"><i class="la la-user mr-1"></i> Logout</a>
                                <?php
                            } else {
                                ?>
                            <a href="login.php" class="btn theme-btn theme-btn-sm theme-btn-outline"><i class="la la-sign-in mr-1"></i> Login</a>
                            <a href="signup.php" class="btn theme-btn theme-btn-white"><i class="la la-user mr-1"></i> Sign up</a>
                                <?php
                            } ?>

            </div>
        </div><!-- end off-canvas-menu -->
        <div class="mobile-search-form">
            <div class="d-flex align-items-center">
                <form action="posts.php" method="get" class="flex-grow-1 mr-3">
                    <div class="form-group mb-0">
                        <input class="form-control form--control pl-40px" type="text" name="search"
                            placeholder="Type your search words...">
                        <span class="la la-search input-icon"></span>
                    </div>
                </form>
                <div class="search-bar-close icon-element icon-element-sm shadow-sm">
                    <i class="la la-times"></i>
                </div><!-- end off-canvas-menu-close -->
            </div>
        </div><!-- end mobile-search-form -->
        <div class="body-overlay"></div>
    </header><!-- end header-area -->
    <!--======================================
        END HEADER AREA
======================================-->

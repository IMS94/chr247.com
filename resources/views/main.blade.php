<!doctype html>
<html class="no-js" lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- ========== VIEWPORT META ========== -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

    <!-- ========== PAGE TITLE ========== -->
    <title>chr247.com</title>

    <!-- ========== META TAGS ========== -->
    <meta name="description" content="Cloud based health records management system">
    <meta name="keywords" content="emr, his, health informatics, health cloud, cloud health records">
    <meta name="author" content="chr247.com">

    <!-- ========== FAVICON & APPLE ICONS ========== -->
    <link rel="shortcut" href="{{asset('favicon.ico')}}"/>
    <link rel="apple-touch-icon" href="{{asset('FrontTheme/images/apple-touch-icon.png')}}">

    <!-- ========== MINIFIED VENDOR CSS ========== -->
    <link rel="stylesheet" href="{{asset('FrontTheme/styles/vendor.css')}}">
    <link rel="stylesheet" href="{{asset('FrontTheme/styles/main.css')}}">

    <!-- ========== MODERNIZR ========== -->
    <script src="{{asset('FrontTheme/scripts/vendor/modernizr.js')}}"></script>
</head>

<!-- ========== BODY ==========
.light-header: for light colored header
.dark-header: for dark colored header
==========  ========== -->
<body class="light-header animsition">

<!-- ========== NAVIGATION ========== -->
<nav class="navbar yamm navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button> <!-- end navbar-toggle -->
            <a class="navbar-brand" href="{{url('/')}}">
                <img src="{{asset('logo-white.png')}}" alt="CHR 24x7" style="width: 200px;height: 200px;"
                     class="light-logo img-responsive">
                <img src="{{asset('logo.png')}}" alt="CHR 24x7" style="width: 50px;height: 50px;"
                     class="dark-logo">
            </a> <!-- end navbar-brand -->
        </div> <!-- end navbar-header -->

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav pull-right">
                <li class="active dropdown">
                    <a href="{{url('/')}}" class="dropdown-toggle" data-toggle="dropdown" role="button">Home </a>
                </li>
                <li class="nav-btn-wrap">
                    <span class="nav-btn">
                        <a href="{{url('login')}}" class="btn se-btn-black btn-rounded">Sign In</a>
                    </span>
                </li>
            </ul> <!-- end navbar-nav -->

        </div> <!--end nav-collapse -->
    </div> <!-- end container -->
</nav>

<!-- ========== HEADER ========== -->
<header class="header main-header header-style-2" id="header-animated">
    <div class="primary-trans-bg">
        <div class="container">
            <!-- For centering the content vertically -->
            <div class="outer">
                <div class="inner text-center">
                    <h1 class="white-color">The simplest Health Informatics System on the Cloud.</h1>
                    <h5 class="">Cloud Health Records 24 x 7.</h5>
                    <a href="{{route('registerClinic')}}" class="btn se-btn-white btn-rounded">Sign up for free!</a>
                </div> <!-- end inner -->
            </div> <!-- end outer -->
        </div> <!-- end container -->
    </div> <!-- end primary-trans-bg -->
</header>

<!-- ========== FEATURES ========== -->
<section class="se-section features-section">
    <div class="container">
        <div class="row">

            <div class="col-md-3 col-sm-6 se-feature">
                <i class="icon ion-earth"></i>
                <h5>100% Free!</h5>
                <p>Enjoy all the basic functions for free, with the latest technologies in-built.</p>
            </div> <!-- end se-feature -->

            <div class="col-md-3 col-sm-6 se-feature">
                <i class="icon ion-document-text"></i>
                <h5>ZERO-Paper Policy</h5>
                <p>No more messy and lost paper records. Enjoy a paper free experience.</p>
            </div> <!-- end se-feature -->

            <div class="col-md-3 col-sm-6 se-feature">
                <i class="icon ion-settings"></i>
                <h5>Easy To Set-Up</h5>
                <p>No more in-house servers and complex IT work.</p>
            </div> <!-- end se-feature -->

            <div class="col-md-3 col-sm-6 se-feature">
                <i class="icon ion-cloud"></i>
                <h5>Cloud Technology</h5>
                <p>Access your records anytime, anywhere.</p>
            </div> <!-- end se-feature -->

        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
{{--

<!-- ========== SINGLE FEATURE SECTION ========== -->
<section class="se-section single-feature">

    <div class="col-md-6 zero-padding col-md-push-6 side-img">
        <img src="http://placehold.it/1600x1000?text=SoftEase" alt="" class="img-responsive">
    </div> <!-- end side-img -->

    <div class="container feature-desc">
        <div class="row">
            <div class="col-md-5 feature-info">
                <h2>The InfiniBoard™</h2>
                <p>The Comprehensive dashboard which gives you all the vital information at a glance.

                </p>
                <p>We are working hard to simplify the system further more to give you the best user experience for
                    health records management.</p>
                <a href="#" class="btn se-btn btn-rounded">Learn More</a>
            </div>

        </div> <!-- end row -->
    </div> <!-- end container -->

</section>

<!-- ========== SINGLE FEATURE SECTION ========== -->
<section class="se-section single-feature">

    <div class="col-md-6 zero-padding side-img">
        <img src="http://placehold.it/1600x1000?text=SoftEase" alt="" class="img-responsive">
    </div> <!-- end side-img -->

    <div class="container feature-desc">
        <div class="row">
            <div class="col-md-5 col-md-push-7 feature-info">
                <h2>InfiniSearch™</h2>
                <p>The global search facility which allows the users to serach the entier patients & drug database at an
                    instance.</p>
                <p>Our engineering are working puting an extra effort to create a highly sophisticated search facility
                    which would not slow down by the time your organisation has millions of records to handle.</p>
                <a href="#" class="btn se-btn btn-rounded">Learn More</a>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
--}}

<!-- ========== STEPS ========== -->
<section class="se-section se-steps">
    <div class="container">
        <div class="row text-center">
            <h3 class="underline mtn">It's as ease as 1 - 2 - 3!</h3>
        </div> <!-- end row -->

        <div class="row">
            <div class="col-md-4 col-sm-4 one-step">
                <h4>Sign Up</h4>
                <p>Let us know few information about your organisation. Will take care of the rest.</p>
            </div>

            <div class="col-md-4 col-sm-4 one-step">
                <h4>Add Users</h4>
                <p>Add Doctors & Nurses using the "settings" page on your dashboard.</p>
            </div>

            <div class="col-md-4 col-sm-4 one-step">
                <h4>Login & enjoy</h4>
                <p>Simply login and start using the system.</p>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>

<!-- ========== FEATURES ========== -->
<section class="se-section features-section parallax-bg" data-parallax="scroll"
         data-image-src="{{asset('FrontTheme/images/bg-img-3.jpg')}}"
         data-speed="0.4">
    <div class="black-gradient">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 se-feature-style-2 mb60">
                    <div class="left">
                        <i class="icon ion-ios-monitor-outline"></i>
                    </div>
                    <div class="right">
                        <h5>Work on any device</h5>
                        <p>The system will work on any device which has a web-browser and an internet conection.</p>
                    </div>
                </div> <!-- end se-feature -->

                <div class="col-md-6 col-sm-6 se-feature-style-2 mb60">
                    <div class="left">
                        <i class="icon ion-ios-infinite-outline"></i>
                    </div>
                    <div class="right">
                        <h5>Updates for lifetime</h5>
                        <p>All of the updates to the system will be avilable to all the users as soon as it's
                            released.</p>
                    </div>
                </div> <!-- end se-feature -->

                <div class="col-md-6 col-sm-6 se-feature-style-2 mb60">
                    <div class="left">
                        <i class="icon ion-ios-bolt-outline"></i>
                    </div>
                    <div class="right">
                        <h5>Lightning Fast</h5>
                        <p>The system will be always lightning fast as it runs on a industrial grade cloud-server.</p>
                    </div>
                </div> <!-- end se-feature -->

                <div class="col-md-6 col-sm-6 se-feature-style-2 mb60">
                    <div class="left">
                        <i class="icon ion-ios-paper-outline"></i>
                    </div>
                    <div class="right">
                        <h5>Compact documantation</h5>
                        <p>The documatation is a cook-book for the entier system which will be useful for begginers and
                            advanced users.</p>
                    </div>
                </div> <!-- end se-feature -->

                <div class="col-md-6 col-sm-6 se-feature-style-2">
                    <div class="left">
                        <i class="icon ion-ios-checkmark-empty"></i>
                    </div>
                    <div class="right">
                        <h5>Light Weight</h5>
                        <p>The system uses a very little amount of bandwith as it's optimised to work under low bandwith
                            networks.</p>
                    </div>
                </div> <!-- end se-feature -->

                <div class="col-md-6 col-sm-6 se-feature-style-2">
                    <div class="left">
                        <i class="icon ion-ios-world-outline"></i>
                    </div>
                    <div class="right">
                        <h5>Multi-lingual support</h5>
                        <p>ආයුබෝවන් ~ 你好 ~ Привіт
                        </p>
                    </div>
                </div> <!-- end se-feature -->

            </div> <!-- end row -->
        </div> <!-- end container -->
    </div> <!-- end black-gradient -->
</section> <!-- end features-section -->

<!-- ========== CTA SECTION ========== -->
<section class="se-section primary-bg">
    <div class="container">
        <div class="row text-center">
            <h3>Create Your Account Now!</h3>
            <p>Basic features 100% free.</p>
            <a href="{{route('registerClinic')}}" class="btn se-btn-black btn-rounded">SIGN UP</a>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>

<!-- ========== FOOTER ========== -->
<footer class="light-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-sm-3 col-xs-6">
                <img src="{{asset('FrontTheme/images/logo.png')}}" alt="" class="footer-logo img-responsive">
            </div>

            <div class="col-md-2 col-sm-3 col-xs-6">
                <h6 class="mtn">HOME</h6>
                <ul>
                    <li><a href="#">Parallax Background</a></li>
                </ul>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-6">
                <h6 class="mtn">PAGES</h6>
                <ul>
                    <li><a href="#">About Us</a></li>
                </ul>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-6">
                <h6 class="mtn">OTHER</h6>
                <ul>
                    <li><a href="{{route('registerClinic')}}">Sign Up</a></li>
                    <li><a href="{{url('login')}}">Login</a></li>
                </ul>
            </div>

            <div class="col-md-4 col-sm-8 col-sm-offset-2 col-md-offset-0">
                <h6 class="mtn">SUBSCRIBE</h6>
                <div class="input-group">
                    <input type="email" class="form-control inp-rounded" placeholder="Enter your email id">
                            <span class="input-group-btn">
                                <button class="btn se-btn btn-rounded" type="button">Subscribe!</button>
                            </span> <!-- end input-group-btn -->
                </div><!-- end input-group -->
                <p class="text-center text-muted">We don't spam!</p>
            </div>
        </div> <!-- end row -->

        <div class="row footer-bottom">
            <div class="col-md-6">
                <p>Copyright &copy; chr247.com. 2016. All Rights Reserved.</p>
            </div>

            <div class="col-md-6 text-right">
                <h6><a href="#">FACEBOOK</a></h6>
                <h6><a href="#">TWITTER</a></h6>
                <h6><a href="#">LINKEDIN</a></h6>
                <h6><a href="#">GOOGLE PLUS</a></h6>
            </div>
        </div> <!-- end footer-bottom -->
    </div> <!-- end container -->
</footer>


<script src="{{asset('FrontTheme/scripts/vendor.js')}}"></script>

<!-- ========== MINIFIED PLUGINS JS ========== -->
<script src="{{asset('FrontTheme/scripts/plugins.js')}}"></script>

<script src="{{asset('FrontTheme/scripts/main.js')}}"></script>

<script src="{{asset('FrontTheme/scripts/init-animation.js')}}"></script>
</body>

</html>
<!doctype html>
<html class="no-js" lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- ========== VIEWPORT META ========== -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

    <!-- ========== PAGE TITLE ========== -->
    <title>chr247.com | Cloud Health Records 24x7</title>

    <meta name="description"
          content="The simplest Health Informatics System on the Cloud. For small scale clinics.
          100% Free! ZERO-Paper Policy!">
    <meta name="keywords"
          content="emr, his, health informatics, health cloud, cloud health records, clinic, patient management">
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
<body class="@if(Request::url()===url('/')) light-header @else dark-header @endif animsition">

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
                <img src="{{asset('logo-white.png')}}" alt="CHR 24x7" style="width: 150px;height: 150px;"
                     class="light-logo img-responsive">
                <img src="{{asset('logo.png')}}" alt="CHR 24x7" style="width: 50px;height: 50px;"
                     class="dark-logo">
            </a> <!-- end navbar-brand -->
        </div> <!-- end navbar-header -->

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav pull-right">
                <li>
                    <a href="{{url('/')}}">Home </a>
                </li>
                <li>
                    <a href="{{url('/web/features')}}">Features</a>
                </li>
                <li><a href="{{url('web/aboutUs')}}">About Us</a></li>
                <li class="nav-btn-wrap">
                    <span class="nav-btn">
                        <a href="{{url('login')}}" class="btn se-btn-black btn-rounded">Sign In</a>
                    </span>
                </li>
            </ul> <!-- end navbar-nav -->

        </div> <!--end nav-collapse -->
    </div> <!-- end container -->
</nav>

@yield("content")
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
                <img src="{{asset('FrontTheme/images/logo.png')}}" alt="chr247.com | Cloud Health Records 24x7"
                     class="footer-logo img-responsive">
            </div>

            <div class="col-md-2 col-sm-3 col-xs-6">
                <h6 class="mtn">HOME</h6>
                <ul>
                    <li><a href="{{url("/")}}">Home</a></li>
                </ul>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-6">
                <h6 class="mtn">PAGES</h6>
                <ul>
                    <li>
                        <a href="{{url('/web/features')}}">Features</a>
                    </li>
                    <li><a href="{{url('web/aboutUs')}}">About Us</a></li>
                </ul>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-6">
                <h6 class="mtn">OTHER</h6>
                <ul>
                    <li><a href="{{route('registerClinic')}}">Register Now</a></li>
                    <li><a href="{{url('login')}}">Login</a></li>
                </ul>
            </div>

            <div class="col-md-4 col-sm-8 col-sm-offset-2 col-md-offset-0">
                <h6 class="mtn">CONTACT US</h6>
                <ul>
                    <li><a href="mailto: support@chr247.com">support@chr247.com</a></li>
                </ul>
            </div>
        </div> <!-- end row -->

        <div class="row footer-bottom">
            <div class="col-md-6">
                <p>Copyright &copy; chr247.com. 2016. All Rights Reserved.</p>
            </div>

            <div class="col-md-6 text-right">
                <h6><a href="https://www.facebook.com/cloudhealthrecords247">FACEBOOK</a></h6>
                <h6><a href="https://twitter.com/chr247_">TWITTER</a></h6>
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

{{-- Google Analytics --}}
@include('analytics.googleAnalytics')

</body>

</html>
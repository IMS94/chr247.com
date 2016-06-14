<!DOCTYPE HTML>
<html>
<head>
    <title>CHR247</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="shortcut" href="{{asset('favicon.ico')}}"/>
    <!--[if lte IE 8]>
    <script src="{{asset('templated-typify/assets/js/ie/html5shiv.js')}}"></script><![endif]-->
    <link rel="stylesheet" href="{{asset('templated-typify/assets/css/main.css')}}"/>

    {{--Animate.css--}}
    <link href="{{asset('plugins/wowjs/animate.css')}}" rel="stylesheet">

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="{{asset('templated-typify/assets/css/ie9.css')}}"/><![endif]-->
</head>
<style>
    .center-block {
        display: block;
        margin-right: auto;
        margin-left: auto;
    }

    #chrLogo {
        position: absolute;
        z-index: 1000;
    }

    @media (min-width: 768px) and (max-width: 991px) {
        .hidden-sm {
            display: none !important;
        }
    }

    @media (max-width: 767px) {
        .hidden-xs {
            display: none !important;
        }
    }

    @media (min-width: 992px) and (max-width: 1199px) {
        .hidden-md {
            display: none !important;
        }
    }
</style>

<body>

<section id="logo" class="hidden-md hidden-md hidden-xs hidden-sm wow rotateIn" data-wow-delay="2s">
    <div class="inner narrow">
        <img id="chrLogo" src="{{asset('logo.png')}}" class="img-responsive center-block">
    </div>
</section>

<!-- Banner -->
<section id="banner" class="wow zoomIn" data-wow-duration="2s">
    <h2><strong>"CHR247"</strong> <br> Cloud Health Records</h2>
    <p>The most simple, user friendly, easy to use medical records system.<br>100% free</p>
    <ul class="actions">
        <li><a href="{{url('login')}}" class="button special">Login</a></li>
        <li><a href="{{route('registerClinic')}}" class="button special">Register Now</a></li>
    </ul>
</section>

<!-- One -->
<section id="one" class="wrapper special wow fadeInDown" data-wow-duration="2s">
    <div class="inner">
        <header class="major">
            <h2>Features</h2>
        </header>
        <div class="features wow">
            <div class="feature">
                <i class="fa fa-smile-o"></i>
                <h3>100% Free!</h3>
                <p>Enjoy all the basic functions for free.</p>
            </div>
            <div class="feature">
                <i class="fa fa-graduation-cap"></i>
                <h3>Easy to learn</h3>
                <p>Minalaistic desingn and tiny learning curve.</p>
            </div>
            <div class="feature">
                <i class="fa fa-cogs"></i>
                <h3>Easy set-up</h3>
                <p>No more in-house servers and complex IT work.</p>
            </div>
            <div class="feature">
                <i class="fa fa-cloud"></i>
                <h3>Centralised cloud technology</h3>
                <p>Access your records anytime, anywhere.</p>
            </div>
            <div class="feature">
                <i class="fa fa-file-text"></i>
                <h3>Zero-paper policy</h3>
                <p>No more messy and lost paper records.</p>
            </div>
        </div>
    </div>
</section>

<!-- Two -->
<section id="two" class="wrapper style2 special wow fadeInDown" data-wow-duration="2s">
    <div class="inner narrow">
        <header>
            <h2>Get in touch</h2>
        </header>
        <form class="grid-form" method="post" action="#">
            <div class="form-control narrow">
                <label for="name">Name</label>
                <input name="name" id="name" type="text">
            </div>
            <div class="form-control narrow">
                <label for="email">Email</label>
                <input name="email" id="email" type="email">
            </div>
            <div class="form-control">
                <label for="message">Message</label>
                <textarea name="message" id="message" rows="4"></textarea>
            </div>
            <ul class="actions">
                <li><input value="Send Message" type="submit"></li>
            </ul>
        </form>
    </div>
</section>

<!-- Footer -->
<footer id="footer">
    <div class="copyright">
        &copy; chr247.com: <a href="#">CMR247</a>.
    </div>
</footer>

<!-- Scripts -->
<script src="{{asset('templated-typify/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('templated-typify/assets/js/skel.min.js')}}"></script>
<script src="{{asset('templated-typify/assets/js/util.js')}}"></script>
<!--[if lte IE 8]>
<script src="{{asset('templated-typify/assets/js/ie/respond.min.js')}}"></script><![endif]-->
<script src="{{asset('templated-typify/assets/js/main.js')}}"></script>
<script src="{{asset('plugins/wowjs/wow.min.js')}}"></script>
<script>
    $(document).ready(function () {
        new WOW().init();
    });
</script>

</body>
</html>
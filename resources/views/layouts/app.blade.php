<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @yield('title',"CHR247 | Cloud Health Records 24x7")
    </title>

    <meta name="description"
          content="The simplest Health Informatics System on the Cloud. For small scale clinics.
          100% Free! ZERO-Paper Policy!">
    <meta name="keywords"
          content="emr, his, health informatics, health cloud, cloud health records, clinic, patient management">
    <meta name="author" content="chr247.com">

    <link rel="shortcut" href="favicon.ico"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
    <!-- Custom styles -->
    <link rel="stylesheet" href="{{asset('dist/css/style.css')}}">

    <!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('dist/css/skins/_all-skins.min.css')}}">

    {{--Animate.css--}}
    <link href="{{asset('plugins/wowjs/animate.css')}}" rel="stylesheet">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('plugins/iCheck/square/blue.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

    <header class="main-header">
        <nav class="navbar navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <div class="row">
                        <a href="{{url('/')}}" class="navbar-brand">
                            <b>CHR 24x7 - Cloud Health Records</b>
                            <small>Beta</small>
                        </a>
                    </div>
                </div>

                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li><a href="{{url('login')}}">Login</a></li>
                        <li><a href="{{route('registerClinic')}}">Register</a></li>
                    </ul>
                </div><!-- /.navbar-custom-menu -->
            </div><!-- /.container-fluid -->
        </nav>
    </header>
    <!-- Full Width Column -->
    <div class="content-wrapper">
        <div class="container">

            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section><!-- /.content -->
        </div><!-- /.container -->
    </div><!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="container">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; <a href="#">chr247.com</a>.</strong> All rights
            reserved.
        </div><!-- /.container -->
    </footer>
</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/app.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
<script src="{{asset('plugins/wowjs/wow.min.js')}}"></script>
<script>
    $(document).ready(function () {
        new WOW().init();
    });
</script>

<!-- iCheck -->
<script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>

{{-- Google Analytics --}}
@include('analytics.googleAnalytics')

</body>
</html>

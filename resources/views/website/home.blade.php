@extends("layouts.website.layout")

@section("content")
    <!-- ========== HEADER ========== -->
    <header class="header main-header header-style-2" id="header-animated">
        <div class="primary-trans-bg">
            <div class="container">
                <!-- For centering the content vertically -->
                <div class="outer">
                    <div class="inner text-center">
                        <h1 class="white-color">The simplest Health Informatics System on the Cloud.</h1>
                        <h5 class="">Secure | Simple | Practical</h5>
                        <a href="{{route('registerClinic')}}" class="btn se-btn-white btn-rounded">
                            Get started now, it's FREE!
                        </a>
                    </div> <!-- end inner -->
                </div> <!-- end outer -->
            </div> <!-- end container -->
        </div> <!-- end primary-trans-bg -->
    </header>

    <!-- ========== FEATURE INTRO ========== -->
    <section class="se-section">
        <div class="container">
            <div class="row">
                <div class="container-fluid col-md-12">
                    <h2 class="underline mtn">Why chr247.com ?</h2>
                    <!-- 16:9 aspect ratio -->
                    <div class="col-md-8 col-md-offset-2 col-xs-12 col-sm-12">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tW3E7FQD_tM"
                                    allowfullscreen></iframe>
                        </div>

                        <div class="text-center">
                            <a href="{{route("registerClinic")}}" class="btn se-btn-black btn-rounded"
                               style="margin-top: 10px">
                                Join our Service
                            </a>
                        </div>
                    </div>
                </div> <!-- end col-md-8 -->
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>


    <!-- ========== FEATURES ========== -->
    <section class="se-section features-section">
        <div class="container">
            <div class="row">

                <div class="col-md-3 col-sm-6 se-feature">
                    <i class="icon ion-earth"></i>
                    <h5>100% Free!</h5>
                    <p>
                        Enjoy all the standard features that any medical practitioner requires for free all day every
                        day!
                    </p>
                    <ul>
                        <li>
                            <p><i class="icon ion-android-done" style="font-size: 16px"></i> No trial periods</p>
                        </li>
                        <li>
                            <p><i class="icon ion-android-done" style="font-size: 16px"></i> No hidden charges</p>
                        </li>
                        <li>
                            <p><i class="icon ion-android-done" style="font-size: 16px"></i> No contracts</p>
                        </li>
                    </ul>
                </div> <!-- end se-feature -->

                <div class="col-md-3 col-sm-6 se-feature">
                    <i class="icon ion-android-checkmark-circle"></i>
                    <h5>Security</h5>
                    <p>
                        All the records are protected by SSL end-to-end encryption so they are only accessed by only you
                        and the people who you grant access to.
                    </p>
                </div> <!-- end se-feature -->

                <div class="col-md-3 col-sm-6 se-feature">
                    <i class="icon ion-settings"></i>
                    <h5>Easy To Set-Up</h5>
                    <p>No installing, updating or maintaining is required by the user. We will do all that for you.
                        Once your account is approved you can immediately start using the system. </p>
                </div> <!-- end se-feature -->

                <div class="col-md-3 col-sm-6 se-feature">
                    <i class="icon ion-cloud"></i>
                    <h5>Easy Access</h5>
                    <p>
                        The entire system is running on cloud technology, so you can securely access your
                        records from anywhere, anytime. All you need is a computer, tablet or a smartphone and an
                        internet connection.
                    </p>
                </div> <!-- end se-feature -->

            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>

    <!-- ========== STEPS ========== -->
    <section class="se-section se-steps">
        <div class="container">
            <div class="row text-center">
                <h3 class="underline mtn">Setting-up is a piece of cake!</h3>
            </div> <!-- end row -->

            <div class="row">
                <div class="col-md-4 col-sm-4 one-step">
                    <h4>Sign Up</h4>
                    <p>Let us know some information about your clinic or private practice and we will contact you within
                        24 hours to authenticate your account. </p>
                </div>

                <div class="col-md-4 col-sm-4 one-step">
                    <h4>Add Users</h4>
                    <p>Once your account is set-up, you can login and add doctors and nurses to grant them access to
                        the system. </p>
                </div>

                <div class="col-md-4 col-sm-4 one-step">
                    <h4>Enjoy CHR247 for FREE!</h4>
                    <p>All the users can then login to the cloud and use the system at all day everyday!</p>
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
                            <p>The system works on any device which has a web-browser and an internet connection.</p>
                        </div>
                    </div> <!-- end se-feature -->

                    <div class="col-md-6 col-sm-6 se-feature-style-2 mb60">
                        <div class="left">
                            <i class="icon ion-ios-infinite-outline"></i>
                        </div>
                        <div class="right">
                            <h5>Updates for lifetime</h5>
                            <p>All of the updates to the system are available to all the users as soon as it's
                                released.</p>
                        </div>
                    </div> <!-- end se-feature -->

                    <div class="col-md-6 col-sm-6 se-feature-style-2 mb60">
                        <div class="left">
                            <i class="icon ion-ios-bolt-outline"></i>
                        </div>
                        <div class="right">
                            <h5>Lightning Fast</h5>
                            <p>The system is always lightning fast as it runs on a industrial grade cloud-server.</p>
                        </div>
                    </div> <!-- end se-feature -->

                    <div class="col-md-6 col-sm-6 se-feature-style-2 mb60">
                        <div class="left">
                            <i class="icon ion-ios-paper-outline"></i>
                        </div>
                        <div class="right">
                            <h5>Compact Documentation</h5>
                            <p>The documentation is a complete guide for the entire system which will be useful for
                                beginners and advanced users.
                            </p>
                        </div>
                    </div> <!-- end se-feature -->

                    <div class="col-md-6 col-sm-6 se-feature-style-2">
                        <div class="left">
                            <i class="icon ion-ios-checkmark-empty"></i>
                        </div>
                        <div class="right">
                            <h5>Light Weight</h5>
                            <p>The system is optimised to run under low-bandwidth conditions.
                            </p>
                        </div>
                    </div> <!-- end se-feature -->

                    <div class="col-md-6 col-sm-6 se-feature-style-2">
                        <div class="left">
                            <i class="icon ion-ios-world-outline"></i>
                        </div>
                        <div class="right">
                            <h5>Multi-lingual Support</h5>
                            <p>ආයුබෝවන් ~ 你好 ~ Привіт
                            </p>
                        </div>
                    </div> <!-- end se-feature -->

                </div> <!-- end row -->
            </div> <!-- end container -->
        </div> <!-- end black-gradient -->
    </section> <!-- end features-section -->
@endsection
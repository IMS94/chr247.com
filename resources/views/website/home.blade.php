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

<!-- ========== FEATURES ========== -->
<section class="se-section features-section">
    <div class="container">
        <div class="row">

            <div class="col-md-3 col-sm-6 se-feature">
                <i class="icon ion-earth"></i>
                <h5>100% Free!</h5>
                <p>
                    Enjoy all the standard features that any medical practitioner requires for free all day every day!
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

<!-- ========== LIST OF FEATURES ========== -->
<section class="se-section">
    <div class="container">
        <div class="row">

            <div class="col-md-4 col-sm-6 se-feature-style-3">
                <div class="feature-wrap">
                    <i class="icon ion-happy-outline"></i>
                    <h5>Patient Record Management</h5>
                    <p>Manage all patient records including prescriptions and past medical records.
                        Access patient information from anywhere.</p>
                    <a href="#" class="learn-more">Learn More</a>
                </div> <!-- end feature-wrap -->
            </div> <!-- end se-feature-style-3 -->

            <div class="col-md-4 col-sm-6 se-feature-style-3">
                <div class="feature-wrap">
                    <i class="icon ion-android-list"></i>
                    <h5>Drug Inventory</h5>
                    <p>Manage all the drugs and their stocks. Get notified on stocks which are running low.</p>
                    <a href="#" class="learn-more">Learn More</a>
                </div> <!-- end feature-wrap -->
            </div> <!-- end se-feature-style-3 -->

            <div class="col-md-4 col-sm-6 se-feature-style-3">
                <div class="feature-wrap">
                    <i class="icon ion-android-person-add"></i>
                    <h5>Queue Management</h5>
                    <p>Manage the patient queues of a clinic. Update the queue as patients finish visit the doctor.
                    </p>
                    <a href="#" class="learn-more">Learn More</a>
                </div> <!-- end feature-wrap -->
            </div> <!-- end se-feature-style-3 -->

            <div class="col-md-4 col-sm-6 se-feature-style-3">
                <div class="feature-wrap">
                    <i class="icon ion-alert-circled"></i>
                    <h5>Access Levels</h5>
                    <p>3 access levels for doctors, nurses and for the system administrator.
                        No need to worry about sensitive information.
                    </p>
                    <a href="#" class="learn-more">Learn More</a>
                </div> <!-- end feature-wrap -->
            </div> <!-- end se-feature-style-3 -->

            <div class="col-md-4 col-sm-6 se-feature-style-3">
                <div class="feature-wrap">
                    <i class="icon ion-android-checkmark-circle""></i>
                    <h5>Security &amp; Portability</h5>
                    <p>We are using the cutting edge technologies to make sure your data is secure while providing
                        the much required portability to your information by allowing you to securely access your data
                        from anywhere</p>
                    <a href="#" class="learn-more">Learn More</a>
                </div> <!-- end feature-wrap -->
            </div> <!-- end se-feature-style-3 -->

            <div class="col-md-4 col-sm-6 se-feature-style-3">
                <div class="feature-wrap">
                    <i class="icon ion-android-clipboard"></i>
                    <h5>Issue &amp; Print Prescriptions</h5>
                    <p>Issue prescriptions to patients through the system. You can print those prescriptions at
                     the same time.</p>
                    <a href="#" class="learn-more">Learn More</a>
                </div> <!-- end feature-wrap -->
            </div> <!-- end se-feature-style-3 -->

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
            <h3 class="underline mtn">It's as easy as 1 - 2 - 3!</h3>
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
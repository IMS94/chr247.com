@extends("layouts.website.layout")

@section("content")

    <!-- ========== PAGE TITLE ========== -->
    <header class="header page-title">
        <div class="container">
            <!-- For centering the content vertically -->
            <div class="outer">
                <div class="inner text-center">
                    <h1 class="">What does chr247.com offer?</h1>
                    <h5 class="">chr247.com provides simple and easy to use interfaces to handle all the day-to-day
                        tasks of small scale clinics including patient management and inventory management.</h5>
                    <a href="{{route("registerClinic")}}" class="btn se-btn-black btn-rounded mt20">Register Now</a>

                </div> <!-- end inner -->
            </div> <!-- end outer -->
        </div> <!-- end container -->
    </header>


    <!-- ========== LIST OF FEATURES ========== -->
    <section class="se-section" id="detailedFeatures">
        <div class="container">
            <div class="row">
                <h2 class="underline mtn">Features in detail ...</h2>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12 se-feature-style-3">
                    <div class="feature-wrap">
                        <i class="icon ion-happy-outline"></i>
                        <h5>Patient Record Management</h5>
                        <p>Manage all patient records including prescriptions and past medical records.
                            Access patient information from anywhere, anytime</p>
                    </div> <!-- end feature-wrap -->
                </div> <!-- end se-feature-style-3 -->

                <div class="col-md-4 col-sm-6 col-xs-12 se-feature-style-3">
                    <div class="feature-wrap">
                        <i class="icon ion-android-list"></i>
                        <h5>Drug Inventory</h5>
                        <p>Manage all the drugs and their stocks. Get notified on the stocks that are running low.</p>
                    </div> <!-- end feature-wrap -->
                </div> <!-- end se-feature-style-3 -->

                <div class="col-md-4 col-sm-6 col-md-offset-0 col-sm-offset-3 col-xs-12 se-feature-style-3">
                    <div class="feature-wrap">
                        <i class="icon ion-android-person-add"></i>
                        <h5>Queue Management</h5>
                        <p>Manage patient queues of the clinic by issuing numbers. Update the queue as the patients go
                            in and come out.</p>
                    </div> <!-- end feature-wrap -->
                </div> <!-- end se-feature-style-3 -->
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12 se-feature-style-3">
                    <div class="feature-wrap">
                        <i class="icon ion-alert-circled"></i>
                        <h5>Access Levels</h5>
                        <p>There are three levels of access. Doctor, nurse and system administrator. So, there’s need to
                            worry about any confidential information being exposed.</p>
                    </div> <!-- end feature-wrap -->
                </div> <!-- end se-feature-style-3 -->

                <div class="col-md-4 col-sm-6 col-xs-12 se-feature-style-3">
                    <div class="feature-wrap">
                        <i class="icon ion-android-checkmark-circle""></i>
                        <h5>Security &amp; Portability</h5>
                        <p>We are using cutting edge technologies to make sure your data is secure while providing
                            the much-required flexibility in access to your information by allowing you to securely
                            access your data from anywhere.</p>
                    </div> <!-- end feature-wrap -->
                </div> <!-- end se-feature-style-3 -->

                <div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-3 col-xs-12 se-feature-style-3">
                    <div class="feature-wrap">
                        <i class="icon ion-android-clipboard"></i>
                        <h5>Issue &amp; Print Prescriptions</h5>
                        <p>Issue prescriptions to patients and also print them straight from the system with one click
                            of a button.</p>
                    </div> <!-- end feature-wrap -->
                </div> <!-- end se-feature-style-3 -->

            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>

@endsection
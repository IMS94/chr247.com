@extends("layouts.website.layout")

@section("title",'chr247.com | About Us')

@section("content")
    <!-- ========== PAGE TITLE ========== -->
    <header class="header page-title">
        <div class="container">
            <!-- For centering the content vertically -->
            <div class="outer">
                <div class="inner text-center">
                    <h1 class="">Who We Are?</h1>
                    <h5 class="">We are Consec Technologies, an Australian start-up IT company in collaboration with few
                        independent software engineers from Sri Lanka</h5>
                    <a href="{{route("registerClinic")}}" class="btn se-btn-black btn-rounded mt20">Register Now</a>

                </div> <!-- end inner -->
            </div> <!-- end outer -->
        </div> <!-- end container -->
    </header>

    <!-- ========== FEATURE INTRO ========== -->
    <section class="se-section">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h2 class="underline mtn">More About Us ...</h2>
                    <p>Chr247 is a service provided by <a href="consectechnologies.com"> Consec Technologies</a>, an
                        Australian start-up IT company and a few
                        independent software engineers from Sri Lanka. Chr247 was initially developed as a stand-alone
                        commercial software in order to be used in public and private hospitals in Sri Lanka. As the
                        sales progressed over time, we decided to offer the service on the cloud so that we could
                        provide our clients with updates regularly without the need to manually install them on the
                        computers. With continuous research and development from the funds we obtained from sales in the
                        first year, we were able to turn Chr247 into a globally accepted complete Health Informatics
                        System running entirely on the cloud. </p>
                    <p>As a company that greatly values equal opportunity, the partners at Consec Technologies decided
                        that Chr247 must be a service that can be equally used by those who cannot afford a Health
                        Informatics System for their hospital or private practice. In May 2015, Chr247 was finally
                        relaunched as a 100% free cloud Health Informatics System that any medical practitioner from
                        anywhere in the world can sign-up and use it to make their medical services a lot more
                        efficient. We believe Chr247 has the potential to revolutionise the medical sector in currently
                        developing countries. We invite you to try Chr247 today and be part of the largest free Health
                        Informatics System on the cloud!
                    </p>
                    <a href="{{route("registerClinic")}}" class="btn se-btn-black btn-rounded">Join our Service</a>
                </div> <!-- end col-md-8 -->

                <div class="col-md-5">
                    <div class="owl-carousel owl-carousel-single mt10">
                        <div class="text-center">
                            <img src="http://consectechnologies.com/images/consec.png" style="background-color: black"
                                 alt="Consec Technologies"/>
                        </div>
                        <div class="text-center">
                            <img src="http://consectechnologies.com/images/consec.png" style="background-color: black"
                                 alt="Consec Technologies"/>
                        </div>
                    </div><!-- end owl-carousel -->
                </div> <!-- end col-md-4 -->

            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>

    <section class="se-section">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h2 class="underline mtn">Contact us</h2>
                    <p>
                        We value your opinion or any suggestions you may have for further improvements ! If you need any
                        clarifications, contact us using the contact number (within Australia) given or send us an email
                        with your contact details requesting a free call as described below. We will contact you.
                    </p>
                    <p> +61 390 056 788 (Australia) </p>
                    <p>From anywhere else, request a free call!
                        <a href="mailto: support@chr247.com">support@chr247.com</a></p>
                </div> <!-- end col-md-8 -->

                <div class="col-md-5">
                </div> <!-- end col-md-4 -->

            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>

    {{--
        <!-- ========== COUNTERS SECTION ========== -->
        <section class="se-section counters-section gray-section">
            <div class="container">
                <div class="row">

                    <div class="col-md-3 col-sm-6 col-xs-6 counter-box">
                        <span class="count-icon ion-thumbsup"></span>
                        <div class="count-info">
                            <h4><span class="counter">1760</span>+</h4>
                            <p>projects completed.</p>
                        </div> <!-- end count-info -->
                    </div> <!-- end counter-box -->

                    <div class="col-md-3 col-sm-6 col-xs-6 counter-box">
                        <span class="count-icon ion-happy-outline"></span>
                        <div class="count-info">
                            <h4><span class="counter">11000</span>+</h4>
                            <p>customers handled.</p>
                        </div> <!-- end count-info -->
                    </div> <!-- end counter-box -->

                    <div class="col-md-3 col-sm-6 col-xs-6 counter-box">
                        <span class="count-icon ion-coffee"></span>
                        <div class="count-info">
                            <h4><span class="counter">2200</span>+</h4>
                            <p>cups of tea.</p>
                        </div> <!-- end count-info -->
                    </div> <!-- end counter-box -->

                    <div class="col-md-3 col-sm-6 col-xs-6 counter-box">
                        <span class="count-icon ion-ios-flame-outline"></span>
                        <div class="count-info">
                            <h4><span class="counter">128</span>+</h4>
                            <p>human resources.</p>
                        </div> <!-- end count-info -->
                    </div> <!-- end counter-box -->

                </div> <!-- end row -->
            </div> <!-- end container -->
        </section>
    --}}


@endsection
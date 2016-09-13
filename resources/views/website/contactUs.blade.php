@extends("layouts.website.layout")

@section("title",'chr247.com | Contact Us')

@section("content")
    <!-- ========== PAGE TITLE ========== -->
    <header class="header page-title">
        <div class="container">
            <!-- For centering the content vertically -->
            <div class="outer">
                <div class="inner text-center">
                    <h1 class="">Contact Us</h1>
                    <h5 class="">We will get back to you as soon as possible</h5>
                    <a href="{{route("registerClinic")}}" class="btn se-btn-black btn-rounded mt20">Register Now</a>

                </div> <!-- end inner -->
            </div> <!-- end outer -->
        </div> <!-- end container -->
    </header>

    <!-- ========== CONTACT US FORM ========== -->
    <section class="se-section">
        <div class="container">
            <div class="row">
                <form class="col-md-9 col-sm-6" action="{{route('contactUs')}}" method="post" id="form">
                    {{csrf_field()}}
                    <h2 class="underline mtn">Contact us</h2>
                    <p>
                        We value your opinion and suggestions for further improvements! If you need any
                        clarification,
                        <strong>send us a message with your contact details requesting a free call below. We will
                            contact you.</strong>
                    </p>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
                            </button>
                            <i class="icon fa fa-ban"></i> Please fill all the fields correctly.
                        </div>
                    @endif

                    @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
                            </button>
                            <i class="icon fa fa-check"></i> {{session('success')}}
                        </div>
                    @endif

                    <div class="form-group col-md-6 col-xs-12">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Your Name ..."
                               value="{{old('name')}}" required>
                    </div> <!-- end form-group -->
                    <div class="form-group col-md-6 col-xs-12">
                        <label for="contact">Contact Number</label>
                        <input type="tel" class="form-control" id="contact" name="contact"
                               placeholder="With country code ..." value="{{old('contact')}}"
                               required="">
                    </div> <!-- end form-group -->
                    <div class="form-group col-md-12 col-xs-12">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email"
                               placeholder="Your Email Address" value="{{old('email')}}"
                               required="">
                    </div> <!-- end form-group -->
                    <div class="form-group col-md-12 col-xs-12">
                        <label for="message">Message</label>
                        <textarea name="message" id="message" rows="5"
                                  placeholder="Enter your message here..">{{old('message')}}</textarea>
                    </div> <!-- end form-group -->

                    <div class="text-center col-md-12 mt10 mb20 col-xs-12">
                        <button type="submit" class="btn se-btn btn-rounded">Submit</button>
                    </div> <!-- end text-center -->
                </form>

                <div class="col-md-3 col-sm-6 contact-info">
                    <h6 class="underline mtn">Address</h6>
                    <p>
                        22 Lachlan close, <br>
                        Cranbourne North,<br>
                        VIC 3977,<br>
                        Australia
                    </p>
                    <h6 class="underline mtn">Contact Number</h6>
                    <p> +61 390 056 788</p>
                    <h6 class="underline mtn">Email Address</h6>
                    <p>
                        support@chr247.com
                    </p>
                </div> <!-- end contact-info -->
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>

@endsection
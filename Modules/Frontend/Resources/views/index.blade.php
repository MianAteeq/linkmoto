@extends('frontend::layout.app')
@section('content')
<!-- Banner -->
<!--<div class="banner-area">-->
<!--    <div class="banner-img">-->
<!--        <img src="{{ asset('modules/website/assets/img/home-one/banner-tyre.png') }}" alt="Banner">-->
<!--        <img class="wow fadeInRightBig" src="{{ asset('modules/website/assets/img/home-one/banner-car.png') }}" alt="Banner">-->
<!--    </div>-->
<!--    <div class="d-table">-->
<!--        <div class="d-table-cell">-->
<!--            <div class="container">-->
<!--                <div class="banner-text">-->
<!--                    <h1>Get Your Best Auto Services</h1>-->
<!--                    <p> @if(!empty($setting['description'])) {{$setting['description']}} @endif</p>-->
<!--                    <div class="cmn-btn">-->
<!--                        <a class="banner-btn-left" href="#">-->
<!--                            <i class='bx bx-meteor'></i>-->
<!--                            Explore Service-->
<!--                        </a>-->
<!--                        <a class="banner-btn-right" href="tel:+123456789">-->
<!--                            <i class='bx bx-phone-call'></i>-->
<!--                            @if(!empty($setting['homecallus'])) {{$setting['homecallus']}} @endif-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- End Banner -->

<!-- Address -->
<div class="address-area" style="margin-top:100px;">
    <div class="containers">
         <h2>Join the linkmoto Closed Beta</h2>
    <p style="text-align:center">Be among the first to try linkmoto, the new platform designed for garages,
    mobile mechanics, and other automotive service providers to manage jobs,
    customers, and services — all in one place.</p>
      <div class="section">
      <h3>Why join the Beta?</h3>
      <ul>
        <li>Early Access – Be one of the first to use linkmoto before public release.</li>
        <li>Tailored for You – Whether you run a garage, work as a mobile mechanic, or provide specialist services, the platform is designed to fit your workflow.</li>
        <li>Help Shape the App – Your feedback will directly influence new features and improvements.</li>
        <li>Exclusive Beta Perks – Access special benefits, early offers, and discounted rates when the app launches.</li>
        <li>Stay Ahead – Get tools that make managing jobs, customers, and services faster and simpler.</li>
      </ul>
    </div>

    <div class="section">
      <h3>What you’ll be testing?</h3>
        <p>During the beta, you’ll get access to early features such as:</p>
      <ul>
        <li>📅 Booking & Job Management – create, schedule, and track customer bookings and jobs</li>
        <li>🚗 Vehicle Records – store vehicle details and link them to customer history</li>
        <li>👤 Customer Records – manage customer details alongside their vehicles</li>
        <li>💰 Quotes & Invoices – generate and share directly with customers</li>
        <li>🔔 Notifications – keep customers updated on progress</li>
        <li>📱 Mobile-Friendly Access – use the app in your garage, on the move, or at a customer’s location</li>
      </ul>
      <p><strong>Note:</strong> These features are still under development — your feedback will help
us improve them and decide what to build next.</p>
    </div>

    <div class="section">
      <h3>Looking ahead</h3>
      <p style="text-align:justify">The beta is just the beginning. We’ll continue to add new features and enhancements to make the platform even more useful for garages, mobile mechanics, and service providers.<br/>
      By participating in the beta, you’ll have early access to these updates and the chance to shape how they evolve.<br/>
      Note: Specific features are still under development and will be shared with testers as they become available.</p>
    </div>

    <div class="section">
      <h3>What’s involved?</h3>
      <ul>
        <li>The beta is free to join.</li>
        <li>You’ll use the app in your daily work — whether in a garage, on the move,
or offering specialist services.</li>
        <li>Features are still under development, so some things may change or not
always work perfectly.</li>
        <li>Your feedback will help us improve the platform for all types of service
providers.</li>
<li>Places are limited — we’ll contact selected applicants with access
details.</li>
      </ul>
    </div>

    <div class="section">
      <h3>Register Your Interest</h3>
      <p>Ready to join the linkmoto Closed Beta? Click the button below to go to the
registration page and submit your details.</p>
      <div style="text-align:center"><a href="https://linkmoto-dev.fissionmonster.com/register" class="btn">Register Your Interest</a></div>
    </div>

    <div class="section">
      <h3>Next steps</h3>
      <p>Once you’ve submitted your details, our team will review your application. If selected, you’ll receive an email with instructions on how to access the app and join the closed beta.</p>
      <p>👉 Whether you’re a garage, mobile mechanic, or service provider, you’ll be able to test the platform in real-world use and share feedback that helps us shape future features.</p>
    </div>

    <div class="section">
      <h3>Questions?</h3>
      <p>Do you have any questions? Click the button below to get in touch with us.</p>
     <div style="text-align:center">
          <a href="https://linkmoto-dev.fissionmonster.com/contact" class="btn">Get in Touch</a>
     </div>
    </div>
        <!--<div class="row">-->
            <!--<div class="col-sm-6 col-lg-4">-->
            <!--    <div class="address-item">-->
            <!--        <i class='bx bxs-paper-plane'></i>-->
            <!--        <h3>Location</h3>-->
            <!--        <span> @if(!empty($setting['homelocation'])) {{$setting['homelocation']}} @endif</span>-->
            <!--    </div>-->
            <!--</div>-->
            <!--<div class="col-sm-6 col-lg-4">-->
            <!--    <div class="address-item">-->
            <!--        <i class='bx bxs-phone-call'></i>-->
            <!--        <h3>Call Us</h3>-->
            <!--        <a href="tel:+0755543332322">@if(!empty($setting['homecallus'])) {{$setting['homecallus']}} @endif </a>-->
            <!--    </div>-->
            <!--</div>-->
            <!--<div class="col-sm-6 offset-sm-3 offset-lg-0 col-lg-4">-->
            <!--    <div class="address-item address-one">-->
            <!--        <i class='bx bxs-time-five'></i>-->
            <!--        <h3>Schedule</h3>-->
            <!--        <span>@if(!empty($setting['homescedule'])) {{$setting['homescedule']}} @endif</span>-->
            <!--    </div>-->
            <!--</div>-->
        <!--</div>-->
    </div>
</div>
<!-- End Address -->

<!-- Process -->
<!--<section class="process-area pt-100 pb-70">-->
<!--    <div class="process-shape">-->
<!--        <img src="{{ asset('modules/website/assets/img/home-one/car-shadow.png') }}" alt="Shape">-->
<!--    </div>-->
<!--    <div class="section-title">-->
<!--        <span class="sub-title">process</span>-->
<!--        <h2>Our Working Process</h2>-->
<!--    </div>-->
<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="col-lg-4">-->
<!--                <div class="process-item">-->
<!--                    <div class="process-inner process-one">-->
<!--                        <i class='bx bxs-car-mechanic'></i>-->
<!--                        <h3>Identify Problems</h3>-->
<!--                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>-->
<!--                    </div>-->
<!--                    <div class="process-inner">-->
<!--                        <i class='bx bxs-car-garage'></i>-->
<!--                        <h3>Start Servicing</h3>-->
<!--                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-lg-4">-->
<!--                <div class="process-item">-->
<!--                    <div class="process-img">-->
<!--                        <img src="{{ asset('modules/website/assets/img/home-one/tyre.png') }}" alt="Process">-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-lg-4">-->
<!--                <div class="process-item">-->
<!--                    <div class="process-inner process-two">-->
<!--                        <i class='bx bxs-car-crash'></i>-->
<!--                        <h3>Trial For Make Sure</h3>-->
<!--                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>-->
<!--                    </div>-->
<!--                    <div class="process-inner process-three">-->
<!--                        <i class='bx bxs-car-wash'></i>-->
<!--                        <h3>Deliver Service</h3>-->
<!--                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</section>-->
<!-- End Process -->

<!-- Our Features -->

<!--<div class="feature-area  my-5">-->
<!--    <div class="feature-shape">-->
<!--        <img src="{{ asset('modules/website/assets/img/home-one/feature-shape.png') }}" alt="Feature">-->
<!--    </div>-->
<!--    <div class="container-fluid">-->
<!--        <div class="row">-->
<!--            <div class="col-lg-6 p-0">-->
<!--                <div class="feature-img">-->
<!--                    <img src="@if(!empty($setting['homeFeatureImage'])){{ $setting['homeFeatureImage']}} @endif" alt="Feature">-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-lg-6 p-0">-->
<!--                <div class="feature-content">-->
<!--                    <h2>Our Features</h2>-->
<!--                    <ul>-->
<!--                        <li>-->
<!--                            <i class='bx bx-box'></i>-->
<!--                            <h3>Trusted & Quality Work</h3>-->
<!--                            <p>Lorem ipsum the dolor sit amet, consectetur adising elit, sed do.the dolor sit amet,-->
<!--                                consectetur </p>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <i class='bx bxs-truck'></i>-->
<!--                            <h3>Fast Service Delivery</h3>-->
<!--                            <p>Lorem ipsum the dolor sit amet, consectetur adising elit, sed do.the dolor sit amet,-->
<!--                                consectetur </p>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <i class='bx bx-money'></i>-->
<!--                            <h3>Money Back Garanty</h3>-->
<!--                            <p>Lorem ipsum the dolor sit amet, consectetur adising elit, sed do.the dolor sit amet,-->
<!--                                consectetur </p>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!-- Our Features  end-->

<!-- Services start -->

<!--<section class="pb-70">-->
<!--    <div class="container">-->
<!--        <div class="section-title">-->
<!--            <span class="sub-title">service</span>-->
<!--            <h2>Our Services</h2>-->
<!--            <p></p>-->
<!--        </div>-->
<!--        <div class="row">-->
<!--            @foreach ($services as $service)-->
<!--            <div class="col-sm-6 col-lg-4">-->
<!--                <a >-->
<!--                    <div class="service-item">-->
<!--                        <div class="service-img">-->
<!--                            <img src="{{ asset($service['image']??'modules/website/assets/img/home-one/service/1.jpg') }}" alt="Service">-->
<!--                        </div>-->
<!--                        <div class="service-content">-->
<!--                            <i class='bx bx-car'></i>-->
<!--                            <i class='bx bx-car service-icon'></i>-->
<!--                            <h3>{{ $service['name'] }}</h3>-->
<!--                            <p>{{ $service['description'] }} </p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </a>-->
<!--            </div>-->
                
<!--            @endforeach-->
          
<!--        </div>-->
<!--    </div>-->
<!--</section>-->
<!-- End Service -->

<!-- Quality -->
<!--<section class="quality-area">-->
<!--    <div class="quality-img">-->
<!--        <img src="{{ asset('modules/website') }}/assets/img/home-one/quality-shape.png" alt="Quality">-->
<!--        <img src="{{ asset('modules/website') }}/assets/img/home-one/quality-shape.png" alt="Quality">-->
<!--        <img src="{{ asset('modules/website') }}/assets/img/home-one/quality-car.png" alt="Quality">-->
<!--    </div>-->
<!--    <div class="container">-->
<!--        <div class="quality-content">-->
<!--            <div class="section-title">-->
<!--                <h2>Quality Work is Our First Priority </h2>-->
<!--                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut-->
<!--                    labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra-->
<!--                    maecenas accumsan lacus vel facilisis. </p>-->
<!--            </div>-->
<!--            <div class="cmn-btn">-->
<!--                <a class="banner-btn-left" href="{{ route('website.about'); }}">-->
<!--                    Read More-->
<!--                </a>-->
<!--            </div>-->
<!--            <img src="{{asset('modules/website/assets/img/home-one/tyre.png')}}" alt="Quality">-->
<!--        </div>-->
<!--    </div>-->
<!--</section>-->
<!-- End Quality -->

<!--<div class="review-area " style="margin-top: 120px; margin-bottom:200px;">-->
<!--    <div class="review-shape">-->
<!--        <img src=" @if(!empty($setting['hometestimonialimage'])) {{$setting['hometestimonialimage']}} @endif" alt="Review">-->
<!--    </div>-->
<!--    <div class="video-wrap">-->
<!--        <a href="@if(!empty($setting['hometestimonialvedio'])){{ $setting['hometestimonialvedio']}} @endif" class="popup-youtube">-->
<!--            <i class='bx bx-play'></i>-->
<!--        </a>-->
<!--    </div>-->
<!--    <div class="container-fluid p-0">-->
<!--        <div class="row m-0">-->
<!--            <div class="col-lg-6 ptb-100">-->
<!--                <div class="review-slider owl-theme owl-carousel">-->
<!--                    <div class="review-item">-->
<!--                        <i class='bx bxs-quote-right'></i>-->
<!--                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt-->
<!--                            ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo-->
<!--                            viverra maecenas accumsan.</p>-->
<!--                        <div class="review-inner">-->
<!--                            <img src="{{ asset('modules/website/assets/img/home-one/review/reviewer-one.png') }}" alt="Review">-->
<!--                            <h3>Sarah Tylor</h3>-->
<!--                            <span>Designer</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="review-item">-->
<!--                        <i class='bx bxs-quote-right'></i>-->
<!--                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have-->
<!--                            suffered alteration in some form, by injected humour, or randomised words which don't-->
<!--                            look even slightly believable.</p>-->
<!--                        <div class="review-inner">-->
<!--                            <img src="{{ asset('modules/website/assets/img/home-one/review/reviewer-one.png') }}" alt="Review">-->
<!--                            <h3>Tom Henry</h3>-->
<!--                            <span>CEO</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-lg-6">-->
<!--                <div class="review-bg">-->
<!--                    <img src="{{ asset('modules/website/assets/img/home-one/review/review-right.jpg') }}" alt="Review">-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- End Review -->
@endsection
@extends('frontend::layout.app')

@section('css')
<style>
/* --- Responsive Margins for Large Sections --- */
.responsive-feature-margin {
  margin-top: 120px;
  margin-bottom: 200px;
}

/* Adjust padding for text content on mobile */
.mobile-padded {
  padding: 15px !important;
}

/* Ensure feature images scale down properly */
.responsive-img {
  max-width: 100%;
  height: auto;
  display: block;
}

@media (max-width: 768px) {
  .responsive-feature-margin {
    margin-top: 60px;
    /* Reduced huge gaps on mobile */
    margin-bottom: 80px;
  }

  /* Add breathing room between stacked sections */
  .mobile-stack-space {
    margin-bottom: 30px;
  }
}
</style>
@endsection

@section('content')
<div class="page-title-area">
  <img class="responsive-img"
    src="@if(!empty($setting['aboutBanner'])) {{$setting['aboutBanner']}} @else {{asset('modules/website/assets/img/home-one/footer-car.png')}} @endif"
    alt="Title">
  <div class="container">
    <div class="page-title-content">
      <h2>About Us</h2>
      <ul>
        <li>
          <a href="<?php echo route('website.index'); ?>">Home</a>
        </li>
        <li>
          <i class='bx bx-chevron-right'></i>
        </li>
        <li>About Us</li>
      </ul>
    </div>
  </div>
</div>
<section class="quality-area quality-area-four pt-100">
  <div class="quality-shape d-none d-lg-block"> <img
      src="<?php echo asset('modules/website') ?>/assets/img/car-shape.png" alt="Quality">
  </div>
  <div class="container-fluid p-0">
    <div class="row m-0 align-items-center">
      <div class="col-12 col-lg-6 p-0 mobile-stack-space">
        <div class="quality-img">
          <img class="responsive-img"
            src="@if(!empty($setting['aboutImage'])) {{$setting['aboutImage']}} @else {{asset('modules/website/assets/img/about-car.jpg')}} @endif"
            alt="Quality">
          <div class="video-wrap">
            <a href="@if(!empty($setting['aboutVedioLink'])) {{$setting['aboutVedioLink']}} @endif"
              class="popup-youtube">
              <i class='bx bx-play'></i>
            </a>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-6 mobile-padded">
        <div class="quality-content">
          <div class="section-title">
            <h2>@if(!empty($setting['aboutTitle'])) {{$setting['aboutTitle']}} @else
              {{'Quality Work is Our First Priority'}} @endif </h2>
            <p>@if(!empty($setting['aboutDescription'])) {{$setting['aboutDescription']}} @else
              {{'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.'}}
              @endif </p>
          </div>
          <div class="cmn-btn mt-4">
            <a class="banner-btn-left" href="<?php echo route('website.about'); ?>">
              Read More
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="feature-area responsive-feature-margin">
  <div class="feature-shape d-none d-lg-block"> <img
      src="<?php echo asset('modules/website') ?>/assets/img/home-one/feature-shape.png" alt="Feature">
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-lg-6 p-0 mobile-stack-space">
        <div class="feature-img">
          <img class="responsive-img" src="<?php echo asset('modules/website') ?>/assets/img/home-one/feature-bg.jpg"
            alt="Feature">
        </div>
      </div>
      <div class="col-12 col-lg-6 mobile-padded">
        <div class="feature-content">
          <h2>Our Features</h2>
          <ul class="list-unstyled">
            <li class="mb-4">
              <i class='bx bx-box' style="font-size: 2rem; color: #f47c42;"></i>
              <h3 class="mt-2">Trusted & Quality Work</h3>
              <p>Lorem ipsum the dolor sit amet, consectetur adising elit, sed do.the dolor sit amet,
                consectetur </p>
            </li>
            <li class="mb-4">
              <i class='bx bxs-truck' style="font-size: 2rem; color: #f47c42;"></i>
              <h3 class="mt-2">Fast Service Delivery</h3>
              <p>Lorem ipsum the dolor sit amet, consectetur adising elit, sed do.the dolor sit amet,
                consectetur </p>
            </li>
            <li class="mb-4">
              <i class='bx bx-money' style="font-size: 2rem; color: #f47c42;"></i>
              <h3 class="mt-2">Money Back Garanty</h3>
              <p>Lorem ipsum the dolor sit amet, consectetur adising elit, sed do.the dolor sit amet,
                consectetur </p>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@extends('frontend::layout.app')

@section('css')
<style>
/* Responsive padding adjustments for mobile devices */
@media (max-width: 768px) {
  .pricing-area {
    padding-top: 50px !important;
    padding-bottom: 20px !important;
  }
}
</style>
@endsection

@section('content')
<div class="page-title-area">
  <img
    src="@if(!empty($setting['pricingBanner'])) {{$setting['pricingBanner']}} @else {{asset('modules/website/assets/img/home-one/footer-car.png')}} @endif"
    class="img-fluid w-100" alt="Title">
  <div class="container">
    <div class="page-title-content">
      <h2>Pricing</h2>
      <ul>
        <li>
          <a href="<?php echo route('website.index'); ?>">Home</a>
        </li>
        <li>
          <i class='bx bx-chevron-right'></i>
        </li>
        <li>Pricing</li>
      </ul>
    </div>
  </div>
</div>
<section class="pricing-area pt-100 pb-70">
  <div class="container">
    <div class="row">
      @if($packages)
      @foreach($packages as $package)
      <div class="col-12 col-sm-6 col-lg-4 mb-4">
        <div class="pricing-item h-100">
          <div class="pricing-top">
            <h3>{{ $package->name }}</h3>
            <p><span class="dollar">£</span>{{$package->price}}<span class="month">{{$package->time}}</span></p>
          </div>
          <div class="pricing-middle">
            <i class='bx bx-rocket'></i>
          </div>
          <div class="pricing-bottom">
            <ul>
              @if($package->features)
              @foreach($package->features as $packagesFeat)
              <li>
                <i class='bx bx-check-circle'></i>
                {{$packagesFeat->name}}
              </li>
              @endforeach
              @endif
            </ul>
            <div class="cmn-btn">
              <a class="banner-btn-left" href="{{route('website.subscription.checkout',$package['random_key'])}}">
                Get Started
              </a>
            </div>
          </div>
        </div>
      </div>
      @endforeach
      @endif
    </div>
  </div>
</section>
@endsection
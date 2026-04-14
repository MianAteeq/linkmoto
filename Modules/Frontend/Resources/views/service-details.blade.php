@extends('frontend::layout.app')

@section('css')
<style>
/* Responsive bottom margin to prevent massive empty space on mobile */
.responsive-bottom-margin {
  margin-bottom: 200px;
}

@media (max-width: 991px) {
  .responsive-bottom-margin {
    margin-bottom: 60px !important;
  }

  .service-details-area.pt-100 {
    padding-top: 50px !important;
  }
}

/* Ensure the slider images take full width of their container */
.service-details-slider-item img {
  width: 100%;
  height: auto;
  border-radius: 8px;
}
</style>
@endsection

@section('content')
<div class="page-title-area">
  <img src="<?php echo asset('modules/website') ?>/assets/img/home-one/footer-car.png" alt="Title"
    class="img-fluid w-100">
  <div class="container">
    <div class="page-title-content">
      <h2>Service Details</h2>
      <ul>
        <li>
          <a href="<?php echo route('website.index'); ?>">Home</a>
        </li>
        <li>
          <i class='bx bx-chevron-right'></i>
        </li>
        <li>Service Details</li>
      </ul>
    </div>
  </div>
</div>
<div class="service-details-area pt-100 pb-70 responsive-bottom-margin">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-9">
        <div class="service-details-item">
          <div class="service-details-img">
            <div class="service-details-slider owl-theme owl-carousel">
              <div class="service-details-slider-item">
                <img src="<?php echo asset('modules/website') ?>/assets/img/service-details.jpg" alt="Service"
                  class="img-fluid">
              </div>
              <div class="service-details-slider-item">
                <img src="<?php echo asset('modules/website') ?>/assets/img/service-details2.jpg" alt="Service"
                  class="img-fluid">
              </div>
              <div class="service-details-slider-item">
                <img src="<?php echo asset('modules/website') ?>/assets/img/service-details3.jpg" alt="Service"
                  class="img-fluid">
              </div>
            </div>
            <h3 class="mt-4">Tyre Service</h3>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
              industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
              scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into
              electronic typesetting, remaining essentially unchanged.</p>
            <p>It is a long established fact that a reader will be distracted by the readable content of a page when
              looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of
              letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration
              in some form, by injected humour, or randomised words which don't look even slightly believable. If you
              are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in
              the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as
              necessary, making this the first true generator on the Internet.</p>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-3 mt-5 mt-lg-0">
        <div class="service-details-item">
          <div class="service-details-left">
            <h3>Service List</h3>
            <ul>
              <li>
                <i class='bx bx-chevron-right'></i>
                <a href="#">Tyre Service</a>
              </li>
              <li>
                <i class='bx bx-chevron-right'></i>
                <a href="#">Engine Service</a>
              </li>
              <li>
                <i class='bx bx-chevron-right'></i>
                <a href="#">Tuning Service</a>
              </li>
              <li>
                <i class='bx bx-chevron-right'></i>
                <a href="#">Motor Service</a>
              </li>
              <li>
                <i class='bx bx-chevron-right'></i>
                <a href="#">System Service</a>
              </li>
              <li>
                <i class='bx bx-chevron-right'></i>
                <a href="#">Washing Service</a>
              </li>
            </ul>
          </div>
          <div class="service-details-left service-details-contact mt-4">
            <h3>Contact Us</h3>
            <ul>
              <li>
                <i class='bx bx-location-plus'></i>
                28/A Street, New York City
              </li>
              <li>
                <i class='bx bx-phone-call'></i>
                <a href="tel:+880123456789">+88 0123 456 789</a>
              </li>
              <li>
                <i class='bx bx-mail-send'></i>
                <a href="mailto:info@audeck.com">info@audeck.com</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
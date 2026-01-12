

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{asset('modules/website/assets/css/bootstrap.min.css')}}">
<!-- Meanmenu CSS -->
<link rel="stylesheet" href="{{asset('modules/website/assets/css/meanmenu.css') }}">
<!-- Boxicons CSS -->
<link rel="stylesheet" href="{{asset('modules/website/assets/css/boxicons.min.css') }}">
<!-- Owl Carousel -->
<link rel="stylesheet" href="{{asset('modules/website/assets/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{asset('modules/website/assets/css/owl.theme.default.min.css') }}">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="{{asset('modules/website/assets/css/magnific-popup.min.css') }}">
<!-- Animate CSS -->
<link rel="stylesheet" href="{{asset('modules/website/assets/css/animate.min.css') }}">
<!-- Style CSS -->
<link rel="stylesheet" href="{{asset('modules/website/assets/css/style.css') }}">
<!-- Responsive CSS -->
<link rel="stylesheet" href="{{asset('modules/website/assets/css/responsive.css') }}">
<!-- Theme Dark CSS -->
<link rel="stylesheet" href="{{asset('modules/website/assets/css/theme-dark.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="icon" type="image/png" href="@if(!empty($setting['favicon'])) {{$setting['favicon']}} @endif">
<style>
    .banner-btn-left {
  display: inline-block;
  text-align: center;
  text-decoration: none;
  color: #333;
  padding: 6px 8px;
  cursor: pointer;
  border-radius: 6px;
}

.banner-btn-left i {
  display: block;      /* stack vertically */
  font-size: 26px;
  line-height: 1;
  margin-bottom: 4px;  /* space between icon and text */
}

.banner-btn-left .btn-label {
  display: block;
  font-size: 13px;
  line-height: 1;
}
.cmn-btn a:hover{
    color:white!important;
}
 .containers {
      max-width: 850px;
      margin: 0 auto;
      background: #fff;
      padding: 30px;
      /*border-radius: 10px;*/
      /*box-shadow: 0 4px 8px rgba(0,0,0,0.05);*/
    }

    h2 {
      text-align: center;
      color: #e67e22;
      margin-bottom: 20px;
    }
 h3 {
     text-align: center;
      margin-top: 40px;
      color: #e67e22;
    }

   ul {
    list-style: disc;
    padding: 0;
    color: black;
}
   

    .btn {
      display: inline-block;
      background: #000;
      color: #fff;
      padding: 10px 20px;
      margin-top: 20px;
      text-decoration: none;
      border-radius: 6px;
      transition: background 0.2s ease;
       margin: 20px auto 0;   
    }
    .btn:hover {
      background: #333;
      color:white;
    }

    .section {
      margin-bottom: 30px;
    }

    p {
      margin: 10px 0;
      color:black;
    }
@media (max-width: 576px) {
  .address-area {
    margin: 10px!important;  /* reduce top margin on mobile */
  }
}
.switch-box {
    display: none;
}
.login-item .form-group .form-control {
    border: 2px solid #231f20;
    background-color: #dddddd1f;
}
.login-item {
    max-width: 600px;
    margin: auto;
    padding: 40px 50px 40px 50px;
    -webkit-box-shadow: none;
    box-shadow: none;
}
.login-item .login-btn {
    margin-top: 10px;
    font-size: 16px;
    color: #ffffff;
    background-color: #000000;
    border-radius: 6px;
    padding: 14px 45px;
    -webkit-transition: 0.5s all 
ease;
    transition: 0.5s all 
ease;
    margin-bottom: 15px;
    width: 100%;
}

.contact-area .contact-right .form-group .form-control {
    border: 2px solid #000000;
    border-radius: 0;
    height: 50px;
    padding-left: 25px;
    font-size: 14px;
}
.contact-area .contact-right .contact-btn {
    background-color: #000000;
}

</style>

@yield('css')
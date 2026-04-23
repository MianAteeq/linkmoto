<style>
    /* Force hide mobile nav, always show main nav with buttons */
    .mobile-nav {
        display: none !important;
    }

    .main-nav {
        display: block !important;
    }

    .main-nav .navbar {
        display: flex !important;
        flex-wrap: nowrap !important;
        align-items: center !important;
    }

    .main-nav .cmn-btn {
        display: flex !important;
        margin-left: auto;
    }

    .main-nav .collapse {
        display: none !important;
    }

    .navbar-toggler {
        display: none !important;
    }

    /* 1. Ensure the container holding both items uses flexbox to center them */
    .navbar-header .navbar-nav {
        display: flex !important;
        align-items: center !important;
        height: 100%;
        /* Ensures it takes full height of navbar */
    }

    /* 2. Reset any weird margins that appear when the menu is opened */
    .navbar-header .menu-toggle,
    .navbar-header .nav-menu-main {
        margin-top: 0 !important;
        margin-bottom: 0 !important;
        display: flex !important;
        align-items: center !important;
    }

    /* 3. Ensure the logo link itself is aligned */
    .navbar-brand {
        display: flex !important;
        align-items: center !important;
    }
</style>
<!-- Start Navbar Area -->
<div class="navbar-area fixed-top">
    <!-- Menu For Mobile Device -->
    <div class="mobile-nav">
        <a href="<?php echo route('website.index'); ?>" class="logo">
            <img src="@if (!empty($setting['headerlogo'])) {{ $setting['headerlogo'] }} @else {{ asset('modules/website/assets/img/logo.png') }} @endif"
                alt="Logo">
        </a>
    </div>

    <!-- Menu For Desktop Device -->
    <div class="main-nav">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light">
                <a class="navbar-brand" href="<?php echo route('website.index'); ?>">
                    <img src="@if (!empty($setting['headerlogo'])) {{ asset($setting['headerlogo']) }} @else {{ asset('modules/website/assets/img/logo.png') }} @endif"
                        class="logo-one" alt="Logo" width="230">
                </a>

                {{-- FIX: hide hamburger toggler completely --}}
                <button class="navbar-toggler d-none" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                    <!--<ul class="navbar-nav ml-auto">-->
                    <!--    <li class="nav-item">-->
                    <!--        <a href="<?php echo route('website.index'); ?>" class="nav-link active">Home</a>-->
                    <!--    </li>-->
                    <!--    <li class="nav-item">-->
                    <!--        <a href="<?php echo route('website.about'); ?>" class="nav-link">About</a>-->
                    <!--    </li>-->
                    <!--    <li class="nav-item">-->
                    <!--        <a href="<?php echo route('website.service'); ?>" class="nav-link">Services</a>-->
                    <!--    </li>-->
                    <!--    <li class="nav-item">-->
                    <!--        <a href="<?php echo route('website.pricing'); ?>" class="nav-link">Pricing</a>-->
                    <!--    </li>-->
                    <!--    <li class="nav-item">-->
                    <!--        <a href="<?php echo route('website.contact'); ?>" class="nav-link">Contact</a>-->
                    <!--    </li>-->
                    <!--</ul>-->
                </div>

                {{-- FIX: d-flex instead of d-none d-md-flex so buttons always visible on all screen sizes --}}
                <div class="cmn-btn d-flex" style="width: auto;">
                    @auth
                        <a class="banner-btn-left" href="<?php echo route('vender.index'); ?>">
                            <i class='bx bxs-home'></i> Dashboard
                        </a>
                    @else
                        <a class="banner-btn-left" style="color: black;background-color: transparent;"
                            href="<?php echo route('website.vendor.login'); ?>">
                            <i class="bx bxs-user-plus" aria-hidden="true"></i>
                            <span class="btn-label">Sign In</span>
                        </a>
                        <a class="banner-btn-left" style="color: black;background-color: transparent;"
                            href="<?php echo route('website.vendor.register'); ?>">
                            <i class='bx bxs-file'></i>
                            <span class="btn-label">Register</span>
                        </a>
                    @endauth
                </div>

            </nav>
        </div>
    </div>
</div>
<!-- End Navbar Area -->

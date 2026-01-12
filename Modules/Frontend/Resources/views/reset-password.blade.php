
@extends('frontend::layout.app')
@section('content')
        <!-- Page Title -->
        <!--<div class="page-title-area">-->
        <!--    <img src="<?php echo asset('modules/website') ?>/assets/img/home-one/footer-car.png" alt="Title">-->
        <!--    <div class="container">-->
        <!--        <div class="page-title-content">-->
        <!--            <h2>Sign In</h2>-->
        <!--            <ul>-->
        <!--                <li>-->
        <!--                    <a href="<?php echo route('website.index'); ?>">Home</a>-->
        <!--                </li>-->
        <!--                <li>-->
        <!--                    <i class='bx bx-chevron-right'></i>-->
        <!--                </li>-->
        <!--                <li>Sign In</li>-->
        <!--            </ul>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
        <!-- End Page Title -->

        <!-- Login -->
        <div class="login-area ptb-100">
            <div class="container">

                <div class="login-item">
                <h2>Reset Password</h2>
               
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-block">

                        <strong>{{ $error }}</strong>
                    </div>
                    @endforeach
                    <form method="POST" action="{{route('password.update')}}">
                        @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">

                        <div class="form-group">
                            <label>New Password:</label>
                            <input type="password" name="password" class="form-control" required placeholder="New Password">
                        </div>
                        <div class="form-group">
                            <label>Confirm password:</label>
                            <input type="password" name="password_confirmation" class="form-control" required placeholder="Confirm Password">
                        </div>
                      
                        <div class="text-center">
                        <button type="submit" class="btn login-btn">Reset Password</button>
                    </div>
                    </form>

                    <span>Not yet registered? <a href="<?php echo route('website.vendor.register'); ?>">Click Here</a></span>
                </div>
            </div>
        </div>
        <!-- End Login -->
        @endsection

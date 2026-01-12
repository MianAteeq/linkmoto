
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
                <h2>Forgot Password</h2>
                @if(session('status'))
                <div style="color: green;">{{ session('status') }}</div>
                @endif
                <p style="text-align:center">Please provide the email address associated with your account to reset your password.</p>
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-block">

                        <strong>{{ $error }}</strong>
                    </div>
                    @endforeach
                    <form method="POST" action="{{route('forget.password.submit')}}">
                        @csrf
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="text" name="email" class="form-control" placeholder="Email">
                        </div>
                      
                        <div class="text-center">
                        <button type="submit" class="btn login-btn">Forget Password</button>
                    </div>
                    </form>

                    <span>Not yet registered? <a href="<?php echo route('website.vendor.register'); ?>">Click Here</a></span>
                </div>
            </div>
        </div>
        <!-- End Login -->
        @endsection

@extends('frontend::layout.app')

@section('css')
<style>
/* Responsive padding adjustments for mobile devices */
@media (max-width: 768px) {
  .login-area.ptb-100 {
    padding-top: 50px !important;
    padding-bottom: 50px !important;
  }

  .login-item {
    padding: 20px 15px !important;
  }
}
</style>
@endsection

@section('content')
<div class="login-area ptb-100">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6">

        <div class="login-item">
          <h2 class="text-center">Forgot Password</h2>

          @if(session('status'))
          <div class="text-center" style="color: green; margin-bottom: 15px;">{{ session('status') }}</div>
          @endif

          <p style="text-align:center">Please provide the email address associated with your account to reset your
            password.</p>

          @foreach ($errors->all() as $error)
          <div class="alert alert-danger alert-block text-center">
            <strong>{{ $error }}</strong>
          </div>
          @endforeach

          <form method="POST" action="{{route('forget.password.submit')}}">
            @csrf
            <div class="form-group mb-3">
              <label>Email:</label>
              <input type="text" name="email" class="form-control" placeholder="Email">
            </div>

            <div class="text-center mt-4 mb-4">
              <button type="submit" class="btn login-btn">Forget Password</button>
            </div>
          </form>

          <div class="text-center mt-3">
            <span>Not yet registered? <a href="<?php echo route('website.vendor.register'); ?>">Click Here</a></span>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>
@endsection
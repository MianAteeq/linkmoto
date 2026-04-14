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
          <h2 class="text-center">Reset Password</h2>

          @foreach ($errors->all() as $error)
          <div class="alert alert-danger alert-block text-center">
            <strong>{{ $error }}</strong>
          </div>
          @endforeach

          <form method="POST" action="{{route('password.update')}}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="form-group mb-3">
              <label>New Password:</label>
              <input type="password" name="password" class="form-control" required placeholder="New Password">
            </div>

            <div class="form-group mb-3">
              <label>Confirm password:</label>
              <input type="password" name="password_confirmation" class="form-control" required
                placeholder="Confirm Password">
            </div>

            <div class="text-center mt-4 mb-4">
              <button type="submit" class="btn login-btn">Reset Password</button>
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
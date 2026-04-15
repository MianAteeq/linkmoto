@extends('frontend::layout.app')

@section('css')
<style>
/* Responsive padding adjustments */
@media (max-width: 768px) {
  .login-area.ptb-100 {
    padding-top: 50px !important;
    padding-bottom: 50px !important;
  }

  .login-item {
    padding: 30px 20px !important;
  }
}

/* Ensure the login item is properly contained */
.login-item {
  margin: 0 auto;
  width: 100%;
}
</style>
@endsection

@section('content')
<div class="login-area ptb-100">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6">

        <div class="login-item">
          <h2 class="text-center">Sign in to Motonos</h2>

          @foreach ($errors->all() as $error)
          <div class="alert alert-danger alert-block">
            <strong>{{ $error }}</strong>
          </div>
          @endforeach

          <form method="POST" action="{{ route('website.vendor.login.submit') }}">
            @csrf
            <div class="form-group mb-3">
              <label class="mb-1">Email:</label>
              <input type="text" name="email" class="form-control" placeholder="Email">
            </div>

            <div class="form-group mb-1">
              <label class="mb-1">Password:</label>
              <input type="password" name="password" class="form-control" placeholder="Password">
            </div>

            <div class="text-end mb-3">
              <a href="{{ route('forget.password') }}" class="small text-muted">Forgot password?</a>
            </div>

            <div class="text-center mb-3">
              <button type="submit" class="btn login-btn w-100">Login</button>
            </div>
          </form>

          <div class="text-center">
            <span>Not yet registered? <a href="<?php echo route('website.vendor.register'); ?>">Click Here</a></span>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
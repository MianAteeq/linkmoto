@extends('frontend::layout.app')

@section('css')
<style>
.thankyou-wrapper {
  width: 100%;
  height: auto;
  margin: auto;
  margin-top: 100px;
  background: #ffffff;
  padding: 10px 0px 50px;
}

.thankyou-wrapper h1 {
  font: 100px Arial, Helvetica, sans-serif;
  text-align: center;
  color: #333333;
  padding: 0px 10px 10px;
}

.thankyou-wrapper p {
  font: 26px Arial, Helvetica, sans-serif;
  text-align: center;
  color: #333333;
  padding: 5px 10px 10px;
}

.thankyou-wrapper a {
  font: 26px Arial, Helvetica, sans-serif;
  text-align: center;
  color: #ffffff;
  display: block;
  text-decoration: none;
  width: 250px;
  background: #E47425;
  margin: 10px auto 0px;
  padding: 15px 20px 15px;
  border-bottom: 5px solid #F96700;
}

.thankyou-wrapper a:hover {
  font: 26px Arial, Helvetica, sans-serif;
  text-align: center;
  color: #ffffff;
  display: block;
  text-decoration: none;
  width: 250px;
  background: #F96700;
  margin: 10px auto 0px;
  padding: 15px 20px 15px;
  border-bottom: 5px solid #F96700;
}

/* --- New Responsive Adjustments --- */
.responsive-spacing {
  margin-top: 100px;
  margin-bottom: 200px;
}

.content-container {
  max-width: 700px;
  margin: 0 auto;
  /* Centers the 700px block on large screens */
  padding: 0 15px;
  /* Gives text breathing room on mobile edges */
}

.content-container ul {
  text-align: left;
  display: inline-block;
  /* Keeps bullets aligned while container centers */
  margin: 0 auto;
}

@media (max-width: 768px) {
  .responsive-spacing {
    margin-top: 50px;
    /* Reduce huge top gap on mobile */
    margin-bottom: 80px;
    /* Reduce huge bottom gap on mobile */
  }

  .content-container h2 {
    font-size: 24px;
    /* Slightly scale down header for small screens */
  }

  .content-container ul {
    padding-left: 20px;
    /* Ensure bullets don't overflow on small screens */
  }
}
</style>
@endsection

@section('content')
<div class="address-area responsive-spacing">
  <div class="containers content-container" style="text-align: center;">
    <h2>Thank You for Registering!</h2>
    <p>You’re now on the list to join the Motonos Closed Beta!</p>
    <p>Thank you for registering your interest in joining the Motonos Closed Beta. Our team
      has received your submission and will review your garage profile.
      If your application is selected, we will contact you with next steps for full registration.</p>

    <p style="margin-top: 30px;">In the meantime, you can:</p>
    <ul>
      <li>Keep an eye on your email and mobile for updates from our team.</li>
      <li>Learn more about Motonos features on our website.</li>
    </ul>

    <p style="margin-top: 30px;">We appreciate your interest and look forward to connecting with you soon!</p>
  </div>
  <div class="clr"></div>
</div>
@endsection
@extends('frontend::layout.app')

@section('css')
<style>
/* Responsive Margins for large sections */
.responsive-margin-top {
  margin-top: 100px;
}

.responsive-margin-large {
  margin-top: 120px;
  margin-bottom: 200px;
}

/* Adjust margins for mobile screens */
@media (max-width: 768px) {
  .responsive-margin-top {
    margin-top: 50px !important;
  }

  .responsive-margin-large {
    margin-top: 60px !important;
    margin-bottom: 80px !important;
  }
}
</style>
@endsection

@section('content')
<div class="address-area responsive-margin-top px-3 px-md-0">
  <div class="containers container">
    <h2 class="text-center text-md-start">Join the Motonos Closed Beta</h2>
    <p style="text-align:center">Be among the first to try Motonos, the new platform designed for garages,
      mobile mechanics, and other automotive service providers to manage jobs,
      customers, and services — all in one place.</p>
    <div class="section mb-4">
      <h3>Why join the Beta?</h3>
      <ul>
        <li>Early Access – Be one of the first to use Motonos before public release.</li>
        <li>Tailored for You – Whether you run a garage, work as a mobile mechanic, or provide specialist
          services, the platform is designed to fit your workflow.</li>
        <li>Help Shape the App – Your feedback will directly influence new features and improvements.</li>
        <li>Exclusive Beta Perks – Access special benefits, early offers, and discounted rates when the app
          launches.</li>
        <li>Stay Ahead – Get tools that make managing jobs, customers, and services faster and simpler.</li>
      </ul>
    </div>

    <div class="section mb-4">
      <h3>What you’ll be testing?</h3>
      <p>During the beta, you’ll get access to early features such as:</p>
      <ul>
        <li>📅 Booking & Job Management – create, schedule, and track customer bookings and jobs</li>
        <li>🚗 Vehicle Records – store vehicle details and link them to customer history</li>
        <li>👤 Customer Records – manage customer details alongside their vehicles</li>
        <li>💰 Quotes & Invoices – generate and share directly with customers</li>
        <li>🔔 Notifications – keep customers updated on progress</li>
        <li>📱 Mobile-Friendly Access – use the app in your garage, on the move, or at a customer’s location
        </li>
      </ul>
      <p><strong>Note:</strong> These features are still under development — your feedback will help
        us improve them and decide what to build next.</p>
    </div>

    <div class="section mb-4">
      <h3>Looking ahead</h3>
      <p style="text-align:justify">The beta is just the beginning. We’ll continue to add new features and
        enhancements to make the platform even more useful for garages, mobile mechanics, and service
        providers.<br />
        By participating in the beta, you’ll have early access to these updates and the chance to shape how they
        evolve.<br />
        Note: Specific features are still under development and will be shared with testers as they become
        available.</p>
    </div>

    <div class="section mb-4">
      <h3>What’s involved?</h3>
      <ul>
        <li>The beta is free to join.</li>
        <li>You’ll use the app in your daily work — whether in a garage, on the move,
          or offering specialist services.</li>
        <li>Features are still under development, so some things may change or not
          always work perfectly.</li>
        <li>Your feedback will help us improve the platform for all types of service
          providers.</li>
        <li>Places are limited — we’ll contact selected applicants with access
          details.</li>
      </ul>
    </div>

    <div class="section mb-4">
      <h3 class="text-center text-md-start">Register Your Interest</h3>
      <p class="text-center text-md-start">Ready to join the Motonos Closed Beta? Click the button below to go to the
        registration page and submit your details.</p>
      <div style="text-align:center">
        <a href="https://Motonos-dev.fissionmonster.com/register" class="btn btn-primary px-4 py-2">Register Your
          Interest</a>
      </div>
    </div>

    <div class="section mb-4">
      <h3>Next steps</h3>
      <p>Once you’ve submitted your details, our team will review your application. If selected, you’ll receive an
        email with instructions on how to access the app and join the closed beta.</p>
      <p>👉 Whether you’re a garage, mobile mechanic, or service provider, you’ll be able to test the platform in
        real-world use and share feedback that helps us shape future features.</p>
    </div>

    <div class="section mb-4">
      <h3 class="text-center text-md-start">Questions?</h3>
      <p class="text-center text-md-start">Do you have any questions? Click the button below to get in touch with us.
      </p>
      <div style="text-align:center">
        <a href="https://Motonos-dev.fissionmonster.com/contact" class="btn btn-secondary px-4 py-2">Get in Touch</a>
      </div>
    </div>

  </div>
</div>
@endsection
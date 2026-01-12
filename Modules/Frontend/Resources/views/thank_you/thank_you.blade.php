@extends('frontend::layout.app')

@section('css')

<style>
    .thankyou-wrapper {
        width: 100%;
        height: auto;
        margin: auto;
        margin-top:100px;
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
</style>

@endsection
@section('content')
<div class="address-area" style="margin-top:100px;margin-bottom:200px;">
    <div class="containers" style="max-width: 700px;">
                    <h2>Thank You for Registering!</h2>
                    <p style="text-align:center">You’re now on the list to join the linkmoto Closed Beta!</p>
                    <p style="text-align:center">Thank you for registering your interest in joining the LinkMoto Closed Beta. Our team has received your submission and will review your garage profile. 
                    If your application is selected, we will contact you with next steps for full registration.</p>
                    <p style="text-align:center;margin-top: 30px;">In the meantime, you can:</p>
                    <ul>
                        <li>Keep an eye on your email and mobile for updates from our team.</li>
                        <li>Learn more about LinkMoto features on our website.</li>
                    </ul>
                    <p style="margin-top: 30px;">We appreciate your interest and look forward to connecting with you soon!</p>
                </div>
                <div class="clr"></div>
            </div>
        

@endsection

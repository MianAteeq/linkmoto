@extends('vender::layouts.master')

{{-- @section('header')
    <div class="content-header"
        style="border-bottom: 3px solid #949494; margin-bottom: 30px; padding-bottom: 15px; padding-top: 20px">
        <div class="container-fluid">
            <h3 style="font-weight: 400; font-size: 21px; color: #333; margin-bottom: 4px;">Getting Started</h3>
            <div style="color: #777; font-size: 14px; padding-left: 2px; padding-top: 5px;">Overview</div>
        </div>
    </div>
@endsection --}}

@section('css_custom')
    <style>
        /* --- EXACT MATCH ACCORDION STYLES --- */
        .custom-accordion-item {
            margin-bottom: 10px;
        }

        .custom-accordion-header {
            display: flex;
            align-items: center;
            min-height: 48px;
            border-radius: 7px;
            border: 2px solid black;
            padding: 12px 15px;
            padding-right: 40px !important;
            color: #000 !important;
            background-color: #fff;
            cursor: pointer;
            position: relative;
            font-weight: 400;
            font-size: 14px;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
        }

        .custom-accordion-header:hover {
            text-decoration: none;
            background-color: #fcfcfc;
        }

        .custom-accordion-header.active {
            border-bottom: none;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        /* The Dropdown Arrow Icon */
        .custom-accordion-header:before {
            content: "\e843";
            font-family: 'feather';
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%) rotate(270deg);
            transition: transform 0.3s ease;
            font-size: 16px;
            color: #000;
        }

        .custom-accordion-header.active:before {
            transform: translateY(-50%) rotate(90deg);
        }

        .custom-collapse-content {
            display: none;
            padding: 22px 25px;
            border-radius: 0 0 4px 4px;
            background: #fff;
            border: 1px solid #000;
            border-top: 1px solid #eaeaea;
            color: #333;
            line-height: 1.6;
            font-size: 14.5px;
        }

        /* Removed heavy bolding and set specific, professional sizes */
        .custom-collapse-content h2 {
            font-size: 22px;
            font-weight: 400;
            color: #222;
            margin-top: 0;
            margin-bottom: 12px;
        }

        .custom-collapse-content h3 {
            font-size: 18px;
            font-weight: 400;
            color: #222;
            margin-top: 22px;
            margin-bottom: 12px;
        }

        .custom-collapse-content h4 {
            font-size: 16px;
            font-weight: 500;
            color: #222;
            margin-top: 18px;
            margin-bottom: 10px;
        }

        .custom-collapse-content p {
            margin-bottom: 14px;
        }

        .custom-collapse-content ul,
        .custom-collapse-content ol {
            margin-bottom: 16px;
            padding-left: 24px;
        }

        .custom-collapse-content li {
            margin-bottom: 8px;
        }

        /* --- EXACT MATCH OVERVIEW SIDEBAR --- */
        .sidebar-overview {
            border-radius: 4px;
            border: 1px solid #000;
            background-color: #fff;
            padding-bottom: 15px;
            margin-bottom: 20px;
            box-shadow: none;
        }

        .sidebar-header {
            padding: 15px 15px 10px 10px;
            font-weight: 600;
            font-size: 15px;
            color: #000;
            border-bottom: none;
            display: flex;
            align-items: center;
            gap: 3px;
            background-color: transparent;
        }

        .sidebar-content {
            padding: 0 15px;
        }

        .overview-lead {
            font-size: 13px;
            font-weight: 600;
            color: #000;
            margin-bottom: 10px;
        }

        .sidebar-content p:not(.overview-lead) {
            line-height: 1.5;
            color: #333;
            font-size: 13px;
            margin-bottom: 12px;
        }

        /* Responsive Fixes */
        @media (min-width: 768px) and (max-width: 1199px) {
            .sidebar-overview {
                max-width: 100%;
                margin-bottom: 30px;
            }
        }

        @media (max-width: 767px) {
            .content-header .container-fluid {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }

            .custom-accordion-header {
                font-size: 13px;
            }
        }
         .btn-dark {
        border-color: black !important;
        background-color: black !important;
        color: #FFFFFF !important;
    }
    
        .custom-control-label::before {
            width: 1.5rem;
            height: 1.5rem;
            border: 2px solid black;
            margin-left: 1px;
        }

        .custom-control-label {
            position: relative;
            margin-bottom: 0;
            vertical-align: top;
            padding-left: 8px;
            padding-top: 3px;
        }

        .custom-control-input:checked~.custom-control-label::before {
            color: #fff;
            border-color: #f47c42;
            background-color: #f26723;
        }

        .custom-control-label::after {
            width: 1.5rem;
            height: 1.5rem;
            /* background: #f26723; */
        }

        /* Flexbox helper to push footer to bottom naturally */
        .flex-column-container {
            display: flex;
            flex-direction: column;
            min-height: 100%;
        }
    </style>

    <style>

body {
    background: #f5f7fb;
}

/* Main Wrapper */
.agreement-wrapper {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 20px;
}

/* Card */
.agreement-card {
    width: 100%;
    max-width: 980px;
    background: #ffffff;
    border-radius: 24px;
    padding: 40px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.06);
    border: 1px solid #ececec;
}

/* Top Header */
.agreement-top {
    margin-bottom: 30px;
}

.agreement-step {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #000;
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 18px;
}

.agreement-title {
    font-size: 32px;
    font-weight: 700;
    color: #111;
    margin-bottom: 10px;
}

.agreement-subtitle {
    font-size: 15px;
    color: #666;
    line-height: 1.6;
}

/* Scroll Box */
.agreement-content {
    height: 420px;
    overflow-y: auto;
    border: 1px solid #e9e9e9;
    border-radius: 18px;
    padding: 30px;
    background: #fafafa;
    line-height: 1.9;
    color: #333;
    font-size: 15px;
}

/* Custom Scroll */
.agreement-content::-webkit-scrollbar {
    width: 6px;
}

.agreement-content::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 10px;
}

/* Checkbox Area */
.agreement-check {
    margin-top: 28px;
    padding: 20px;
    border-radius: 16px;
    background: #f8f8f8;
    border: 1px solid #ececec;
}

.custom-control-label {
    font-size: 15px;
    color: #333;
    padding-left: 10px;
    line-height: 1.7;
}

.custom-control-label::before {
    width: 22px;
    height: 22px;
    border-radius: 6px;
    border: 2px solid #000;
}

.custom-control-input:checked ~ .custom-control-label::before {
    background-color: #000;
    border-color: #000;
}

/* Footer Buttons */
.agreement-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 35px;
}

/* Buttons */
.btn-modern {
    min-width: 140px;
    height: 52px;
    border-radius: 14px;
    border: none;
    font-weight: 600;
    font-size: 14px;
    transition: 0.25s ease;
}

.btn-primary-modern {
    background: #000;
    color: #fff;
}

.btn-primary-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.12);
}

.btn-secondary-modern {
    background: #f1f1f1;
    color: #111;
}

.btn-secondary-modern:hover {
    background: #e5e5e5;
}

/* Error */
.agreement-error {
    font-size: 13px;
    margin-top: 10px;
}

/* Responsive */
@media(max-width:768px){

    .agreement-card{
        padding: 24px;
    }

    .agreement-title{
        font-size: 24px;
    }

    .agreement-content{
        height: 340px;
        padding: 20px;
    }

    .agreement-footer{
        flex-direction: column;
        gap: 12px;
    }

    .btn-modern{
        width: 100%;
    }
}

</style>
@endsection

@section('content')
<div class="agreement-wrapper">

    <div class="agreement-card">

        <form id="detailsForm" action="{{ route('vender.agreements.submit') }}" method="POST">

            @csrf

            {{-- PRIVACY STEP --}}
            <div id="privacyStep">

                <div class="agreement-top">

                    <div class="agreement-step">
                        1
                    </div>

                    <div class="agreement-title">
                        Privacy Policy
                    </div>

                    <div class="agreement-subtitle">
                        Please carefully review and accept the privacy policy before continuing.
                    </div>

                </div>

                <div class="agreement-content">
                    {!! $setting['privacy_policy'] ?? '' !!}
                </div>

                <div class="agreement-check">

                    <div class="custom-control custom-checkbox">

                        <input
                            type="checkbox"
                            class="custom-control-input"
                            id="is_privacy_policy"
                            name="is_privacy_policy"
                        >

                        <label class="custom-control-label" for="is_privacy_policy">
                            I confirm that I have read, understood and agree to the Privacy Policy.
                        </label>

                    </div>

                    <p
                        class="text-danger agreement-error"
                        id="privacyError"
                        style="display:none;"
                    >
                        You must accept the privacy policy to continue.
                    </p>

                </div>

                <div class="agreement-footer">

                    <div></div>

                    <button
                        type="button"
                        onclick="showTermsStep()"
                        class="btn-modern btn-primary-modern"
                    >
                        Continue
                    </button>

                </div>

            </div>

            {{-- TERMS STEP --}}
            <div id="termsStep" style="display:none;">

                <div class="agreement-top">

                    <div class="agreement-step">
                        2
                    </div>

                    <div class="agreement-title">
                        Terms & Conditions
                    </div>

                    <div class="agreement-subtitle">
                        Please review the terms and conditions carefully before finishing setup.
                    </div>

                </div>

                <div class="agreement-content">
                    {!! $setting['term_condition'] ?? '' !!}
                </div>

                <div class="agreement-check">

                    <div class="custom-control custom-checkbox">

                        <input
                            type="checkbox"
                            class="custom-control-input"
                            id="is_terms"
                            name="is_terms"
                        >

                        <label class="custom-control-label" for="is_terms">
                            I confirm that I have read, understood and agree to the Terms & Conditions.
                        </label>

                    </div>

                    <p
                        class="text-danger agreement-error"
                        id="termsError"
                        style="display:none;"
                    >
                        You must accept the terms to continue.
                    </p>

                </div>

                <div class="agreement-footer">

                    <button
                        type="button"
                        onclick="backToPrivacy()"
                        class="btn-modern btn-secondary-modern"
                    >
                        Back
                    </button>

                    <button
                        type="button"
                        onclick="submitDetailsForm()"
                        class="btn-modern btn-primary-modern"
                    >
                        Finish Setup
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection
@section('scripts_lib')

<script>

    function showTermsStep() {

        let privacyChecked = document.getElementById('is_privacy_policy').checked;

        if (!privacyChecked) {

            document.getElementById('privacyError').style.display = 'block';

            return;
        }

        document.getElementById('privacyError').style.display = 'none';

        document.getElementById('privacyStep').style.display = 'none';

        document.getElementById('termsStep').style.display = 'block';
    }

    function backToPrivacy() {

        document.getElementById('privacyStep').style.display = 'block';

        document.getElementById('termsStep').style.display = 'none';
    }

    function submitDetailsForm() {

        let termsChecked = document.getElementById('is_terms').checked;

        if (!termsChecked) {

            document.getElementById('termsError').style.display = 'block';

            return;
        }

        document.getElementById('termsError').style.display = 'none';

        document.getElementById('detailsForm').submit();

        // submit form here
    }

</script>

@endsection

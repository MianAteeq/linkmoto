@extends('vender::layouts.master')

@section('css_custom')
<style>

body {
    background: #f5f7fb;
}

.agreement-wrapper {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 20px;
}

.agreement-card {
    width: 100%;
    max-width: 980px;
    background: #ffffff;
    border-radius: 24px;
    padding: 40px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.06);
    border: 1px solid #ececec;
}

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

.agreement-content::-webkit-scrollbar {
    width: 6px;
}

.agreement-content::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 10px;
}

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

.agreement-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 35px;
}

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

.btn-secondary-modern {
    background: #f1f1f1;
    color: #111;
}

.agreement-error {
    font-size: 13px;
    margin-top: 10px;
}

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

                    <div class="agreement-step">1</div>

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

                    <div class="agreement-step">2</div>

                    <div class="agreement-title">
                        Terms & Conditions
                    </div>

                    <div class="agreement-subtitle">
                        Please review the terms carefully before continuing.
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
                        onclick="showNdaStep()"
                        class="btn-modern btn-primary-modern"
                    >
                        Next
                    </button>

                </div>

            </div>

            {{-- NDA STEP --}}
            <div id="ndaStep" style="display:none;">

                <div class="agreement-top">

                    <div class="agreement-step">3</div>

                    <div class="agreement-title">
                        NDA
                    </div>

                    <div class="agreement-subtitle">
                        Please review the NDA carefully before finishing setup.
                    </div>

                </div>

                <div class="agreement-content">
                    {!! $setting['nda'] ?? '' !!}
                </div>

                <div class="agreement-check">

                    <div class="custom-control custom-checkbox">

                        <input
                            type="checkbox"
                            class="custom-control-input"
                            id="is_nda"
                            name="is_nda"
                        >

                        <label class="custom-control-label" for="is_nda">
                            I confirm that I have read, understood and agree to the NDA.
                        </label>

                    </div>

                    <p
                        class="text-danger agreement-error"
                        id="ndaError"
                        style="display:none;"
                    >
                        You must accept the NDA to continue.
                    </p>

                </div>

                <div class="agreement-footer">

                    <button
                        type="button"
                        onclick="backToTerms()"
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
        document.getElementById('ndaStep').style.display = 'none';
    }

    function showNdaStep() {

        let termsChecked = document.getElementById('is_terms').checked;

        if (!termsChecked) {

            document.getElementById('termsError').style.display = 'block';
            return;
        }

        document.getElementById('termsError').style.display = 'none';

        document.getElementById('privacyStep').style.display = 'none';
        document.getElementById('termsStep').style.display = 'none';
        document.getElementById('ndaStep').style.display = 'block';
    }

    function backToPrivacy() {

        document.getElementById('privacyStep').style.display = 'block';
        document.getElementById('termsStep').style.display = 'none';
        document.getElementById('ndaStep').style.display = 'none';
    }

    function backToTerms() {

        document.getElementById('privacyStep').style.display = 'none';
        document.getElementById('termsStep').style.display = 'block';
        document.getElementById('ndaStep').style.display = 'none';
    }

    function submitDetailsForm() {

        let ndaChecked = document.getElementById('is_nda').checked;

        if (!ndaChecked) {

            document.getElementById('ndaError').style.display = 'block';
            return;
        }

        document.getElementById('ndaError').style.display = 'none';

        document.getElementById('detailsForm').submit();
    }

</script>

@endsection
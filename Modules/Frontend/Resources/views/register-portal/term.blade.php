@extends('frontend::new-layouts.master')

@section('css')
    <style>
        hr {
            margin-top: 0rem;
            margin-bottom: 0rem;
            border: 0;
            border-top: 2px solid rgba(0, 0, 0, 0.1);
        }

        a {
            color: black !important;
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
    <div class="content-body">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12">
                <h3 class="h3">Business registration application</h3>
            </div>

        </div>

        <div class="row" style="margin-top: 10px;">
            <div class="col-md-4">
                <div style="border-radius: 7px;border: 2px solid black;">

                    <h4 class="h3"
                        style="border-radius: 7px;padding: 10px;font-weight: 600;
            font-size: 17px; ">
                        <img src="/home.png" style="width: 22px;margin-top: -5px;"> Agreements –
                        Privacy Policy</h2>
                        <p style="padding-left: 10px; padding-right: 10px;">
                            The Privacy Policy explains what
                            data we collect (business info,
                            customer details, usage data),
                            how we use it, and your rights
                            under UK GDPR.
                        </p>
                </div>




            </div>

            <div class="col-md-8" style="border: 2px solid black;border-radius: 8px;padding:inherit">
                <form action="{{ route('vender.profile.terms') }}" method="POST" id="contens"> @csrf

                    <input type="hidden" id="is_save_later" name="is_save_later" value="0">
                    <div class="link-body" style="padding: 10px">
                        <div class="form-group">
                            <p style="font-size:15px; font-weight:500;">
                                To complete your registration for the LinkMoto closed beta, you must review and agree to the
                                following agreement.
                                Please read carefully before confirming
                            </p>

                            <div
                                style="height: 300px; overflow-y: scroll; border: 3px solid #e0e0e0; padding: 20px; margin-bottom: 10px; scrollbar-width: none;">
                                <h2 data-start="190" data-end="211" class=""><span data-start="193" data-end="211"
                                        style="">
                                        <font color="#000000" style="">Privacy Policy</font>
                                    </span></h2>
                                <p data-start="213" data-end="246">
                                    <font color="#000000" style=""><strong data-start="213" data-end="230">Last
                                            Updated:</strong> October 6, 2025</font>
                                </p>
                                <p data-start="248" data-end="494">
                                    <font color="#000000" style="">At Link Moto, we value your privacy and are
                                        committed to protecting your personal data. This Privacy Policy explains how we
                                        collect, use, and protect the information you provide to us when you use our
                                        website, products, or services.</font>
                                </p>
                                <h3 data-start="501" data-end="534" class=""><span data-start="505" data-end="534"
                                        style="">
                                        <font color="#000000">1. Information We Collect</font>
                                    </span></h3>
                                <p data-start="535" data-end="585">
                                    <font color="#000000" style="">We may collect the following types of information:
                                    </font>
                                </p>
                                <ul>
                                    <li>
                                        <font color="#000000" style=""><strong data-start="588"
                                                data-end="613">Personal Information:</strong> Name, email address, phone
                                            number, billing and shipping addresses, and payment details.</font>
                                    </li>
                                    <li>
                                        <font color="#000000" style=""><strong data-start="704" data-end="728">Account
                                                Information:</strong> Username, password, and preferences.</font>
                                    </li>
                                    <li>
                                        <font color="#000000" style=""><strong data-start="768" data-end="783">Usage
                                                Data:</strong> IP address, browser type, device information, and pages
                                            visited.</font>
                                    </li>
                                    <li>
                                        <font color="#000000" style=""><strong data-start="851" data-end="876">Cookies
                                                and Tracking:</strong> To improve user experience and analytics.</font>
                                    </li>
                                </ul>
                                <h3 data-start="925" data-end="963" class=""><span data-start="929" data-end="963"
                                        style="">
                                        <font color="#000000">2. How We Use Your Information</font>
                                    </span></h3>
                                <p data-start="964" data-end="1009">
                                    <font color="#000000" style="">We use your information for purposes such as:
                                    </font>
                                </p>
                                <p data-start="964" data-end="1009">
                                    <font color="#000000" style="">Providing and managing our services.</font>
                                </p>
                                <ul>
                                    <li>
                                        <font color="#000000" style="">Processing orders and payments.</font>
                                    </li>
                                    <li>
                                        <font color="#000000" style="">Sending important updates or promotional
                                            messages (with your consent).</font>
                                    </li>
                                    <li>
                                        <font color="#000000" style="">Improving our website and customer experience.
                                        </font>
                                    </li>
                                    <li>
                                        <font color="#000000" style="">Complying with legal and regulatory
                                            obligations.</font>
                                    </li>
                                </ul>
                                <h3 data-start="1262" data-end="1288" class=""><span data-start="1266"
                                        data-end="1288" style="">
                                        <font color="#000000">3. Data Protection</font>
                                    </span></h3>
                                <p>
                                </p>
                                <p data-start="1289" data-end="1447">
                                    <font color="#000000" style="">We implement appropriate technical and
                                        organizational measures to protect your personal data from unauthorized access,
                                        alteration, disclosure, or destruction.</font>
                                </p>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="is_privacy_policy"
                                            {{ $user['profile']['is_privacy_policy'] == 1 ? 'checked' : '' }}
                                            name="is_privacy_policy" value="1" required>
                                        <label class="custom-control-label" for="is_privacy_policy">
                                            I confirm that I have read, understood, and agree to the above Privacy Policy.
                                            <span style="color:red">*</span>
                                        </label>
                                    </div>
                                    <p class="text-danger confirm_authorised" style="display:none;">
                                        You must agree this before proceeding.
                                    </p>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="footers">
                        <button type="button" onclick="submitDetailsForm()"
                            class="btn btn-dark round btn-min-width mr-1 mb-1" style="float: right;">NEXT</button>
                        <button onclick="saveforlater()" type="button"
                            class="btn btn-dark round btn-min-width mr-1 mb-1" style="float: right;">SAVE AND
                            EXIT</button>
                        <a href="{{ route('vender.profile.back', $user['profile']['step']) }}"> <button type="button"
                                class="btn btn-dark round btn-min-width mr-1 mb-1"
                                style="float: right;">PREVIOUS</button></a>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            var contentHeight = $('#contens').height();
            $('#contens').height(contentHeight);
        });
    </script>
    <script>
        function submitDetailsForm() {
            var checked = $('input[name=is_privacy_policy]').is(":checked");


            if (checked === true) {

                $("form").submit();
            } else {

                $('.confirm_authorised').show();

            }










        }

        $('input[type=checkbox]').change(function() {
            var checked = $('input[name=is_privacy_policy]').is(":checked");

            console.log(checked)


            if (checked === true) {
                $('.agree').hide();

            } else {

                $('.agree').show();

            }
        });
    </script>

    <script>
        function saveforlater() {
            $('#is_save_later').val(1);
            $("form").submit();
        }
    </script>
@endsection

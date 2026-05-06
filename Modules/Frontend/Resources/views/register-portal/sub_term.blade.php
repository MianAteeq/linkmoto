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

        /* Flexbox helper to push footer to bottom naturally */
        .flex-column-container {
            display: flex;
            flex-direction: column;
            min-height: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="content-body pb-1">

        <div class="row" style="border-bottom: 3px solid #949494; margin-bottom: 15px;">
            <div class="col-xl-12 col-12 px-1 px-md-2">
                <h3 class="h3" style="font-weight: 800; font-size: 18px; color: black; margin-bottom: 14px;">
                    Business registration application
                </h3>
            </div>
        </div>

        <div class="px-1 px-md-1">
            <div class="row" style="margin-top: 20px;">

                <div class="col-12 col-lg-4 mb-2 mb-lg-0">
                    <div style="border-radius: 7px; border: 2px solid black;">
                        <h4 class="h3" style="padding: 10px; font-weight: 600; font-size: 17px; margin-bottom: 0;">
                            <img src="/home.png" style="width: 22px; margin-top: -5px;"> Agreements – Subscription T&Cs
                        </h4>
                        <p style="padding-left: 10px; padding-right: 10px; padding-bottom: 10px;">
                            The Subscription Terms & Conditions confirms that participation in the beta is free
                            and that any future subscription will be optional and subject to full Subscription Terms &
                            Conditions.
                        </p>
                    </div>
                </div>

                <div class="col-12 col-lg-8 body-height">
                    <form action="{{ route('vender.profile.terms', ['requestType' => 'sub_term']) }}" method="POST"
                        id="contens" class="flex-column-container h-100"
                        style="border: 2px solid black; border-radius: 8px; overflow: hidden;">
                        @csrf
                        <input type="hidden" id="is_save_later" name="is_save_later" value="0">

                        <div class="link-body" style="padding: 10px; flex-grow: 1;">
                            <div class="form-group">
                                <p style="font-size:15px; font-weight:500;">
                                    To complete your registration for the Motonos closed beta, you must review and agree to
                                    the following agreement. Please read carefully before confirming
                                </p>

                                <div
                                    style="height: 300px; overflow-y: scroll; border: 3px solid #e0e0e0; padding: 20px; margin-bottom: 10px; scrollbar-width: none;">
                                    
                                    <p>{!! $setting['subscription_term_condition'] ?? '' !!}</p>
                                </div>

                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="is_sub"
                                                {{ $user['profile']['is_sub'] == 1 ? 'checked' : '' }} name="is_sub"
                                                value="1" required>
                                            <label class="custom-control-label" for="is_sub">
                                                I confirm that I have read, understood, and agree to the above Subscription
                                                Terms & Conditions.
                                                <span style="color:red">*</span>
                                            </label>
                                        </div>
                                        <p class="text-danger confirm_authorised"
                                            style="display:none; padding-left: 10px; margin-top: 5px;">
                                            You must agree this before proceeding.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="footers d-flex flex-wrap justify-content-center justify-content-md-end w-100 mt-auto"
                            style="gap: 10px; padding: 15px; ">
                            <a href="{{ route('vender.profile.back', $user['profile']['step']) }}"
                                class="btn btn-dark round btn-min-width" style="color: white !important;">
                                PREVIOUS
                            </a>
                            <button onclick="saveforlater()" type="button" class="btn btn-dark round btn-min-width">
                                SAVE AND EXIT
                            </button>
                            <button type="button" onclick="submitDetailsForm()" class="btn btn-dark round btn-min-width">
                                NEXT
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // JS fixed height calculation removed to allow responsive scaling.

        function submitDetailsForm() {
            var checked = $('input[name=is_sub]').is(":checked");

            if (checked === true) {
                $("form").submit();
            } else {
                $('.confirm_authorised').show();
            }
        }

        $('input[type=checkbox]').change(function() {
            var checked = $('input[name=is_sub]').is(":checked");
            console.log(checked)

            if (checked === true) {
                $('.agree').hide();
                $('.confirm_authorised').hide(); // Also hide the validation message when they check it
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

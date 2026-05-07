@extends('frontend::new-layouts.master')

@section('css')
    <style>
        hr {
            margin-top: 0rem;
            margin-bottom: 0rem;
            border: 0;

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
                    Business registration application @if($user['application_status'] == 'Request for Info' || $user['application_status'] == 'PENDING')
                                            <span class="badge badge-info" style="padding: 0.5em 0.6em;font-size: 13px;"> Request
                                                for Info
                                            </span>
                                            @elseif ($user['application_status'] == 'DECLINE')
                                            <span class="badge badge-info" style="padding: 0.5em 0.6em;font-size: 13px;background-color: black!important; color: white;"> Decline
                                            </span>
                                            @else
                                             <span class="badge badge-success" style="padding: 0.5em 0.6em;font-size: 13px;"> In Review
                                            </span>


                                            @endif
                </h3>
            </div>
        </div>

        <div class="px-1 px-md-1">
            <div class="row" style="margin-top: 20px;">

                <div class="col-12 col-lg-4 mb-2 mb-lg-0">
                    <div class="" style="border-radius: 7px; border: 2px solid black;">
                        <h4 class="h3" style="padding: 10px;font-weight: 600;font-size: 17px; ">
                            <img src="/home.png" style="width: 22px;margin-top: -5px;"> VAT
                        </h4>

                        <div class="footers" id="show_help">
                            <h4 style="padding-left: 13px; color: black; font-weight: 600;">Help information: </h4>
                            <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                                <div class="card accordion collapse-icon accordion-icon-rotate"
                                    style="box-shadow: none;margin-right: 10px;margin-left: 10px;">
                                    <a id="business_VAT" class="card-header info collapsed" data-toggle="collapse"
                                        href="#collapsebusiness_vat" aria-expanded="false"
                                        aria-controls="collapsebusiness_vat">
                                        <div class="card-title lead">UK VAT Number (?)</div>
                                    </a>
                                    <div id="collapsebusiness_vat" data-parent="#accordionWrap1" role="tabpanel"
                                        aria-labelledby="business_VAT" class="collapse" style="">
                                        <div class="card-content">
                                            <div class="card-body">
                                                A VAT number is a unique identification number given to VAT-registered
                                                businesses. In England, Scotland and Wales, a VAT number is a nine-digit
                                                code
                                                with the prefix ‘GB’. VAT numbers are issued by HMRC.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-8 body-height">
                    <form action="{{ route('vender.profile.vat') }}" method="POST" id="contens"
                        class="flex-column-container h-100"
                        style="border: 2px solid black; border-radius: 8px; overflow: hidden;">
                        @csrf
                        <input type="hidden" id="is_save_later" name="is_save_later" value="0">

                        <div class="link-body" style="padding: 10px; flex-grow: 1;">
                            <div class="form-group row">
                                <label class="col-12 col-md-4 label-control">Is your business UK VAT registered <span
                                        style="color: red">*</span> </label>
                                <div class="col-12 col-md-8 mx-auto">
                                    <div class="input-group d-flex flex-wrap" style="gap: 15px;">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="vat_register" value="YES"
                                                class="custom-control-input"
                                                @if ($user['profile']['vat_register'] == 'YES') checked @endif id="Yes">
                                            <label class="custom-control-label" for="Yes">Yes</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="vat_register" value="NO"
                                                class="custom-control-input"
                                                @if ($user['profile']['vat_register'] == 'NO') checked @endif id="No">
                                            <label class="custom-control-label" for="No">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row uk-vat-form"
                                @if ($user['profile']['vat_register'] == 'NO') style="display: none" @endif>
                                <label class="col-12 col-md-4 label-control" for="uk_vat_no">UK VAT Number <span
                                        style="color: red">*</span>
                                    <a style="color: black" href="#collapsebusiness_vat" data-toggle="collapse"
                                        aria-expanded="false" aria-controls="collapsebusiness">(?)</a></label>
                                <div class="col-12 col-md-8 mx-auto">
                                    <input type="tel" id="uk_vat_no" onkeyup="lookup(this);"
                                        value="{{ $user['profile']['uk_vat_no'] }}" class="form-control" name="uk_vat_no"
                                        required placeholder="">
                                    <p class="text-danger uk_vat_no"
                                        style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">
                                        UK VAT Number is Required !</p>
                                </div>
                            </div>
                        </div>

                        <div class="footers d-flex flex-wrap justify-content-center justify-content-md-end w-100 mt-auto"
                            style="gap: 10px; padding: 15px; ">
                            @if ($user['profile']['edit_step'] == 0)
                                <a href="{{ route('vender.profile.back', 5) }}" class="btn btn-dark round btn-min-width">
                                    PREVIOUS
                                </a>
                                <button type="button" onclick="saveforlater()" class="btn btn-dark round btn-min-width">
                                    SAVE AND EXIT
                                </button>
                                <button type="button" class="btn btn-dark round btn-min-width"
                                    onclick="submitDetailsForm()">
                                    NEXT
                                </button>
                            @else
                                <button type="button" class="btn btn-dark round btn-min-width"
                                    onclick="submitDetailsForm()">
                                    Update
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // JS height calculation removed. Container expands naturally with Flexbox.
            let value = $('input[type=radio]:checked').val();

            if (value == 'YES') {
                $('#uk_vat_no').attr("required", true);
                $('#show_help').show();
                $('.body-height').css('height:250px');
            } else {
                $('#uk_vat_no').attr("required", false);
                $('#show_help').hide();
                $('.body-height').css('height', '180px');
            }
        });
    </script>

    <script>
        $('input[type=radio]').change(function() {
            if (this.value == 'YES') {
                $('.uk-vat-form').show();
                $('#uk_vat_no').attr("required", true);
                $('#show_help').show();
                $('.body-height').css('height', '250px');
            } else {
                $('.uk-vat-form').hide();
                $('#uk_vat_no').attr("required", false);
                $('#show_help').hide();
                $('.body-height').css('height', '180px');
            }
        });
    </script>

    <script>
        function submitDetailsForm() {
            let is_vat = $('input[type=radio]:checked').val();
            console.log(is_vat);

            if (is_vat == "NO") {
                $("form").submit();
            } else {
                let uk_vat_no = $('#uk_vat_no').val();
                if (uk_vat_no === "") {
                    $('.uk_vat_no').show();
                    $('#uk_vat_no').attr('style', 'border:2px solid red!important');
                    status = false;
                    return false;
                } else {
                    $('.uk_vat_no').hide();
                    $('#uk_vat_no').attr('style', 'border:2px solid black!important');
                    status = true;
                    $("form").submit();
                }
            }
        }
    </script>

    <script>
        async function lookup(arg) {
            var id = arg.getAttribute('id');
            var value = arg.value;

            let trading_name = $(`#${id}`).val();
            if (trading_name === "") {
                $(`#${id}`).attr("style", "border:2px solid red!important;");
            } else {
                $(`#${id}`).attr("style", "border:2px solid black!important;");
                $(`.${id}`).hide();
            }
        }
    </script>

    <script>
        function saveforlater() {
            $('#is_save_later').val(1);
            $("form").submit();
        }
    </script>
@endsection

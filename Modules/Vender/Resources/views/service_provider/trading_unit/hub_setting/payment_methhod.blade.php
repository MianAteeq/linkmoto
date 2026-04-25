@extends('vender::layouts.master')

@section('css_custom')
    <style>
        /* --- ORIGINAL STYLES --- */
        .footers {
            /* position: absolute; */
            bottom: 0;
            left: 0;
            border-top: 2px solid black;
            padding-top: 5px;
            width: 100%;
        }

        .btn-dark {
            border-color: black !important;
            background-color: black !important;
            color: #FFFFFF;
        }

        .round {
            border-radius: 0.5rem;
        }

        form .form-control {
            border: 2px solid #000000;
            color: #000000;
        }

        p {
            color: black;
        }

        .form-control:focus {
            color: #000000;
            background-color: #fff;
            border-color: #000000;
            outline: 0;
            box-shadow: none;
        }

        #headingCollapse1:before {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e845" !important;
            transition: all 300ms linear 0s;
        }

        /* --- RESPONSIVE FIXES (Overrides inline styles safely) --- */

        /* 1. Base Mobile-First Rules */
        .form-control {
            width: 100%;
            /* Prevents input overflow on small screens */
        }

        .breadcrumb-wrapper {
            overflow-x: auto;
            /* Allows long breadcrumbs to be swiped horizontally */
            white-space: nowrap;
            padding-bottom: 5px;
        }

        /* Fix Sidebar Title & Image Floats */
        .col-md-3 h4>div:first-child {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .col-md-3 h4>div:first-child>div {
            float: none !important;
            width: auto !important;
        }

        /* Fix Content Header Links (Overview, App Settings, etc.) */
        #contens>.row:first-child {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 0 15px;
        }

        #contens>.row:first-child a {
            display: block;
            width: 100%;
        }

        #contens>.row:first-child h4 {
            margin-left: 0 !important;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
        }

        /* Fix Footer Buttons layout */
        .footers {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            padding-bottom: 15px;
        }

        .footers a,
        .footers button {
            width: 100% !important;
            float: none !important;
            margin: 0 !important;
        }

        .checkboxsas {
            margin-bottom: 10px;
        }

        /* 2. Desktop Rules (md & up) */
        @media (min-width: 768px) {
            .form-control {
                width: 55%;
                /* Restores your original design width */
            }

            /* Restore header links horizontal layout */
            #contens>.row:first-child {
                flex-direction: row;
            }

            #contens>.row:first-child a {
                width: auto;
            }

            #contens>.row:first-child h4 {
                margin-left: 15px !important;
                text-align: left;
            }

            /* Restore sidebar buttons layout */
            .col-md-3 .footers {
                flex-direction: column;
                align-items: center;
            }

            .col-md-3 .footers a {
                width: 80% !important;
            }

            /* Restore form action buttons (Save/Cancel) */
            #contens form .footers {
                flex-direction: row;
                justify-content: flex-end;
                padding-right: 15px;
            }

            #contens form .footers a,
            #contens form .footers button {
                width: auto !important;
            }
        }

        @media (max-width: 767px) {
            .headerbg {
                padding-left: 15px !important;
                /* Adjusts the 32px padding for mobile screens */
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3">Edit Payment Method</h3>
                <div class="breadcrumb-wrapper col-12 p-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Products</a>
                        </li>


                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.service.provider') }}">Service
                                Provider</a>
                        </li>
                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.service.provider.trading.unit') }}">Trade Units</a>
                        </li>
                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.service.provider.trading.unit.view', $trading_unit['id']) }}">
                                {{ $trading_unit['name'] }}</a>
                        </li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('vender.service.provider.trading.unit.app.setting', $trading_unit['id']) }}"
                                style="color: black">App Settings</a></li>
                        <li class="breadcrumb-item"> <a
                                href="{{ url('vender/service/provider/trading/unit/app/setting/' . $trading_unit['id']) }}#payment_method"
                                style="color: black">Payment Methods</a>
                        </li>
                        <li class="breadcrumb-item"> Edit Payment Method
                        </li>



                    </ol>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('content')
    <style>
        #headingCollapse1::before,
        #headingCollapse1::after {
            display: none !important;
        }

        #headingCollapse1[aria-expanded="true"] .custom-arrow {
            transform: rotate(180deg);
        }
    </style>

    <div class="row">
        <div class="col-12 col-lg-3" style="margin-bottom: 20px;">
            <div
                style="border-radius: 7px; border: 2px solid black; background: white; display: flex; flex-direction: column; overflow: hidden;">

                <div style="padding: 15px; display: flex; flex-direction: column; gap: 12px;">
                    <div style="display: flex; align-items: flex-start; gap: 10px;">
                        <img src="/trading_unit.png" style="width: 22px; flex-shrink: 0; margin-top: 2px;">
                        <span style="font-weight: 600; font-size: 16px; line-height: 1.3; color: black;">Trading Unit :
                            {{ $trading_unit['name'] }}</span>
                    </div>

                    <div style="font-weight: 500; font-size: 13px; color: black;">
                        Trading Name : {{ $trading_unit['trading_name']['name'] ?? '' }}
                    </div>

                    <div style="font-weight: 500; font-size: 13px; color: #28a745;">
                        {{ $trading_unit['status'] }}
                    </div>

                    <div style="font-weight: 500; font-size: 13px; color: #28a745;">
                        {{ $trading_unit['active_status'] }}
                    </div>

                    <div style="font-weight: 500; font-size: 13px; color: black;">
                        Created: {{ \Carbon\Carbon::parse($trading_unit['created_at'])->format('d/m/Y') }} at
                        {{ \Carbon\Carbon::parse($trading_unit['created_at'])->format('h:i') }}
                    </div>
                </div>

                <div style="border-top: 2px solid black; padding: 15px; display: flex; flex-direction: column; gap: 10px;">
                    @if ($trading_unit['status'] == 'PENDING' || $trading_unit['status'] == 'INACTIVE')
                        <a href="{{ route('vender.service.provider.trading.unit.active', $trading_unit['id']) }}"
                            style="text-decoration: none;">
                            <button type="button" class="btn btn-dark"
                                style="width: 100%; border-radius: 5px; background: black; color: white; border: none; padding: 10px; font-weight: 600; white-space: normal;">ACTIVATE
                                TRADE UNIT</button>
                        </a>
                    @else
                        <a href="{{ route('vender.service.provider.trading.unit.in.active', $trading_unit['id']) }}"
                            style="text-decoration: none;">
                            <button type="button" class="btn btn-dark"
                                style="width: 100%; border-radius: 5px; background: black; color: white; border: none; padding: 10px; font-weight: 600; white-space: normal;">INACTIVATE
                                TRADE UNIT</button>
                        </a>
                    @endif

                    @if ($trading_unit['active_status'] == 'OFFLINE')
                        <a href="{{ route('vender.service.provider.trading.unit.Online', $trading_unit['id']) }}"
                            style="text-decoration: none;">
                            <button type="button" class="btn btn-dark"
                                style="width: 100%; border-radius: 5px; background: black; color: white; border: none; padding: 10px; font-weight: 600; white-space: normal;">SHOW
                                ONLINE</button>
                        </a>
                    @else
                        <a href="{{ route('vender.service.provider.trading.unit.offline', $trading_unit['id']) }}"
                            style="text-decoration: none;">
                            <button type="button" class="btn btn-dark"
                                style="width: 100%; border-radius: 5px; background: black; color: white; border: none; padding: 10px; font-weight: 600; white-space: normal;">SHOW
                                OFFLINE</button>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-9" id="contens" style="margin-bottom: 20px;">

            <div class="row" style="display: flex; gap: 12px; margin-left: 15px; margin-bottom: 20px;">
                <a href="{{ route('vender.service.provider.trading.unit.view', $trading_unit['id']) }}"
                    style="text-decoration: none;">
                    <div
                        style="border: 2px solid black; border-radius: 5px; padding: 8px 20px; color: black; font-weight: 600; font-size: 15px; background: white;">
                        Overview</div>
                </a>
                <a href="{{ route('vender.service.provider.trading.unit.app.setting', $trading_unit['id']) }}"
                    style="text-decoration: none;">
                    <div
                        style="border: 2px solid #ff6600; border-radius: 5px; padding: 8px 20px; color: #ff6600; font-weight: 600; font-size: 15px; background: white;">
                        App settings</div>
                </a>
                <a href="{{ route('vender.service.provider.trading.unit.app.data', $trading_unit['id']) }}"
                    style="text-decoration: none;">
                    <div
                        style="border: 2px solid black; border-radius: 5px; padding: 8px 20px; color: black; font-weight: 600; font-size: 15px; background: white;">
                        App data</div>
                </a>
            </div>

            <div
                style="border: 2px solid black; border-radius: 7px; background: white; margin-left: 15px; overflow: hidden;">

                <a id="headingCollapse1" href="#collaptr_businesss_info"
                    class="card-header info d-flex justify-content-between align-items-center"
                    style="border-bottom: 2px solid black; padding: 15px 20px; color: black !important; text-decoration: none; background: white;"
                    data-toggle="collapse" aria-expanded="true">
                    <h4 style="margin: 0; font-size: 18px; font-weight: normal; color: #333;">Edit Payment Method</h4>

                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="custom-arrow" viewBox="0 0 16 16" style="transition: transform 0.3s ease;">
                        <path fill-rule="evenodd"
                            d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>

                <div id="collaptr_businesss_info" class="collapse show" aria-expanded="true">
                    <form action="{{ route('vender.service.provider.trading.unit.hub.setting.payment.method.submit') }}"
                        method="POST" enctype="multipart/form-data" id="contens_form" style="margin: 0;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $trading_unit['id'] }}">

                        <div style="padding: 20px;">
                            <div class="row">
                                @foreach ($job_types as $job_type)
                                    <div class="col-6 col-md-4 col-lg-3" style="margin-bottom: 15px;">
                                        <fieldset>
                                            <label
                                                style="display: flex; align-items: center; gap: 8px; cursor: pointer; margin: 0;">
                                                <input type="checkbox" name="warrenty_id[]"
                                                    value="{{ $job_type['id'] }}"
                                                    style="width: 16px; height: 16px; cursor: pointer;">
                                                <span
                                                    style="font-size: 14px; line-height: 1.2;">{{ $job_type['name'] }}</span>
                                            </label>
                                        </fieldset>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div
                            style="padding: 15px 20px; border-top: 2px solid black; display: flex; justify-content: flex-end; gap: 10px; background: white;">
                            <a href="{{ redirect()->back()->getTargetUrl() }}" style="text-decoration: none;">
                                <button type="button" class="btn btn-dark"
                                    style="border-radius: 5px; padding: 8px 20px; background: black; color: white; border: none; font-weight: 500;">Cancel</button>
                            </a>
                            <button type="button" onclick="submitDetailsForm()" class="btn btn-dark"
                                style="border-radius: 5px; padding: 8px 20px; background: black; color: white; border: none; font-weight: 500;">Save</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function submitDetailsForm() {
            let array = ['address_line_1', 'address_line_2', 'city', 'postcode', 'email', 'mobile'];

            let status = false;
            array.some((item) => {
                let name = $(`#${item}`).val();
                console.log(name, item);

                if (name === "") {


                    $(`#${item}`).attr('style', 'border:2px solid red!important;');




                    return false;

                } else {

                    $(`#${item}`).attr('style', 'border:2px solid black!important;');


                }
            });
            array.some((item) => {
                let name = $(`#${item}`).val();
                console.log(name, item);

                if (name === "") {


                    $(`#${item}`).attr('style', 'border:2px solid red!important;');

                    status = false;


                    return true;

                } else {

                    $(`#${item}`).attr('style', 'border:2px solid black!important;');
                    status = true;

                }
            });



            // return;


            if (status == true) {
                $("form").submit();
            }






        }
    </script>

    <script>
        async function lookup(arg) {
            var id = arg.getAttribute('id');
            var value = arg.value;


            let trading_name = $(`#${id}`).val();
            if (id !== "address_line_2" && id !== "city" && id !== "postcode") {
                if (trading_name === "") {


                    $(`#${id}`).attr("style", "border:2px solid red!important;");
                    status = false;

                } else {
                    $(`#${id}`).attr("style", "border:2px solid black!important;");
                    $(`.${id}`).hide();
                }
            } else {
                if (trading_name === "") {


                    $(`#${id}`).attr("style", "border:2px solid red!important;margin-top: 5px ");
                    status = false;

                } else {
                    $(`#${id}`).attr("style", "border:2px solid black!important;margin-top: 5px;");
                    $(`.${id}`).hide();
                }
            }














        }
    </script>
@endsection

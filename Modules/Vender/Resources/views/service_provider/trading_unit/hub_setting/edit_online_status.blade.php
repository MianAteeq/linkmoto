@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/forms/toggle/bootstrap-switch.min.css">
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/forms/toggle/switchery.min.css">
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/css/plugins/forms/switch.css">

    <style>
        /* ================= EXISTING STYLES ================= */

        .footers {
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

        .btn-success {
            border-color: #ff6618 !important;
            background-color: #ff6800 !important;
            color: #FFFFFF;
        }

        .btn-success:hover,
        .btn-success:active {
            border-color: #ff6618 !important;
            background-color: #ff6618 !important;
            color: #FFF !important;
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

        /* ================= RESPONSIVE FIXES ================= */

        /* Images responsive */
        img {
            max-width: 100%;
            height: auto;
        }

        /* Tabs wrap */
        #contens .row {
            flex-wrap: wrap;
        }

        #contens .row a {
            display: inline-block;
            margin-bottom: 10px;
        }

        /* Remove float issues */
        .float-left {
            float: none !important;
        }

        /* Prevent overflow */
        h3,
        h4,
        span,
        p {
            word-wrap: break-word;
        }

        /* Buttons */
        .btn {
            white-space: normal;
        }

        /* Breadcrumb wrap */
        .breadcrumb {
            flex-wrap: wrap;
        }

        /* Card safety */
        .card {
            overflow: hidden;
        }

        /* MOBILE */
        @media (max-width: 768px) {

            .col-md-3,
            .col-md-9 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .col-md-3 {
                margin-bottom: 15px;
            }

            /* Fix sidebar float layout */
            .col-md-3 div[style*="float: left"] {
                width: 100% !important;
                float: none !important;
                margin-bottom: 5px;
            }

            /* Fix spacing */
            .col-md-3 div[style*="margin: 20px"] {
                margin: 10px !important;
            }

            /* Full width buttons */
            .footers button {
                width: 100% !important;
                margin-bottom: 8px;
                float: none !important;
            }

            /* Form stacking */
            .form-group.row {
                display: flex;
                flex-direction: column;
            }

            .form-group .col-md-4,
            .form-group .col-md-8 {
                max-width: 100%;
                flex: 100%;
            }

            .form-group .col-md-8 {
                margin-top: 5px;
            }
        }

        /* TABLET */
        @media (min-width: 769px) and (max-width: 1024px) {
            .col-md-3 {
                flex: 0 0 35%;
                max-width: 35%;
            }

            .col-md-9 {
                flex: 0 0 65%;
                max-width: 65%;
            }
        }
    </style>
@endsection


@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3">Edit online statuses</h3>
                <div class="breadcrumb-wrapper col-12 p-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Products</a></li>
                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.service.provider') }}">Service
                                Provider</a></li>
                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.service.provider.trading.unit') }}">Trade Units</a></li>
                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.service.provider.trading.unit.view', $trading_unit['id']) }}">{{ $trading_unit['name'] }}</a>
                        </li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('vender.service.provider.trading.unit.hub.setting', $trading_unit['id']) }}"
                                style="color: black">Hub profile settings</a></li>
                        <li class="breadcrumb-item">Edit online statuses</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('content')
    <div class="row">
        <!-- SIDEBAR -->
        <div class="col-md-3" style="margin-bottom: 20px;">
            <div style="border-radius: 7px; border: 2px solid black; background: white; overflow: hidden;">

                <div style="padding: 15px;">

                    <div style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 15px;">
                        <img src="/trading_unit.png" style="width: 22px; flex-shrink: 0; margin-top: 2px;">
                        <span style="font-weight: 600; font-size: 16px; line-height: 1.3; color: black;">Trading Unit :
                            {{ $trading_unit['name'] }}</span>
                    </div>

                    <div style="font-weight: 500; font-size: 13px; margin-bottom: 12px; color: black;">
                        <span>Trading Name : {{ $trading_unit['trading_name']['name'] ?? '' }}</span>
                    </div>

                    <div style="font-weight: 500; font-size: 13px; margin-bottom: 12px;">
                        <span class="success" style="color: #28a745;">{{ $trading_unit['status'] }}</span>
                    </div>

                    <div style="font-weight: 500; font-size: 13px; margin-bottom: 12px;">
                        <span class="success" style="color: #28a745;">{{ $trading_unit['active_status'] }}</span>
                    </div>

                    <div style="font-weight: 500; font-size: 13px; color: black;">
                        <span>Created: {{ \Carbon\Carbon::parse($trading_unit['created_at'])->format('d/m/Y') }} at
                            {{ \Carbon\Carbon::parse($trading_unit['created_at'])->format('h:i') }}</span>
                    </div>

                </div>

                <div class="footers" style="border-top: 2px solid black; padding: 15px; display: flex; gap: 10px;">

                    @if ($trading_unit['status'] == 'PENDING' || $trading_unit['status'] == 'INACTIVE')
                        <a href="{{ route('vender.service.provider.trading.unit.active', $trading_unit['id']) }}"
                            style="text-decoration: none; flex: 1; display: flex;">
                            <button type="button" class="btn btn-dark"
                                style="width: 100%; border-radius: 5px; background: black; color: white; border: none; padding: 8px 4px; font-weight: 600; font-size: 12px; white-space: normal;">ACTIVATE
                                TRADE UNIT</button>
                        </a>
                    @else
                        <a href="{{ route('vender.service.provider.trading.unit.in.active', $trading_unit['id']) }}"
                            style="text-decoration: none; flex: 1; display: flex;">
                            <button type="button" class="btn btn-dark"
                                style="width: 100%; border-radius: 5px; background: black; color: white; border: none; padding: 8px 4px; font-weight: 600; font-size: 12px; white-space: normal;">INACTIVATE
                                TRADE UNIT</button>
                        </a>
                    @endif

                    @if ($trading_unit['active_status'] == 'OFFLINE')
                        <a href="{{ route('vender.service.provider.trading.unit.Online', $trading_unit['id']) }}"
                            style="text-decoration: none; flex: 1; display: flex;">
                            <button type="button" class="btn btn-dark"
                                style="width: 100%; border-radius: 5px; background: black; color: white; border: none; padding: 8px 4px; font-weight: 600; font-size: 12px; white-space: normal;">SHOW
                                ONLINE</button>
                        </a>
                    @else
                        <a href="{{ route('vender.service.provider.trading.unit.offline', $trading_unit['id']) }}"
                            style="text-decoration: none; flex: 1; display: flex;">
                            <button type="button" class="btn btn-dark"
                                style="width: 100%; border-radius: 5px; background: black; color: white; border: none; padding: 8px 4px; font-weight: 600; font-size: 12px; white-space: normal;">SHOW
                                OFFLINE</button>
                        </a>
                    @endif

                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="col-md-9" id="contens" style="border-radius: 6px; margin-bottom: 10px; padding-bottom: 10px;">

            <div class="row" style="display: flex; gap: 12px; margin-left: 15px; margin-bottom: 20px;">
                <a href="{{ route('vender.service.provider.trading.unit.view', $trading_unit['id']) }}"
                    style="text-decoration: none;">
                    <div
                        style="border: 2px solid black; border-radius: 5px; padding: 8px 20px; color: black; font-weight: 600; font-size: 15px; background: white;">
                        Overview
                    </div>
                </a>

                <a href="{{ route('vender.service.provider.trading.unit.app.setting', $trading_unit['id']) }}"
                    style="text-decoration: none;">
                    <div
                        style="border: 2px solid #ff6600; border-radius: 5px; padding: 8px 20px; color: #ff6600; font-weight: 600; font-size: 15px; background: white;">
                        App settings
                    </div>
                </a>

                <a href="{{ route('vender.service.provider.trading.unit.app.data', $trading_unit['id']) }}"
                    style="text-decoration: none;">
                    <div
                        style="border: 2px solid black; border-radius: 5px; padding: 8px 20px; color: black; font-weight: 600; font-size: 15px; background: white;">
                        App data
                    </div>
                </a>
            </div>

            <div style="border: 2px solid black; border-radius: 5px; background: white; margin-left: 15px;">

                <div style="padding: 15px 20px; border-bottom: 2px solid black;">
                    <h4 style="margin: 0; font-size: 18px; font-weight: normal; color: #333;">Edit online statuses</h4>
                </div>

                <form action="{{ route('vender.service.provider.trading.unit.hub.setting.online.status.submit') }}"
                    method="POST" style="margin: 0;">
                    @csrf
                    <input type="hidden" name="id" value="{{ $trading_unit['id'] }}">

                    <div style="padding: 20px;">
                        <div class="form-group row" style="margin-bottom: 15px;">
                            <label class="col-md-4 label-control">Marketplace</label>
                            <div class="col-md-8">
                                <input type="checkbox" class="switch" name="is_marketplace"
                                    @if ($trading_unit['hub_setting']['is_marketplace'] == 1) checked @endif>
                            </div>
                        </div>

                        <div class="form-group row" style="margin-bottom: 15px;">
                            <label class="col-md-4 label-control">Quotes</label>
                            <div class="col-md-8">
                                <input type="checkbox" class="switch" @if ($is_advertise == 'on') disabled @endif
                                    name="is_quote" @if ($trading_unit['hub_setting']['is_quote'] == 1) checked @endif>
                            </div>
                        </div>

                        <div class="form-group row" style="margin-bottom: 0px;">
                            <label class="col-md-4 label-control">Bookings</label>
                            <div class="col-md-8">
                                <input type="checkbox" class="switch" @if ($is_advertise == 'on') disabled @endif
                                    name="is_booking" @if ($trading_unit['hub_setting']['is_booking'] == 1) checked @endif>
                            </div>
                        </div>
                    </div>

                    <div
                        style="padding: 15px 20px; border-top: 2px solid black; display: flex; justify-content: flex-end; gap: 10px; background: white; border-radius: 0 0 5px 5px;">
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
@endsection


@section('script')
    <script src="/modules/admin/app-assets/vendors/js/forms/toggle/bootstrap-switch.min.js"></script>
    <script src="/modules/admin/app-assets/vendors/js/forms/toggle/switchery.min.js"></script>
    <script src="/modules/admin/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js"></script>
    <script src="/modules/admin/app-assets/js/scripts/forms/switch.js"></script>

    <script>
        function submitDetailsForm() {
            $("form").submit();
        }
    </script>
@endsection

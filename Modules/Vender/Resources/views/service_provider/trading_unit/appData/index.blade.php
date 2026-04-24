@extends('vender::layouts.master')

@section('css_custom')
    <style>
        /* ========================================================================
       1. ICONS & MENU STYLES
       ======================================================================== */
        .collapse-icon [data-toggle="collapse"]:before {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e842";
            transition: all 300ms linear 0s;
        }

        .collapse-icon [data-toggle="collapse"]:after {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e845";
            transition: all 300ms linear 0s;
        }

        .collapsed {
            border-bottom-left-radius: 0px !important;
            border-bottom-right-radius: 0px !important;
        }

        /* ========================================================================
       2. CONTAINER & UI STYLES
       ======================================================================== */
        body {
            color: black;
        }

        .info-sidebar {
            border-radius: 7px;
            border: 2px solid black;
            background-color: white;
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
        }

        .main-content-box {
            border-radius: 6px;
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .footers {
            border-top: 2px solid black;
            padding: 15px 20px;
            width: 100%;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;
        }

        .btn-dark {
            border-color: black !important;
            background-color: black !important;
            color: #FFFFFF !important;
            margin: 0 !important;
        }

        .round {
            border-radius: 0.5rem;
        }

        .success {
            color: #28a745;
            font-weight: bold;
        }

        /* ========================================================================
       3. RESPONSIVE MEDIA QUERIES (Tablet & Mobile Stacking)
       ======================================================================== */
        @media (max-width: 991.98px) {
            .headerbg {
                padding-left: 25px !important;
            }

            .info-sidebar-wrapper {
                margin-bottom: 20px;
            }

            .col-lg-9 {
                padding-left: 0 !important;
                padding-right: 0 !important;
                width: 100% !important;
                flex: 0 0 100% !important;
                max-width: 100% !important;
            }

            .footers .btn-dark {
                float: none !important;
                width: 100% !important;
                display: block !important;
            }

            .footers a {
                display: block;
                width: 100%;
            }

            /* Make nav buttons stack fully on small screens */
            .nav-buttons {
                flex-direction: column;
                align-items: stretch !important;
            }

            .nav-buttons h4 {
                text-align: center;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row m-0" style="border-bottom: 3px solid #949494;">
            {{-- Single-line flexbox alignment --}}
            <div class="col-12 bg-white headerbg d-flex align-items-center flex-wrap" style="padding: 15px 32px;">
                <h3 class="h3 m-0 mr-3" style="font-weight: 600;">Trade unit information</h3>

                <div class="breadcrumb-wrapper p-0">
                    <ol class="breadcrumb m-0 p-0" style="background-color: transparent; padding-top: 2px !important;">
                        <li class="breadcrumb-item"><a>Products</a></li>
                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.service.provider') }}">Service Provider</a></li>
                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.service.provider.trading.unit') }}">Trade Units</a></li>
                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.service.provider.trading.unit.view', $trading_unit['id']) }}">{{ $trading_unit['name'] }}</a>
                        </li>
                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.service.provider.trading.unit.view', $trading_unit['id']) }}">Overview</a>
                        </li>
                        <li class="breadcrumb-item">Trade unit information</li>
                        <li class="breadcrumb-item active">App Data</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid px-1 px-md-1 mt-1">
        <div class="row align-items-start m-0">

            {{-- Left Sidebar Profile Card --}}
            <div class="col-12 col-lg-3 info-sidebar-wrapper mb-4 mb-lg-0 p-0 pr-lg-3">
                <div class="info-sidebar">

                    {{-- Fixed invalid HTML: changed outer h4 to a div --}}
                    <div
                        style="font-weight: 600; font-size: 17px; padding: 12px 16px; border-bottom: 2px solid black; display: flex; align-items: flex-start;">
                        <img src="/trading_unit.png" style="width: 22px; margin-right: 10px; margin-top: 2px;">
                        <span style="word-break: break-word;"><span style="color:#ff6600">Trading
                                Unit:</span><br>{{ $trading_unit['name'] }}</span>
                    </div>

                    <div style="padding: 20px; flex-grow: 1;">
                        <div class="mb-3" style="font-weight: 500; font-size: 14px;">
                            <span style="color:#ff6600; font-weight: 600;">Trading Name:</span><br>
                            {{ $trading_unit['trading_name']['name'] ?? '' }}
                        </div>

                        <div class="mb-3" style="font-weight: 500; font-size: 14px;">
                            <span class="success">{{ $trading_unit['status'] }}</span>
                        </div>

                        <div class="mb-4" style="font-weight: 500; font-size: 14px;">
                            <span class="success">{{ $trading_unit['active_status'] }}</span>
                        </div>

                        <div style="font-weight: 500; font-size: 13px; color: #555; line-height: 1.6;">
                            Created: {{ \Carbon\Carbon::parse($trading_unit['created_at'])->format('d/m/Y \a\t h:i') }}
                        </div>
                    </div>

                    {{-- Action Buttons Footer --}}
                    <div class="footers"
                        style="flex-direction: column; gap: 12px; padding: 15px; border-radius: 0 0 5px 5px;">
                        @if ($trading_unit['status'] == 'PENDING' || $trading_unit['status'] == 'INACTIVE')
                            <a href="{{ route('vender.service.provider.trading.unit.active', $trading_unit['id']) }}"
                                style="width: 100%; text-decoration: none;">
                                <button type="button" class="btn btn-dark round w-100 m-0">ACTIVATE TRADE UNIT</button>
                            </a>
                        @else
                            <a href="{{ route('vender.service.provider.trading.unit.in.active', $trading_unit['id']) }}"
                                style="width: 100%; text-decoration: none;">
                                <button type="button" class="btn btn-dark round w-100 m-0">INACTIVATE TRADE UNIT</button>
                            </a>
                        @endif

                        @if ($trading_unit['active_status'] == 'OFFLINE')
                            <a href="{{ route('vender.service.provider.trading.unit.Online', $trading_unit['id']) }}"
                                style="width: 100%; text-decoration: none;">
                                <button type="button" class="btn btn-dark round w-100 m-0">SHOW ONLINE</button>
                            </a>
                        @else
                            <a href="{{ route('vender.service.provider.trading.unit.offline', $trading_unit['id']) }}"
                                style="width: 100%; text-decoration: none;">
                                <button type="button" class="btn btn-dark round w-100 m-0">SHOW OFFLINE</button>
                            </a>
                        @endif
                    </div>

                </div>
            </div>

            {{-- Right Content Container --}}
            <div class="col-12 col-lg-9 p-0" id="contens">

                {{-- Navigation Buttons Row (Flexbox Spacing Fix) --}}
                <div class="d-flex align-items-center mb-4 flex-wrap nav-buttons" style="gap: 15px;">
                    <a href="{{ route('vender.service.provider.trading.unit.view', $trading_unit['id']) }}"
                        style="text-decoration: none;">
                        <h4 class="h3 m-0"
                            style="border-radius: 7px; border: 2px solid black; padding: 10px 20px; font-weight: 600; font-size: 17px; color: black; text-align: center;">
                            Overview
                        </h4>
                    </a>
                    <a href="{{ route('vender.service.provider.trading.unit.app.setting', $trading_unit['id']) }}"
                        style="text-decoration: none;">
                        <h4 class="h3 m-0"
                            style="border-radius: 7px; border: 2px solid black; padding: 10px 20px; font-weight: 600; font-size: 17px; color: black; text-align: center;">
                            App settings
                        </h4>
                    </a>
                    <h4 class="h3 m-0"
                        style="border-radius: 7px; border: 2px solid #ff6600; padding: 10px 20px; font-weight: 600; font-size: 17px; color: #ff6600; text-align: center;">
                        App data
                    </h4>
                </div>

                {{-- App Data Menu Links --}}
                <div class="main-content-box p-0" style="border: none; background: transparent;">

                    <a href="{{ route('vender.service.provider.trading.unit.app.data.contact', $trading_unit['id']) }}"
                        class="card-header info mb-2"
                        style="border: 2px solid black; border-radius: 7px !important; padding: 1.2rem 1rem; color: black !important; display: block; text-decoration: none; background: white;">
                        <div class="card-title lead m-0">Contacts</div>
                    </a>
                    <a href="{{ route('vender.service.provider.trading.unit.app.data.vehicle', $trading_unit['id']) }}"
                        class="card-header info mb-2"
                        style="border: 2px solid black; border-radius: 7px !important; padding: 1.2rem 1rem; color: black !important; display: block; text-decoration: none; background: white;">
                        <div class="card-title lead m-0">Vehicles</div>
                    </a>
                    <a href="{{ route('vender.service.provider.trading.unit.app.data.quotes', $trading_unit['id']) }}"
                        class="card-header info mb-2"
                        style="border: 2px solid black; border-radius: 7px !important; padding: 1.2rem 1rem; color: black !important; display: block; text-decoration: none; background: white;">
                        <div class="card-title lead m-0">Quotes</div>
                    </a>
                    <a href="{{ route('vender.service.provider.trading.unit.app.data.booking', $trading_unit['id']) }}"
                        class="card-header info mb-2"
                        style="border: 2px solid black; border-radius: 7px !important; padding: 1.2rem 1rem; color: black !important; display: block; text-decoration: none; background: white;">
                        <div class="card-title lead m-0">Bookings</div>
                    </a>
                    <a href="{{ route('vender.service.provider.trading.unit.app.data.jobs', $trading_unit['id']) }}"
                        class="card-header info mb-2"
                        style="border: 2px solid black; border-radius: 7px !important; padding: 1.2rem 1rem; color: black !important; display: block; text-decoration: none; background: white;">
                        <div class="card-title lead m-0">Jobs</div>
                    </a>
                    <a href="{{ route('vender.service.provider.trading.unit.app.data.invoices', $trading_unit['id']) }}"
                        class="card-header info mb-2"
                        style="border: 2px solid black; border-radius: 7px !important; padding: 1.2rem 1rem; color: black !important; display: block; text-decoration: none; background: white;">
                        <div class="card-title lead m-0">Invoices</div>
                    </a>
                    <a href="{{ route('vender.service.provider.trading.unit.app.data.payments', $trading_unit['id']) }}"
                        class="card-header info mb-0"
                        style="border: 2px solid black; border-radius: 7px !important; padding: 1.2rem 1rem; color: black !important; display: block; text-decoration: none; background: white;">
                        <div class="card-title lead m-0">Payments</div>
                    </a>

                </div>

            </div>
        </div>
    </div>
@endsection

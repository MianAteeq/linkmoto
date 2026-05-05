@extends('vender::layouts.master')

@section('css_custom')
    <style>
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

        .badge-primary-1 {
            background-color: #ff6600;
        }

        /* Ensure accordion text doesn't slide under the icons */
        .card-header.info {
            padding-right: 45px !important;
        }

        /* Custom gap utility for top nav tabs */
        .custom-nav-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-left: 15px;
            margin-bottom: 15px;
        }

        .custom-nav-tabs a {
            text-decoration: none;
        }

        /* --- RESPONSIVE ENHANCEMENTS (Updated to 991px to catch 768px screens) --- */
        @media (max-width: 991px) {

            /* Stack top navigation links cleanly on smaller screens */
            .custom-nav-tabs {
                flex-direction: column;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            .custom-nav-tabs a {
                width: 100%;
            }

            .custom-nav-tabs a h4 {
                margin-left: 0 !important;
                text-align: center;
                margin-bottom: 0;
            }

            /* Accordion Key-Value pairs spacing */
            .card-body .col-sm-5 h6 {
                margin-bottom: 5px;
                font-weight: bold;
            }

            .card-body .col-sm-7 {
                margin-bottom: 15px;
            }

            .card-body hr {
                margin-top: 5px;
                margin-bottom: 15px;
            }

            /* Edit button full width */
            .footers .btn {
                width: 43% !important;
                float: none !important;
                margin-top: 10px;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3">Trade unit information</h3>
                <div class="breadcrumb-wrapper col-12 p-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Products</a></li>
                        <li class="breadcrumb-item">
                            <a style="color: black" href="{{ route('vender.service.provider') }}">Service Provider</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a style="color: black" href="{{ route('vender.service.provider.trading.unit') }}">Trade
                                Units</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a style="color: black"
                                href="{{ route('vender.service.provider.trading.unit.view', $trading_unit['id']) }}">{{ $trading_unit['name'] }}</a>
                        </li>
                        <li class="breadcrumb-item">Overview</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-3 col-md-12 mb-4 align-self-start">
            <div class="info-sidebar d-flex flex-column"
                style="border-radius: 7px; border: 2px solid black; background-color: white; overflow: hidden;">

                <div class="info-sidebar-body" style="flex-grow: 1;">
                    <div class="d-flex align-items-start font-weight-bold"
                        style="font-size: 1.1rem; padding-bottom: 15px; margin: 0; border-bottom: 2px solid black;padding:10px">
                        <img src="/trading_unit.png" style="width: 22px; margin-right: 10px; margin-top: 2px;">
                        <span style="word-break: break-word;">Trading Unit : <br>{{ $trading_unit['name'] }}</span>
                    </div>

                    <div style="margin-top: 20px; font-weight: 500; font-size: 13px;padding-left:10px">
                        <span>Trading Name : {{ $trading_unit['trading_name']['name'] ?? '' }}</span>
                    </div>
                    <div style="margin-top: 15px; font-weight: 500; font-size: 13px;padding-left:10px">
                        <span class="success">{{ ucfirst(strtolower($trading_unit['status'])) }}</span>
                    </div>
                    <div style="margin-top: 15px; font-weight: 500; font-size: 13px;padding-left:10px">
                        <span class="success">{{ ucfirst(str_replace(['offfline'], ['offline'], strtolower($trading_unit['active_status']))) }}</span>
                    </div>
                    <div style="margin-top: 15px; font-weight: 500; font-size: 13px;padding-left:10px;padding-bottom:10px">
                        <span>Created: {{ \Carbon\Carbon::parse($trading_unit['created_at'])->format('d/m/Y') }} at
                            {{ \Carbon\Carbon::parse($trading_unit['created_at'])->format('h:i') }}</span>
                    </div>
                </div>

                {{-- Action Buttons Footer --}}
                <div class="footers"
                    style="padding: 15px; border-top: 2px solid black; background: white; display: flex; flex-direction: column; gap: 12px;">

                    @if ($trading_unit['status'] == 'PENDING' || $trading_unit['status'] == 'INACTIVE')
                        <a href="{{ route('vender.service.provider.trading.unit.active', $trading_unit['id']) }}"
                            style="text-decoration: none; display: block; width: 100%;">
                            <button type="button" class="btn btn-dark m-0"
                                style="width: 100%; padding: 10px; font-weight: 600; border-radius: 6px;">Activate Trade
                                Unit</button>
                        </a>
                    @else
                        <a href="{{ route('vender.service.provider.trading.unit.in.active', $trading_unit['id']) }}"
                            style="text-decoration: none; display: block; width: 100%;">
                            <button type="button" class="btn btn-dark m-0"
                                style="width: 100%; padding: 10px; font-weight: 600; border-radius: 6px;">Inactivate Trade
                                Unit</button>
                        </a>
                    @endif

                    @if ($trading_unit['active_status'] == 'OFFLINE')
                        <a href="{{ route('vender.service.provider.trading.unit.Online', $trading_unit['id']) }}"
                            style="text-decoration: none; display: block; width: 100%;">
                            <button type="button" class="btn btn-dark m-0"
                                style="width: 100%; padding: 10px; font-weight: 600; border-radius: 6px;">Show
                                Online</button>
                        </a>
                    @else
                        <a href="{{ route('vender.service.provider.trading.unit.offline', $trading_unit['id']) }}"
                            style="text-decoration: none; display: block; width: 100%;">
                            <button type="button" class="btn btn-dark m-0"
                                style="width: 100%; padding: 10px; font-weight: 600; border-radius: 6px;">Show
                                Offline</button>
                        </a>
                    @endif

                </div>

            </div>
        </div>

        <div class="col-lg-9 col-md-12" id="contens"
            style="border-radius: 6px; margin-bottom: 10px; padding-bottom: 10px; margin-top: 0px;">

            <div class="custom-nav-tabs">
                <a href="{{ route('vender.service.provider.trading.unit.view', $trading_unit['id']) }}">
                    <h4 class="h3"
                        style="border-radius: 7px; border: 2px solid #ff6600; padding: 10px; font-weight: 600; font-size: 17px; color: #ff6600; margin: 0;">
                        Overview</h4>
                </a>
                <a href="{{ route('vender.service.provider.trading.unit.app.setting', $trading_unit['id']) }}">
                    <h4 class="h3"
                        style="border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black; margin: 0;">
                        App settings</h4>
                </a>
                <a href="{{ route('vender.service.provider.trading.unit.app.data', $trading_unit['id']) }}">
                    <h4 class="h3"
                        style="border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black; margin: 0;">
                        App data</h4>
                </a>
            </div>

            <div class="card default-collapse collapse-icon accordion-icon-rotate" style="box-shadow: none; margin-top: 0;">
                <a id="headingCollapse1" class="card-header info mt-2"
                    style="border: 2px solid black; border-radius: 7px !important; padding: 1.2rem 1rem; color: black !important;"
                    data-toggle="collapse" href="#collaptr_businesss_info" aria-expanded="true"
                    aria-controls="collaptr_businesss_info">
                    <div class="card-title lead collapsed">Trade unit information</div>
                </a>

                <div id="collaptr_businesss_info" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
                    class="collapse show" aria-expanded="true"
                    style="border-left: 2px solid black; margin-top: -4px; border-right: 2px solid black; border-bottom: 2px solid black; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px;">
                    <div class="card-content">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="font-weight: 600;">ID</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">SVP{{ sprintf('%07d', $trading_unit['id']) }}</div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="font-weight: 600;">Trade unit name</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">{{ $trading_unit['name'] ?? '' }}</div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="font-weight: 600;">Business Name Format</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    @if (auth()->user()->profile['organization_status'] === 'Limited Company (Ltd)' ||
                                            auth()->user()->profile['organization_status'] === 'Limited Liability Partnership (LLP)')
                                        @if ($trading_unit['trading_template'] == 1)
                                            Registered company name
                                        @endif
                                        @if ($trading_unit['trading_template'] == 2)
                                            Registered company name & trading name
                                        @endif
                                        @if ($trading_unit['trading_template'] == 3)
                                            Trading name
                                        @endif
                                    @else
                                        @if ($trading_unit['trading_template'] == 1)
                                            Registered {{ $user['profile']['organization_status'] }} name
                                        @endif
                                        @if ($trading_unit['trading_template'] == 2)
                                            Registered {{ $user['profile']['organization_status'] }} & trading name
                                        @endif
                                        @if ($trading_unit['trading_template'] == 3)
                                            Trading name
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="font-weight: 600;">Business Name</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    @if ($trading_unit['trading_template'] == 1)
                                        {{ auth()->user()->profile->company_name }}
                                    @endif
                                    @if ($trading_unit['trading_template'] == 2)
                                        {{ auth()->user()->profile->company_name }} Trading as
                                        {{ $trading_unit['trading_name']['name'] }}
                                    @endif
                                    @if ($trading_unit['trading_template'] == 3)
                                        {{ $trading_unit['trading_name']['name'] ?? '' }}
                                    @endif
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="font-weight: 600;">Service offerings</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    @if ($trading_unit['operation_type'] === 'Both')
                                        <span class="badge badge-primary-1">On-site</span>
                                        <span class="badge badge-primary-1">Mobile</span>
                                    @else
                                        <span
                                            class="badge badge-primary-1">{{ ucfirst($trading_unit['operation_type']) }}</span>
                                    @endif
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="font-weight: 600;">Site address</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">{{ $trading_unit['site']['address_line_1'] ?? '' }}
                                </div>
                            </div>
                            <hr>

                            @if ($trading_unit['operation_type'] != 'On-site')
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="font-weight: 600;">Mobile city / town</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">{{ $trading_unit['city'] }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="font-weight: 600;">Mobile postcode</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">{{ $trading_unit['postcode'] }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="font-weight: 600;">Mobile distance / radius (miles)</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">{{ $trading_unit['radius'] }}</div>
                                </div>
                                <hr>
                                
                            @endif
                            <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="font-weight: 600;">Landline</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">{{ $trading_unit['landline'] }}</div>
                                </div>
                                <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="font-weight: 600;">Mobile</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">{{ $trading_unit['mobile'] }}</div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="font-weight: 600;">Email</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">{{ $trading_unit['email'] }}</div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="font-weight: 600;">Website</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">{{ $trading_unit['website'] }}</div>
                            </div>
                        </div>

                        <div class="footers px-1 pb-1 pt-2" style="text-align: right;">
                            <a href="{{ route('vender.service.provider.trading.unit.edit', $trading_unit['id']) }}">
                                <button type="button" class="btn btn-dark round btn-min-width">Edit</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

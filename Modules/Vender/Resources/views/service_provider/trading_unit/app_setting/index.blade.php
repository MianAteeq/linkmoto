@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        /* ========================================================================
                           1. TABLE STYLES
                           ======================================================================== */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info {
            display: none !important;
        }

        table.dataTable thead {
            background: #fafbfc;
            color: black;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: white;
        }

        table.dataTable tbody td {
            padding: 8px 10px;
            padding-bottom: 2px;
            padding-top: 2px;
            font-size: 10px;
            color: black;
            vertical-align: middle;
        }

        table.dataTable thead th,
        table.dataTable thead td {
            padding: 10px 18px;
            border-bottom: 1px solid #111;
            font-size: 11px;
            padding-left: 8px;
            padding-right: 1px;
            white-space: nowrap;
        }

        table.dataTable tfoot th,
        table.dataTable tfoot td {
            padding: 10px 18px 6px 18px;
            border-top: 1px solid #111;
            font-size: 10px;
            padding-right: 0px;
            padding-left: 8px;
            color: black;
        }

        table.dataTable {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            border-collapse: collapse !important;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            padding: 1px;
        }

        /* Hide DataTables sorting icons */
        table.dataTable thead .sorting,
        table.dataTable thead .sorting_asc,
        table.dataTable thead .sorting_desc {
            background-image: none !important;
            cursor: default !important;
        }

        table.dataTable thead th {
            padding-right: 18px !important;
        }

        /* ========================================================================
                           2. ICONS & COLLAPSE STYLES
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
                           3. CONTAINER & UI STYLES
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
            border: 2px solid black;
            border-radius: 6px;
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
            background-color: white;
            width: 100%;
        }

        .footers {
            border-top: 2px solid black;
            padding: 15px 20px;
            width: 100%;
            background: white;
            display: flex;
            justify-content: flex-end;
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

        .tags {
            display: flex;
            align-items: center;
            gap: 10px;
            float: right;
            margin-right: 32px;
        }

        .tag {
            background-color: #ff8c42;
            color: white;
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 14px;
        }

        .badge-success {
            background-color: #ff6600 !important;
            padding: 6px 10px;
            font-size: 12px;
        }

        /* ========================================================================
                           4. RESPONSIVE MEDIA QUERIES
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

            .tags {
                float: none;
                margin-top: 10px;
                margin-right: 0;
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
                        <li class="breadcrumb-item active">App settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid px-1 px-md-1 mt-1">
        <div class="row align-items-start m-0">

            {{-- Left Sidebar --}}
            <div class="col-12 col-lg-3 info-sidebar-wrapper mb-4 mb-lg-0 p-0 pr-lg-3">
                <div class="info-sidebar">
                    <h4 class="h3 m-0"
                        style="font-weight: 600; font-size: 17px; padding: 12px 16px; border-bottom: 2px solid black; display: flex; align-items: flex-start;">
                        <img src="/trading_unit.png" style="width: 22px; margin-right: 10px; margin-top: 2px;">
                        <span style="word-break: break-word;"><span style="color:#ff6600">Trading
                                Unit:</span><br>{{ $trading_unit['name'] }}</span>
                    </h4>

                    <div style="padding: 20px; flex-grow: 1;">
                        <div class="mb-1" style="font-weight: 500; font-size: 14px;">
                            <span style="color:#ff6600; font-weight: 600;">Business Name:</span><br>
                            @if ($trading_unit['trading_template'] == 1)
                                {{ auth()->user()->profile->company_name }}
                            @elseif ($trading_unit['trading_template'] == 2)
                                {{ auth()->user()->profile->company_name }} Trading as
                                {{ $trading_unit['trading_name']['name'] }}
                            @elseif ($trading_unit['trading_template'] == 3)
                                {{ $trading_unit['trading_name']['name'] ?? '' }}
                            @endif
                        </div>

                        <div class="mb-0" style="font-weight: 600; font-size: 14px;">
                            <span style="color:#ff6600">Online Status:</span>
                        </div>

                        <div class="mb-2" style="font-weight: 500; font-size: 14px; line-height: 1.8;">
                            Marketplace:
                            @isset($trading_unit['hub_setting']){{ $trading_unit['hub_setting']['is_marketplace'] ? 'On' : 'Off' }}@else'Off'
                                @endif
                                <br>
                                Quotes:
                                @isset($trading_unit['hub_setting']){{ $trading_unit['hub_setting']['is_quote'] ? 'On' : 'Off' }}@else'Off'
                                    @endif
                                    <br>
                                    Bookings:
                                    @isset($trading_unit['hub_setting']){{ $trading_unit['hub_setting']['is_booking'] ? 'On' : 'Off' }}@else'Off'
                                        @endif
                                    </div>

                                    <div style="font-weight: 500; font-size: 13px; color: #555; margin-bottom: 10px;">
                                        Created: {{ \Carbon\Carbon::parse($trading_unit['created_at'])->format('d/m/Y \a\t h:i') }}
                                    </div>
                                    <div style="font-weight: 500; font-size: 13px; color: #555;">
                                        Last updated:
                                        {{ \Carbon\Carbon::parse($trading_unit['updated_at'])->format('d/m/Y \a\t h:i') }}
                                    </div>
                                </div>

                                <div class="footers"
                                    style="flex-direction: column; gap: 12px; border-radius: 0 0 5px 5px; padding: 15px;">

                                    @if ($trading_unit['status'] == 'PENDING' || $trading_unit['status'] == 'INACTIVE')
                                        <a href="{{ route('vender.service.provider.trading.unit.active', $trading_unit['id']) }}"
                                            style="width: 100%; text-decoration: none;">
                                            {{-- Removed mb-2, letting gap handle the spacing --}}
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
                                <h4 class="h3 m-0"
                                    style="border-radius: 7px; border: 2px solid #ff6600; padding: 10px 20px; font-weight: 600; font-size: 17px; color: #ff6600; text-align: center;">
                                    App settings
                                </h4>
                                <a href="{{ route('vender.service.provider.trading.unit.app.data', $trading_unit['id']) }}"
                                    style="text-decoration: none;">
                                    <h4 class="h3 m-0"
                                        style="border-radius: 7px; border: 2px solid black; padding: 10px 20px; font-weight: 600; font-size: 17px; color: black; text-align: center;">
                                        App data
                                    </h4>
                                </a>
                            </div>

                            <div class="card default-collapse collapse-icon accordion-icon-rotate m-0" style="box-shadow: none;">

                                {{-- Accordion 1: Booking --}}
                                <div class="card-header info mt-0 mb-1"
                                    style="border: 2px solid black; border-radius: 7px !important; padding: 1.2rem 1rem; cursor: pointer; background: white;"
                                    data-toggle="collapse" data-target="#collaptr_businesss_info">
                                    <div class="card-title lead m-0" style="color: black !important;">
                                        Booking
                                        <div class="tags">
                                            <div class="tag">Service Provider</div>
                                            <div class="tag">Hub</div>
                                        </div>
                                    </div>
                                </div>
                                <div id="collaptr_businesss_info" class="collapse mb-3"
                                    style="border: 2px solid black; border-top: 0; border-radius: 0 0 6px 6px; margin-top: -10px; background: white;">
                                    <div class="card-content">
                                        <div class="card-body" style="padding: 20px;">
                                            <div class="row align-items-center py-2">
                                                <div class="col-12 col-sm-5">
                                                    <h6 class="mb-0 font-weight-bold">Booking start time</h6>
                                                </div>
                                                <div class="col-12 col-sm-7 text-secondary">
                                                    {{ $trading_unit['app_setting']['start_time'] ?? '' }}</div>
                                            </div>
                                            <hr class="m-0">
                                            <div class="row align-items-center py-2">
                                                <div class="col-12 col-sm-5">
                                                    <h6 class="mb-0 font-weight-bold">Last booking time</h6>
                                                </div>
                                                <div class="col-12 col-sm-7 text-secondary">
                                                    {{ $trading_unit['app_setting']['end_time'] ?? '' }}</div>
                                            </div>
                                            <hr class="m-0">
                                            <div class="row align-items-center py-2">
                                                <div class="col-12 col-sm-5">
                                                    <h6 class="mb-0 font-weight-bold">Booking time intervals</h6>
                                                </div>
                                                <div class="col-12 col-sm-7 text-secondary">
                                                    {{ $trading_unit['app_setting']['interval'] ?? '' }} minutes</div>
                                            </div>
                                        </div>
                                        @if ($is_provider != 'off')
                                            <div class="footers m-0" style="border-radius: 0 0 5px 5px;">
                                                <a
                                                    href="{{ route('vender.service.provider.trading.unit.booking.setting', $trading_unit['id']) }}">
                                                    <button type="button" class="btn btn-dark round btn-min-width m-0">Edit</button>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Accordion 2: Invoice Document --}}
                                <div class="card-header info mt-1 mb-1"
                                    style="border: 2px solid black; border-radius: 7px !important; padding: 1.2rem 1rem; cursor: pointer; background: white;"
                                    data-toggle="collapse" data-target="#invoice_settings">
                                    <div class="card-title lead m-0" style="color: black !important;">
                                        Invoice Document
                                        <div class="tags">
                                            <div class="tag">Service Provider</div>
                                        </div>
                                    </div>
                                </div>
                                <div id="invoice_settings" class="collapse mb-3"
                                    style="border: 2px solid black; border-top: 0; border-radius: 0 0 6px 6px; margin-top: -10px; background: white;">
                                    <div class="card-content">
                                        <div class="card-body" style="padding: 20px;">
                                            <div class="row py-2">
                                                <div class="col-12 col-sm-5">
                                                    <h6 class="mb-0 font-weight-bold">Business Name</h6>
                                                </div>
                                                <div class="col-12 col-sm-7 text-secondary">
                                                    @if ($trading_unit['trading_template'] == 1)
                                                        {{ ucfirst(auth()->user()->profile->company_name) }}
                                                    @elseif ($trading_unit['trading_template'] == 2)
                                                        {{ ucfirst(auth()->user()->profile->company_name) }} Trading as
                                                        {{ $trading_unit['trading_name']['name'] }}
                                                    @elseif ($trading_unit['trading_template'] == 3)
                                                        {{ ucfirst($trading_unit['trading_name']['name'] ?? '') }}
                                                    @endif
                                                </div>
                                            </div>
                                            <hr class="m-0">

                                            {{-- Address Logic Re-structured purely for display --}}
                                            <div class="row py-2">
                                                <div class="col-12 col-sm-5">
                                                    <h6 class="mb-0 font-weight-bold">Address</h6>
                                                </div>
                                                <div class="col-12 col-sm-7 text-secondary">
                                                    @if ($trading_unit['operation_type'] == 'Both' || $trading_unit['operation_type'] == 'On-site')
                                                        @if (!empty($trading_unit['site']['address_line_1']))
                                                            {{ $trading_unit['site']['address_line_1'] }},<br> @endif
                                                        @if (!empty($trading_unit['app_setting']['city']))
                                                            {{ $trading_unit['app_setting']['city'] }},<br> @endif
                                                        @if (!empty($trading_unit['app_setting']['postcode']))
                                                            {{ $trading_unit['app_setting']['postcode'] }} @endif
                                                    @else
                                                        @if (!empty($profile['address_line_1']))
                                                            {{ $profile['address_line_1'] }},<br> @endif
                                                        @if (!empty($profile['city']))
                                                            {{ $profile['city'] }},<br> @endif
                                                        @if (!empty($profile['postcode']))
                                                            {{ $profile['postcode'] }} @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <hr class="m-0">

                                            <div class="row py-2">
                                                <div class="col-12 col-sm-5">
                                                    <h6 class="mb-0 font-weight-bold">Contact Info</h6>
                                                </div>
                                            </div>
                                            <div class="row py-1">
                                                <div class="col-12 col-sm-5">
                                                    <h6 class="mb-0 pl-3">Include Landline</h6>
                                                </div>
                                                <div class="col-12 col-sm-7 text-secondary">
                                                    {{ ucfirst(strtolower($trading_unit['app_setting']['show_landline'] ?? '')) }}
                                                    {{ $trading_unit['landline'] ?? '' }}</div>
                                            </div>
                                            <div class="row py-1">
                                                <div class="col-12 col-sm-5">
                                                    <h6 class="mb-0 pl-3">Include Mobile</h6>
                                                </div>
                                                <div class="col-12 col-sm-7 text-secondary">
                                                    {{ ucfirst(strtolower($trading_unit['app_setting']['show_mobile'] ?? '')) }}
                                                    {{ $trading_unit['mobile'] ?? '' }}</div>
                                            </div>
                                            <div class="row py-1">
                                                <div class="col-12 col-sm-5">
                                                    <h6 class="mb-0 pl-3">Include Email</h6>
                                                </div>
                                                <div class="col-12 col-sm-7 text-secondary">
                                                    {{ ucfirst(strtolower($trading_unit['app_setting']['show_email'] ?? '')) }}
                                                    {{ $trading_unit['email'] ?? '' }}</div>
                                            </div>
                                            <div class="row py-1 mb-2">
                                                <div class="col-12 col-sm-5">
                                                    <h6 class="mb-0 pl-3">Include Website</h6>
                                                </div>
                                                <div class="col-12 col-sm-7 text-secondary">
                                                    {{ ucfirst(strtolower($trading_unit['app_setting']['show_website'] ?? '')) }}
                                                    {{ $trading_unit['website'] ?? '' }}</div>
                                            </div>

                                            @if ($user['profile']['vat_register'] == 'YES')
                                                <hr class="m-0">
                                                <div class="row align-items-center py-2">
                                                    <div class="col-12 col-sm-5">
                                                        <h6 class="mb-0 font-weight-bold">UK VAT Number</h6>
                                                    </div>
                                                    <div class="col-12 col-sm-7 text-secondary">
                                                        {{ auth()->user()->profile['uk_vat_no'] ?? '' }}</div>
                                                </div>
                                            @endif

                                            <hr class="m-0">
                                            <div class="row align-items-center py-2">
                                                <div class="col-12 col-sm-5">
                                                    <h6 class="mb-0 font-weight-bold">Include Bank Transfer Details</h6>
                                                </div>
                                                <div class="col-12 col-sm-7 text-secondary">
                                                    {{ ucfirst(strtolower($trading_unit['app_setting']['bank_transfer'] ?? '')) }}
                                                </div>
                                            </div>

                                            @if (($trading_unit['app_setting']['bank_transfer'] ?? '') == 'YES')
                                                <div class="row py-1">
                                                    <div class="col-12 col-sm-5">
                                                        <h6 class="mb-0 pl-3">Account Name</h6>
                                                    </div>
                                                    <div class="col-12 col-sm-7 text-secondary">
                                                        {{ $trading_unit['app_setting']['account_name'] ?? '' }}</div>
                                                </div>
                                                <div class="row py-1">
                                                    <div class="col-12 col-sm-5">
                                                        <h6 class="mb-0 pl-3">Sort Code</h6>
                                                    </div>
                                                    <div class="col-12 col-sm-7 text-secondary">
                                                        {{ $trading_unit['app_setting']['sort_code'] ?? '' }}</div>
                                                </div>
                                                <div class="row py-1">
                                                    <div class="col-12 col-sm-5">
                                                        <h6 class="mb-0 pl-3">Account Number</h6>
                                                    </div>
                                                    <div class="col-12 col-sm-7 text-secondary">
                                                        {{ $trading_unit['app_setting']['account_number'] ?? '' }}</div>
                                                </div>
                                                <div class="row py-1 mb-2">
                                                    <div class="col-12 col-sm-5">
                                                        <h6 class="mb-0 pl-3">Payment Reference</h6>
                                                    </div>
                                                    <div class="col-12 col-sm-7 text-secondary">
                                                        {{ ucfirst(strtolower($trading_unit['app_setting']['is_payment_reference'] ?? '')) }}
                                                        {{ $trading_unit['app_setting']['payment_reference'] ?? '' }}</div>
                                                </div>
                                            @endif

                                        </div>
                                        @if ($is_provider != 'off')
                                            <div class="footers m-0" style="border-radius: 0 0 5px 5px;">
                                                <a href="{{ route('vender.service.provider.trading.unit.invoice.sample', $trading_unit['id']) }}"
                                                    target="_blank">
                                                    <button type="button" class="btn btn-dark round btn-min-width m-0">View
                                                        Sample</button>
                                                </a>
                                                <a
                                                    href="{{ route('vender.service.provider.trading.unit.invoice.setting', $trading_unit['id']) }}">
                                                    <button type="button" class="btn btn-dark round btn-min-width m-0">Edit</button>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Accordion 3: Workstream --}}
                                <div class="card-header info mt-1 mb-1"
                                    style="border: 2px solid black; border-radius: 7px !important; padding: 1.2rem 1rem; cursor: pointer; background: white;"
                                    data-toggle="collapse" data-target="#collaptr_Workstream_info">
                                    <div class="card-title lead m-0" style="color: black !important;">
                                        Workstream
                                        <div class="tags">
                                            <div class="tag">Service Provider</div>
                                        </div>
                                    </div>
                                </div>
                                <div id="collaptr_Workstream_info" class="collapse mb-3"
                                    style="border: 2px solid black; border-top: 0; border-radius: 0 0 6px 6px; margin-top: -10px; background: white;">
                                    <div class="card-content">
                                        <div class="card-body" style="padding: 20px;">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered zero-configuration w-100 m-0">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Workstream name</th>
                                                            <th>Status</th>
                                                            <th style="text-align: center;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($workstreams as $contact)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $contact['workstream_name'] }}</td>
                                                                <td>{{ $contact['status'] }}</td>
                                                                <td style="text-align: center;">
                                                                    <a
                                                                        href="{{ route('vender.service.provider.trading.unit.view.work.stream', [$contact['id'], $trading_unit['id']]) }}">
                                                                        <i class="ft-eye" style="color: #ff6600;"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="footers m-0" style="border-radius: 0 0 5px 5px;">
                                            <a
                                                href="{{ route('vender.service.provider.trading.unit.add.work.stream', $trading_unit['id']) }}">
                                                <button type="button" class="btn btn-dark round btn-min-width m-0">ADD</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                {{-- Accordion 4: Products --}}
                                <div class="card-header info mt-1 mb-1"
                                    style="border: 2px solid black; border-radius: 7px !important; padding: 1.2rem 1rem; cursor: pointer; background: white;"
                                    data-toggle="collapse" data-target="#product_offer">
                                    <div class="card-title lead m-0" style="color: black !important;">
                                        Products
                                        <div class="tags">
                                            <div class="tag">Service Provider</div>
                                            <div class="tag">Hub</div>
                                        </div>
                                    </div>
                                </div>
                                <div id="product_offer" class="collapse mb-3"
                                    style="border: 2px solid black; border-top: 0; border-radius: 0 0 6px 6px; margin-top: -10px; background: white;">
                                    <div class="card-content">
                                        <div class="card-body" style="padding: 20px;">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered zero-configuration w-100 m-0">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Product Name</th>
                                                            <th>Product Description</th>
                                                            <th>Job Coverage</th>
                                                            <th>Price</th>
                                                            <th>Price Type</th>
                                                            <th>Status</th>
                                                            <th style="text-align: center;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($trading_unit['product_offers'] as $contact)
                                                            <tr>
                                                                <td>{{ $contact['product_no'] }}</td>
                                                                <td>{{ $contact['product_name'] }}</td>
                                                                <td>{{ $contact['description'] }}</td>
                                                                <td>{{ $contact['job_coverage']['name'] }}</td>
                                                                <td>{{ number_format($contact['price'], 2) }}</td>
                                                                <td>{{ $contact['price_type'] }}</td>
                                                                <td>{{ $contact['status'] }}</td>
                                                                <td style="text-align: center;">
                                                                    <a
                                                                        href="{{ route('vender.service.provider.trading.unit.hub.setting.view.product.offer', [$contact['id'], $trading_unit['id']]) }}">
                                                                        <i class="ft-eye" style="color: #ff6600;"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="footers m-0" style="border-radius: 0 0 5px 5px;">
                                            <a
                                                href="{{ route('vender.service.provider.trading.unit.hub.setting.product.offer', $trading_unit['id']) }}">
                                                <button type="button" class="btn btn-dark round btn-min-width m-0">Add</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                {{-- Accordion 5: Job Types --}}
                                <div class="card-header info mt-1 mb-1"
                                    style="border: 2px solid black; border-radius: 7px !important; padding: 1.2rem 1rem; cursor: pointer; background: white;"
                                    data-toggle="collapse" data-target="#job_type">
                                    <div class="card-title lead m-0" style="color: black !important;">
                                        Job types
                                        <div class="tags">
                                            <div class="tag">Hub</div>
                                        </div>
                                    </div>
                                </div>
                                <div id="job_type" class="collapse mb-3"
                                    style="border: 2px solid black; border-top: 0; border-radius: 0 0 6px 6px; margin-top: -10px; background: white;">
                                    <div class="card-content">
                                        <div class="card-body" style="padding: 20px;">
                                            <div class="row align-items-start py-2">
                                                <div class="col-12 col-md-3">
                                                    <h6 class="mb-2 font-weight-bold">Job Type</h6>
                                                </div>
                                                <div class="col-12 col-md-9 text-secondary"
                                                    style="display: flex; flex-wrap: wrap; gap: 8px;">
                                                    @foreach ($trading_unit['job_types'] as $job_type)
                                                        <span class="badge badge-success">{{ $job_type['job_type']['name'] }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="footers m-0" style="border-radius: 0 0 5px 5px;">
                                            <a
                                                href="{{ route('vender.service.provider.trading.unit.hub.setting.job.type', $trading_unit['id']) }}">
                                                <button type="button" class="btn btn-dark round btn-min-width m-0">Edit</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endsection

            @section('script')
                <script src="/modules/admin/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>

                <script>
                    $(document).ready(function() {
                        if ($('.zero-configuration').length > 0) {
                            if ($.fn.dataTable.isDataTable('.zero-configuration')) {
                                $('.zero-configuration').DataTable().destroy();
                            }

                            var oTable = $('.zero-configuration').DataTable({
                                "bPaginate": $('.zero-configuration tbody tr').length > 10,
                                "iDisplayLength": 10,
                                "bAutoWidth": false,
                                "ordering": false,
                                "width": "100%",
                                "columnDefs": [{
                                    "targets": "_all",
                                    "orderable": false
                                }]
                            });

                            // Re-adjust heavily nested DataTables when their accordions are opened
                            $('.collapse').on('shown.bs.collapse', function() {
                                oTable.columns.adjust().draw();
                            });

                            $(window).on('resize', function() {
                                oTable.columns.adjust();
                            });
                        }
                    });
                </script>
            @endsection

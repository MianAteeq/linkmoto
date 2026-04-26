@extends('vender::layouts.master')

@section('css_custom')
    <style>
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
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3" id="page-title">App Settings</h3>
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
                        <li class="breadcrumb-item">
                            <a style="color: black"
                                href="{{ route('vender.service.provider.trading.unit.app.setting', $trading_unit['id']) }}">App
                                Settings</a>
                        </li>
                        <li class="breadcrumb-item active" id="breadcrumb-section"></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div style="border-radius: 7px; border: 2px solid black;">

                {{-- Header --}}
                <div style="padding: 15px 18px; border-bottom: 2px solid black;">
                    <div style="display: flex; align-items: flex-start; gap: 10px;">
                        <img src="/trading_unit.png" style="width: 22px; flex-shrink: 0; margin-top: 2px;">
                        <span
                            style="font-weight: 600; font-size: 15px; color: #000; line-height: 1.5; word-break: break-word;">
                            <span style="color:#ff6600">Trading Unit : </span>{{ $trading_unit['name'] }}
                        </span>
                    </div>
                </div>

                {{-- Body --}}
                <div style="padding: 15px;">

                    {{-- Business Name --}}
                    <div style="margin-bottom: 12px; font-size: 14px; font-weight: 500;">
                        <span style="color:#ff6600;">Business Name : </span>
                        @if ($trading_unit['trading_template'] == 1)
                            {{ auth()->user()->profile->company_name }}
                        @elseif ($trading_unit['trading_template'] == 2)
                            {{ auth()->user()->profile->company_name }} Trading as
                            {{ $trading_unit['trading_name']['name'] }}
                        @elseif ($trading_unit['trading_template'] == 3)
                            {{ $trading_unit['trading_name']['name'] ?? '' }}
                        @endif
                    </div>

                    {{-- Online Status --}}
                    <div style="margin-bottom: 8px; font-size: 14px; font-weight: 500;">
                        <span style="color:#ff6600;">Online Status :</span>
                    </div>

                    {{-- Marketplace / Quotes / Bookings --}}
                    <div style="margin-bottom: 12px; font-size: 13px; font-weight: 500; line-height: 1.9;">
                        <div>Marketplace :
                            @isset($trading_unit['hub_setting'])
                                {{ $trading_unit['hub_setting']['is_marketplace'] ? 'On' : 'Off' }}
                            @else
                                Off
                            @endisset
                        </div>
                        <div>Quotes :
                            @isset($trading_unit['hub_setting'])
                                {{ $trading_unit['hub_setting']['is_quote'] ? 'On' : 'Off' }}
                            @else
                                Off
                            @endisset
                        </div>
                        <div>Bookings :
                            @isset($trading_unit['hub_setting'])
                                {{ $trading_unit['hub_setting']['is_booking'] ? 'On' : 'Off' }}
                            @else
                                Off
                            @endisset
                        </div>
                    </div>

                    {{-- Dates --}}
                    <div
                        style="font-size: 12px; font-weight: 500; color: #444; line-height: 1.8; border-top: 1px solid #e0e0e0; padding-top: 10px;">
                        <div>Created: {{ \Carbon\Carbon::parse($trading_unit['created_at'])->format('d/m/Y') }} at
                            {{ \Carbon\Carbon::parse($trading_unit['created_at'])->format('H:i') }}</div>
                        <div>Last updated: {{ \Carbon\Carbon::parse($trading_unit['updated_at'])->format('d/m/Y') }} at
                            {{ \Carbon\Carbon::parse($trading_unit['updated_at'])->format('H:i') }}</div>
                    </div>
                </div>

                {{-- Footer Buttons --}}
                <div
                    style="border-top: 2px solid black; padding: 12px 15px; display: flex; flex-direction: column; gap: 8px;">
                    @if ($trading_unit['status'] == 'PENDING' || $trading_unit['status'] == 'INACTIVE')
                        <a href="{{ route('vender.service.provider.trading.unit.active', $trading_unit['id']) }}">
                            <button type="button" class="btn btn-dark round btn-min-width" style="width: 100%;">Activate
                                Trade Unit</button>
                        </a>
                    @else
                        <a href="{{ route('vender.service.provider.trading.unit.in.active', $trading_unit['id']) }}">
                            <button type="button" class="btn btn-dark round btn-min-width" style="width: 100%;">Inactivate
                                Trade Unit</button>
                        </a>
                    @endif

                    @if ($trading_unit['active_status'] == 'OFFLINE')
                        <a href="{{ route('vender.service.provider.trading.unit.Online', $trading_unit['id']) }}">
                            <button type="button" class="btn btn-dark round btn-min-width" style="width: 100%;">Show
                                Online</button>
                        </a>
                    @else
                        <a href="{{ route('vender.service.provider.trading.unit.offline', $trading_unit['id']) }}">
                            <button type="button" class="btn btn-dark round btn-min-width" style="width: 100%;">Show
                                Offline</button>
                        </a>
                    @endif
                </div>

            </div>
        </div>
        <div class="col-md-9" id="contens"
            style="border-radius: 6px;margin-bottom: 10px;padding-bottom: 10px;margin-top: 0px;">
            <div class="row ">
                <a href="{{ route('vender.service.provider.trading.unit.view', $trading_unit['id']) }}">
                    <h4 class="h3"
                        style="border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 15px;">
                        Overview</h2>
                </a>
                <a href="{{ route('vender.service.provider.trading.unit.app.setting', $trading_unit['id']) }}">
                    <h4 class="h3"
                        style="border-radius: 7px; border: 2px solid #ff6600; padding: 10px; font-weight: 600; font-size: 17px; color: #ff6600;margin-left: 15px;">
                        App settings</h2>
                </a>
                <a href="{{ route('vender.service.provider.trading.unit.app.data', $trading_unit['id']) }}">
                    <h4 class="h3"
                        style="border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 15px;">
                        App data </h2>
                </a>


            </div>

            <div class="card default-collapse collapse-icon accordion-icon-rotate"
                style="box-shadow: none;margin-top: -6px;">




                <a id="headingCollapse1" class="card-header info mt-2"
                    style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;"
                    data-toggle="collapse" href="#collaptr_businesss_info" data-section="Booking" aria-expanded="false"
                    aria-controls="collaptr_businesss_info">
                    <div class="card-title lead ">Booking
                        <div class="tags">
                            <div class="tag">Service Provider</div>
                            <div class="tag">Hub</div>
                        </div>
                    </div>
                </a>
                <div id="collaptr_businesss_info" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
                    style="border-left: 2px solid black;
                    margin-top: -4px;
                    border-right: 2px solid black;
                    border-bottom: 2px solid black;
                    border-bottom-left-radius: 6px;
                    border-bottom-right-radius: 6px;"
                    class="collapse " aria-expanded="false">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="font-weight: 600;">Booking start time</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ $trading_unit['app_setting']['start_time'] ?? '' }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="font-weight: 600;">Last booking time</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ $trading_unit['app_setting']['end_time'] ?? '' }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="font-weight: 600;">Booking time intervals</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ $trading_unit['app_setting']['interval'] ?? '' }} minutes
                                </div>
                            </div>






                        </div>
                        <div class="footers" @if ($is_provider == 'off') style="display:none" @endif>

                            <a
                                href="{{ route('vender.service.provider.trading.unit.booking.setting', $trading_unit['id']) }}">
                                <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                                    style="float: right;">Edit</button></a>

                        </div>
                    </div>
                </div>


                <a id="headingCollapse2" class="card-header info mt-2"
                    style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;"
                    data-toggle="collapse" href="#invoice_settings" data-section="Invoice Document"
                    aria-expanded="false" aria-controls="invoice_settings">
                    <div class="card-title lead ">Invoice Document
                        <div class="tags">
                            <div class="tag">Service Provider</div>

                        </div>
                    </div>
                </a>
                <div id="invoice_settings" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
                    style="border-left: 2px solid black;
                        margin-top: -4px;
                        border-right: 2px solid black;
                        border-bottom: 2px solid black;
                        border-bottom-left-radius: 6px;
                        border-bottom-right-radius: 6px;"
                    class="collapse " aria-expanded="false">
                    <div class="card-content">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="font-weight: 600;">Business Name</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    @if ($trading_unit['trading_template'] == 1)
                                        {{ ucfirst(auth()->user()->profile->company_name) }}
                                    @endif
                                    @if ($trading_unit['trading_template'] == 2)
                                        {{ ucfirst(auth()->user()->profile->company_name) }} Trading as
                                        {{ $trading_unit['trading_name']['name'] }}
                                    @endif
                                    @if ($trading_unit['trading_template'] == 3)
                                        {{ ucfirst($trading_unit['trading_name']['name']) ?? '' }}
                                    @endif
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="font-weight: 600;">Address</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    <p class="address_line1">
                                        @if ($trading_unit['operation_type'] == 'Both' || $trading_unit['operation_type'] == 'On-site')
                                            @if (!empty($trading_unit['site']['address_line_1']))
                                                {{ $trading_unit['site']['address_line_1'] }},<br>
                                            @endif
                                            @if (!empty($trading_unit['site']['address_line_2']))
                                                {{ $trading_unit['site']['address_line_2'] }},<br>
                                            @endif
                                            @if (!empty($trading_unit['site']['address_line_3']))
                                                {{ $trading_unit['site']['address_line_3'] }},<br>
                                            @endif
                                            @if (!empty($trading_unit['site']['address_line_4']))
                                                {{ $trading_unit['site']['address_line_4'] }},<br>
                                            @endif
                                            @if (!empty($trading_unit['app_setting']['city']))
                                                {{ $trading_unit['app_setting']['city'] }},<br>
                                            @endif
                                            @if (!empty($trading_unit['app_setting']['postcode']))
                                                {{ $trading_unit['app_setting']['postcode'] }}
                                            @endif
                                        @else
                                            @if (!empty($profile['address_line_1']))
                                                {{ $profile['address_line_1'] }},<br>
                                            @endif
                                            @if (!empty($profile['address_line_2']))
                                                {{ $profile['address_line_2'] }},<br>
                                            @endif
                                            @if (!empty($profile['address_line_3']))
                                                {{ $profile['address_line_3'] }},<br>
                                            @endif
                                            @if (!empty($profile['address_line_4']))
                                                {{ $profile['address_line_4'] }},<br>
                                            @endif
                                            @if (!empty($profile['city']))
                                                {{ $profile['city'] }},<br>
                                            @endif
                                            @if (!empty($profile['postcode']))
                                                {{ $profile['postcode'] }}
                                            @endif
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="font-weight: 600;">Contact Info</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">

                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="padding-left: 16px;">Include Landline</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ ucfirst(strtolower($trading_unit['app_setting']['show_landline'])) ?? '' }}
                                    {{ $trading_unit['landline'] ?? '' }}
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="padding-left: 16px;">Include Mobile</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ ucfirst(strtolower($trading_unit['app_setting']['show_mobile'])) ?? '' }}
                                    {{ $trading_unit['mobile'] ?? '' }}
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="padding-left: 16px;">Include Email</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ ucfirst(strtolower($trading_unit['app_setting']['show_email'])) ?? '' }}
                                    {{ $trading_unit['email'] ?? '' }}
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="padding-left: 16px;">Include Website</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ ucfirst(strtolower($trading_unit['app_setting']['show_website'])) ?? '' }}
                                    {{ $trading_unit['website'] ?? '' }}
                                </div>
                            </div>


                            @if ($user['profile']['vat_register'] == 'YES')
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="font-weight: 600;">UK VAT Number</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        <p>{{ auth()->user()->profile['uk_vat_no'] ?? '' }}</p>
                                    </div>
                                </div>
                            @endif
                            <hr>
                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="font-weight: 600;">Include Bank Transfer Details</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    <p> {{ ucfirst(strtolower($trading_unit['app_setting']['bank_transfer'])) ?? '' }}</p>
                                </div>
                            </div>

                            @if ($trading_unit['app_setting']['bank_transfer'] == 'YES')
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="padding-left: 15px;">Account Name</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        <p> {{ $trading_unit['app_setting']['account_name'] ?? '' }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="padding-left: 15px;">Sort Code</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        <p> {{ $trading_unit['app_setting']['sort_code'] ?? '' }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="padding-left: 15px;">Account Number</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        <p> {{ $trading_unit['app_setting']['account_number'] ?? '' }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="padding-left: 15px;">Payment Reference</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        <p> {{ ucfirst(strtolower($trading_unit['app_setting']['is_payment_reference'] ?? '')) }}
                                        </p>
                                        {{ $trading_unit['app_setting']['payment_reference'] ?? '' }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="padding-left: 15px;">Remittance Email Address</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        <p>{{ ucfirst(strtolower($trading_unit['app_setting']['show_remittance_email'])) ?? '' }}
                                            {{ $trading_unit['email'] ?? '' }}</p>
                                    </div>
                                </div>
                                <hr>
                            @endif
                            @if ($trading_unit['operation_type'] != 'Both' || $trading_unit['operation_type'] != 'On-site')
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="font-weight: 600;">Job Location (Mobile Service)</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        <p>Job Mobile Address </p>
                                    </div>
                                </div>
                                <hr>
                            @endif

                            @php
                                $companyName =
                                    $profile['company_name'] ?? (auth()->user()->profile['company_name'] ?? null);
                                $tradingName = $trading_unit['trading_name']['name'] ?? null;

                                $businessNameFormat = $trading_unit['trading_template'] ?? null;
                                $businessSetup = $profile['organization_status'] ?? null;

                                $footerLegalName = null;

                                // Case 1: Trading Name Only
                                if ($businessNameFormat == '3' && $companyName && $tradingName) {
                                    $footerLegalName = $companyName . ' trading as ' . $tradingName;
                                }
                                // Case 2: LTD / LLP
                                elseif (
                                    in_array($businessSetup, [
                                        'Limited Company (Ltd)',
                                        'Limited Liability Partnership (LLP)',
                                    ]) &&
                                    $companyName
                                ) {
                                    $footerLegalName = $companyName;
                                }
                            @endphp
                            @php
                                $profileData = auth()->user()->profile;

                                $businessSetup = $profile['organization_status'] ?? null;

                                $isCompany = in_array($businessSetup, [
                                    'Limited Company (Ltd)',
                                    'Limited Liability Partnership (LLP)',
                                ]);

                                $registeredAddress = null;

                                if ($isCompany) {
                                    $addressParts = array_values(
                                        array_filter([
                                            $profileData['address_line_1'] ?? null,
                                            $profileData['address_line_2'] ?? null,
                                            $profileData['address_line_3'] ?? null,
                                            $profileData['address_line_4'] ?? null,
                                            $profileData['city'] ?? null,
                                            $profileData['postcode'] ?? null,
                                        ]),
                                    );

                                    if (!empty($addressParts)) {
                                        // Add comma to all except last
                                        $formattedParts = [];

                                        foreach ($addressParts as $index => $part) {
                                            $formattedParts[] = $index < count($addressParts) - 1 ? $part . ',' : $part;
                                        }

                                        $registeredAddress = implode('<br>', $formattedParts);
                                    }
                                }

                                // Jurisdiction
                                $registeredJurisdiction = $isCompany
                                    ? $profileData['company_jurisdiction'] ?? null
                                    : null;

                                // Company Number
                                $registeredCompanyNo = $isCompany ? $profileData['registration_no'] ?? null : null;
                            @endphp
                            @if (
                                !empty($footerLegalName) ||
                                    !empty($registeredAddress) ||
                                    !empty($registeredJurisdiction) ||
                                    !empty($registeredCompanyNo))
                                <div class="form-group row align-items-center mb-2">
                                    <div class="col-md-5">
                                        <h6 class="mb-0" style="font-weight: 600;">Footer</h6>
                                    </div>
                                </div>
                            @endif

                            @if (!empty($footerLegalName))
                                <div class="row">
                                    <div class="col-md-5">
                                        <h6 class="mb-0" style="padding-left: 15px;">Legal Business Name</h6>
                                    </div>

                                    <div class="col-sm-7 text-secondary">

                                        <p>
                                            {{ $footerLegalName }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if (!empty($registeredAddress))
                                <div class="row">
                                    <div class="col-md-5 ">
                                        <h6 class="mb-0" style="padding-left: 15px;">Footer – Registered Address</h6>
                                    </div>

                                    <div class="col-md-7 text-secondary">


                                        <p class="mb-0">{!! $registeredAddress !!}</p>
                                    </div>
                                </div>
                            @endif
                            @if (!empty($registeredJurisdiction))
                                <div class="row mt-1">
                                    <div class="col-md-5">
                                        <h6 class="mb-0" style="padding-left: 15px;"> Footer – Registered Company
                                            Jurisdiction</h6>
                                    </div>

                                    <div class="col-sm-7 text-secondary">


                                        <p>{{ $registeredJurisdiction }}</p>
                                    </div>
                                </div>
                            @endif
                            @if (!empty($registeredCompanyNo))
                                <div class="row">
                                    <div class="col-md-5">
                                        <h6 class="mb-0" style="padding-left: 15px;"> Footer – Registered Company Number
                                        </h6>
                                    </div>

                                    <div class="col-sm-7 text-secondary">


                                        <p>{{ $registeredCompanyNo }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="footers" @if ($is_provider == 'off') style="display:none" @endif>

                            <a
                                href="{{ route('vender.service.provider.trading.unit.invoice.setting', $trading_unit['id']) }}">
                                <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                                    style="float: right;">Edit</button></a>
                            <a href="{{ route('vender.service.provider.trading.unit.invoice.sample', $trading_unit['id']) }}"
                                target="_blank">
                                <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                                    style="float: right;">View Sample</button></a>


                        </div>
                    </div>
                </div>

                <a id="headingCollapse2" class="card-header info mt-2"
                    style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;display:none;"
                    data-toggle="collapse" href="#vat_settings" aria-expanded="false" aria-controls="vat_settings">
                    <div class="card-title lead ">VAT settings</div>
                </a>
                <div id="vat_settings" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
                    style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
                    class="collapse " aria-expanded="false">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="font-weight: 600;">VAT </h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ auth()->user()['profile']['vat_register'] }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="font-weight: 600;">VAT Booking </h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ $trading_unit['app_setting']['vat_booking'] ?? '0' == 1 ? 'YES' : 'NO' }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="font-weight: 600;">VAT Quote</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ $trading_unit['app_setting']['vat_quote'] ?? '0' == 1 ? 'YES' : 'NO' }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="font-weight: 600;">VAT Jobs</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ $trading_unit['app_setting']['vat_job'] ?? '0' == 1 ? 'YES' : 'NO' }}
                                </div>
                            </div>
                        </div>
                        <div class="footers" @if ($is_provider == 'off') style="display:none" @endif>

                            <a
                                href="{{ route('vender.service.provider.trading.unit.vat.setting', $trading_unit['id']) }}">
                                <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                                    style="float: right;">Edit</button></a>

                        </div>
                    </div>
                </div>
                <a id="headingCollapse1" class="card-header info mt-2"
                    style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;"
                    data-toggle="collapse" href="#collaptr_Workstream_info" data-section="Workstream"
                    aria-expanded="false" aria-controls="collaptr_Workstream_info">
                    <div class="card-title lead ">Workstream
                        <div class="tags">
                            <div class="tag">Service Provider</div>

                        </div>
                    </div>
                </a>
                <div id="collaptr_Workstream_info" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
                    style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
                    class="collapse " aria-expanded="false">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Workstream name</th>
                                                <th>Status</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            {{-- @foreach ($users as $user)

                                        @endforeach --}}


                                            @foreach ($workstreams as $contact)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $contact['workstream_name'] }}</td>
                                                    <td>{{ $contact['status'] }}</td>



                                                    <td> <a
                                                            href="{{ route('vender.service.provider.trading.unit.view.work.stream', [$contact['id'], $trading_unit['id']]) }}"><i
                                                                class="ft-eye"></i></a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Workstream name</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="footers">

                            <a
                                href="{{ route('vender.service.provider.trading.unit.add.work.stream', $trading_unit['id']) }}">
                                <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                                    style="float: right;">ADD</button></a>

                        </div>
                    </div>
                </div>
                @isset($trading_unit['hub_setting'])
                    <a id="headingCollapse1" class="card-header info mt-2"
                        style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;"
                        data-toggle="collapse" href="#online_status_info" data-section="Online Statuses"
                        aria-expanded="false" aria-controls="online_status_info">
                        <div class="card-title lead ">Online statuses
                            <div class="tags">
                                <div class="tag">Hub</div>
                            </div>
                        </div>
                    </a>
                    <div id="online_status_info" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
                        style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
                        class="collapse " aria-expanded="false">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="font-weight: 600;">Marketplace</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        @isset($trading_unit['hub_setting'])
                                            {{ $trading_unit['hub_setting']['is_marketplace'] ? 'On' : 'Off' }}
                                        @else
                                            'Off'
                                        @endisset
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="font-weight: 600;">Quotes</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        @isset($trading_unit['hub_setting'])
                                            {{ $trading_unit['hub_setting']['is_quote'] ? 'On' : 'Off' }}
                                        @else
                                            'Off'
                                        @endisset
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="font-weight: 600;">Bookings</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        @isset($trading_unit['hub_setting'])
                                            {{ $trading_unit['hub_setting']['is_booking'] ? 'On' : 'Off' }}
                                        @else
                                            'Off'
                                        @endisset
                                    </div>
                                </div>
                            </div>

                            <div class="footers" @if ($is_hub == 'off') style="display: none" @endif>

                                <a
                                    href="{{ route('vender.service.provider.trading.unit.hub.setting.online.status', $trading_unit['id']) }}">
                                    <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                                        style="float: right;">Edit</button></a>

                            </div>
                        </div>
                    </div>
                @endisset

                <a id="headingCollapse2" class="card-header info mt-2"
                    style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;"
                    data-toggle="collapse" href="#opening_hours" data-section="Opening Hours" aria-expanded="false"
                    aria-controls="opening_hours">
                    <div class="card-title lead ">Opening hours
                        <div class="tags">

                            <div class="tag">Hub</div>
                        </div>
                    </div>
                </a>
                @isset($trading_unit['hub_setting'])
                    <div id="opening_hours" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
                        style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
                        class="collapse " aria-expanded="false">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="font-weight: 600;">Monday </h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        @if ($trading_unit['hub_setting']['is_monday'] == 1)
                                            {{ $trading_unit['hub_setting']['monday_start_time'] }} -
                                            {{ $trading_unit['hub_setting']['monday_end_time'] }}
                                        @else
                                            Close
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="font-weight: 600;">Tuesday </h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        @if ($trading_unit['hub_setting']['is_tuesday'] == 1)
                                            {{ $trading_unit['hub_setting']['tuesday_start_time'] }} -
                                            {{ $trading_unit['hub_setting']['tuesday_end_time'] }}
                                        @else
                                            Closed
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="font-weight: 600;">Wednesday</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        @if ($trading_unit['hub_setting']['is_wednesday'] == 1)
                                            {{ $trading_unit['hub_setting']['wednesday_start_time'] }} -
                                            {{ $trading_unit['hub_setting']['wednesday_end_time'] }}
                                        @else
                                            Closed
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="font-weight: 600;">Thursaday</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        @if ($trading_unit['hub_setting']['is_thursday'] == 1)
                                            {{ $trading_unit['hub_setting']['thursday_start_time'] }} -
                                            {{ $trading_unit['hub_setting']['thursday_end_time'] }}
                                        @else
                                            Closed
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="font-weight: 600;">Friday</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        @if ($trading_unit['hub_setting']['is_friday'] == 1)
                                            {{ $trading_unit['hub_setting']['friday_start_time'] }} -
                                            {{ $trading_unit['hub_setting']['friday_end_time'] }}
                                        @else
                                            Closed
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="font-weight: 600;">Saturday</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        @if ($trading_unit['hub_setting']['is_saturday'] == 1)
                                            {{ $trading_unit['hub_setting']['saturday_start_time'] }} -
                                            {{ $trading_unit['hub_setting']['saturday_end_time'] }}
                                        @else
                                            Closed
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="font-weight: 600;">Sunday</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        @if ($trading_unit['hub_setting']['is_sunday'] == 1)
                                            {{ $trading_unit['hub_setting']['sunday_start_time'] }} -
                                            {{ $trading_unit['hub_setting']['sunday_end_time'] }}
                                        @else
                                            Closed
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="footers" @if ($is_hub == 'off') style="display: none" @endif>

                                <a
                                    href="{{ route('vender.service.provider.trading.unit.hub.setting.opening.hour', $trading_unit['id']) }}">
                                    <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                                        style="float: right;">Edit</button></a>

                            </div>
                        </div>
                    </div>
                @endisset
                @isset($trading_unit['hub_setting'])
                    <a id="headingCollapse2" class="card-header info mt-2"
                        style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;"
                        data-toggle="collapse" href="#social_media" data-section="Social Media Profiles"
                        aria-expanded="false" aria-controls="social_media">
                        <div class="card-title lead ">Social media profiles
                            <div class="tags">

                                <div class="tag">Hub</div>
                            </div>
                        </div>
                    </a>
                    <div id="social_media" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
                        style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
                        class="collapse " aria-expanded="false">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="font-weight: 600;">Website </h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $trading_unit['hub_setting']['website'] }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="font-weight: 600;">Facebook </h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $trading_unit['hub_setting']['facebook'] }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="font-weight: 600;">Instagram</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $trading_unit['hub_setting']['instagram'] }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0" style="font-weight: 600;">Trust Pilot</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $trading_unit['hub_setting']['trust_pilot'] }}
                                    </div>
                                </div>
                            </div>
                            <div class="footers">

                                <a
                                    href="{{ route('vender.service.provider.trading.unit.hub.setting.social.media', $trading_unit['id']) }}">
                                    <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                                        style="float: right;">Edit</button></a>

                            </div>
                        </div>
                    </div>
                @endisset
                <a id="headingCollapse2" class="card-header info mt-2"
                    style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;"
                    data-toggle="collapse" href="#job_type" data-section="Job Types" aria-expanded="false"
                    aria-controls="job_type">
                    <div class="card-title lead ">Job types
                        <div class="tags">
                            <div class="tag">Hub</div>
                        </div>
                    </div>
                </a>
                <div id="job_type" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
                    style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
                    class="collapse " aria-expanded="false">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0" style="font-weight: 600;">Job Type </h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <div class="row">
                                        @foreach ($trading_unit['job_types'] as $job_type)
                                            <div class="col-md-3 mt-1">
                                                <span
                                                    class="badge badge-primary-1">{{ $job_type['job_type']['name'] }}</span>
                                            </div>
                                        @endforeach


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footers">

                            <a
                                href="{{ route('vender.service.provider.trading.unit.hub.setting.job.type', $trading_unit['id']) }}">
                                <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                                    style="float: right;">Edit</button></a>

                        </div>
                    </div>
                </div>
                <a id="headingCollapse2" class="card-header info mt-2"
                    style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;"
                    data-toggle="collapse" href="#product_offer" data-section="Products" aria-expanded="false"
                    aria-controls="product_offer">
                    <div class="card-title lead ">Products
                        <div class="tags">
                            <div class="tag">Service Provider</div>
                            <div class="tag">Hub</div>
                        </div>
                    </div>
                </a>
                <div id="product_offer" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
                    style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
                    class="collapse " aria-expanded="false">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Product Name</th>
                                                <th>Product Description</th>
                                                <th>Job Coverage</th>
                                                <th>Price</th>
                                                <th>Price Type</th>
                                                <th>Status</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            {{-- @foreach ($users as $user)

                                        @endforeach --}}


                                            @foreach ($trading_unit['product_offers'] as $contact)
                                                <tr>

                                                    <td>{{ $contact['product_no'] }}</td>
                                                    <td>{{ $contact['product_name'] }}</td>
                                                    <td>{{ $contact['description'] }}</td>
                                                    <td>{{ $contact['job_coverage']['name'] }}</td>
                                                    <td>{{ number_format($contact['price'], 2) }}</td>
                                                    <td>
                                                        @if ($contact['price_type'] == 'FIXED')
                                                            Fixed
                                                        @endif
                                                        @if ($contact['price_type'] == 'STARTING_FROM')
                                                            Starting From
                                                        @endif
                                                        @if ($contact['price_type'] == 'HOURLY')
                                                            Hourly
                                                        @endif
                                                        @if ($contact['price_type'] == 'POA')
                                                            POA
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($contact['status'] == 'ACTIVE')
                                                            Active
                                                        @else
                                                            InActive
                                                        @endif
                                                    </td>



                                                    <td> <a
                                                            href="{{ route('vender.service.provider.trading.unit.hub.setting.view.product.offer', [$contact['id'], $trading_unit['id']]) }}"><i
                                                                class="ft-eye"></i></a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Product Name</th>
                                                <th>Product Description</th>
                                                <th>Job Coverage</th>
                                                <th>Price</th>
                                                <th>Price Type</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="footers">

                            <a
                                href="{{ route('vender.service.provider.trading.unit.hub.setting.product.offer', $trading_unit['id']) }}">
                                <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                                    style="float: right;">Add</button></a>

                        </div>
                    </div>
                </div>
                <a id="headingCollapse2" class="card-header info mt-2"
                    style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;"
                    data-toggle="collapse" href="#warrenty_job" data-section="Warranty Jobs" aria-expanded="false"
                    aria-controls="warrenty_job">
                    <div class="card-title lead ">Warranty jobs
                        <div class="tags">

                            <div class="tag">Hub</div>
                        </div>
                    </div>
                </a>
                <div id="warrenty_job" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
                    style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
                    class="collapse " aria-expanded="false">
                    <div class="card-content">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0" style="font-weight: 600;">Warranty Job </h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <div class="row">
                                        @foreach ($trading_unit['warranty_jobs'] as $job_type)
                                            <div class="col-md-3 mt-1">
                                                <span
                                                    class="badge badge-success">{{ $job_type['warranty_job']['name'] }}</span>
                                            </div>
                                        @endforeach


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footers">

                            <a
                                href="{{ route('vender.service.provider.trading.unit.hub.setting.warranty.job', $trading_unit['id']) }}">
                                <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                                    style="float: right;">Edit</button></a>

                        </div>
                    </div>
                </div>
                <a id="headingCollapse2" class="card-header info mt-2"
                    style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;"
                    data-toggle="collapse" href="#vehicle_specialist" data-section="Vehicle Specialist"
                    aria-expanded="false" aria-controls="vehicle_specialist">
                    <div class="card-title lead ">Vehicle specialist
                        <div class="tags">
                            <div class="tag">Hub</div>
                        </div>
                    </div>
                </a>
                <div id="vehicle_specialist" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
                    style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
                    class="collapse " aria-expanded="false">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0" style="font-weight: 600;">Vehicle specialist </h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <div class="row">
                                        @foreach ($trading_unit['vehicle_specialists'] as $job_type)
                                            <div class="col-md-3 mt-1">
                                                <span
                                                    class="badge badge-success">{{ $job_type['vehicle_specialist']['name'] }}</span>
                                            </div>
                                        @endforeach


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footers">

                            <a
                                href="{{ route('vender.service.provider.trading.unit.hub.setting.vehicle.specialist', $trading_unit['id']) }}">
                                <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                                    style="float: right;">Edit</button></a>

                        </div>
                    </div>
                </div>
                <a id="headingCollapse2" class="card-header info mt-2"
                    style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;"
                    data-toggle="collapse" href="#accreditation"
                    data-section="Accreditation & Schemes aria-expanded="false" aria-controls="accreditation">
                    <div class="card-title lead ">Accreditation & schemes
                        <div class="tags">
                            <div class="tag">Hub</div>
                        </div>
                    </div>
                </a>
                <div id="accreditation" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
                    style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
                    class="collapse " aria-expanded="false">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0" style="font-weight: 600;">Accreditation & schemes </h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <div class="row">
                                        @foreach ($trading_unit['accreditations'] as $job_type)
                                            <div class="col-md-3 mt-1">
                                                <span
                                                    class="badge badge-success">{{ $job_type['accreditation']['name'] }}</span>
                                            </div>
                                        @endforeach


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footers">

                            <a
                                href="{{ route('vender.service.provider.trading.unit.hub.setting.accreditation', $trading_unit['id']) }}">
                                <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                                    style="float: right;">Edit</button></a>

                        </div>
                    </div>
                </div>
                <a id="headingCollapse2" class="card-header info mt-2"
                    style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;"
                    data-toggle="collapse" href="#payment_method" data-section="Payment Methods" aria-expanded="false"
                    aria-controls="payment_method">
                    <div class="card-title lead ">Payment methods
                        <div class="tags">

                            <div class="tag">Hub</div>
                        </div>
                    </div>
                </a>
                <div id="payment_method" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
                    style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
                    class="collapse " aria-expanded="false">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0" style="font-weight: 600;">Payment methods </h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    <div class="row">
                                        @foreach ($trading_unit['payment_methods'] as $job_type)
                                            <div class="col-md-3 mt-1">
                                                <span
                                                    class="badge badge-success">{{ $job_type['payment_method']['name'] }}</span>
                                            </div>
                                        @endforeach


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footers">

                            <a
                                href="{{ route('vender.service.provider.trading.unit.hub.setting.payment.method', $trading_unit['id']) }}">
                                <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                                    style="float: right;">Edit</button></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts_lib')
    <script>
        $(document).ready(function() {
            const defaultTitle = 'App Settings';
            const defaultCrumb = '';

            // Bootstrap 3 uses 'show.bs.collapse' and 'hide.bs.collapse'
            $('.collapse').on('show.bs.collapse', function() {
                const id = $(this).attr('id');
                const section = $('[href="#' + id + '"][data-section]').attr('data-section');
                if (section) {
                    $('#page-title').text(section);
                    $('#breadcrumb-section').text(section);
                }
            });

            $('.collapse').on('hide.bs.collapse', function() {
                $('#page-title').text(defaultTitle);
                $('#breadcrumb-section').text(defaultCrumb);
            });
        });
    </script>
@endsection

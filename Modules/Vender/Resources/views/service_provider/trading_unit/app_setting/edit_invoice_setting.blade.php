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

        .form-control {
            width: 55%;
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

        .payment_reference {
            display: none;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 45px;
            height: 24px;
            float: left;
        }


        .switch input {
            display: none;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            background-color: #ccc;
            border-radius: 24px;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            transition: 0.4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            border-radius: 50%;
            transition: 0.4s;
        }

        input:checked+.slider {
            background-color: #ff6600;
        }

        input:checked+.slider:before {
            transform: translateX(20px);
        }

        .pill-toggle {
            display: inline-flex;
            border: 1px solid #ccc;
            border-radius: 25px;
            overflow: hidden;
            background: #fff;
        }

        .pill-toggle input {
            display: none;
        }

        .pill-toggle label {
            padding: 6px 16px;
            font-size: 14px;
            cursor: pointer;
            color: #555;
            margin: 0;
            transition: 0.2s ease;
        }

        .pill-toggle input:checked+label {
            background: #f97316;
            color: #fff;
        }

        .value-text {
            font-size: 14px;
            color: #444;
        }

        .disabled-toggle {
            opacity: 0.6;
            pointer-events: none;
            background: #f5f5f5;
        }

        .disabled-toggle label {
            cursor: not-allowed;
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3">Trade unit information</h3>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Products</a>
                        </li>


                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.service.provider') }}">Service Provider</a>
                        </li>
                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.service.provider.trading.unit') }}">Trade Units</a>
                        </li>
                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.service.provider.trading.unit.view', $trading_unit['id']) }}">
                                {{ $trading_unit['name'] }}</a>
                        </li>
                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.service.provider.trading.unit.view', $trading_unit['id']) }}">
                                Overview</a>
                        </li>

                        <li class="breadcrumb-item"> Trade unit information
                        </li>
                        <li class="breadcrumb-item"> Edit Invoice Setting
                        </li>



                    </ol>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-3">
            <div style="border-radius: 7px;border: 2px solid black;  ">
                <h4 class="h3" style="font-weight: 600; font-size: 17px;padding: 10px; ">
                    <div>
                        <div style="float: left; width: 10%;">
                            <img src="/trading_unit.png" style="width: 22px;margin-top: -5px;">
                        </div>
                        <div style="float: left; width: 90%;">
                            <span>Trading Unit : {{ $trading_unit['name'] }}</span>
                        </div>



                    </div>
                    <div style="margin: 20px;margin-top: 53px;font-weight: 500;font-size: 13px;">
                        <span>Trading Name : {{ $trading_unit['trading_name']['name'] ?? '' }}</span>
                    </div>
                    <div style="margin: 20px;margin-top: 15px;font-weight: 500;font-size: 13px;">
                        <span class="success">{{ $trading_unit['status'] }}</span>
                    </div>
                    <div style="margin: 20px;margin-top: 15px;font-weight: 500;font-size: 13px;">
                        <span class="success">{{ $trading_unit['active_status'] }}</span>
                    </div>
                    <div style="margin: 20px;margin-top: 15px;font-weight: 500;font-size: 13px;margin-bottom:0px">
                        <span>Created: {{ \Carbon\Carbon::parse($trading_unit['created_at'])->format('d/m/Y') }} at
                            {{ \Carbon\Carbon::parse($trading_unit['created_at'])->format('h:i') }}</span>
                    </div>

                </h4>
                <div class="footers" style="text-align: center;">

                    @if ($trading_unit['status'] == 'PENDING' || $trading_unit['status'] == 'INACTIVE')
                        <a href="{{ route('vender.service.provider.trading.unit.active', $trading_unit['id']) }}"> <button
                                type="button" style="width: 80%;"
                                class="btn btn-dark round btn-min-width mr-1 mb-1">ACTIVATE TRADE UNIT</button></a>
                    @else
                        <a href="{{ route('vender.service.provider.trading.unit.in.active', $trading_unit['id']) }}">
                            <button type="button" style="width: 80%;"
                                class="btn btn-dark round btn-min-width mr-1 mb-1">INACTIVATE TRADE UNIT</button></a>
                    @endif
                    @if ($trading_unit['active_status'] == 'OFFLINE')
                        <a href="{{ route('vender.service.provider.trading.unit.Online', $trading_unit['id']) }}"> <button
                                type="button" style="width: 80%;" class="btn btn-dark round btn-min-width mr-1 mb-1">SHOW
                                ONLINE</button></a>
                    @else
                        <a href="{{ route('vender.service.provider.trading.unit.offline', $trading_unit['id']) }}"> <button
                                type="button" style="width: 80%;" class="btn btn-dark round btn-min-width mr-1 mb-1">SHOW
                                OFFLINE</button></a>
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

                {{-- <a href="{{route('vender.service.provider.trading.unit.hub.setting',$trading_unit['id'])}}"> <h4 class="h3" style="border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 15px;"> Hub profile settings </h2> </a> --}}


            </div>

            <div class="card default-collapse collapse-icon accordion-icon-rotate"
                style="box-shadow: none;margin-top: -6px;">




                <a id="headingCollapse1" href="{{ redirect()->back()->getTargetUrl() }}" class="card-header info mt-2"
                    style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;"
                    data-toggle="" href="#collaptr_businesss_info" aria-expanded="false">
                    <div class="card-title lead collapsed">Invoice settings</div>
                </a>
                <div id="collaptr_businesss_info" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
                    style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
                    class="collapse show" aria-expanded="false">
                    <div class="card-content">
                        <form action="{{ route('vender.service.provider.trading.unit.invoice.setting.submit') }}"
                            id="contens" method="POST" enctype="multipart/form-data" id="contens"> @csrf
                            <div class="link-body" style="padding: 10px">

                                <input type="hidden" name="id" value="{{ $trading_unit['id'] }}">
                                <div class="form-group row">
                                    <label class="col-md-4 label-control" for="eventRegInput5">Business Name Format
                                        *</label>
                                    <div class="col-md-8 mx-auto">
                                        <p>
                                            @if (auth()->user()->profile['organization_status'] === 'Limited Company')
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
                                                    Registered sole trader name
                                                @endif
                                                @if ($trading_unit['trading_template'] == 2)
                                                    Registered sole trader name & trading name
                                                @endif
                                                @if ($trading_unit['trading_template'] == 3)
                                                    Trading name
                                                @endif
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 label-control" for="eventRegInput5">Business Name *</label>
                                    <div class="col-md-8 mx-auto">
                                        <p>
                                            @if ($trading_unit['trading_template'] == 1)
                                                {{ ucfirst(auth()->user()->profile->company_name) }}
                                            @endif
                                            @if ($trading_unit['trading_template'] == 2)
                                                {{ ucfirst(auth()->user()->profile->company_name) }} Trading as
                                                {{ $trading_unit['trading_name']['name'] }}
                                            @endif
                                            @if ($trading_unit['trading_template'] == 3)
                                                {{ ucfirst($trading_unit['trading_name']['name']) }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="form-group row" id="site_show">
                                    <label class="col-md-4 label-control" for="eventRegInput5">Address * (?)</label>
                                    <div class="col-md-8 mx-auto">

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


                                <div class="form-group row align-items-center mb-2">
                                    <label class="col-md-4 label-control">
                                        Contact Info
                                    </label>
                                </div>
                                <div class="form-group row align-items-center mb-2">
                                    <label class="col-md-4 label-control"
                                        style="margin-left: 29px; padding-right: 0px; max-width: 30%;">
                                        Include Landline <span class="text-danger">*</span>
                                    </label>
                                    @php
                                        $landline = $trading_unit['landline'] ?? null;
                                        $isLandlineEmpty = empty($landline);
                                    @endphp

                                    <div class="col-md-2">
                                        <div class="pill-toggle {{ $isLandlineEmpty ? 'disabled-toggle' : '' }}">

                                            <!-- NO -->
                                            <input type="radio" id="landline_no" name="show_landline" value="NO"
                                                {{ $isLandlineEmpty || $trading_unit['app_setting']['show_landline'] !== 'YES' ? 'checked' : '' }}
                                                {{ $isLandlineEmpty ? 'disabled' : '' }}>

                                            <label for="landline_no">No</label>

                                            <!-- YES -->
                                            <input type="radio" id="landline_yes" name="show_landline" value="YES"
                                                {{ !$isLandlineEmpty && $trading_unit['app_setting']['show_landline'] === 'YES' ? 'checked' : '' }}
                                                {{ $isLandlineEmpty ? 'disabled' : '' }}>

                                            <label for="landline_yes">Yes</label>
                                            @if ($isLandlineEmpty)
                                                <input type="hidden" name="show_landline" value="NO">
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-md-6">

                                        <span
                                            class="value-text">{{ $trading_unit['landline'] ?? 'No landline configured → Set in Trade Unit settings' }}</span>
                                    </div>
                                </div>
                                @php
                                    $mobile = $trading_unit['mobile'] ?? null;
                                    $isMobileEmpty = empty($mobile);
                                @endphp

                                <div class="form-group row align-items-center mb-2">
                                    <label class="col-md-4 label-control"
                                        style="margin-left: 29px; padding-right: 0px; max-width: 30%;">
                                        Include Mobile <span class="text-danger">*</span>
                                    </label>

                                    <div class="col-md-2">
                                        <div class="pill-toggle {{ $isMobileEmpty ? 'disabled-toggle' : '' }}">

                                            <!-- NO -->
                                            <input type="radio" id="mobile_no" name="show_mobile" value="NO"
                                                {{ $isMobileEmpty || $trading_unit['app_setting']['show_mobile'] !== 'YES' ? 'checked' : '' }}
                                                {{ $isMobileEmpty ? 'disabled' : '' }}>

                                            <label for="mobile_no">No</label>

                                            <!-- YES -->
                                            <input type="radio" id="mobile_yes" name="show_mobile" value="YES"
                                                {{ !$isMobileEmpty && $trading_unit['app_setting']['show_mobile'] === 'YES' ? 'checked' : '' }}
                                                {{ $isMobileEmpty ? 'disabled' : '' }}>

                                            <label for="mobile_yes">Yes</label>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <span class="value-text">
                                            {{ $mobile ?? 'No mobile configured → Set in Trade Unit settings' }}
                                        </span>
                                    </div>
                                </div>

                                @if ($isMobileEmpty)
                                    <input type="hidden" name="show_mobile" value="NO">
                                @endif
                                @php
                                    $email = $trading_unit['email'] ?? null;
                                    $isEmailEmpty = empty($email);
                                @endphp

                                <div class="form-group row align-items-center mb-2">
                                    <label class="col-md-4 label-control"
                                        style="margin-left: 29px; padding-right: 0px; max-width: 30%;">
                                        Include Email <span class="text-danger">*</span>
                                    </label>

                                    <div class="col-md-2">
                                        <div class="pill-toggle {{ $isEmailEmpty ? 'disabled-toggle' : '' }}">

                                            <!-- NO -->
                                            <input type="radio" id="email_no" name="show_email" value="NO"
                                                {{ $isEmailEmpty || $trading_unit['app_setting']['show_email'] !== 'YES' ? 'checked' : '' }}
                                                {{ $isEmailEmpty ? 'disabled' : '' }}>

                                            <label for="email_no">No</label>

                                            <!-- YES -->
                                            <input type="radio" id="email_yes" name="show_email" value="YES"
                                                {{ !$isEmailEmpty && $trading_unit['app_setting']['show_email'] === 'YES' ? 'checked' : '' }}
                                                {{ $isEmailEmpty ? 'disabled' : '' }}>

                                            <label for="email_yes">Yes</label>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <span class="value-text">
                                            {{ $email ?? 'No email configured → Set in Trade Unit settings' }}
                                        </span>
                                    </div>
                                </div>

                                @if ($isEmailEmpty)
                                    <input type="hidden" name="show_email" value="NO">
                                @endif
                                @php
                                    $website = $trading_unit['website'] ?? null;
                                    $isWebsiteEmpty = empty($website);
                                @endphp

                                <div class="form-group row align-items-center mb-2">
                                    <label class="col-md-4 label-control"
                                        style="margin-left: 29px; padding-right: 0px; max-width: 30%;">
                                        Include Website <span class="text-danger">*</span>
                                    </label>

                                    {{-- Toggle --}}
                                    <div class="col-md-2">
                                        <div class="pill-toggle {{ $isWebsiteEmpty ? 'disabled-toggle' : '' }}">

                                            <!-- NO -->
                                            <input type="radio" id="website_no" name="show_website" value="NO"
                                                {{ $isWebsiteEmpty || $trading_unit['app_setting']['show_website'] !== 'YES' ? 'checked' : '' }}
                                                {{ $isWebsiteEmpty ? 'disabled' : '' }}>
                                            <label for="website_no">No</label>

                                            <!-- YES -->
                                            <input type="radio" id="website_yes" name="show_website" value="YES"
                                                {{ !$isWebsiteEmpty && $trading_unit['app_setting']['show_website'] === 'YES' ? 'checked' : '' }}
                                                {{ $isWebsiteEmpty ? 'disabled' : '' }}>
                                            <label for="website_yes">Yes</label>

                                        </div>
                                    </div>

                                    {{-- Value --}}
                                    <div class="col-md-6">
                                        <span class="value-text">
                                            {{ $website ?? 'No website configured → Set in Trade Unit settings' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Hidden fallback --}}
                                @if ($isWebsiteEmpty)
                                    <input type="hidden" name="show_website" value="NO">
                                @endif


                                @if ($user['profile']['vat_register'] == 'YES')
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" for="eventRegInput5">UK VAT Number</label>
                                        <div class="col-md-8 mx-auto">
                                            <p>{{ auth()->user()->profile['uk_vat_no'] }}</p>
                                        </div>
                                    </div>
                                @endif
                                {{-- <div class="form-group row" id="bank_transfer_show">
                                    <label class="col-md-4 label-control" for="eventRegInput5">Bank Transfer Details
                                        *</label>
                                    <div class="col-md-8 mx-auto">
                                        <select id="bank_transfer" name="bank_transfer" class="form-control"
                                            style="width: 55%;border-radius: 7px;">
                                            <option value="none" selected="">Select Bank Transfer Detail</option>
                                            <option value="YES" @if ('YES' === $trading_unit['app_setting']['bank_transfer']) selected @endif>YES
                                            </option>
                                            <option value="NO" @if ('NO' === $trading_unit['app_setting']['bank_transfer']) selected @endif>NO
                                            </option>



                                        </select>
                                        <p class="text-danger bank_transfer"
                                            style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This
                                            Field is Required !</p>
                                    </div>
                                </div> --}}
                                @php
                                    $bankTransfer = $trading_unit['app_setting']['bank_transfer'] ?? null;
                                @endphp

                                <div class="form-group row align-items-center mb-2" id="bank_transfer_show">
                                    <label class="col-md-4 label-control">
                                        Include Bank Transfer Details <span class="text-danger">*</span>
                                    </label>

                                    <div class="col-md-3">
                                        <div class="pill-toggle">

                                            <!-- NO -->
                                            <input type="radio" id="bank_transfer_no" name="bank_transfer"
                                                value="NO"
                                                {{ $bankTransfer === 'NO' || $bankTransfer === null ? 'checked' : '' }}>
                                            <label for="bank_transfer_no">No</label>

                                            <!-- YES -->
                                            <input type="radio" id="bank_transfer_yes" name="bank_transfer"
                                                value="YES" {{ $bankTransfer === 'YES' ? 'checked' : '' }}>
                                            <label for="bank_transfer_yes">Yes</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row bank_transfer_info">
                                    <label class="col-md-4 label-control"
                                        style="margin-left: 29px; padding-right: 0px; max-width: 30%;"
                                        for="bank_select">Select Bank *</label>
                                    <div class="col-md-8 mx-auto">
                                        <select id="bank_select" class="form-control" onchange="fillBankDetails(this)">
                                            <option value="">-- Select Bank --</option>
                                            @foreach ($banks as $bank)
                                                <option @if ($bank['id'] == $bank_id) selected @endif
                                                    value="{{ $bank['id'] }}"
                                                    data-account-name="{{ $bank['account_name'] }}"
                                                    data-sort-code="{{ $bank['sort_code'] }}"
                                                    data-account-number="{{ $bank['account_number'] }}">
                                                    {{ $bank['bank_name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="text-danger bank_select"
                                            style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This
                                            Field is Required!</p>
                                        <input type="hidden" id="account_name" name="account_name"
                                            value="{{ $trading_unit['app_setting']['account_name'] ?? '' }}">
                                        <input type="hidden" id="sort_code" name="sort_code"
                                            value="{{ $trading_unit['app_setting']['sort_code'] ?? '' }}">
                                        <input type="hidden" id="account_number" name="account_number"
                                            value="{{ $trading_unit['app_setting']['account_number'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="form-group row bank_transfer_info">
                                    <label class="col-md-4 label-control"
                                        style="margin-left: 29px; padding-right: 0px; max-width: 30%;"
                                        for="eventRegInput5">Account Name *</label>
                                    <div class="col-md-8 mx-auto">
                                        <p id="text_account_name">{{ $trading_unit['app_setting']['account_name'] ?? '' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group row bank_transfer_info">
                                    <label class="col-md-4 label-control"
                                        style="margin-left: 29px; padding-right: 0px; max-width: 30%;"
                                        for="eventRegInput5">Sort code *</label>
                                    <div class="col-md-8 mx-auto">
                                        <p id="text_sort_code">{{ $trading_unit['app_setting']['sort_code'] ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="form-group row bank_transfer_info">
                                    <label class="col-md-4 label-control"
                                        style="margin-left: 29px; padding-right: 0px; max-width: 30%;"
                                        for="eventRegInput5">Account Number *</label>
                                    <div class="col-md-8 mx-auto">
                                        <p id="text_account_number">
                                            {{ $trading_unit['app_setting']['account_number'] ?? '' }}</p>
                                    </div>
                                </div>


                                @php
                                    $paymentReference =
                                        $trading_unit['app_setting']['is_payment_reference'] === 'YES' ? 'YES' : null;
                                    $isEnabled = !empty($paymentReference);
                                @endphp
                                {{-- @dd($isEnabled) --}}

                                <div class="form-group row align-items-center bank_transfer_info mb-2">
                                    <label class="col-md-4 label-control "
                                        style="margin-left: 29px; padding-right: 0px; max-width: 30%;">
                                        Include Payment Reference <span class="text-danger">*</span>
                                    </label>

                                    <div class="col-md-3">
                                        <div class="pill-toggle">

                                            <!-- NO -->
                                            <input type="radio" id="payment_ref_no" name="is_payment_reference"
                                                value="NO" {{ !$isEnabled ? 'checked' : '' }}>
                                            <label for="payment_ref_no">No</label>

                                            <!-- YES -->
                                            <input type="radio" id="payment_ref_yes" name="is_payment_reference"
                                                value="YES" {{ $isEnabled ? 'checked' : '' }}>
                                            <label for="payment_ref_yes">Yes</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row payment_reference_box bank_transfer_info ">

                                    <label class="col-md-4 label-control">

                                    </label>

                                    <div class="col-md-6 payment_reference_box"
                                        style="{{ $isEnabled ? '' : 'display:none;' }}">
                                        <select name="payment_reference" class="form-control">
                                            <option value="">Select Payment Reference</option>



                                            <option value="Invoice Number"
                                                {{ $trading_unit['app_setting']['payment_reference'] === 'Invoice Number' ? 'selected' : '' }}>
                                                Invoice Number
                                            </option>
                                        </select>

                                        <p class="text-danger payment_reference d-none">
                                            This field is required!
                                        </p>
                                    </div>
                                </div>
                                @php
                                    $remittanceEmail = $trading_unit['email'] ?? null;
                                    $isRemittanceEmpty = empty($remittanceEmail);
                                @endphp

                                <div class="form-group row align-items-center mb-2 bank_transfer_info">
                                    <label class="col-md-4 label-control"
                                        style="margin-left: 29px; padding-right: 0px; max-width: 30%;">
                                        Include Remittance Email <span class="text-danger">*</span>
                                    </label>

                                    {{-- Toggle --}}
                                    <div class="col-md-2">
                                        <div class="pill-toggle {{ $isRemittanceEmpty ? 'disabled-toggle' : '' }}">

                                            <!-- NO -->
                                            <input type="radio" id="remittance_no" name="show_remittance_email"
                                                value="NO"
                                                {{ $isRemittanceEmpty || !($trading_unit['app_setting']['show_remittance_email'] ?? false) ? 'checked' : '' }}
                                                {{ $isRemittanceEmpty ? 'disabled' : '' }}>

                                            <label for="remittance_no">No</label>

                                            <!-- YES -->
                                            <input type="radio" id="remittance_yes" name="show_remittance_email"
                                                value="YES"
                                                {{ !$isRemittanceEmpty && ($trading_unit['app_setting']['show_remittance_email'] ?? false) ? 'checked' : '' }}
                                                {{ $isRemittanceEmpty ? 'disabled' : '' }}>

                                            <label for="remittance_yes">Yes</label>

                                        </div>
                                    </div>

                                    {{-- Value --}}
                                    <div class="col-md-6">
                                        <span class="value-text">
                                            {{ $remittanceEmail ?? 'No  email configured' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Hidden fallback --}}
                                @if ($isRemittanceEmpty)
                                    <input type="hidden" name="show_remittance_email" value="NO">
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
                                                $formattedParts[] =
                                                    $index < count($addressParts) - 1 ? $part . ',' : $part;
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
                                        <label class="col-md-4 label-control">
                                            Footer
                                        </label>
                                    </div>
                                @endif

                                @if (!empty($footerLegalName))
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control"
                                            style="margin-left: 29px; padding-right: 0px; max-width: 30%;">
                                            Legal Business Name
                                        </label>

                                        <div class="col-md-6">
                                            {{-- Hidden input for form submission --}}
                                            <input type="hidden" name="footer_business_name"
                                                value="{{ $footerLegalName }}">

                                            {{-- Display --}}
                                            <p class="footer_business_name">
                                                {{ $footerLegalName }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($registeredAddress))
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" style="margin-left: 29px; max-width: 30%;">
                                            Footer – Registered Office Address
                                        </label>

                                        <div class="col-md-6">
                                            <input type="hidden" name="footer_office_address"
                                                value="{{ $registeredAddress }}">

                                            <p class="mb-0">{!! $registeredAddress !!}</p>
                                        </div>
                                    </div>
                                @endif
                                @if (!empty($registeredJurisdiction))
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" style="margin-left: 29px; max-width: 30%;">
                                            Footer – Registered Company Jurisdiction
                                        </label>

                                        <div class="col-md-6">
                                            <input type="hidden" name="company_jurisdiction"
                                                value="{{ $registeredJurisdiction }}">

                                            <p>{{ $registeredJurisdiction }}</p>
                                        </div>
                                    </div>
                                @endif
                                @if (!empty($registeredCompanyNo))
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control" style="margin-left: 29px; max-width: 30%;">
                                            Footer – Registered Company Number
                                        </label>

                                        <div class="col-md-6">
                                            <input type="hidden" name="company_number"
                                                value="{{ $registeredCompanyNo }}">

                                            <p>{{ $registeredCompanyNo }}</p>
                                        </div>
                                    </div>
                                @endif







                            </div>
                            <div class="footers">

                                <button type="button" onclick="submitDetailsForm()"
                                    class="btn btn-dark round btn-min-width mr-1 mb-1" style="float: right;">Save</button>
                                <a href="{{ redirect()->back()->getTargetUrl() }}"><button type="button"
                                        class="btn btn-dark round btn-min-width mr-1 mb-1"
                                        style="float: right;">Cancel</button></a>


                            </div>
                        </form>
                    </div>
                </div>















            </div>






        </div>
    </div>


@endsection

@section('script')
    <script>
        function submitDetailsForm() {
            let array = ['address_line_1'];
            if ($("#bank_transfer").val() === "YES") {
                array = ['address_line_1', 'account_name', 'sort_code', 'account_number', 'payment_reference'];
            }

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

    <script>
        $('#site_id').on('change', function() {

            let sites = @json($sites);

            let site = sites.filter((item) => parseInt(item.id) === parseInt(this.value));

            console.log(site);

            if (site.length > 0) {
                let s = site[0];
                let fullAddress = [
                    s.address_line_1,
                    s.address_line_2,
                    s.address_line_3,
                    s.address_line_4,
                    s.city,
                    s.postcode
                ].filter(Boolean).join(',\n');
                $('.address_line1').val(site[0].address_line_1);
                $('.address_line2').val(site[0].address_line_2);
                $('.address_line3').val(site[0].address_line_3);
                $('.address_line4').val(site[0].address_line_4);
                $('.cities').val(site[0].city);
                $('.postcodes').val(site[0].postcode);

                $('.address_line1').html(fullAddress.replace(/\n/g, '<br>'));
                $('.address_line2').text(site[0].address_line_2);
                $('.address_line3').text(site[0].address_line_3);
                $('.address_line4').text(site[0].address_line_4);
                $('.cities').text(site[0].city);
                $('.postcodes').text(site[0].postcode);
            }


        });
        $(document).ready(function() {
            function toggleBankTransferInfo() {
                const value = $("input[name='bank_transfer']:checked").val();

                if (value === "YES") {
                    $(".bank_transfer_info").show();
                } else {
                    $(".bank_transfer_info").hide();
                }
            }

            // Run on page load (in case value is already set)
            toggleBankTransferInfo();

            // Run when value changes
            $(document).on("change", "input[name='bank_transfer']", function() {
                console.log(this.value); // use console instead of alert for debugging
                toggleBankTransferInfo();
            });
        });

        function fillBankDetails(select) {
            let selectedOption = select.options[select.selectedIndex];

            console.log(selectedOption)

            let accountName = selectedOption.dataset.accountName || '';
            let sortCode = selectedOption.dataset.sortCode || '';
            let accountNumber = selectedOption.dataset.accountNumber || '';

            // Fill hidden inputs for form submission
            document.getElementById('account_name').value = accountName;
            document.getElementById('sort_code').value = sortCode;
            document.getElementById('account_number').value = accountNumber;

            $('#text_account_name').text(accountName);
            $('#text_sort_code').text(sortCode);
            $('#text_account_number').text(accountNumber);

        }

        $(document).on("change", "input[name='is_payment_reference']", function() {
            togglePaymentReference();
        });

        $(document).ready(function() {
            togglePaymentReference();
        });

        function togglePaymentReference() {
            const value = $("input[name='is_payment_reference']:checked").val();

            if (value === "YES") {
                $(".payment_reference_box").slideDown(200);
            } else {
                $(".payment_reference_box").slideUp(200);

                // reset dropdown when disabled
                $("select[name='payment_reference']").val('');
            }
        }
    </script>
@endsection

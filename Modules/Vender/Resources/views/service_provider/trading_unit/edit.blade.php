@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        .dataTables_wrapper .dataTables_length {
            display: none;
        }

        .dataTables_wrapper .dataTables_filter {

            display: none;
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
        }

        .dataTables_wrapper .dataTables_info {
            display: none;
        }

        table.dataTable tbody td {

            color: black;
        }

        table.dataTable thead th,
        table.dataTable thead td {
            padding: 10px 18px;
            border-bottom: 1px solid #111;
            font-size: 11px;
            padding-left: 8px;
            padding-right: 1px;
        }

        th {
            white-space: pre-line;
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

        #headingCollapse14:before {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e843";
            transition: all 300ms linear 0s;
        }

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

        .form-control {

            border: 2px solid black !important;
            height: calc(1em + 1.4rem + 0px);
            border-radius: 7px;
            width: 60%;

        }

        .form-btn {
            text-align: left;
            /* opacity: -0.5; */
            color: #babfcc;
            width: 37%;
            padding: 7px;
            padding-left: 14px;
            float: left;
        }

        .view-btn {
            float: left;
            margin-top: 0px;
            padding: 9px;
            margin-left: 10px;
            background-color: #ff822f !important;
            border-color: #ff822f !important;
        }

        body {
            color: black;
        }

        .view-btn-black {
            /* float: left; */
            margin-top: 0px;
            padding: 9px;
            margin-left: 10px;
            background-color: black !important;
            border-color: black !important;
        }

        .form-control:focus {
            color: #4e5154;
            background-color: #fff;
            border-color: black;
            outline: 0;
            box-shadow: none;
        }

        body.vertical-layout.vertical-menu.menu-expanded .main-menu {
            width: 274px;
            transition: 300ms ease all;
            backface-visibility: hidden;
        }

        body.vertical-layout.vertical-menu.menu-expanded .content,
        body.vertical-layout.vertical-menu.menu-expanded .footer {
            margin-left: 274px;
            /* background-color: white; */
        }

        input:focus:required:invalid {
            border: 2px solid red;
        }

        input:required:valid {
            border: 2px solid black;
        }

        /* --- NEW RESPONSIVE ENHANCEMENTS --- */

        /* 1. Prevent JS and inline styles from freezing the container and form heights */
        #contens,
        form#contens {
            height: auto !important;
            min-height: 469px;
            padding-bottom: 20px;
            /* Add some breathing room before the footer */
        }

        /* Mobile Specific Enhancements */
        @media (max-width: 767px) {

            /* Sidebar spacing */
            .col-md-3 {
                margin-bottom: 25px;
            }

            /* Fix the horizontal form layout to stack vertically */
            .form-group.row {
                display: flex;
                flex-direction: column;
                margin-bottom: 1rem;
            }

            /* Align labels to the left instead of right/center */
            .form-group.row label {
                text-align: left !important;
                margin-bottom: 5px;
                width: 100%;
                padding-left: 15px;
            }

            /* Make inputs span the full width instead of 60% */
            .form-control,
            select.form-control {
                width: 100% !important;
            }

            /* Make Checkboxes stack neatly */
            .d-flex.flex-column {
                align-items: flex-start;
                padding-left: 15px;
            }

            /* Ensure action buttons at bottom stack or share space evenly */
            .footers {
                display: flex;
                flex-direction: column-reverse;
                /* Puts Update above Cancel */
                padding: 15px !important;
            }

            .footers .btn {
                width: 100% !important;
                float: none !important;
                margin-top: 10px;
                margin-right: 0 !important;
            }

            .footers a {
                width: 100%;
            }

            .footers a .btn {
                margin-top: 0;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3">Edit trade unit</h3>
                <div class="breadcrumb-wrapper col-12">
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



                        <li class="breadcrumb-item">Edit trade unit
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
            <div style="border-radius: 7px;border: 2px solid black; ">
                <h4 class="h3" style="font-weight: 600; font-size: 17px;padding: 10px; ">
                    <img src="/trading_unit.png" style="width: 22px;margin-top: -5px;"> Edit trade unit
                </h4>

            </div>
        </div>
        <div class="col-md-9"
            style="border: 2px solid black;border-radius: 6px;margin-bottom: 10px;padding-left: 0;padding-right: 0;">
            <div class="row" style="margin-right: 0;margin-left: 0;">
                <div class="col-md-12" style="border-bottom: 2px solid black;">
                    <h3 style="font-size: 20px; padding: 10px; margin-left: -11px; color: black;padding-bottom: 0px;">Trade
                        unit information</h3>
                </div>


            </div>
            <form action="{{ route('vender.service.provider.trading.unit.update') }}" id="contens" method="POST"
                enctype="multipart/form-data" id="contens" style="height: 469px;">
                @csrf

                <input type="hidden" name="id" value="{{ $trading_unit['id'] }}">
                <div class="link-body" style="padding: 10px">

                    <div class="form-group row">
                        <label class="col-md-4 label-control" for="eventRegInput5">Trade unit name * (?)</label>
                        <div class="col-md-8 mx-auto">
                            <input type="text" id="name" class="form-control" value="{{ $trading_unit['name'] }}"
                                onkeyup="lookup(this);" name="name" placeholder="Trade unit name">
                            @if ($errors->has('name'))
                                <p class="text-danger name" style="padding-left: 10px;width:100%;margin-bottom: -8px;">
                                    {{ $errors->first('name') }}</p>
                            @else
                                <p class="text-danger name"
                                    style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This
                                    Field is
                                    Required !</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 label-control" for="eventRegInput5">Business Name Format * (?)</label>
                        <div class="col-md-8 mx-auto">
                            <select id="trading_template" name="trading_template" class="form-control"
                                onkeyup="lookup(this);" style="width: 60%;border-radius: 7px;">
                                <option value="none" selected="" disabled="">Select Business Name Format</option>

                                @if (auth()->user()->profile['organization_status'] === 'Limited Company (Ltd)')
                                    @if (auth()->user()->profile['organization_status'] === 'Limited Company (Ltd)' ||
                                            auth()->user()->profile['organization_status'] === 'Limited Liability Partnership (LLP)')
                                        <option value="1" @if ($trading_unit['trading_template'] == 1) selected @endif>Registered
                                            company name</option>
                                        <option value="2" @if ($trading_unit['trading_template'] == 2) selected @endif>Registered
                                            company name & trading name</option>
                                        <option value="3" @if ($trading_unit['trading_template'] == 3) selected @endif>Trading
                                            name
                                        </option>
                                    @else
                                        <option value="1" @if ($trading_unit['trading_template'] == 1) selected @endif>Registered
                                            {{ $user['profile']['organization_status'] }} name</option>
                                        <option value="2" @if ($trading_unit['trading_template'] == 2) selected @endif>Registered
                                            {{ $user['profile']['organization_status'] }} & trading name</option>
                                        <option value="3" @if ($trading_unit['trading_template'] == 3) selected @endif>Trading
                                            name
                                            only</option>
                                    @endif



                            </select>
                            <p class="text-danger trading_template"
                                style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This Field is
                                Required !</p>
                        </div>
                    </div>
                    <div class="form-group row" id="trading_name"
                        @if ($trading_unit['trading_template'] == 1) style="display: none" @endif>
                        <label class="col-md-4 label-control" for="eventRegInput5">Trading name * (?)</label>
                        <div class="col-md-8 mx-auto">
                            <select id="trading_name_id" name="trading_name_id" class="form-control" onkeyup="lookup(this);"
                                style="width: 60%;border-radius: 7px;">
                                <option value="none" selected="" disabled="">Select Trading Name</option>
                                @foreach ($trading_names as $name)
                                    {{-- @if ($name['is_change'] == 0) --}}
                                    <option value="{{ $name['id'] }}" @if ($trading_unit['trading_name_id'] == $name['id']) selected @endif>
                                        {{ $name['name'] }}</option>

                                    {{-- @endif --}}
                                @endforeach


                            </select>
                            <p class="text-danger trading_name_id"
                                style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This Field is
                                Required !</p>
                        </div>
                    </div>
                    <div class="form-group row " id="company_name">
                        <label class="col-md-4 label-control" for="eventRegInput5">Business Name</label>
                        <div class="col-md-8 mx-auto">

                            <p class="company_show">
                                @if ($trading_unit['trading_template'] == 1)
                                    {{ auth()->user()->profile->company_name }}
                                @endif
                                @if ($trading_unit['trading_template'] == 2)
                                    {{ auth()->user()->profile->company_name }} Trading as
                                    {{ $trading_unit['trading_name']['name'] }}
                                @endif
                                @if ($trading_unit['trading_template'] == 3)
                                    {{ $trading_unit['trading_name']['name'] }}
                                @endif
                            </p>
                            <p class="text-danger company"
                                style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This
                                Field is
                                Required !</p>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 label-control">How do you provide and offer your services? * (?)
                        </label>
                        <div class="col-md-8 mx-auto">
                            <div class="d-flex flex-column">
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" name="operation_type[]" value="On-site"
                                        class="custom-control-input" id="On-site"
                                        @if (in_array('On-site', explode(',', $user['profile']['operation_type']))) checked @endif>
                                    <label class="custom-control-label" for="On-site">On-site</label>
                                </div>

                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" name="operation_type[]" value="Mobile"
                                        class="custom-control-input" id="Mobile"
                                        @if (in_array('Mobile', explode(',', $user['profile']['operation_type']))) checked @endif>
                                    <label class="custom-control-label" for="Mobile">Mobile</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group row" id="site_show"
                        @if ($trading_unit['operation_type'] == 'Mobile') style="display: none" @else @endif>
                        <label class="col-md-4 label-control" for="eventRegInput5">Address * (?)</label>
                        <div class="col-md-8 mx-auto">
                            <select id="site_id" name="site_id" class="form-control"
                                style="width: 60%;border-radius: 7px;">
                                <option value="none" selected="" disabled="">Select Address</option>
                                @foreach ($sites as $site)
                                    <option value="{{ $site['id'] }}"
                                        @if ($trading_unit['site_id'] == $site['id']) selected @endif>
                                        {{ $site['address_line_1'] }}
                                        {{ $site['address_line_2'] }}</option>
                                @endforeach


                            </select>
                            <p class="text-danger site_id"
                                style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This
                                Field is
                                Required !</p>
                        </div>
                    </div>
                    <div class="form-group row mobile_show"
                        @if ($trading_unit['operation_type'] == 'On-site') style="display: none" @endif>
                        <label class="col-md-4 label-control" for="eventRegInput5">Mobile city / town * (?) </label>
                        <div class="col-md-8 mx-auto">
                            <input type="text" @if ($trading_unit['operation_type'] == 'Both') style="display: none" @endif
                                id="city" class="form-control" value="{{ $trading_unit['city'] }}"
                                onkeyup="lookup(this);" name="city" placeholder="Mobile city / town">
                            <p @if ($trading_unit['operation_type'] == 'Both') style="display: block" @else style="display: none" @endif
                                class="city_show">{{ $trading_unit['city'] }}</p>
                            <p class="text-danger city"
                                style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This
                                Field is
                                Required !</p>

                        </div>
                    </div>
                    <div class="form-group row mobile_show"
                        @if ($trading_unit['operation_type'] == 'On-site') style="display: none" @endif>
                        <label class="col-md-4 label-control" for="eventRegInput5">Mobile postcode * (?) </label>
                        <div class="col-md-8 mx-auto">
                            <input type="text" id="postcode"
                                @if ($trading_unit['operation_type'] == 'Both') style="display: none" @endif class="form-control"
                                value="{{ $trading_unit['postcode'] }}" onkeyup="lookup(this);" name="postcode"
                                placeholder="Mobile postcode">
                            <p @if ($trading_unit['operation_type'] == 'Both') style="display: block" @else style="display: none" @endif
                                class="postcode_show">{{ $trading_unit['postcode'] }}</p>
                            <p class="text-danger postcode"
                                style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">
                                This Field is
                                Required !</p>

                        </div>
                    </div>
                    <div class="form-group row mobile_show"
                        @if ($trading_unit['operation_type'] == 'On-site') style="display: none" @endif>
                        <label class="col-md-4 label-control" for="eventRegInput5">Mobile distance / radius (miles) * (?)
                        </label>
                        <div class="col-md-8 mx-auto">
                            <input type="text" id="radius" class="form-control"
                                value="{{ $trading_unit['radius'] }}" onkeyup="lookup(this);" name="radius"
                                placeholder="Mobile distance">
                            <p class="text-danger radious"
                                style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This
                                Field is
                                Required !</p>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 label-control" for="eventRegInput5">Mobile * </label>
                        <div class="col-md-8 mx-auto">
                            <input type="tel" id="mobile" class="form-control"
                                value="{{ $trading_unit['mobile'] }}" onkeyup="lookup(this);" name="mobile"
                                placeholder="Mobile">
                            <p class="text-danger mobile"
                                style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This
                                Field is
                                Required !</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 label-control" for="eventRegInput5">Landline </label>
                        <div class="col-md-8 mx-auto">
                            <input type="tel" id="landline" class="form-control"
                                value="{{ $trading_unit['landline'] }}" onkeyup="lookup(this);" name="landline"
                                placeholder="Landline">
                            <p class="text-danger landline"
                                style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">
                                This Field is
                                Required !</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 label-control" for="eventRegInput5">Email * </label>
                        <div class="col-md-8 mx-auto">
                            <input type="email" id="email" class="form-control"
                                value="{{ $trading_unit['email'] }}" onkeyup="lookup(this);" name="email"
                                placeholder="Email">
                            <p class="text-danger email"
                                style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">
                                Invalid Email !
                            </p>
                            @if ($errors->has('email'))
                                <p class="text-danger email" style="padding-left: 10px;width:100%;margin-bottom: -8px;">
                                    {{ $errors->first('email') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 label-control" for="eventRegInput5">Website </label>
                        <div class="col-md-8 mx-auto">
                            <input type="text" id="website" class="form-control"
                                value="{{ $trading_unit['website'] }}" onkeyup="lookup(this);" name="website"
                                placeholder="Website">
                            <p class="text-danger website"
                                style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">
                                Invalid Website !
                            </p>
                            @if ($errors->has('website'))
                                <p class="text-danger website" style="padding-left: 10px;width:100%;margin-bottom: -8px;">
                                    {{ $errors->first('website') }}</p>
                            @endif
                        </div>
                    </div>



                </div>
                <div class="footers">

                    <button type="button" onclick="submitDetailsForm()"
                        class="btn btn-dark round btn-min-width mr-1 mb-1" style="float: right;">Update</button>
                    <a href="{{ redirect()->back()->getTargetUrl() }}"><button type="button"
                            class="btn btn-dark round btn-min-width mr-1 mb-1" style="float: right;">Cancel</button></a>


                </div>
            </form>
        </div>
    </div>
@endsection

@extends('admin::admin.layout.app')

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

        #headingCollapse14:before {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e842";
            transition: all 300ms linear 0s;
        }

        #headingCollapsevat:before {
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

        .span {
            background: #ff6600;
            padding: 3px;
            padding-left: 7px;
            border-radius: 4px;
            color: white;
            padding-right: 9px;
            margin-left: 8px;
        }

        .card-footer {
            border-top: 2px solid black;
            padding: 0.5rem 1rem;
        }
    </style>
     <style>

        .section {

            border: 1px solid #000;

            border-radius: 6px;

            margin-bottom: 20px;

            overflow: hidden;

        }



        .section-header {

            font-weight: bold;

            font-size: 16px;

            padding: 10px 15px;

            border-bottom: 1px solid #000;

            background: white;

        }



        .section-body {

            padding: 10px 15px;

        }



        .item {

            display: grid;

            grid-template-columns: 1fr auto 1fr;

            align-items: center;

            padding: 10px 0;

            border-bottom: 1px solid #ddd;

        }



        .item:last-child {

            border-bottom: none;

        }



        .item a {

            color: black;

            text-decoration: none;

            font-weight: 500;

        }



        .badge {

            padding: 6px 12px;

            border-radius: 20px;

            font-size: 13px;

            font-weight: bold;

            color: #fff;

            display: inline-block;

            text-align: center;

            min-width: 80px;

        }



        .badge.todo {

            background: #007bff;

        }



        .badge.verified {

            background: #28a745;

        }



        .badge.pending {

            background: #999;

        }



        .timestamp {

            font-size: 12px;

            color: #555;

            text-align: right;

            white-space: nowrap;

        }



        @media (max-width: 600px) {

            .item {

                grid-template-columns: 1fr;

                row-gap: 5px;

            }



            .badge {

                justify-self: start;

            }



            .timestamp {

                justify-self: start;

            }

        }

    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3">Business</h3>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Business</a>
                        </li>

                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('admin.register') }}">Registered</a>
                        </li>


                        <li class="breadcrumb-item">{{ $user['profile']['trading_name'] }}
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

                    <img src="/home.png" style="width: 22px;margin-top: -5px;"> {{ $user['profile']['trading_name'] }} <br>
                    <span
                        style="margin-left: 26px;
                font-size: 13px;">BSN{{ sprintf('%05d', $user['id']) }}</span>

                </h4>
                <p style="color: black;padding-left: 25px;">Account : @if ($user['application_status'] == 'ACCEPTED')
                        Active
                    @else
                        INACTIVE
                    @endif
                </p>
                <p style="color: black;padding-left: 25px;">Verification : @if (accountAdminVerfied($user['id']) == 0)
                                Active
                            @else
                                Setup
                            @endif
                </p>

                <div class="footers" style="border-top: 2px solid black;padding: 10px ">
                    @if ($user['application_status'] == 'ACCEPTED')
                        <button class="btn btn-primary btn-block"
                            onclick="window.location.href=`{{ route('admin.register.in.active', $user['id']) }}`">INACTIVE</button>
                    @else
                        <button class="btn btn-primary btn-block"
                            onclick="window.location.href=`{{ route('admin.register.active', $user['id']) }}`">ACTIVE</button>
                    @endif

                </div>



            </div>
        </div>
        {{-- @dd($user['sites']) --}}
        <div class="col-md-9" id="contens" style="border-radius: 6px;margin-bottom: 10px;padding-bottom: 10px;">
            <div class="row " style="margin-left: 1px;">
                <a onclick="verification()">
                    <h4 class="h3" id="v_detail"
                        style="border-radius: 7px; border: 2px solid #ff6600; padding: 10px; font-weight: 600; font-size: 17px; color: #ff6600;">
                        Verification</h2>
                </a>
                <a onclick="showDetail()">
                    <h4 class="h3" id="h3_detail"
                        style="border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px;margin-left: 10px; color: black;">
                        Details</h2>
                </a>
                <a onclick="showMainAccount()">
                    <h4 class="h3" id="h3_main_account"
                        style="border-radius: 7px;border: 2px solid black;padding: 10px;font-weight: 600;font-size: 17px;margin-left: 10px  ">
                        Main contacts</h2>
                </a>
                <a onclick="showTradingName()">
                    <h4 class="h3" id="h3_trading_account"
                        style="border-radius: 7px;border: 2px solid black;padding: 10px;font-weight: 600;font-size: 17px;margin-left: 10px  ">
                        Trading names</h2>
                </a>
                <a onclick="showSites()">
                    <h4 class="h3" id="h3_sites"
                        style="border-radius: 7px;border: 2px solid black;padding: 10px;font-weight: 600;font-size: 17px;margin-left: 10px  ">
                        Sites</h2>
                </a>
                <a onclick="showBank()">
                    <h4 class="h3" id="h3_bank"
                        style="border-radius: 7px;border: 2px solid black;padding: 10px;font-weight: 600;font-size: 17px;margin-left: 10px  ">
                        Bank Accounts</h2>
                </a>

            </div>
            <div class="card default-collapse collapse-icon accordion-icon-rotate" id="verification_detail"
                style="box-shadow: none;">
                 <div class="section">

                <div class="section-header">VAT Verification</div>

                <div class="section-body">

                    @if ($user['profile']['vat_register'] == 'No')

                        <div class="item">

                            <a href="">UK VAT registered: No</a>

                            <span class="badge verified">Verified</span>

                            <div class="timestamp">Last updated {{ $user['profile']->updated_at->format('d M Y, H:i') }}

                            </div>

                        </div>

                    @else

                        <div class="item">

                            <a href="">UK VAT registered: Yes</a>

                            @php

                                $status = $user['profile']['vat_info'];



                                // Assign Bootstrap badge color classes based on status

                                switch ($status) {

                                    case 'Todo':

                                        $badgeClass = 'badge todo'; // gray

                                        break;

                                    case 'Pending':

                                        $badgeClass = 'badge pending'; // yellow

                                        break;

                                    case 'Verified':

                                        $badgeClass = 'badge verified'; // green

                                        break;

                                    case 'Rejected':

                                        $badgeClass = 'badge badge-danger'; // red

                                        break;

                                    default:

                                        $badgeClass = 'badge badge-light text-dark'; // default

                                        break;

                                }

                            @endphp

                            <span class="{{ $badgeClass }}" style="margin-top:10px">

                                {{ $status }}

                            </span>

                            <div class="timestamp">Last updated {{ $user['profile']->updated_at->format('d M Y, H:i') }}

                            </div>

                        </div>

                    @endif

                </div>

            </div>



            <div class="section">

                <div class="section-header">Main Contacts Verification</div>

                <div class="section-body">

                    <div class="item">

                        <a href="">{{ $user['name'] }} {{ $user['middle_name'] }} {{ $user['last_name'] }}</a>

                        @php

                            $status = $user['user_verified'];



                            // Assign Bootstrap badge color classes based on status

                            switch ($status) {

                                case 'Todo':

                                    $badgeClass = 'badge todo'; // gray

                                    break;

                                case 'Pending':

                                    $badgeClass = 'badge pending'; // yellow

                                    break;

                                case 'Verified':

                                    $badgeClass = 'badge verified'; // green

                                    break;

                                case 'Rejected':

                                    $badgeClass = 'badge badge-danger'; // red

                                    break;

                                default:

                                    $badgeClass = 'badge badge-light text-dark'; // default

                                    break;

                            }

                        @endphp

                        <span class="{{ $badgeClass }}" style="margin-top:10px">

                            {{ $status }}

                        </span>

                        <div class="timestamp">Last updated {{ $user->updated_at->format('d M Y, H:i') }}</div>

                    </div>

                    @foreach ($users as $main)

                        <div class="item">

                            <a href="">{{ $main['name'] }} {{ $main['middle_name'] }} {{ $main['last_name'] }}</a>

                            @php

                                $status = $main['user_verified'];



                                // Assign Bootstrap badge color classes based on status

                                switch ($status) {

                                    case 'Todo':

                                        $badgeClass = 'badge todo'; // gray

                                        break;

                                    case 'Pending':

                                        $badgeClass = 'badge pending'; // yellow

                                        break;

                                    case 'Verified':

                                        $badgeClass = 'badge verified'; // green

                                        break;

                                    case 'Rejected':

                                        $badgeClass = 'badge badge-danger'; // red

                                        break;

                                    default:

                                        $badgeClass = 'badge badge-light text-dark'; // default

                                        break;

                                }

                            @endphp

                            <span class="{{ $badgeClass }}" style="margin-top:10px">

                                {{ $status }}

                            </span>

                            <div class="timestamp">Last updated {{ $main->updated_at->format('d M Y, H:i') }}</div>

                        </div>

                    @endforeach



                </div>

            </div>



            <div class="section">

                <div class="section-header">Sites Verifications</div>

                <div class="section-body">

                    @foreach ($sites as $site)

                        <div class="item">

                            <a href="">{{ $site['address_line_1'] }} {{ $site['address_line_2'] }}</a>

                            @php

                                $status = $site['status'];



                                // Assign Bootstrap badge color classes based on status

                                switch ($status) {

                                    case 'Todo':

                                        $badgeClass = 'badge todo'; // gray

                                        break;

                                    case 'Pending':

                                        $badgeClass = 'badge pending'; // yellow

                                        break;

                                    case 'Verified':

                                        $badgeClass = 'badge verified'; // green

                                        break;

                                    case 'Rejected':

                                        $badgeClass = 'badge badge-danger'; // red

                                        break;

                                    default:

                                        $badgeClass = 'badge badge-light text-dark'; // default

                                        break;

                                }

                            @endphp

                            <span class="{{ $badgeClass }}" style="margin-top:10px">

                                {{ $status }}

                            </span>

                            <div class="timestamp">Last updated {{ $site->updated_at->format('d M Y, H:i') }}</div>

                        </div>

                    @endforeach

                </div>

            </div>



            <div class="section">

                <div class="section-header">Bank Accounts Verification</div>

                <div class="section-body">

                    @foreach ($banks as $bank)

                        <div class="item">

                            <a href="">{{ $bank['bank_name'] }} | {{ $bank['account_name'] }} |

                                {{ $bank['account_number'] }} </a>

                            @php

                                $status = $bank['status'];



                                // Assign Bootstrap badge color classes based on status

                                switch ($status) {

                                    case 'Todo':

                                        $badgeClass = 'badge todo'; // gray

                                        break;

                                    case 'Pending':

                                        $badgeClass = 'badge pending'; // yellow

                                        break;

                                    case 'Verified':

                                        $badgeClass = 'badge verified'; // green

                                        break;

                                    case 'Rejected':

                                        $badgeClass = 'badge badge-danger'; // red

                                        break;

                                    default:

                                        $badgeClass = 'badge badge-light text-dark'; // default

                                        break;

                                }

                            @endphp

                            <span class="{{ $badgeClass }}" style="margin-top:10px">

                                {{ $status }}

                            </span>

                            <div class="timestamp">Last updated {{ $bank->updated_at->format('d M Y, H:i') }}</div>

                        </div>

                    @endforeach

                </div>

            </div>

               




            </div>
            <div class="card default-collapse collapse-icon accordion-icon-rotate" style="display:none" id="show_detail"
                style="box-shadow: none;">

                <a id="headingCollapse14" class="card-header info collapsed"
                    style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;"
                    data-toggle="collapse" href="#collapse14" aria-expanded="false" aria-controls="collapse14">
                    <div class="card-title lead collapsed">Business information</div>

                </a>

                <div id="collapse14" role="tabpanel" aria-labelledby="headingCollapse14" class="collapse"
                    aria-expanded="false"
                    style="border-left: 2px solid black; margin-top: -4px; border-right: 2px solid black; border-bottom: 2px solid black; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px;">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0">ID</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    BSN{{ sprintf('%07d', $user['id']) }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0">Business setup</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ $user['profile']['organization_status'] }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0">Registered @if (
                                        $user['profile']['organization_status'] == 'Limited Liability Partnership (LLP)' ||
                                            $user['profile']['organization_status'] == 'Limited Company (Ltd)')
                                            company
                                        @endif name</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ $user['profile']['company_name'] }}
                                </div>
                            </div>
                            @if (
                                $user['profile']['organization_status'] == 'Limited Liability Partnership (LLP)' ||
                                    $user['profile']['organization_status'] == 'Limited Company (Ltd)')
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Registered @if (
                                            $user['profile']['organization_status'] == 'Limited Liability Partnership (LLP)' ||
                                                $user['profile']['organization_status'] == 'Limited Company (Ltd)')
                                                company
                                            @endif number</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $user['profile']['registration_no'] }}
                                    </div>
                                </div>
                            @endif
                            @if (
                                $user['profile']['organization_status'] == 'Limited Liability Partnership (LLP)' ||
                                    $user['profile']['organization_status'] == 'Limited Company (Ltd)')
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Registered @if (
                                            $user['profile']['organization_status'] == 'Limited Liability Partnership (LLP)' ||
                                                $user['profile']['organization_status'] == 'Limited Company (Ltd)')
                                                company
                                            @endif Jurisdiction</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $user['profile']['company_jurisdiction'] }}
                                    </div>
                                </div>
                            @endif
                            <hr>
                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0">Registered @if (
                                        $user['profile']['organization_status'] == 'Limited Liability Partnership (LLP)' ||
                                            $user['profile']['organization_status'] == 'Limited Company (Ltd)')
                                            company
                                        @endif address</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{-- @dd($user['profile']['address_line_1']) --}}
                                    {{ $user['profile']['address_line_1'] }}
                                    @if ($user['profile']['address_line_2'] != null)
                                        ,
                                    @endif {{ $user['profile']['address_line_2'] }} ,
                                    {{ $user['profile']['city'] }} , {{ $user['profile']['postcode'] }}
                                </div>
                            </div>

                            @if ($user['profile']['organization_status'] == 'Sole Trader / Self Employed')
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Companies House Proof</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $user['profile']['document_proof_name'] }} <a
                                            class="btn btn-primary btn-primary_2"
                                            style="border-color: #ff6600 !important; background-color: #ff6600 !important;float: right;"
                                            target="_blank"
                                            href="{{ URL::to($user['profile']['document_proof']) }}">View</a>
                                    </div>
                                </div>
                            @endif



                            @if (
                                $user['profile']['organization_status'] == 'General Partnership' ||
                                    $user['profile']['organization_status'] == 'Sole Trader / Self-Employed')
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Proof of business registration</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        @if ($user['profile']['document_proof_name'] != null)
                                            {{ $user['profile']['document_proof_name'] }}
                                            <a class="btn btn-primary btn-primary_2"
                                                style="border-color: #ff6600 !important; background-color: #ff6600 !important;float: right;"
                                                target="_blank"
                                                href="{{ URL::to($user['profile']['document_proof']) }}">View</a>
                                        @else
                                            <p style="color:red">Proof documentation upload required</p>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0"> Proof of trading activity</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        @if ($user['profile']['trading_activity'] != null)
                                            Trading Activity
                                            <a class="btn btn-primary btn-primary_2"
                                                style="border-color: #ff6600 !important; background-color: #ff6600 !important;float: right;"
                                                target="_blank"
                                                href="{{ URL::to($user['profile']['trading_activity']) }}">View</a>
                                        @else
                                            <p style="color:red">Proof documentation upload required</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if (
                                $user['profile']['organization_status'] == 'Limited Liability Partnership (LLP)' ||
                                    $user['profile']['organization_status'] == 'Limited Company (Ltd)')
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Proof of business registration</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        @if ($user['profile']['document_proof_name'] != null)
                                            {{ $user['profile']['document_proof_name'] }}
                                            <a class="btn btn-primary btn-primary_2"
                                                style="border-color: #ff6600 !important; background-color: #ff6600 !important;float: right;"
                                                target="_blank"
                                                href="{{ URL::to($user['profile']['document_proof']) }}">View</a>
                                        @else
                                            <p>Registered company number supplied. Proof not required.
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0"> Proof of trading activity</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        @if ($user['profile']['trading_activity'] != null)
                                            {{ $user['profile']['trading_activity'] }}
                                            <a class="btn btn-primary btn-primary_2"
                                                style="border-color: #ff6600 !important; background-color: #ff6600 !important;float: right;"
                                                target="_blank"
                                                href="{{ URL::to($user['profile']['trading_activity']) }}">View</a>
                                        @else
                                            <p style="color:red">Proof documentation upload required</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <hr>
                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0"> Verification Status</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    <p>{{ $user['profile']['business_info'] }}</p>

                                </div>
                            </div>



                        </div>
                        @if ($user['profile']['business_info'] == 'Pending')
                            <div class="card-footer">
                                <div class="text-secondary" style="text-align: right">
                                    <a href="{{ route('admin.register.detail.verify', $user['id']) }}"
                                        style=" background-color: black !important;
                                       border-color: black !important;"
                                        class="btn btn-primary"> Verified</a>
                                    <a href="{{ route('admin.register.detail.rejected', $user['id']) }}"
                                        style=" background-color: black !important;
                                       border-color: black !important;"
                                        class="btn btn-primary"> Rejected</a>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>

                <a id="headingCollapsevat" class="card-header info mt-2"
                    style="border: 2px solid black;
            border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;"
                    data-toggle="collapse" href="#collapsevats" aria-expanded="false" aria-controls="collapsevats">
                    <div class="card-title lead collapsed">VAT</div>
                </a>
                <div id="collapsevats" role="tabpanel" aria-labelledby="headingCollapsevats" class="collapse"
                    aria-expanded="false"
                    style="border-left: 2px solid black; margin-top: -4px; border-right: 2px solid black; border-bottom: 2px solid black; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px;">
                    <div class="card-content">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0">Is your business UK VAT registered</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ $user['profile']['vat_register'] }}
                                </div>
                            </div>

                            @if ($user['profile']['vat_register'] == 'YES')
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">UK VAT Number</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $user['profile']['uk_vat_no'] }}
                                    </div>
                                </div>
                            @endif
                            <hr>
                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0"> Verification Status</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    <p>{{ $user['profile']['vat_info'] }}</p>

                                </div>
                            </div>






                        </div>
                        @if ($user['profile']['vat_info'] == 'Pending')
                            <div class="card-footer">
                                <div class="text-secondary" style="text-align: right">
                                    <a href="{{ route('admin.register.detail.vat.verify', $user['id']) }}"
                                        style=" background-color: black !important;
                                       border-color: black !important;"
                                        class="btn btn-primary"> Verified</a>
                                    <a href="{{ route('admin.register.detail.vat.rejected', $user['id']) }}"
                                        style=" background-color: black !important;
                                       border-color: black !important;"
                                        class="btn btn-primary"> Rejected</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>




            </div>

            <div id="main_account"
                style="display: none;border: 2px solid black;border-radius: 6px;margin-bottom: 10px;padding-bottom: 10px;">
                <div class="row" style="margin-right: 0;margin-left: 0;">
                    <div class="col-md-12" style="border-bottom: 2px solid black;">
                        <h3 style="font-size: 20px; padding: 10px; margin-left: -11px; color: black;padding-bottom: 0px;">
                            Main contacts</h3>
                    </div>


                </div>

                <div class="row m-0 mt-2">
                    <div class="col-md-11">
                        <input type="text" class="form-control" id="myInputTextField"
                            style="border: 2px solid black; border-radius: 6px;" placeholder="Search" name=""
                            id="">
                    </div>
                    <div class="col-md-1" style="margin-top: 7px ">
                        <a href=""> <i class="ft-filter" style="font-size: 30px;color: black;"></i></a>
                    </div>
                </div>
                <div class="row mt-2 mb-4">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Status</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    {{-- @foreach ($users as $user)

                                 @endforeach --}}

                                    <tr>
                                        <td>1</td>
                                        <td>{{ $user['name'] }}</td>
                                        <td>{{ $user['middle_name'] }}</td>
                                        <td>{{ $user['last_name'] }} </td>
                                        <td>{{ $user['email'] }}</td>
                                        <td>{{ $user['profile']['phone_no'] }}</td>
                                        <td>{{ $user['user_verified'] }}</td>
                                        <td><a href="{{ route('admin.register.detail.main.contact', $user['id']) }}"><i
                                                    class="ft-eye"></i></a></td>
                                    </tr>

                                    @foreach ($users as $user)
                                        <tr>
                                            <td>1</td>
                                            <td>{{ $user['name'] }}</td>
                                            <td>{{ $user['middle_name'] }}</td>
                                            <td>{{ $user['last_name'] }} </td>
                                            <td>{{ $user['email'] }}</td>
                                            <td>{{ $user['profile']['phone_no'] }}</td>
                                            <td>{{ $user['user_verified'] }}</td>
                                            <td><a href="{{ route('admin.register.detail.main.contact', $user['id']) }}"><i
                                                        class="ft-eye"></i></a></td>
                                        </tr>
                                    @endforeach



                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="trading_name"
                style="display: none;border: 2px solid black;border-radius: 6px;margin-bottom: 10px;padding-bottom: 10px;">
                <div class="row" style="margin-right: 0;margin-left: 0;">
                    <div class="col-md-12" style="border-bottom: 2px solid black;">
                        <h3 style="font-size: 20px; padding: 10px; margin-left: -11px; color: black;padding-bottom: 0px;">
                            Trading Name</h3>
                    </div>


                </div>

                <div class="row m-0 mt-2">
                    <div class="col-md-11">
                        <input type="text" class="form-control" id="myInputTextField2"
                            style="border: 2px solid black; border-radius: 6px;" placeholder="Search" name=""
                            id="">
                    </div>
                    <div class="col-md-1" style="margin-top: 7px ">
                        <a href=""> <i class="ft-filter" style="font-size: 30px;color: black;"></i></a>
                    </div>
                </div>
                <div class="row mt-2 mb-4">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration-1">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Trading Name</th>



                                    </tr>
                                </thead>
                                <tbody>

                                    {{-- @dd($user['trading_names']) --}}
                                    {{-- @foreach ($users as $user)

                                 @endforeach --}}
                                    @foreach ($tarding_names as $name)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $name['name'] }}</td>


                                        </tr>
                                    @endforeach



                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Trading Name</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="sites"
                style="display: none;border: 2px solid black;border-radius: 6px;margin-bottom: 10px;padding-bottom: 10px;">
                <div class="row" style="margin-right: 0;margin-left: 0;">
                    <div class="col-md-12" style="border-bottom: 2px solid black;">
                        <h3 style="font-size: 20px; padding: 10px; margin-left: -11px; color: black;padding-bottom: 0px;">
                            Sites</h3>
                    </div>


                </div>

                <div class="row m-0 mt-2">
                    <div class="col-md-11">
                        <input type="text" class="form-control" id="myInputTextField3"
                            style="border: 2px solid black; border-radius: 6px;" placeholder="Search" name=""
                            id="">
                    </div>
                    <div class="col-md-1" style="margin-top: 7px ">
                        <a href=""> <i class="ft-filter" style="font-size: 30px;color: black;"></i></a>
                    </div>
                </div>
                <div class="row mt-2 mb-4">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration-2">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Address </th>
                                        <th>Proof</th>
                                        <th>Status</th>
                                        <th>Action</th>



                                    </tr>
                                </thead>
                                <tbody>

                                    {{-- @foreach ($users as $user)

                                    @endforeach --}}

                                    @foreach ($sites as $site)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $site['address_line_1'] }} {{ $site['address_line_2'] }}
                                                {{ $site['city'] }} {{ $site['postcode'] }}</td>
                                            <td><a href="{{ URL::to($site['proof']) }}"
                                                    target="_blank">{{ $site['proof_name'] }}</a></td>
                                            <td>
                                                {{ $site['status'] }}

                                            </td>
                                            <td><a href="{{ route('admin.register.detail.site', $site['id']) }}"><i
                                                        class="ft-eye"></i></a></td>


                                        </tr>
                                    @endforeach



                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Address </th>
                                        <th>Proof</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="banks"
                style="display: none;border: 2px solid black;border-radius: 6px;margin-bottom: 10px;padding-bottom: 10px;">
                <div class="row" style="margin-right: 0;margin-left: 0;">
                    <div class="col-md-12" style="border-bottom: 2px solid black;">
                        <h3 style="font-size: 20px; padding: 10px; margin-left: -11px; color: black;padding-bottom: 0px;">
                            Bank Accounts</h3>
                    </div>


                </div>

                <div class="row m-0 mt-2">
                    <div class="col-md-11">
                        <input type="text" class="form-control" id="myInputTextField3"
                            style="border: 2px solid black; border-radius: 6px;" placeholder="Search" name=""
                            id="">
                    </div>
                    <div class="col-md-1" style="margin-top: 7px ">
                        <a href=""> <i class="ft-filter" style="font-size: 30px;color: black;"></i></a>
                    </div>
                </div>
                <div class="row mt-2 mb-4">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration-2">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Label</th>
                                        <th>Bank Name</th>
                                        <th>Account Name</th>
                                        <th>Sort Code</th>
                                        <th>Account Number</th>
                                        <th>Status</th>
                                        <th>Action</th>



                                    </tr>
                                </thead>
                                <tbody>

                                    {{-- @foreach ($users as $user)

                                    @endforeach --}}

                                    @foreach ($banks as $bank)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $bank['label'] }}
                                            </td>
                                            <td>{{ $bank['bank_name'] }}
                                            </td>
                                            <td>{{ $bank['account_name'] }}
                                            </td>
                                            <td>{{ $bank['sort_code'] }}
                                            </td>
                                            <td>{{ $bank['account_number'] }}
                                            </td>

                                            <td> {{ $bank['status'] }}</td>
                                            <td>

                                                <a href="{{ route('admin.register.detail.bank', $bank['id']) }}"><i
                                                        class="ft-eye"></i></a>
                                            </td>

                                        </tr>
                                    @endforeach



                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Label</th>
                                        <th>Bank Name</th>
                                        <th>Account Name</th>
                                        <th>Sort Code</th>
                                        <th>Account Number</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>





        </div>
    </div>
@endsection


@section('script')
    <script src="/modules/admin/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    {{-- <script src="/modules/admin/app-assets/js/scripts/tables/datatables/datatable-basic.js"></script> --}}


    <script>
        oTable = $('.zero-configuration').DataTable({
            "bPaginate": $('.zero-configuration tbody tr').length > 10,
            "iDisplayLength": 10,
            "bAutoWidth": false,
            "ordering": false,

        }); //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
        $('#myInputTextField').keyup(function() {
            oTable.search($(this).val()).draw();
        })
    </script>
    <script>
        oTable = $('.zero-configuration-1').DataTable({
            "bPaginate": $('.zero-configuration-1 tbody tr').length > 10,
            "iDisplayLength": 10,
            "bAutoWidth": false,
            "ordering": false,

        }); //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
        $('#myInputTextField2').keyup(function() {
            oTable.search($(this).val()).draw();
        })
    </script>
    <script>
        oTable = $('.zero-configuration-2').DataTable({
            "bPaginate": $('.zero-configuration-2 tbody tr').length > 10,
            "iDisplayLength": 10,
            "bAutoWidth": false,
            "ordering": false,

        }); //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
        $('#myInputTextField3').keyup(function() {
            oTable.search($(this).val()).draw();
        })
    </script>

    <script>
        $(document).ready(function() {
            var contentHeight = $('#contens').height();
            $('#contens').height(contentHeight);
        });
    </script>

    <script>
        function verification() {

            $('#verification_detail').show();
             $('#v_detail').attr("style",
                "border-radius: 7px; border: 2px solid #ff6600; padding: 10px; font-weight: 600; font-size: 17px; color: #ff6600;margin-right: 10px"
            );
            $('#show_detail').hide();
            $('#h3_detail').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
            $('#h3_main_account').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
            $('#h3_trading_account').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
            $('#h3_sites').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
            $('#main_account').hide();
            $('#sites').hide();
            $('#trading_name').hide();
             $('#banks').hide();
            $('#h3_bank').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
        }
        function showDetail() {

            $('#show_detail').show();
            $('#h3_detail').attr("style",
                "border-radius: 7px; border: 2px solid #ff6600; padding: 10px; font-weight: 600; font-size: 17px; color: #ff6600;margin-left: 10px"
            );
            $('#h3_main_account').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
            $('#h3_trading_account').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
            $('#h3_sites').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
            $('#main_account').hide();
            $('#sites').hide();
            $('#trading_name').hide();
             $('#verification_detail').hide();
             $('#v_detail').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-right: 10px"
            );
             $('#banks').hide();
            $('#h3_bank').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
        }
    </script>
    <script>
        function showMainAccount() {

            $('#show_detail').hide();
            $('#main_account').show();
            $('#h3_main_account').attr("style",
                "border-radius: 7px; border: 2px solid #ff6600; padding: 10px; font-weight: 600; font-size: 17px; color: #ff6600;margin-left: 10px"
            );
            $('#h3_detail').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;"
            );
            $('#h3_trading_account').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
            $('#h3_sites').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
            $('#sites').hide();
            $('#trading_name').hide();
             $('#verification_detail').hide();
             $('#v_detail').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-right: 10px"
            );
        }
    </script>
    <script>
        function showTradingName() {

            $('#show_detail').hide();
            $('#main_account').hide();
            $('#sites').hide();
            $('#trading_name').show();
            $('#h3_trading_account').attr("style",
                "border-radius: 7px; border: 2px solid #ff6600; padding: 10px; font-weight: 600; font-size: 17px; color: #ff6600;margin-left: 10px"
            );
            $('#h3_detail').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;"
            );
            $('#h3_main_account').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
            $('#h3_sites').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
             $('#verification_detail').hide();
             $('#v_detail').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-right: 10px"
            );
        }
    </script>
    <script>
        function showSites() {


            $('#show_detail').hide();
            $('#main_account').hide();
            $('#sites').show();
            $('#trading_name').hide();
            $('#banks').hide();
            $('#h3_sites').attr("style",
                "border-radius: 7px; border: 2px solid #ff6600; padding: 10px; font-weight: 600; font-size: 17px; color: #ff6600;margin-left: 10px"
            );
            $('#h3_detail').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;"
            );
            $('#h3_main_account').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
            $('#h3_trading_account').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
            $('#h3_bank').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
             $('#verification_detail').hide();
             $('#v_detail').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-right: 10px"
            );
        }

        function showBank() {


            $('#show_detail').hide();
            $('#main_account').hide();
            $('#trading_name').hide();
            $('#sites').hide();
            $('#banks').show();
            $('#h3_bank').attr("style",
                "border-radius: 7px; border: 2px solid #ff6600; padding: 10px; font-weight: 600; font-size: 17px; color: #ff6600;margin-left: 10px"
            );
            $('#h3_detail').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;"
            );
            $('#h3_main_account').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
            $('#h3_trading_account').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
            $('#h3_sites').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
             $('#verification_detail').hide();
             $('#v_detail').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-right: 10px"
            );
        }
    </script>
@endsection

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
            white-space: nowrap;
        }

        table.dataTable {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            padding: 1px;
        }

        /* Hide sorting arrows */
        table.dataTable thead .sorting,
        table.dataTable thead .sorting_asc,
        table.dataTable thead .sorting_desc {
            background-image: none !important;
            cursor: default !important;
        }

        /* ========================================================================
                           2. ICONS & MENU STYLES
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

        /* Remove default Bootstrap padding from DataTables column wrappers */
        .dataTables_wrapper .row .col-sm-12 {
            padding-left: 0 !important;
            padding-right: 0 !important;
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

            .nav-buttons {
                flex-direction: column;
                align-items: stretch !important;
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
                        <li class="breadcrumb-item active">Contacts</li>
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
                    <div
                        style="font-weight: 600; font-size: 17px; padding: 12px 16px; border-bottom: 2px solid black; display: flex; align-items: flex-start;">
                        <img src="/trading_unit.png" style="width: 22px; margin-right: 10px; margin-top: 2px;">
                        <span style="word-break: break-word;"><span style="color:#ff6600">Trading
                                Unit:</span><br>{{ $trading_unit['name'] }}</span>
                    </div>

                    <div style="padding: 20px; flex-grow: 1;">
                        <div class="mb-2" style="font-weight: 500; font-size: 14px;">
                            <span style="color:#ff6600; font-weight: 600;">Trading Name:</span><br>
                            {{ $trading_unit['trading_name']['name'] ?? '' }}
                        </div>
                        <div class="mb-2"><span class="success">{{ $trading_unit['status'] }}</span></div>
                        <div class="mb-2"><span class="success">{{ $trading_unit['active_status'] }}</span></div>
                        <div style="font-weight: 500; font-size: 13px; color: #555;">
                            Created: {{ \Carbon\Carbon::parse($trading_unit['created_at'])->format('d/m/Y \a\t h:i') }}
                        </div>
                    </div>

                    {{-- Action Buttons Footer (Vertical Fix) --}}
                    <div class="footers"
                        style="flex-direction: column; gap: 12px; padding: 10px; border-radius: 0 0 5px 5px;">
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

                <div class="card default-collapse collapse-icon accordion-icon-rotate m-0" style="box-shadow: none;">

                    {{-- FIXED ACCORDION HEADER --}}
                    <div id="headingCollapse1" class="card-header info mt-0"
                        style="border: 2px solid black; border-radius: 7px 7px 0 0 !important; padding: 1.2rem 1rem; color: black !important; background: white; cursor: pointer;"
                        data-toggle="collapse" data-target="#collaptr_businesss_info" aria-expanded="true">
                        <div class="card-title lead m-0">Contact</div>
                    </div>

                    <div id="collaptr_businesss_info" class="collapse show"
                        style="border-left: 2px solid black; border-right: 2px solid black; border-bottom: 2px solid black; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px; background: white; margin-top: -2px;">

                        <div class="card-content">
                            <div class="card-body" style="padding: 20px 10px;">

                                {{-- Search Row --}}
                                <div class="row align-items-center mb-3 m-0">
                                    <div class="col-10 col-md-11 p-0 pr-2">
                                        <input type="text" class="form-control" id="myInputTextField"
                                            style="border: 2px solid black; border-radius: 6px; width: 100%; height: 40px;"
                                            placeholder="Search">
                                    </div>
                                    <div class="col-2 col-md-1 text-center p-0">
                                        <a href=""><i class="ft-filter"
                                                style="font-size: 26px; color: black; line-height: 1;"></i></a>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration w-90 m-0 p-0"
                                        width="90%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Middle Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Address</th>
                                                <th style="text-align: center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($contacts as $contact)
                                                <tr>
                                                    <td>{{ $contact->contact_no }}</td>
                                                    <td>{{ $contact['name'] }}</td>
                                                    <td>{{ $contact['middle_name'] }}</td>
                                                    <td>{{ $contact['last_name'] }}</td>
                                                    <td>{{ $contact['email'] }}</td>
                                                    <td>{{ $contact['mobile_no'] }}</td>
                                                    <td>{{ $contact['address'] }} {{ $contact['address_line2'] }}</td>
                                                    <td style="text-align: center;">
                                                        <a
                                                            href="{{ route('vender.service.provider.trading.unit.app.data.contact.detail', $contact['id']) }}">
                                                            <i class="ft-eye" style="color: #ff6600;"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
                    "order": [],
                    "columnDefs": [{
                        "targets": "_all",
                        "orderable": false
                    }]
                });
                $('#myInputTextField').on('keyup', function() {
                    oTable.search($(this).val()).draw();
                });

                setTimeout(function() {
                    oTable.columns.adjust().draw();
                }, 150);
            }
        });
    </script>
@endsection

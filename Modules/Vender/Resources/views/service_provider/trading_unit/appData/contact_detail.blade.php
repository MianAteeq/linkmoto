@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        /* ========================================================================
       1. TABLE & UI STYLES
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

        /* ========================================================================
       2. ICONS & ACCORDION
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
       3. CONTAINER & NAV STYLES
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
        }

        .round {
            border-radius: 0.5rem;
        }

        /* Tab Styling */
        .nav.nav-tabs .nav-item .nav-link {
            padding: 5px 16px !important;
            display: inline-flex;
            border: 2px solid black;
            border-radius: 7px;
            color: black;
            font-weight: 600;
        }

        .nav.nav-tabs .nav-item .nav-link.active {
            border: 2px solid #ff6600;
            color: #ff6600;
            background: transparent;
        }

        .nav.nav-tabs .nav-item {
            margin-right: 7px;
            margin-bottom: 7px;
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
                max-width: 100% !important;
            }

            .footers .btn-dark {
                float: none !important;
                width: 100% !important;
                display: block !important;
            }

            /* Fixed: Removed flex-direction column from tabs so they stay in rows/wrap */
            .nav-tabs {
                flex-direction: row !important;
                flex-wrap: wrap !important;
                width: 100% !important;
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
            {{-- Fixed: 2 Rows, flush left alignment --}}
            <div class="col-12 bg-white headerbg" style="padding: 15px 32px;">

                {{-- Row 1 --}}
                <h3 class="h3 mb-1" style="font-weight: 600; color: black;">Contact</h3>

                {{-- Row 2 --}}
                <div class="breadcrumb-wrapper p-0">
                    <ol class="breadcrumb m-0 p-0" style="background-color: transparent;">
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
                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.service.provider.trading.unit.app.data', $trading_unit['id']) }}">App
                                Data</a></li>
                        <li class="breadcrumb-item active">Contacts</li>
                        <li class="breadcrumb-item active">{{ $contact['contact_no'] }}</li>
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
                        style="font-weight: 600; font-size: 17px; padding: 10px; border-bottom: 2px solid black; display: flex; align-items: flex-start;">
                        <div style="width: 10%; margin-top: 5px;"><img src="/trading_unit.png" style="width: 22px;"></div>
                        <div style="width: 90%; padding-left: 5px;"><span>Trading Unit : {{ $trading_unit['name'] }}</span>
                        </div>
                    </div>

                    <div style="padding: 20px; flex-grow: 1;">
                        <div class="mb-2" style="font-weight: 500; font-size: 13px;">
                            <span>Trading Name : {{ $trading_unit['trading_name']['name'] ?? '' }}</span>
                        </div>
                        <div class="mb-1" style="font-weight: 600; font-size: 13px; color:#ff6600">
                            {{ $trading_unit['status'] }}</div>
                        <div class="mb-1" style="font-weight: 600; font-size: 13px; color:#ff6600">
                            {{ $trading_unit['active_status'] }}</div>
                        <div style="font-weight: 500; font-size: 13px; color: #555;">
                            <span>Created:
                                {{ \Carbon\Carbon::parse($trading_unit['created_at'])->format('d/m/Y \a\t h:i') }}</span>
                        </div>
                    </div>

                    {{-- Action Buttons Footer (Vertical Stack Fix) --}}
                    <div class="footers"
                        style="flex-direction: column; gap: 12px; padding: 10px; border-radius: 0 0 5px 5px;">
                        @if ($trading_unit['status'] == 'PENDING' || $trading_unit['status'] == 'INACTIVE')
                            <a href="{{ route('vender.service.provider.trading.unit.active', $trading_unit['id']) }}"
                                class="w-100"><button type="button" class="btn btn-dark round w-100 m-0">ACTIVATE TRADE
                                    UNIT</button></a>
                        @else
                            <a href="{{ route('vender.service.provider.trading.unit.in.active', $trading_unit['id']) }}"
                                class="w-100"><button type="button" class="btn btn-dark round w-100 m-0">INACTIVATE TRADE
                                    UNIT</button></a>
                        @endif

                        @if ($trading_unit['active_status'] == 'OFFLINE')
                            <a href="{{ route('vender.service.provider.trading.unit.Online', $trading_unit['id']) }}"
                                class="w-100"><button type="button" class="btn btn-dark round w-100 m-0">SHOW
                                    ONLINE</button></a>
                        @else
                            <a href="{{ route('vender.service.provider.trading.unit.offline', $trading_unit['id']) }}"
                                class="w-100"><button type="button" class="btn btn-dark round w-100 m-0">SHOW
                                    OFFLINE</button></a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right Content Container --}}
            <div class="col-12 col-lg-9 p-0" id="contens">

                {{-- Navigation Buttons --}}
                <div class="d-flex align-items-center mb-4 flex-wrap nav-buttons" style="gap: 15px;">
                    <a href="{{ route('vender.service.provider.trading.unit.view', $trading_unit['id']) }}"
                        style="text-decoration: none;">
                        <h4 class="h3 m-0"
                            style="border-radius: 7px; border: 2px solid black; padding: 10px 20px; font-weight: 600; font-size: 17px; color: black;">
                            Overview</h4>
                    </a>
                    <a href="{{ route('vender.service.provider.trading.unit.app.setting', $trading_unit['id']) }}"
                        style="text-decoration: none;">
                        <h4 class="h3 m-0"
                            style="border-radius: 7px; border: 2px solid black; padding: 10px 20px; font-weight: 600; font-size: 17px; color: black;">
                            App settings</h4>
                    </a>
                    <h4 class="h3 m-0"
                        style="border-radius: 7px; border: 2px solid #ff6600; padding: 10px 20px; font-weight: 600; font-size: 17px; color: #ff6600;">
                        App data</h4>
                </div>

                <div class="card default-collapse collapse-icon accordion-icon-rotate m-0" style="box-shadow: none;">

                    {{-- Accordion Header --}}
                    <div id="headingCollapse1" class="card-header info mt-0"
                        style="border: 2px solid black; border-radius: 7px 7px 0 0 !important; padding: 1.2rem 1rem; color: black !important; background: white; cursor: pointer;"
                        data-toggle="collapse" data-target="#collaptr_businesss_info" aria-expanded="true">
                        <div class="card-title lead m-0">Contact</div>
                    </div>

                    <div id="collaptr_businesss_info" class="collapse show"
                        style="border-left: 2px solid black; border-right: 2px solid black; border-bottom: 2px solid black; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px; background: white; margin-top: -2px;">

                        <div class="card-content">
                            {{-- Tabs (Aligned in rows/wrapping) --}}
                            <ul class="nav nav-tabs border-0 m-2" style="gap: 10px;">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                        href="#detail">Details</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#contact">Linked
                                        Vehicles</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#quote">Quote</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#booking">Booking</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#jobs">Jobs</a></li>
                            </ul>

                            <div class="tab-content px-2 pb-2">
                                {{-- Details Tab --}}
                                <div role="tabpanel" class="tab-pane active" id="detail">
                                    <div class="card-body p-1">
                                        @php
                                            $detailsMap = [
                                                'Contact No' => $contact['contact_no'],
                                                'First Name' => $contact['name'],
                                                'Middle Name' => $contact['middle_name'],
                                                'Last Name' => $contact['last_name'],
                                                'Company Name' => $contact['company'],
                                                'Mobile' => $contact['mobile_no'],
                                                'Landline' => $contact['landline_no'],
                                                'Email' => $contact['email'],
                                                'Hub link id' => $contact['hub_id'],
                                                'Address line one' => $contact['address'],
                                                'Address line Two' => $contact['address_line2'],
                                                'Address line Three' => $contact['address_line3'],
                                                'Address line Four' => $contact['address_line4'],
                                                'City' => $contact['city'],
                                                'Postcode' => $contact['postal_code'],
                                            ];
                                        @endphp

                                        @foreach ($detailsMap as $label => $val)
                                            <div class="row py-2 align-items-center">
                                                <div class="col-5"><strong>{{ $label }}</strong></div>
                                                <div class="col-7 text-secondary">{{ $val ?? 'N/A' }}</div>
                                            </div>
                                            @if (!$loop->last)
                                                <hr class="m-0">
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Vehicles Tab --}}
                                <div class="tab-pane" id="contact">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered zero-configuration w-100"
                                            width="100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Vehicle No</th>
                                                    <th>VRM</th>
                                                    <th>Vin</th>
                                                    <th>Make & Model</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($contact['vehicles'] as $vehicle)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $vehicle['vehicle_no'] }}</td>
                                                        <td>{{ $vehicle['vrm'] }}</td>
                                                        <td>{{ $vehicle['vin_number'] }}</td>
                                                        <td>{{ $vehicle['vehicle_make']['name'] }}
                                                            {{ $vehicle['vehicle_model']['name'] }}</td>
                                                        <td class="text-center"><a href=""><i class="ft-eye"
                                                                    style="color: #ff6600;"></i></a></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- Quote Tab --}}
                                <div class="tab-pane" id="quote">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered zero-configuration w-100"
                                            width="100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Quotation No</th>
                                                    <th>Vehicle</th>
                                                    <th>Service Type</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($contact['quotes'] as $quote)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $quote['quotation_no'] }}</td>
                                                        <td>{{ $quote['vehicle']['vrm'] }}</td>
                                                        <td>{{ $quote['service_type'] }}</td>
                                                        <td>{{ $quote['status'] }}</td>
                                                        <td class="text-center"><a href=""><i class="ft-eye"
                                                                    style="color: #ff6600;"></i></a></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- Booking Tab --}}
                                <div class="tab-pane" id="booking">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered zero-configuration w-100"
                                            width="100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Booking No</th>
                                                    <th>Vehicle</th>
                                                    <th>Service Type</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($contact['bookings'] as $booking)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $booking['booking_no'] }}</td>
                                                        <td>{{ $booking['vehicle']['vrm'] }}</td>
                                                        <td>{{ $booking['service_type'] }}</td>
                                                        <td>{{ $booking['status'] }}</td>
                                                        <td class="text-center"><a href=""><i class="ft-eye"
                                                                    style="color: #ff6600;"></i></a></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- Jobs Tab --}}
                                <div class="tab-pane" id="jobs">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered zero-configuration w-100"
                                            width="100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Job No</th>
                                                    <th>Vehicle</th>
                                                    <th>Service Type</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($contact['jobs'] as $job)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $job['job_no'] }}</td>
                                                        <td>{{ $job['vehicle']['vrm'] }}</td>
                                                        <td>{{ $job['service_type'] }}</td>
                                                        <td>{{ $job['status'] == 'ARRIVED' ? 'IN QUEUE' : $job['status'] }}
                                                        </td>
                                                        <td class="text-center"><a href=""><i class="ft-eye"
                                                                    style="color: #ff6600;"></i></a></td>
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
    </div>
@endsection

@section('script')
    <script src="/modules/admin/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            // Retrieve: true fixes the reinitialisation warning for multiple tabs
            var tables = $('.zero-configuration').DataTable({
                "retrieve": true,
                "bPaginate": true,
                "iDisplayLength": 10,
                "bAutoWidth": false,
                "ordering": false,
                "order": [],
                "width": "100%",
                "columnDefs": [{
                    "targets": "_all",
                    "orderable": false
                }]
            });

            $('#myInputTextField').on('keyup', function() {
                $('.zero-configuration').DataTable().search($(this).val()).draw();
            });

            // Adjust table column alignment when switching tabs
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
        });
    </script>
@endsection

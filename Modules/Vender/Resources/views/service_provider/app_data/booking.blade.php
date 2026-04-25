@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        /* --- DATATABLES UI HIDING --- */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info {
            display: none;
        }

        /* --- CRITICAL DATATABLES WIDTH FIXES --- */
        .table-responsive {
            display: block;
            width: 98% !important;
            /* Pulls edges in slightly to match search bar */
            margin: 0 auto !important;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .dataTables_wrapper {
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            display: block !important;
        }

        .dataTables_wrapper .row {
            width: 100% !important;
            margin: 0 !important;
        }

        .dataTables_wrapper .col-sm-12 {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            padding: 0 !important;
        }

        table.dataTable,
        table.table {
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
            display: table !important;
            clear: both;
            border-collapse: collapse;
            margin: 0 !important;
        }

        table.dataTable thead {
            background: #fafbfc;
            color: black;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: white;
        }

        table.dataTable tbody td {
            padding: 8px 10px 2px 10px;
            font-size: 10px;
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

        /* --- SIDEBAR SCROLLBAR FIXES --- */
        .main-menu {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
            overflow-x: hidden !important;
        }

        .main-menu::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari and Opera */
        }

        .main-menu-content {
            overflow-x: hidden !important;
        }

        /* --- GENERAL STYLES --- */
        .btn-dark {
            border-color: black !important;
            background-color: black !important;
            color: #FFFFFF;
        }

        .round {
            border-radius: 0.5rem;
        }

        /* --- RESPONSIVE ENHANCEMENTS --- */
        @media (max-width: 991px) {
            .form-control {
                width: 100% !important;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494; margin: 0;">

            <div class="col-12 bg-white headerbg" style="padding-left: 14px; padding-top: 13px;">

                <h3 class="h3">Booking</h3>

                <div class="breadcrumb-wrapper p-0">
                    <ol class="breadcrumb" style="padding-left: 0; background-color: transparent; margin-bottom: 10px;">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)" style="text-decoration: none; color: black;">Products</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a style="text-decoration: none; color: black;"
                                href="{{ route('vender.service.provider.trading.unit') }}">Service Provider</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a style="text-decoration: none; color: black;"
                                href="{{ route('vender.service.provider.app.data') }}">App data</a>
                        </li>
                        <li class="breadcrumb-item active">Booking</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-12 mb-3">
            <div style="border-radius: 7px;border: 2px solid black;">
                <h4 class="h3 d-flex align-items-center"
                    style="font-weight: 600; font-size: 17px;padding: 10px; margin: 0;">
                    <img src="/service_provider.png" style="width: 22px; margin-right: 8px;">Service Provider
                </h4>
            </div>
        </div>

        <div class="col-lg-9 col-md-12" style="border: 2px solid black;border-radius: 6px;margin-bottom: 10px;padding: 0;">

            <div class="row m-0">
                <div class="col-12 p-0" style="border-bottom: 2px solid black;">
                    <h3 style="font-size: 20px; padding: 10px 15px; color: black; margin: 0;">Booking</h3>
                </div>
            </div>

            <div class="d-flex align-items-center mb-3 mt-3 px-3">
                <div class="flex-grow-1 pr-2">
                    <input type="text" class="form-control w-100" id="myInputTextField"
                        style="border: 2px solid black; border-radius: 6px;" placeholder="Search" name=""
                        id="">
                </div>
                <div>
                    <a href=""> <i class="ft-filter" style="font-size: 30px;color: black;"></i></a>
                </div>
            </div>

            <div class="row m-0 mt-1 mb-4">
                <div class="col-12 p-0">
                    <div class="table-responsive" style="width: 98% !important; margin: 0 auto;">
                        <table class="table table-striped table-bordered zero-configuration w-100"
                            style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Booking No</th>
                                    <th>Vehicle</th>
                                    <th>Contact</th>
                                    <th>Service Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $contact)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $contact['booking_no'] }}</td>
                                        <td>
                                            {{ $contact['vehicle']['vehicle_no'] }} <br>
                                            {{ $contact['vehicle']['vrm'] }} <br>
                                            {{ $contact['vehicle']['vehicle_make']['name'] }}
                                            {{ $contact['vehicle']['vehicle_model']['name'] }}
                                        </td>
                                        <td>
                                            {{ $contact['contact_detail']['contact_no'] }} <br>
                                            {{ $contact['contact_detail']['name'] }}
                                            {{ $contact['contact_detail']['last_name'] }} <br>
                                            {{ $contact['contact_detail']['mobile_no'] }}
                                        </td>
                                        <td>{{ $contact['service_type'] }}</td>
                                        <td>{{ $contact['status'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Booking No</th>
                                    <th>Vehicle</th>
                                    <th>Contact</th>
                                    <th>Service Type</th>
                                    <th>Status</th>
                                </tr>
                            </tfoot>
                        </table>
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
            // Force sidebar to open automatically on page load to fix mobile collapse issue
            $('body').removeClass('menu-hide menu-collapsed').addClass('menu-expanded menu-open');

            // Trigger a slight delay window resize to snap layouts
            setTimeout(function() {
                $(window).trigger('resize');
            }, 200);

            // Initialize DataTables
            if ($('.zero-configuration').length > 0) {
                var oTable = $('.zero-configuration').DataTable({
                    "destroy": true, // <--- THIS LINE IS CRITICAL TO FIX THE ERROR
                    "bPaginate": $('.zero-configuration tbody tr').length > 10,
                    "iDisplayLength": 10,
                    "bAutoWidth": false,
                    "ordering": false,
                    "initComplete": function(settings, json) {
                        // Forcibly apply 100% width to all injected elements via JS
                        $('.dataTables_wrapper, .dataTables_wrapper .row, .dataTables_wrapper .col-sm-12, .dataTable')
                            .css('width', '100%', 'important');
                    }
                });

                $('#myInputTextField').keyup(function() {
                    oTable.search($(this).val()).draw();
                });
            }
        });
    </script>
@endsection

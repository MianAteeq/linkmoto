@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info {
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
            bottom: 0;
            left: 0;
            border-top: 2px solid black;
            padding-top: 10px;
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

        /* --- NEW RESPONSIVE ENHANCEMENTS --- */

        /* 1. Prevent inline style from freezing container height */
        #contens {
            height: auto !important;
            min-height: 460px;
        }

        /* 2. Ensure table data doesn't wrap into vertical columns */
        .table-responsive table th,
        .table-responsive table td {
            white-space: nowrap !important;
        }

        /* 3. Tablet & Mobile Specific Enhancements (Covers up to 991px) */
        @media (max-width: 991px) {

            /* Sidebar spacing */
            .col-lg-3 {
                margin-bottom: 25px;
            }

            /* Stack top navigation links cleanly */
            .nav-buttons {
                display: flex;
                flex-direction: column;
                margin-left: 0 !important;
                margin-right: 0 !important;
                width: 100%;
            }

            .nav-buttons a,
            .nav-buttons>h4 {
                width: 100%;
                margin-bottom: 10px;
                margin-right: 0 !important;
            }

            .nav-buttons a h4,
            .nav-buttons>h4 {
                margin-left: 0 !important;
                margin-right: 0 !important;
                text-align: center;
            }

            /* Fix search bar and filter icon alignment */
            .search-row {
                display: flex;
                flex-wrap: nowrap;
                align-items: center;
            }

            .search-row .col-md-11 {
                flex: 1;
                padding-right: 10px;
            }

            .search-row .col-md-1 {
                width: auto;
                margin-top: 0 !important;
                padding-left: 0;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3">Subscriptions</h3>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Billing</a></li>
                        <li class="breadcrumb-item">Subscriptions</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">

        <div class="col-lg-3 col-12 mb-3">
            <div style="border-radius: 7px;border: 2px solid black;">
                <h4 class="h3 d-flex align-items-center"
                    style="font-weight: 600; font-size: 17px; padding: 10px; margin: 0;">
                    <img src="/wallet.png" style="width: 22px; margin-right: 8px;"> Billing
                </h4>
            </div>
        </div>

        <div class="col-lg-9 col-12" id="contens" style="margin-bottom: 10px; padding-left: 0; padding-right: 0;">

            <div class="row d-flex align-items-center mb-2 flex-wrap nav-buttons" style="margin-left: 0;">
                <a href="{{ route('vender.subscription.index') }}">
                    <h4 class="h3 mb-0"
                        style="border-radius: 7px; border: 2px solid #ff6600; padding: 10px; font-weight: 600; font-size: 17px; color: #ff6600; margin-right: 15px;">
                        Subscriptions
                    </h4>
                </a>
                <a href="{{ route('vender.invoice.index') }}">
                    <h4 class="h3 mb-0"
                        style="border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black; margin-right: 15px;">
                        Invoices
                    </h4>
                </a>
            </div>

            <div style="border: 2px solid black;border-radius: 6px;">
                <div class="row" style="margin-right: 0;margin-left: 0;">
                    <div class="col-md-12" style="border-bottom: 2px solid black;">
                        <h3 style="font-size: 20px; padding: 10px; margin-left: -11px; color: black;padding-bottom: 0px;">
                            Subscriptions
                        </h3>
                    </div>
                </div>

                <div class="row m-0 mt-2 search-row d-flex align-items-center">
                    <div class="col-md-11 col-10">
                        <input type="text" class="form-control" id="myInputTextField"
                            style="border: 2px solid black; border-radius: 6px;" placeholder="Search" name=""
                            id="">
                    </div>
                    <div class="col-md-1 col-2 text-center">
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
                                        <th>Product</th>
                                        <th>Plan </th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscriptions as $account)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>Service Provider App</td>
                                            <td>{{ $account['plan']['name'] ?? '' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($account['start_at'])->format('d/m/Y') }} </td>
                                            <td>{{ \Carbon\Carbon::parse($account['end_at'])->format('d/m/Y') }} </td>
                                            <td>Active</td>
                                            <td><a href="{{ route('vender.subscription.detail', $account['id']) }}"><i
                                                        class="ft-eye"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Plan </th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
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

    <script>
        oTable = $('.zero-configuration').DataTable({
            "bPaginate": $('.zero-configuration tbody tr').length > 10,
            "iDisplayLength": 10,
            "bAutoWidth": false,
            "ordering": false,
        });

        $('#myInputTextField').keyup(function() {
            oTable.search($(this).val()).draw();
        });
    </script>
@endsection

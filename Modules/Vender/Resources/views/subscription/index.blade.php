@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        /* --- Table & UI cleanup --- */
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
            font-size: 10px;
            color: black;
        }

        table.dataTable thead th {
            padding: 10px 18px;
            border-bottom: 1px solid #111;
            font-size: 11px;
        }

        .btn-dark {
            border-color: black !important;
            background-color: black !important;
            color: #FFFFFF;
        }

        .round {
            border-radius: 0.5rem;
        }

        /* --- Alignment Styles --- */
        .sidebar-box {
            border-radius: 7px;
            border: 2px solid black;
            padding: 10px;
            height: 100%;
            background: white;
        }

        #contens {
            height: auto !important;
            /* Prevents height freezing */
            margin-bottom: 10px;
        }

        /* Fixed alignment for the header buttons */
        .nav-link-box {
            border-radius: 7px;
            padding: 10px;
            font-weight: 600;
            font-size: 17px;
            display: block;
            text-align: center;
            margin-bottom: 10px;
        }

        /* --- RESPONSIVE MEDIA QUERIES --- */
        @media (min-width: 769px) {
            .nav-buttons-row {
                display: flex;
                margin-left: 0;
                margin-bottom: 15px;
            }

            .nav-link-box {
                margin-right: 15px;
                min-width: 160px;
            }
        }

        @media (max-width: 768px) {
            .headerbg {
                padding-left: 15px !important;
            }

            /* Stack Sidebar & Content */
            .col-lg-3,
            .col-lg-9 {
                width: 100% !important;
                padding-left: 15px !important;
                padding-right: 15px !important;
            }

            /* Adjust Nav Buttons (Subscriptions/Invoices) for Tablet */
            .nav-buttons-row {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            .nav-link-box {
                width: 100%;
                margin-right: 0 !important;
            }

            /* Adjust search row for narrow screens */
            .search-row {
                flex-direction: row !important;
                display: flex;
                align-items: center;
            }

            #myInputTextField {
                margin-bottom: 0;
            }

            .table-responsive {
                border: none;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px; padding-top: 13px;">
                <h3 class="h3">Subscriptions</h3>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb p-0 m-0 pb-2 bg-transparent">
                        <li class="breadcrumb-item"><a>Billing</a></li>
                        <li class="breadcrumb-item">Subscriptions</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-3 col-12 mb-2">
            <div class="sidebar-box">
                <h4 class="h3 d-flex align-items-center" style="font-weight: 600; font-size: 17px; margin: 0;">
                    <img src="/wallet.png" style="width: 22px; margin-right: 8px;"> Billing
                </h4>
            </div>
        </div>

        <div class="col-lg-9 col-12" id="contens">

            <div class="row nav-buttons-row">
                <div class="col-md-auto col-12">
                    <a href="{{ route('vender.subscription.index') }}" style="text-decoration: none;">
                        <span class="nav-link-box" style="border: 2px solid #ff6600; color: #ff6600;">Subscriptions</span>
                    </a>
                </div>
                <div class="col-md-auto col-12">
                    <a href="{{ route('vender.invoice.index') }}" style="text-decoration: none;">
                        <span class="nav-link-box" style="border: 2px solid black; color: black;">Invoices</span>
                    </a>
                </div>
            </div>

            <div style="border: 2px solid black; border-radius: 6px; background: white;">
                <div style="border-bottom: 2px solid black; padding: 10px;">
                    <h3 style="font-size: 20px; color: black; margin: 0;">Subscriptions</h3>
                </div>

                <div class="row m-0 mt-2 p-1 search-row">
                    <div class="col-10">
                        <input type="text" class="form-control" id="myInputTextField"
                            style="border: 2px solid black; border-radius: 6px;" placeholder="Search">
                    </div>
                    <div class="col-2 text-center">
                        <a href="#"><i class="ft-filter" style="font-size: 28px; color: black;"></i></a>
                    </div>
                </div>

                <div class="p-1">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product</th>
                                    <th>Plan</th>
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
                                        <td>{{ \Carbon\Carbon::parse($account['start_at'])->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($account['end_at'])->format('d/m/Y') }}</td>
                                        <td><span class="text-success">Active</span></td>
                                        <td>
                                            <a href="{{ route('vender.subscription.detail', $account['id']) }}">
                                                <i class="ft-eye" style="color: black;"></i>
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
@endsection

@section('script')
    <script src="/modules/admin/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            var oTable = $('.zero-configuration').DataTable({
                "bPaginate": $('.zero-configuration tbody tr').length > 10,
                "iDisplayLength": 10,
                "bAutoWidth": false,
                "ordering": false,
            });

            $('#myInputTextField').keyup(function() {
                oTable.search($(this).val()).draw();
            });
        });
    </script>
@endsection

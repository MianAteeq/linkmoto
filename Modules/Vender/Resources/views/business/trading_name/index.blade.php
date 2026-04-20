@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">

    <style>
        /* Table Resets */
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

        /* Icons & Structural */
        .collapsed {
            border-bottom-left-radius: 0px !important;
            border-bottom-right-radius: 0px !important;
        }

        .footers {
            border-top: 2px solid black;
            padding: 12px 20px;
            width: 100%;
            background: white;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;
            margin-top: auto;
        }

        .btn-dark {
            border-color: black !important;
            background-color: black !important;
            color: #FFFFFF;
        }

        .round {
            border-radius: 0.5rem;
        }

        /* Custom Containers */
        .info-sidebar {
            border-radius: 7px;
            border: 2px solid black;
            height: auto;
            background-color: #fcfdfe;
            box-shadow: 4px 4px 0px rgba(0, 0, 0, 0.04);
        }

        .main-content-box {
            border: 2px solid black;
            border-radius: 6px;
            margin-bottom: 10px;
            padding: 0;
            display: flex;
            flex-direction: column;
            background-color: white;
        }

        .main-content-inner {
            flex-grow: 1;
            padding-bottom: 0;
        }

        /* Search row alignment */
        .search-filter-row {
            display: flex;
            align-items: center;
            padding: 12px 20px 0 20px;
            gap: 10px;
        }

        .search-filter-row input {
            flex: 1;
            border: 2px solid black;
            border-radius: 6px;
        }

        .search-filter-row .filter-icon {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
        }

        .dataTables_paginate {
            display: none;
        }

        /* --- RESPONSIVE MEDIA QUERIES --- */
        @media (max-width: 767.98px) {
            .headerbg {
                padding-left: 25px !important;
            }

            .info-sidebar-wrapper {
                margin-bottom: 20px;
            }

            .footers .btn-dark {
                float: none !important;
                width: 100%;
                display: block;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494; margin: 0;">
            <div class="col-12 bg-white headerbg" style="padding-left: 32px; padding-top: 13px;">
                <h3 class="h3">Trading names</h3>
                <div class="breadcrumb-wrapper col-12 p-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Business</a></li>
                        <li class="breadcrumb-item">Trading names</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-4 col-lg-3 info-sidebar-wrapper">
            <div class="info-sidebar">
                <h4
                    style="font-weight: 600; font-size: 1.1rem; padding: 12px 16px; margin: 0; display: flex; align-items: center; gap: 10px; background-color: white; border-radius: 5px 5px 0 0;">
                    <img src="/home.png" style="width: 20px;"> Trading Names
                </h4>
                <div style="border-top: 2px solid black; padding: 14px 16px;">
                    <p style="line-height: 1.6; color: #333; font-size: 0.9rem; margin: 0;">
                        Add and manage the different names your business operates under. These names can be linked to
                        invoices, trade units, and marketplace listings. Your registered business name is included
                        automatically, but you can add other trading names as needed.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-8 col-lg-9">
            <div class="main-content-box" id="contens">

                <div class="main-content-inner">
                    {{-- Title row --}}
                    <div style="border-bottom: 2px solid black; padding: 12px 20px;">
                        <h3 style="font-size: 20px; color: black; margin: 0;">
                            Trading names
                        </h3>
                    </div>

                    {{-- Search + Filter row --}}
                    <div class="search-filter-row">
                        <input type="text" class="form-control" id="myInputTextField" placeholder="Search">
                        <div class="filter-icon">
                            <a href="">
                                <i class="ft-filter" style="font-size: 26px; color: black; line-height: 1;"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div style="padding: 12px 20px 16px 20px;">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration w-100 m-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Trading Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($trading_names as $trading_name)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>
                                                {{ $trading_name['name'] }}
                                                @if ($trading_name['is_change'] == 1)
                                                    <span style="background-color: #ff6600;"
                                                        class="badge badge-primary">Registered</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('vender.trading.name.view', $trading_name['id']) }}">
                                                    <i class="ft-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Trading Name</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="footers">
                    <a href="{{ route('vender.trading.name.add') }}">
                        <button type="button" class="btn btn-dark round btn-min-width float-right m-0">Add</button>
                    </a>
                    <div class="clearfix"></div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/modules/admin/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>

    <script>
        $(document).ready(function() {

            // Destroy existing instance if already initialized
            if ($.fn.dataTable.isDataTable('.zero-configuration')) {
                $('.zero-configuration').DataTable().destroy();
            }

            var oTable = $('.zero-configuration').DataTable({
                "paging": false,
                "bAutoWidth": false,
                "ordering": false,
                "columnDefs": [{
                    "orderable": false,
                    "targets": "_all"
                }]
            });

            $('#myInputTextField').keyup(function() {
                oTable.search($(this).val()).draw();
            });

        });
    </script>
@endsection

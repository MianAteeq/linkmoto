@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">

    <style>
        /* ========================================================================
               1. MASTER LAYOUT & CONTAINER FOUNDATIONS
               ======================================================================== */
        .content-wrapper {
            height: auto !important;
            min-height: 84vh !important;
        }

        .info-sidebar {
            border-radius: 7px;
            border: 2px solid black;
            height: auto;
            background-color: #fcfdfe;
            box-shadow: 4px 4px 0px rgba(0, 0, 0, 0.04);
            width: 100%;
        }

        .main-content-box {
            border: 2px solid black;
            border-radius: 6px;
            margin-bottom: 10px;
            padding: 0;
            display: flex;
            flex-direction: column;
            background-color: white;
            width: 100% !important;
            overflow: hidden;
            /* Prevents child elements from bleeding out */
        }

        .main-content-inner {
            flex-grow: 1;
            padding-bottom: 0;
            width: 100%;
        }

        /* ========================================================================
               2. SEARCH & FILTER ROW
               ======================================================================== */
        .search-filter-row {
            display: flex;
            align-items: center;
            padding: 12px 20px 0 20px;
            gap: 10px;
            width: 100%;
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

        /* ========================================================================
               3. THE "NUCLEAR" DATATABLES STRETCH FIX
               ======================================================================== */
        /* Hide DataTables default controls */
        .dataTables_length,
        .dataTables_filter,
        .dataTables_info,
        .dataTables_paginate {
            display: none !important;
        }

        /* Force user wrapper to 100% */
        .table-responsive {
            width: 100% !important;
            display: block !important;
            overflow-x: auto !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Force DataTables injected wrapper to 100% */
        .dataTables_wrapper {
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            display: block !important;
        }

        /* Force DataTables injected row to 100% flex */
        .dataTables_wrapper .row {
            width: 100% !important;
            margin: 0 !important;
            display: flex !important;
            flex-wrap: wrap !important;
        }

        /* Target ANY column DataTables injects (.col-sm-12, .col-md-12, etc) and force 100% */
        .dataTables_wrapper [class*="col-"] {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            padding: 0 !important;
        }

        /* Force the actual table element to 100% */
        table.dataTable,
        table.dataTable.w-100 {
            width: 100% !important;
            min-width: 100% !important;
            /* Critical to prevent shrink-wrapping */
            max-width: 100% !important;
            margin: 0 !important;
            table-layout: fixed !important;
            /* Strictly enforces our percentages below */
            border-collapse: collapse !important;
        }

        /* ========================================================================
               4. TABLE STYLING & EXACT COLUMN PERCENTAGES
               ======================================================================== */
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
            padding-right: 1px;
        }

        /* Hardcoded widths to ensure flawless scaling */
        table.dataTable th:nth-child(1),
        table.dataTable td:nth-child(1) {
            width: 15% !important;
        }

        table.dataTable th:nth-child(2),
        table.dataTable td:nth-child(2) {
            width: 65% !important;
            word-wrap: break-word !important;
            white-space: normal !important;
        }

        table.dataTable th:nth-child(3),
        table.dataTable td:nth-child(3) {
            width: 20% !important;
            text-align: center !important;
        }

        /* ========================================================================
               5. UI ELEMENTS (FOOTERS & BUTTONS)
               ======================================================================== */
        .footers {
            border-top: 2px solid black;
            padding: 12px 20px;
            width: 100%;
            background: white;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;
            margin-top: auto;
            /* Glues footer to bottom */
        }

        .btn-dark {
            border-color: black !important;
            background-color: black !important;
            color: #FFFFFF !important;
        }

        .round {
            border-radius: 0.5rem;
        }

        /* ========================================================================
               6. RESPONSIVE MEDIA QUERIES
               ======================================================================== */
        @media (max-width: 1024px) {
            .search-filter-row {
                flex-wrap: wrap;
            }

            .search-filter-row input {
                flex: 0 0 85%;
                max-width: 85%;
            }

            .search-filter-row .filter-icon {
                flex: 0 0 10%;
                max-width: 10%;
            }
        }

        @media (max-width: 991.98px) {
            .headerbg {
                padding-left: 25px !important;
            }

            .info-sidebar-wrapper {
                margin-bottom: 20px;
            }

            .footers .btn-dark {
                float: none !important;
                width: 100% !important;
                display: block !important;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494; margin: 0;">
            <div class="col-12 bg-white headerbg" style="padding-left: 32px; padding-top: 13px;">
                <h3 class="h3">Trading names</h3>

                <div class="breadcrumb-wrapper p-0">
                    <ol class="breadcrumb" style="padding-left: 0; background-color: transparent; margin-bottom: 10px;">
                        <li class="breadcrumb-item"><a>Business</a></li>
                        <li class="breadcrumb-item">Trading names</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid px-1 px-md-1 mt-1">
        <div class="row align-items-start" style="padding-left: 0 !important;">

            <div class="col-12 col-md-12 col-lg-3 info-sidebar-wrapper d-flex mb-3 mb-lg-0">
                <div class="info-sidebar d-flex flex-column">
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

            <div class="col-12 col-md-12 col-lg-9 d-flex ps-lg-3 mb-4 w-100">
                <div class="main-content-box w-100" id="contens">

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
                                            <th style="text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($trading_names as $trading_name)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>
                                                    {{ $trading_name['name'] }}
                                                    @if ($trading_name['is_change'] == 1)
                                                        <span
                                                            style="background-color: #ff6600; color: white !important; margin-left: 5px;"
                                                            class="badge badge-primary">Registered</span>
                                                    @endif
                                                </td>
                                                <td style="text-align: center;">
                                                    <a href="{{ route('vender.trading.name.view', $trading_name['id']) }}">
                                                        <i class="ft-eye" style="color: black;"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Trading Name</th>
                                            <th style="text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="footers mt-auto">
                        <a href="{{ route('vender.trading.name.add') }}">
                            <button type="button" class="btn btn-dark round btn-min-width float-right m-0"
                                style="color: white !important;">Add</button>
                        </a>
                        <div class="clearfix"></div>
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
            // Destroy existing instance if already initialized
            if ($.fn.dataTable.isDataTable('.zero-configuration')) {
                $('.zero-configuration').DataTable().destroy();
            }

            var oTable = $('.zero-configuration').DataTable({
                "paging": false,
                "bAutoWidth": false, // Force DataTables to ignore its own width logic
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

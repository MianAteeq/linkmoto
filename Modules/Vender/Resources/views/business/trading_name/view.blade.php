@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        /* Fix for double scrollbar from master layout */
        .content-wrapper {
            height: auto !important;
            min-height: 84vh !important;
        }

        /* Table Resets (Included for consistency if you add tables later) */
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

        /* Custom Containers */
        .info-sidebar {
            border-radius: 7px;
            border: 2px solid black;
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
            width: 100%;
        }

        .main-content-inner {
            flex-grow: 1;
            padding-bottom: 0;
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
            color: #FFFFFF !important;
        }

        .round {
            border-radius: 0.5rem;
        }

        /* --- RESPONSIVE MEDIA QUERIES --- */
        @media (max-width: 991.98px) {
            .headerbg {
                padding-left: 25px !important;
            }

            .info-sidebar-wrapper {
                margin-bottom: 20px;
            }

            .text-secondary {
                word-break: break-word;
                margin-top: 5px;
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
                <h3 class="h3">Trading name Information</h3>

                <div class="breadcrumb-wrapper p-0">
                    <ol class="breadcrumb" style="padding-left: 0; background-color: transparent; margin-bottom: 10px;">
                        <li class="breadcrumb-item"><a>Business</a></li>
                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.trading.name') }}">Trading names</a></li>
                        <li class="breadcrumb-item">{{ $trading_name['name'] }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid px-1 px-md-1 mt-1">
        <div class="row align-items-stretch" style="padding-left: 0 !important;">

            {{-- FIX: Removed 'd-flex' from the wrapper to prevent vertical stretching --}}
            <div class="col-12 col-lg-3 info-sidebar-wrapper mb-3 mb-lg-0">
                {{-- FIX: Removed 'h-100' so the card fits its content --}}
                <div class="info-sidebar d-flex flex-column">
                    <h4
                        style="font-weight: 600; font-size: 1.1rem; padding: 12px 16px; margin: 0; display: flex; align-items: center; gap: 10px; background-color: white; border-radius: 5px 5px 0 0;">
                        <img src="/home.png" style="width: 20px;"> Trading Name
                    </h4>
                    <div style="border-top: 2px solid black; padding: 14px 16px; flex-grow: 1;">
                        <p style="line-height: 1.6; color: #333; font-size: 0.9rem; margin: 0;">
                            <strong>{{ $trading_name['name'] }}</strong><br><br>
                            Created on: {{ $trading_name->created_at->format('d M Y, H:i') }} <br>
                            Last updated: {{ $trading_name->updated_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-9 d-flex ps-lg-3 mb-4">
                <div class="main-content-box" id="contens">

                    <div class="main-content-inner">
                        {{-- Title row --}}
                        <div style="border-bottom: 2px solid black; padding: 12px 20px;">
                            <h3 style="font-size: 20px; color: black; margin: 0;">
                                Trading name Information
                            </h3>
                        </div>

                        {{-- Card Data --}}
                        <div class="card-content">
                            {{-- FIX: Increased padding from 20px to '30px 35px' for better spacing --}}
                            <div class="card-body" style="padding: 25px 15px;">

                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">ID</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $trading_name['id'] }}
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Trading name</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $trading_name['name'] }}
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Linked trade unit</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $trading_name['trading_unit']['name'] ?? 'None' }}
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Linked invoice document templates</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $trading_name['trading_unit']['name'] ?? 'None' }}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Footer aligned to bottom --}}
                    <div class="footers mt-auto text-right" style="text-align: right;">
                        <a href="{{ route('vender.trading.name.edit', $trading_name['id']) }}">
                            <button type="button" class="btn btn-dark round btn-min-width float-right m-0"
                                style="color: white !important;">Edit</button>
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
        // Minimal DataTables init (if needed for future use)
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

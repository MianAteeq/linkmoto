@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        /* ========================================================================
       1. TABLE STYLES (Preserved for global consistency)
       ======================================================================== */
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

        /* ========================================================================
       2. ICONS & COLLAPSE STYLES
       ======================================================================== */
        #headingCollapse14:before,
        #headingCollapse1:before,
        #headingCollapse2:before {
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

        /* ========================================================================
       3. CONTAINER STYLES (Fixed for Responsiveness)
       ======================================================================== */
        .info-sidebar {
            border-radius: 7px;
            border: 2px solid black;
            display: flex;
            flex-direction: column;
            height: 100%;
            /* Allows it to stretch to match the right column if needed */
            background-color: white;
            overflow: hidden;
        }

        .info-sidebar-body {
            padding: 15px;
            flex-grow: 1;
            /* Pushes the footer down naturally */
        }

        .footers {
            border-top: 2px solid black;
            padding: 15px;
            width: 100%;
            background: white;
            text-align: center;
            margin-top: auto;
            /* Always sits at the bottom */
        }

        .btn-dark {
            border-color: black !important;
            background-color: black !important;
            color: #FFFFFF;
        }

        .round {
            border-radius: 0.5rem;
        }

        .success {
            color: #28a745;
            /* Standard success green, adjust if needed */
            font-weight: bold;
        }

        /* ========================================================================
       4. RESPONSIVE MEDIA QUERIES (Updated to 991.98px for Tablet Stacking)
       ======================================================================== */
        @media (max-width: 991.98px) {
            .headerbg {
                padding-left: 25px !important;
            }

            .info-sidebar-wrapper {
                margin-bottom: 25px;
                /* Adds space between stacked containers */
            }

            /* Make buttons full width on smaller screens for better touch targets */
            .footers a button {
                width: 100% !important;
            }

            .text-secondary {
                word-break: break-word;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row m-0" style="border-bottom: 3px solid #949494;">
            <div class="col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3">User</h3>
                <div class="breadcrumb-wrapper col-12 p-0">
                    <ol class="breadcrumb" style="padding-left: 0; background-color: transparent;">
                        <li class="breadcrumb-item"><a>Directory</a></li>
                        <li class="breadcrumb-item"><a style="color: black" href="{{ route('vender.user') }}">Users</a></li>
                        <li class="breadcrumb-item">{{ $user['name'] }} {{ $user['middle_name'] }} {{ $user['last_name'] }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid px-1 px-md-1 mt-1">
        <div class="row align-items-start m-0">

            {{-- Left Sidebar Profile Card (Changed to col-lg-3 to stack on tablets) --}}
            <div class="col-12 col-lg-3 info-sidebar-wrapper mb-4 mb-lg-0 p-0 pr-lg-3">
                <div class="info-sidebar">
                    <div class="info-sidebar-body">
                        <h4 class="h3 d-flex align-items-start m-0"
                            style="font-weight: 600; font-size: 17px; padding-bottom: 15px;">
                            <img src="/user.png" style="width: 22px; margin-top: 2px; margin-right: 10px;">
                            <span style="word-break: break-word;">{{ $user['name'] }} {{ $user['middle_name'] }}
                                {{ $user['last_name'] }}</span>
                        </h4>

                        <div style="margin-top: 20px; font-weight: 500; font-size: 13px; word-break: break-all;">
                            <span>{{ $user['email'] }}</span>
                        </div>
                        <div style="margin-top: 15px; font-weight: 500; font-size: 13px;">
                            <span class="success">{{ $user['status'] }}</span>
                        </div>
                        <div style="margin-top: 15px; font-weight: 500; font-size: 13px;">
                            <span>Last sign in: {{ \Carbon\Carbon::parse($user['updated_at'])->format('d/m/Y') }} at
                                {{ \Carbon\Carbon::parse($user['updated_at'])->format('h:i') }}</span>
                        </div>
                        <div style="margin-top: 15px; font-weight: 500; font-size: 13px;">
                            <span>Created: {{ \Carbon\Carbon::parse($user['created_at'])->format('d/m/Y') }} at
                                {{ \Carbon\Carbon::parse($user['created_at'])->format('h:i') }}</span>
                        </div>
                    </div>

                    {{-- Action Buttons Footer --}}
                    <div class="footers">
                        <a href="{{ route('vender.user.password', $user['id']) }}">
                            <button type="button" style="width: 80%;" class="btn btn-dark round btn-min-width mb-2">RESET
                                PASSWORD</button>
                        </a>
                        <a href="{{ route('vender.user.edit', $user['id']) }}">
                            <button type="button" style="width: 80%;" class="btn btn-dark round btn-min-width mb-2">UPDATE
                                USER</button>
                        </a>
                        <a href="{{ route('vender.user.suspend', $user['id']) }}">
                            <button type="button" style="width: 80%;" class="btn btn-dark round btn-min-width mb-2">SUSPEND
                                USER</button>
                        </a>

                        @if ($user['status'] != 'ACTIVE')
                            <a href="{{ route('vender.user.active', $user['id']) }}">
                                <button type="button" style="width: 80%;"
                                    class="btn btn-dark round btn-min-width mb-0">ACTIVATE USER</button>
                            </a>
                        @else
                            <a href="{{ route('vender.user.in.active', $user['id']) }}">
                                <button type="button" style="width: 80%;"
                                    class="btn btn-dark round btn-min-width mb-0">INACTIVATE USER</button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right Content Menu (Changed to col-lg-9 to stack on tablets) --}}
            <div class="col-12 col-lg-9 p-0">
                <div class="card default-collapse collapse-icon accordion-icon-rotate"
                    style="box-shadow: none; background: transparent;">

                    <a id="headingCollapse1" href="{{ route('vender.user.information', $user['id']) }}"
                        class="card-header info mt-0"
                        style="border: 2px solid black; border-radius: 7px !important; padding: 1.2rem 1rem; color: black !important; display: block; position: relative; background: white;">
                        <div class="card-title lead m-0">User information</div>
                    </a>

                    <a id="headingCollapse2" href="{{ route('vender.user.app', $user['id']) }}"
                        class="card-header info mt-3"
                        style="border: 2px solid black; border-radius: 7px !important; padding: 1.2rem 1rem; color: black !important; display: block; position: relative; background: white;">
                        <div class="card-title lead m-0">Apps</div>
                    </a>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script src="/modules/admin/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>

    <script>
        // DataTable check to prevent errors if no table exists on page
        if ($('.zero-configuration').length > 0) {
            var oTable = $('.zero-configuration').DataTable({
                "destroy": true,
                "bPaginate": $('.zero-configuration tbody tr').length > 10,
                "iDisplayLength": 10,
                "bAutoWidth": false,
                "ordering": false,
            });

            $('#myInputTextField').keyup(function() {
                oTable.search($(this).val()).draw();
            });
        }
    </script>
@endsection

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

        /* ========================================================================
               3. CONTAINER & UI STYLES
               ======================================================================== */
        .info-sidebar {
            border-radius: 7px;
            border: 2px solid black;
            display: flex;
            flex-direction: column;
            height: 100%;
            background-color: white;
            overflow: hidden;
        }

        .info-sidebar-body {
            padding: 15px;
            flex-grow: 1;
        }

        .footers {
            border-top: 2px solid black;
            padding: 15px;
            width: 100%;
            background: white;
            text-align: center;
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

        .success {
            color: #28a745;
            font-weight: bold;
        }

        /* Sidebar Action Buttons Fixes */
        .sidebar-action-btn {
            width: 100%;
            padding: 10px 15px;
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: 6px;
            transition: all 0.2s ease;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .sidebar-action-btn:hover {
            background-color: #333 !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .footers-flex {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* ========================================================================
               4. RESPONSIVE MEDIA QUERIES (991.98px for Tablet/Mobile Stacking)
               ======================================================================== */
        @media (max-width: 991.98px) {
            .headerbg {
                padding-left: 25px !important;
            }

            .info-sidebar-wrapper {
                margin-bottom: 25px;
                /* Adds space between stacked containers */
            }

            /* Make buttons full width on smaller screens */
            .footers a button {
                width: 100% !important;
                float: none !important;
                margin-bottom: 0px !important;
                /* Managed by flex gap now */
            }

            .text-secondary {
                word-break: break-word;
                margin-top: 5px;
            }

            .col-sm-5 {
                font-weight: 600;
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
                        <li class="breadcrumb-item">User information</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid px-1 px-md-1 mt-1">
        <div class="row align-items-start m-0">

            {{-- Left Sidebar Profile Card (Added align-self-start) --}}
            <div class="col-12 col-lg-3 info-sidebar-wrapper mb-4 mb-lg-0 p-0 pr-lg-3 align-self-start">
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

                    {{-- Action Buttons Footer (Corrected styles and casing) --}}
                    <div class="footers footers-flex">
                        <a href="{{ route('vender.user.password', $user['id']) }}" style="text-decoration: none;">
                            <button type="button" class="btn btn-dark sidebar-action-btn m-0">Reset Password</button>
                        </a>
                        <a href="{{ route('vender.user.edit', $user['id']) }}" style="text-decoration: none;">
                            <button type="button" class="btn btn-dark sidebar-action-btn m-0">Update User</button>
                        </a>
                        <a href="{{ route('vender.user.suspend', $user['id']) }}" style="text-decoration: none;">
                            <button type="button" class="btn btn-dark sidebar-action-btn m-0">Suspend User</button>
                        </a>
                        @if ($user['status'] != 'ACTIVE')
                            <a href="{{ route('vender.user.active', $user['id']) }}" style="text-decoration: none;">
                                <button type="button" class="btn btn-dark sidebar-action-btn m-0">Activate User</button>
                            </a>
                        @else
                            <a href="{{ route('vender.user.in.active', $user['id']) }}" style="text-decoration: none;">
                                <button type="button" class="btn btn-dark sidebar-action-btn m-0">Inactivate User</button>
                            </a>
                        @endif
                    </div>

                </div>
            </div>

            {{-- Right Content Container --}}
            <div class="col-12 col-lg-9 p-0" id="contens">
                <div class="card default-collapse collapse-icon accordion-icon-rotate m-0"
                    style="box-shadow: none; background: transparent;">

                    {{-- FIXED ACCORDION HEADER (Using data-target instead of href) --}}
                    <a id="headingCollapse1" class="card-header info mt-0"
                        style="border: 2px solid black; border-radius: 7px 7px 0 0 !important; padding: 0.7rem 1rem; color: black !important; background: white; display: block; cursor: pointer;"
                        data-toggle="collapse" data-target="#collaptr_businesss_info" aria-expanded="true">
                        <div class="card-title lead m-0">User information</div>
                    </a>

                    <div id="collaptr_businesss_info" role="tabpanel" aria-labelledby="headingCollapse1"
                        style="border-left: 2px solid black; border-right: 2px solid black; border-bottom: 2px solid black; background: white; margin-top: -2px;"
                        class="collapse show">

                        <div class="card-content">
                            {{-- Added Padding Fix Here --}}
                            <div class="card-body" style="padding: 10px 15px;">

                                <div class="row align-items-center py-1">
                                    <div class="col-12 col-sm-5">
                                        <h6 class="mb-0">ID</h6>
                                    </div>
                                    <div class="col-12 col-sm-7 text-secondary">{{ $user['id'] }}</div>
                                </div>
                                <hr class="m-0">

                                <div class="row align-items-center py-1">
                                    <div class="col-12 col-sm-5">
                                        <h6 class="mb-0">First name</h6>
                                    </div>
                                    <div class="col-12 col-sm-7 text-secondary">{{ $user['name'] }}</div>
                                </div>
                                <hr class="m-0">

                                <div class="row align-items-center py-1">
                                    <div class="col-12 col-sm-5">
                                        <h6 class="mb-0">Middle name</h6>
                                    </div>
                                    <div class="col-12 col-sm-7 text-secondary">{{ $user['middle_name'] }}</div>
                                </div>
                                <hr class="m-0">

                                <div class="row align-items-center py-1">
                                    <div class="col-12 col-sm-5">
                                        <h6 class="mb-0">Last name</h6>
                                    </div>
                                    <div class="col-12 col-sm-7 text-secondary">{{ $user['last_name'] }}</div>
                                </div>
                                <hr class="m-0">

                                <div class="row align-items-center py-1">
                                    <div class="col-12 col-sm-5">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-12 col-sm-7 text-secondary">{{ $user['email'] }}</div>
                                </div>
                                <hr class="m-0">

                                @if (auth()->user()->id == $user['id'])
                                    <div class="row align-items-center py-1">
                                        <div class="col-12 col-sm-5">
                                            <h6 class="mb-0">Mobile</h6>
                                        </div>
                                        <div class="col-12 col-sm-7 text-secondary">{{ $user['profile']['phone_no'] }}
                                        </div>
                                    </div>
                                    <hr class="m-0">
                                    <div class="row align-items-center py-1">
                                        <div class="col-12 col-sm-5">
                                            <h6 class="mb-0">Landline</h6>
                                        </div>
                                        <div class="col-12 col-sm-7 text-secondary">{{ $user['profile']['landline'] }}
                                        </div>
                                    </div>
                                @else
                                    <div class="row align-items-center py-1">
                                        <div class="col-12 col-sm-5">
                                            <h6 class="mb-0">Mobile</h6>
                                        </div>
                                        <div class="col-12 col-sm-7 text-secondary">{{ $user['phone_no'] }}</div>
                                    </div>
                                    <hr class="m-0">
                                    <div class="row align-items-center py-1">
                                        <div class="col-12 col-sm-5">
                                            <h6 class="mb-0">Landline</h6>
                                        </div>
                                        <div class="col-12 col-sm-7 text-secondary">{{ $user['landline'] }}</div>
                                    </div>
                                @endif

                            </div>

                            <div class="footers"
                                style="border-radius: 0 0 5px 5px; text-align: right; border-top: 2px solid black;">
                                <a href="{{ route('vender.user.edit', $user['id']) }}">
                                    <button type="button" class="btn btn-dark round btn-min-width m-0">Edit</button>
                                </a>
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
        // Prevent initialization errors if table doesn't exist
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

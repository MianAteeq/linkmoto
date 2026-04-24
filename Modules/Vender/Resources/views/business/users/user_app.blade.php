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

        /* Hide sorting arrows */
        table.dataTable thead .sorting,
        table.dataTable thead .sorting_asc,
        table.dataTable thead .sorting_desc {
            background-image: none !important;
            cursor: default !important;
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
        }

        .round {
            border-radius: 0.5rem;
        }

        .success {
            color: #28a745;
            font-weight: bold;
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
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row m-0" style="border-bottom: 3px solid #949494;">
            {{-- Fixed alignment: Heading and Nav in two separate but equally aligned rows --}}
            <div class="col-12 bg-white headerbg" style="padding: 15px 32px;">

                <h3 class="h3 mb-1" style="font-weight: 600; color: black;">User</h3>

                <div class="breadcrumb-wrapper p-0">
                    <ol class="breadcrumb m-0 p-0" style="background-color: transparent;">
                        <li class="breadcrumb-item"><a>Directory</a></li>
                        <li class="breadcrumb-item">Users</li>
                        <li class="breadcrumb-item">{{ $user['name'] }} {{ $user['middle_name'] }} {{ $user['last_name'] }}
                        </li>
                        <li class="breadcrumb-item active">Apps</li>
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
                        <div style="width: 15%; margin-top: 2px;"><img src="/user.png" style="width: 22px;"></div>
                        <div style="width: 85%; padding-left: 5px;"><span>{{ $user['name'] }} {{ $user['middle_name'] }}
                                {{ $user['last_name'] }}</span></div>
                    </div>

                    <div style="padding: 20px; flex-grow: 1;">
                        <div class="mb-3" style="font-weight: 500; font-size: 13px; word-break: break-all;">
                            <span>{{ $user['email'] }}</span>
                        </div>
                        <div class="mb-2"><span class="success">{{ $user['status'] }}</span></div>
                        <div class="mb-3" style="font-weight: 500; font-size: 13px;">
                            <span>Last sign in:
                                {{ \Carbon\Carbon::parse($user['updated_at'])->format('d/m/Y \a\t h:i') }}</span>
                        </div>
                        <div style="font-weight: 500; font-size: 13px; color: #555;">
                            <span>Created: {{ \Carbon\Carbon::parse($user['created_at'])->format('d/m/Y \a\t h:i') }}</span>
                        </div>
                    </div>

                    {{-- Sidebar Action Buttons (Fixing crushed layout) --}}
                    <div class="footers"
                        style="flex-direction: column; gap: 12px; padding: 15px; border-radius: 0 0 5px 5px;">
                        <a href="{{ route('vender.user.password', $user['id']) }}" class="w-100"><button type="button"
                                class="btn btn-dark round w-100 m-0">RESET PASSWORD</button></a>
                        <a href="{{ route('vender.user.edit', $user['id']) }}" class="w-100"><button type="button"
                                class="btn btn-dark round w-100 m-0">UPDATE USER</button></a>
                        <a href="{{ route('vender.user.suspend', $user['id']) }}" class="w-100"><button type="button"
                                class="btn btn-dark round w-100 m-0">SUSPEND USER</button></a>
                        @if ($user['status'] != 'ACTIVE')
                            <a href="{{ route('vender.user.active', $user['id']) }}" class="w-100"><button type="button"
                                    class="btn btn-dark round w-100 m-0">ACTIVATE USER</button></a>
                        @else
                            <a href="{{ route('vender.user.in.active', $user['id']) }}" class="w-100"><button
                                    type="button" class="btn btn-dark round w-100 m-0">INACTIVATE USER</button></a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right Content Container --}}
            <div class="col-12 col-lg-9 p-0" id="contens">
                <div class="card default-collapse collapse-icon accordion-icon-rotate m-0"
                    style="box-shadow: none; background: transparent;">

                    {{-- FIXED ACCORDION HEADER (Using data-target to prevent redirect) --}}
                    <div id="headingCollapse1" class="card-header info mt-0"
                        style="border: 2px solid black; border-radius: 7px 7px 0 0 !important; padding: 1.2rem 1rem; color: black !important; background: white; cursor: pointer;"
                        data-toggle="collapse" data-target="#collaptr_apps_info" aria-expanded="true">
                        <div class="card-title lead m-0" style="font-weight: 600;">Apps</div>
                    </div>

                    <div id="collaptr_apps_info" class="collapse show"
                        style="border-left: 2px solid black; border-right: 2px solid black; border-bottom: 2px solid black; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px; background: white; margin-top: -2px;">

                        <div class="card-content">
                            <div class="card-body" style="padding: 20px;">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration w-100 m-0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>App</th>
                                                <th>Group</th>
                                                <th>Status</th>
                                                <th style="text-align: center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($apps as $app)
                                                <tr>
                                                    <td>{{ $app['app_name'] }}</td>
                                                    <td>
                                                        @if (isset($app['group']))
                                                            {{-- FIXED: Using auth()->user()->id if $vender_id is missing --}}
                                                            {{ str_replace('SVP_B_' . ($vender_id ?? auth()->user()->id), '', $app['group']['name']) }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $app['status'] == 1 ? 'ON' : 'OFF' }}</td>
                                                    <td
                                                        style="text-align: center; white-space: nowrap; vertical-align: middle;">
                                                        <a href="{{ route('vender.user.app.edit', $app['id']) }}"
                                                            style="margin-right: 12px; display: inline-block;">
                                                            <i class="ft-edit" style="color: #ff6600; font-size: 16px;"></i>
                                                        </a>
                                                        <a href="{{ route('vender.user.app.view', $app['id']) }}"
                                                            style="display: inline-block;">
                                                            <i class="ft-eye" style="color: #ff6600; font-size: 16px;"></i>
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
            // Check if the table is already a DataTable to prevent the alert
            if ($.fn.DataTable.isDataTable('.zero-configuration')) {
                $('.zero-configuration').DataTable().destroy();
            }

            $('.zero-configuration').DataTable({
                "destroy": true, // This prevents the "Cannot reinitialise" warning
                "bPaginate": true,
                "iDisplayLength": 10,
                "bAutoWidth": false,
                "ordering": false,
                "order": [], // Keeps those pesky purple arrows away
                "width": "100%",
                "columnDefs": [{
                    "targets": "_all",
                    "orderable": false
                }]
            });
        });
    </script>
@endsection

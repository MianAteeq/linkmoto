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

        /* ========================================================================
       2. ICONS & COLLAPSE STYLES
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
            padding: 12px 16px;
            display: flex;
            align-items: center;
        }

        .main-content-box {
            border: 2px solid black;
            border-radius: 6px;
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
            background-color: white;
            width: 100%;
        }

        .btn-dark {
            border-color: black !important;
            background-color: black !important;
            color: #FFFFFF !important;
            margin: 0 !important;
        }

        .round {
            border-radius: 0.5rem;
        }

        .badge-success {
            background-color: #ff6600 !important;
            /* Theme orange */
            font-size: 11px;
            padding: 6px 10px;
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
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row m-0" style="border-bottom: 3px solid #949494;">
            <div class="col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3">User group</h3>
                <div class="breadcrumb-wrapper col-12 p-0">
                    <ol class="breadcrumb" style="padding-left: 0; background-color: transparent;">
                        <li class="breadcrumb-item"><a>Products</a></li>
                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.app.setting') }}">Business Manager</a></li>
                        <li class="breadcrumb-item"><a style="color: black" href="{{ route('vender.app.setting') }}">App
                                settings</a></li>
                        <li class="breadcrumb-item"><a style="color: black" href="{{ route('vender.user.group') }}">User
                                groups</a></li>
                        <li class="breadcrumb-item">{{ $role['name'] }}</li>
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
                    <h4 class="h3 m-0 d-flex align-items-center"
                        style="font-weight: 600; font-size: 17px; word-break: break-word;">
                        <img src="/group.png" style="width: 22px; margin-right: 8px;"> {{ $role['name'] }}
                    </h4>
                </div>
            </div>

            {{-- Right Content Container --}}
            <div class="col-12 col-lg-9 p-0">
                <div class="main-content-box" id="contens">

                    {{-- Form Header --}}
                    <div style="border-bottom: 2px solid black; padding: 12px 20px;">
                        <h3 style="font-size: 20px; color: black; margin: 0;">User group information</h3>
                    </div>

                    {{-- Form Body --}}
                    <div class="card-content" style="padding: 20px; text-align: left;">

                        <div class="row py-2 align-items-center">
                            <div class="col-12 col-md-5">
                                <h6 class="mb-1 mb-md-0" style="font-weight: 600;">Name</h6>
                            </div>
                            <div class="col-12 col-md-7 text-secondary">
                                {{ str_replace('SVP_B_' . $vender_id, '', $role['name']) }}
                            </div>
                        </div>
                        <hr class="m-0">

                        <div class="row py-2 align-items-center">
                            <div class="col-12 col-md-5">
                                <h6 class="mb-1 mb-md-0" style="font-weight: 600;">User group type</h6>
                            </div>
                            <div class="col-12 col-md-7 text-secondary">
                                {{ $role['group_type'] }}
                            </div>
                        </div>
                        <hr class="m-0">

                        <div class="row py-3">
                            <div class="col-12">
                                <h6 class="mb-2" style="font-weight: 600; font-size: 1.1rem;">Permissions</h6>
                            </div>
                        </div>

                        {{-- Permissions Loop --}}
                        @foreach ($permissions as $key => $p)
                            <div class="row py-2 border-bottom">
                                <div class="col-12 col-md-5">
                                    <h6 class="mb-2 mb-md-0 mt-md-1" style="font-weight: 600; color: #333;">
                                        {{ $key }}</h6>
                                </div>
                                <div class="col-12 col-md-7 text-secondary"
                                    style="display: flex; flex-wrap: wrap; gap: 8px; justify-content: flex-start;">
                                    @foreach ($permissions[$key] as $per)
                                        <span class="badge badge-success">{{ $per['name'] }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

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
            if ($('.zero-configuration').length > 0) {
                if ($.fn.dataTable.isDataTable('.zero-configuration')) {
                    $('.zero-configuration').DataTable().destroy();
                }
                var oTable = $('.zero-configuration').DataTable({
                    "bPaginate": $('.zero-configuration tbody tr').length > 10,
                    "iDisplayLength": 10,
                    "bAutoWidth": false,
                    "ordering": false,
                });
                $('#myInputTextField').keyup(function() {
                    oTable.search($(this).val()).draw();
                });
            }
        });
    </script>
@endsection

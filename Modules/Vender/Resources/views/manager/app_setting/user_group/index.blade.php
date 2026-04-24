@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        .breadcrumb-wrapper {
            padding: 0 !important;
        }

        /* ========================================================================
                                                                       1. TABLE STYLES
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
            padding-bottom: 2px;
            padding-top: 2px;
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
            white-space: nowrap;
            /* Keeps headers clean */
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

        /* Force table to 100% width and prevent border clipping */
        table.dataTable {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            border-collapse: collapse !important;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            padding: 1px;
        }

        /* ========================================================================
                                                                       2. ICONS & COLLAPSE STYLES
                                                                       ======================================================================== */
        #headingCollapse1:before {
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

        /* Hide DataTables sorting icons (the purple arrows) */
        table.dataTable thead .sorting,
        table.dataTable thead .sorting_asc,
        table.dataTable thead .sorting_desc,
        table.dataTable thead .sorting_asc_disabled,
        table.dataTable thead .sorting_desc_disabled {
            background-image: none !important;
            cursor: default !important;
        }

        /* Remove the padding DataTables adds to make room for the icon */
        table.dataTable thead th,
        table.dataTable thead td {
            padding-right: 18px !important;
        }

        /* ========================================================================
                                                                       3. FOOTER & BUTTONS
                                                                       ======================================================================== */
        .footers {
            bottom: 0;
            left: 0;
            border-top: 2px solid black;
            padding: 15px 20px;
            width: 100%;
            background: white;
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
                                                                       4. RESPONSIVE MEDIA QUERIES (Tablet & Mobile Stacking)
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
                flex: 0 0 100% !important;
                max-width: 100% !important;
            }

            .footers .btn-dark {
                float: none !important;
                width: 100% !important;
                display: block !important;
            }

            .footers a {
                display: block;
                width: 100%;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row m-0" style="border-bottom: 3px solid #949494;">
            <div class="col-12 bg-white headerbg" style="padding: 15px 32px;">
                <h3 class="h3">App settings</h3>
                <div class="breadcrumb-wrapper col-12 p-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Products</a></li>
                        <li class="breadcrumb-item">
                            <a style="color: black" href="{{ route('vender.app.setting') }}">Business Manager</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a style="color: black" href="{{ route('vender.app.setting') }}">App settings</a>
                        </li>
                        <li class="breadcrumb-item active">User groups</li>
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
            <div class="col-12 col-lg-3 info-sidebar-wrapper mb-3 mb-lg-0 p-0 pr-lg-3">
                <h4 class="h3 m-0"
                    style="border-radius: 7px; border: 2px solid black; padding: 12px 16px; font-weight: 600; font-size: 17px; background-color: white; display: flex; align-items: center;">
                    <img src="/business_manager.png" style="width: 22px; margin-right: 8px;"> Business Manager
                </h4>
            </div>

            {{-- Right Content Container --}}
            <div class="col-12 col-lg-9 p-0" id="contens">

                {{-- Top Orange Header --}}
                <div class="row m-0 mb-3">
                    <h4 class="h3 d-inline-block m-0"
                        style="border-radius: 7px; border: 2px solid #ff6600; padding: 10px 15px; font-weight: 600; font-size: 17px; color: #ff6600; background-color: white;">
                        App settings
                    </h4>
                </div>

                {{-- Accordion Block --}}
                <div class="card default-collapse collapse-icon accordion-icon-rotate m-0"
                    style="box-shadow: none; background: transparent;">

                    {{-- FIXED ACCORDION HEADER: Changed <a> to <div> to entirely prevent page navigation --}}
                    <div id="headingCollapse1" class="card-header info mt-0"
                        style="border: 2px solid black; border-radius: 7px 7px 0 0 !important; padding: 1.2rem 1rem; color: black !important; background: white; display: block; cursor: pointer;"
                        data-toggle="collapse" data-target="#collapse14" aria-expanded="true">
                        <div class="card-title lead m-0">User groups</div>
                    </div>

                    <div id="collapse14" role="tabpanel" aria-labelledby="headingCollapse1"
                        style="border-left: 2px solid black; border-right: 2px solid black; border-bottom: 2px solid black; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px; background: white; margin-top: -2px;"
                        class="collapse show">

                        <div class="card-content">
                            <div class="card-body" style="padding: 20px;">

                                {{-- Search & Filter Row --}}
                                <div class="row align-items-center mb-3 m-0">
                                    <div class="col-10 col-md-11 p-0 pr-2">
                                        <input type="text" class="form-control" id="myInputTextField"
                                            style="border: 2px solid black; border-radius: 6px; width: 100%; height: 40px;"
                                            placeholder="Search">
                                    </div>
                                    <div class="col-2 col-md-1 text-center p-0">
                                        <a href=""><i class="ft-filter"
                                                style="font-size: 26px; color: black; line-height: 1;"></i></a>
                                    </div>
                                </div>

                                {{-- Data Table --}}
                                <div class="row m-0">
                                    <div class="col-12 p-0">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered zero-configuration w-100 m-0"
                                                width="100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10%;">ID</th>
                                                        <th>User Group Name</th>
                                                        <th>User Group Type</th>
                                                        <th style="text-align: center; width: 15%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($roles as $role)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ str_replace('SVP_B_' . $vender_id, '', $role['name']) }}
                                                            </td>
                                                            <td>{{ $role['group_type'] }}</td>
                                                            {{-- FIXED: Enforced white-space: nowrap to keep buttons on one line --}}
                                                            <td
                                                                style="text-align: center; white-space: nowrap; vertical-align: middle;">

                                                                {{-- FIXED: Increased font size to 16px and ensured both are #ff6600 --}}
                                                                <a href="{{ route('vender.user.group.edit', $role['id']) }}"
                                                                    style="display: inline-block; margin-right: 12px;">
                                                                    <i class="ft-edit"
                                                                        style="color: #ff6600; font-size: 11px;"></i>
                                                                </a>

                                                                <a href="{{ route('vender.user.group.view', $role['id']) }}"
                                                                    style="display: inline-block;">
                                                                    <i class="ft-eye"
                                                                        style="color: #ff6600; font-size: 11px;"></i>
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

                            {{-- Footer Add Button --}}
                            <div class="footers m-0" style="border-radius: 0 0 5px 5px;">
                                <a href="{{ route('vender.user.group.add') }}">
                                    <button type="button" class="btn btn-dark round btn-min-width m-0"
                                        style="float: right;">Add</button>
                                </a>
                                <div class="clearfix"></div>
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
            if ($('.zero-configuration').length > 0) {
                if ($.fn.dataTable.isDataTable('.zero-configuration')) {
                    $('.zero-configuration').DataTable().destroy();
                }

                var oTable = $('.zero-configuration').DataTable({
                    "bPaginate": $('.zero-configuration tbody tr').length > 10,
                    "iDisplayLength": 10,
                    "bAutoWidth": false,
                    "ordering": false,
                    "order": [], // Enforces removal of purple arrow
                    "width": "100%",
                    "columnDefs": [{
                        "targets": "_all",
                        "orderable": false
                    }]
                });

                setTimeout(function() {
                    oTable.columns.adjust().draw();
                }, 150);

                $('#myInputTextField').on('keyup', function() {
                    oTable.search($(this).val()).draw();
                });

                $(window).on('resize', function() {
                    oTable.columns.adjust();
                });
            }
        });
    </script>
@endsection

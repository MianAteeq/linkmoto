@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        /* --- DATATABLES HIDE DEFAULT UI --- */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info {
            display: none;
        }

        /* --- DATATABLES WIDTH FIXES --- */
        .table-responsive {
            display: block;
            width: 100% !important;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .dataTables_wrapper {
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            display: block !important;
        }

        .dataTables_wrapper .row {
            width: 100% !important;
            margin: 0 !important;
        }

        .dataTables_wrapper .col-sm-12 {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            padding: 0 !important;
        }

        table.dataTable,
        table.table {
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
            display: table !important;
            clear: both;
            border-collapse: collapse;
            margin: 0 !important;
        }

        table.dataTable thead {
            background: #fafbfc;
            color: black;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: white;
        }

        table.dataTable tbody td {
            padding: 8px 10px 2px 10px;
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

        /* --- ACCORDION FIXES --- */
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

        /* --- SIDEBAR SCROLLBAR FIXES --- */
        .main-menu {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
            overflow-x: hidden !important;
        }

        .main-menu::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari and Opera */
        }

        .main-menu-content {
            overflow-x: hidden !important;
        }

        /* --- GENERAL STYLES --- */
        .footers {
            bottom: 0;
            left: 0;
            border-top: 2px solid black;
            padding-top: 5px;
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

        .badge-success {
            background-color: #ff6600 !important;
        }

        /* --- RESPONSIVE ENHANCEMENTS --- */
        @media (max-width: 991px) {

            /* Accordion Key-Value pairs spacing on mobile */
            .card-body .col-sm-5 h6 {
                margin-bottom: 5px;
                font-weight: bold;
            }

            .card-body .col-sm-7 {
                margin-bottom: 15px;
            }

            .card-body hr {
                margin-top: 5px;
                margin-bottom: 15px;
            }

            .badge-success {
                display: inline-block;
                margin-bottom: 5px;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3 mb-1">User group</h3>

                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb p-0 m-0 pb-2 bg-transparent">
                        <li class="breadcrumb-item"><a>Products</a></li>
                        <li class="breadcrumb-item">
                            <a style="text-decoration: none; color: black;"
                                href="{{ route('vender.service.provider.trading.unit') }}">Service Provider</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a style="text-decoration: none; color: black;"
                                href="{{ route('vender.service.provider.app.setting') }}">App settings</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('vender.service.provider.user.group')}}">User groups</a>
                        </li>
                        <li class="breadcrumb-item">{{ str_replace('SVP_B_' . auth()->user()->id, '', $role['name']) }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-12 mb-3">
            <div style="border-radius: 7px;border: 2px solid black;">
                <h4 class="h3 d-flex align-items-center"
                    style="font-weight: 600; font-size: 17px;padding: 10px; margin: 0;">
                    <img src="/group.png" style="width: 22px; margin-right: 8px;"> {{ str_replace('SVP_' . auth()->user()->id, '', $role['name']) }}
                </h4>
            </div>
        </div>

        <div class="col-lg-9 col-md-12" id="contens"
            style="border: 2px solid black;border-radius: 6px;margin-bottom: 10px;padding: 0;">
            <div class="row m-0">
                <div class="col-12 p-0" style="border-bottom: 2px solid black;">
                    <h3 style="font-size: 20px; padding: 10px 15px; color: black; margin: 0;">User group information</h3>
                </div>

                <div class="col-12 p-0">
                    <div id="collaptr_businesss_info" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
                        class="collapse show" aria-expanded="false">
                        <div class="card-content">
                            <div class="card-body" style="padding-bottom: 15px;">

                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">ID</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $role['id'] }}
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Name</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ str_replace('SVP_' . auth()->user()->id, '', $role['name']) }}
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">User group type</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $role['group_type'] }}
                                    </div>
                                </div>
                                <hr>

                                <div class="row mb-2">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Permission</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                    </div>
                                </div>

                                @foreach ($permissions as $key => $p)
                                    <div class="row mt-2">
                                        <div class="col-sm-5">
                                            <h6 class="mb-0 pl-md-3" style="font-weight: 600;">{{ $key }}</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            @foreach ($permissions[$key] as $per)
                                                <span class="badge badge-success mr-1 mb-1">{{ $per['name'] }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

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
            // Force sidebar to open automatically on page load to fix mobile collapse issue
            $('body').removeClass('menu-hide menu-collapsed').addClass('menu-expanded menu-open');

            // Trigger a slight delay window resize to snap DataTables/Layouts to the newly opened sidebar
            setTimeout(function() {
                $(window).trigger('resize');
            }, 200);

            // Initialize DataTables ONLY if a table exists on this page
            if ($('.zero-configuration').length > 0) {
                var oTable = $('.zero-configuration').DataTable({
                    "bPaginate": $('.zero-configuration tbody tr').length > 10,
                    "iDisplayLength": 10,
                    "bAutoWidth": false,
                    "ordering": false,
                    "initComplete": function(settings, json) {
                        $('.dataTables_wrapper, .dataTables_wrapper .row, .dataTables_wrapper .col-sm-12, .dataTable')
                            .css('width', '100%', 'important');
                    }
                });

                $('#myInputTextField').keyup(function() {
                    oTable.search($(this).val()).draw();
                });
            }
        });
    </script>
@endsection

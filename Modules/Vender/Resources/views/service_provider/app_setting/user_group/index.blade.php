@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        #headingCollapse1:before {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e845" !important;
            transition: all 300ms linear 0s;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info {
            display: none;
        }

        /* --- CRITICAL DATATABLES WIDTH FIXES --- */
        .table-responsive {
            display: block;
            width: 100% !important;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Force the outer wrapper to 100% */
        .dataTables_wrapper {
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            display: block !important;
        }

        /* Force DataTables' injected row to 100% */
        .dataTables_wrapper .row {
            width: 100% !important;
            margin: 0 !important;
        }

        /* Force DataTables' injected column to 100% and remove padding */
        .dataTables_wrapper .col-sm-12 {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            padding: 0 !important;
        }

        /* Force the actual table to stretch */
        table.dataTable,
        table.table {
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
            display: table !important;
            /* Prevents block-level collapse */
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

        .btn-dark {
            border-color: black !important;
            background-color: black !important;
            color: #FFFFFF;
        }

        .round {
            border-radius: 0.5rem;
        }

        /* --- RESPONSIVE ENHANCEMENTS --- */
        .card-body {
            position: relative;
            padding-bottom: 60px !important;
            /* Space for the absolute footer */
        }

        .footers {
            position: absolute;
            bottom: 0 !important;
            left: 0 !important;
            border-top: 2px solid black;
            padding: 10px 15px !important;
            width: 100% !important;
            box-sizing: border-box;
            background-color: #fff;
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
        }

        .table-responsive table th,
        .table-responsive table td {
            white-space: nowrap !important;
        }

        @media (max-width: 991px) {
            .nav-buttons {
                display: flex;
                flex-direction: column;
                margin-left: 0 !important;
                margin-right: 0 !important;
                width: 100%;
            }

            .nav-buttons a,
            .nav-buttons>h4 {
                width: 100%;
                margin-bottom: 10px;
                margin-right: 0 !important;
            }

            .nav-buttons a h4,
            .nav-buttons>h4 {
                margin-left: 0 !important;
                margin-right: 0 !important;
                text-align: center;
            }

            .footers {
                position: relative;
                width: 100% !important;
                bottom: 0 !important;
                margin-top: 20px;
            }

            .footers .btn {
                width: 100%;
                float: none !important;
                margin: 0 !important;
            }

            .card-body {
                padding-bottom: 15px !important;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px; padding-top: 13px;">
                <h3 class="h3 mb-1">App settings</h3>

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
                        <li class="breadcrumb-item">User groups</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-12 col-12 mb-3">
            <h4 class="h3 d-flex align-items-center"
                style="border-radius: 7px;border: 2px solid black;padding: 10px;font-weight: 600; font-size: 17px; margin: 0;">
                <img src="/business_manager.png" style="width: 22px; margin-right: 8px;"> Business Manager
            </h4>
        </div>

        <div class="col-lg-9 col-md-12 col-12" id="contens"
            style="border-radius: 6px;margin-bottom: 10px;padding-bottom: 10px;margin-top: 0px;">

            <div class="row d-flex align-items-center mb-2 flex-wrap nav-buttons" style="margin-left: 0;">
                <h4 class="h3 mb-0"
                    style="border-radius: 7px; border: 2px solid #ff6600; padding: 10px; font-weight: 600; font-size: 17px; color: #ff6600; margin-right: 15px;">
                    App settings
                </h4>
            </div>

            <div class="card default-collapse collapse-icon accordion-icon-rotate" style="box-shadow: none;">
                <a id="headingCollapse1" href="{{ redirect()->back()->getTargetUrl() }}" class="card-header info mt-2"
                    style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;margin-top: 1px !important;border-bottom-left-radius: 0px !important; border-bottom-right-radius: 0px !important;"
                    data-toggle="" aria-expanded="false" aria-controls="collapse14">
                    <div class="card-title lead collapsed mb-0">User groups</div>
                </a>

                <div id="collapse14" role="tabpanel" aria-labelledby="headingCollapse14" class="collapse show"
                    aria-expanded="false"
                    style="border-left: 2px solid black; margin-top: -4px; border-right: 2px solid black; border-bottom: 2px solid black; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px;">
                    <div class="card-content">
                        <div class="card-body" style="padding-left: 0px;padding-right: 0px;">

                            <div class="d-flex align-items-center mb-3 mt-1 px-2">
                                <div class="flex-grow-1 pr-2">
                                    <input type="text" class="form-control w-100" id="myInputTextField"
                                        style="border: 2px solid black; border-radius: 6px;" placeholder="Search"
                                        name="" id="">
                                </div>
                                <div>
                                    <a href=""> <i class="ft-filter" style="font-size: 30px;color: black;"></i></a>
                                </div>
                            </div>

                            <div class="row m-0 mt-1 mb-1 px-2">
                                <div class="col-12 p-0">
                                    <div class="table-responsive w-100">
                                        <table class="table table-striped table-bordered zero-configuration w-100"
                                            style="width: 100% !important;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>User Group Name</th>
                                                    <th>User Group Type</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($roles as $role)
                                                    <tr>
                                                        <td>{{ $loop->iteration + 1 }}</td>
                                                        <td>{{ str_replace('SVP_' . auth()->user()->id, '', $role['name']) }}
                                                        </td>
                                                        <td>{{ $role['group_type'] }}</td>
                                                        <td>
                                                            @if($role['group_type'] !='System Default')
                                                            <a
                                                                href="{{ route('vender.service.provider.user.group.edit', $role['id']) }}">
                                                                <i class="ft-edit"></i>
                                                            </a>
                                                            @endif
                                                            <a
                                                                href="{{ route('vender.service.provider.user.group.view', $role['id']) }}">
                                                                <i class="ft-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>User Group Name</th>
                                                    <th>User Group Type</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="footers">
                                <a href="{{ route('vender.service.provider.user.group.add') }}">
                                    <button type="button" class="btn btn-dark round btn-min-width m-0"
                                        style="float: right;">Add</button>
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
        oTable = $('.zero-configuration').DataTable({
            "bPaginate": $('.zero-configuration tbody tr').length > 10,
            "iDisplayLength": 10,
            "bAutoWidth": false,
            "ordering": false,
            "initComplete": function(settings, json) {
                // Forcibly apply 100% width to all injected elements via JS
                $('.dataTables_wrapper, .dataTables_wrapper .row, .dataTables_wrapper .col-sm-12, .dataTable')
                    .css('width', '100%', 'important');

                // Trigger window resize to force DataTables to recount columns
                setTimeout(function() {
                    $(window).trigger('resize');
                }, 100);
            }
        });

        $('#myInputTextField').keyup(function() {
            oTable.search($(this).val()).draw();
        });
    </script>
@endsection

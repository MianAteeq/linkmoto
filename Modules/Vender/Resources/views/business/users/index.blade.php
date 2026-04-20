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

        /* Sort cursor & arrow overrides */
        table.dataTable thead th {
            cursor: default !important;
        }

        table.dataTable thead .sorting,
        table.dataTable thead .sorting_asc,
        table.dataTable thead .sorting_desc,
        table.dataTable thead .sorting_asc_disabled,
        table.dataTable thead .sorting_desc_disabled {
            cursor: default !important;
            background-image: none !important;
        }

        .dataTables_paginate {
            display: none !important;
        }

        /* Icons & Structural */
        .collapsed {
            border-bottom-left-radius: 0px !important;
            border-bottom-right-radius: 0px !important;
        }

        .footers {
            border-top: 2px solid black;
            padding: 15px 15px 10px 15px;
            width: 100%;
            background: white;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;
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
            /* height: auto so it only wraps its content */
            height: auto;
        }

        .main-content-box {
            border: 2px solid black;
            border-radius: 6px;
            margin-bottom: 10px;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        .main-content-inner {
            flex-grow: 1;
            padding-bottom: 20px;
        }

        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* --- RESPONSIVE MEDIA QUERIES --- */
        @media (max-width: 767.98px) {
            .headerbg {
                padding-left: 25px !important;
            }

            /* Stack both columns full width */
            .col-12.col-lg-3,
            .col-12.col-lg-9 {
                width: 100% !important;
                max-width: 100% !important;
                flex: 0 0 100% !important;
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            /* Gap between sidebar and main box */
            .info-sidebar-wrapper {
                margin-bottom: 15px !important;
            }

            /* Prevent outer row overflow */
            .row {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            /* Remove fixed height */
            .main-content-box {
                height: auto !important;
            }

            /* Footer button full width */
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
        <div class="row m-0" style="border-bottom: 3px solid #949494;">
            <div class="col-12 bg-white headerbg" style="padding-left: 32px; padding-top: 13px;">
                <h3 class="h3">Users</h3>
                <div class="breadcrumb-wrapper col-12 p-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Directory</a></li>
                        <li class="breadcrumb-item">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">

        {{-- Sidebar --}}
        <div class="col-12 col-lg-3 mb-3 info-sidebar-wrapper">
            <div class="info-sidebar">
                <h4 class="h3" style="font-weight: 600; font-size: 17px; padding: 10px; margin: 0;">
                    <img src="/users.png" style="width: 35px; margin-top: 1px;"> Directory
                </h4>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="col-12 col-lg-9">
            <div class="main-content-box" id="contens">

                <div class="main-content-inner">
                    <div class="row m-0" style="border-bottom: 2px solid black;">
                        <div class="col-12 p-0">
                            <h3 style="font-size: 20px; padding: 10px 15px; color: black; margin: 0;">
                                Users
                            </h3>
                        </div>
                    </div>

                    <div class="row m-0 mt-1 px-1 align-items-center">
                        <div class="col-10 col-md-11 pr-1">
                            <input type="text" class="form-control" id="myInputTextField"
                                style="border: 2px solid black; border-radius: 6px;" placeholder="Search">
                        </div>
                        <div class="col-2 col-md-1 text-center pl-0">
                            <a href="">
                                <i class="ft-filter" style="font-size: 30px; color: black; line-height: 1;"></i>
                            </a>
                        </div>
                    </div>

                    <div class="row m-0 mt-1 px-1 mb-1">
                        <div class="col-12 p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration w-100">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>First Name</th>
                                            <th>Middle Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>{{ $user['name'] }}</td>
                                            <td>{{ $user['middle_name'] }}</td>
                                            <td>{{ $user['last_name'] }}</td>
                                            <td>{{ $user['email'] }}</td>
                                            <td>{{ $user['profile']['phone_no'] }}</td>
                                            <td>Active</td>
                                            <td>
                                                <a href="{{ route('vender.user.edit', $user['id']) }}"><i
                                                        class="ft-edit"></i></a>
                                                <a href="{{ route('vender.user.view', $user['id']) }}"><i
                                                        class="ft-eye"></i></a>
                                            </td>
                                        </tr>
                                        @foreach ($users as $account)
                                            <tr>
                                                <td>{{ $loop->iteration + 1 }}</td>
                                                <td>{{ $account['name'] }}</td>
                                                <td>{{ $account['middle_name'] }}</td>
                                                <td>{{ $account['last_name'] }}</td>
                                                <td>{{ $account['email'] }}</td>
                                                <td>{{ $account['phone_no'] }}</td>
                                                <td>{{ $account['status'] }}</td>
                                                <td>
                                                    <a href="{{ route('vender.user.edit', $account['id']) }}"><i
                                                            class="ft-edit"></i></a>
                                                    <a href="{{ route('vender.user.view', $account['id']) }}"><i
                                                            class="ft-eye"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>First Name</th>
                                            <th>Middle Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="footers">
                    <a href="{{ route('vender.user.add') }}">
                        <button type="button" class="btn btn-dark round btn-min-width float-md-right m-0">ADD</button>
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

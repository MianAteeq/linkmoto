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
        }

        .main-content-inner {
            flex-grow: 1;
            padding-bottom: 20px;
            width: 100%;
        }

        /* ========================================================================
                       2. DATATABLES & TABLE STYLING
                       ======================================================================== */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_paginate {
            display: none !important;
        }

        .dataTables_wrapper .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .dataTables_wrapper [class*="col-"] {
            padding-left: 0 !important;
            padding-right: 0 !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
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

        /* FIX: 99.8% width prevents the 1px browser rounding error that causes phantom scrollbars */
        table.dataTable {
            width: 99.8% !important;
            max-width: 100% !important;
            margin: 0 auto !important;
            /* Centers the table in that tiny 0.2% gap */
        }

        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* ========================================================================
                       3. UI ELEMENTS (FOOTERS & BUTTONS)
                       ======================================================================== */
        .footers {
            border-top: 2px solid black;
            padding: 15px 20px 25px 20px;
            width: 100%;
            background: white;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;
            margin-top: auto;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
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

            .footers {
                padding: 15px 20px 25px 20px !important;
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
        <div class="row" style="border-bottom: 3px solid #949494; margin: 0;">
            <div class="col-12 bg-white headerbg" style="padding-left: 32px; padding-top: 13px;">
                <h3 class="h3">Bank Accounts</h3>
                <div class="breadcrumb-wrapper col-12 p-0">
                    <ol class="breadcrumb" style="padding-left: 0; background-color: transparent; margin-bottom: 10px;">
                        <li class="breadcrumb-item"><a>Business</a></li>
                        <li class="breadcrumb-item">Bank Accounts</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid px-1 px-md-1 mt-1">
        <div class="row align-items-start" style="padding-left: 0 !important;">

            {{-- Sidebar --}}
            <div class="col-12 col-md-12 col-lg-3 info-sidebar-wrapper d-flex mb-3 mb-lg-0">
                <div class="info-sidebar d-flex flex-column">
                    <h4 class="h3"
                        style="font-weight: 600; font-size: 1.1rem; padding: 12px 16px; margin: 0; display: flex; align-items: center; gap: 10px; background-color: white; border-radius: 5px 5px 0 0;">
                        <img src="/home.png" style="width: 20px;"> Bank Accounts
                    </h4>
                    <div style="border-top: 2px solid black; padding: 14px 16px;">
                        <p style="line-height: 1.6; color: #333; font-size: 0.9rem; margin: 0;">
                            Add and manage your business bank accounts here. These will be linked in other sections such as
                            invoice document settings and payout account selection. Multiple accounts can be stored for
                            different purposes (e.g. main business account, remittance, trade unit specific account, etc).
                            <br><br>
                            At least 1 bank account needs to be added for the <a>Payout Account</a>.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Main Content Box --}}
            <div class="col-12 col-md-12 col-lg-9 d-flex ps-lg-3 mb-4 w-100">
                <div class="main-content-box w-100" id="contens">

                    <div class="main-content-inner">
                        <div class="row m-0" style="border-bottom: 2px solid black;">
                            <div class="col-12 p-0">
                                <h3 style="font-size: 20px; padding: 12px 20px; color: black; margin: 0;">
                                    Bank Accounts
                                </h3>
                            </div>
                        </div>

                        {{-- Search Filter --}}
                        <div class="row m-0 mt-2 align-items-center" style="padding: 0 20px;">
                            <div class="col-10 col-md-11 p-0 pr-2">
                                <input type="text" class="form-control" id="myInputTextField"
                                    style="border: 2px solid black; border-radius: 6px; width: 100%; max-width: 100%;"
                                    placeholder="Search">
                            </div>
                            <div class="col-2 col-md-1 text-center p-0">
                                <a href="">
                                    <i class="ft-filter" style="font-size: 26px; color: black; line-height: 1;"></i>
                                </a>
                            </div>
                        </div>

                        {{-- Table --}}
                        <div class="row m-0 mt-2" style="padding: 0 20px;">
                            <div class="col-12 p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration m-0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Label</th>
                                                <th>Bank Name</th>
                                                <th>Account Name</th>
                                                <th>Sort Code</th>
                                                <th>Account Number</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($banks as $bank)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $bank['label'] }}</td>
                                                    <td>{{ $bank['bank_name'] }}</td>
                                                    <td>{{ $bank['account_name'] }}</td>
                                                    <td>{{ $bank['sort_code'] }}</td>
                                                    <td>{{ $bank['account_number'] }}</td>
                                                    <td>{{ $bank['status'] }}</td>
                                                    <td>
                                                        <a href="{{ route('vender.bank.view', $bank['id']) }}"><i
                                                                class="ft-eye"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Label</th>
                                                <th>Bank Name</th>
                                                <th>Account Name</th>
                                                <th>Sort Code</th>
                                                <th>Account Number</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="footers" style="padding: 15px 20px 15px 20px;">
                        <a href="{{ route('vender.bank.add') }}">
                            <button type="button" class="btn btn-dark round btn-min-width m-0">Add</button>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/modules/admin/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>

    <script>
        $(window).on('load', function() {
            if ($(window).width() <= 768) {
                setTimeout(function() {
                    $('.nav-toggle, .menu-toggle').trigger('click');
                    $('body').removeClass('menu-hide menu-collapsed').addClass('menu-expanded menu-open');
                }, 500);
            }
        });
    </script>

    <script>
        $(document).ready(function() {
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

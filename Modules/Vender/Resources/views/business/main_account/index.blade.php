@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        .dataTables_wrapper .dataTables_length {
            display: none;
        }

        .dataTables_wrapper .dataTables_filter {
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
        }

        .dataTables_wrapper .dataTables_info {
            display: none;
        }

        table.dataTable tbody td {
            color: black;
        }

        table.dataTable thead th,
        table.dataTable thead td {
            padding: 10px 18px;
            border-bottom: 1px solid #000000;
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

        /* --- PROFESSIONAL SIDEBAR STYLES --- */
        .sidebar-overview {
            border-radius: 7px;
            border: 2px solid black;
            background-color: #fcfdfe;
            padding-bottom: 20px;
            box-shadow: 4px 4px 0px rgba(0, 0, 0, 0.04);
        }

        .sidebar-header {
            border-radius: 5px 5px 0 0;
            padding: 15px 20px;
            font-weight: 600;
            font-size: 1.2rem;
            color: black;
            border-bottom: 2px solid #0a0a0a;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
            background-color: white;
        }

        .sidebar-content {
            padding: 0px 10px;
        }

        .sidebar-content p {
            line-height: 1.6;
            color: #333;
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }

        /* Updated Footer style for Flexbox alignment */
        .footers {
            border-top: 2px solid black;
            padding: 10px 15px;
            width: 100%;
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

        /* BEGIN: Responsive Layout Adjustments */
        @media (max-width: 1024px) {
            .row.m-0.mt-2 .search-col {
                width: 90%;
                float: left;
            }

            .row.m-0.mt-2 .filter-col {
                width: 10%;
                float: left;
                text-align: center;
            }
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }

            .content-header {
                padding-left: 15px !important;
            }

            #contens[style] {
                height: auto !important;
                padding-bottom: 10px !important;
            }

            .headerbg[style] {
                padding-left: 15px !important;
            }

            .row.m-0.mt-2 {
                display: flex;
                flex-wrap: nowrap;
                align-items: center;
            }

            .row.m-0.mt-2 .search-col {
                flex: 0 0 85%;
                max-width: 85%;
                padding-right: 5px;
            }

            .row.m-0.mt-2 .filter-col {
                flex: 0 0 15%;
                max-width: 15%;
                text-align: center;
                margin-top: 0 !important;
            }

            .table-responsive {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .footers {
                text-align: center;
                padding-bottom: 15px;
            }

            .footers a button {
                float: none !important;
                width: 100%;
                margin: 0 auto !important;
                display: block;
            }
        }

        /* END: Responsive Layout Adjustments */
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 42px;padding-top: 13px;">
                <h3 class="h3">Main contacts</h3>

                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb" style="padding-left: 0; background-color: transparent; margin-bottom: 10px;">
                        <li class="breadcrumb-item"><a>Business</a>
                        </li>

                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.business.detail') }}">Detail</a>
                        </li>

                        <li class="breadcrumb-item">Main contacts
                        </li>

                    </ol>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    {{-- SPACING FIX: px-1 px-md-1 mt-2 → px-3 px-md-3 mt-3 to match VAT page --}}
    <div class="container-fluid px-1 px-md-1 mt-1">
        <div class="row align-items-stretch" style="padding-left: 0 !important;">

            {{-- SPACING FIX: col-lg-13 (invalid) → col-lg-3 to match VAT page sidebar column --}}
            <div class="col-xl-3 col-lg-3 mb-3 d-flex">
                <div class="sidebar-overview w-100 mb-0 d-flex flex-column">

                    <div class="sidebar-header">
                        <img src="/home.png" style="width: 22px;" alt="Home">
                        <span>Main Contacts</span>
                    </div>

                    <div class="sidebar-content flex-grow-1" style="color: black;">
                        <p>
                            Manage your business's main contact. The main contact is the primary point of contact for the
                            platform. They will receive all notifications, account updates, and verification requests, and
                            are authorised to manage subscriptions, payments, and other official actions on behalf of the
                            business.
                            Only one verified active main contact can be assigned. When a new contact is verified, the
                            current one becomes inactive.
                        </p>
                    </div>

                </div>
            </div>

            {{-- SPACING FIX: col-lg-12 → col-lg-9 and added ps-md-3 for gap between the two cards --}}
            <div class="col-xl-9 col-lg-9 mb-4 d-flex ps-md-3">
                <div id="contens" class="w-100 d-flex flex-column"
                    style="border: 2px solid black;border-radius: 6px; background-color: white; padding: 0;">

                    <div class="flex-grow-1">

                        <div class="row m-0" style="border-bottom: 2px solid black;">
                            <div class="col-md-12 p-0">
                                <h3 style="font-size: 20px; padding: 10px 15px; margin: 0; color: black;">Main contacts</h3>
                            </div>
                        </div>

                        <div class="row m-0 mt-1 align-items-center px-2">
                            <div class="col-10 col-md-11 search-col">
                                <input type="text" class="form-control" id="myInputTextField"
                                    style="border: 2px solid black; border-radius: 6px;" placeholder="Search" name=""
                                    id="">
                            </div>
                            <div class="col-2 col-md-1 filter-col text-center">
                                <a href=""> <i class="ft-filter" style="font-size: 30px;color: black;"></i></a>
                            </div>
                        </div>

                        <div class="row m-0 mt-2 mb-2">
                            <div class="col-md-12 p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration w-120 m-0 p-0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>First Name</th>
                                                <th>Middle Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Role / Position</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td>1</td>
                                                <td>{{ $user['name'] }}</td>
                                                <td>{{ $user['middle_name'] }}</td>
                                                <td>{{ $user['last_name'] }} </td>
                                                <td>{{ $user['email'] }}</td>
                                                <td>{{ $user['profile']['phone_no'] }}</td>
                                                <td>{{ $user['profile']['job_title'] }}</td>
                                                <td>{{ $user['user_verified'] }}</td>
                                                <td><a href="{{ route('vender.main.contact.view', $user['id']) }}"><i
                                                            class="ft-eye"></i></a></td>
                                            </tr>

                                            @foreach ($users as $account)
                                                <tr>
                                                    <td>{{ $loop->iteration + 1 }}</td>
                                                    <td>{{ $account['name'] }}</td>
                                                    <td>{{ $account['middle_name'] }}</td>
                                                    <td>{{ $account['last_name'] }} </td>
                                                    <td>{{ $account['email'] }}</td>
                                                    <td>{{ $account['sub_profile']['phone_no'] ?? '' }}</td>
                                                    <td>{{ $account['sub_profile']['job_title'] }}</td>
                                                    <td>{{ $account['user_verified'] }}</td>
                                                    <td> <a href="{{ route('vender.main.contact.view', $account['id']) }}"><i
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
                                                <th>Role / Position</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                    @if (count($exits) <= 0)
                        <div class="footers mt-auto">
                            <a href="{{ route('vender.main.contact.add') }}">
                                <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1 m-md-0"
                                    style="float: right; color: white !important;">Add</button>
                            </a>
                        </div>
                    @endif

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
        });

        $('#myInputTextField').keyup(function() {
            oTable.search($(this).val()).draw();
        })
    </script>
@endsection

@extends('admin::admin.layout.app')

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

        #headingCollapse14:before {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e842";
            transition: all 300ms linear 0s;
        }

        #headingCollapsevat:before {
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

        .span {
            background: #ff6600;
            padding: 3px;
            padding-left: 7px;
            border-radius: 4px;
            color: white;
            padding-right: 9px;
            margin-left: 8px;
        }

        .card-footer {
            border-top: 2px solid black;
            padding: 0.5rem 1rem;
        }

        .badge {
            display: inline-block;
            padding: 0.6em 0.6em;
            font-size: 83%;
        }

        .badge-primary {
            background-color: #1a469b;
            color: white !important;
        }

        .card-footer {
            border-top: 2px solid black;
            padding: 0.5rem 1rem;
        }

        .badge-danger {
            background-color: red;
        }

        .badge-secondary {
            background-color: rgb(0 111 192);
        }

        .card-footer {
            border-top: 2px solid black;
            padding: 0.5rem 1rem;
            margin-right: -15px;
            margin-left: -15px;
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3">Business</h3>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Business</a>
                        </li>

                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('admin.register') }}">Registered</a>
                        </li>


                        <li class="breadcrumb-item">{{ $site['address_line_1'] }} ,
                            {{ $site['address_line_2'] }}
                        </li>
                    </ol>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div style="border-radius: 7px;border: 2px solid black; ">
                <h4 class="h3" style="font-weight: 600; font-size: 17px;padding: 10px; ">
                    <img src="/home.png" style="width: 22px;margin-top: -5px;">
                    Site
                </h4>
                <p
                    style="padding-left: 10px; padding-right: 10px; line-height: 1.5rem; color: black; border-top: 2px solid black; ">

                    <strong>{{ $site['address_line_1'] }} ,
                        {{ $site['address_line_2'] }}</strong> <br>

                    @php
                        $status = $site['status'];

                        // Assign Bootstrap badge color classes based on status
                        switch ($status) {
                            case 'Todo':
                                $badgeClass = 'badge badge-secondary'; // gray
                                break;
                            case 'Pending':
                                $badgeClass = 'badge badge-primary text-dark'; // yellow
                                break;
                            case 'Verified':
                                $badgeClass = 'badge badge-success'; // green
                                break;
                            case 'Rejected':
                                $badgeClass = 'badge badge-danger'; // red
                                break;
                            default:
                                $badgeClass = 'badge badge-light text-dark'; // default
                                break;
                        }
                    @endphp

                    <span class="{{ $badgeClass }}" style="margin-top:10px">
                        {{ $status }}
                    </span>
                    <br>
                    <br>
                    Created on: {{ $site->created_at->format('d M Y, H:i') }} <br>
                    Last updated: {{ $site->updated_at->format('d M Y, H:i') }}


                </p>

            </div>
        </div>
        {{-- @dd($user['sites']) --}}
        <div class="col-md-9" id="contens"
            style="border: 2px solid black;border-radius: 6px;margin-bottom: 10px;padding-left: 0;padding-right: 0;">

            <div class="row" style="margin-right: 0;margin-left: 0;">
                <div class="col-md-12" style="border-bottom: 2px solid black;">
                    <h3 style="font-size: 20px; padding: 10px; margin-left: -11px; color: black;padding-bottom: 0px;">Site
                        Information</h3>
                </div>
                <div class="col-md-12">
                    <div id="collaptr_businesss_info" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
                        style="" class="collapse show" aria-expanded="false">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">ID</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $site['id'] }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Address Line 1</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $site['address_line_1'] }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Address Line 2</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $site['address_line_2'] }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Address Line 3</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $site['address_line_3'] }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Address Line 4</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $site['address_line_4'] }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">City</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $site['city'] }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Postcode</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $site['postcode'] }}
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0"> Proof of site</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        @if ($site['proof_name'] == null)
                                            <p> Registered address. Covered by business verification.</p>
                                        @else
                                            {{ $site['proof_name'] ?? 'N/A' }} <a class="btn btn-primary btn-primary_2"
                                                style="border-color: #ff6600 !important; background-color: #ff6600 !important;float: right;"
                                                target="_blank" href="{{ URL::to($site['proof'] ?? '') }}">View</a>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Status</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $site['status'] }}
                                    </div>
                                </div>







                            </div>


                            @if ($site['status'] == 'Pending')
                                <div class="card-footer">
                                    <div class="text-secondary" style="text-align: right">
                                        <a href="{{ route('admin.register.detail.site.rejected', $site['id']) }}"
                                            style=" background-color: black !important;
                                       border-color: black !important;"
                                            class="btn btn-primary"> Reject</a>
                                        <a href="{{ route('admin.register.detail.site.verify', $site['id']) }}"
                                            style=" background-color: black !important;
                                       border-color: black !important;"
                                            class="btn btn-primary"> Verify</a>

                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>


            </div>




        </div>
    </div>
@endsection


@section('script')
    <script src="/modules/admin/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    {{-- <script src="/modules/admin/app-assets/js/scripts/tables/datatables/datatable-basic.js"></script> --}}


    <script>
        oTable = $('.zero-configuration').DataTable({
            "bPaginate": $('.zero-configuration tbody tr').length > 10,
            "iDisplayLength": 10,
            "bAutoWidth": false,
            "ordering": false,

        }); //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
        $('#myInputTextField').keyup(function() {
            oTable.search($(this).val()).draw();
        })
    </script>
    <script>
        oTable = $('.zero-configuration-1').DataTable({
            "bPaginate": $('.zero-configuration-1 tbody tr').length > 10,
            "iDisplayLength": 10,
            "bAutoWidth": false,
            "ordering": false,

        }); //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
        $('#myInputTextField2').keyup(function() {
            oTable.search($(this).val()).draw();
        })
    </script>
    <script>
        oTable = $('.zero-configuration-2').DataTable({
            "bPaginate": $('.zero-configuration-2 tbody tr').length > 10,
            "iDisplayLength": 10,
            "bAutoWidth": false,
            "ordering": false,

        }); //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
        $('#myInputTextField3').keyup(function() {
            oTable.search($(this).val()).draw();
        })
    </script>

    <script>
        $(document).ready(function() {
            var contentHeight = $('#contens').height();
            $('#contens').height(contentHeight);
        });
    </script>

    <script>
        function showDetail() {

            $('#show_detail').show();
            $('#h3_detail').attr("style",
                "border-radius: 7px; border: 2px solid #ff6600; padding: 10px; font-weight: 600; font-size: 17px; color: #ff6600;"
            );
            $('#h3_main_account').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
            $('#h3_trading_account').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
            $('#h3_sites').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
            $('#main_account').hide();
            $('#sites').hide();
            $('#trading_name').hide();
        }
    </script>
    <script>
        function showMainAccount() {

            $('#show_detail').hide();
            $('#main_account').show();
            $('#h3_main_account').attr("style",
                "border-radius: 7px; border: 2px solid #ff6600; padding: 10px; font-weight: 600; font-size: 17px; color: #ff6600;margin-left: 10px"
            );
            $('#h3_detail').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;"
            );
            $('#h3_trading_account').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
            $('#h3_sites').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
            $('#sites').hide();
            $('#trading_name').hide();
        }
    </script>
    <script>
        function showTradingName() {

            $('#show_detail').hide();
            $('#main_account').hide();
            $('#sites').hide();
            $('#trading_name').show();
            $('#h3_trading_account').attr("style",
                "border-radius: 7px; border: 2px solid #ff6600; padding: 10px; font-weight: 600; font-size: 17px; color: #ff6600;margin-left: 10px"
            );
            $('#h3_detail').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;"
            );
            $('#h3_main_account').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
            $('#h3_sites').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
        }
    </script>
    <script>
        function showSites() {


            $('#show_detail').hide();
            $('#main_account').hide();
            $('#sites').show();
            $('#trading_name').hide();
            $('#h3_sites').attr("style",
                "border-radius: 7px; border: 2px solid #ff6600; padding: 10px; font-weight: 600; font-size: 17px; color: #ff6600;margin-left: 10px"
            );
            $('#h3_detail').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;"
            );
            $('#h3_main_account').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
            $('#h3_trading_account').attr("style",
                "border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; color: black;margin-left: 10px"
            );
        }
    </script>
@endsection

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

        .collapsed {
            border-bottom-left-radius: 0px !important;
            border-bottom-right-radius: 0px !important;
        }

        .footers {
            bottom: 0;
            left: 0;
            border-top: 2px solid black;
            padding-top: 10px;
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

        .dataTables_paginate {
            display: none;
        }

        .dataTables_paginate {
            display: none !important;
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

        /* --- RESPONSIVE MEDIA QUERIES --- */
        @media (max-width: 768px) {
            .headerbg {
                padding-left: 15px !important;
            }

            /* Stack columns vertically */
            .col-md-3,
            .col-md-9 {
                width: 100% !important;
                max-width: 100% !important;
                flex: 0 0 100% !important;
                padding-left: 15px !important;
                padding-right: 15px !important;
            }

            /* Gap between sidebar and main box */
            .col-md-3 {
                margin-bottom: 15px;
            }

            /* Fix main content box */
            #contens {
                height: auto !important;
                margin-top: 0 !important;
            }

            /* Search row stays in one line */
            .search-action-row {
                display: flex;
                flex-wrap: nowrap;
                align-items: center;
            }

            .search-action-row .col-md-11 {
                width: 85%;
                padding-right: 5px;
            }

            .search-action-row .col-md-1 {
                width: 15%;
                text-align: center;
                margin-top: 0 !important;
                padding-left: 5px;
            }

            .footers {
                padding-bottom: 15px;
            }

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
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3">Sites</h3>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Business</a></li>
                        <li class="breadcrumb-item">Sites</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div style="border-radius: 7px;border: 2px solid black;">
                <h4 class="h3" style="font-weight: 600; font-size: 17px;padding: 10px;">
                    <img src="/home.png" style="width: 22px;margin-top: -5px;"> Sites
                </h4>
                <p
                    style="border-top:2px solid;padding-left: 10px;padding-top: 10px; padding-right: 10px; line-height: 1.5rem; color: black;">
                    Add and manage your business locations.
                    <strong>Your registered business address will be added automatically as a site once your business is
                        verified.</strong><br>
                    Each trade unit must be linked to a verified site, so add additional sites if they operate from
                    different addresses.
                </p>
            </div>
        </div>

        <div class="col-md-9" id="contens"
            style="border: 2px solid black;border-radius: 6px;margin-bottom: 10px;padding-left: 0; padding-right: 0;">

            <div class="row" style="margin-right: 0;margin-left: 0;">
                <div class="col-md-12" style="border-bottom: 2px solid black;">
                    <h3 style="font-size: 20px; padding: 10px; margin-left: -11px; color: black;padding-bottom: 0px;">Sites
                    </h3>
                </div>
            </div>

            <div class="row m-0 mt-2 search-action-row">
                <div class="col-md-11">
                    <input type="text" class="form-control" id="myInputTextField"
                        style="border: 2px solid black; border-radius: 6px;" placeholder="Search">
                </div>
                <div class="col-md-1" style="margin-top: 7px;">
                    <a href=""><i class="ft-filter" style="font-size: 30px;color: black;"></i></a>
                </div>
            </div>

            <div class="row mt-2 mb-4">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Postcode</th>
                                    <th>Proof</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($address as $site)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $site['address_line_1'] }} {{ $site['address_line_2'] }}
                                            @if ($site['is_change'] == 1)
                                                <span style="background-color: #ff6600;"
                                                    class="badge badge-primary">Registered</span>
                                            @endif
                                        </td>
                                        <td>{{ $site['city'] }}</td>
                                        <td>{{ $site['postcode'] }}</td>
                                        <td><a href="{{ URL::to($site['proof']) }}"
                                                target="_blank">{{ $site['proof_name'] }}</a></td>
                                        <td>{{ $site['status'] }}</td>
                                        <td>
                                            <a href="{{ route('vender.site.view', $site['id']) }}"><i
                                                    class="ft-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Postcode</th>
                                    <th>Proof</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="footers">
                <a href="{{ route('vender.site.add') }}">
                    <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                        style="float: right;">Add</button>
                </a>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script src="/modules/admin/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>

    <script>
        $(document).ready(function() {

            // Destroy existing instance first if it exists
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

            // Only fix height on desktop
            if ($(window).width() > 768) {
                var contentHeight = $('#contens').height();
                $('#contens').height(contentHeight);
            }
        });
    </script>
@endsection

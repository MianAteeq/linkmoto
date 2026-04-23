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
            padding-bottom: 0;
            width: 100%;
        }

        /* ========================================================================
                   2. SEARCH & FILTER ROW
                   ======================================================================== */
        .search-filter-row {
            display: flex;
            align-items: center;
            padding: 12px 20px 0 20px;
            gap: 10px;
            width: 100%;
        }

        .search-filter-row input {
            flex: 1;
            border: 2px solid black;
            border-radius: 6px;
        }

        .search-filter-row .filter-icon {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
        }

        /* ========================================================================
                   3. THE "NUCLEAR" DATATABLES STRETCH FIX
                   ======================================================================== */
        .dataTables_length,
        .dataTables_filter,
        .dataTables_info,
        .dataTables_paginate {
            display: none !important;
        }

        .table-responsive {
            width: 100% !important;
            display: block !important;
            overflow-x: auto !important;
            margin: 0 !important;
            padding: 0 !important;
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
            display: flex !important;
            flex-wrap: wrap !important;
        }

        .dataTables_wrapper [class*="col-"] {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            padding: 0 !important;
        }

        table.dataTable,
        table.dataTable.w-100 {
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            table-layout: auto !important;
            border-collapse: collapse !important;
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

        /* ========================================================================
                   4. TABLE STYLING
                   ======================================================================== */
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

        /* ========================================================================
                   5. UI ELEMENTS (FOOTERS & BUTTONS)
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

        .collapsed {
            border-bottom-left-radius: 0px !important;
            border-bottom-right-radius: 0px !important;
        }

        /* ========================================================================
                   6. RESPONSIVE MEDIA QUERIES
                   ======================================================================== */
        @media (max-width: 1024px) {
            .search-filter-row {
                flex-wrap: wrap;
            }

            .search-filter-row input {
                flex: 0 0 85%;
                max-width: 85%;
            }

            .search-filter-row .filter-icon {
                flex: 0 0 10%;
                max-width: 10%;
            }
        }

        @media (max-width: 991.98px) {
            .headerbg {
                padding-left: 25px !important;
            }

            .info-sidebar-wrapper {
                margin-bottom: 20px;
            }

            /* FIX: Enforce auto height so the container doesn't chop off the footer */
            #contens {
                height: auto !important;
            }

            /* FIX: Ensure we maintain bottom padding on mobile */
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
                <h3 class="h3">Sites</h3>

                <div class="breadcrumb-wrapper p-0">
                    <ol class="breadcrumb" style="padding-left: 0; background-color: transparent; margin-bottom: 10px;">
                        <li class="breadcrumb-item"><a>Business</a></li>
                        <li class="breadcrumb-item">Sites</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid px-1 px-md-1 mt-1">
        <div class="row align-items-start" style="padding-left: 0 !important;">

            <div class="col-12 col-md-12 col-lg-3 info-sidebar-wrapper d-flex mb-3 mb-lg-0">
                <div class="info-sidebar d-flex flex-column">
                    <h4
                        style="font-weight: 600; font-size: 1.1rem; padding: 12px 16px; margin: 0; display: flex; align-items: center; gap: 10px; background-color: white; border-radius: 5px 5px 0 0;">
                        <img src="/home.png" style="width: 20px;"> Sites
                    </h4>
                    <div style="border-top: 2px solid black; padding: 14px 16px;">
                        <p style="line-height: 1.6; color: #333; font-size: 0.9rem; margin: 0;">
                            Add and manage your business locations. <br><br>
                            <strong>Your registered business address will be added automatically as a site once your
                                business is verified.</strong><br><br>
                            Each trade unit must be linked to a verified site, so add additional sites if they operate from
                            different addresses.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-12 col-lg-9 d-flex ps-lg-3 mb-4 w-100">
                <div class="main-content-box w-100" id="contens">

                    <div class="main-content-inner">
                        {{-- Title row --}}
                        <div style="border-bottom: 2px solid black; padding: 12px 20px;">
                            <h3 style="font-size: 20px; color: black; margin: 0;">
                                Sites
                            </h3>
                        </div>

                        {{-- Search + Filter row --}}
                        <div class="search-filter-row">
                            <input type="text" class="form-control" id="myInputTextField" placeholder="Search">
                            <div class="filter-icon">
                                <a href="">
                                    <i class="ft-filter" style="font-size: 26px; color: black; line-height: 1;"></i>
                                </a>
                            </div>
                        </div>

                        {{-- Table --}}
                        <div style="padding: 12px 20px 16px 20px;">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration w-100 m-0">
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

                    <div class="footers mt-auto">
                        <a href="{{ route('vender.site.add') }}">
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

    {{-- SIDEBAR FIX: Force open on mobile with a slight delay so template JS doesn't override it --}}
    <script>
        $(window).on('load', function() {
            if ($(window).width() <= 768) {
                setTimeout(function() {
                    // Try clicking the toggle buttons first
                    $('.nav-toggle, .menu-toggle').trigger('click');

                    // Fallback: Manually force the body classes that Modern Admin uses to show the menu
                    $('body').removeClass('menu-hide menu-collapsed').addClass('menu-expanded menu-open');
                }, 500); // Wait 500ms for template scripts to finish loading
            }
        });
    </script>

    <script>
        $(document).ready(function() {

            // Destroy existing instance first if it exists
            if ($.fn.dataTable.isDataTable('.zero-configuration')) {
                $('.zero-configuration').DataTable().destroy();
            }

            var oTable = $('.zero-configuration').DataTable({
                "paging": false,
                "bAutoWidth": false, // Force DataTables to ignore its own width logic
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

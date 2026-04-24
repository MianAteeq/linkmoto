@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        /* --- 1. AGGRESSIVE HIDE FOR PURPLE SORTING ICONS --- */
        table.dataTable thead th.sorting::before, 
        table.dataTable thead th.sorting::after,
        table.dataTable thead th.sorting_asc::before, 
        table.dataTable thead th.sorting_asc::after,
        table.dataTable thead th.sorting_desc::before, 
        table.dataTable thead th.sorting_desc::after {
            content: "" !important;
            display: none !important;
        }

        /* Standardize header appearance */
        table.dataTable thead th {
            padding-right: 10px !important;
            color: black !important;
            background-color: #fafbfc !important;
        }

        /* --- 2. DataTable UI Clean-up --- */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info {
            display: none;
        }

        /* --- 3. STRETCH FIX: Equal Width for Search & Table --- */
        .dataTables_wrapper {
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .dataTables_wrapper .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        .dataTables_wrapper .col-sm-12 {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        table.dataTable {
            width: 100% !important;
            margin: 0 !important;
        }

        /* Standard Padding Alignment (15px) */
        .search-container { display: flex; align-items: center; gap: 10px; padding: 15px; }
        .table-container-custom { padding: 0 15px 15px 15px; } 

        .search-input { border: 2px solid black !important; border-radius: 6px !important; flex-grow: 1; }

        /* --- 4. Sidebar & General Styles --- */
        .sidebar-title { border-radius: 7px; border: 2px solid black; padding: 10px; font-weight: 600; font-size: 17px; display: flex; align-items: center; gap: 8px; margin-bottom: 15px; }
        .sidebar-title img { width: 22px; }

        .top-nav-group { display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; }
        .nav-btn { border-radius: 7px; border: 2px solid black; padding: 10px 15px; font-weight: 600; font-size: 17px; color: black; text-decoration: none; text-align: center; flex: 1 1 auto; min-width: 160px; transition: 0.2s; }
        .nav-btn.active { border-color: #ff6600; color: #ff6600; }

        .table-striped tbody tr:nth-of-type(odd) { background-color: white; }
        table.dataTable tbody td { padding: 8px 10px; font-size: 10px; color: black; }
        table.dataTable thead th { border-bottom: 1px solid #111; font-size: 11px; white-space: nowrap; }

        /* Sidebar Scrollbar Fix */
        .main-menu { -ms-overflow-style: none; scrollbar-width: none; overflow-x: hidden !important; }
        .main-menu::-webkit-scrollbar { display: none; }

        @media (max-width: 991px) {
            .nav-btn { width: 100%; }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494; margin: 0;">
            <div class="col-12 bg-white p-2 pl-2">
                <h3 class="h3 mb-1">Invoices</h3>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb p-0 m-0 pb-2 bg-transparent">
                        <li class="breadcrumb-item"><a>Billing</a></li>
                        <li class="breadcrumb-item">Invoices</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row mt-1">
        <div class="col-lg-3 col-12 mb-1">
            <h4 class="sidebar-title"><img src="/wallet.png"> Billing</h4>
        </div>

        <div class="col-lg-9 col-12">
            <div class="top-nav-group">
                <a href="{{ route('vender.subscription.index') }}" class="nav-btn">Subscriptions</a>
                <a href="{{ route('vender.invoice.index') }}" class="nav-btn active">Invoices</a>
            </div>

            <div style="border: 2px solid black; border-radius: 6px; margin-bottom: 30px;">
                <div style="border-bottom: 2px solid black; padding: 10px 15px;">
                    <h3 style="font-size: 20px; color: black; margin: 0;">Invoices</h3>
                </div>

                <div class="search-container">
                    <input type="text" class="form-control search-input" id="myInputTextField" placeholder="Search">
                    <a href="#"><i class="ft-filter" style="font-size: 30px; color: black;"></i></a>
                </div>

                <div class="table-container-custom">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration w-100">
                            <thead>
                                <tr>
                                    <th>Invoice ID</th>
                                    <th>Subscription ID</th>
                                    <th>Product</th>
                                    <th>Plan</th>
                                    <th>Invoice Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscriptions as $account)
                                    <tr>
                                        <td>{{ $account->number }}</td>
                                        <td>S-{{ sprintf('%04d', $account['subscription']['id'] ?? 0) }}</td>
                                        <td>Service Provider App</td>
                                        <td>{{ $account['inv_plan']['name'] ?? '' }}</td>
                                        <td>{{ $account['created_at'] ? \Carbon\Carbon::parse($account['created_at'])->format('d/m/Y') : 'N/A' }}</td>
                                        <td>{{ number_format(($account['amount_due'] ?? 0) / 100, 2) }}</td>
                                        <td>{{ Str::ucfirst($account['status'] ?? 'N/A') }}</td>
                                        <td><a href="{{ route('vender.invoice.detail', $account['id']) }}"><i class="ft-eye"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
            // 1. Force Sidebar Open and fix potential layout shifts
            $('body').removeClass('menu-hide menu-collapsed').addClass('menu-expanded menu-open');
            setTimeout(function() { $(window).trigger('resize'); }, 200);

            // 2. Initialize DataTable with destroy and sorting disabled
            var oTable = $('.zero-configuration').DataTable({
                "destroy": true,   // Prevents re-initialization warning
                "order": [],        // Prevents default sort selection
                "ordering": false,  // Disables sorting feature entirely
                "bPaginate": $('.zero-configuration tbody tr').length > 10,
                "iDisplayLength": 10,
                "bAutoWidth": false,
                "initComplete": function(settings, json) {
                    // Force table to fill container
                    $('.dataTables_wrapper, .dataTable').css('width', '100%', 'important');
                }
            });

            // 3. Bind Search
            $('#myInputTextField').keyup(function() {
                oTable.search($(this).val()).draw();
            });
        });
    </script>
@endsection
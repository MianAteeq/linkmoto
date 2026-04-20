@extends('vender::layouts.master')

@section('css_custom')
    <style>
        /* --- RESPONSIVE FIXES --- */

        /* 1. Ensure Table scrolls horizontally on mobile and doesn't squish data */
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table th,
        .table td {
            white-space: nowrap !important;
            /* Prevents text from stacking vertically */
            vertical-align: middle;
        }

        /* 2. Fix Earnings Cards Alignment & Text Wrapping */
        .media.d-flex {
            align-items: center;
            justify-content: space-between;
        }

        .media-body h3 {
            word-break: break-word;
            font-size: clamp(1.2rem, 4vw, 1.75rem);
            /* Auto-scales text based on screen size */
            margin-bottom: 5px;
        }

        /* 3. Tablet & Mobile adjustments for the filter form (Up to 991px) */
        @media (max-width: 991px) {
            .users-list-filter .row>div {
                margin-bottom: 15px;
                /* Adds space between stacked inputs */
            }

            .users-list-filter .d-flex.align-items-center,
            .users-list-filter .align-items-end {
                align-items: flex-start !important;
                /* Resets alignment on mobile */
            }

            .users-list-filter .btn {
                width: 100%;
                /* Ensures button spans full width on mobile/tablet */
                margin-top: 5px;
            }

            .users-list-filter .row>div:last-child {
                margin-bottom: 0;
            }
        }
    </style>
@endsection

@section('content')
    <section class="users-list-wrapper mt-2">

        <div class="row">
            <div class="col-xl-4 col-lg-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h3 class="danger">£ {{ $total_earning }}</h3>
                                    <h6 class="m-0">Total Earning</h6>
                                </div>
                                <div>
                                    <img src="{{ URL::to('assets/icons/totalearning.png') }}" alt="Total Earning Icon">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h3 class="danger">£ {{ $monthly_earning }}</h3>
                                    <h6 class="m-0">Monthly Earning</h6>
                                </div>
                                <div>
                                    <img src="{{ URL::to('assets/icons/totalearning.png') }}" alt="Monthly Earning Icon">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h3 class="danger">£ {{ $today_earning }}</h3>
                                    <h6 class="m-0">Today Earning</h6>
                                </div>
                                <div>
                                    <img src="{{ URL::to('assets/icons/totalearning.png') }}" alt="Today Earning Icon">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="users-list-filter px-1">
            <form method="GET" action="{{ route('vender.report.search') }}">
                <div class="row border border-light rounded py-2 mb-2 align-items-end">

                    <div class="col-12 col-sm-6 col-lg-3">
                        <label for="invoice_no">Invoice No</label>
                        <input type="text" class="form-control" name="invoice_no" id="invoice_no"
                            placeholder="Invoice #">
                    </div>

                    <div class="col-12 col-sm-6 col-lg-3">
                        <label for="vehicle_no">Vehicle</label>
                        <input type="text" class="form-control" name="vehicle_no" id="vehicle_no"
                            placeholder="Vehicle #">
                    </div>

                    <div class="col-12 col-sm-6 col-lg-3">
                        <label for="status">Status</label>
                        <fieldset class="form-group mb-0">
                            <select class="form-control" name="status" id="status">
                                <option value="ALL">ALL</option>
                                <option value="DUE">Due</option>
                                <option value="PAID">Paid</option>
                            </select>
                        </fieldset>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-3">
                        <button class="btn btn-block btn-primary glow m-0">Show</button>
                    </div>

                </div>
            </form>
        </div>

        <div class="users-list-table">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="users-list-datatable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sr #</th>
                                        <th>Invoice #</th>
                                        <th>Client</th>
                                        <th>Vehicle</th>
                                        <th>Sub Total</th>
                                        <th>Total</th>
                                        <th>Time Stamp</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $invoice)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $invoice['invoice_no'] }}</td>
                                            <td>{{ $invoice['booking']['contact_detail']['name'] }}</td>
                                            <td>{{ $invoice['booking']['vehicle']['vrm'] }}
                                                {{ $invoice['booking']['vehicle']['vin_number'] }}</td>
                                            <td>£ {{ $invoice['sub_total'] }}</td>
                                            <td>£ {{ $invoice['total'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('D m Y') }}</td>

                                            @if ($invoice['status'] == 'PENDING')
                                                <td><span class="badge badge-primary"
                                                        style="background-color: #f26622 !important">{{ $invoice['status'] }}</span>
                                                </td>
                                            @else
                                                <td><span class="badge badge-light">{{ $invoice['status'] }}</span></td>
                                            @endif

                                            <td>
                                                <a href="{{ route('vender.print.invoices', $invoice['id']) }}"><i
                                                        class="la la-eye"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('css_lib')
    <link rel="stylesheet" type="text/css" href="{{ asset('/modules/vender') }}/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/modules/vender') }}/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/modules/vender') }}/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/modules/vender') }}/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/modules/vender') }}/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/modules/vender') }}/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/modules/vender') }}/app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/modules/vender') }}/app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/modules/vender') }}/app-assets/css/pages/page-users.css">
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css">
@endsection

@section('scripts_lib')
    <script src="{{ asset('/modules/vender') }}/app-assets/vendors/js/vendors.min.js"></script>
    <script src="{{ asset('/modules/vender') }}/app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <script src="{{ asset('/modules/vender') }}/app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
    <script src="{{ asset('/modules/vender') }}/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="{{ asset('/modules/vender') }}/app-assets/js/core/app-menu.js"></script>
    <script src="{{ asset('/modules/vender') }}/app-assets/js/core/app.js"></script>
    <script src="{{ asset('/modules/vender') }}/app-assets/js/scripts/ui/breadcrumbs-with-stats.js"></script>
    <script src="{{ asset('/modules/vender') }}/app-assets/js/scripts/pages/page-users.js"></script>
@endsection

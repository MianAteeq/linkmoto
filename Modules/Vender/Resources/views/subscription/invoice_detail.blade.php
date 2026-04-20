@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
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

        /* Accordion Icons positioning */
        .card-header.info {
            position: relative;
            /* Keeps the absolute icons inside the header bounds */
            padding-right: 45px !important;
            /* Prevents text from overlapping icons */
        }

        .collapse-icon [data-toggle="collapse"]:before {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e842" !important;
            transition: all 300ms linear 0s;
        }

        .collapse-icon [data-toggle="collapse"]:after {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e845" !important;
            transition: all 300ms linear 0s;
        }

        /* --- NEW RESPONSIVE ENHANCEMENTS --- */

        /* 1. Prevent JS from freezing the container height */
        #contens {
            height: auto !important;
            min-height: 200px;
        }

        /* 2. Ensure table data doesn't wrap into unreadable vertical columns */
        .table-responsive table th,
        .table-responsive table td {
            white-space: nowrap !important;
        }

        /* 3. Tablet & Mobile Specific Adjustments (Up to 991px) */
        @media (max-width: 991px) {

            /* Adds spacing between the sidebar and main content */
            .col-lg-3 {
                margin-bottom: 25px;
            }

            /* Improve spacing inside the Data Accordions */
            .col-sm-5 h6 {
                margin-bottom: 5px;
                font-weight: bold;
            }

            .col-sm-7 {
                margin-bottom: 15px;
            }

            hr {
                margin-top: 5px;
                margin-bottom: 15px;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3">Invoices</h3>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Billing</a></li>
                        <li class="breadcrumb-item">Invoices</li>
                        <li class="breadcrumb-item">{{ $invoice['number'] }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row mt-3">

        <div class="col-lg-3 col-12 mb-3">
            <div
                style="border-radius: 7px; border: 2px solid black; padding: 15px; display: flex; flex-direction: column; justify-content: space-between; min-height: 180px;">

                <div>
                    <div class="d-flex align-items-start mb-3">
                        <img src="/Invoice.png" style="width: 22px; margin-right: 10px; margin-top: 3px;">
                        <span style="font-weight: 600; font-size: 17px;">{{ $invoice['number'] }}</span>
                    </div>
                    <div style="font-weight: 600; font-size: 15px; margin-bottom: 20px;">
                        <span class="success">{{ ucfirst($invoice['status']) }}</span>
                    </div>
                </div>

                <div class="d-flex flex-column align-items-center w-100"
                    style="border-top: 2px solid black; padding-top: 15px;">
                    @if ($invoice['status'] == 'open')
                        <a href="{{ route('vender.invoice.pay', $invoice['id']) }}" class="w-100 text-center mb-2">
                            <button type="button" style="width: 80%;"
                                class="btn btn-dark round btn-min-width m-0">Pay</button>
                        </a>
                    @endif
                    <a href="{{ $pdf }}" class="w-100 text-center">
                        <button type="button" style="width: 80%;"
                            class="btn btn-dark round btn-min-width m-0">Download</button>
                    </a>
                </div>

            </div>
        </div>

        <div class="col-lg-9 col-12" id="contens"
            style="border-radius: 6px; margin-bottom: 10px; padding-left: 0; padding-right: 0;">

            <div class="card default-collapse collapse-icon accordion-icon-rotate" style="box-shadow: none;">
                <a id="headingCollapse13" class="card-header info mt-2 collapsed"
                    style="border: 2px solid black; border-radius: 7px !important; padding: 1.2rem 1rem; color: black !important;"
                    data-toggle="collapse" href="#collaptr_businesss_info" aria-expanded="false"
                    aria-controls="collaptr_businesss_info">
                    <div class="card-title lead collapsed mb-0">Invoice information</div>
                </a>

                <div id="collaptr_businesss_info" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
                    style="border-left: 2px solid black; margin-top: -4px; border-right: 2px solid black; border-bottom: 2px solid black; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px;"
                    class="collapse" aria-expanded="false">
                    <div class="card-content">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0">ID</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">{{ $invoice['id'] }}</div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0">Subscription Id</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">S-{{ sprintf('%04d', $invoice['subscription']['id']) }}
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0">Product & Plan</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">Service Provider App {{ $invoice['inv_plan']['name'] }}
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0">Invoice Date</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ \Carbon\Carbon::parse($invoice['created_at'])->format('d/m/Y') }}</div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0">Invoice Due Date</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ \Carbon\Carbon::parse($invoice['created_at'])->format('d/m/Y') }}</div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0">Status</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">{{ ucfirst($invoice['status']) }}</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card default-collapse collapse-icon accordion-icon-rotate" style="box-shadow: none;">
                <a id="headingCollapse14" class="card-header info mt-2 collapsed"
                    style="border: 2px solid black; border-radius: 7px !important; padding: 1.2rem 1rem; color: black !important;"
                    data-toggle="collapse" href="#total" aria-expanded="false" aria-controls="total">
                    <div class="card-title lead collapsed mb-0">Invoice Total</div>
                </a>

                <div id="total" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
                    style="border-left: 2px solid black; margin-top: -4px; border-right: 2px solid black; border-bottom: 2px solid black; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px;"
                    class="collapse" aria-expanded="false">
                    <div class="card-content">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0">Subtotal Total (inc VAT)</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">£ {{ number_format($invoice['amount_due'] / 100, 2) }}
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0">Credits</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">£ 0.00</div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0">Total (inc VAT)</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">£ {{ number_format($invoice['amount_due'] / 100, 2) }}
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0">Amount Paid</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">£ {{ number_format($invoice['amount_paid'] / 100, 2) }}
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0">Current Balance</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">£
                                    {{ number_format(($invoice['amount_due'] - $invoice['amount_paid']) / 100, 2) }}</div>
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
            var oTable = $('.zero-configuration').DataTable({
                "destroy": true, // Added destroy: true to prevent re-initialization conflicts
                "bPaginate": $('.zero-configuration tbody tr').length > 10,
                "iDisplayLength": 10,
                "bAutoWidth": false,
                "ordering": false,
            });

            $('#myInputTextField').keyup(function() {
                oTable.search($(this).val()).draw();
            });
        });
    </script>
@endsection

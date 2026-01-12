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
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3">VAT</h3>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Business</a>
                        </li>

                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.business.detail') }}">Detail</a>
                        </li>

                        <li class="breadcrumb-item">VAT
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
                <h4 class="h3"
                    style="font-weight: 600; font-size: 17px;padding: 1.36rem 0.5rem;border-bottom:2px solid; ">
                    <img src="/home.png" style="width: 22px;margin-top: -5px;"> VAT
                </h4>
                <p style="padding-left: 10px; padding-right: 10px; line-height: 1.5rem; color: black; ">

                    @php
                        $status = $user['profile']['vat_info'];

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
                    Created on: {{ $user['profile']->created_at->format('d M Y, H:i') }} <br>
                    Last updated: {{ $user['profile']->updated_at->format('d M Y, H:i') }}
                    @if ($status == 'Rejected')
                        <p
                            style="border-top:2px solid;padding-left: 10px;padding-top: 10px; padding-right: 10px; line-height: 1.5rem; color: black; ">
                            <strong>Rejected reason</strong>: Incorrect VAT
                            number - could not be verified.
                            Please provide valid VAT number.

                        </p>
                    @endif

                </p>

            </div>
        </div>
        <div class="col-md-9" id="contens" style="border-radius: 6px;margin-bottom: 10px;padding-bottom: 10px;">
            <div class="card default-collapse collapse-icon accordion-icon-rotate"
                style="box-shadow: none;margin-top: -19px;">




                <a id="headingCollapse1"  class="card-header info mt-2"
                    style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;"
                    data-toggle="" href="#collaptr_businesss_info" aria-expanded="true">
                    <div class="card-title lead collapsed">VAT</div>
                </a>
                <div id="collaptr_businesss_info" role="tabpanel" aria-labelledby="headingCollapsebusinesss_info"
                    style="border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;"
                    class="collapse show" aria-expanded="false">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0">UK VAT Registered</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ $user['profile']['vat_register'] }}
                                </div>
                            </div>
                            @if ($user['profile']['vat_register'] == 'YES')
                                <hr>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">UK VAT Number</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        {{ $user['profile']['uk_vat_no'] }}
                                    </div>
                                </div>
                            @endif
                            <hr>
                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="mb-0">Status</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ $user['profile']['vat_info'] }}
                                </div>
                            </div>



                        </div>
                        @if ($user['profile']['vat_info'] != 'Pending')
                            <div class="card-footer">
                                <div class="text-secondary" style="text-align: right">
                                    <a href="{{ route('vender.business.vat.update') }}"
                                        style=" background-color: black !important;
                                       border-color: black !important;"
                                        class="btn btn-primary"> Edit</a>
                                </div>
                            </div>
                        @endif
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
        $(document).ready(function() {
            var contentHeight = $('#contens').height();
            $('#contens').height(contentHeight);
        });
    </script>
@endsection

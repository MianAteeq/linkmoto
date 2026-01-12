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

        hr {
            margin-top: 0rem;
            margin-bottom: 0rem;
            border: 0;
            border-top: 2px solid rgba(0, 0, 0, 0.1);
        }

        .accordion .card-header,
        .default-collapse .card-header {

            color: black !important;
            padding: 1rem 1rem !important;
        }

        .card>hr {
            margin-right: 0;
            margin-left: 0;
            height: 0px;
        }

        .card .card-title {
            font-weight: 500;
            letter-spacing: 0.05rem;
            font-size: 1rem;
        }

        input:focus:required:invalid {
            border: 2px solid red;
        }

        input:required:valid {
            border: 2px solid black;
        }

        .form-control {

            border: 2px solid black !important;
            height: calc(1em + 1.4rem + 0px);
            border-radius: 7px;
            width: 60%;

        }

        .collapse-icon [data-toggle="collapse"]:after {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e845";
            transition: all 300ms linear 0s;
            font-size: 18px;
            font-weight: 900;
        }

        .collapse-icon [data-toggle="collapse"]:before {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e842";
            transition: all 300ms linear 0s;
            font-size: 18px;
            font-weight: 900;
        }

        .custom-control-input:checked~.custom-control-label::before {
            color: #fff;
            border-color: #ff6600;
            background-color: #ff6600;
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
                <h4 class="h3" style="font-weight: 600; font-size: 17px;padding: 1rem 0.5rem;border-bottom:2px solid; ">
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
                </p>
                <div class="footers" id="show_help" style="border-top:none;">
                    <h4
                        style="padding-left: 13px;
                        color: black;
                        font-weight: 600;">
                        Help information: </h4>

                    <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                        <div class="card accordion collapse-icon accordion-icon-rotate"
                            style="box-shadow: none;margin-right: 10px;margin-left: 10px;">
                            <a id="business_VAT" class="card-header info collapsed" data-toggle="collapse"
                                href="#collapsebusiness_vat" aria-expanded="false" aria-controls="collapsebusiness_vat">
                                <div class="card-title lead">UK VAT Number (?)</div>
                            </a>
                            <div id="collapsebusiness_vat" data-parent="#accordionWrap1" role="tabpanel"
                                aria-labelledby="business_VAT" class="collapse" style="">
                                <div class="card-content">
                                    <div class="card-body" style="color:black">
                                        A VAT number is a unique identification number given to VAT. registered
                                        businesses. In England,Scotland and Wales, a VAT number is a nine-digit code
                                        with the prefix ‘GB’. VAT numbers are issued by
                                        HMRC.




                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>

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
                        <form method="Post" action="{{ route('vender.business.vat.update') }}">
                            @csrf

                            <div class="card-body">
                                <div class="link-body" style="padding: 10px">
                                    <div class="form-group row">
                                        <label class="col-md-4 label-control">Is your business UK VAT registered <span
                                                style="color: red">*</span> </label>
                                        <div class="col-md-8 mx-auto">
                                            <div class="input-group">
                                                <div class="d-inline-block custom-control custom-radio mr-1">
                                                    <input type="radio" name="vat_register" value="YES"
                                                        class="custom-control-input"
                                                        @if ($user['profile']['vat_register'] == 'YES') checked @endif checked=""
                                                        id="Yes">
                                                    <label class="custom-control-label" for="Yes">Yes</label>
                                                </div>
                                                <div class="d-inline-block custom-control custom-radio">
                                                    <input type="radio" name="vat_register" value="NO"
                                                        @if ($user['profile']['vat_register'] == 'NO') checked @endif
                                                        class="custom-control-input" id="No">
                                                    <label class="custom-control-label" for="No">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row uk-vat-form"
                                        @if ($user['profile']['vat_register'] == 'NO') style="display: none" @endif>
                                        <label class="col-md-4 label-control" for="eventRegInput5">UK VAT Number <span
                                                style="color: red">*</span> </label>
                                        <div class="col-md-8 mx-auto">
                                            <input type="tel" id="uk_vat_no" onkeyup="lookup(this);"
                                                value="{{ $user['profile']['uk_vat_no'] }}" class="form-control"
                                                name="uk_vat_no" required placeholder="">
                                            <p class="text-danger uk_vat_no"
                                                style="padding-left: 10px;width:100%;display: none">UK VAT
                                                Number is Required !</p>
                                        </div>
                                    </div>



                                </div>



                            </div>
                            @if ($user['profile']['vat_info'] != 'Pending')
                                <div class="card-footer">
                                    <div class="text-secondary" style="text-align: right">
                                        <a href="{{ route('vender.business.vat') }}"
                                            style=" background-color: black !important;
                                       border-color: black !important;"
                                            class="btn btn-primary"> Cancel</a>
                                        <button type="submit"
                                            style=" background-color: black !important;
                                       border-color: black !important;"
                                            class="btn btn-primary"> Save</button>
                                    </div>
                                </div>
                            @endif
                        </form>
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
    <script>
        $(document).ready(function() {
            var contentHeight = $('#contens').height();
            $('input[type=radio]').change(function() {
                if (this.value == 'YES') {

                    $('.uk-vat-form').show();
                    $('#uk_vat_no').attr("required", true);

                    $('#contens').height(contentHeight + 70);
                    $('#show_help').show();

                } else {
                    $('.uk-vat-form').hide();
                    $('#uk_vat_no').attr("required", false);

                    $('#contens').height(contentHeight);
                    $('#show_help').hide();

                }
            });
        });
    </script>
@endsection

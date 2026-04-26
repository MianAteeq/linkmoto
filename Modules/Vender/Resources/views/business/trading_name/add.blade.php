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
                           2. YOUR ORIGINAL CSS (Preserved)
                           ======================================================================== */
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
            color: black;
        }

        .dataTables_wrapper .dataTables_info {
            display: none;
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

        /* FOOTER FIX: Increased bottom padding from 12px to 25px */
        .footers {
            border-top: 2px solid black;
            padding: 15px 20px 25px 20px;
            /* Top: 15px, Right: 20px, Bottom: 25px, Left: 20px */
            width: 100%;
            background: white;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;
            margin-top: auto;
            display: flex;
            justify-content: flex-end;
            /* Aligns buttons to the right */
            align-items: center;
            gap: 10px;
            /* Adds space between buttons */
        }

        .btn-dark {
            border-color: black !important;
            background-color: black !important;
            color: #FFFFFF;
            margin: 0 !important;
        }

        .round {
            border-radius: 0.5rem;
        }

        .form-control {
            border: 2px solid black !important;
            height: calc(1em + 1.4rem + 0px);
            border-radius: 7px;
            width: 60%;
        }

        .form-btn {
            text-align: left;
            color: #babfcc;
            width: 60%;
            padding: 7px;
            padding-left: 14px;
            float: left;
        }

        .view-btn {
            float: left;
            margin-top: 0px;
            padding: 9px;
            margin-left: 10px;
            background-color: #ff822f !important;
            border-color: #ff822f !important;
        }

        body {
            color: black;
        }

        .view-btn-black {
            margin-top: 0px;
            padding: 9px;
            margin-left: 10px;
            background-color: black !important;
            border-color: black !important;
        }

        .form-control:focus {
            color: #4e5154;
            background-color: #fff;
            border-color: black;
            outline: 0;
            box-shadow: none;
        }

        body.vertical-layout.vertical-menu.menu-expanded .main-menu {
            width: 274px;
            transition: 300ms ease all;
            backface-visibility: hidden;
        }

        body.vertical-layout.vertical-menu.menu-expanded .content,
        body.vertical-layout.vertical-menu.menu-expanded .footer {
            margin-left: 274px;
        }

        input:focus:required:invalid {
            border: 2px solid red;
        }

        input:required:valid {
            border: 2px solid black;
        }

        @media (max-width: 991.98px) {
            .headerbg {
                padding-left: 25px !important;
            }

            .info-sidebar-wrapper {
                margin-bottom: 20px;
            }

            .form-control {
                width: 100% !important;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494; margin: 0;">
            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3">Add new trading name</h3>
                <div class="breadcrumb-wrapper col-12 p-0">
                    <ol class="breadcrumb" style="padding-left: 0; background-color: transparent; margin-bottom: 10px;">
                        <li class="breadcrumb-item"><a>Business</a>
                        </li>
                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.trading.name') }}">Trading
                                names</a>
                        </li>
                        <li class="breadcrumb-item">Add new trading name
                        </li>
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
                        style="font-weight: 600; font-size: 1.1rem; padding: 12px 16px; margin: 0; display: flex; align-items: center; gap: 10px;  border-radius: 5px 5px 0 0;">
                        <img src="/home.png" style="width: 20px;"> New Trading Name
                    </h4>
                </div>
            </div>

            <div class="col-12 col-md-12 col-lg-9 d-flex ps-lg-3 mb-4 w-100">
                <div class="main-content-box w-100">

                    <form action="{{ route('vender.trading.name.store') }}" id="contens" method="POST"
                        enctype="multipart/form-data" style="display: flex; flex-direction: column; height: 100%;">
                        @csrf

                        <div class="main-content-inner">
                            <div class="row" style="margin-right: 0;margin-left: 0;">
                                <div class="col-md-12" style="border-bottom: 2px solid black;">
                                    <h3 style="font-size: 20px; padding: 1rem 0.7rem; color: black;">
                                        Trading name Information</h3>
                                </div>
                            </div>

                            <div class="link-body" style="padding: 10px">
                                <div class="form-group row">
                                    <label class="col-md-4 label-control" for="eventRegInput5">Trading name * (?)</label>
                                    <div class="col-md-8 mx-auto">
                                        <input type="text" id="name" class="form-control" value=""
                                            onkeyup="lookup(this);" name="name" value="{{ old('name') }}"
                                            placeholder="Trading name ">
                                        <p class="text-danger name"
                                            style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This
                                            Field is Required !</p>
                                        @if ($errors->has('name'))
                                            <p class="text-danger name"
                                                style="padding-left: 10px;width:100%;margin-bottom: -8px;">
                                                {{ $errors->first('name') }}</p>
                                        @else
                                            <p class="text-danger name"
                                                style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">
                                                This Field is Required !</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="footers mt-auto">
                            <a href="{{ redirect()->back()->getTargetUrl() }}" style="text-decoration: none;">
                                <button type="button" class="btn btn-dark round btn-min-width">Cancel</button>
                            </a>
                            <button type="button" onclick="submitDetailsForm()"
                                class="btn btn-dark round btn-min-width">Save</button>
                        </div>

                    </form>
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
                $('.nav-toggle, .menu-toggle').click();
            }
        });
    </script>

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

    <script>
        $(document).ready(function() {
            var contentHeight = $('#contens').height();
            $('#contens').height(contentHeight);
        });
    </script>

    <script>
        $(document).ready(function() {
            var contentHeight = $('#contens').height();
            $('#contens').height(contentHeight);
        });
    </script>

    <script>
        $('.form-btn').click(function() {
            $('input[type=file]').trigger('click');
        });
    </script>

    <script>
        $('input[type=radio]').change(function() {
            if (this.value == 'YES') {
                $('.Poof_div').show();
                var contentHeight = $('#contens').height();
                $('#contens').height(contentHeight);
            } else {
                $('.Poof_div').hide();
                var contentHeight = $('#contens').height();
                $('#contens').height('550px');
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('input[type="file"]').change(function(e) {
                var fileName = e.target.files[0].name;
                $('.form-btn').val(fileName);

                $('.view-btn').show();
                $('#view_file').attr('href', URL.createObjectURL(e.target.files[0]));
                $('.file_proof').hide();
                $(`#proof_of_main_contact`).attr('style', 'border:2px solid black!important');
            });
        });
    </script>

    <script>
        async function lookup(arg) {
            var id = arg.getAttribute('id');
            var value = arg.value;

            let trading_name = $(`#${id}`).val();
            if (id !== "address_line_2" && id !== "city" && id !== "postcode") {
                if (trading_name === "") {
                    $(`#${id}`).attr("style", "border:2px solid red!important;");
                    status = false;
                } else {
                    $(`#${id}`).attr("style", "border:2px solid black!important;");
                    $(`.${id}`).hide();
                }
            } else {
                if (trading_name === "") {
                    $(`#${id}`).attr("style", "border:2px solid red!important;margin-top: 5px ");
                    status = false;
                } else {
                    $(`#${id}`).attr("style", "border:2px solid black!important;margin-top: 5px;");
                    $(`.${id}`).hide();
                }
            }
        }
    </script>

    <script>
        function submitDetailsForm() {
            let name = $(`#name`).val();

            if (name === "") {
                $(`#name`).attr('style', 'border:2px solid red!important');
                status = false;
                return false;
            } else {
                $(`#name`).attr('style', 'border:2px solid black!important');
                status = true;
            }

            $("form").submit();
        }
    </script>
@endsection

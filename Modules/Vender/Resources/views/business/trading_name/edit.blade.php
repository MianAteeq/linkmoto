@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        /* Fix for double scrollbar from master layout */
        .content-wrapper {
            height: auto !important;
            min-height: 84vh !important;
        }

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
            border-top: 2px solid black;
            padding: 12px 20px;
            width: 100%;
            background: white;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;
            margin-top: auto;
        }

        .btn-dark {
            border-color: black !important;
            background-color: black !important;
            color: #FFFFFF !important;
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

        input:focus:required:invalid {
            border: 2px solid red;
        }

        input:required:valid {
            border: 2px solid black;
        }

        /* Custom Containers */
        .info-sidebar {
            border-radius: 7px;
            border: 2px solid black;
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
            width: 100%;
        }

        /* --- RESPONSIVE MEDIA QUERIES --- */
        @media (max-width: 991.98px) {
            .headerbg {
                padding-left: 25px !important;
            }
        }

        @media (max-width: 768px) {
            .form-control {
                width: 100% !important;
            }

            .headerbg {
                padding-left: 15px !important;
            }

            .footers {
                padding-bottom: 15px;
            }

            .footers .btn-dark {
                float: none !important;
                width: 100%;
                display: block;
                margin-top: 10px;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494; margin: 0;">
            <div class="col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3">Edit trading name</h3>

                <div class="breadcrumb-wrapper p-0">
                    <ol class="breadcrumb" style="padding-left: 0; background-color: transparent; margin-bottom: 10px;">
                        <li class="breadcrumb-item"><a>Business</a></li>
                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.trading.name') }}">Trading names</a></li>
                        <li class="breadcrumb-item">Edit trading name</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid px-1 px-md-1 mt-1">
        <div class="row align-items-stretch" style="padding-left: 0 !important;">

            <div class="col-12 col-lg-3 d-flex mb-3 mb-lg-0">
                <div class="info-sidebar d-flex flex-column">
                    <h4
                        style="font-weight: 600; font-size: 1.1rem; padding: 12px 16px; margin: 0; display: flex; align-items: center; gap: 10px; background-color: white; border-radius: 5px 5px 0 0; border-bottom: 2px solid black;">
                        <img src="/home.png" style="width: 20px; margin-top: -2px;"> Edit Trading Name
                    </h4>
                </div>
            </div>

            <div class="col-12 col-lg-9 d-flex ps-lg-3 mb-4">
                <div class="main-content-box">

                    <div class="row" style="margin-right: 0;margin-left: 0;">
                        <div class="col-md-12" style="border-bottom: 2px solid black;">
                            <h3 style="font-size: 20px; padding: 12px 20px; margin: 0; color: black;">
                                Trading name Information
                            </h3>
                        </div>
                    </div>

                    <form action="{{ route('vender.trading.name.update') }}" id="contens" method="POST"
                        enctype="multipart/form-data" style="display: flex; flex-direction: column; flex-grow: 1;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $trading_name['id'] }}">

                        <div class="link-body" style="padding: 20px; flex-grow: 1;">

                            <div class="form-group row">
                                <label class="col-12 col-md-4 label-control" for="eventRegInput5">ID</label>
                                <div class="col-12 col-md-8 mx-auto" style="margin-top: 5px;">
                                    {{ $trading_name['id'] }}
                                </div>
                            </div>

                            <div class="form-group row mt-2">
                                <label class="col-12 col-md-4 label-control" for="eventRegInput5">Trading name * (?)</label>
                                <div class="col-12 col-md-8 mx-auto">
                                    <input type="text" id="name" class="form-control"
                                        value="{{ $trading_name['name'] }}" onkeyup="lookup(this);" name="name"
                                        placeholder="Trading name ">

                                    @if ($errors->has('name'))
                                        <p class="text-danger name"
                                            style="padding-left: 10px;width:100%;margin-bottom: -8px;">
                                            {{ $errors->first('name') }}</p>
                                    @else
                                        <p class="text-danger name"
                                            style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This
                                            Field is Required !</p>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="footers mt-auto text-right" style="text-align: right; margin-bottom: 15px;">
                            <button type="button" onclick="submitDetailsForm()"
                                class="btn btn-dark round btn-min-width mr-1 mb-1 m-md-0"
                                style="color: white !important;">Update</button>
                            <a href="{{ redirect()->back()->getTargetUrl() }}">
                                <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1 m-md-0"
                                    style="color: white !important;">Cancel</button>
                            </a>
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
        $('.form-btn').click(function() {
            $('input[type=file]').trigger('click');
        });
    </script>
    <script>
        $('input[type=radio]').change(function() {
            if (this.value == 'YES') {
                $('.Poof_div').show();
            } else {
                $('.Poof_div').hide();
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

            let file = $('input[type=file]').val();
            if (file === "" && @json($trading_name['proof'] == null)) {
                $(`#proof_of_main_contact`).attr('style', 'border:2px solid red!important');
                status = false;
                return false;
            } else {
                $("form").submit();
            }
        }
    </script>
@endsection

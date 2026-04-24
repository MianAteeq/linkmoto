@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        /* Table Resets (Kept for your global consistency) */
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

        /* Icons & Structural */
        #headingCollapse14:before,
        .collapse-icon [data-toggle="collapse"]:before {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e843";
            transition: all 300ms linear 0s;
        }

        .collapse-icon [data-toggle="collapse"]:after {
            content: "\e845";
        }

        .collapsed {
            border-bottom-left-radius: 0px !important;
            border-bottom-right-radius: 0px !important;
        }

        /* Custom Containers */
        .info-sidebar {
            border-radius: 7px;
            border: 2px solid black;
            height: 100%;
        }

        .main-content-box {
            border: 2px solid black;
            border-radius: 6px;
            margin-bottom: 10px;
            padding: 0;
            display: flex;
            flex-direction: column;
            background-color: white;
        }

        .main-content-inner {
            flex-grow: 1;
            padding: 15px 20px;
        }

        .footers {
            border-top: 2px solid black;
            padding: 15px 15px 10px 15px;
            width: 100%;
            background: white;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;
        }

        /* Buttons and Forms */
        .btn-dark {
            border-color: black !important;
            background-color: black !important;
            color: #FFFFFF;
        }

        .round {
            border-radius: 0.5rem;
        }

        .form-control {
            border: 2px solid black !important;
            height: calc(1em + 1.4rem + 0px);
            border-radius: 7px;
            width: 100%;
        }

        .form-btn {
            text-align: left;
            color: #babfcc;
            width: 37%;
            padding: 7px;
            padding-left: 14px;
            float: left;
        }

        .view-btn,
        .view-btn-black {
            margin-top: 0px;
            padding: 9px;
            margin-left: 10px;
        }

        .view-btn {
            float: left;
            background-color: #ff822f !important;
            border-color: #ff822f !important;
        }

        .view-btn-black {
            background-color: black !important;
            border-color: black !important;
        }

        body {
            color: black;
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

        /* --- RESPONSIVE MEDIA QUERIES --- */
        /* Changed breakpoint from 767px to 991px to catch tablet sizes */
        @media (max-width: 991.98px) {
            .headerbg {
                padding-left: 25px !important;
            }

            .info-sidebar-wrapper {
                margin-bottom: 25px;
                /* Adds space between the stacked containers */
            }

            /* Stack labels above inputs for maximum width inside the form */
            .form-group.row {
                flex-direction: column !important;
                align-items: flex-start !important;
            }

            .form-group.row .col-md-4,
            .form-group.row .col-md-8 {
                max-width: 100% !important;
                flex: 0 0 100% !important;
                width: 100% !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            .form-group.row .col-md-8 {
                margin-top: 5px;
            }

            .footers .btn-dark {
                float: none !important;
                width: 100%;
                display: block;
                margin-bottom: 10px !important;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row m-0" style="border-bottom: 3px solid #949494;">
            <div class="col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3">User</h3>
                <div class="breadcrumb-wrapper col-12 p-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Directory</a></li>
                        <li class="breadcrumb-item"><a style="color: black" href="{{ route('vender.user') }}">Users</a></li>
                        <li class="breadcrumb-item">Edit user information</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        {{-- Removed col-md-4, added mb-4 mb-lg-0 to space them out when stacked --}}
        <div class="col-12 col-lg-3 info-sidebar-wrapper mb-4 mb-lg-0">
            <div class="info-sidebar">
                <h4 class="h3" style="font-weight: 600; font-size: 17px;padding: 10px; margin: 0;">
                    <img src="/user.png" style="width: 22px;margin-top: -5px;"> Edit User
                </h4>
            </div>
        </div>

        {{-- Removed col-md-8 --}}
        <div class="col-12 col-lg-9">
            <div class="main-content-box">
                <div class="row m-0" style="border-bottom: 2px solid black;">
                    <div class="col-12 p-0">
                        <h3 style="font-size: 20px; padding: 10px 15px; color: black; margin: 0;">User Information</h3>
                    </div>
                </div>

                <form action="{{ route('vender.user.update') }}" id="contens" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user['id'] }}">

                    <div class="main-content-inner">

                        <div class="form-group row align-items-center">
                            <label class="col-md-4 label-control" for="name">First name *</label>
                            <div class="col-md-8">
                                <input type="text" id="name" class="form-control" value="{{ $user['name'] }}"
                                    onkeyup="lookup(this);" name="name" placeholder="First name">
                                <p class="text-danger name"
                                    style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This
                                    Field is Required !</p>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-md-4 label-control" for="middle_name">Middle name </label>
                            <div class="col-md-8">
                                <input type="text" id="middle_name" class="form-control"
                                    value="{{ $user['middle_name'] }}" name="middle_name" placeholder="Middle name ">
                                <p class="text-danger middle_name"
                                    style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">This Field is
                                    Required !</p>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-md-4 label-control" for="last_name">Last name *</label>
                            <div class="col-md-8">
                                <input type="text" id="last_name" class="form-control" value="{{ $user['last_name'] }}"
                                    onkeyup="lookup(this);" name="last_name" placeholder="Last name">
                                <p class="text-danger last_name"
                                    style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">
                                    This Field is Required !</p>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-md-4 label-control" for="email">Email * </label>
                            <div class="col-md-8">
                                <input type="email" id="email" class="form-control" value="{{ $user['email'] }}"
                                    onkeyup="lookup(this);" name="email" placeholder="Email">
                                <p class="text-danger email"
                                    style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">
                                    Invalid Email !</p>
                                @if ($errors->has('email'))
                                    <p class="text-danger email" style="padding-left: 10px;width:100%;margin-bottom: -8px;">
                                        {{ $errors->first('email') }}</p>
                                @endif
                            </div>
                        </div>

                        @if (auth()->user()->id == $user['id'])
                            <div class="form-group row align-items-center">
                                <label class="col-md-4 label-control" for="phone_no">Mobile * </label>
                                <div class="col-md-8">
                                    <input type="tel" id="phone_no" class="form-control"
                                        value="{{ $user['profile']['phone_no'] ?? '' }}" onkeyup="lookup(this);"
                                        name="phone_no" placeholder="Mobile">
                                    <p class="text-danger phone_no"
                                        style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">
                                        This Field is Required !</p>
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label class="col-md-4 label-control" for="landline">Landline </label>
                                <div class="col-md-8">
                                    <input type="tel" id="landline" class="form-control"
                                        value="{{ $user['profile']['landline'] ?? '' }}" onkeyup="lookup(this);"
                                        name="landline" placeholder="Landline">
                                    <p class="text-danger landline"
                                        style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">
                                        This Field is Required !</p>
                                </div>
                            </div>
                        @else
                            <div class="form-group row align-items-center">
                                <label class="col-md-4 label-control" for="phone_no">Mobile * </label>
                                <div class="col-md-8">
                                    <input type="tel" id="phone_no" class="form-control"
                                        value="{{ $user['phone_no'] }}" onkeyup="lookup(this);" name="phone_no"
                                        placeholder="Mobile">
                                    <p class="text-danger phone_no"
                                        style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">
                                        This Field is Required !</p>
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label class="col-md-4 label-control" for="landline">Landline </label>
                                <div class="col-md-8">
                                    <input type="tel" id="landline" class="form-control"
                                        value="{{ $user['landline'] }}" onkeyup="lookup(this);" name="landline"
                                        placeholder="Landline">
                                    <p class="text-danger landline"
                                        style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px;">
                                        This Field is Required !</p>
                                </div>
                            </div>
                        @endif

                    </div>

                    <div class="footers">
                        <button type="button" onclick="submitDetailsForm()"
                            class="btn btn-dark round btn-min-width float-md-right mr-md-1 mb-1 mb-md-0">Update</button>
                        <a href="{{ redirect()->back()->getTargetUrl() }}">
                            <button type="button"
                                class="btn btn-dark round btn-min-width float-md-right mr-md-1 mb-1 mb-md-0">Cancel</button>
                        </a>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/modules/admin/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>

    <script>
        // DataTable check
        if ($('.zero-configuration').length > 0) {
            oTable = $('.zero-configuration').DataTable({
                "destroy": true,
                "bPaginate": $('.zero-configuration tbody tr').length > 10,
                "iDisplayLength": 10,
                "bAutoWidth": false,
                "ordering": false,
            });
            $('#myInputTextField').keyup(function() {
                oTable.search($(this).val()).draw();
            });
        }
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
            let array = ['name', 'last_name', 'email', 'phone_no'];
            let status = true;

            array.forEach((item) => {
                let element = $(`#${item}`);
                if (element.length) {
                    let name = element.val();
                    if (name === "") {
                        element.attr('style', 'border:2px solid red!important');
                        status = false;
                    } else {
                        element.attr('style', 'border:2px solid black!important');
                    }
                }
            });

            if (status === true) {
                let radioStatus = $('input[type=radio]:checked').val();
                if (radioStatus === "YES") {
                    let file = $('input[type=file]').val();
                    if (file === "" || file === undefined) {
                        $(`#proof_of_main_contact`).attr('style', 'border:2px solid red!important');
                        status = false;
                        return false;
                    } else {
                        status = true;
                    }
                } else {
                    status = true;
                }

                let email = $(`#email`).val();
                if (validateEmail(email) === null) {
                    $(`#email`).attr('style', 'border:2px solid red!important');
                    $('.email').show();
                    return false;
                } else {
                    $('.email').hide();
                }

                if (status === true) {
                    $("form").submit();
                }
            }
        }
    </script>

    <script>
        const validateEmail = (email) => {
            return String(email)
                .toLowerCase()
                .match(
                    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                );
        };
    </script>
@endsection

@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        /* --- DATATABLES UI HIDING --- */
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
            padding: 8px 10px 2px 10px;
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

        /* --- ACCORDION ICONS --- */
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

        /* --- SIDEBAR SCROLLBAR FIXES --- */
        .main-menu {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
            overflow-x: hidden !important;
        }

        .main-menu::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari and Opera */
        }

        .main-menu-content {
            overflow-x: hidden !important;
        }

        /* --- GENERAL STYLES --- */
        .footers {
            bottom: 0;
            left: 0;
            border-top: 2px solid black;
            padding-top: 5px;
            padding-bottom: 15px;
            width: 100%;
            background-color: #fff;
        }

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
            width: 60%;
            /* Desktop Width */
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

        .form-btn {
            text-align: left;
            color: #babfcc;
            width: 37%;
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

        .view-btn-black {
            margin-top: 0px;
            padding: 9px;
            margin-left: 10px;
            background-color: black !important;
            border-color: black !important;
        }

        body {
            color: black;
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

        /* --- RESPONSIVE ENHANCEMENTS --- */
        @media (max-width: 991px) {
            .form-control {
                width: 100% !important;
                /* Force inputs to take full width on mobile/tablet */
            }

            .footers {
                position: relative;
                padding: 15px !important;
                display: flex !important;
                flex-direction: column;
                /* Stacks buttons */
                align-items: center;
                /* Centers items horizontally */
            }

            .footers a {
                width: 100%;
                display: block;
            }

            .footers .btn {
                width: 100% !important;
                float: none !important;
                margin: 5px 0 !important;
                /* Removes left/right margins causing overflow */
                display: block;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3 mb-1">Add new user group</h3>

                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb p-0 m-0 pb-2 bg-transparent">
                        <li class="breadcrumb-item"><a>Products</a></li>
                       <li class="breadcrumb-item">
                            <a style="text-decoration: none; color: black;"
                                href="{{ route('vender.service.provider.trading.unit') }}">Service Provider</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a style="text-decoration: none; color: black;"
                                href="{{ route('vender.service.provider.app.setting') }}">App settings</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('vender.service.provider.user.group')}}">User groups</a>
                        </li>
                        <li class="breadcrumb-item"><a> Add new user group</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-12 mb-3">
            <div style="border-radius: 7px;border: 2px solid black;">
                <h4 class="h3 d-flex align-items-center"
                    style="font-weight: 600; font-size: 17px;padding: 10px; margin: 0;">
                    <img src="/group.png" style="width: 22px; margin-right: 8px;"> New user group
                </h4>
            </div>
        </div>

        <div class="col-lg-9 col-md-12" style="border: 2px solid black;border-radius: 6px;margin-bottom: 10px;padding: 0;">
            <div class="row" style="margin-right: 0;margin-left: 0;">
                <div class="col-md-12" style="border-bottom: 2px solid black;">
                    <h3 style="font-size: 20px; padding: 10px; color: black; margin: 0;">User group information</h3>
                </div>
            </div>

            <form action="{{ route('vender.service.provider.user.group.store') }}" id="contens" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="link-body" style="padding: 15px;">

                    <div class="form-group row">
                        <label class="col-lg-4 col-md-12 label-control" for="eventRegInput5">User group name * (?)</label>
                        <div class="col-lg-8 col-md-12 mx-auto">
                            <input type="text" id="name" class="form-control" value="" onkeyup="lookup(this);"
                                name="name" placeholder="First name">
                            @if ($errors->has('name'))
                                <p class="text-danger name"
                                    style="padding-left: 10px;width:100%;margin-bottom: -8px; margin-top: 5px;">
                                    {{ $errors->first('name') }}</p>
                            @else
                                <p class="text-danger name"
                                    style="padding-left: 10px;width:100%;display: none;margin-bottom: -8px; margin-top: 5px;">
                                    This Field is Required !</p>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-md-12 label-control" for="eventRegInput5">User group type * (?)</label>
                        <div class="col-lg-8 col-md-12 mx-auto">
                            <span style="padding-left: 5px;">Custom</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-md-12 label-control" for="eventRegInput5">Permission</label>
                        <div class="col-lg-8 col-md-12 mx-auto">
                            <p class="text-danger permissions" style="width:100%;display: none;margin-bottom: -8px;">Please
                                Check At Least One Permission !</p>
                        </div>
                    </div>

                    @foreach ($permissions as $key => $permission)
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-12 label-control" for="eventRegInput5">{{ $key }}</label>
                            <div class="col-lg-8 col-md-12 mx-auto">
                                <div class="row">
                                    @foreach ($permissions[$key] as $per)
                                        <div class="col-lg-6 col-md-12 mb-1">
                                            <fieldset class="checkboxsas">
                                                <label class="d-flex align-items-center">
                                                    <input type="checkbox" class="permission_id" name="permission_id[]"
                                                        style="margin-right: 8px;" value="{{ $per['id'] }}">
                                                    {{ ucwords($per['name']) }}
                                                </label>
                                            </fieldset>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="footers px-3">
                    <button type="button" onclick="submitDetailsForm()" class="btn btn-dark round btn-min-width m-1"
                        style="float: right;">Save</button>
                    <a href="{{ redirect()->back()->getTargetUrl() }}">
                        <button type="button" class="btn btn-dark round btn-min-width m-1"
                            style="float: right;">Cancel</button>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="/modules/admin/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>

    <script>
        $(document).ready(function() {
            // Force sidebar to open automatically on page load to fix mobile collapse issue
            $('body').removeClass('menu-hide menu-collapsed').addClass('menu-expanded menu-open');

            // Trigger a slight delay window resize to snap layouts to the newly opened sidebar
            setTimeout(function() {
                $(window).trigger('resize');
            }, 200);

            // File input triggers (Kept from original code)
            $('input[type="file"]').change(function(e) {
                var fileName = e.target.files[0].name;
                $('.form-btn').val(fileName);
                $('.view-btn').show();
                $('#view_file').attr('href', URL.createObjectURL(e.target.files[0]));
                $('.file_proof').hide();
                $(`#proof_of_main_contact`).attr('style', 'border:2px solid black!important');
            });
        });

        $('.form-btn').click(function() {
            $('input[type=file]').trigger('click');
        });

        $('input[type=radio]').change(function() {
            if (this.value == 'YES') {
                $('.Poof_div').show();
            } else {
                $('.Poof_div').hide();
            }
        });

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

        function submitDetailsForm() {
            let array = ['name'];
            let status = false;

            array.some((item) => {
                let name = $(`#${item}`).val();
                if (name === "") {
                    $(`#${item}`).attr('style', 'border:2px solid red!important');
                    status = false;
                    return false;
                } else {
                    $(`#${item}`).attr('style', 'border:2px solid black!important');
                    status = true;
                }
            });

            let checked = $('.permission_id').is(':checked');

            if (checked == false) {
                $('.permissions').show();
                return;
            } else {
                $('.permissions').hide();
            }

            if (status == true) {
                $("form").submit();
            }
        }
    </script>
@endsection

@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        /* ========================================================================
       1. TABLE STYLES (Preserved for global consistency)
       ======================================================================== */
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

        /* ========================================================================
       2. ICONS & COLLAPSE STYLES
       ======================================================================== */
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

        /* ========================================================================
       3. CONTAINER & UI STYLES
       ======================================================================== */
        body {
            color: black;
        }

        .info-sidebar {
            border-radius: 7px;
            border: 2px solid black;
            background-color: white;
            padding: 12px 16px;
            display: flex;
            align-items: center;
        }

        .main-content-box {
            border: 2px solid black;
            border-radius: 6px;
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
            background-color: white;
            width: 100%;
        }

        .footers {
            border-top: 2px solid black;
            padding: 15px 20px;
            width: 100%;
            background: white;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;
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

        .form-control {
            border: 2px solid black !important;
            height: calc(1em + 1.4rem + 0px);
            border-radius: 7px;
            width: 100%;
            /* Fixed: Removed 60% hardcoded width */
            color: black;
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

        .label-control {
            font-weight: 500;
        }

        /* ========================================================================
       4. RESPONSIVE MEDIA QUERIES (Tablet & Mobile Stacking)
       ======================================================================== */
        @media (max-width: 991.98px) {
            .headerbg {
                padding-left: 25px !important;
            }

            .info-sidebar-wrapper {
                margin-bottom: 20px;
            }

            /* Stack labels above inputs */
            .form-group.row {
                flex-direction: column !important;
                margin-bottom: 15px;
            }

            .form-group.row .col-md-4,
            .form-group.row .col-md-8 {
                width: 100% !important;
                max-width: 100% !important;
                flex: 0 0 100% !important;
                padding-left: 15px !important;
                padding-right: 15px !important;
            }

            .form-group.row .col-md-8 {
                margin-top: 5px;
            }

            /* Make buttons full width */
            .footers {
                flex-direction: column;
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
        <div class="row m-0" style="border-bottom: 3px solid #949494;">
            <div class="col-12 bg-white headerbg" style="padding-left: 32px;padding-top: 13px;">
                <h3 class="h3">Add new user group</h3>
                <div class="breadcrumb-wrapper col-12 p-0">
                    <ol class="breadcrumb" style="padding-left: 0; background-color: transparent;">
                        <li class="breadcrumb-item"><a>Products</a></li>
                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.app.setting') }}">Business Manager</a></li>
                        <li class="breadcrumb-item"><a style="color: black" href="{{ route('vender.app.setting') }}">App
                                settings</a></li>
                        <li class="breadcrumb-item"><a style="color: black" href="{{ route('vender.user.group') }}">User
                                groups</a></li>
                        <li class="breadcrumb-item">Add new user group</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid px-1 px-md-1 mt-1">
        <div class="row align-items-start m-0">

            {{-- Left Sidebar Card --}}
            <div class="col-12 col-lg-3 info-sidebar-wrapper mb-4 mb-lg-0 p-0 pr-lg-3">
                <div class="info-sidebar">
                    <h4 class="h3 m-0 d-flex align-items-center" style="font-weight: 600; font-size: 17px;">
                        <img src="/group.png" style="width: 22px; margin-right: 8px;"> New user group
                    </h4>
                </div>
            </div>

            {{-- Right Content Container --}}
            <div class="col-12 col-lg-9 p-0">
                <form action="{{ route('vender.user.group.store') }}" id="contens" method="POST"
                    enctype="multipart/form-data" class="main-content-box">
                    @csrf

                    {{-- Form Header --}}
                    <div style="border-bottom: 2px solid black; padding: 12px 20px;">
                        <h3 style="font-size: 20px; color: black; margin: 0;">User group information</h3>
                    </div>

                    {{-- Form Body --}}
                    <div class="link-body" style="padding: 20px">

                        <div class="form-group row align-items-center">
                            <label class="col-md-4 label-control">User group name * (?)</label>
                            <div class="col-md-8">
                                <input type="text" id="name" class="form-control" value=""
                                    onkeyup="lookup(this);" name="name" placeholder="User group name">
                                @if ($errors->has('name'))
                                    <p class="text-danger name"
                                        style="padding-left: 10px; width:100%; margin-top: 5px; margin-bottom: 0;">
                                        {{ $errors->first('name') }}</p>
                                @else
                                    <p class="text-danger name"
                                        style="padding-left: 10px; width:100%; display: none; margin-top: 5px; margin-bottom: 0;">
                                        This Field is Required !</p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-md-4 label-control">User group type * (?)</label>
                            <div class="col-md-8" style="font-weight: 500;">
                                Custom
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 label-control">Permission *</label>
                            <div class="col-md-8">
                                <p class="text-danger permissions"
                                    style="width:100%; display: none; margin-bottom: 5px; font-weight: 600;">Please Check At
                                    Least One Permission !</p>
                            </div>
                        </div>

                        {{-- Dynamic Permissions --}}
                        @foreach ($permissions as $key => $permission)
                            <div class="form-group row">
                                <label class="col-md-4 label-control" style="font-weight: 600;">{{ $key }}</label>
                                <div class="col-md-8">
                                    <div class="row m-0">
                                        @foreach ($permissions[$key] as $per)
                                            {{-- Changed to col-12 col-md-6 col-xl-4 to stack checkboxes perfectly on smaller screens --}}
                                            <div class="col-12 col-md-6 col-xl-4 p-0 pr-2 mb-2">
                                                <fieldset class="checkboxsas">
                                                    <label
                                                        style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
                                                        <input type="checkbox" class="permission_id" name="permission_id[]"
                                                            value="{{ $per['id'] }}" style="margin-top: 4px;">
                                                        <span
                                                            style="word-break: break-word; line-height: 1.3;">{{ $per['name'] }}</span>
                                                    </label>
                                                </fieldset>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    {{-- Footers --}}
                    <div class="footers">
                        {{-- Changed from float to Flexbox gap --}}
                        <a href="{{ route('vender.user.group') }}" style="text-decoration: none;">
                            <button type="button" class="btn btn-dark round btn-min-width">Cancel</button>
                        </a>
                        <button type="button" onclick="submitDetailsForm()"
                            class="btn btn-dark round btn-min-width">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/modules/admin/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>

    <script>
        // Prevent initialization errors if the table doesn't exist on this form page
        $(document).ready(function() {
            if ($('.zero-configuration').length > 0) {
                var oTable = $('.zero-configuration').DataTable({
                    "bPaginate": $('.zero-configuration tbody tr').length > 10,
                    "iDisplayLength": 10,
                    "bAutoWidth": false,
                    "ordering": false,
                });
                $('#myInputTextField').keyup(function() {
                    oTable.search($(this).val()).draw();
                });
            }
        });
    </script>

    <script>
        // General lookup function for required text fields
        async function lookup(arg) {
            var id = arg.getAttribute('id');
            let trading_name = $(`#${id}`).val().trim();

            if (trading_name === "") {
                $(`#${id}`).attr("style", "border:2px solid red!important;");
                $(`.${id}`).show();
            } else {
                $(`#${id}`).attr("style", "border:2px solid black!important;");
                $(`.${id}`).hide();
            }
        }
    </script>

    <script>
        function submitDetailsForm() {
            let array = ['name'];
            let status = true;

            // Check required text inputs
            array.forEach((item) => {
                let nameVal = $(`#${item}`).val().trim();
                if (nameVal === "") {
                    $(`#${item}`).attr('style', 'border:2px solid red!important');
                    $(`.${item}`).show();
                    status = false;
                } else {
                    $(`#${item}`).attr('style', 'border:2px solid black!important');
                    $(`.${item}`).hide();
                }
            });

            // Check if at least one permission checkbox is selected
            let isChecked = $('.permission_id').is(':checked');
            if (!isChecked) {
                $('.permissions').show();
                status = false;
            } else {
                $('.permissions').hide();
            }

            // Final Submission
            if (status) {
                $("#contens").submit();
            }
        }
    </script>
@endsection

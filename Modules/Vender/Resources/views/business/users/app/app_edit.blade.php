@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        /* ========================================================================
       1. TABLE & UI STYLES
       ======================================================================== */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info {
            display: none !important;
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
            font-size: 10px;
            color: black;
            vertical-align: middle;
        }

        /* ========================================================================
       2. ICONS & ACCORDION
       ======================================================================== */
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

        /* ========================================================================
       3. CONTAINER & FORM STYLES
       ======================================================================== */
        body {
            color: black;
        }

        .info-sidebar {
            border-radius: 7px;
            border: 2px solid black;
            background-color: white;
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
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
        }

        .btn-dark {
            border-color: black !important;
            background-color: black !important;
            color: #FFFFFF !important;
        }

        .round {
            border-radius: 0.5rem;
        }

        .success {
            color: #28a745;
            font-weight: bold;
        }

        .form-control {
            border: 2px solid #000000 !important;
            color: #000000;
            width: 100%;
            /* Mobile default */
            max-width: 400px;
            /* Desktop limit */
        }

        /* ========================================================================
       4. RESPONSIVE MEDIA QUERIES
       ======================================================================== */
        @media (max-width: 991.98px) {
            .headerbg {
                padding-left: 25px !important;
            }

            .info-sidebar-wrapper {
                margin-bottom: 20px;
            }

            .col-lg-9 {
                padding-left: 0 !important;
                padding-right: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }

            /* Center sidebar content on mobile */
            .info-sidebar h4 {
                text-align: left;
            }

            .footers {
                flex-direction: column;
            }

            .footers .btn-dark,
            .footers a {
                width: 100% !important;
                display: block !important;
                margin: 0 !important;
            }

            .form-control {
                max-width: 100% !important;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row m-0" style="border-bottom: 3px solid #949494;">
            {{-- Fixed alignment: 2 Rows, flush left --}}
            <div class="col-12 bg-white headerbg" style="padding: 15px 32px;">
                <h3 class="h3 mb-1" style="font-weight: 600; color: black;">User</h3>
                <div class="breadcrumb-wrapper p-0">
                    <ol class="breadcrumb m-0 p-0" style="background-color: transparent;">
                        <li class="breadcrumb-item"><a>Directory</a></li>
                        <li class="breadcrumb-item">Users</li>
                        <li class="breadcrumb-item">{{ $user['name'] }} {{ $user['middle_name'] }} {{ $user['last_name'] }}
                        </li>
                        <li class="breadcrumb-item">App</li>
                        <li class="breadcrumb-item">{{ $app['app_name'] }}</li>
                        <li class="breadcrumb-item active">Edit user app settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid px-1 px-md-1 mt-1">
        <div class="row align-items-start m-0">

            {{-- Left Sidebar Profile Card --}}
            <div class="col-12 col-lg-3 info-sidebar-wrapper mb-4 mb-lg-0 p-0 pr-lg-3">
                <div class="info-sidebar">
                    <div
                        style="font-weight: 600; font-size: 17px; padding: 12px 16px; border-bottom: 2px solid black; display: flex; align-items: flex-start;">
                        <div style="width: 15%; margin-top: 2px;"><img src="/user.png" style="width: 22px;"></div>
                        <div style="width: 85%; padding-left: 5px;"><span>{{ $user['name'] }} {{ $user['middle_name'] }}
                                {{ $user['last_name'] }}</span></div>
                    </div>

                    <div style="padding: 20px; flex-grow: 1;">
                        <div class="mb-3" style="font-weight: 500; font-size: 13px; word-break: break-all;">
                            <span>{{ $user['email'] }}</span>
                        </div>
                        <div class="mb-2"><span class="success">{{ $user['status'] }}</span></div>
                        <div class="mb-3" style="font-weight: 500; font-size: 13px;">
                            <span>Last sign in:
                                {{ \Carbon\Carbon::parse($user['updated_at'])->format('d/m/Y \a\t h:i') }}</span>
                        </div>
                        <div style="font-weight: 500; font-size: 13px; color: #555;">
                            <span>Created:
                                {{ \Carbon\Carbon::parse($user['created_at'])->format('d/m/Y \a\t h:i') }}</span>
                        </div>
                    </div>

                    {{-- Action Buttons Footer (Vertical Stack Fix) --}}
                    <div class="footers"
                        style="flex-direction: column; gap: 12px; padding: 15px; border-radius: 0 0 5px 5px;">
                        <a href="{{ route('vender.user.password', $user['id']) }}" class="w-100"><button type="button"
                                class="btn btn-dark round w-100 m-0">RESET PASSWORD</button></a>
                        <a href="{{ route('vender.user.edit', $user['id']) }}" class="w-100"><button type="button"
                                class="btn btn-dark round w-100 m-0">UPDATE USER</button></a>
                        <a href="{{ route('vender.user.suspend', $user['id']) }}" class="w-100"><button type="button"
                                class="btn btn-dark round w-100 m-0">SUSPEND USER</button></a>
                        @if ($user['status'] != 'ACTIVE')
                            <a href="{{ route('vender.user.active', $user['id']) }}" class="w-100"><button type="button"
                                    class="btn btn-dark round w-100 m-0">ACTIVATE USER</button></a>
                        @else
                            <a href="{{ route('vender.user.in.active', $user['id']) }}" class="w-100"><button
                                    type="button" class="btn btn-dark round w-100 m-0">INACTIVATE USER</button></a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right Content Container --}}
            <div class="col-12 col-lg-9 p-0">
                <form action="{{ route('vender.user.app.update') }}" method="POST" enctype="multipart/form-data"
                    class="main-content-box" id="userAppForm">
                    @csrf
                    <input type="hidden" name="id" value="{{ $app['id'] }}">

                    {{-- Form Header --}}
                    <div style="border-bottom: 2px solid black; padding: 12px 20px;">
                        <h3 style="font-size: 20px; color: black; margin: 0;">Edit user app settings</h3>
                    </div>

                    <div class="link-body" style="padding: 20px">

                        <div class="form-group row align-items-center">
                            <label class="col-md-4 label-control">App *</label>
                            <div class="col-md-8">
                                <p class="m-0 font-weight-bold">{{ $app['app_name'] }}</p>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-md-4 label-control" for="status">Status *</label>
                            <div class="col-md-8">
                                <select id="status" name="status" @if ($is_edit_able == 'off') disabled @endif
                                    class="form-control">
                                    <option value="none" selected disabled>Select Status</option>
                                    <option value="0" @if ($app['status'] == 0) selected @endif>Off</option>
                                    <option value="1" @if ($app['status'] == 1) selected @endif>On</option>
                                </select>
                                <p class="text-danger status-error" style="display: none; margin-top: 5px;">This Field is
                                    Required !</p>
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-md-4 label-control" for="role_id">Group *</label>
                            <div class="col-md-8">
                                <select id="role_id" name="role_id" class="form-control">
                                    <option value="none" selected disabled>Select Group</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role['id'] }}"
                                            @if ($app['role_id'] == $role['id']) selected @endif>
                                            @if ($role['type'] == 'BUSINESS')
                                                {{ str_replace('SVP_B_' . ($vender_id ?? auth()->user()->id), '', $role['name']) }}
                                            @else
                                                {{ str_replace('SVP_' . ($vender_id ?? auth()->user()->id), '', $role['name']) }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-danger role_id-error" style="display: none; margin-top: 5px;">This Field is
                                    Required !</p>
                            </div>
                        </div>

                        @if ($app['app_name'] == 'Service Provider')
                            <div class="form-group row">
                                <label class="col-md-4 label-control">Trade units *</label>
                                <div class="col-md-8">
                                    <div class="row m-0">
                                        @foreach ($trade_units as $trade_unit)
                                            <div class="col-12 col-md-6 p-0 mb-1">
                                                <fieldset>
                                                    <label class="m-0 cursor-pointer">
                                                        <input type="checkbox" name="trade_unit[]"
                                                            @foreach ($user['trading_units'] as $unit) @if ($unit['trading_id'] == $trade_unit['id']) checked @endif @endforeach
                                                            value="{{ $trade_unit['id'] }}">
                                                        {{ $trade_unit['name'] }}
                                                    </label>
                                                </fieldset>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label class="col-md-4 label-control" for="default_trading_unit">Default trade unit
                                    *</label>
                                <div class="col-md-8">
                                    <select id="default_trading_unit" name="default_trading_unit" class="form-control">
                                        <option value="none" selected disabled>Select Default trade unit</option>
                                        @foreach ($trade_units as $trade_unit)
                                            <option value="{{ $trade_unit['id'] }}"
                                                @if ($user['default_trading_unit'] == $trade_unit['id']) selected @endif>{{ $trade_unit['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger default_trading_unit-error"
                                        style="display: none; margin-top: 5px;">This Field is Required !</p>
                                </div>
                            </div>
                        @endif

                    </div>

                    <div class="footers">
                        <a href="{{ redirect()->back()->getTargetUrl() }}">
                            <button type="button" class="btn btn-dark round btn-min-width">Cancel</button>
                        </a>
                        @if ($is_edit_able != 'off')
                            <button type="button" onclick="submitDetailsForm()"
                                class="btn btn-dark round btn-min-width">Save</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/modules/admin/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script>
        function submitDetailsForm() {
            let appName = @json($app['app_name']);
            let fields = ['role_id'];

            if (appName === "Service Provider") {
                fields.push('default_trading_unit');
            }

            let isValid = true;

            fields.forEach((id) => {
                let element = $(`#${id}`);
                let errorMsg = $(`.${id}-error`);

                if (element.val() === null || element.val() === "none") {
                    element.attr('style', 'border:2px solid red !important;');
                    errorMsg.show();
                    isValid = false;
                } else {
                    element.attr('style', 'border:2px solid black !important;');
                    errorMsg.hide();
                }
            });

            if (isValid) {
                $("#userAppForm").submit();
            }
        }
    </script>
@endsection

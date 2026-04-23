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
            padding: 8px 10px 2px 10px;
            font-size: 10px;
            color: black;
        }

        table.dataTable thead th,
        table.dataTable thead td {
            padding: 10px 18px 10px 8px;
            border-bottom: 1px solid #111;
            font-size: 11px;
        }

        th {
            white-space: pre-line;
        }

        table.dataTable tfoot th,
        table.dataTable tfoot td {
            padding: 10px 18px 6px 8px;
            border-top: 1px solid #111;
            font-size: 10px;
            color: black;
        }

        #headingCollapse14:before,
        .collapse-icon [data-toggle="collapse"]:before,
        .collapse-icon [data-toggle="collapse"]:after {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            transition: all 300ms linear 0s;
        }

        #headingCollapse14:before {
            content: "\e843";
        }

        .collapse-icon [data-toggle="collapse"]:before {
            content: "\e842";
        }

        .collapse-icon [data-toggle="collapse"]:after {
            content: "\e845";
        }

        .collapsed {
            border-bottom-left-radius: 0px !important;
            border-bottom-right-radius: 0px !important;
        }

        .btn-dark {
            border-color: black !important;
            background-color: black !important;
            color: #FFFFFF;
        }

        .round {
            border-radius: 0.5rem;
        }

        /* Form Elements Styling */
        .form-control {
            border: 2px solid black !important;
            height: calc(1em + 1.4rem + 0px);
            border-radius: 7px;
            width: 60%;
            /* Desktop default */
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

        body {
            color: black;
        }

        /* --- RESPONSIVE ENHANCEMENTS --- */

        /* 1. Prevent JS and inline styles from freezing the container and form heights */
        #contens,
        form#contens {
            position: relative;
            /* Required to keep the absolute footer contained */
            height: auto !important;
            min-height: 469px;
            padding-bottom: 60px;
            /* Add breathing room for the absolute footer */
        }

        .footers {
            position: absolute;
            bottom: 0;
            left: 0;
            border-top: 2px solid black;
            padding: 10px 15px;
            width: 100%;
            background-color: #fff;
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
            box-sizing: border-box;
        }

        /* Tablet & Mobile Specific Enhancements (Covers iPads/Tablets at exactly 768px up to 991px) */
        @media (max-width: 991px) {

            /* Sidebar spacing */
            .col-lg-3 {
                margin-bottom: 25px;
            }

            /* Fix the horizontal form layout to stack vertically */
            .form-group.row {
                display: flex;
                flex-direction: column;
                margin-bottom: 1rem;
            }

            /* Align labels to the left instead of right/center */
            .form-group.row label {
                text-align: left !important;
                margin-bottom: 5px;
                width: 100%;
                padding-left: 15px;
            }

            /* Shrink input widths slightly to give breathing room and align strictly with labels */
            .form-control,
            select.form-control {
                width: calc(100% - 30px) !important;
                margin-left: 15px !important;
            }

            /* Make Checkboxes stack neatly */
            .d-flex.flex-column {
                align-items: flex-start;
                padding-left: 15px;
            }

            /* Ensure action buttons at bottom stack neatly with equal gap and width */
            .footers {
                display: flex;
                flex-direction: column-reverse;
                /* Puts Save above Cancel on narrow screens */
                position: relative;
                /* Release from absolute at bottom to flow naturally */
                margin-top: 20px;
                padding: 15px !important;
                gap: 12px;
                /* Perfect uniform spacing between buttons */
            }

            .footers a {
                width: 100%;
                margin: 0 !important;
                display: block;
            }

            .footers .btn {
                width: 100% !important;
                float: none !important;
                margin: 0 !important;
                /* Rely on gap for spacing */
                padding: 10px 0 !important;
                /* Equal vertical thickness */
            }

            #contens {
                padding-bottom: 10px !important;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        {{-- Standardized row with margin: 0 to prevent bleed --}}
        <div class="row" style="border-bottom: 3px solid #949494; margin: 0;">
            <div class="col-12 bg-white headerbg" style="padding-left: 32px; padding-top: 13px;">
                <h3 class="h3">Add new trade unit</h3>

                <div class="breadcrumb-wrapper p-0">
                    {{-- Resetting padding-left to 0 ensures alignment with the H3 above --}}
                    <ol class="breadcrumb" style="padding-left: 0; background-color: transparent; margin-bottom: 10px;">
                        <li class="breadcrumb-item"><a>Products</a></li>
                        <li class="breadcrumb-item">
                            <a style="color: black" href="{{ route('vender.service.provider') }}">Service Provider</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a style="color: black" href="{{ route('vender.service.provider.trading.unit') }}">Trade
                                Units</a>
                        </li>
                        <li class="breadcrumb-item">Add new trade unit</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-12 mb-3">
            <div style="border-radius: 7px;border: 2px solid black; ">
                <h4 class="h3"
                    style="font-weight: 600; font-size: 17px;padding: 10px; margin: 0; display: flex; align-items: center;">
                    <img src="/trading_unit.png" style="width: 22px; margin-right: 8px;"> New trade unit
                </h4>
            </div>
        </div>

        <div class="col-lg-9 col-12"
            style="border: 2px solid black;border-radius: 6px;margin-bottom: 10px;padding-left: 0;padding-right: 0;">
            <div class="row" style="margin-right: 0;margin-left: 0;">
                <div class="col-md-12" style="border-bottom: 2px solid black;">
                    <h3 style="font-size: 20px; padding: 10px; margin-left: -11px; color: black;padding-bottom: 0px;">Trade
                        unit information</h3>
                </div>
            </div>

            <form action="{{ route('vender.service.provider.trading.unit.store') }}" id="contens" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="link-body" style="padding: 10px">

                    <div class="form-group row">
                        <label class="col-lg-4 col-12 label-control" for="name">Trade unit name * (?)</label>
                        <div class="col-lg-8 col-12 mx-auto">
                            <input type="text" id="name" class="form-control" value="" onkeyup="lookup(this);"
                                name="name" placeholder="Trade unit name">
                            @if ($errors->has('name'))
                                <p class="text-danger name" style="padding-left: 15px;width:100%;margin-bottom: -8px;">
                                    {{ $errors->first('name') }}</p>
                            @else
                                <p class="text-danger name"
                                    style="padding-left: 15px;width:100%;display: none;margin-bottom: -8px;">This Field is
                                    Required !</p>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-12 label-control" for="trading_template">Business Name Format *
                            (?)</label>
                        <div class="col-lg-8 col-12 mx-auto">
                            <select id="trading_template" name="trading_template" class="form-control"
                                onkeyup="lookup(this);" style="border-radius: 7px;">
                                <option value="none" selected="" disabled="">Select Business Name Format</option>
                                @if (auth()->user()->profile['organization_status'] === 'Limited Company (Ltd)' ||
                                        auth()->user()->profile['organization_status'] === 'Limited Liability Partnership (LLP)')
                                    <option value="1">Registered company name only</option>
                                    <option value="2">Registered company name & trading name</option>
                                    <option value="3">Trading name only</option>
                                @else
                                    <option value="1">Registered {{ $user['profile']['organization_status'] }} name
                                    </option>
                                    <option value="2">Registered {{ $user['profile']['organization_status'] }} &
                                        trading name</option>
                                    <option value="3">Trading name only</option>
                                @endif
                            </select>
                            <p class="text-danger trading_template"
                                style="padding-left: 15px;width:100%;display: none;margin-bottom: -8px;">This Field is
                                Required !</p>
                        </div>
                    </div>

                    <div class="form-group row" id="trading_name" style="display: none">
                        <label class="col-lg-4 col-12 label-control" for="trading_name_id">Trading name * (?)</label>
                        <div class="col-lg-8 col-12 mx-auto">
                            <select id="trading_name_id" name="trading_name_id" class="form-control" onkeyup="lookup(this);"
                                style="border-radius: 7px;">
                                <option value="none" selected="" disabled="">Select Trading Name</option>
                                @foreach ($trading_names as $name)
                                    <option value="{{ $name['id'] }}">{{ $name['name'] }}</option>
                                @endforeach
                            </select>
                            <p class="text-danger trading_name_id"
                                style="padding-left: 15px;width:100%;display: none;margin-bottom: -8px;">This Field is
                                Required !</p>
                        </div>
                    </div>

                    <div class="form-group row " id="company_name">
                        <label class="col-lg-4 col-12 label-control">Business Name</label>
                        <div class="col-lg-8 col-12 mx-auto">
                            <p class="company_show pt-2 m-0" style="padding-left: 15px;">&lt; Select Business Name Format
                                &gt;</p>
                            <p class="text-danger company"
                                style="padding-left: 15px;width:100%;display: none;margin-bottom: -8px;">This Field is
                                Required !</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-12 label-control">How do you provide and offer your services? * (?)
                        </label>
                        <div class="col-lg-8 col-12 mx-auto">
                            <div class="d-flex flex-column pt-1">
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" name="operation_type[]" value="On-site"
                                        class="custom-control-input" id="On-site"
                                        @if (in_array('On-site', explode(',', $user['profile']['operation_type']))) checked @endif>
                                    <label class="custom-control-label" for="On-site">On-site</label>
                                </div>
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" name="operation_type[]" value="Mobile"
                                        class="custom-control-input" id="Mobile"
                                        @if (in_array('Mobile', explode(',', $user['profile']['operation_type']))) checked @endif>
                                    <label class="custom-control-label" for="Mobile">Mobile</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row" id="site_show"
                        @if ($user['profile']['operation_type'] != 'On-site') style="display: none" @endif>
                        <label class="col-lg-4 col-12 label-control" for="site_id">Address * (?)</label>
                        <div class="col-lg-8 col-12 mx-auto">
                            <select id="site_id" name="site_id" class="form-control" style="border-radius: 7px;">
                                <option value="none" selected="" disabled="">Select Address</option>
                                @foreach ($sites as $site)
                                    <option value="{{ $site['id'] }}">{{ $site['address_line_1'] }}
                                        {{ $site['address_line_2'] }}</option>
                                @endforeach
                            </select>
                            <p class="text-danger site_id"
                                style="padding-left: 15px;width:100%;display: none;margin-bottom: -8px;">This Field is
                                Required !</p>
                        </div>
                    </div>

                    <div class="form-group row mobile_show" @if ($user['profile']['operation_type'] != 'Mobile') style="display: none" @endif>
                        <label class="col-lg-4 col-12 label-control" for="city">Mobile city / town * (?) </label>
                        <div class="col-lg-8 col-12 mx-auto">
                            <input type="text" id="city" class="form-control" value=""
                                onkeyup="lookup(this);" name="city" placeholder="Mobile city / town">
                            <p style="display: none" class="city_show"></p>
                            <p class="text-danger city"
                                style="padding-left: 15px;width:100%;display: none;margin-bottom: -8px;">This Field is
                                Required !</p>
                        </div>
                    </div>

                    <div class="form-group row mobile_show" @if ($user['profile']['operation_type'] != 'Mobile') style="display: none" @endif>
                        <label class="col-lg-4 col-12 label-control" for="postcode">Mobile postcode * (?) </label>
                        <div class="col-lg-8 col-12 mx-auto">
                            <input type="text" id="postcode" class="form-control" value=""
                                onkeyup="lookup(this);" name="postcode" placeholder="Mobile postcode">
                            <p style="display: none" class="postcode_show"></p>
                            <p class="text-danger postcode"
                                style="padding-left: 15px;width:100%;display: none;margin-bottom: -8px;">This Field is
                                Required !</p>
                        </div>
                    </div>

                    <div class="form-group row mobile_show" @if ($user['profile']['operation_type'] != 'Mobile') style="display: none" @endif>
                        <label class="col-lg-4 col-12 label-control" for="radius">Mobile distance / radius (miles) * (?)
                        </label>
                        <div class="col-lg-8 col-12 mx-auto">
                            <input type="text" id="radius" class="form-control" value=""
                                onkeyup="lookup(this);" name="radius" placeholder="Mobile distance">
                            <p class="text-danger radious"
                                style="padding-left: 15px;width:100%;display: none;margin-bottom: -8px;">This Field is
                                Required !</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-12 label-control" for="mobile">Mobile * </label>
                        <div class="col-lg-8 col-12 mx-auto">
                            <input type="tel" id="mobile" class="form-control" value=""
                                onkeyup="lookup(this);" name="mobile" placeholder="Mobile">
                            <p class="text-danger mobile"
                                style="padding-left: 15px;width:100%;display: none;margin-bottom: -8px;">This Field is
                                Required !</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-12 label-control" for="landline">Landline </label>
                        <div class="col-lg-8 col-12 mx-auto">
                            <input type="tel" id="landline" class="form-control" value="" name="landline"
                                placeholder="Landline">
                            <p class="text-danger landline"
                                style="padding-left: 15px;width:100%;display: none;margin-bottom: -8px;">This Field is
                                Required !</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-12 label-control" for="email">Email * </label>
                        <div class="col-lg-8 col-12 mx-auto">
                            <input type="email" id="email" class="form-control" value=""
                                onkeyup="lookup(this);" name="email" placeholder="Email">
                            <p class="text-danger email"
                                style="padding-left: 15px;width:100%;display: none;margin-bottom: -8px;">Invalid Email !
                            </p>
                            @if ($errors->has('email'))
                                <p class="text-danger email" style="padding-left: 15px;width:100%;margin-bottom: -8px;">
                                    {{ $errors->first('email') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-4 col-12 label-control" for="website">Website </label>
                        <div class="col-lg-8 col-12 mx-auto">
                            <input type="url" id="website" class="form-control" value="" name="website"
                                placeholder="Website">
                            <p class="text-danger website"
                                style="padding-left: 15px;width:100%;display: none;margin-bottom: -8px;">Invalid Website !
                            </p>
                            @if ($errors->has('website'))
                                <p class="text-danger website" style="padding-left: 15px;width:100%;margin-bottom: -8px;">
                                    {{ $errors->first('website') }}</p>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="footers d-flex justify-content-end align-items-center" style="gap: 10px;">
                    <a href="{{ redirect()->back()->getTargetUrl() }}">
                        <button type="button" class="btn btn-dark round btn-min-width mb-0">Cancel</button>
                    </a>
                    <button type="button" onclick="submitDetailsForm()"
                        class="btn btn-dark round btn-min-width mb-0">Save</button>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="/modules/admin/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>

    <script>
        $('input[name="operation_type[]"]').change(function() {
            let selected = $('input[name="operation_type[]"]:checked').map(function() {
                return this.value;
            }).get();

            $('.mobile_show, #site_show, #city, .city_show, #postcode, .postcode_show').hide();

            if (selected.includes('Mobile') && selected.includes('On-site')) {
                $('.mobile_show').show();
                $('#site_show').show();
                $('.city_show').show();
                $('.postcode_show').show();
            } else if (selected.includes('Mobile')) {
                $('.mobile_show').show();
                $('#city').show();
                $('#postcode').show();
            } else if (selected.includes('On-site')) {
                $('#site_show').show();
                $('#city').show();
                $('#postcode').show();
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
            let status = true;
            const setError = (selector, showMsg = false, msgClass = '') => {
                $(selector).css('border', '2px solid red');
                if (showMsg && msgClass) $(msgClass).show();
                status = false;
            };

            const clearError = (selector, msgClass = '') => {
                $(selector).css('border', '2px solid black');
                if (msgClass) $(msgClass).hide();
            };

            const selectedOps = $('input[name="operation_type[]"]:checked').map(function() {
                return this.value;
            }).get();

            if (selectedOps.length === 0) {
                alert("Please select at least one operation type.");
                return false;
            }

            const tradingTemplate = $('#trading_template').val();
            let requiredFields = [];

            if (selectedOps.includes('Mobile') && !selectedOps.includes('On-site')) {
                requiredFields = tradingTemplate == 1 ? ['name', 'email', 'city', 'postcode', 'radius'] : ['name',
                    'trading_name_id', 'email', 'city', 'postcode', 'radius'
                ];
            } else if (selectedOps.includes('On-site') && !selectedOps.includes('Mobile')) {
                requiredFields = tradingTemplate == 1 ? ['name', 'mobile', 'email', 'city', 'site_id'] : ['name',
                    'trading_name_id', 'mobile', 'email', 'city', 'site_id'
                ];
            } else if (selectedOps.includes('On-site') && selectedOps.includes('Mobile')) {
                requiredFields = tradingTemplate == 1 ? ['site_id', 'radius', 'name', 'mobile', 'email'] : ['site_id',
                    'radius', 'name', 'trading_name_id', 'mobile', 'email'
                ];
            }

            requiredFields.forEach((field) => {
                const value = $(`#${field}`).val()?.trim();
                if (!value) {
                    setError(`#${field}`);
                } else {
                    clearError(`#${field}`);
                }
            });

            const mobileVal = $('#mobile').val()?.trim();
            const landlineVal = $('#landline').val()?.trim();

            clearError('#mobile, #landline', '.mobile, .landline');

            if (!mobileVal && !landlineVal) {
                setError('#mobile, #landline', true, '.mobile, .landline');
                $('.mobile, .landline').text('Please enter mobile or landline');
            } else if (mobileVal && landlineVal) {
                setError('#mobile, #landline', true, '.mobile, .landline');
                $('.mobile, .landline').text('Enter only one: mobile OR landline');
            }

            const email = $('#email').val()?.trim();

            if (!email || validateEmail(email) === null) {
                setError('#email', true, '.email');
            } else {
                clearError('#email', '.email');
            }

            if (status) {
                $('form').submit();
            }
            return status;
        }

        $('#trading_template').on('change', function() {
            $id = this.value;
            if ($id == 1) {
                $('#company_name').show();
                $('#trading_name').hide();
                showCompanyName();
            }
            if ($id == 2) {
                $('#company_name').show();
                $('#trading_name').show();
                showCompanyTradingName();
            }
            if ($id == 3) {
                $('#trading_name').show();
                showTradingName();
            }
        });

        $('#trading_name_id').on('change', function() {
            $id = this.value;
            let company_name = @json(auth()->user()->profile->company_name);
            let trading_names = @json($trading_names).filter((item) => item.id == $id);

            if (trading_names.length > 0) {
                if ($('#trading_template').val() == 2) {
                    trading_name = `trading as ${trading_names[0].name}`;
                    $('.company_show').text(`${company_name} ${trading_name}`);
                }
                if ($('#trading_template').val() == 3) {
                    trading_name = `${trading_names[0].name}`;
                    $('.company_show').text(`${trading_name}`);
                }
            }
        });

        $('#site_id').on('change', function() {
            let sites = @json($sites);
            let site = sites.filter((item) => parseInt(item.id) === parseInt(this.value));

            if (site.length > 0) {
                $('#city').val(site[0].city);
                $('.city_show').text(site[0].city);
                $('#postcode').val(site[0].postcode);
                $('.postcode_show').text(site[0].postcode);
            }
        });

        const validateEmail = (email) => {
            return String(email)
                .toLowerCase()
                .match(
                    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                );
        };

        function showCompanyName() {
            let company_name = @json(auth()->user()->profile->company_name);
            $('.company_show').text(company_name);
        }

        function showCompanyTradingName() {
            let company_name = @json(auth()->user()->profile->company_name);
            let trading_id = $('#trading_name_id').val();
            let trading_name = `< Select Trading Name >`;

            if (trading_id !== null) {
                let trading_names = @json($trading_names).filter((item) => item.id == trading_id);
                if (trading_names.length > 0) {
                    trading_name = `trading as ${trading_names[0].name}`;
                }
            } else {
                trading_name = `trading as < Select Trading Name >`;
            }
            $('.company_show').text(`${company_name} ${trading_name}`);
        }

        function showTradingName() {
            let trading_id = $('#trading_name_id').val();
            let trading_name = `< Select Trading Name >`;

            if (trading_id !== null) {
                let trading_names = @json($trading_names).filter((item) => item.id == trading_id);
                if (trading_names.length > 0) {
                    trading_name = `${trading_names[0].name}`;
                }
            }
            $('.company_show').text(`${trading_name}`);
        }
    </script>
@endsection

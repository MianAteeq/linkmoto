@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        /* ========================================================================
                   1. GLOBAL SCROLL & ALIGNMENT FIX
                   ======================================================================== */
        html,
        body {
            overflow-x: hidden !important;
            overflow-y: auto !important;
            /* Restore natural page scroll */
            height: auto !important;
        }

        .app-content,
        .content-wrapper,
        .content-body {
            overflow: visible !important;
            height: auto !important;
            min-height: auto !important;
        }

        .main-content-box {
            border: 2px solid black;
            border-radius: 6px;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            background-color: white;
            width: 100% !important;
            overflow: visible !important;
            /* Allow data to push height */
            height: auto !important;
        }

        /* ========================================================================
                   2. FORM ALIGNMENT & DATA STANDARDIZATION
                   ======================================================================== */
        .main-content-inner {
            flex-grow: 1;
            padding-bottom: 0;
            width: 100%;
        }

        .form-control {
            border: 2px solid black !important;
            border-radius: 7px;
            height: calc(1.5em + 1.2rem);
            width: 100% !important;
            /* Full width inside its column for better alignment */
            color: black;
        }

        .label-control {
            color: black;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 5px;
        }

        .info-sidebar {
            border-radius: 7px;
            border: 2px solid black;
            height: auto;
            background-color: #fcfdfe;
            box-shadow: 4px 4px 0px rgba(0, 0, 0, 0.04);
            width: 100%;
        }

        /* ========================================================================
                   3. FOOTERS & BUTTONS
                   ======================================================================== */
        .footers {
            border-top: 2px solid black;
            padding: 15px 20px 15px 20px;
            width: 100%;
            background: white;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
        }

        .btn-dark {
            border-color: black !important;
            background-color: black !important;
            color: #FFFFFF !important;
            padding: 8px 25px;
        }

        .round {
            border-radius: 0.5rem;
        }

        /* ========================================================================
                   4. MOBILE FIXES (SIDEBAR & STACKING)
                   ======================================================================== */
        @media (max-width: 991.98px) {

            /* Sidebar Slider Fix - Hides native scroll track without breaking scroll */
            .main-menu,
            .main-menu-content {
                scrollbar-width: none;
                -ms-overflow-style: none;
            }

            .main-menu::-webkit-scrollbar {
                display: none;
            }

            .headerbg {
                padding-left: 25px !important;
            }

            .info-sidebar-wrapper {
                margin-bottom: 20px;
            }

            /* Stack Form Elements neatly */
            .form-group.row {
                flex-direction: column !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            .col-md-4,
            .col-md-8 {
                width: 100% !important;
                max-width: 100% !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            .footers {
                flex-direction: column-reverse;
                padding: 15px !important;
            }

            .footers .btn-dark,
            .footers a {
                width: 100% !important;
                display: block;
                text-align: center;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494; margin: 0;">
            <div class="col-12 bg-white headerbg" style="padding-left: 32px; padding-top: 13px;">
                <h3 class="h3">Edit trade unit</h3>
                <div class="breadcrumb-wrapper col-12 p-0">
                    <ol class="breadcrumb" style="padding-left: 0; background-color: transparent; margin-bottom: 10px;">
                        <li class="breadcrumb-item"><a>Products</a></li>
                        <li class="breadcrumb-item"><a style="color: black"
                                href="{{ route('vender.service.provider.trading.unit') }}">Trade Units</a></li>
                        <li class="breadcrumb-item">Edit trade unit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid px-1 px-md-1 mt-1">
        <div class="row align-items-start m-0">

            {{-- Sidebar --}}
            <div class="col-12 col-md-12 col-lg-3 info-sidebar-wrapper d-flex mb-3 mb-lg-0">
                <div class="info-sidebar d-flex flex-column">
                    <h4
                        style="font-weight: 600; font-size: 1.1rem; padding: 12px 16px; margin: 0; display: flex; align-items: center; gap: 10px; background-color: white; border-radius: 5px 5px 0 0;">
                        <img src="/trading_unit.png" style="width: 20px;"> Edit trade unit
                    </h4>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="col-12 col-md-12 col-lg-9 d-flex ps-lg-3 mb-4">
                <div class="main-content-box w-100">
                    <form action="{{ route('vender.service.provider.trading.unit.update') }}" id="unitForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $trading_unit['id'] }}">

                        <div class="main-content-inner">
                            <div style="border-bottom: 2px solid black; padding: 12px 20px;">
                                <h3 style="font-size: 20px; color: black; margin: 0;">Trade unit information</h3>
                            </div>

                            <div style="padding: 20px;">
                                {{-- Trade Unit Name --}}
                                <div class="form-group row mb-2">
                                    <div class="col-md-4"><label class="label-control">Trade unit name * (?)</label></div>
                                    <div class="col-md-8">
                                        <input type="text" id="name" class="form-control"
                                            value="{{ $trading_unit['name'] }}" name="name" onkeyup="lookup(this);">
                                        <p class="text-danger name" style="display:none; margin-top:5px;">This field is
                                            required!</p>
                                    </div>
                                </div>

                                {{-- Business Name Format --}}
                                <div class="form-group row mb-2">
                                    <div class="col-md-4"><label class="label-control">Business Name Format * (?)</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select id="trading_template" name="trading_template" class="form-control">
                                            <option value="1" @if ($trading_unit['trading_template'] == 1) selected @endif>
                                                Registered company name</option>
                                            <option value="2" @if ($trading_unit['trading_template'] == 2) selected @endif>
                                                Registered company name & trading name</option>
                                            <option value="3" @if ($trading_unit['trading_template'] == 3) selected @endif>Trading
                                                name only</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Trading Name (Conditional) --}}
                                <div class="form-group row mb-2" id="trading_name_row"
                                    @if ($trading_unit['trading_template'] == 1) style="display: none" @endif>
                                    <div class="col-md-4"><label class="label-control">Trading name * (?)</label></div>
                                    <div class="col-md-8">
                                        <select id="trading_name_id" name="trading_name_id" class="form-control">
                                            @foreach ($trading_names as $name)
                                                <option value="{{ $name['id'] }}"
                                                    @if ($trading_unit['trading_name_id'] == $name['id']) selected @endif>{{ $name['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Preview Box --}}
                                <div class="form-group row mb-2">
                                    <div class="col-md-4"><label class="label-control">Preview Business Name</label></div>
                                    <div class="col-md-8">
                                        <p class="company_show m-0"
                                            style="padding: 10px; border: 1px dashed #ccc; background: #f9f9f9; font-weight: 500;">
                                            {{-- Content filled by JS --}}
                                        </p>
                                    </div>
                                </div>

                                {{-- Mobile/Email fields --}}
                                <div class="form-group row mb-2">
                                    <div class="col-md-4"><label class="label-control">Mobile *</label></div>
                                    <div class="col-md-8">
                                        <input type="tel" id="mobile" class="form-control"
                                            value="{{ $trading_unit['mobile'] }}" name="mobile">
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <div class="col-md-4"><label class="label-control">Email *</label></div>
                                    <div class="col-md-8">
                                        <input type="email" id="email" class="form-control"
                                            value="{{ $trading_unit['email'] }}" name="email">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="footers">
                            <a href="{{ redirect()->back()->getTargetUrl() }}"><button type="button"
                                    class="btn btn-dark round">Cancel</button></a>
                            <button type="button" onclick="submitDetailsForm()" class="btn btn-dark round">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(window).on('load', function() {
            if ($(window).width() <= 768) {
                setTimeout(function() {
                    $('.nav-toggle, .menu-toggle').trigger('click');
                    $('body').removeClass('menu-hide menu-collapsed').addClass('menu-expanded menu-open');
                }, 500);
            }
            // Run initial preview
            updateNamePreview();
        });

        // Handle template changes
        $('#trading_template, #trading_name_id').on('change', function() {
            if ($('#trading_template').val() == 1) {
                $('#trading_name_row').hide();
            } else {
                $('#trading_name_row').show();
            }
            updateNamePreview();
        });

        function updateNamePreview() {
            let company = @json(auth()->user()->profile->company_name);
            let template = $('#trading_template').val();
            let tradingName = $("#trading_name_id option:selected").text();
            let preview = "";

            if (template == 1) preview = company;
            else if (template == 2) preview = company + " Trading as " + tradingName;
            else if (template == 3) preview = tradingName;

            $('.company_show').text(preview);
        }

        function lookup(arg) {
            if ($(arg).val() == "") $(arg).css('border', '2px solid red');
            else $(arg).css('border', '2px solid black');
        }

        function submitDetailsForm() {
            // Add your validation here similar to previous pages
            $("#unitForm").submit();
        }
    </script>
@endsection

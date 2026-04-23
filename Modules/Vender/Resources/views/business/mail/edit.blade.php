@extends('vender::layouts.master')

@section('css_custom')
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
            background-color: #fcfdfe;
            box-shadow: 4px 4px 0px rgba(0, 0, 0, 0.04);
            width: 100%;
            overflow: hidden;
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
            height: 100%;
        }

        .main-content-inner {
            flex-grow: 1;
            padding-bottom: 0;
            width: 100%;
        }

        /* ========================================================================
                   2. FORM ELEMENTS
                   ======================================================================== */
        .form-control-custom {
            border: 2px solid black !important;
            border-radius: 7px;
            height: calc(1em + 1.4rem + 0px);
            padding: 8px 12px;
            width: 100%;
            box-sizing: border-box;
            color: black;
        }

        .form-control-custom:focus {
            color: #4e5154;
            background-color: #fff;
            border-color: black;
            outline: 0;
            box-shadow: none;
        }

        .form-control-custom.is-invalid {
            border-color: red !important;
        }

        .label-control {
            color: black;
            font-weight: 500;
        }

        .required-star {
            color: red;
        }

        .validation-msg {
            color: red;
            font-size: 0.85rem;
            margin-top: 5px;
            margin-bottom: 0;
            display: none;
            padding-left: 5px;
        }

        /* ========================================================================
                   3. SIDEBAR ACCORDION STYLES
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

        .accordion .card-header {
            color: black !important;
            padding: 1rem 1rem !important;
            border-top: 2px solid rgba(0, 0, 0, 0.1);
        }

        .card .card-title {
            font-weight: 600;
            font-size: 0.95rem;
            margin: 0;
        }

        .accordion .card-body {
            color: black;
            padding-top: 0;
            font-size: 0.9rem;
        }

        /* ========================================================================
                   4. UI ELEMENTS (FOOTERS & BUTTONS)
                   ======================================================================== */
        .footers {
            border-top: 2px solid black;
            padding: 15px 20px 25px 20px;
            width: 100%;
            background: white;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;
            margin-top: auto;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
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

        /* ========================================================================
                   5. RESPONSIVE MEDIA QUERIES & SCROLL FIX
                   ======================================================================== */
        @media (max-width: 991.98px) {

            /* Sidebar Double Scrollbar Fix */
            body.menu-open {
                overflow: hidden !important;
            }

            .main-menu,
            .main-menu-content {
                overflow-y: auto !important;
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            .main-menu::-webkit-scrollbar,
            .main-menu-content::-webkit-scrollbar {
                display: none !important;
            }

            .headerbg {
                padding-left: 25px !important;
            }

            .info-sidebar-wrapper {
                margin-bottom: 20px;
            }

            /* Stack label above input */
            .form-group.row {
                flex-direction: column !important;
                margin-bottom: 12px;
            }

            .form-group.row .col-md-4,
            .form-group.row .col-md-8 {
                width: 100% !important;
                max-width: 100% !important;
                flex: 0 0 100% !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            .form-group.row .col-md-8 {
                margin-top: 4px;
            }

            .footers {
                padding: 15px 20px 25px 20px !important;
            }

            .footers .btn-dark {
                float: none !important;
                width: 100% !important;
                display: block !important;
                text-align: center;
                margin-top: 10px;
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
        <div class="row" style="border-bottom: 3px solid #949494; margin: 0;">
            <div class="col-12 bg-white headerbg" style="padding-left: 32px; padding-top: 13px;">
                <h3 class="h3">Edit Email Address</h3>
                <div class="breadcrumb-wrapper p-0">
                    <ol class="breadcrumb" style="padding-left: 0; background-color: transparent; margin-bottom: 10px;">
                        <li class="breadcrumb-item"><a>Business</a></li>
                        <li class="breadcrumb-item"><a style="color: black" href="{{ route('vender.mail') }}">Email
                                Addresses</a></li>
                        <li class="breadcrumb-item">Edit Email Address</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid px-1 px-md-1 mt-1">
        <div class="row align-items-start" style="padding-left: 0 !important;">

            {{-- Sidebar --}}
            <div class="col-12 col-md-12 col-lg-3 info-sidebar-wrapper d-flex mb-3 mb-lg-0">
                <div class="info-sidebar d-flex flex-column">
                    <h4
                        style="font-weight: 600; font-size: 1.1rem; padding: 12px 16px; margin: 0; display: flex; align-items: center; gap: 10px; background-color: white; border-radius: 5px 5px 0 0;">
                        <img src="/home.png" alt="Icon" style="width: 20px;"> Edit Email Address
                    </h4>

                    {{-- Help Section Accordion --}}
                    <div id="show_help" style="border-top:2px solid black; background: #fcfdfe;">
                        <h4 style="padding: 12px 16px 0 16px; color: black; font-weight: 600; margin: 0; font-size: 1rem;">
                            Help information:
                        </h4>

                        <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                            <div class="card accordion collapse-icon accordion-icon-rotate mb-0"
                                style="box-shadow: none; background: transparent;">
                                <a id="business_VAT" class="card-header info collapsed" data-toggle="collapse"
                                    href="#collapsebusiness_vat" aria-expanded="false">
                                    <div class="card-title">Label (?)</div>
                                </a>
                                <div id="collapsebusiness_vat" data-parent="#accordionWrap1" class="collapse">
                                    <div class="card-content">
                                        <div class="card-body pb-3">
                                            Give this account a short name so you can recognise it later when selecting for
                                            invoices or payouts. For example: Main Business Account, Refunds Account, Payout
                                            Account, or Site A – Payments.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Content Box --}}
            <div class="col-12 col-md-12 col-lg-9 d-flex ps-lg-3 mb-4 w-100">
                <form action="{{ route('vender.mail.update') }}" id="contens" method="POST" enctype="multipart/form-data"
                    class="main-content-box w-100" style="display: flex; flex-direction: column; height: 100%;">
                    @csrf
                    <input type="hidden" name="id" value="{{ $site['id'] }}">

                    <div class="main-content-inner">
                        {{-- Title row --}}
                        <div style="border-bottom: 2px solid black; padding: 12px 20px;">
                            <h3 style="font-size: 20px; color: black; margin: 0;">
                                Bank Account Information
                            </h3>
                        </div>

                        {{-- Form Body --}}
                        <div style="padding: 20px;">
                            <div class="form-group row align-items-center mb-2">
                                <label class="col-md-4 label-control">Label (?) <span class="required-star">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" id="label" name="label" class="form-control-custom"
                                        placeholder="Enter Your Label *" value="{{ $site['label'] }}"
                                        onkeyup="lookup(this);" required>
                                    <p class="validation-msg label-error">Label Field is Required!</p>
                                </div>
                            </div>

                            <div class="form-group row align-items-center mb-2">
                                <label class="col-md-4 label-control">Email Address <span
                                        class="required-star">*</span></label>
                                <div class="col-md-8">
                                    <input type="email" id="email" name="email" class="form-control-custom"
                                        placeholder="Enter Your Email Address" value="{{ $site['email'] }}"
                                        onkeyup="lookup(this);" required>
                                    <p class="validation-msg email-error">Email Address Field is Required!</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Flexbox Footer --}}
                    <div class="footers mt-auto">
                        <a href="{{ redirect()->back()->getTargetUrl() }}" style="text-decoration: none;">
                            <button type="button" class="btn btn-dark round btn-min-width">Cancel</button>
                        </a>
                        <button type="button" onclick="submitDetailsForm()"
                            class="btn btn-dark round btn-min-width">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- SIDEBAR FIX: Force open on mobile with a slight delay --}}
    <script>
        $(window).on('load', function() {
            if ($(window).width() <= 768) {
                setTimeout(function() {
                    $('.nav-toggle, .menu-toggle').trigger('click');
                    $('body').removeClass('menu-hide menu-collapsed').addClass('menu-expanded menu-open');
                }, 500);
            }
        });
    </script>

    <script>
        // Real-time validation on keyup
        function lookup(element) {
            var id = element.getAttribute('id');
            var value = element.value.trim();

            if (value === "") {
                $('#' + id).addClass("is-invalid");
                $('.' + id + '-error').show();
            } else {
                $('#' + id).removeClass("is-invalid");
                $('.' + id + '-error').hide();
            }
        }

        // Final validation before submission
        function submitDetailsForm() {
            let requiredFields = ['label', 'email'];
            let isValid = true;

            requiredFields.forEach(function(item) {
                let value = $('#' + item).val().trim();
                if (value === "") {
                    $('#' + item).addClass('is-invalid');
                    $('.' + item + '-error').show();
                    isValid = false;
                } else {
                    $('#' + item).removeClass('is-invalid');
                    $('.' + item + '-error').hide();
                }
            });

            if (isValid) {
                $("#contens").submit();
            }
        }
    </script>
@endsection

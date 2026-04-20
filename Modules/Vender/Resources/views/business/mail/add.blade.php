@extends('vender::layouts.master')

@section('css_custom')
    <style>
        .collapsed {
            border-bottom-left-radius: 0px !important;
            border-bottom-right-radius: 0px !important;
        }

        .footers {
            border-top: 2px solid black;
            padding: 15px;
            width: 100%;
            background: white;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;
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
            box-sizing: border-box;
        }

        .form-control:focus {
            color: #4e5154;
            background-color: #fff;
            border-color: black;
            outline: 0;
            box-shadow: none;
        }

        .accordion .card-header,
        .default-collapse .card-header {
            color: black !important;
            padding: 1rem 1rem !important;
        }

        .card .card-title {
            font-weight: 500;
            letter-spacing: 0.05rem;
            font-size: 1rem;
        }

        /* Sidebar container */
        .info-sidebar {
            border-radius: 7px;
            border: 2px solid black;
        }

        /* Main content box */
        .main-content-box {
            border: 2px solid black;
            border-radius: 6px;
            margin-bottom: 10px;
            padding: 0;
            background: white;
        }

        /* --- RESPONSIVE MEDIA QUERIES --- */
        @media (max-width: 1024px) {
            .form-control {
                width: 85% !important;
            }
        }

        @media (max-width: 767.98px) {
            .headerbg {
                padding-left: 15px !important;
            }

            /* Stack both columns full width */
            .col-12.col-lg-3,
            .col-12.col-lg-9 {
                width: 100% !important;
                max-width: 100% !important;
                flex: 0 0 100% !important;
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            /* Prevent outer row overflow */
            .row {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            /* Remove fixed height */
            .main-content-box {
                height: auto !important;
                min-height: unset !important;
            }

            /* Stack label above input */
            .form-group.row {
                flex-direction: column !important;
                margin-bottom: 12px;
            }

            .form-group.row .col-md-4,
            .form-group.row .col-md-8,
            .form-group.row .mx-auto {
                width: 100% !important;
                max-width: 100% !important;
                flex: 0 0 100% !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            .form-group.row .col-md-8 {
                margin-top: 4px;
            }

            /* All inputs full width */
            .form-control {
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
            }

            /* Footer buttons stacked */
            .footers {
                text-align: center;
                padding: 10px !important;
            }

            .footers button,
            .footers a button {
                float: none !important;
                width: 100% !important;
                margin: 5px 0 !important;
                display: block;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494; margin: 0;">
            <div class="col-12 bg-white headerbg" style="padding-left: 32px; padding-top: 13px;">
                <h3 class="h3">Add New Email Address</h3>
                <div class="breadcrumb-wrapper col-12 p-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Business</a></li>
                        <li class="breadcrumb-item"><a style="color: black" href="{{ route('vender.mail') }}">Email
                                Addresses</a></li>
                        <li class="breadcrumb-item">Add New Email Address</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">

        {{-- Sidebar --}}
        <div class="col-12 col-lg-3 mb-3">
            <div class="info-sidebar">
                <h4 class="h3" style="font-weight: 600; font-size: 17px; padding: 10px; margin: 0;">
                    <img src="/home.png" style="width: 22px; margin-top: -5px;"> New Email Address
                </h4>
                <div style="border-top: 2px solid black; padding: 10px 13px;">
                    <h4 style="color: black; font-weight: 600; margin: 0 0 5px 0;">Help information:</h4>
                    <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                        <div class="card accordion collapse-icon accordion-icon-rotate mb-0" style="box-shadow: none;">
                            <a id="business_VAT" class="card-header info collapsed" data-toggle="collapse"
                                href="#collapsebusiness_vat" aria-expanded="false">
                                <div class="card-title lead">Label (?)</div>
                            </a>
                            <div id="collapsebusiness_vat" data-parent="#accordionWrap1" class="collapse">
                                <div class="card-body" style="color: black;">
                                    Give this account a short name so you can recognise it later when selecting for
                                    invoices or payouts. For example: Main Business Account, Refunds Account,
                                    Payout Account, or Site A – Payments.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="col-12 col-lg-9">
            <div class="main-content-box">

                <div style="border-bottom: 2px solid black; padding: 10px 15px;">
                    <h3 style="font-size: 20px; color: black; margin: 0;">Bank Account Information</h3>
                </div>

                <form action="{{ route('vender.mail.store') }}" id="contens" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div style="padding: 15px;">

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Label (?) <span style="color:red;">*</span></label>
                            <div class="col-md-8 mx-auto">
                                <input type="text" id="label" value="" onkeyup="lookup(this);"
                                    class="form-control" name="label" required placeholder="Enter Your Label *">
                                <p class="text-danger label"
                                    style="padding-left: 0; width:100%; display: none; margin-bottom: -8px;">
                                    Label Field is Required!
                                </p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Email Address <span style="color:red;">*</span></label>
                            <div class="col-md-8 mx-auto">
                                <input type="email" id="email" class="form-control" name="email" required
                                    value="" placeholder="Enter Your Email Address">
                                <p class="text-danger email"
                                    style="padding-left: 0; width:100%; display: none; margin-bottom: -8px;">
                                    Email Address Field is Required!
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="footers">
                        <button type="button" onclick="submitDetailsForm()"
                            class="btn btn-dark round btn-min-width float-right mr-1 mb-1">Save</button>
                        <a href="{{ redirect()->back()->getTargetUrl() }}">
                            <button type="button"
                                class="btn btn-dark round btn-min-width float-right mr-1 mb-1">Cancel</button>
                        </a>
                        <div class="clearfix"></div>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            // Real-time validation
            window.lookup = function(arg) {
                var id = arg.getAttribute('id');
                var value = arg.value.trim();

                if (value === "") {
                    $('#' + id).css('border', '2px solid red');
                } else {
                    $('#' + id).css('border', '2px solid black');
                    $('.' + id).hide();
                }
            };

            // Final form validation
            window.submitDetailsForm = function() {
                let fields = ['label', 'email'];
                let isValid = true;

                fields.forEach(function(item) {
                    let val = $('#' + item).val().trim();
                    if (val === "") {
                        $('#' + item).css('border', '2px solid red');
                        isValid = false;
                    } else {
                        $('#' + item).css('border', '2px solid black');
                        $('.' + item).hide();
                    }
                });

                if (isValid) {
                    $("#contens").submit();
                }
            };

        });
    </script>
@endsection

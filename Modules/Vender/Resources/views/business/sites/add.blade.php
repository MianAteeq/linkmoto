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
        }

        .main-content-inner {
            flex-grow: 1;
            padding-bottom: 0;
            width: 100%;
        }

        /* ========================================================================
                   2. FORM ELEMENTS & FILE UPLOADS (Original Logic Preserved)
                   ======================================================================== */
        .form-control {
            border: 2px solid black !important;
            height: calc(1em + 1.4rem + 0px);
            border-radius: 7px;
            width: 100%;
            /* Changed to 100% to fill the column cleanly */
        }

        .form-control:focus {
            color: #4e5154;
            background-color: #fff;
            border-color: black;
            outline: 0;
            box-shadow: none;
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
            color: white;
        }

        .label-control {
            color: black;
            font-weight: 500;
        }

        input:focus:required:invalid {
            border: 2px solid red;
        }

        input:required:valid {
            border: 2px solid black;
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
        }

        .card .card-title {
            font-weight: 500;
            letter-spacing: 0.05rem;
            font-size: 1rem;
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
                   5. RESPONSIVE MEDIA QUERIES
                   ======================================================================== */
        @media (max-width: 991.98px) {
            .headerbg {
                padding-left: 25px !important;
            }

            .info-sidebar-wrapper {
                margin-bottom: 20px;
            }

            #contens {
                height: auto !important;
            }

            .form-btn {
                width: 70%;
                /* Give it more room on mobile */
            }

            .view-btn {
                width: auto !important;
                /* Ensure the view button doesn't stretch */
                display: inline-block !important;
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
                <h3 class="h3">Add new site</h3>

                <div class="breadcrumb-wrapper p-0">
                    <ol class="breadcrumb" style="padding-left: 0; background-color: transparent; margin-bottom: 10px;">
                        <li class="breadcrumb-item"><a>Business</a></li>
                        <li class="breadcrumb-item"><a style="color: black" href="{{ route('vender.site') }}">Sites</a></li>
                        <li class="breadcrumb-item">Add new site</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid px-1 px-md-1 mt-1">
        <div class="row align-items-start" style="padding-left: 0 !important;">

            {{-- Sidebar Layout --}}
            <div class="col-12 col-md-12 col-lg-3 info-sidebar-wrapper d-flex mb-3 mb-lg-0">
                <div class="info-sidebar d-flex flex-column">
                    <h4
                        style="font-weight: 600; font-size: 1.1rem; padding: 12px 16px; margin: 0; display: flex; align-items: center; gap: 10px; background-color: white; border-radius: 5px 5px 0 0;">
                        <img src="/home.png" style="width: 20px; color:black;"> New Site
                    </h4>

                    {{-- Help Section Accordion --}}
                    <div id="show_help" style="border-top:2px solid black; background: #fcfdfe;">
                        <h4 style="padding: 12px 16px 0 16px; color: black; font-weight: 600; margin: 0; font-size: 1rem;">
                            Help information:
                        </h4>

                        <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                            <div class="card accordion collapse-icon accordion-icon-rotate"
                                style="box-shadow: none; background: transparent;">
                                <a id="business_VAT" class="card-header info collapsed" data-toggle="collapse"
                                    href="#collapsebusiness_vat" aria-expanded="false" aria-controls="collapsebusiness_vat">
                                    <div class="card-title lead" style="font-size: 0.95rem;"> Proof of site (?)</div>
                                </a>
                                <div id="collapsebusiness_vat" data-parent="#accordionWrap1" role="tabpanel"
                                    aria-labelledby="business_VAT" class="collapse">
                                    <div class="card-content">
                                        <div class="card-body" style="color:black; padding-top: 0; padding-bottom: 15px;">
                                            <h6 class="h3" style="font-size: 13px; font-weight: bold; color:black;">
                                                Acceptable proof (any 1 of the following):</h6>
                                            <p style="font-size: 12px;">Acceptable documents:</p>
                                            <ul style="font-size: 12px; padding-left: 15px;">
                                                <li>Expense Invoice (i.e. parts purchases, tools purchase, etc) in your
                                                    trading address, dated within the last 1 month</li>
                                                <li>Utility Bill in your trading address, dated within the last 3 months
                                                </li>
                                                <li>Business rates bill or letter of your trading address</li>
                                                <li>Lease or Rent agreement of your trading address</li>
                                            </ul>
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
                <form action="{{ route('vender.site.store') }}" id="contens" method="POST" enctype="multipart/form-data"
                    class="main-content-box w-100" style="display: flex; flex-direction: column; height: 100%;">
                    @csrf

                    <div class="main-content-inner">
                        {{-- Title row --}}
                        <div style="border-bottom: 2px solid black; padding: 12px 20px;">
                            <h3 style="font-size: 20px; color: black; margin: 0;">
                                Site information
                            </h3>
                        </div>

                        {{-- Form Body --}}
                        <div class="link-body" style="padding: 20px;">

                            <div class="form-group row align-items-center mb-2">
                                <label class="col-md-4 label-control"> Address Line 1 <span
                                        style="color:red;">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" id="address_line_1" class="form-control" name="address_line_1"
                                        onkeyup="lookup(this);" placeholder="Address line one *" value="" required>
                                    <p class="text-danger address"
                                        style="padding-left: 5px; width:100%; display: none; margin-bottom: 0; margin-top: 5px;">
                                        Address Field is Required !</p>
                                </div>
                            </div>

                            <div class="form-group row align-items-center mb-2">
                                <label class="col-md-4 label-control"> Address Line 2 </label>
                                <div class="col-md-8">
                                    <input type="text" id="address_line_2" class="form-control" name="address_line_2"
                                        placeholder="Address line two " value="">
                                </div>
                            </div>

                            <div class="form-group row align-items-center mb-2">
                                <label class="col-md-4 label-control"> Address Line 3 </label>
                                <div class="col-md-8">
                                    <input type="text" id="address_line_3" class="form-control" name="address_line_3"
                                        placeholder="Address line three " value="">
                                </div>
                            </div>

                            <div class="form-group row align-items-center mb-2">
                                <label class="col-md-4 label-control"> Address Line 4 </label>
                                <div class="col-md-8">
                                    <input type="text" id="address_line_4" class="form-control" name="address_line_4"
                                        placeholder="Address line four " value="">
                                </div>
                            </div>

                            <div class="form-group row align-items-center mb-2">
                                <label class="col-md-4 label-control"> City / Town <span
                                        style="color:red;">*</span></label>
                                <div class="col-md-8">
                                    <select name="city" id="city" class="form-control select2">
                                        @foreach ($cities as $city)
                                            <option value="{{ $city }}">{{ $city }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row align-items-center mb-2">
                                <label class="col-md-4 label-control"> Postcode <span style="color:red;">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" id="postcode" class="form-control" name="postcode"
                                        onkeyup="lookup(this);" placeholder="Postcode *" value="" required>
                                </div>
                            </div>

                            <div class="form-group row align-items-center mb-2 Poof_div">
                                <label class="col-md-4 label-control">Proof of site (?)<span
                                        style="color:red;">*</span></label>
                                <div class="col-md-8">
                                    <input type="file" name="proof" accept="image/*,.doc, .docx,.pdf"
                                        class="d-none" id="file_input">
                                    <div style="display: flex; align-items: center;">
                                        <input type="button" id="proof_of_main_contact" class="form-control form-btn"
                                            value="Document Upload" name="contact" placeholder="Document Upload ">
                                        <button type="button" class="btn btn-primary btn-sm view-btn round"
                                            style="display: none; padding: 7px 15px; margin-top: 0;">
                                            <a href="" id="view_file" target="_blank"
                                                style="color: white; text-decoration: none;">View</a>
                                        </button>
                                    </div>
                                    <p class="text-danger file_proof"
                                        style="padding-left: 5px; width:100%; display: none; margin-bottom: 0; margin-top: 5px;">
                                        Trading name proof is Required !</p>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Flexbox Footer applied --}}
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
@endsection

@section('script')
    <script src="/modules/admin/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>

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
            // Only fix height on desktop to prevent footer cut-off on mobile
            if ($(window).width() > 768) {
                var contentHeight = $('#contens').height();
                $('#contens').height(contentHeight);
            }
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
                if ($(window).width() > 768) {
                    var contentHeight = $('#contens').height();
                    $('#contens').height(contentHeight);
                }
            } else {
                $('.Poof_div').hide();
                if ($(window).width() > 768) {
                    $('#contens').height('auto');
                }
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
            if (id !== "address_line_2" && id !== "address_line_3" && id !== "address_line_4" && id !== "city" && id !==
                "postcode") {
                if (trading_name === "") {
                    $(`#${id}`).attr("style", "border:2px solid red!important;");
                    status = false;
                } else {
                    $(`#${id}`).attr("style", "border:2px solid black!important;");
                    $(`.${id}`).hide();
                }
            } else {
                if (trading_name === "") {
                    $(`#${id}`).attr("style", "border:2px solid red!important;margin-top: 0px ");
                    status = false;
                } else {
                    $(`#${id}`).attr("style", "border:2px solid black!important;margin-top: 0px;");
                    $(`.${id}`).hide();
                }
            }
        }
    </script>

    <script>
        function submitDetailsForm() {
            let address_line_1 = $(`#address_line_1`).val();
            let city = $(`#city`).val();
            let postcode = $(`#postcode`).val();

            let status = true;

            if (address_line_1 === "") {
                $(`#address_line_1`).attr('style', 'border:2px solid red!important;');
                status = false;
            } else {
                $(`#address_line_1`).attr('style', 'border:2px solid black!important;');
            }

            if (city === "") {
                $(`#city`).attr('style', 'border:2px solid red!important;');
                status = false;
            } else {
                $(`#city`).attr('style', 'border:2px solid black!important;');
            }

            if (postcode === "") {
                $(`#postcode`).attr('style', 'border:2px solid red!important;');
                status = false;
            } else {
                $(`#postcode`).attr('style', 'border:2px solid black!important;');
            }

            let file = $('input[type=file]').val();
            if (file === "" && $('.Poof_div').is(':visible')) {
                $(`#proof_of_main_contact`).attr('style', 'border:2px solid red!important');
                status = false;
            }

            if (status) {
                $("form").submit();
            } else {
                return false;
            }
        }
    </script>
@endsection

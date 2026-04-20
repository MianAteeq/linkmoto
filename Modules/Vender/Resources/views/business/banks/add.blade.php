@extends('vender::layouts.master')

@section('css_custom')
    <style>
        /* --- Global Customizations --- */
        .headerbg-custom {
            padding: 15px 15px 0 15px;
        }

        /* --- Sidebar Styles --- */
        .sidebar-box {
            border-radius: 7px;
            border: 2px solid black;
            margin-bottom: 20px;
            background-color: white;
        }

        .sidebar-title {
            font-weight: 600;
            font-size: 17px;
            padding: 10px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sidebar-title img {
            width: 22px;
        }

        .sidebar-help-header {
            border-top: 2px solid black;
            padding: 10px 13px;
            color: black;
            font-weight: 600;
            margin: 0;
        }

        /* --- Accordion Customizations --- */
        .accordion .card-header {
            color: black !important;
            padding: 1rem !important;
            border-top: 2px solid rgba(0, 0, 0, 0.1);
        }

        .accordion .card-title {
            font-weight: 600;
            font-size: 1rem;
            margin: 0;
        }

        .accordion .card-body {
            color: black;
            padding-top: 0;
        }

        /* --- Main Form Container --- */
        .main-container {
            border: 2px solid black;
            border-radius: 6px;
            margin-bottom: 30px;
            background-color: white;
        }

        .main-header {
            border-bottom: 2px solid black;
            padding: 10px 15px;
        }

        .main-header h3 {
            font-size: 20px;
            color: black;
            margin: 0;
        }

        .form-body {
            padding: 20px 15px;
        }

        /* --- Form Inputs & Controls --- */
        .form-control-custom {
            border: 2px solid black !important;
            border-radius: 7px;
            height: auto;
            padding: 8px 12px;
            width: 100%;
            box-sizing: border-box;
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

        /* File Upload Specific */
        .file-upload-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .form-btn-file {
            text-align: left;
            color: #babfcc;
            padding: 8px 14px;
            cursor: pointer;
            flex-grow: 1;
        }

        .view-btn {
            background-color: #ff822f !important;
            border-color: #ff822f !important;
            color: white !important;
            padding: 8px 15px;
        }

        /* Required Asterisk */
        .required-star {
            color: red;
        }

        /* Validation Text */
        .validation-msg {
            color: red;
            font-size: 0.85rem;
            margin-top: 5px;
            margin-bottom: 0;
            display: none;
        }

        /* --- Footer & Actions --- */
        .form-actions {
            border-top: 2px solid black;
            padding: 15px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-dark-custom {
            border-color: black !important;
            background-color: black !important;
            color: #FFFFFF !important;
            border-radius: 0.5rem;
            padding: 8px 25px;
            font-weight: 500;
        }

        /* --- RESPONSIVE MEDIA QUERIES --- */
        @media (max-width: 767.98px) {
            .headerbg-custom {
                padding-left: 15px !important;
            }

            /* Stack both columns full width */
            .col-md-3,
            .col-md-9 {
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

            /* All inputs same full width */
            .form-control-custom,
            .form-btn-file {
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
            }

            /* File upload wrapper stacks nicely */
            .file-upload-wrapper {
                flex-direction: column;
                align-items: stretch;
            }

            .view-btn {
                width: 100%;
                text-align: center;
            }

            /* Footer buttons stack full width */
            .form-actions {
                flex-direction: column;
                justify-content: center;
                padding: 10px !important;
            }

            .btn-dark-custom {
                width: 100%;
                text-align: center;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494; margin: 0;">
            <div class="col-12 bg-white headerbg-custom">
                <h3 class="h3">Add New Bank Account</h3>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Business</a></li>
                        <li class="breadcrumb-item"><a style="color: black" href="{{ route('vender.bank') }}">Bank</a></li>
                        <li class="breadcrumb-item">Add New Bank Account</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row mt-3">

        <div class="col-12 col-lg-3 mb-3">
            <div class="sidebar-box">
                <h4 class="sidebar-title">
                    <img src="/home.png" alt="Icon"> Add New Bank Account
                </h4>

                <h4 class="sidebar-help-header">Help information:</h4>

                <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                    <div class="card accordion collapse-icon accordion-icon-rotate mb-0" style="box-shadow: none;">

                        <a id="business_VAT" class="card-header info collapsed" data-toggle="collapse"
                            href="#collapsebusiness_vat" aria-expanded="false">
                            <div class="card-title">Label (?)</div>
                        </a>
                        <div id="collapsebusiness_vat" data-parent="#accordionWrap1" class="collapse">
                            <div class="card-content">
                                <div class="card-body">
                                    Give this account a short name so you can recognise it later when selecting for invoices
                                    or payouts. For example: Main Business Account, Refunds Account, Payout Account, or
                                    Site A – Payments.
                                </div>
                            </div>
                        </div>

                        <a id="business_bank_proof" class="card-header info collapsed" data-toggle="collapse"
                            href="#collapsebusiness_bank_proof" aria-expanded="false">
                            <div class="card-title">Proof of bank account (?)</div>
                        </a>
                        <div id="collapsebusiness_bank_proof" data-parent="#accordionWrap1" class="collapse">
                            <div class="card-content">
                                <div class="card-body">
                                    Even if your bank account matches your registered business or trading name, we still
                                    require proof to confirm the account belongs to your business. This keeps payouts secure
                                    and ensures compliance with UK regulations. <br><br>
                                    Upload a document that clearly shows your business name, sort code, and account number.
                                    Accepted documents include:
                                    <ul>
                                        <li>Recent bank statement (within 3 months)</li>
                                        <li>Void cheque or paying-in slip</li>
                                        <li>Official letter from your bank</li>
                                    </ul>
                                    Screenshots from online banking are acceptable if they clearly show these details.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-9">
            <div class="main-container">

                <div class="main-header">
                    <h3>Bank Account Information</h3>
                </div>

                <form action="{{ route('vender.bank.store') }}" method="POST" enctype="multipart/form-data"
                    id="bankDetailsForm">
                    @csrf
                    <div class="form-body">

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Label (?) <span class="required-star">*</span></label>
                            <div class="col-md-8">
                                <input type="text" id="label" name="label" class="form-control-custom"
                                    placeholder="Enter Your Label *" onkeyup="lookup(this);" required>
                                <p class="validation-msg label-error">Label Field is Required!</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Bank name <span class="required-star">*</span></label>
                            <div class="col-md-8">
                                <input type="text" id="bank_name" name="bank_name" class="form-control-custom"
                                    placeholder="Enter Your Bank Name" onkeyup="lookup(this);" required>
                                <p class="validation-msg bank_name-error">Bank name Field is Required!</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Account name <span class="required-star">*</span></label>
                            <div class="col-md-8">
                                <input type="text" id="account_name" name="account_name" class="form-control-custom"
                                    placeholder="Enter Your Account name" onkeyup="lookup(this);" required>
                                <p class="validation-msg account_name-error">Account name Field is Required!</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Sort Code</label>
                            <div class="col-md-8">
                                <input type="text" id="sort_code" name="sort_code" class="form-control-custom"
                                    placeholder="Enter Your Sort Code">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Account Number <span
                                    class="required-star">*</span></label>
                            <div class="col-md-8">
                                <input type="text" id="account_number" name="account_number"
                                    class="form-control-custom" placeholder="Enter Your Account Number *"
                                    onkeyup="lookup(this);" required>
                                <p class="validation-msg account_number-error">Account Number Field is Required!</p>
                            </div>
                        </div>

                        <div class="form-group row Poof_div">
                            <label class="col-md-4 col-form-label">Proof of bank account (?) <span
                                    class="required-star">*</span></label>
                            <div class="col-md-8">
                                <div class="file-upload-wrapper">
                                    <input type="file" name="proof" accept="image/*,.doc,.docx,.pdf" class="d-none"
                                        id="hidden_file_input">
                                    <input type="button" id="proof_of_main_contact"
                                        class="form-control-custom form-btn-file" value="Document Upload">
                                    <a href="#" id="view_file" target="_blank" class="btn btn-sm view-btn"
                                        style="display: none;">View</a>
                                </div>
                                <p class="validation-msg proof-error">Proof of bank account is Required!</p>
                            </div>
                        </div>

                    </div>

                    <div class="form-actions" style="padding: 15px;">
                        <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-dark-custom">Cancel</a>
                        <button type="button" onclick="submitDetailsForm()" class="btn btn-dark-custom">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            // Trigger hidden file input
            $('#proof_of_main_contact').click(function() {
                $('#hidden_file_input').trigger('click');
            });

            // Handle file selection
            $('#hidden_file_input').change(function(e) {
                if (e.target.files.length > 0) {
                    var fileName = e.target.files[0].name;
                    $('#proof_of_main_contact').val(fileName);
                    $('#proof_of_main_contact').removeClass('is-invalid');
                    $('#view_file').show().attr('href', URL.createObjectURL(e.target.files[0]));
                    $('.proof-error').hide();
                }
            });

        });

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
            let requiredFields = ['label', 'bank_name', 'account_name', 'account_number'];
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

            if ($('.Poof_div').is(':visible')) {
                let file = $('#hidden_file_input').val();
                if (file === "") {
                    $('#proof_of_main_contact').addClass('is-invalid');
                    $('.proof-error').show();
                    isValid = false;
                } else {
                    $('#proof_of_main_contact').removeClass('is-invalid');
                    $('.proof-error').hide();
                }
            }

            if (isValid) {
                $("#bankDetailsForm").submit();
            }
        }
    </script>
@endsection

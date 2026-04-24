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
            position: relative;
            /* Ensure collapse icons position correctly inside */
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

        /* --- Form Inputs & Displays --- */
        .form-control-custom {
            border: 2px solid black !important;
            border-radius: 7px;
            padding: 8px 12px;
            width: 100%;
            max-width: 400px;
            background-color: white;
        }

        .form-control-custom:focus {
            color: #4e5154;
            border-color: black;
            outline: 0;
            box-shadow: none;
        }

        .form-control-custom.is-invalid {
            border-color: red !important;
        }

        .validation-msg {
            color: red;
            font-size: 0.85rem;
            margin-top: 5px;
            margin-bottom: 0;
            display: none;
        }

        .bank-info-display {
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 7px;
            border: 1px solid #d1d5db;
            max-width: 400px;
            display: block;
            line-height: 1.6;
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
            transition: opacity 0.2s ease-in-out;
        }

        .btn-dark-custom:hover {
            opacity: 0.8;
            color: white !important;
        }

        /* --- Tablet & Mobile Specific Enhancements (Up to 991px) --- */
        @media (max-width: 991px) {
            .headerbg-custom {
                padding-left: 15px;
            }

            .form-control-custom,
            .bank-info-display {
                max-width: 100%;
            }

            .form-group.row {
                margin-bottom: 1.5rem;
            }

            /* Fixed button stretching and alignment on mobile */
            .form-actions {
                flex-direction: column;
                align-items: center;
                /* Centers the buttons horizontally */
                gap: 15px;
                /* Adds healthy spacing between the stacked buttons */
                padding: 20px 15px;
            }

            .btn-dark-custom {
                width: 85%;
                /* Reduces width so they don't touch the borders */
                margin: 0 !important;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494; margin: 0;">
            <div class="col-12 bg-white headerbg-custom">
                <h3 class="h3">Add Payout Account</h3>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Billing</a></li>
                        <li class="breadcrumb-item"><a style="color: black" href="{{ route('vender.bank') }}">Payout
                                Account</a></li>
                        <li class="breadcrumb-item">Edit Payout Account</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row mt-2">

        <div class="col-lg-3 col-12 mb-3">
            <div class="sidebar-box">
                <h4 class="sidebar-title">
                    <img src="/home.png" alt="Icon"> Edit Payout Account
                </h4>

                <h4 class="sidebar-help-header">Help information:</h4>

                <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                    <div class="card accordion collapse-icon accordion-icon-rotate mb-0" style="box-shadow: none;">
                        <a id="business_VAT" class="card-header info collapsed" data-toggle="collapse"
                            href="#collapsebusiness_vat" aria-expanded="false">
                            <div class="card-title">Bank account (?)</div>
                        </a>
                        <div id="collapsebusiness_vat" data-parent="#accordionWrap1" class="collapse">
                            <div class="card-content">
                                <div class="card-body">
                                    Select a <strong>verified bank account</strong> to receive payouts and refunds from the
                                    platform. Only verified accounts appear in this list. If you don’t see your bank
                                    account, please add and verify it first under <strong>Business > Bank Accounts.</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-12">
            <div class="main-container">

                <div class="main-header">
                    <h3>Payout Account Information</h3>
                </div>

                <form action="{{ route('vender.payout.save') }}" method="POST" id="payoutForm">
                    @csrf
                    <div class="form-body">

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Bank account (?) <span
                                    style="color:red;">*</span></label>
                            <div class="col-md-8">
                                <select name="bank_id" id="bank_id" class="form-control-custom select2">
                                    <option value="">Select Bank Account</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank['id'] }}"
                                            @if ($bank['is_payout'] == 1) selected @endif>
                                            {{ $bank['bank_name'] }} - {{ $bank['account_name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="validation-msg bank_id-error">Please select a bank account!</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label"></label>
                            <div class="col-md-8">
                                <div class="show_bank_info bank-info-display"
                                    style="@if (!collect($banks)->contains('is_payout', 1)) display: none; @endif">
                                    @foreach ($banks as $bank)
                                        @if ($bank['is_payout'] == 1)
                                            <strong>{{ $bank['bank_name'] }}</strong> <br>
                                            {{ $bank['account_name'] }} <br>
                                            Account: {{ $bank['account_number'] }} <br>
                                            Sort Code: {{ $bank['sort_code'] }}
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-actions" style="padding-right: 15px;">
                        <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-dark-custom"
                            style="text-decoration: none; text-align: center;">Cancel</a>
                        <button type="button" onclick="submitDetailsForm()" class="btn btn-dark-custom">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Dynamic Bank Info Display
        $('#bank_id').on('change', function() {
            // Clear validation error on change
            $(this).removeClass('is-invalid');
            $('.bank_id-error').hide();

            let bankId = this.value;
            let bankInfoContainer = $('.show_bank_info');

            if (bankId) {
                let banks = @json($banks);
                let selectedBank = banks.find((item) => item.id == bankId);

                if (selectedBank) {
                    let html = `<strong>${selectedBank.bank_name}</strong> <br>`;
                    html += `${selectedBank.account_name} <br>`;
                    html += `Account: ${selectedBank.account_number} <br>`;
                    html += `Sort Code: ${selectedBank.sort_code}`;

                    bankInfoContainer.html(html).show();
                }
            } else {
                // Hide the info box if the user goes back to "Select Bank Account"
                bankInfoContainer.html('').hide();
            }
        });

        // Validation & Submission
        function submitDetailsForm() {
            let bankDropdown = $('#bank_id');

            // Check if a bank account is actually selected
            if (bankDropdown.val() === "") {
                bankDropdown.addClass('is-invalid');
                $('.bank_id-error').show();
            } else {
                bankDropdown.removeClass('is-invalid');
                $('.bank_id-error').hide();

                // If valid, submit the form
                $("#payoutForm").submit();
            }
        }
    </script>
@endsection

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

        .sidebar-text {
            padding: 10px;
            margin: 0;
            line-height: 1.5rem;
            color: black;
            border-top: 2px solid black;
        }

        /* --- Main Content Container --- */
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

        /* --- Card Details & Footer --- */
        .info-label {
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }

        .card-footer-custom {
            border-top: 2px solid black;
            padding: 1rem 1.5rem;
            text-align: right;
        }

        .btn-custom {
            background-color: black !important;
            border-color: black !important;
            color: white !important;
            padding: 8px 24px;
            border-radius: 4px;
            font-weight: 500;
            transition: opacity 0.2s ease-in-out;
        }

        .btn-custom:hover {
            opacity: 0.8;
            color: white !important;
        }

        /* --- Tablet & Mobile Specific Enhancements (Covers up to 991px) --- */
        @media (max-width: 991px) {
            .headerbg-custom {
                padding-left: 15px;
            }

            .card-footer-custom {
                text-align: center;
                /* Center the button on mobile/tablet */
            }

            .btn-custom {
                display: block;
                width: 100%;
                /* Make button full width for easy tapping */
            }

            /* Add breathing room between stacked rows on mobile */
            .row>.col-sm-7 {
                margin-bottom: 15px;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494; margin: 0;">
            <div class="col-12 bg-white headerbg-custom">
                <h3 class="h3">Payout Account</h3>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Business</a></li>
                        <li class="breadcrumb-item">Billing</li>
                        <li class="breadcrumb-item">Payout Account</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row mt-3">

        <div class="col-lg-3 col-12 mb-3">
            <div class="sidebar-box">
                <h4 class="sidebar-title">
                    <img src="/home.png" alt="Home Icon"> Payout Account
                </h4>
                <p class="sidebar-text">
                    Payout account is your bank account where refunds and payouts from the platform will be sent.
                </p>
            </div>
        </div>

        <div class="col-lg-9 col-12" id="contens">

            <div class="main-container">

                <div class="main-header">
                    <h3>Payout Account information</h3>
                </div>

                <div class="card-content">
                    <div class="card-body px-4 py-3">

                        @if (count($banks) > 0)
                            <div class="row mt-2">
                                <div class="col-sm-5">
                                    <h6 class="info-label">ID</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ $banks[0]['id'] }}
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="info-label">Label</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ $banks[0]['label'] }}
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="info-label">Bank Name</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ $banks[0]['bank_name'] }}
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="info-label">Account Name</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ $banks[0]['account_name'] }}
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="info-label">Sort Code</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ $banks[0]['sort_code'] }}
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-5">
                                    <h6 class="info-label">Account Number</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    {{ $banks[0]['account_number'] }}
                                </div>
                            </div>
                        @else
                            <p class="mt-3 mb-3 text-center">Please add a payout account</p>
                        @endif

                    </div>

                    <div class="card-footer-custom">
                        @if (count($banks) == 0)
                            <a href="{{ route('vender.payout.edit') }}" class="btn btn-custom">Add</a>
                        @else
                            <a href="{{ route('vender.payout.edit') }}" class="btn btn-custom">Edit</a>
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection

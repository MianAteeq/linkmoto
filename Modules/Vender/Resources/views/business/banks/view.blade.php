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
            overflow-y: visible !important;
            /* Prevents double scrollbars */
        }

        .info-sidebar {
            border-radius: 7px;
            border: 2px solid black;
            height: auto;

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
            overflow-x: hidden;
            overflow-y: visible !important;
            /* Prevents the internal slider */
            height: auto !important;
        }

        .main-content-inner {
            flex-grow: 1;
            padding-bottom: 0;
            width: 100%;
        }

        /* ========================================================================
                                           2. UI ELEMENTS (FOOTERS, BUTTONS, BADGES)
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

        /* Badge Styles */
        .badge {
            display: inline-block;
            padding: 0.6em 0.6em;
            font-size: 83%;
        }

        .badge-primary {
            background-color: #1a469b;
            color: white !important;
        }

        .badge-danger {
            background-color: red;
        }

        .badge-secondary {
            background-color: rgb(0 111 192);
        }

        .badge-success {
            background-color: #28a745;
            color: white !important;
        }

        /* Internal Card Elements */
        .card-body h6 {
            font-weight: 600;
            color: black;
        }

        .text-secondary {
            color: #333 !important;
        }

        /* ========================================================================
                                           3. RESPONSIVE MEDIA QUERIES
                                           ======================================================================== */
        @media (max-width: 991.98px) {
            .headerbg {
                padding-left: 25px !important;
            }

            .info-sidebar-wrapper {
                margin-bottom: 20px;
            }

            .footers {
                padding: 15px 20px 25px 20px !important;
            }

            /* Footer buttons stretch to 100% */
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

            /* FIX: Make sure the View button shrinks to its text size */
            .btn-primary_2 {
                float: none !important;
                width: auto !important;
                display: inline-block !important;
                margin-top: 10px;
            }

            .text-secondary {
                word-break: break-word;
                margin-top: 5px;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row" style="border-bottom: 3px solid #949494; margin: 0;">
            <div class="col-12 bg-white headerbg" style="padding-left: 32px; padding-top: 13px;">
                <h3 class="h3">Bank Accounts</h3>

                <div class="breadcrumb-wrapper p-0">
                    <ol class="breadcrumb" style="padding-left: 0; background-color: transparent; margin-bottom: 10px;">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)" style="text-decoration: none; color: black;">Business</a>
                        </li>

                        <li class="breadcrumb-item">
                            <a href="{{ route('vender.bank') }}" style="text-decoration: none; color: black;">Bank
                                Accounts</a>
                        </li>

                        <li class="breadcrumb-item active">{{ $site['label'] }}</li>
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
                        <img src="/home.png" style="width: 20px;"> Bank Account
                    </h4>

                    <div
                        style="border-top: 2px solid black; padding: 14px 16px; line-height: 1.6; color: #333; font-size: 0.9rem;">
                        <strong>{{ $site['label'] }}</strong> <br>

                        @php
                            $status = $site['status'];
                            switch ($status) {
                                case 'Todo':
                                    $badgeClass = 'badge badge-secondary';
                                    break;
                                case 'Pending':
                                    $badgeClass = 'badge badge-primary text-dark';
                                    break;
                                case 'Verified':
                                    $badgeClass = 'badge badge-success';
                                    break;
                                case 'Rejected':
                                    $badgeClass = 'badge badge-danger';
                                    break;
                                default:
                                    $badgeClass = 'badge badge-light text-dark';
                                    break;
                            }
                        @endphp

                        <span class="{{ $badgeClass }}" style="margin-top:10px; margin-bottom:10px;">
                            {{ $status }}
                        </span>
                        <br>
                        Created on: {{ $site->created_at->format('d M Y, H:i') }} <br>
                        Last updated: {{ $site->updated_at->format('d M Y, H:i') }}
                    </div>

                    {{-- Conditional Sidebar Actions / Messages --}}
                    @if ($status == 'Pending')
                        <div style="border-top: 2px solid black; padding: 14px 16px; text-align: center;">
                            <a href="{{ route('vender.main.bank.verify', $site['id']) }}"
                                class="btn btn-dark round w-100 m-0">
                                Cancel Verification
                            </a>
                        </div>
                    @endif

                    @if ($status == 'Rejected')
                        <div
                            style="border-top: 2px solid black; padding: 14px 16px; line-height: 1.5rem; color: black; background-color: #fff0f0;">
                            <strong>Rejected reason:</strong> Details do not match supplied document.
                        </div>
                    @endif

                </div>
            </div>

            {{-- Main Content Box --}}
            <div class="col-12 col-md-12 col-lg-9 d-flex ps-lg-3 mb-4 w-100">
                <div class="main-content-box w-100" id="contens">

                    <div class="main-content-inner">
                        {{-- Title row --}}
                        <div style="border-bottom: 2px solid black; padding: 12px 20px;">
                            <h3 style="font-size: 20px; color: black; margin: 0;">
                                Bank information
                            </h3>
                        </div>

                        {{-- Details Content --}}
                        <div class="card-content">
                            <div class="card-body" style="padding: 20px;">
                                <div class="row mb-1">
                                    <div class="col-sm-4">
                                        <h6 class="mb-0">ID</h6>
                                    </div>
                                    <div class="col-sm-8 text-secondary">{{ $site['id'] }}</div>
                                </div>
                                <hr style="margin-top: 10px; margin-bottom: 10px;">

                                <div class="row mb-1">
                                    <div class="col-sm-4">
                                        <h6 class="mb-0">Label</h6>
                                    </div>
                                    <div class="col-sm-8 text-secondary">{{ $site['label'] }}</div>
                                </div>
                                <hr style="margin-top: 10px; margin-bottom: 10px;">

                                <div class="row mb-1">
                                    <div class="col-sm-4">
                                        <h6 class="mb-0">Bank Name</h6>
                                    </div>
                                    <div class="col-sm-8 text-secondary">{{ $site['bank_name'] }}</div>
                                </div>
                                <hr style="margin-top: 10px; margin-bottom: 10px;">

                                <div class="row mb-1">
                                    <div class="col-sm-4">
                                        <h6 class="mb-0">Account Name</h6>
                                    </div>
                                    <div class="col-sm-8 text-secondary">{{ $site['account_name'] }}</div>
                                </div>
                                <hr style="margin-top: 10px; margin-bottom: 10px;">

                                <div class="row mb-1">
                                    <div class="col-sm-4">
                                        <h6 class="mb-0">Sort Code</h6>
                                    </div>
                                    <div class="col-sm-8 text-secondary">{{ $site['sort_code'] }}</div>
                                </div>
                                <hr style="margin-top: 10px; margin-bottom: 10px;">

                                <div class="row mb-1">
                                    <div class="col-sm-4">
                                        <h6 class="mb-0">Account Number</h6>
                                    </div>
                                    <div class="col-sm-8 text-secondary">{{ $site['account_number'] }}</div>
                                </div>
                                <hr style="margin-top: 10px; margin-bottom: 10px;">

                                <div class="row mb-1">
                                    <div class="col-sm-4">
                                        <h6 class="mb-0">Linked</h6>
                                    </div>
                                    <div class="col-sm-8 text-secondary">No</div>
                                </div>
                                <hr style="margin-top: 10px; margin-bottom: 10px;">

                                <div class="row mb-1 align-items-center">
                                    <div class="col-sm-4">
                                        <h6 class="mb-0">Proof of bank account</h6>
                                    </div>
                                    <div class="col-sm-8 text-secondary">
                                        @if ($site['proof'] != null)
                                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                                <span>Upload.{{ Str::after($site['proof'], '.') ?? 'N/A' }}</span>
                                                <a class="btn btn-dark round btn-min-width btn-primary_2 m-0"
                                                    target="_blank" href="{{ URL::to($site['proof'] ?? '') }}">View</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <hr style="margin-top: 10px; margin-bottom: 10px;">

                                <div class="row">
                                    <div class="col-sm-4">
                                        <h6 class="mb-0">Status</h6>
                                    </div>
                                    <div class="col-sm-8 text-secondary">{{ $site['status'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer with Edit Button --}}
                    @if ($site['status'] != 'Pending' && $site['status'] != 'Verified')
                        <div class="footers mt-auto">
                            <a href="{{ route('vender.bank.edit', $site['id']) }}">
                                <button type="button" class="btn btn-dark round btn-min-width m-0">Edit</button>
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/modules/admin/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>

    {{-- SIDEBAR FIX --}}
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
@endsection

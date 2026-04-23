@extends('vender::layouts.master')

@section('css_custom')
    <link rel="stylesheet" type="text/css" href="/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <style>
        /* --- OVERRIDES FOR EXACT THEME MATCH --- */

        /* 1. Master Box Styling (Thick Borders, No Shadows) */
        .theme-box {
            border: 2px solid #000 !important;
            border-radius: 5px !important;
            background-color: #fff !important;
            overflow: hidden;
            /* Keeps child borders inside */
        }

        /* 2. Header Styling (Thick black bottom border) */
        .theme-box-header {
            padding: 1.2rem 1.5rem !important;
            border-bottom: 2px solid #000 !important;
            /* The critical missing line */
            background-color: #fff !important;
            color: #000 !important;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
        }

        /* Left Sidebar specific header */
        .sidebar-header-custom {
            font-weight: 700;
            gap: 12px;
        }

        /* Right Accordion specific header */
        .accordion-header-custom {
            justify-content: space-between;
            cursor: pointer;
            text-decoration: none !important;
            border-bottom: none !important;
        }

        /* Put the border on the collapsible content so it hides when closed */
        #collaptr_businesss_info {
            border-top: 2px solid #000 !important;
        }

        /* 3. Row & Alignment Styling */
        .theme-row {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e0e0e0;
            margin: 0;
        }

        .theme-row:last-child {
            border-bottom: none !important;
            /* Removes border from last item */
        }

        /* 4. Text Contrast */
        .theme-label {
            color: #6c757d !important;
            /* Medium Grey */
            font-size: 0.95rem;
            font-weight: 400;
            margin: 0;
            padding-right: 15px;
        }

        .theme-value {
            color: #000 !important;
            /* Pure Black */
            font-size: 0.95rem;
            font-weight: 400;
            margin: 0;
        }

        /* 5. Badges & Buttons */
        .badge-pending-custom {
            background-color: #1e3b8a !important;
            /* Exact Dark Blue */
            color: #fff !important;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .btn-view-custom {
            background-color: #000 !important;
            color: #fff !important;
            padding: 8px 24px;
            border-radius: 4px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none !important;
            display: inline-block;
        }

        .btn-view-custom:hover {
            background-color: #333 !important;
        }

        /* Ensure flex columns align properly on mobile */
        @media (max-width: 767px) {
            .theme-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .theme-label {
                margin-bottom: 0.5rem;
            }

            .btn-wrapper {
                width: 100%;
                text-align: left !important;
                margin-top: 10px;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white shadow-sm mb-2">
        <div class="container-fluid" style="border-bottom: 3px solid #949494;">
            <div class="row px-md-4 py-3 align-items-center"
                style="padding-left: 10px !important; padding-top: 15px !important; padding-bottom: 23px !important;">
                <div class="col-12 bg-white">
                    <h3 class="h3">Business Information</h3>
                    <div class="breadcrumb-wrapper" style="padding-left: 3px !important;">
                        <ol class="breadcrumb mb-0 bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-muted">Business</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('vender.business.detail') }}"
                                    class="text-dark">Detail</a>
                            </li>
                            <li class="breadcrumb-item active text-muted">Business information</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid px-md-4" style="padding-left: 2px !important;">
        <div class="row">

            <div class="col-xl-4 col-lg-4 mb-4">
                <div class="theme-box w-100">

                    <div class="theme-box-header sidebar-header-custom">
                        <img src="/home.png" style="width: 20px;" alt="Home">
                        <span>Business Information</span>
                    </div>

                    <div style="padding: 1.5rem;">
                        @php
                            $status = $user['profile']['business_info'];
                        @endphp

                        <div class="mb-3">
                            <strong class="d-block mb-2" style="font-size: 1.05rem; color: #000;">
                                {{ $user['profile']['organization_status'] }}
                            </strong>
                            <span class="badge-pending-custom">
                                {{ $status }}
                            </span>
                        </div>

                        <div style="font-size: 0.9rem; color: #111;">
                            <p class="mb-1">
                                Created on: {{ $user['profile']->created_at->format('d M Y,') }}<br>
                                {{ $user['profile']->created_at->format('H:i') }}
                            </p>
                            <p class="mb-0">
                                Last updated: {{ $user['profile']->updated_at->format('d M Y,') }}<br>
                                {{ $user['profile']->updated_at->format('H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-lg-8 mb-4">
                <div class="theme-box w-100 d-flex flex-column">

                    <a href="javascript:void(0);" class="theme-box-header accordion-header-custom"
                        onclick="toggleCollapse(this)" data-target="#collaptr_businesss_info">
                        <span>Business information</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="18 15 12 9 6 15"></polyline>
                        </svg>
                    </a>

                    <div id="collaptr_businesss_info" class="flex-grow-1" style="display: block;">

                        <div class="row theme-row">
                            <div class="col-sm-4 px-0">
                                <p class="theme-label">ID</p>
                            </div>
                            <div class="col-sm-8 px-0">
                                <p class="theme-value">BSN{{ sprintf('%07d', $user['id']) }}</p>
                            </div>
                        </div>

                        <div class="row theme-row">
                            <div class="col-sm-4 px-0">
                                <p class="theme-label">Business setup</p>
                            </div>
                            <div class="col-sm-8 px-0">
                                <p class="theme-value">{{ $user['profile']['organization_status'] }}</p>
                            </div>
                        </div>

                        <div class="row theme-row">
                            <div class="col-sm-4 px-0">
                                <p class="theme-label">
                                    Registered @if (in_array($user['profile']['organization_status'], ['Limited Liability Partnership (LLP)', 'Limited Company (Ltd)']))
                                        company
                                    @endif name
                                </p>
                            </div>
                            <div class="col-sm-8 px-0">
                                <p class="theme-value">{{ $user['profile']['company_name'] }}</p>
                            </div>
                        </div>

                        @if (in_array($user['profile']['organization_status'], ['Limited Liability Partnership (LLP)', 'Limited Company (Ltd)']))
                            <div class="row theme-row">
                                <div class="col-sm-4 px-0">
                                    <p class="theme-label">Registered company number</p>
                                </div>
                                <div class="col-sm-8 px-0">
                                    <p class="theme-value">{{ $user['profile']['registration_no'] }}</p>
                                </div>
                            </div>
                            <div class="row theme-row">
                                <div class="col-sm-4 px-0">
                                    <p class="theme-label">Registered company jurisdiction</p>
                                </div>
                                <div class="col-sm-8 px-0">
                                    <p class="theme-value">{{ $user['profile']['company_jurisdiction'] }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="row theme-row">
                            <div class="col-sm-4 px-0">
                                <p class="theme-label">
                                    Registered @if (in_array($user['profile']['organization_status'], ['Limited Liability Partnership (LLP)', 'Limited Company (Ltd)']))
                                        company
                                    @endif address
                                </p>
                            </div>
                            <div class="col-sm-8 px-0">
                                <p class="theme-value">
                                    {{ $user['profile']['address_line_1'] }}
                                    @if ($user['profile']['address_line_2'])
                                        , {{ $user['profile']['address_line_2'] }}
                                    @endif
                                    , {{ $user['profile']['city'] }} , {{ $user['profile']['postcode'] }}
                                </p>
                            </div>
                        </div>

                        @if ($user['profile']['organization_status'] == 'Sole Trader / Self Employed')
                            <div class="row theme-row">
                                <div class="col-sm-4 px-0">
                                    <p class="theme-label">Companies House Proof</p>
                                </div>
                                <div class="col-sm-8 px-0 text-right btn-wrapper">
                                    <a class="btn-view-custom" target="_blank"
                                        href="{{ URL::to($user['profile']['document_proof'] ?? '#') }}">View</a>
                                </div>
                            </div>
                        @endif

                        @if (in_array($user['profile']['organization_status'], ['General Partnership', 'Sole Trader / Self-Employed']))
                            <div class="row theme-row">
                                <div class="col-sm-4 px-0">
                                    <p class="theme-label">Proof of business registration</p>
                                </div>
                                <div class="col-sm-8 px-0">
                                    @if ($user['profile']['document_proof_name'] != null)
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <span class="theme-value">{{ $user['profile']['document_proof_name'] }}</span>
                                            <a class="btn-view-custom" target="_blank"
                                                href="{{ URL::to($user['profile']['document_proof']) }}">View</a>
                                        </div>
                                    @else
                                        <span style="color: #d9534f; font-weight: 500;">Proof documentation upload
                                            required</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row theme-row">
                                <div class="col-sm-4 px-0">
                                    <p class="theme-label">Proof of trading activity</p>
                                </div>
                                <div class="col-sm-8 px-0">
                                    @if ($user['profile']['trading_activity'] != null)
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <span class="theme-value">{{ $user['profile']['document_proof_name'] }}</span>
                                            <a class="btn-view-custom" target="_blank"
                                                href="{{ URL::to($user['profile']['trading_activity']) }}">View</a>
                                        </div>
                                    @else
                                        <span style="color: #d9534f; font-weight: 500;">Proof documentation upload
                                            required</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="row theme-row">
                            <div class="col-sm-4 px-0">
                                <p class="theme-label">Verification Status</p>
                            </div>
                            <div class="col-sm-8 px-0">
                                <p class="theme-value">{{ $user['profile']['business_info'] }}</p>
                            </div>
                        </div>

                        {{-- EDIT BUTTON MOVED HERE: Now inside the collapse div so it hides when closed --}}
                        @if ($user['profile']['business_info'] == 'Todo' || $user['profile']['business_info'] == 'Rejected')
                            <div class="mt-auto p-1 text-right">
                                <a href="{{ route('vender.business.information.edit') }}"
                                    class="btn-view-custom">Edit</a>
                            </div>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Simple toggle for the accordion content
        function toggleCollapse(element) {
            const targetId = element.getAttribute('data-target');
            const content = document.querySelector(targetId);

            if (content.style.display === 'none') {
                content.style.display = 'block';
            } else {
                content.style.display = 'none';
            }
        }
    </script>
@endsection

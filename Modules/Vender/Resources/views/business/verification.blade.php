@extends('vender::layouts.master')

@section('css_custom')
    <style>
        /* Custom Containers */
        .info-sidebar {
            border-radius: 7px;
            border: 2px solid black;
            height: 100%;
        }

        .main-content-box {
            border: 2px solid black;
            border-radius: 6px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            background-color: white;
        }

        /* Section Styling */
        .section {
            border-bottom: 1px solid #000;
            overflow: hidden;
        }

        .section:last-child {
            border-bottom: none;
        }

        .section-header {
            font-weight: bold;
            font-size: 16px;
            padding: 10px 15px;
            border-bottom: 1px solid #000;
            background: #fafbfc;
            color: black;
        }

        .section-body {
            padding: 10px 15px;
        }

        .item {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
            gap: 10px;
        }

        .item:last-child {
            border-bottom: none;
        }

        .item a {
            color: black;
            text-decoration: none;
            font-weight: 500;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            color: #fff;
            display: inline-block;
            text-align: center;
            min-width: 80px;
        }

        .badge.todo {
            background: #6c757d;
        }

        .badge.pending {
            background: #ffc107;
            color: #212529;
        }

        .badge.verified {
            background: #28a745;
        }

        .badge.badge-danger {
            background: #dc3545;
        }

        .badge.badge-light {
            background: #f8f9fa;
            border: 1px solid #ddd;
        }

        .timestamp {
            font-size: 12px;
            color: #555;
            text-align: right;
            white-space: nowrap;
        }

        /* --- RESPONSIVE MEDIA QUERIES --- */
        @media (max-width: 767.98px) {
            .headerbg {
                padding-left: 25px !important;
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

            /* Gap between sidebar and main box */
            .info-sidebar-wrapper {
                margin-bottom: 15px !important;
            }

            /* Prevent outer row overflow */
            .row {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            /* Remove fixed height */
            .main-content-box {
                height: auto !important;
            }

            /* Stack grid items vertically */
            .item {
                grid-template-columns: 1fr;
                row-gap: 8px;
                text-align: center;
            }

            .badge {
                justify-self: center;
                margin-top: 5px !important;
            }

            .timestamp {
                justify-self: center;
                text-align: center;
                white-space: normal;
            }
        }
    </style>
@endsection

@section('header')
    <div class="content-header bg-white">
        <div class="row m-0" style="border-bottom: 3px solid #949494;">
            <div class="col-12 bg-white headerbg" style="padding-left: 32px; padding-top: 13px;">
                <h3 class="h3">Verifications</h3>
                <div class="breadcrumb-wrapper col-12 p-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Business</a></li>
                        <li class="breadcrumb-item">Verifications</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">

        {{-- Sidebar --}}
        <div class="col-12 col-lg-3 mb-3 info-sidebar-wrapper">
            <div class="info-sidebar">
                <h4 class="h3"
                    style="font-weight: 600; font-size: 17px; padding: 1rem 0.5rem; border-bottom: 2px solid black; margin: 0;">
                    <img src="/not-pad.png" style="width: 30px; margin-top: -5px;"> Verifications
                </h4>
                <p style="padding: 15px 10px; line-height: 1.5rem; color: black; margin: 0;">
                    Track the status of key business items that require approval: <br><br>
                    <strong>• Business Verification</strong> (registration) <br>
                    <strong>• VAT</strong><br>
                    <strong>• Main Contacts</strong><br>
                    <strong>• Sites</strong><br>
                    <strong>• Bank Accounts</strong><br><br>
                    Each item may require supporting documents. Statuses:
                    <strong>To-Do, Pending, Verified, Rejected, Cancelled, Inactive</strong>
                </p>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="col-12 col-lg-9">
            <div class="main-content-box" id="contens">

                {{-- Business Verification --}}
                <div class="section">
                    <div class="section-header">Business Verification</div>
                    <div class="section-body">
                        <div class="item">
                            <a href="{{ route('vender.business.information') }}">{{ $user['profile']['company_name'] }}</a>
                            @php
                                $status = $user['profile']['business_info'];
                                switch ($status) {
                                    case 'Todo':
                                        $badgeClass = 'badge todo';
                                        break;
                                    case 'Pending':
                                        $badgeClass = 'badge pending';
                                        break;
                                    case 'Verified':
                                        $badgeClass = 'badge verified';
                                        break;
                                    case 'Rejected':
                                        $badgeClass = 'badge badge-danger';
                                        break;
                                    default:
                                        $badgeClass = 'badge badge-light text-dark';
                                        break;
                                }
                            @endphp
                            <span class="{{ $badgeClass }}">{{ $status }}</span>
                            <div class="timestamp">Last updated {{ $user['profile']->updated_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- VAT Verification --}}
                <div class="section">
                    <div class="section-header">VAT Verification</div>
                    <div class="section-body">
                        @if ($user['profile']['vat_register'] == 'No')
                            <div class="item">
                                <a href="{{ route('vender.business.vat') }}">UK VAT registered: No</a>
                                <span class="badge verified">Verified</span>
                                <div class="timestamp">Last updated {{ $user['profile']->updated_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                        @else
                            <div class="item">
                                <a href="{{ route('vender.business.vat') }}">UK VAT registered: Yes</a>
                                @php
                                    $status = $user['profile']['vat_info'];
                                    switch ($status) {
                                        case 'Todo':
                                            $badgeClass = 'badge todo';
                                            break;
                                        case 'Pending':
                                            $badgeClass = 'badge pending';
                                            break;
                                        case 'Verified':
                                            $badgeClass = 'badge verified';
                                            break;
                                        case 'Rejected':
                                            $badgeClass = 'badge badge-danger';
                                            break;
                                        default:
                                            $badgeClass = 'badge badge-light text-dark';
                                            break;
                                    }
                                @endphp
                                <span class="{{ $badgeClass }}">{{ $status }}</span>
                                <div class="timestamp">Last updated
                                    {{ $user['profile']->updated_at->format('d M Y, H:i') }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Main Contacts Verification --}}
                <div class="section">
                    <div class="section-header">Main Contacts Verification</div>
                    <div class="section-body">
                        <div class="item">
                            <a href="{{ route('vender.main.contact.view', $user['id']) }}">
                                {{ $user['name'] }} {{ $user['middle_name'] }} {{ $user['last_name'] }}
                            </a>
                            @php
                                $status = $user['user_verified'];
                                switch ($status) {
                                    case 'Todo':
                                        $badgeClass = 'badge todo';
                                        break;
                                    case 'Pending':
                                        $badgeClass = 'badge pending';
                                        break;
                                    case 'Verified':
                                        $badgeClass = 'badge verified';
                                        break;
                                    case 'Rejected':
                                        $badgeClass = 'badge badge-danger';
                                        break;
                                    default:
                                        $badgeClass = 'badge badge-light text-dark';
                                        break;
                                }
                            @endphp
                            <span class="{{ $badgeClass }}">{{ $status }}</span>
                            <div class="timestamp">Last updated {{ $user->updated_at->format('d M Y, H:i') }}</div>
                        </div>

                        @foreach ($users as $main)
                            <div class="item">
                                <a href="{{ route('vender.main.contact.view', $main['id']) }}">
                                    {{ $main['name'] }} {{ $main['middle_name'] }} {{ $main['last_name'] }}
                                </a>
                                @php
                                    $status = $main['user_verified'];
                                    switch ($status) {
                                        case 'Todo':
                                            $badgeClass = 'badge todo';
                                            break;
                                        case 'Pending':
                                            $badgeClass = 'badge pending';
                                            break;
                                        case 'Verified':
                                            $badgeClass = 'badge verified';
                                            break;
                                        case 'Rejected':
                                            $badgeClass = 'badge badge-danger';
                                            break;
                                        default:
                                            $badgeClass = 'badge badge-light text-dark';
                                            break;
                                    }
                                @endphp
                                <span class="{{ $badgeClass }}">{{ $status }}</span>
                                <div class="timestamp">Last updated {{ $main->updated_at->format('d M Y, H:i') }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Sites Verification --}}
                <div class="section">
                    <div class="section-header">Sites Verifications</div>
                    <div class="section-body">
                        @foreach ($sites as $site)
                            <div class="item">
                                <a href="{{ route('vender.site.view', $site['id']) }}">
                                    {{ $site['address_line_1'] }} {{ $site['address_line_2'] }}
                                </a>
                                @php
                                    $status = $site['status'];
                                    switch ($status) {
                                        case 'Todo':
                                            $badgeClass = 'badge todo';
                                            break;
                                        case 'Pending':
                                            $badgeClass = 'badge pending';
                                            break;
                                        case 'Verified':
                                            $badgeClass = 'badge verified';
                                            break;
                                        case 'Rejected':
                                            $badgeClass = 'badge badge-danger';
                                            break;
                                        default:
                                            $badgeClass = 'badge badge-light text-dark';
                                            break;
                                    }
                                @endphp
                                <span class="{{ $badgeClass }}">{{ $status }}</span>
                                <div class="timestamp">Last updated {{ $site->updated_at->format('d M Y, H:i') }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Bank Accounts Verification --}}
                <div class="section">
                    <div class="section-header">Bank Accounts Verification</div>
                    <div class="section-body">
                        @foreach ($banks as $bank)
                            <div class="item">
                                <a href="{{ route('vender.bank.view', $bank['id']) }}">
                                    {{ $bank['bank_name'] }} | {{ $bank['account_name'] }} |
                                    {{ $bank['account_number'] }}
                                </a>
                                @php
                                    $status = $bank['status'];
                                    switch ($status) {
                                        case 'Todo':
                                            $badgeClass = 'badge todo';
                                            break;
                                        case 'Pending':
                                            $badgeClass = 'badge pending';
                                            break;
                                        case 'Verified':
                                            $badgeClass = 'badge verified';
                                            break;
                                        case 'Rejected':
                                            $badgeClass = 'badge badge-danger';
                                            break;
                                        default:
                                            $badgeClass = 'badge badge-light text-dark';
                                            break;
                                    }
                                @endphp
                                <span class="{{ $badgeClass }}">{{ $status }}</span>
                                <div class="timestamp">Last updated {{ $bank->updated_at->format('d M Y, H:i') }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            @if (isset($user['profile']['organization_status']))
                let orgStatus = @json($user['profile']['organization_status']);
                showHideHelpinfo(orgStatus);
            @endif

        });

        function showHideHelpinfo(value) {
            if (value === "Limited Liability Partnership (LLP)") {
                $('.company_name_text').html(
                    `This is the exact LLP name as registered at Companies House. It may be different from your trading name (the name customers see).`
                    );
                $('.company_number_text').html(
                    `This is your unique Companies House registration number (8 characters, usually letters and/or numbers) that officially identifies your LLP.`
                    );
                $('.company_address_text').html(
                    `This is the official address listed at Companies House. It may be different from your trading or garage address where customers drop off vehicles.`
                    );
            }
            if (value === "Sole Trader / Self-Employed") {
                $('.company_name_text').html(`This is the name of the person who legally owns the business.`);
                $('.company_number_text').html(``);
                $('.company_address_text').html(`This is the address where your business operates.`);
            }
            if (value === "General Partnership") {
                $('.company_name_text').html(
                    `This is the official name of your partnership. If your partnership doesn't have a formal name, you can use the owner(s) names or a commonly used garage name. <strong>A trading name will be asked separately later</strong> for customer facing purposes.`
                    );
                $('.company_number_text').html(``);
                $('.company_address_text').html(`This is the address where your business operates.`);
            }
            if (value === "Limited Company (Ltd)") {
                $('.company_name_text').html(
                    `This is the exact company name as registered at Companies House. It may be different from your trading name (the name customers see). Check your official registration documents if you're unsure.`
                    );
                $('.company_number_text').html(
                    `This is your unique Companies House registration number (8 characters, usually letters and/or numbers). It identifies your company officially and helps us verify your business.`
                    );
                $('.company_address_text').html(
                    `This is the official address listed at Companies House. It may be different from your trading or garage address where customers drop off vehicles.`
                    );
            }
        }
    </script>
@endsection

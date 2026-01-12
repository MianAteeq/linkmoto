@extends('frontend::new-layouts.master')

@section('css')
    <style>
        .collapse-icon [data-toggle="collapse"]:after {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e845";
            transition: all 300ms linear 0s;
        }

        .collapse-icon [data-toggle="collapse"]:before {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e842";
            transition: all 300ms linear 0s;
        }

        .accordinbody {
            border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;
        }

        .accordin_style {
            border-left: 2px solid black;
            margin-top: -4px;
            border-right: 2px solid black;
            border-bottom: 2px solid black;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;
        }

        .card-footer {
            border-top: 2px solid black;
            padding: 0.5rem 1rem;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            color: white;
            text-align: center;
            vertical-align: middle;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.6rem 1.6rem;
            font-size: 1rem;
            line-height: 1.25;
            border-radius: 0.5rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
    </style>
@endsection


@section('content')
    <div class="content-body">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12">
                <h3 class="h3">Business registration application</h3>
            </div>

        </div>

        <div class="row" style="margin-top: 10px;">
            <div class="col-md-4" id="contens">

                <div
                    @if (
                        $user['application_status'] == 'IN_REVIEW' &&
                            $user['profile']['business_status'] != 3 &&
                            $user['profile']['trading_name_status'] != 3 &&
                            $user['profile']['business_activities_status'] != 3 &&
                            $user['profile']['vat_status'] != 3 &&
                            $user['profile']['trade_unit_status'] != 3 &&
                            $user['profile']['main_account_status'] != 3 &&
                            $user['profile']['subscription_status'] != 3) style="border-radius: 7px;border: 2px solid black;padding: 10px;" @else style="border-radius: 7px;border: 2px solid black;padding: 10px;" @endif>
                    <h4 class="h3" style="font-weight: 600;
                font-size: 17px; "> <img src="/home.png"
                            style="width: 22px;margin-top: -5px;"> Review and submit</h2>

                        @if (
                            $user['application_status'] != 'IN_REVIEW' ||
                                $user['profile']['business_status'] == 3 ||
                                $user['profile']['trading_name_status'] == 3 ||
                                $user['profile']['business_activities_status'] == 3 ||
                                $user['profile']['vat_status'] == 3 ||
                                $user['profile']['trade_unit_status'] == 3 ||
                                $user['profile']['main_account_status'] == 3 ||
                                $user['profile']['subscription_status'] == 3)
                            <div text-center> <span class="badge badge-info "
                                    style="background-color: darkblue;margin-left: 28px "> Request for Info </span></div>
                            <p style="justify-content: center;padding-top: 19px;padding-bottom: 14px;">
                                You have answered all the required questions. Please review your supplied information. If
                                you are happy with it, then please submit the application.

                            </p>
                            <ul style="margin-left: -10px;">
                                @if ($user['profile']['is_business_info'] == 0)
                                    <li style="color:red">
                                        Your business information
                                    </li>
                                @endif
                                @if ($user['profile']['is_vat'] == 0)
                                    <li style="color:red">
                                        Your VAT
                                    </li>
                                @endif
                                @if ($user['profile']['is_trading_names'] == 0)
                                    <li style="color:red">
                                        Your Trading Name
                                    </li>
                                @endif


                                @if ($user['profile']['is_main_account'] == 0)
                                    <li style="color:red">
                                        Your Mian Contact
                                    </li>
                                @endif
                                @if ($user['profile']['is_subscription'] == 0)
                                    <li style="color:red">
                                        Your Subscription
                                    </li>
                                @endif
                                @if ($user['profile']['is_direct_debit'] == 0)
                                    <li style="color:red">
                                        Your Direct Debit Info
                                    </li>
                                @endif

                                @if ($user['profile']['is_term'] == 0)
                                    <li style="color:red">
                                        Your Term
                                    </li>
                                @endif
                            </ul>
                            <div @if (
                                $user['profile']['is_business_info'] == 0 ||
                                    $user['profile']['is_vat'] == 0 ||
                                    $user['profile']['is_trading_names'] == 0 ||
                                    $user['profile']['is_main_account'] == 0 ||
                                    $user['profile']['is_subscription'] == 0 ||
                                    $user['profile']['is_term'] == 0 ||
                                    $user['profile']['is_direct_debit'] == 0) class="foote d-none" @else class="foote" @endif
                                style="border-top: 2px solid black;padding: 5px !important;text-align: center;margin: -11px ">
                                <button type="button" class="btn btn-dark round btn-min-width mr-1 mb-1"
                                    onclick="window.location.href=`{{ route('vender.profile.submit') }}`">SUBMIT
                                    APPLICATION</button>


                            </div>
                        @else
                            <div text-center> <span class="badge badge-info "
                                    style="background-color: green;margin-left: 28px "> In review </span></div>
                            <p> <strong>Thank you for submitting the
                                    required information. </strong> </p>
                            <p> We have received all the
                                required information. Our team
                                is reviewing your submission,
                                and we will be in touch with you
                                shortly.</p>
                            <p>In the meantime, you can
                                <strong> review your application.</strong>
                            </p>
                            <p>
                                Submission date and time:
                                {{ \Carbon\Carbon::parse($user['updated_at'])->format('d/m/y H:i') }}

                            </p>
                        @endif

                </div>





            </div>

            <div class="col-md-8" style="height: auto;">
                <div class="link-body">
                    <div class="card default-collapse collapse-icon accordion-icon-rotate" style="box-shadow: none;">



                        <a id="headingCollapse14" class="card-header info collapsed"
                            @if ($user['profile']['business_status'] != 3) style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" @else style="border: 2px solid red;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" @endif
                            data-toggle="collapse" href="#collapse14" aria-expanded="false" aria-controls="collapse14">
                            <div class="card-title lead collapsed">Your Business information</div>
                        </a>
                        <div id="collapse14" role="tabpanel" aria-labelledby="headingCollapse14"
                            class="collapse accordin_style"
                            @if ($user['profile']['business_status'] != 3) style="border-color:black;" @else style="border-color: red;" @endif
                            aria-expanded="false" style="">
                            <div class="card-content">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h6 class="mb-0">Business Setup</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            {{ $user['profile']['organization_status'] }}
                                        </div>
                                    </div>
                                    <hr>
                                    @if (
                                        $user['profile']['organization_status'] == 'Limited Company (Ltd)' ||
                                            $user['profile']['organization_status'] == 'Limited Liability Partnership (LLP)')
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <h6 class="mb-0">Registered company name</h6>
                                            </div>
                                            <div class="col-sm-7 text-secondary">
                                                {{ $user['profile']['company_name'] }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <h6 class="mb-0">Registered company number</h6>
                                            </div>
                                            <div class="col-sm-7 text-secondary">
                                                {{ $user['profile']['registration_no'] }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <h6 class="mb-0">Registered company jurisdiction </h6>
                                            </div>
                                            <div class="col-sm-7 text-secondary">
                                                {{ $user['profile']['company_jurisdiction'] }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <h6 class="mb-0"> Registered company address </h6>
                                            </div>
                                            <div class="col-sm-7 text-secondary">
                                                {{ collect([
                                                    $user['profile']['address_line_1'] ?? null,
                                                    $user['profile']['address_line_2'] ?? null,
                                                    $user['profile']['address_line_3'] ?? null,
                                                    $user['profile']['address_line_4'] ?? null,
                                                    $user['profile']['city'] ?? null,
                                                    $user['profile']['postcode'] ?? null,
                                                ])->filter()->implode(', ') }}

                                            </div>
                                        </div>
                                    @else
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <h6 class="mb-0">Registered name</h6>
                                            </div>
                                            <div class="col-sm-7 text-secondary">
                                                {{ $user['profile']['company_name'] }}
                                            </div>
                                        </div>
                                        <hr>


                                        <div class="row">
                                            <div class="col-sm-5">
                                                <h6 class="mb-0"> Registered address </h6>
                                            </div>
                                            <div class="col-sm-7 text-secondary">
                                                {{ collect([
                                                    $user['profile']['address_line_1'] ?? null,
                                                    $user['profile']['address_line_2'] ?? null,
                                                    $user['profile']['address_line_3'] ?? null,
                                                    $user['profile']['address_line_4'] ?? null,
                                                    $user['profile']['city'] ?? null,
                                                    $user['profile']['postcode'] ?? null,
                                                ])->filter()->implode(', ') }}

                                            </div>
                                        </div>
                                    @endif







                                </div>
                                <div class="card-footer">
                                    @if ($user['application_status'] != 'IN_REVIEW' || $user['profile']['business_status'] == 3)
                                        <div class="text-secondary" style="text-align: right">
                                            <a href="{{ route('vender.profile.step', 1) }}"
                                                style=" background-color: black !important;
                                       border-color: black !important;"
                                                class="btn btn-primary"> Edit</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <a id="headingCollapse14" class="card-header info mt-2"
                            @if ($user['profile']['trading_name_status'] != 3) style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" @else style="border: 2px solid red;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" @endif
                            data-toggle="collapse" href="#collaptr_name" aria-expanded="false"
                            aria-controls="collaptr_name">
                            <div class="card-title lead collapsed">Trading names</div>
                        </a>
                        <div id="collaptr_name" role="tabpanel" aria-labelledby="headingCollaptr_name"
                            @if ($user['profile']['trading_name_status'] != 3) style="border-color:black;" @else style="border-color:red;" @endif
                            class="collapse accordin_style" aria-expanded="false">
                            <div class="card-content">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h6 class="mb-0">Does your business use any trading
                                                names? *</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            {{ $user['profile']['is_trading_name'] }}
                                        </div>
                                    </div>

                                    @if ($user['profile']['is_trading_name'] = 'YES')
                                        <hr>
                                        @foreach ($user['trading_names'] as $name)
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <h6 class="mb-0">Trading Name</h6>
                                                </div>
                                                <div class="col-sm-7 text-secondary">
                                                    <div class="form-group rm-{{ $name['id'] }}" style="width: 100%">
                                                        <p
                                                            style="width: 30%;
                                            float: left;">
                                                            {{ $name['name'] }}</p>


                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        @endforeach
                                    @endif







                                </div>
                                <div class="card-footer">
                                    @if ($user['application_status'] != 'IN_REVIEW' || $user['profile']['trading_name_status'] == 3)
                                        <div class="text-secondary" style="text-align: right">
                                            <a href="{{ route('vender.profile.step', 2) }}"
                                                style=" background-color: black !important;
                                       border-color: black !important;"
                                                class="btn btn-primary"> Edit</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <a id="headingCollapse14" class="card-header info mt-2"
                            @if ($user['profile']['main_account_status'] != 3) style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" @else style="border: 2px solid red;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" @endif
                            data-toggle="collapse" href="#collapmain_conatct" aria-expanded="false"
                            aria-controls="collapmain_conatct">
                            <div class="card-title lead collapsed">Main contact</div>
                        </a>
                        <div id="collapmain_conatct" role="tabpanel" aria-labelledby="headingCollapmain_conatct"
                            class="collapse accordin_style"
                            @if ($user['profile']['main_account_status'] != 3) style="border-color:  black;" @else style="border-color:  red;" @endif
                            aria-expanded="false">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h6 class="mb-0">First Name</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            {{ $user['name'] }}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h6 class="mb-0">Middle Name</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            {{ $user['middle_name'] }}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h6 class="mb-0">Last Name</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            {{ $user['last_name'] }}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            {{ $user['email'] }}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h6 class="mb-0">Mobile</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            {{ $user['profile']['phone_no'] }}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h6 class="mb-0">Role / Position</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            {{ $user['profile']['job_title'] }}
                                        </div>
                                    </div>




                                </div>
                                <div class="card-footer">
                                    @if ($user['application_status'] != 'IN_REVIEW' || $user['profile']['main_account_status'] == 3)
                                        <div class="text-secondary" style="text-align: right">
                                            <a href="{{ route('vender.profile.step', 4) }}"
                                                style=" background-color: black !important;
                                       border-color: black !important;"
                                                class="btn btn-primary"> Edit</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <a id="headingCollapsevat" class="card-header info mt-2"
                            @if ($user['profile']['vat_status'] != 3) style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" @else style="border: 2px solid red;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" @endif
                            data-toggle="collapse" href="#collapsevats" aria-expanded="false"
                            aria-controls="collapsevats">
                            <div class="card-title lead collapsed">VAT</div>
                        </a>
                        <div id="collapsevats" role="tabpanel" aria-labelledby="headingCollapsevats"
                            class="collapse accordin_style"
                            @if ($user['profile']['vat_status'] != 3) style="border-color:black;" @else style="border-color: red;" @endif
                            aria-expanded="false">
                            <div class="card-content">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h6 class="mb-0">Is your business UK VAT registered</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            {{ $user['profile']['vat_register'] }}
                                        </div>
                                    </div>

                                    @if ($user['profile']['vat_register'] == 'YES')
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <h6 class="mb-0">UK VAT Number</h6>
                                            </div>
                                            <div class="col-sm-7 text-secondary">
                                                {{ $user['profile']['uk_vat_no'] }}
                                            </div>
                                        </div>
                                    @endif







                                </div>
                                <div class="card-footer">
                                    @if ($user['application_status'] != 'IN_REVIEW' || $user['profile']['vat_status'] == 3)
                                        <div class="text-secondary" style="text-align: right">
                                            <a href="{{ route('vender.profile.step', 7) }}"
                                                style=" background-color: black !important;
                                       border-color: black !important;"
                                                class="btn btn-primary"> Edit</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>





                        <a id="headingCollapse14" class="card-header info mt-2"
                            @if ($user['profile']['subscription_status'] != 3) style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" @else style="border: 2px solid red;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" @endif
                            data-toggle="collapse" href="#collapsubs" aria-expanded="false" aria-controls="collapsubs">
                            <div class="card-title lead collapsed">Subscription</div>
                        </a>
                        <div id="collapsubs" role="tabpanel" aria-labelledby="headingCollapsubs"
                            @if ($user['profile']['subscription_status'] != 3) style="border-color:  black;" @else style="border-color:  red;" @endif
                            class="collapse accordin_style" aria-expanded="false">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h6 class="mb-0">Product Name</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            {{ $user['profile']['product_name'] }}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h6 class="mb-0">Package Name</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            {{ $user['profile']['package']['name'] ?? 'N/A' }}
                                        </div>
                                    </div>



                                </div>
                                <div class="card-footer">
                                    @if ($user['application_status'] != 'IN_REVIEW' || $user['profile']['subscription_status'] == 3)
                                        <div class="text-secondary" style="text-align: right">
                                            <a href="{{ route('vender.profile.step', 3) }}"
                                                style=" background-color: black !important;
                                       border-color: black !important;"
                                                class="btn btn-primary"> Edit</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <a id="headingCollapse14" class="card-header info mt-2"
                            @if ($user['profile']['is_privacy_policy'] === 1) style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" @else style="border: 2px solid red;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" @endif
                            data-toggle="collapse" href="#term" aria-expanded="false" aria-controls="term">
                            <div class="card-title lead collapsed">Agreements – Privacy Policy</div>
                        </a>
                        <div id="term" role="tabpanel" aria-labelledby="headingterm"
                            @if ($user['profile']['is_privacy_policy'] === 1) style="border-color:  black;" @else style="border-color:  red;" @endif
                            class="collapse accordin_style" aria-expanded="false">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h6 class="mb-0">Agreements – Privacy Policy Approved</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            YES
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    @if ($user['application_status'] != 'IN_REVIEW')
                                        <div class="text-secondary" style="text-align: right">
                                            <a href="{{ route('vender.profile.step', 9) }}"
                                                style=" background-color: black !important;
                                       border-color: black !important;"
                                                class="btn btn-primary"> Edit</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <a id="headingCollapse15" class="card-header info mt-2"
                            @if ($user['profile']['is_term'] === 1) style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" @else style="border: 2px solid red;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" @endif
                            data-toggle="collapse" href="#term_beta" aria-expanded="false" aria-controls="term_beta">
                            <div class="card-title lead collapsed"> Agreements – Beta T&Cs
                            </div>
                        </a>
                        <div id="term_beta" role="tabpanel" aria-labelledby="headingterm_beta"
                            @if ($user['profile']['is_term'] === 1) style="border-color:  black;" @else style="border-color:  red;" @endif
                            class="collapse accordin_style" aria-expanded="false">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h6 class="mb-0"> Agreements – Beta T&Cs
                                                Approved</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            YES
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    @if ($user['application_status'] != 'IN_REVIEW')
                                        <div class="text-secondary" style="text-align: right">
                                            <a href="{{ route('vender.profile.step', 9.1) }}"
                                                style=" background-color: black !important;
                                       border-color: black !important;"
                                                class="btn btn-primary"> Edit</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <a id="headingCollapse15" class="card-header info mt-2"
                            @if ($user['profile']['is_sub'] === 1) style="border: 2px solid black;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" @else style="border: 2px solid red;border-radius: 7px !important;padding: 1.2rem 1rem;color: black !important;" @endif
                            data-toggle="collapse" href="#term_sub" aria-expanded="false" aria-controls="term_sub">
                            <div class="card-title lead collapsed"> Agreements – Subscription T&Cs
                            </div>
                        </a>
                        <div id="term_sub" role="tabpanel" aria-labelledby="headingterm_sub"
                            @if ($user['profile']['is_sub'] === 1) style="border-color:  black;" @else style="border-color:  red;" @endif
                            class="collapse accordin_style" aria-expanded="false">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <h6 class="mb-0"> Agreements – Subscription T&Cs</h6>
                                        </div>
                                        <div class="col-sm-7 text-secondary">
                                            YES
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    @if ($user['application_status'] != 'IN_REVIEW')
                                        <div class="text-secondary" style="text-align: right">
                                            <a href="{{ route('vender.profile.step', 9.2) }}"
                                                style=" background-color: black !important;
                                       border-color: black !important;"
                                                class="btn btn-primary"> Edit</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>

        </div>

    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            var contentHeight = $('#contens').height();
            $('#contens').height(contentHeight + 50);
        });
    </script>
@endsection

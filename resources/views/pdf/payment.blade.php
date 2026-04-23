<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

    <title>Invoice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    {{--
    <link rel='stylesheet' type='text/css' href='css/style.css' /> --}}
    <link rel='stylesheet' type='text/css' href='css/print.css' media="print" />
    <script type='text/javascript' src='js/jquery-1.3.2.min.js'></script>
    <script type='text/javascript' src='js/example.js'></script>

</head>
<style>
    body {
        font: 14px/1.4 Arial, Helvetica, sans-serif;
    }

    table td,
    table th {
        border: 1px solid black;
        padding: 5px;
        padding-bottom: 1px;
        padding-top: 1px;

    }

    .item-table th {
        border: 1px solid black !important;
        border-right: none !important;
        border-left: none !important;
    }

    .item-table tr {
        border: 1px solid black !important;
    }

    #items tr {
        border: none !important;
    }

    #items th {
        background: #d9d9d9;
        color: black;
    }

    /* #items td.total-line {
    border-right: 0;

    }
    #items td.total-value {
    border-left: 0;
    padding: 10px;
    } */

    .footer {
        /* margin: 100px 0px; */
        width: 100%;
        /* display: flex; */
        /* justify-content: flex-start; */

        margin: 30px 0px;
    }

    /* .main{
    margin-bottom: 330px;
    } */

    .main {
        margin-bottom: 100px;
    }
</style>


<body>

    <div id="page-wrap" style="width: 100%;margin: 0 auto; position: relative;">

        <div id="header">
            <p style="width: 50%;margin-top: 10px;font-size: 16px;text-align: left;float: left;margin-left: 12px;"></p>
            <p
                style="width: 50%;margin-bottom: 10px;font-size: 16px;text-align: right;float: left;margin-top: 10px;margin-left: 17px;">
                Powered by Motonos (www.motonos.com)</p>


        </div>
        <div style="width: 100%;clear: both;"></div>
        <div>
            <div class="top-addr">
                <div id="customer"
                    style="overflow: hidden;margin: 10px;margin-top:25px;margin-bottom:0px;width: 50%;float: left;">

                    <h1 id="customer-title" style="font-size: 15px;font-weight: bold;line-height: 2.1;margin-bottom: 0">


                        <!-- TITLE -->
                        <p style="font-weight:bold; font-size:13px; margin:0 0 3px 0;">
                            @if ($trading_unit['trading_template'] == 1)
                                {{ ucfirst(auth()->user()->profile->company_name) }}
                            @endif
                            @if ($trading_unit['trading_template'] == 2)
                                {{ ucfirst(auth()->user()->profile->company_name) }} Trading as
                                {{ $trading_unit['trading_name']['name'] }}
                            @endif
                            @if ($trading_unit['trading_template'] == 3)
                                {{ ucfirst($trading_unit['trading_name']['name']) }}
                            @endif
                        </p>
                        @php
                            if (
                                $trading_unit['operation_type'] == 'Both' ||
                                $trading_unit['operation_type'] == 'On-site'
                            ) {
                                $addressLine1 = collect([
                                    $trading_unit['site']['address_line_1'] ?? null,
                                    $trading_unit['site']['address_line_2'] ?? null,
                                    $trading_unit['site']['address_line_3'] ?? null,
                                    $trading_unit['site']['address_line_4'] ?? null,
                                ])
                                    ->filter()
                                    ->implode(', ');

                                $addressLine2 = collect([
                                    $trading_unit['site']['city'] ?? null,
                                    $trading_unit['site']['postcode'] ?? null,
                                ])
                                    ->filter()
                                    ->implode(' ');
                            } else {
                                $addressLine1 = collect([
                                    $profile['address_line_1'] ?? null,
                                    $profile['address_line_2'] ?? null,
                                    $profile['address_line_3'] ?? null,
                                    $profile['address_line_4'] ?? null,
                                ])
                                    ->filter()
                                    ->implode(', ');

                                $addressLine2 = collect([$profile['city'] ?? null, $profile['postcode'] ?? null])
                                    ->filter()
                                    ->implode(' ');
                            }
                        @endphp

                        <!-- ADDRESS -->
                        @if ($addressLine1 || $addressLine2)
                            <p style="margin:0 0 3px 0;">
                                {{ $addressLine1 }}<br>
                                {{ $addressLine2 }}
                            </p>
                        @endif

                        <!-- CONTACT -->
                        <div style="min-height:150px;">

                            <p style="margin:0 0 3px 0;">

                                @php
                                    $hasTel =
                                        $trading_unit['app_setting']['show_landline'] === 'YES' &&
                                        !empty($trading_unit['landline']);
                                    $hasMobile =
                                        $trading_unit['app_setting']['show_mobile'] === 'YES' &&
                                        !empty($trading_unit['mobile']);
                                @endphp

                                @if ($hasTel)
                                    Tel: {{ $trading_unit['landline'] }}
                                @endif

                                @if ($hasTel && $hasMobile)
                                    &nbsp;|&nbsp;
                                @endif

                                @if ($hasMobile)
                                    Mobile: {{ $trading_unit['mobile'] }}
                                @endif

                            </p>

                            @if ($trading_unit['app_setting']['show_email'] === 'YES' && !empty($trading_unit['email']))
                                <p style="margin:0 0 3px 0;">Email: {{ $trading_unit['email'] }}</p>
                            @endif

                            @if ($trading_unit['app_setting']['show_website'] === 'YES' && !empty($trading_unit['website']))
                                <p style="margin:0 0 3px 0;">{{ $trading_unit['website'] }}</p>
                            @endif
                            <p style="margin:0 0 6px 0;">
                                @if (!empty($vender['profile']['uk_vat_no']))
                                    Registered vat no: {{ $vender['profile']['uk_vat_no'] }}
                                @else
                                    <span style="visibility:hidden;">VAT placeholder</span>
                                @endif
                            </p>



                        </div>
                        <table id="meta" style="margin-top: 160px;width: 100%;">
                            <tr>
                                <th style="background: #d9d9d9;text-align: left;color: black;" colspan="2">Invoice
                                    Reference
                                </th>
                            </tr>
                            <tr>
                                <td style="text-align: left;background: #d9d9d9;color: black;" class="meta-head">Invoice
                                    ID
                                </td>
                                <td>
                                    {{ $invoice['invoice']['invoice_no'] ?? '' }}
                                </td>
                            </tr>




                        </table>

                </div>

                <div class="invoice-side" style="width: 50%;float: left;margin: 30px;margin-bottom:0px;">
                    <h2 style="float: right;padding-bottom: 10px;margin-right:30px; font-size:20px">PAYMENT RECEIPT</h2>

                    <table id="meta" style="margin-top: 40px;width: 100%;float: right;margin-right:20px;">
                        <tr>
                            <td style="text-align: left;background: #d9d9d9;color: black" class="meta-head">Payment ID
                            </td>
                            <td>
                                {{ $invoice['pay_no'] }}
                            </td>
                        </tr>
                        <tr>

                            <td style="text-align: left;background: #d9d9d9;color: black" class="meta-head">Date</td>
                            <td>
                                {{ \Carbon\Carbon::parse($invoice['payment_date'])->format('d/m/Y') }}
                            </td>
                        </tr>
                        <tr>

                            <td style="text-align: left;background: #d9d9d9;color: black" class="meta-head">Time</td>
                            <td>
                                {{ \Carbon\Carbon::parse($invoice['created_at'])->format('H:i:s') }}
                            </td>
                        </tr>



                    </table>


                </div>
            </div>
            <div style="width: 100%;clear: both;"></div>
            <table id="items" class="item-table"
                style="margin-top: 20px;width: 103%;margin-left:10px;border-bottom: 1px solid black !important;">
                <tr style="border-left:1px solid black !important;border-right: 1px solid black !important;">
                    <th>Payment</th>
                    <th></th>
                    <th></th>
                    <th></th>

                </tr>
                <tr class="item-row"
                    style="border-left:1px solid black !important;border-right: 1px solid black !important;">
                    <td style="color: black;border: none!important;padding:10px;">{{ $invoice['payment_type'] }}</td>
                    <td style="border: none!important;padding:10px;">
                        {{ $invoice['payment_method'] == 'DEPOSIT' ? 'Deposit' : $invoice['payment_method'] }}</td>
                    <td style="border: none!important;padding:10px;">
                        {{ \Carbon\Carbon::parse($invoice['payment_date'])->format('d/m/Y') }}
                        {{ \Carbon\Carbon::parse($invoice['created_at'])->format('H:i:s') }}</td>
                    <td style="border: none!important;padding:10px;">£{{ number_format($invoice['amount'], 2) }}</td>

                </tr>
                <tr class="item-row"
                    style="border-left:1px solid black !important;border-right: 1px solid black !important;padding-top:10px;padding-bottom:40px">
                    <td style="color: black;border: none!important;padding:10px; ">Payment Ref:</td>
                    <td style="border: none!important;padding:10px;">{{ $invoice['payment_ref'] }}</td>
                    <td style="border: none!important;padding:10px;"></td>
                    <td style="border: none!important;padding:10px;"></td>

                </tr>
                <tr class="item-row"
                    style="border-left:1px solid black !important;border-right: 1px solid black !important;">
                    <td style="color: black;border: none!important;padding:10px;"></td>
                    <td style="border: none!important;padding:10px"></td>
                    <td style="border: none!important;padding:10px"></td>
                    <td style="border: none!important;padding:10px"></td>

                </tr>






            </table>


        </div>












    </div>


    <div style="width: 100%;clear: both;"></div>


    <div id="header" style="position: fixed;bottom: 0;width: 100%;margin: 10px;margin-top: 15px;">
        <p style="width: 100%;margin-top: 10px;font-size: 11px;text-align: left">
            @php
                $companyName = $profile['company_name'] ?? (auth()->user()->profile['company_name'] ?? null);
                $tradingName = $trading_unit['trading_name']['name'] ?? null;

                $businessNameFormat = $trading_unit['trading_template'] ?? null;
                $businessSetup = $profile['organization_status'] ?? null;

                $footerLegalName = null;

                // Case 1: Trading Name Only
                if ($businessNameFormat == '3' && $companyName && $tradingName) {
                    $footerLegalName = $companyName . ' trading as ' . $tradingName;
                }
                // Case 2: LTD / LLP
                elseif (
                    in_array($businessSetup, ['Limited Company (Ltd)', 'Limited Liability Partnership (LLP)']) &&
                    $companyName
                ) {
                    $footerLegalName = $companyName;
                }
            @endphp
            {{ $footerLegalName }}
            {{-- Motodoc Ltd trading as H & H Motors. --}}
        </p>
        @php

            $businessSetup = $profile['organization_status'] ?? null;

            $isCompany = in_array($businessSetup, ['Limited Company (Ltd)', 'Limited Liability Partnership (LLP)']);

            $registeredAddress = null;

            if ($isCompany) {
                $addressParts = array_values(
                    array_filter([
                        $profile['address_line_1'] ?? null,
                        $profile['address_line_2'] ?? null,
                        $profile['address_line_3'] ?? null,
                        $profile['address_line_4'] ?? null,
                        $profile['city'] ?? null,
                        $profile['postcode'] ?? null,
                    ]),
                );

                if (!empty($addressParts)) {
                    // Add comma to all except last
                    $formattedParts = [];

                    foreach ($addressParts as $index => $part) {
                        $formattedParts[] = $index < count($addressParts) - 1 ? $part . ', ' : $part;
                    }

                    $registeredAddress = implode($formattedParts);
                }
            }

            // Jurisdiction
            $registeredJurisdiction = $isCompany ? $profile['company_jurisdiction'] ?? null : null;

            // Company Number
            $registeredCompanyNo = $isCompany ? $profile['registration_no'] ?? null : null;
        @endphp
        <p style="width: 100%;margin-bottom: 30px;margin-top: -18px;font-size: 11px;text-align: left">
            @isset($registeredAddress)
                Registered
                office: {{ $registeredAddress }}.
                Registered in
                {{ $registeredJurisdiction }} no: {{ $registeredCompanyNo }}.
            @endisset

        <p style="margin-top:-45px;margin-right: -20px; font-size: 11px;float: right;text-align: right!important">
            v20241002</p>
        </p>
        </p>


    </div>



</body>

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Receipt</title>
</head>

<body class="antialiased">
    <h2>Dear {{ $invoice['booking']['contact_detail']['name'] }},</h2>

    <p>Please find attached your Payment Receipt.</p>

    <p>Kind regards,</p>
    @php
        $profile = optional($vender->profile);
        $tradingName = optional($invoice->trading_name);
        $appSetting = optional($tradingName->app_setting);
    @endphp

    <p>
        @if ($appSetting->header_option == 1)
            {{ ucfirst($profile->company_name) }}
        @elseif($appSetting->header_option == 2)
            {{ ucfirst($profile->company_name) }} trading as {{ $tradingName->trading_name->name ?? '' }}
        @else
            {{ $tradingName->trading_name->name ?? '' }}
        @endif
    </p>
</body>

</html>

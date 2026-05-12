





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        /* Loading your local Coolvetica font for the heading */
        @font-face {
            font-family: 'Coolvetica';
            src: url('coolvetica.otf') format('opentype');
            font-weight: normal;
            font-style: normal;
        }
    </style>
</head>

<body style="margin: 0; padding: 0; background-color: #ffffff;">

    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600"
        style="border-collapse: collapse; max-width: 600px; width: 100%; font-family: Arial, Helvetica, sans-serif; background-color: #ffffff; margin: 20px auto;">

        <tr>
            <td height="4" style="background-color: #f26522; line-height: 0; font-size: 0;">&nbsp;</td>
        </tr>

        <tr>
            <td align="center" style="padding: 25px 0;">
                <img src="https://motonos.com/uploads/cms/minilogo.png" alt="MOTONOS" width="160"
                    style="display: block; border: 0;">
            </td>
        </tr>

        <tr>
            <td height="4" style="background-color: #f26522; line-height: 0; font-size: 0;">&nbsp;</td>
        </tr>
        <!-- APPLICATION RECEIVED CONTENT -->
    <tr>
    <td align="center" style="padding: 50px 40px; background-color: #ffffff;">

      

        <p style="margin: 0 0 20px 0; font-size: 16px; line-height: 1.7; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
            Hi {{ $invoice['invoice']['booking']['contact_detail']['name'] }},
        </p>

        <p style="margin: 0 0 30px 0; font-size: 16px; line-height: 1.8; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
            Please find your invoice attached to this email for your records and review.
        </p>

        <p style="margin: 0; font-size: 14px; line-height: 1.8; color: #666666; font-family: Arial, Helvetica, sans-serif;text-align: left;">
                        If you have any questions regarding this invoice, please contact us and our team will be happy to assist you.
                    </p>

                     @php
        $profile = optional($vender->profile);
        $tradingName = optional($invoice->invoice->trading_name);
        $appSetting = optional($tradingName->app_setting);
    @endphp

    

        <p style="margin: 40px 0 0 0; font-size: 16px; line-height: 1.7; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
            Best regards,<br>
            <strong> @if ($appSetting->header_option == 1)
            {{ ucfirst($profile->company_name) }}
        @elseif($appSetting->header_option == 2)
            {{ ucfirst($profile->company_name) }} trading as {{ $tradingName->trading_name->name ?? '' }}
        @else
            {{ $tradingName->trading_name->name ?? '' }}
        @endif</strong>
        </p>

    </td>
</tr>

        <!-- FOOTER -->
        <tr>
            <td height="4" style="background-color: #f26522; line-height: 0; font-size: 0;">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 30px 20px; background-color: #ffffff;">

                <img src="https://motonos.com/uploads/cms/minilogo.png" alt="MOTONOS" width="140"
                    style="display: block; border: 0; margin-bottom: 20px;">

                <p
                    style="margin: 0; font-size: 13px; line-height: 1.6; color: #777777; font-family: Arial, Helvetica, sans-serif; text-align: center;">
                    © {{date('Y')}} Motonos. All rights reserved.
                </p>

            </td>
        </tr>

        <!-- BOTTOM BORDER -->


        <!-- BOTTOM BORDER -->


        <!-- BOTTOM BORDER -->
        <tr>
            <td height="4" style="background-color: #f26522; line-height: 0; font-size: 0;">
                &nbsp;
            </td>
        </tr>

    </table>

</body>

</html>

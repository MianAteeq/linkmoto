<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motonos Email Template</title>
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


                <p
                    style="margin: 0 0 20px 0; font-size: 16px; line-height: 1.7; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
                    Hi {{$booking->contact_detail->name}},
                </p>

                <p
                    style="margin: 0 0 30px 0; font-size: 16px; line-height: 1.8; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
                    Please find your booking details with
                    <strong>>@if ($trading_unit['trading_template'] == 1)
                                        {{ $user->profile->company_name }}
                                    @endif
                                    @if ($trading_unit['trading_template'] == 2)
                                        {{ $user->profile->company_name }} Trading as
                                        {{ $trading_unit['trading_name']['name'] }}
                                    @endif
                                    @if ($trading_unit['trading_template'] == 3)
                                        {{ $trading_unit['trading_name']['name'] ?? '' }}
                                    @endif</strong> below.
                </p>

                <!-- BOOKING DETAILS BOX -->
                <p
                    style="margin: 0 0 16px 0; font-size: 15px; color: #111111; font-weight: bold; font-family: Arial, Helvetica, sans-serif; text-align: left;">
                    Booking Details
                </p>

                <table width="100%" border="0" cellspacing="0" cellpadding="0"
                    style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #555555; line-height: 2;">

                    <tr>
                        <td style="font-weight: bold; width: 140px;">Booking ID:</td>
                        <td>{{$booking->booking_no}}</td>
                    </tr>

                    <tr>
                        <td style="font-weight: bold;">Date:</td>
                        <td> {{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}</td>
                    </tr>

                    <tr>
                        <td style="font-weight: bold;">Time:</td>
                        <td>{{$booking->booking_time}}</td>
                    </tr>

                    <tr>
                        <td style="font-weight: bold;">Vehicle:</td>
                        <td>{{$booking->vehicle->vrm}}
                    </tr>

                    <tr>
                        <td style="font-weight: bold;">Requested Work:</td>
                        <td>
                           {{ 
    collect($booking['job_requests'])
        ->flatMap(fn($job_request) => $job_request['job_types'])
        ->pluck('job_type.name')
        ->unique()
        ->implode(', ')
}}
                        </td>
                    </tr>

                    <tr>
                        <td style="font-weight: bold;">Status:</td>
                        <td>{{ ucfirst(strtolower($booking->status)) }}</td>
                    </tr>

                </table>

                <!-- LOCATION BOX -->


                <p
                    style="margin: 0 0 16px 0; font-size: 15px; color: #111111; font-weight: bold; font-family: Arial, Helvetica, sans-serif; text-align: left;">
                    Location Information
                </p>


                @if ($booking->service_type == 'On-Premises')
                 <p
                    style="margin: 0; font-size: 14px; line-height: 1.9; color: #555555; font-family: Arial, Helvetica, sans-serif;text-align: left;">
                    <strong>Address:</strong> {{ collect([
                                $trade_unit->site['address_line_1'],
                                $trade_unit->site['address_line_2'],
                                $trade_unit->site['address_line_3'],
                                $trade_unit->site['address_line_4'],
                                $trade_unit->site['city'],
                                $trade_unit->site['postcode'],
                            ])->filter()->implode(', ') }}
                </p>
                @else
                <p
                    style="margin: 0; font-size: 14px; line-height: 1.9; color: #555555; font-family: Arial, Helvetica, sans-serif;text-align: left;">
                    <strong>Mobile Service Address:</strong> {{ collect([
                                $booking['address_line_1'],
                                $booking['address_line_2'],
                                $booking['address_line_3'],
                                $booking['address_line_4'],
                                $booking['city'],
                                $booking['post_code'],
                            ])->filter()->implode(', ') }}
                </p>
                    
                @endif
               






                <p
                    style="margin: 0; font-size: 14px; line-height: 1.8; color: #666666; font-family: Arial, Helvetica, sans-serif; text-align: left;margin-top: 20px;">
                    If you need to make any changes or have questions, please contact us.

                </p>



                <p
                    style="margin: 40px 0 0 0; font-size: 16px; line-height: 1.7; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
                    Best regards,<br>
                    <strong>@if ($trading_unit['trading_template'] == 1)
                                        {{ $user->profile->company_name }}
                                    @endif
                                    @if ($trading_unit['trading_template'] == 2)
                                        {{ $user->profile->company_name }} Trading as
                                        {{ $trading_unit['trading_name']['name'] }}
                                    @endif
                                    @if ($trading_unit['trading_template'] == 3)
                                        {{ $trading_unit['trading_name']['name'] ?? '' }}
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
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
                <img src="https://motonos.com/uploads/cms/minilogo.png" alt="MOTONOS" width="160" style="display: block; border: 0;">
            </td>
        </tr>

        <tr>
            <td height="4" style="background-color: #f26522; line-height: 0; font-size: 0;">&nbsp;</td>
        </tr>
<!-- APPLICATION RECEIVED CONTENT -->
<tr>
    <td align="center" style="padding: 50px 40px; background-color: #ffffff;">

        <h1 style="margin: 0 0 20px 0; font-size: 28px; color: #111111; font-family: Arial, Helvetica, sans-serif;">
            We’ve Received Your Application
        </h1>

        <p style="margin: 0 0 20px 0; font-size: 16px; line-height: 1.7; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
            Hi {{$user->name}},
        </p>

        <p style="margin: 0 0 25px 0; font-size: 16px; line-height: 1.7; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
            Thank you for your interest in Motonos.
        </p>

        <p style="margin: 0 0 30px 0; font-size: 16px; line-height: 1.7; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
            We’ve successfully received your expression of interest for joining 
            <strong>{{$user->profile->trading_name}}</strong> to the Motonos platform.
        </p>

        <!-- STATUS BOX -->
        <table width="100%" border="0" cellspacing="0" cellpadding="0"
               style="background-color: #f8f8f8; border-left: 4px solid #f26522; border-radius: 6px; margin-bottom: 30px;">
            <tr>
                <td style="padding: 20px;">

                    <p style="margin: 0 0 12px 0; font-size: 15px; color: #111111; font-weight: bold; font-family: Arial, Helvetica, sans-serif;">
                        What Happens Next
                    </p>

                    <ul style="padding-left: 18px; margin: 0; color: #555555; font-size: 14px; line-height: 1.9; font-family: Arial, Helvetica, sans-serif;">
                        <li>We review your submitted details</li>
                        <li>We assess suitability for the platform</li>
                        <li>Our team contacts you with the next steps</li>
                    </ul>

                </td>
            </tr>
        </table>

        <!-- CTA BUTTON -->
        <table border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom: 35px;">
            <tr>
                <td align="center" bgcolor="#f26522" style="border-radius: 6px;">
                    <a href="https://motonos.com" target="_blank"
                       style="font-size: 16px; font-family: Arial, Helvetica, sans-serif; color: #ffffff; text-decoration: none; padding: 14px 32px; display: inline-block; font-weight: bold;">
                        Visit Motonos
                    </a>
                </td>
            </tr>
        </table>

        <p style="margin: 0; font-size: 14px; line-height: 1.7; color: #777777; font-family: Arial, Helvetica, sans-serif; text-align: left;">
            We appreciate your interest and look forward to connecting with you soon.
        </p>

        <p style="margin: 40px 0 0 0; font-size: 16px; line-height: 1.7; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
            Best regards,<br>
            <strong>Motonos Team</strong>
        </p>

    </td>
</tr>

<!-- FOOTER -->
 <tr>
    <td height="4"
        style="background-color: #f26522; line-height: 0; font-size: 0;">
        &nbsp;
    </td>
</tr>

        <tr>
            <td align="center" style="padding: 15px 20px 5px 20px">
                <p style="font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; color: #555555; line-height: 1.5; margin: 0 0 5px 0; text-align: center;">
                    Need help?
                </p>

                <p style="font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; color: #555555; margin: 0 0 15px 0; text-align: center;">
                    Reply to this email or contact us at support@motonos.com
                </p>

                <p style="font-family: Arial, Helvetica, sans-serif; font-weight: normal; font-size: 12px; color: #555555; margin: 0 0 5px 0; text-align: center;">
                   © 2026 Motonos. All rights reserved.
                </p>

            </td>
        </tr>

        <tr>
            <td height="4" style="background-color: #f26522; line-height: 0; font-size: 0;">&nbsp;</td>
        </tr>

    </table>

</body>

</html>
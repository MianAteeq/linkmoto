<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motonos OTP security code</title>
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
<!-- OTP EMAIL CONTENT -->
<tr>
    <td align="center" style="padding: 50px 40px; background-color: #ffffff;">

        <h1 style="margin: 0 0 20px 0; font-size: 28px; color: #111111; font-family: Arial, Helvetica, sans-serif;">
            Verify Your OTP Code
        </h1>

        <p style="margin: 0 0 20px 0; font-size: 16px; line-height: 1.7; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
            Hi {{$user->name}},
        </p>

        <p style="margin: 0 0 25px 0; font-size: 16px; line-height: 1.7; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
            We received a request to reset your Motonos password from the Service Provider App.
        </p>

        <p style="margin: 0 0 30px 0; font-size: 16px; line-height: 1.7; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
            Use the one-time security code below to continue:
        </p>

        <!-- OTP BOX -->
        <table border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom: 35px;">
            <tr>
                <td align="center"
                    style="background-color: #f26522; color: #ffffff; font-size: 34px; font-weight: bold; letter-spacing: 8px; padding: 18px 35px; border-radius: 8px; font-family: Arial, Helvetica, sans-serif;">
                    {{ $otp }}
                </td>
            </tr>
        </table>

        <!-- INFO BOX -->
        <table width="100%" border="0" cellspacing="0" cellpadding="0"
               style="background-color: #f8f8f8; border-radius: 8px; margin-bottom: 30px;">
            <tr>
                <td style="padding: 20px;">

                    <p style="margin: 0 0 12px 0; font-size: 15px; color: #111111; font-weight: bold; font-family: Arial, Helvetica, sans-serif;">
                        Important Instructions
                    </p>

                    <ul style="padding-left: 18px; margin: 0; color: #555555; font-size: 14px; line-height: 1.8; font-family: Arial, Helvetica, sans-serif;">
                        <li>Enter this code in the Service Provider App to continue resetting your password.</li>
                        <li>This code will expire in 10 minutes.</li>
                        <li>Do not share this code with anyone.</li>
                    </ul>

                </td>
            </tr>
        </table>

        <p style="margin: 0 0 20px 0; font-size: 14px; line-height: 1.7; color: #777777; font-family: Arial, Helvetica, sans-serif; text-align: left;">
            If you did not request this, you can safely ignore this email. Your account remains secure.
        </p>

        <p style="margin: 40px 0 0 0; font-size: 16px; line-height: 1.7; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
            Best regards,<br>
            <strong>Motonos Team</strong>
        </p>

    </td>
</tr>

  <tr>
            <td height="4" style="background-color: #f26522; line-height: 0; font-size: 0;">&nbsp;</td>
        </tr>


<!-- FOOTER -->
<tr>
    <td align="center" style="padding: 30px 20px; background-color: #ffffff;">

        <img src="https://motonos.com/uploads/cms/minilogo.png" alt="MOTONOS" width="140"
             style="display: block; border: 0; margin-bottom: 20px;">

        <p style="margin: 0; font-size: 13px; line-height: 1.6; color: #777777; font-family: Arial, Helvetica, sans-serif; text-align: center;">
            © {{date('Y')}} Motonos. All rights reserved.
        </p>

    </td>
</tr>

<!-- BOTTOM BORDER -->
<tr>
    <td height="4"
        style="background-color: #f26522; line-height: 0; font-size: 0;">
        &nbsp;
    </td>
</tr>

    </table>

</body>

</html>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
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


        <tr>
            <td align="center" style="padding: 50px 40px; background-color: #ffffff;">

                <h1
                    style="margin: 0 0 20px 0; font-size: 28px; color: #111111; font-family: Arial, Helvetica, sans-serif;">
                    Reset Your Password
                </h1>

                <p
                    style="margin: 0 0 20px 0; font-size: 16px; line-height: 1.7; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
                    Hi {{ $name }},
                </p>

                <p
                    style="margin: 0 0 20px 0; font-size: 16px; line-height: 1.7; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
                    We received a request to reset the password for your Motonos account.
                </p>

                <p
                    style="margin: 0 0 35px 0; font-size: 16px; line-height: 1.7; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
                    Click the button below to create a new password securely.
                </p>

                <!-- CTA Button -->
                <table border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom: 35px;">
                    <tr>
                        <td align="center" bgcolor="#f26522" style="border-radius: 6px;">
                            <a href="{{ url('/reset-password?token=' . $token . '&email=' . urlencode($email)) }}" target="_blank"
                                style="font-size: 16px; font-family: Arial, Helvetica, sans-serif; color: #ffffff; text-decoration: none; padding: 14px 32px; display: inline-block; font-weight: bold;">
                                Reset Password
                            </a>
                        </td>
                    </tr>
                </table>

                <p
                    style="margin: 0 0 20px 0; font-size: 14px; line-height: 1.7; color: #777777; font-family: Arial, Helvetica, sans-serif; text-align: left;">
                    If the button above does not work, copy and paste this link into your browser:
                </p>

                <p
                    style="margin: 0 0 30px 0; font-size: 14px; line-height: 1.7; color: #f26522; word-break: break-all; font-family: Arial, Helvetica, sans-serif; text-align: left;">
                    {{ url('/reset-password?token=' . $token . '&email=' . urlencode($email)) }}
                </p>

                <p
                    style="margin: 0 0 20px 0; font-size: 14px; line-height: 1.7; color: #777777; font-family: Arial, Helvetica, sans-serif; text-align: left;">
                    If you did not request a password reset, you can safely ignore this email. Your account remains
                    secure.
                </p>

                <p
                    style="margin: 40px 0 0 0; font-size: 16px; line-height: 1.7; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
                    Best regards,<br>
                    <strong>Motonos Team</strong>
                </p>

            </td>
        </tr>


        <tr>
            <td height="4" style="background-color: #f26522; line-height: 0; font-size: 0;">&nbsp;</td>
        </tr>

        <tr>
            <td align="center" style="padding: 35px 20px;">

                <img src="https://motonos.com/uploads/cms/minilogo.png" alt="MOTONOS" width="160"
                    style="display: block; border: 0; margin-bottom: 25px;">

               <p style="margin: 0; font-size: 13px; line-height: 1.6; color: #777777; font-family: Arial, Helvetica, sans-serif; text-align: center;">
            © {{date('Y')}} Motonos. All rights reserved.
        </p>

            </td>
            
        </tr>



<!-- BOTTOM ORANGE BORDER -->
<tr>
    <td height="4"
        style="background-color: #f26522; line-height: 0; font-size: 0;">
        &nbsp;
    </td>
</tr>

    </table>

</body>

</html>
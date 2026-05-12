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

       

        <p style="margin: 0 0 20px 0; font-size: 16px; line-height: 1.7; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
            Hi {{$user->name}},
        </p>

        <p style="margin: 0 0 30px 0; font-size: 17px; line-height: 1.8; color: #333333; font-family: Arial, Helvetica, sans-serif; text-align: left;">
          <strong>Great news — your business has been pre-approved to join Motonos.</strong>
        </p>

        <p style="margin: 0 0 25px 0; font-size: 16px; line-height: 1.7; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
            To get started, please complete your registration using the secure link below:
        </p>

        <!-- CTA BUTTON -->
        <table border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom: 35px;">
            <tr>
                <td align="center" bgcolor="#f26522" style="border-radius: 6px;">
                    <a href="{{route('website.vendor.login')}}" target="_blank"
                       style="font-size: 16px; font-family: Arial, Helvetica, sans-serif; color: #ffffff; text-decoration: none; padding: 14px 34px; display: inline-block; font-weight: bold;">
                        Complete Registration
                    </a>
                </td>
            </tr>
        </table>

        <!-- LOGIN BOX -->
        <table width="100%" border="0" cellspacing="0" cellpadding="0"
               style="background-color: #f8f8f8; border-left: 4px solid #f26522; border-radius: 6px; margin-bottom: 30px;">
            <tr>
                <td style="padding: 22px;">

                    <p style="margin: 0 0 15px 0; font-size: 15px; color: #111111; font-weight: bold; font-family: Arial, Helvetica, sans-serif;">
                        Temporary Login Details
                    </p>

                    <p style="margin: 0 0 10px 0; font-size: 14px; line-height: 1.8; color: #555555; font-family: Arial, Helvetica, sans-serif;">
                        You can log in using this email address and the temporary password below:
                    </p>

                    <p style="margin: 0; font-size: 18px; color: #111111; font-weight: bold; letter-spacing: 1px; font-family: Arial, Helvetica, sans-serif;">
                        12345678
                    </p>

                </td>
            </tr>
        </table>

        <!-- SECURITY NOTE -->
        <table width="100%" border="0" cellspacing="0" cellpadding="0"
               style="background-color: #fff4f1; border-left: 4px solid #f26522; border-radius: 6px; margin-bottom: 30px;">
            <tr>
                <td style="padding: 20px;">

                    <p style="margin: 0; font-size: 14px; line-height: 1.8; color: #555555; font-family: Arial, Helvetica, sans-serif;">
                        For security reasons, you’ll be required to create a new password when you log in for the first time.
                    </p>

                </td>
            </tr>
        </table>

        <p style="margin: 0 0 18px 0; font-size: 15px; line-height: 1.8; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
            The setup process usually takes around 5–10 minutes to complete.
        </p>

        <p style="margin: 0 0 20px 0; font-size: 15px; line-height: 1.8; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
            If you have any questions, simply reply to this email and our team will be happy to help.
        </p>

        <p style="margin: 40px 0 0 0; font-size: 16px; line-height: 1.7; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
            Best regards,<br>
            <strong>Motonos Team</strong>
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
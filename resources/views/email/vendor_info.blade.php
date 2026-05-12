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
                    Hi {{$user->name}},
                </p>

                <p
                    style="margin: 0 0 25px 0; font-size: 16px; line-height: 1.8; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
                    Thank you for your application to join Motonos.
                </p>

                <p
                    style="margin: 0 0 30px 0; font-size: 16px; line-height: 1.8; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
                    We’ve reviewed the submission for <strong>{{$user->profile->business_name}}</strong> and need a few updates before
                    we can continue processing your application.
                </p>

                <!-- UPDATE DETAILS BOX -->
                <table width="100%" border="0" cellspacing="0" cellpadding="0"
                    style="background-color: #f8f8f8; border-left: 4px solid #f26522; border-radius: 6px; margin-bottom: 30px;">
                    <tr>
                        <td style="padding: 22px;">

                            <p
                                style="margin: 0 0 16px 0; font-size: 15px; color: #111111; font-weight: bold; font-family: Arial, Helvetica, sans-serif;">
                                What Needs Updating
                            </p>

                            <p
                                style="margin: 0; font-size: 14px; line-height: 1.9; color: #555555; font-family: Arial, Helvetica, sans-serif;">
                                {{$reason}}
                            </p>

                        </td>
                    </tr>
                </table>

                <p
                    style="margin: 0 0 30px 0; font-size: 15px; line-height: 1.9; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
                    Once you’ve made the changes, you can resubmit your application for review.
                </p>
                <p
                    style="margin: 0 0 30px 0; font-size: 15px; line-height: 1.9; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
                    CTA <br>
                    Review & Update Application →  <a href="{{route('website.vendor.login')}}" target="_blank"
                       style="font-size: 16px; font-family: Arial, Helvetica, sans-serif; color: #ffffff; background: #f26522; text-decoration: none; padding: 10px 13px; display: inline-block; font-weight: bold; border-radius: 7px; margin-left: 17px;">
                        Application Edit Link
                    </a>

                </p>

                <!-- CTA BUTTON -->


                <!-- SUPPORT BOX -->


                <p
                    style="margin: 0; font-size: 14px; line-height: 1.8; color: #666666; font-family: Arial, Helvetica, sans-serif;text-align: left;">
                    If you need any help, just reply to this email or contact us at support@motonos.com - we’re happy to
                    assist.

                </p>



                <p
                    style="margin: 40px 0 0 0; font-size: 16px; line-height: 1.7; color: #555555; font-family: Arial, Helvetica, sans-serif; text-align: left;">
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
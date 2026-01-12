<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="background:#e67e22; padding:20px;">
                            <h1 style="color:#ffffff; margin:0; font-size:24px;">{{ config('app.name') }}</h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px; color:#333333; font-size:16px; line-height:1.6;">
                            <p>Hello,</p>
                            <p>You recently requested to reset your password for your <strong>{{ config('app.name') }}</strong> account. Click the button below to reset it:</p>
                            
                            <p style="text-align:center; margin:30px 0;">
                                <a href="{{ url('/reset-password?token=' . $token . '&email=' . urlencode($email)) }}"
                                   style="background:#e67e22; color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:6px; font-size:16px; display:inline-block;">
                                    Reset Password
                                </a>
                            </p>

                            <p>If you did not request a password reset, please ignore this email.  
                               This link will expire in <strong>60 minutes</strong>.</p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background:#e67e22; padding:20px; font-size:14px; color:#fff;">
                            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

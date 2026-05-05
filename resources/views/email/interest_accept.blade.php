<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Motonos</title>
</head>

<body style="margin:0; padding:0; background:#f6f7f9; font-family:Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
<tr>
<td align="center">

<!-- Card -->
<table width="520" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.05); overflow:hidden;">

  <!-- Top Accent Bar -->
  <tr>
    <td style="background:#f26622; height:6px;"></td>
  </tr>

  <!-- Content -->
  <tr>
    <td style="padding:40px 30px; text-align:center;">

      <h1 style="margin:0; font-size:22px; color:#111;">
        Welcome to Motonos
      </h1>

      <p style="margin-top:15px; font-size:15px; color:#555; line-height:1.6;">
        Hi {{ $user['name'] }} {{ $user['last_name'] }},<br>
        Your interest has been accepted. Please complete your profile to continue.
      </p>

      <!-- Button -->
      <table cellpadding="0" cellspacing="0" style="margin:25px auto 0;">
        <tr>
          <td bgcolor="#000000" style="border-radius:8px;">
            <a href="https://yourdomain.com/login"
               style="display:inline-block; padding:12px 24px; color:#ffffff; text-decoration:none; font-size:14px; font-weight:600;">
               Log in to your account
            </a>
          </td>
        </tr>
      </table>

    </td>
  </tr>

  <!-- Account Box -->
  <tr>
    <td style="padding:0 30px 30px;">
      
      <table width="100%" cellpadding="0" cellspacing="0" style="background:#fafafa; border:1px solid #eee; border-radius:10px;">
        <tr>
          <td style="padding:25px; text-align:center;">

            <h2 style="margin:0; font-size:18px; color:#f26622;">
              Your Account Details
            </h2>

            <p style="margin-top:15px; font-size:14px; color:#444;">
              <strong>Email:</strong><br>
              {{ $user['email'] }}
            </p>

            <p style="margin-top:10px; font-size:14px; color:#444;">
              <strong>Password:</strong><br>
              12345678
            </p>

          </td>
        </tr>
      </table>

    </td>
  </tr>

  <!-- Note -->
  <tr>
    <td style="padding:0 30px 25px; text-align:center; font-size:13px; color:#777;">
      For security reasons, we recommend changing your password after logging in.
    </td>
  </tr>

  <!-- Divider -->
  <tr>
    <td style="padding:0 40px;">
      <hr style="border:none; border-top:1px solid #eee;">
    </td>
  </tr>

  <!-- Footer -->
  <tr>
    <td style="padding:20px 30px; text-align:center;">

      <a href="https://www.motonos.com" style="color:#111; text-decoration:none; font-size:14px;">
        www.motonos.com
      </a>

      <p style="margin-top:10px; font-size:12px; color:#999;">
        © 2026 Motonos. All rights reserved.
      </p>

    </td>
  </tr>

</table>

</td>
</tr>
</table>

</body>
</html>
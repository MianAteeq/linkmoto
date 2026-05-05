<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
</head>

<body style="margin:0; padding:0; background:#f6f7f9; font-family:Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
<tr>
<td align="center">

<table width="520" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:12px; overflow:hidden;">

  <!-- Top Bar -->
  <tr>
    <td style="background:{{ $status == 1 ? '#28a745' : '#dc3545' }}; height:6px;"></td>
  </tr>

  <!-- Header -->
  <tr>
    <td align="center" style="padding:30px;">

      <h2 style="margin:0; font-size:20px; color:#111;">
        Hello {{ $vendor->name }},
      </h2>

      <!-- STATUS BADGE -->
      <div style="margin-top:10px;">
        <span style="display:inline-block; 
                     background:{{ $status == 1 ? '#eaf7ee' : '#fdecea' }};
                     color:{{ $status == 1 ? '#2e7d32' : '#c62828' }};
                     padding:6px 14px; font-size:12px; border-radius:20px;">
          {{ $status == 1 ? 'Approved' : 'Declined' }}
        </span>
      </div>

    </td>
  </tr>

  <!-- Message -->
  <tr>
    <td align="center" style="padding:0 30px 25px; font-size:15px; color:#555; line-height:1.6;">

      @if($status == 1)
        Your profile has been successfully approved. You can now access your account and start using our platform.
      @else
        Unfortunately, your profile has been declined. Please review your information and update your details.
      @endif

    </td>
  </tr>

  <!-- CTA -->
  <tr>
    <td align="center" style="padding-bottom:30px;">
      <table cellpadding="0" cellspacing="0">
        <tr>
          <td bgcolor="#000000" style="border-radius:8px;">
            <a href="https://motonos.com/login"
               style="display:inline-block; padding:12px 24px; color:#ffffff; text-decoration:none; font-size:14px;">
               {{ $status == 1 ? 'Go to Dashboard' : 'Update Profile' }}
            </a>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <!-- Footer -->
  <tr>
    <td style="padding:25px; text-align:center; font-size:12px; color:#999; border-top:1px solid #eee;">
      <a href="https://motonos.com/" style="color:#000; text-decoration:none; font-weight:600;">
        www.motonos.com
      </a>
      <div style="margin-top:8px;">© 2026 Motonos. All rights reserved.</div>
    </td>
  </tr>

</table>

</td>
</tr>
</table>

</body>
</html>
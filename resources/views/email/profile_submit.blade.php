<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
</head>

<body style="margin:0; padding:0; background:#f6f7f9; font-family:Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
<tr>
<td align="center">

<!-- Main Card -->
<table width="640" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:12px; overflow:hidden;">

  <!-- Top Accent -->
  <tr>
    <td style="background:#f26622; height:6px;"></td>
  </tr>

  <!-- Header -->
  <tr>
    <td style="padding:25px 30px; text-align:center;">
      <h2 style="margin:0; font-size:20px; color:#111;">
        New Vendor Profile Submitted
      </h2>

      <!-- Status Badge -->
      <div style="margin-top:10px;">
        <span style="display:inline-block; background:#eaf7ee; color:#2e7d32; padding:6px 14px; font-size:12px; border-radius:20px;">
          New Submission
        </span>
      </div>
    </td>
  </tr>

  <!-- SECTION: USER INFO -->
  <tr>
    <td style="padding:0 30px 20px;">
      <h3 style="margin:0 0 10px; font-size:15px; color:#f26622;">
        User Information
      </h3>

      <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #eee; border-radius:8px;">
        <tr><td style="padding:18px;">

          <table width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;">
            <tr>
              <td style="color:#777; width:40%;">Name</td>
              <td style="font-weight:600;">{{ $user->name }} {{ $user->last_name }}</td>
            </tr>
            <tr>
              <td style="padding-top:8px; color:#777;">Email</td>
              <td style="padding-top:8px;">
                <a href="mailto:{{ $user->email }}" style="color:#f26622; text-decoration:none;">
                  {{ $user->email }}
                </a>
              </td>
            </tr>
            <tr>
              <td style="padding-top:8px; color:#777;">Submitted</td>
              <td style="padding-top:8px;">
                {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y, h:i A') }}
              </td>
            </tr>
          </table>

        </td></tr>
      </table>
    </td>
  </tr>

  <!-- SECTION: BUSINESS INFO -->
  <tr>
    <td style="padding:0 30px 20px;">
      <h3 style="margin:0 0 10px; font-size:15px; color:#f26622;">
        Business Information
      </h3>

      <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #eee; border-radius:8px;">
        <tr><td style="padding:18px;">

          <table width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;">
            <tr>
              <td style="color:#777; width:40%;">Trading Name</td>
              <td>{{ $vendor->trading_name }}</td>
            </tr>
            <tr>
              <td style="padding-top:8px; color:#777;">Company Name</td>
              <td style="padding-top:8px;">{{ $vendor->company_name }}</td>
            </tr>
            <tr>
              <td style="padding-top:8px; color:#777;">Business Type</td>
              <td style="padding-top:8px;">{{ $vendor->organization_status }}</td>
            </tr>
            <tr>
              <td style="padding-top:8px; color:#777;">Registration No</td>
              <td style="padding-top:8px;">{{ $vendor->registration_no }}</td>
            </tr>
            <tr>
              <td style="padding-top:8px; color:#777;">Contact Number</td>
              <td style="padding-top:8px;">{{ $vendor->phone_no }}</td>
            </tr>
          </table>

        </td></tr>
      </table>
    </td>
  </tr>

  <!-- SECTION: LOCATION -->
  <tr>
    <td style="padding:0 30px 25px;">
      <h3 style="margin:0 0 10px; font-size:15px; color:#f26622;">
        Location Details
      </h3>

      <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #eee; border-radius:8px;">
        <tr><td style="padding:18px;">

          <table width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;">
            <tr>
              <td style="color:#777; width:40%;">Country</td>
              <td>{{ $vendor->country }}</td>
            </tr>
            <tr>
              <td style="padding-top:8px; color:#777;">City</td>
              <td style="padding-top:8px;">{{ $vendor->city }}</td>
            </tr>
            <tr>
              <td style="padding-top:8px; color:#777;">Postcode</td>
              <td style="padding-top:8px;">{{ $vendor->postcode }}</td>
            </tr>
            <tr>
              <td style="padding-top:8px; color:#777;">Address</td>
              <td style="padding-top:8px;">
                {{ $vendor->address_line_1 }},
                {{ $vendor->address_line_2 }},
                {{ $vendor->address_line_3 }},
                {{ $vendor->address_line_4 }}
              </td>
            </tr>
          </table>

        </td></tr>
      </table>
    </td>
  </tr>

  <!-- CTA -->
  <tr>
    <td align="center" style="padding:0 30px 30px;">
      <table cellpadding="0" cellspacing="0">
        <tr>
          <td bgcolor="#000000" style="border-radius:8px;">
            <a href="{{route('admin.application.detail', $user['id'])}}"
               style="display:inline-block; padding:14px 26px; color:#ffffff; text-decoration:none; font-size:14px; font-weight:600;">
               Review Vendor Profile
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
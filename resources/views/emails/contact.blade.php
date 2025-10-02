{{-- Preheader (hidden in most clients) --}}
<span style="display:none!important;visibility:hidden;opacity:0;color:transparent;height:0;width:0;overflow:hidden;">
  New contact message received fom website
</span>

@php
    $logo = asset('images/dss-logo.png');
@endphp

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>New Contact Message fom website</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    /* Basic email-safe styles */
    body { margin:0; padding:0; background:#f6f7fb; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
    a { color:#0d6efd; text-decoration:none; }
    .wrapper { width:100%; background:#f6f7fb; padding:24px 0; }
    .container { width:100%; max-width:640px; margin:0 auto; background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.06); }
    .header { padding:24px; text-align:center; border-bottom:1px solid #eef0f4; }
    .logo-space { height:56px; line-height:56px; color:#94a3b8; font-size:12px; }
    .content { padding:24px; }
    .title { margin:0 0 12px; font-size:20px; font-weight:700; color:#0f172a; }
    .meta-table { width:100%; border-collapse:collapse; margin:16px 0 24px; }
    .meta-table th, .meta-table td { text-align:left; padding:10px 12px; vertical-align:top; border-bottom:1px solid #eef0f4; font-size:14px; color:#0f172a; }
    .meta-table th { width:160px; color:#475569; font-weight:600; background:#fafbfc; }
    .message-box { background:#0f172a; color:#ffffff; padding:16px; border-radius:8px; white-space:pre-wrap; line-height:1.55; font-size:14px; }
    .footer { padding:16px 24px; color:#64748b; font-size:12px; text-align:center; border-top:1px solid #eef0f4; }
    .btn { display:inline-block; padding:10px 14px; border-radius:6px; background:#0d6efd; color:#ffffff !important; font-weight:600; font-size:14px; }
    .btn + .btn { margin-left:8px; }
    @media (max-width: 480px){
      .content { padding:18px; }
      .header, .footer { padding:18px; }
      .meta-table th { width:120px; }
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
      <tr>
        <td align="center">
          <div class="container">
            <!-- Header / Logo space -->
            <div class="header">
              <!-- Replace with your <img> when ready -->
              <div class="logo-space">
                <!-- Company Logo Placeholder -->
                <img src="{{ $logo }}" alt='DSS logo'>
              </div>
            </div>

            <!-- Body -->
            <div class="content">
              <h1 class="title">New Contact Message</h1>

              <table class="meta-table" role="presentation">
                <tr>
                  <th>From</th>
                  <td>{{ $payload['name'] ?? '—' }}</td>
                </tr>
                <tr>
                  <th>Email</th>
                  <td>
                    @php $email = $payload['email'] ??  null; @endphp
                    @if($email)
                      <a href="mailto:{{ $email }}">{{ $email }}</a>
                    @else
                      —
                    @endif
                  </td>
                </tr>
                @if(!empty($payload['phone']))
                  <tr>
                    <th>Phone</th>
                    <td>{{ $payload['phone'] }}</td>
                  </tr>
                @endif
                @if(!empty($payload['website']))
                  <tr>
                    <th>Website</th>
                    @php $website = $payload['website']; @endphp
                    <td>
                      @if(Str::startsWith($website, ['http://','https://']))
                        <a href="{{ $website }}" target="_blank" rel="noopener">{{ $website }}</a>
                      @else
                        <a href="https://{{ $website }}" target="_blank" rel="noopener">{{ $website }}</a>
                      @endif
                    </td>
                  </tr>
                @endif
                <tr>
                  <th>Subject</th>
                  <td>{{ $payload['subject'] ?? 'Contact Form Message' }}</td>
                </tr>
                <tr>
                  <th>Submitted</th>
                  <td>
                    @php
                      $submittedAt = $payload['submitted_at'] ?? ($contact->created_at ?? now());
                    @endphp
                    {{ \Illuminate\Support\Carbon::parse($submittedAt)->toDayDateTimeString() }}
                  </td>
                </tr>
              </table>

              <div class="message-box">
                {{ $payload['message'] ?? '' }}
              </div>

              <!-- Quick actions -->
              <p style="margin:18px 0 0;">
                @if(!empty($email))
                  <a class="btn" href="mailto:{{ $email }}?subject=Re:%20{{ urlencode($payload['subject'] ?? ($contact->subject ?? 'Contact Form Message')) }}">
                    Reply via Email
                  </a>
                @endif
              </p>
            </div>

            <!-- Footer -->
            <div class="footer">
              You’re receiving this because your site’s contact form was submitted.
            </div>
          </div>
        </td>
      </tr>
    </table>
  </div>
</body>
</html>

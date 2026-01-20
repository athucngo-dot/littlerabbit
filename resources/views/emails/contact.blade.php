<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Message from Contact Us</title>
</head>
<body style="margin:0; padding:0; background-color:#f5f7f6; font-family: Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" role="presentation"
       style="background: linear-gradient(to bottom, #c7f0e8, #f7f7f4); padding: 32px 0;">
    <tr>
        <td align="center">

        <!-- Container -->
        <table width="600" cellpadding="0" cellspacing="0" role="presentation"
               style="background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 10px 25px rgba(0,0,0,0.06);">

            <!-- Header -->
            <tr>
                <td style="padding:24px; border-bottom:1px solid #eaeaea;">
                    <a href="{{ config('app.url') }}" target="_blank" style="text-decoration:none;">
                        <table cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <!-- Logo -->
                                <td style="vertical-align:middle;">
                                    <img src="https://littlerabbit.anh-thuc-ngo.com/images/logo.png"
                                        alt="Logo"
                                        style="height:32px; width:auto; display:block;">
                                </td>

                                <!-- Spacing -->
                                <td style="width:8px;"></td>

                                <!-- App name -->
                                <td style="vertical-align:middle;">
                                    <span style="
                                        font-weight:bold;
                                        font-family: Arial, Helvetica, sans-serif;
                                        font-size:18px;
                                        color:#111;
                                        letter-spacing:-0.02em;
                                        white-space:nowrap;
                                    ">
                                        {{ config('app.name') }}
                                    </span>
                                </td>
                            </tr>
                        </table>                        
                    </a>
                </td>
            </tr>

            <!-- Content -->
            <tr>
                <td style="padding:32px;">
                    <h2 style="margin:0 0 16px; font-size:20px; color:#111;">
                        New Contact Us Message from {{ $first_name }} {{ $last_name }}
                    </h2>

                    <p style="margin:0 0 24px; font-size:14px; color:#555;">
                        You've received a new message from contact us page.
                    </p>

                    <!-- Details -->
                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                           style="font-size:14px; color:#333;">
                        <tr>
                            <td style="padding:6px 0; font-weight:bold;">Name:</td>
                            <td style="padding:6px 0;">
                                {{ $first_name }} {{ $last_name }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:6px 0; font-weight:bold;">Email:</td>
                            <td style="padding:6px 0;">
                                <a href="mailto:{{ $email }}" style="color:#2563eb; text-decoration:none;">
                                    {{ $email }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:6px 0; font-weight:bold;">Subject:</td>
                            <td style="padding:6px 0;">
                                {{ $subject ?? 'No Subject' }}
                            </td>
                        </tr>
                    </table>

                    <!-- Message -->
                    <div style="margin-top:24px;">
                        <p style="margin:0 0 8px; font-weight:bold; font-size:14px;">
                            Message:
                        </p>
                        <div style="background:#f9fafb; padding:16px; border-radius:8px; color:#333; line-height:1.6;">
                            {!! nl2br(e($body)) !!}
                        </div>
                    </div>
                </td>
            </tr>

            <!-- Footer -->
            <tr>
                <td style="padding:20px; text-align:center; font-size:12px; color:#777; background:#fafafa;">
                    This email was sent from
                    <a href="{{ config('app.url') }}" style="color:#2563eb; text-decoration:none;">
                        {{ config('app.name') }}
                    </a>.
                </td>
            </tr>

        </table>
    </td>
</tr>

</table>

</body>
</html>

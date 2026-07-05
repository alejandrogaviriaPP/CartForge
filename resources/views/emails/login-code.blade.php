<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('login_code.subject') }}</title>
</head>
<body style="margin:0;padding:0;background-color:#f3f4f6;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f3f4f6;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="560" cellpadding="0" cellspacing="0" style="max-width:560px;width:100%;background-color:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.08);">

                    <tr>
                        <td style="padding:32px 40px 8px 40px;text-align:center;">
                            <span style="font-size:22px;font-weight:700;letter-spacing:-.02em;color:#111827;">&#128722; CartForge</span>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:8px 40px 0 40px;">
                            <h1 style="margin:0;font-size:24px;line-height:1.3;color:#111827;">{{ __('login_code.welcome', ['name' => $user->name]) }}</h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:16px 40px 0 40px;font-size:15px;line-height:1.6;color:#4b5563;">
                            {{ __('login_code.intro') }}
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding:28px 40px 8px 40px;">
                            <span style="display:inline-block;padding:18px 40px;background-color:#f9fafb;border:1px solid #e5e7eb;border-radius:12px;font-size:40px;font-weight:700;letter-spacing:.35em;color:#111827;">{{ $code }}</span>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding:8px 40px 28px 40px;">
                            <a href="{{ config('app.url') }}/products" style="display:inline-block;padding:14px 36px;background-color:#2563eb;border-radius:10px;font-size:15px;font-weight:600;color:#ffffff;text-decoration:none;">{{ __('login_code.shop_btn') }}</a>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:8px 40px 36px 40px;">
                            <p style="margin:0;font-size:12px;line-height:1.6;color:#9ca3af;text-align:center;border-top:1px solid #f3f4f6;padding-top:20px;">
                                {{ __('login_code.expires', ['minutes' => \App\Services\LoginVerification::EXPIRES_MINUTES]) }}<br>
                                {{ __('login_code.ignore') }}
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>

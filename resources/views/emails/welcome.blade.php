<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('welcome_email_subject') }}</title>
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
                            <h1 style="margin:0;font-size:24px;line-height:1.3;color:#111827;">{{ __('welcome_email_greeting', ['name' => $user->name]) }}</h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:16px 40px 0 40px;font-size:15px;line-height:1.6;color:#4b5563;">
                            {{ __('welcome_email_intro') }}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:24px 40px 0 40px;">
                            <p style="margin:0 0 12px 0;font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:.08em;color:#9ca3af;">{{ __('welcome_email_explore') }}</p>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding:0 4px 0 0;width:33%;">
                                        <a href="{{ config('app.url') }}/products?category=tech" style="display:block;text-align:center;padding:14px 8px;background-color:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;font-size:14px;font-weight:600;color:#2563eb;text-decoration:none;">{{ __('Tech') }}</a>
                                    </td>
                                    <td style="padding:0 4px;width:33%;">
                                        <a href="{{ config('app.url') }}/products?category=fashion" style="display:block;text-align:center;padding:14px 8px;background-color:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;font-size:14px;font-weight:600;color:#2563eb;text-decoration:none;">{{ __('Fashion') }}</a>
                                    </td>
                                    <td style="padding:0 0 0 4px;width:34%;">
                                        <a href="{{ config('app.url') }}/products?category=home" style="display:block;text-align:center;padding:14px 8px;background-color:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;font-size:14px;font-weight:600;color:#2563eb;text-decoration:none;">{{ __('Home Goods') }}</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:28px 40px 0 40px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#eff6ff;border:1px dashed #93c5fd;border-radius:12px;">
                                <tr>
                                    <td style="padding:20px 24px;text-align:center;">
                                        <p style="margin:0 0 4px 0;font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:.08em;color:#1d4ed8;">{{ __('welcome_email_gift_title') }}</p>
                                        <p style="margin:0 0 12px 0;font-size:14px;color:#4b5563;">{{ __('welcome_email_gift_text') }}</p>
                                        <span style="display:inline-block;padding:10px 20px;background-color:#ffffff;border:1px solid #bfdbfe;border-radius:8px;font-size:20px;font-weight:700;letter-spacing:.12em;color:#1d4ed8;">WELCOME10</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding:28px 40px 8px 40px;">
                            <a href="{{ config('app.url') }}/products" style="display:inline-block;padding:14px 36px;background-color:#2563eb;border-radius:10px;font-size:15px;font-weight:600;color:#ffffff;text-decoration:none;">{{ __('welcome_email_shop_btn') }}</a>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:28px 40px 36px 40px;">
                            <p style="margin:0;font-size:12px;line-height:1.6;color:#9ca3af;text-align:center;border-top:1px solid #f3f4f6;padding-top:20px;">
                                {{ __('welcome_email_footer') }}<br>
                                <a href="{{ config('app.url') }}" style="color:#9ca3af;text-decoration:underline;">{{ config('app.url') }}</a>
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>

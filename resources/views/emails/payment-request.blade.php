<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('payment_request.subject') }}</title>
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
                            <h1 style="margin:0;font-size:24px;line-height:1.3;color:#111827;">{{ __('payment_request.greeting', ['name' => $order->user->name]) }}</h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:16px 40px 0 40px;font-size:15px;line-height:1.6;color:#4b5563;">
                            {{ __('payment_request.intro', ['id' => $order->id, 'total' => number_format($order->total, 2)]) }}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:24px 40px 0 40px;">
                            <a href="{{ $paymentUrl }}"
                                style="display:block;background-color:#16a34a;color:#ffffff;text-align:center;padding:14px 24px;border-radius:12px;font-size:15px;font-weight:600;text-decoration:none;">
                                {{ __('payment_request.pay_button') }}
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:12px 40px 0 40px;font-size:13px;line-height:1.6;color:#6b7280;">
                            {{ __('payment_request.instructions') }}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:24px 40px 32px 40px;font-size:12px;color:#9ca3af;text-align:center;">
                            {{ __('payment_request.footer') }}
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>

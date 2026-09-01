<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class WompiPayment
{
    public function isConfigured(): bool
    {
        return ! empty(config('services.wompi.public_key')) && ! empty(config('services.wompi.integrity_key'));
    }

    public function createPaymentLink(Order $order, string $email): ?array
    {
        $reference = $this->reference($order);

        $response = Http::withToken((string) config('services.wompi.public_key'))
            ->acceptJson()
            ->post(rtrim((string) config('services.wompi.url'), '/') . '/payment_links', [
                'name' => __('Payment for CartForge order #:id', ['id' => $order->id]),
                'description' => $order->items->pluck('name')->implode(', '),
                'single_use' => true,
                'amount_in_cents' => (int) round($order->total * 100),
                'currency' => 'COP',
                'collect_email' => true,
                'metadata' => [
                    'order_id' => $order->id,
                    'reference' => $reference,
                    'customer_email' => $email,
                ],
            ]);

        $url = $response->json('data.url') ?? $response->json('data.link');

        if ($response->failed() || blank($url)) {
            return null;
        }

        return ['reference' => $reference, 'url' => $url];
    }

    public function verifyWebhookSignature(array $event): bool
    {
        $checksum = (string) ($event['signature']['checksum'] ?? '');
        $eventsKey = (string) config('services.wompi.events_key');

        if ($checksum === '' || $eventsKey === '') {
            return false;
        }

        $transaction = $event['data']['transaction'] ?? [];

        $payload = implode('', [
            $transaction['id'] ?? '',
            $transaction['status'] ?? '',
            $transaction['amount_in_cents'] ?? '',
        ]) . $eventsKey;

        return hash_equals($checksum, hash('sha256', $payload));
    }

    private function reference(Order $order): string
    {
        return 'CF-' . $order->id . '-' . strtoupper(Str::random(6));
    }
}

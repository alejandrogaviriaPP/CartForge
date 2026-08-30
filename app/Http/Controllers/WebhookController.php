<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\WompiPayment;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function wompi(Request $request, WompiPayment $wompi)
    {
        $event = $request->all();

        if (! $wompi->verifyWebhookSignature($event)) {
            return response()->json(['success' => false], 401);
        }

        $transaction = $event['data']['transaction'] ?? [];

        if (($transaction['status'] ?? '') === 'APPROVED') {
            Order::where('payment_reference', $transaction['reference'])
                ->where('status', 'pending')
                ->update(['status' => 'paid']);
        }

        return response()->json(['success' => true]);
    }
}

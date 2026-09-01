<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function cancel(Request $request, Order $order)
    {
        abort_unless($request->user() && $order->user_id === $request->user()->id, 403);

        if (! $order->cancel()) {
            return redirect()->route('profile.edit')->with('error', __('This order can no longer be cancelled.'));
        }

        return redirect()->route('profile.edit')->with('success', __('Order cancelled successfully.'));
    }
}

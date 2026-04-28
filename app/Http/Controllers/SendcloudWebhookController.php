<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SendcloudWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();
        
        Log::info('Sendcloud Webhook Payload:', $payload);

        $parcel = $payload['parcel'] ?? null;
        $action = $payload['action'] ?? '';

        if ($parcel && $action === 'parcel_status_changed') {
            $order = Order::where('sendcloud_id', $parcel['id'])->first();

            if ($order) {
                $order->update([
                    'tracking_number' => $parcel['tracking_number'] ?? $order->tracking_number,
                    'status' => ($parcel['status']['id'] >= 1000) ? 'shipped' : $order->status
                ]);

                return response()->json(['message' => 'OK'], 200);
            }
        }

        return response()->json(['message' => 'Ignored'], 200);
    }
}
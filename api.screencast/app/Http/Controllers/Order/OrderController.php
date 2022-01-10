<?php

namespace App\Http\Controllers\Order;

use App\Models\User;
use App\Models\Order\Order;
use Illuminate\Http\Request;
use App\Models\Screencast\Playlist;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function store()
    {
        $order = Auth::user()->orders()->create([
            'order_identifier' => 'order-' . time(),
            'playlist_ids' => Auth::user()->carts()->pluck('playlist_id'),
            'total' => Auth::user()->carts()->sum('price')
        ]);

        $params = [
            'enable_payments' => [
                "credit_card", "cimb_clicks",
                "bca_klikbca", "bca_klikpay", "bri_epay", "echannel", "permata_va",
                "bca_va", "bni_va", "bri_va", "other_va", "gopay", "indomaret",
                "danamon_online", "akulaku", "shopeepay"
            ],
            'transaction_details' => [
                'order_id' => $order->order_identifier,
                'gross_amount' => $order->total
            ],
            'customer_details' => Auth::user(),
            'expriy' => [
                'start_time' => now()->format('Y-m-d H:i:s T'),
                'unit' => 'days',
                'duration' => 1,
            ],
        ];

        $headers = [
            'Authorization' => 'Basic ' . base64_encode(config('payment.server_key') . ':'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $url = 'https://app.sandbox.midtrans.com/snap/v1/transactions';
        $response = Http::withHeaders($headers)->post($url, $params);

        return $response;
    }

    public function notificationHandler(Request $request)
    {
        info("hit");
        // Ha512(order_id+status_code+gross_amount+serverkey)
        $signature = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . config('payment.server_key'));
        if ($signature !== $request->signature_key) {
            abort(404);
        }

        $order = Order::where('order_identifier', $request->order_id)->first();
        $user = User::find($order->user_id);

        foreach($order->playlist_ids as $i){
            $playlist = Playlist::find($i);
            $user->buy($playlist);
        }

        $order->delete();
        $user->carts()->delete();

        return;
    }
}

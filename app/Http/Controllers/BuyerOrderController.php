<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class BuyerOrderController extends Controller
{
    /**
     * Display a listing of the buyer's orders.
     */
    public function index()
    {
        $orders = Order::with('product')
            ->where('buyer_id', auth()->id())
            ->latest()
            ->get();

        return view('buyer.orders', compact('orders'));
    }

    /**
     * Confirm delivery of a shipped order.
     */
    public function confirmDelivery($id)
    {
        $order = Order::where('id', $id)
            ->where('buyer_id', auth()->id())
            ->firstOrFail();

        if ($order->status !== 'shipped') {
            return redirect()->route('buyer.orders')->with('error', 'Order is not shipped yet.');
        }

        $order->status = 'delivered';
        $order->save();

        // Optional: notify seller or release escrow funds here
        // Example: event(new OrderDelivered($order));

        return redirect()->route('buyer.orders')->with('success', 'Delivery confirmed successfully.');
    }
}

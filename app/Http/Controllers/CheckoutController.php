<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function buyNow($id)
    {
        $buyer = Auth::user();

        // Step 1: Find the product
        $product = Product::findOrFail($id);

        // Step 2: Create an order record (simulate escrow)
        $order = Order::create([
            'product_id'   => $product->id,
            'buyer_id'     => $buyer->id,
            'seller_id'    => $product->seller_id, // assuming product has seller_id
            'price'        => $product->price,
            'status'       => 'pending', // pending -> paid -> delivered -> released
        ]);

        // Step 3: Redirect to confirmation or payment page
        return redirect()->route('buyer.orders')->with('success', 'Order placed! Awaiting payment.');
    }
}

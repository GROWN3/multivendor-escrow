<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class BuyerController extends Controller
{
    public function dashboard()
    {
        $orders = Order::with('product')
            ->where('buyer_id', auth()->id())
            ->get();

        $products = Product::latest()->get();

        return view('dashboard.buyer', compact('orders', 'products'));
    }
}

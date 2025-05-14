<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function redirectToDashboard()
    {
        $role = Auth::user()->role;

        return match ($role) {
            'buyer' => redirect()->route('dashboard.buyer'),
            'seller' => redirect()->route('dashboard.seller'),
            default => abort(403)
        };
    }

    public function buyerDashboard()
    {
        $orders = Order::with('product')
            ->where('buyer_id', auth()->id())
            ->get();

        $products = Product::latest()->get();

        return view('dashboard.buyer', compact('orders', 'products'));
    }

    public function sellerDashboard()
{
    $products = Product::where('user_id', Auth::id())->get();

    return view('dashboard.seller', compact('products'));
}
}


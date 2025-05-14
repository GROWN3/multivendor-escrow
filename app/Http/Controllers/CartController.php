<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        // For now, just return back
        return back()->with('success', 'Product added to cart (simulated)');
    }
}

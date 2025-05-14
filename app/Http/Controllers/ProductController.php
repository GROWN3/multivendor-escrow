<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Seller dashboard: list own products
    public function index()
    {
        $products = Product::where('user_id', auth()->id())->get();
        return view('dashboard.seller', compact('products'));
    }

    // Show product creation form
    public function create()
    {
        return view('seller.create');
    }

    // Store new product with optional image
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = new Product($validated);
        $product->user_id = auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->save();

        return redirect()->route('dashboard.seller')->with('success', 'Product created successfully.');
    }

    // Buyer product listing
    public function list()
    {
        $products = Product::latest()->get();
        return view('dashboard.buyer', compact('products'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    // Dashboard view method
    public function index()
    {
        $products = Product::where('user_id', auth()->id())->get();

        $orders = Order::with('product')->whereHas('product', function ($q) {
            $q->where('user_id', auth()->id());
        })->get();

        return view('dashboard.seller', compact('products', 'orders'));
    }

    // Show create product form
    public function create()
    {
        return view('seller.create');
    }

    // Store product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'name' => 'required|string|max:255',
        ]);

        $product = new Product();
        $product->title = $validated['title'];
        $product->description = $validated['description'];
        $product->name = $request->name;
        $product->price = $validated['price'];
        $product->user_id = auth()->id();
        $product->save();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->save();

        return redirect()->route('dashboard.seller')->with('success', 'Product created successfully!');
    }
}

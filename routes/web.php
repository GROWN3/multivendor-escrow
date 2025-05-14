<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\BuyerOrderController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/buyer/orders', [BuyerOrderController::class, 'index'])->name('buyer.orders');
    Route::post('/buyer/orders/{id}/confirm', [BuyerOrderController::class, 'confirmDelivery'])->name('buyer.orders.confirm');
});

Route::get('/buyer/orders', [BuyerOrderController::class, 'index'])->name('buyer.orders');

Route::get('/checkout/now/{id}', [CheckoutController::class, 'buyNow'])->name('checkout.now');

Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');

Route::post('/checkout/process/{id}', [CheckoutController::class, 'process'])->name('checkout.process');

// Cart
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');

// Checkout (Buy Now)
Route::get('/checkout/now/{id}', [CheckoutController::class, 'buyNow'])->name('checkout.now');


Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/seller/products/create', [SellerController::class, 'create'])->name('seller.create');
    Route::post('/seller/products', [SellerController::class, 'store'])->name('seller.store');
});


Route::middleware(['auth', 'verified'])->group(function () {
    // Seller Dashboard
    Route::get('/dashboard/seller', [SellerController::class, 'dashboard'])->name('dashboard.seller');

    // Mark Order as Shipped
    Route::post('/orders/{id}/mark-shipped', [SellerController::class, 'markOrderShipped'])->name('orders.markShipped');

    // Buyer Dashboard
    Route::get('/dashboard/buyer', [BuyerController::class, 'dashboard'])->name('dashboard.buyer');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
});

Route::get('/dashboard/seller', function () {
    $products = Product::where('user_id', Auth::id())->get();
    return view('dashboard.seller', compact('products'));
})->name('dashboard.seller')->middleware(['auth', 'verified']);

// Homepage
Route::get('/', function () {
    return view('dashboard');
});

// Registration
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest');

// Redirect based on user role
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard.buyer', function () {
        $user = Auth::user();

        if ($user->is_seller) {
            return redirect()->route('dashboard.seller');
        } else {
            return redirect()->route('dashboard.buyer');
        }
    })->name('dashboard');
});

// ✅ Buyer Dashboard (Only this version remains!)
Route::get('/buyer/dashboard', [DashboardController::class, 'buyerDashboard'])
    ->name('dashboard.buyer')
    ->middleware(['auth', 'verified']);

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes
require __DIR__.'/auth.php';

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Seller Dashboard</h2>
    </x-slot>

    <div class="p-6 space-y-10">

        {{-- Flash Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                <p class="font-bold">Success</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        {{-- Add Product Button --}}
        <div class="flex justify-end">
            <a href="{{ route('products.create') }}" class="bg-blue-600 text-white font-semibold px-5 py-2 rounded hover:bg-blue-700 shadow">
                + Add Product
            </a>
        </div>

        {{-- My Products Section --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow">
            <h3 class="text-lg font-bold mb-4">My Products</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                    <div class="border rounded-lg p-4 shadow hover:shadow-lg transition bg-white dark:bg-gray-800">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}"
                                class="w-full h-48 object-cover mb-3 rounded">
                        @endif

                        <h4 class="text-lg font-semibold mb-1">{{ $product->title }}</h4>
                        <p class="text-gray-600 dark:text-gray-300 mb-2">{{ \Str::limit($product->description, 80) }}</p>
                        <span class="text-green-600 font-bold">${{ number_format($product->price, 2) }}</span>
                    </div>
                @empty
                    <div class="text-center text-gray-500 p-10 border rounded bg-gray-50 col-span-full">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h4l3 10h8l3-10h4M4 6h16" />
                        </svg>
                        <p class="mt-2">You haven't listed any products yet.</p>
                        <a href="{{ route('products.create') }}" class="text-blue-600 hover:underline mt-1 inline-block">Add your first product</a>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Product Orders Section --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow">
            <h3 class="text-lg font-bold mb-4">Product Orders</h3>
            @php
                $orders = \App\Models\Order::with('product')->whereHas('product', function($q) {
                    $q->where('user_id', auth()->id());
                })->get();
            @endphp

            @forelse($orders as $order)
                @if($order->product)
                    <div class="border rounded p-4 mb-4 bg-gray-50 hover:shadow transition">
                        <p><strong>Product:</strong> {{ $order->product->title }}</p>
                        <p><strong>Buyer ID:</strong> {{ $order->buyer_id }}</p>
                        <p><strong>Status:</strong> <span class="capitalize">{{ $order->status }}</span></p>

                        @if($order->status === 'pending')
                            <form method="POST" action="{{ route('orders.markShipped', $order->id) }}">
                                @csrf
                                <button class="mt-2 bg-yellow-600 text-white px-4 py-1 rounded hover:bg-yellow-700">
                                    Mark as Shipped
                                </button>
                            </form>
                        @endif
                    </div>
                @else
                    <div class="text-sm text-red-600">Related product no longer exists.</div>
                @endif
            @empty
                <div class="text-center text-gray-500 p-10 border rounded bg-gray-50">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 118 0v2M6 8v2a6 6 0 0012 0V8" />
                    </svg>
                    <p class="mt-2">You haven’t received any orders yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Buyer Dashboard</h2>
    </x-slot>

    <div class="p-6 space-y-10">

        {{-- Flash Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                <p class="font-bold">Success</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        {{-- My Orders Section --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow w-full max-w-[800px] mx-auto">
            <h3 class="text-lg font-bold mb-4">My Orders</h3>

            @forelse($orders as $order)
                @if($order->product)
                    <div class="border rounded p-4 mb-4 bg-gray-50 hover:shadow transition">
                        <div class="flex items-center space-x-4">
                            @if($order->product->image)
                                <img src="{{ asset('storage/' . $order->product->image) }}"
                                    alt="{{ $order->product->title }}"
                                    class="w-20 h-20 object-cover rounded">
                            @else
                                <div class="w-20 h-20 bg-gray-200 flex items-center justify-center rounded text-gray-500">
                                    No Image
                                </div>
                            @endif

                            <div>
                                <h4 class="text-lg font-semibold">{{ $order->product->title }}</h4>
                                <p class="text-gray-600 dark:text-gray-300">Ksh {{ number_format($order->product->price, 2) }}</p>
                                <p class="mt-1 text-sm text-gray-700"><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-sm text-red-600">A product in your order history no longer exists.</div>
                @endif
            @empty
                <div class="text-center text-gray-500 p-10 border rounded bg-gray-50">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 3h18M9 3v18M15 3v18M4 21h16" />
                    </svg>
                    <p class="mt-2">You haven’t placed any orders yet.</p>
                </div>
            @endforelse
        </div>

{{-- All Available Products --}}
<div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow">
    <h3 class="text-lg font-bold mb-4">Available Products</h3>

    @forelse($products as $product)
        <div class="border rounded p-4 mb-6 bg-gray-50 hover:shadow transition">
            <div class="flex items-center space-x-4">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        class="w-20 h-20 object-cover rounded">
                @else
                    <div class="w-20 h-20 bg-gray-200 flex items-center justify-center rounded text-gray-500">
                        No Image
                    </div>
                @endif

                <div class="flex-1">
                    <h4 class="text-lg font-semibold text-black">{{ $product->name }}</h4>
                    <p class="text-gray-700"> {{ $product->description }} </p>
                    <p class="text-blue-600 font-bold mt-1">Ksh {{ number_format($product->price, 2) }}</p>

                    {{-- Buttons --}}
                    <div class="mt-4 flex space-x-3">
                        {{-- Add to Cart --}}
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700 transition">
                                Add to Cart
                            </button>
                        </form>

                        {{-- Buy Now --}}
                        <a href="{{ route('checkout.now', $product->id) }}"
                            class="bg-green-600 text-black px-4 py-2 rounded hover:bg-green-700 transition">
                            Buy Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p class="text-gray-500">No products available right now.</p>
    @endforelse
</div>

    </div>
</x-app-layout>

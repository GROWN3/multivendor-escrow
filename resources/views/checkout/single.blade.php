<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-black">{{ $product->name }}</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 bg-white dark:bg-white rounded-xl shadow space-y-6">

        {{-- Product Details --}}
        <div class="flex flex-col md:flex-row items-start md:items-center space-y-6 md:space-y-0 md:space-x-8">

            {{-- Product Image --}}
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     class="w-full md:w-80 h-80 object-cover rounded-lg">
            @else
                <div class="w-full md:w-80 h-80 bg-gray-200 flex items-center justify-center rounded-lg text-gray-500">
                    No Image
                </div>
            @endif

            {{-- Product Info --}}
            <div class="flex-1 text-black">
                <h1 class="text-2xl font-bold text-black">{{ $product->name }}</h1>

                <p class="text-black mt-4">{{ $product->description }}</p>

                <p class="text-xl text-black font-bold mt-4">Ksh {{ number_format($product->price, 2) }}</p>

                {{-- Buttons --}}
                <div class="mt-6 flex space-x-4">
                    {{-- Add to Cart --}}
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                        class="bg-blue-600 text-black px-6 py-2 rounded hover:bg-blue-700 transition">Add to Cart</button>
                    </form>

    {{-- Buy Now --}}
    <a href="{{ route('checkout.now', $product->id) }}"
       class="bg-green-600 text-black px-6 py-2 rounded hover:bg-green-700 transition">
        Buy Now
    </a>
</div>
            </div>
        </div>

        {{-- Optional: Flash success message --}}
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded" role="alert">
                <p class="font-bold">Success</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

    </div>
</x-app-layout>

@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-4">My Orders</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->isEmpty())
        <p class="text-gray-600">You have no orders yet.</p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 rounded shadow-sm">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">Product</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Ordered At</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $index => $order)
                        <tr class="border-t">
                            <td class="p-3">{{ $index + 1 }}</td>
                            <td class="p-3">{{ $order->product->name }}</td>
                            <td class="p-3 capitalize">{{ $order->status }}</td>
                            <td class="p-3">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="p-3">
                                @if($order->status === 'shipped')
                                    <form action="{{ route('buyer.orders.confirm', $order->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded">
                                            Confirm Delivery
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-500 text-sm">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

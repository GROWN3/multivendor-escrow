<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Add New Product</h2>
    </x-slot>

    <div class="p-6 max-w-xl mx-auto">
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('seller.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block font-semibold mb-1">Title</label>
                <input type="text" name="title" class="w-full border rounded p-2" required>
            </div>

            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>


            <div>
                <label class="block font-semibold mb-1">Description</label>
                <textarea name="description" class="w-full border rounded p-2" rows="4" required></textarea>
            </div>

            <div>
                <label class="block font-semibold mb-1">Price (USD)</label>
                <input type="number" name="price" step="0.01" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Image</label>
                <input type="file" name="image" class="w-full border rounded p-2">
            </div>

            <div class="text-right">
                <button type="submit" class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">
                    Submit Product
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

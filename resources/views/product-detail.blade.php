<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $product->name }}
            </h2>
            <a href="{{ route('cart.list') }}" class="flex items-center hover:text-indigo-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="ml-1 bg-indigo-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ Cart::getTotalQuantity() }}</span>
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Product Image -->
                        <div>
                            <img src="{{ url($product->image) }}" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-lg">
                        </div>

                        <!-- Product Details -->
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                            
                            <div class="flex items-center mb-4">
                                <div class="text-yellow-400">
                                    @for($i = 0; $i < 5; $i++)
                                        @if($i < $product->averageRating())
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                                <span class="ml-2 text-gray-600">({{ $product->reviews()->count() }} reviews)</span>
                            </div>

                            <p class="text-2xl font-bold text-indigo-600 mb-4">${{ $product->price }}</p>
                            
                            <p class="text-gray-600 mb-6">{{ $product->description }}</p>

                            <form action="{{ route('cart.store') }}" method="POST" class="mb-6">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center border rounded-md">
                                        <button type="button" class="px-3 py-2 text-gray-600 hover:text-indigo-600" onclick="decrementQuantity()">-</button>
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-16 text-center border-0 focus:ring-0">
                                        <button type="button" class="px-3 py-2 text-gray-600 hover:text-indigo-600" onclick="incrementQuantity()">+</button>
                                    </div>
                                    <button type="submit" class="flex-1 bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition-colors">
                                        Add to Cart
                                    </button>
                                </div>
                            </form>

                            <div class="border-t pt-6">
                                <h3 class="text-lg font-semibold mb-2">Product Details</h3>
                                <ul class="space-y-2 text-gray-600">
                                    <li><span class="font-medium">Category:</span> {{ ucfirst($product->category) }}</li>
                                    <li><span class="font-medium">Stock:</span> {{ $product->stock }} available</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <x-reviews :product="$product" />
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function incrementQuantity() {
            const input = document.querySelector('input[name="quantity"]');
            const max = parseInt(input.getAttribute('max'));
            const currentValue = parseInt(input.value);
            if (currentValue < max) {
                input.value = currentValue + 1;
            }
        }

        function decrementQuantity() {
            const input = document.querySelector('input[name="quantity"]');
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        }
    </script>
    @endpush
</x-app-layout> 
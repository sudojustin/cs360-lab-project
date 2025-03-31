<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Orders') }}
            </h2>
            <a href="{{ route('cart.list') }}" class="flex items-center">
                <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                {{ Cart::getTotalQuantity() }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @foreach($orders as $order)
                    <div class="mb-6 p-4 border-b">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-semibold">Order #{{ $order->id }}</h3>
                                <p class="text-gray-600">Status: <span class="font-medium">{{ ucfirst($order->status) }}</span></p>
                                <p class="text-gray-600">Total Price: <span class="font-medium">${{ number_format($order->total_price, 2) }}</span></p>
                                <p class="text-gray-600">Placed at: <span class="font-medium">{{ $order->placed_at->format('F j, Y g:i A') }}</span></p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h4 class="font-semibold mb-2">Order Items:</h4>
                            <div class="space-y-2">
                                @foreach($order->products as $product)
                                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                        <div class="flex items-center">
                                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-md mr-4">
                                            <div>
                                                <p class="font-medium">{{ $product->name }}</p>
                                                <p class="text-gray-600">Quantity: {{ $product->pivot->quantity }}</p>
                                                <p class="text-gray-600">Price: ${{ number_format($product->pivot->price, 2) }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-medium">${{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>

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
                        <h3 class="text-xl font-semibold">Order #{{ $order->id }}</h3>
                        <p>Status: {{ $order->status }}</p>
                        <p>Total Price: ${{ $order->total_price }}</p>
                        <p>Placed at: {{ $order->placed_at }}</p>
                        <!-- Add more order details as needed -->
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>

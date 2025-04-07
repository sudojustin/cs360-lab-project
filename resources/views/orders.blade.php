<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Orders') }}
            </h2>
            <a href="{{ route('cart.list') }}" class="flex items-center hover:text-indigo-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="ml-1 bg-indigo-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ Cart::getTotalQuantity() }}</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Pending Orders Section -->
            <div class="mb-10">
                <div class="mb-6 bg-gradient-to-r from-yellow-500 to-amber-600 rounded-lg shadow-md overflow-hidden relative">
                    <div class="absolute inset-0 opacity-20">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                            <defs>
                                <pattern id="pattern-pending" width="40" height="40" patternUnits="userSpaceOnUse">
                                    <path d="M0 20 L40 20" stroke="white" stroke-width="0.5" fill="none" />
                                    <path d="M20 0 L20 40" stroke="white" stroke-width="0.5" fill="none" />
                                </pattern>
                            </defs>
                            <rect width="100%" height="100%" fill="url(#pattern-pending)" />
                        </svg>
                    </div>
                    <div class="px-6 py-4 relative z-10">
                        <h2 class="text-lg font-bold text-white">Pending Orders</h2>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-100">
                    @php $hasPendingOrders = false; @endphp
                    
                    @foreach($orders as $order)
                        @if($order->status == 'pending')
                            @php $hasPendingOrders = true; @endphp
                            <div class="mb-1 p-6 border-b border-gray-100 hover:bg-yellow-50 transition-colors">
                                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-4">
                                    <div>
                                        <h3 class="text-xl font-semibold mb-2 text-gray-800">Order #{{ $order->id }}</h3>
                                        <div class="flex flex-wrap gap-4 text-sm">
                                            <p class="text-gray-600">Status: 
                                                <span class="ml-1 font-medium px-2 py-1 text-xs rounded-full inline-flex items-center bg-yellow-100 text-yellow-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Pending
                                                </span>
                                            </p>
                                            <p class="text-gray-600">Placed: <span class="font-medium">{{ $order->placed_at->format('M d, Y g:i A') }}</span></p>
                                        </div>
                                    </div>
                                    <div class="md:text-right">
                                        <div class="text-lg font-bold text-amber-600">${{ number_format($order->total_price, 2) }}</div>
                                        <div class="text-xs text-gray-500 mt-1">{{ $order->products->sum('pivot.quantity') }} item(s)</div>
                                    </div>
                                </div>

                                <div class="mt-4 bg-gray-50 rounded-lg p-4">
                                    <h4 class="font-semibold mb-3 text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                        Order Items
                                    </h4>
                                    <div class="space-y-3">
                                        @foreach($order->products as $product)
                                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-3 border-b border-gray-200 last:border-0">
                                                <div class="flex items-center">
                                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-md mr-4 border border-gray-200 shadow-sm">
                                                    <div>
                                                        <p class="font-medium text-gray-800">{{ $product->name }}</p>
                                                        <div class="flex flex-wrap gap-x-4 text-sm text-gray-600 mt-1">
                                                            <span>Qty: {{ $product->pivot->quantity }}</span>
                                                            <span>${{ number_format($product->pivot->price, 2) }} each</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-right mt-2 sm:mt-0">
                                                    <p class="font-medium text-amber-600">${{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    
                    @if(!$hasPendingOrders)
                        <div class="p-8 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="mt-4 text-gray-500">You don't have any pending orders.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Processing Orders Section -->
            <div class="mb-10">
                <div class="mb-6 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg shadow-md overflow-hidden relative">
                    <div class="absolute inset-0 opacity-20">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                            <defs>
                                <pattern id="pattern-processing" width="40" height="40" patternUnits="userSpaceOnUse">
                                    <path d="M0 20 L40 20" stroke="white" stroke-width="0.5" fill="none" />
                                    <path d="M20 0 L20 40" stroke="white" stroke-width="0.5" fill="none" />
                                </pattern>
                            </defs>
                            <rect width="100%" height="100%" fill="url(#pattern-processing)" />
                        </svg>
                    </div>
                    <div class="px-6 py-4 relative z-10">
                        <h2 class="text-lg font-bold text-white">Processing Orders</h2>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-100">
                    @php $hasProcessingOrders = false; @endphp
                    
                    @foreach($orders as $order)
                        @if($order->status == 'processing')
                            @php $hasProcessingOrders = true; @endphp
                            <div class="mb-1 p-6 border-b border-gray-100 hover:bg-blue-50 transition-colors">
                                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-4">
                                    <div>
                                        <h3 class="text-xl font-semibold mb-2 text-gray-800">Order #{{ $order->id }}</h3>
                                        <div class="flex flex-wrap gap-4 text-sm">
                                            <p class="text-gray-600">Status: 
                                                <span class="ml-1 font-medium px-2 py-1 text-xs rounded-full inline-flex items-center bg-blue-100 text-blue-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                    </svg>
                                                    Processing
                                                </span>
                                            </p>
                                            <p class="text-gray-600">Placed: <span class="font-medium">{{ $order->placed_at->format('M d, Y g:i A') }}</span></p>
                                        </div>
                                    </div>
                                    <div class="md:text-right">
                                        <div class="text-lg font-bold text-indigo-600">${{ number_format($order->total_price, 2) }}</div>
                                        <div class="text-xs text-gray-500 mt-1">{{ $order->products->sum('pivot.quantity') }} item(s)</div>
                                    </div>
                                </div>

                                <div class="mt-4 bg-gray-50 rounded-lg p-4">
                                    <h4 class="font-semibold mb-3 text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                        Order Items
                                    </h4>
                                    <div class="space-y-3">
                                        @foreach($order->products as $product)
                                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-3 border-b border-gray-200 last:border-0">
                                                <div class="flex items-center">
                                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-md mr-4 border border-gray-200 shadow-sm">
                                                    <div>
                                                        <p class="font-medium text-gray-800">{{ $product->name }}</p>
                                                        <div class="flex flex-wrap gap-x-4 text-sm text-gray-600 mt-1">
                                                            <span>Qty: {{ $product->pivot->quantity }}</span>
                                                            <span>${{ number_format($product->pivot->price, 2) }} each</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-right mt-2 sm:mt-0">
                                                    <p class="font-medium text-indigo-600">${{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    
                    @if(!$hasProcessingOrders)
                        <div class="p-8 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <p class="mt-4 text-gray-500">You don't have any orders being processed.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Cancelled Orders Section -->
            <div class="mb-10">
                <div class="mb-6 bg-gradient-to-r from-red-500 to-rose-600 rounded-lg shadow-md overflow-hidden relative">
                    <div class="absolute inset-0 opacity-20">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                            <defs>
                                <pattern id="pattern-cancelled" width="40" height="40" patternUnits="userSpaceOnUse">
                                    <path d="M0 20 L40 20" stroke="white" stroke-width="0.5" fill="none" />
                                    <path d="M20 0 L20 40" stroke="white" stroke-width="0.5" fill="none" />
                                </pattern>
                            </defs>
                            <rect width="100%" height="100%" fill="url(#pattern-cancelled)" />
                        </svg>
                    </div>
                    <div class="px-6 py-4 relative z-10">
                        <h2 class="text-lg font-bold text-white">Cancelled Orders</h2>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-100">
                    @php $hasCancelledOrders = false; @endphp
                    
                    @foreach($orders as $order)
                        @if($order->status == 'cancelled')
                            @php $hasCancelledOrders = true; @endphp
                            <div class="mb-1 p-6 border-b border-gray-100 hover:bg-red-50 transition-colors">
                                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-4">
                                    <div>
                                        <h3 class="text-xl font-semibold mb-2 text-gray-800">Order #{{ $order->id }}</h3>
                                        <div class="flex flex-wrap gap-4 text-sm">
                                            <p class="text-gray-600">Status: 
                                                <span class="ml-1 font-medium px-2 py-1 text-xs rounded-full inline-flex items-center bg-red-100 text-red-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    Cancelled
                                                </span>
                                            </p>
                                            <p class="text-gray-600">Placed: <span class="font-medium">{{ $order->placed_at->format('M d, Y g:i A') }}</span></p>
                                        </div>
                                    </div>
                                    <div class="md:text-right">
                                        <div class="text-lg font-bold text-red-600">${{ number_format($order->total_price, 2) }}</div>
                                        <div class="text-xs text-gray-500 mt-1">{{ $order->products->sum('pivot.quantity') }} item(s)</div>
                                    </div>
                                </div>

                                <div class="mt-4 bg-gray-50 rounded-lg p-4">
                                    <h4 class="font-semibold mb-3 text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                        Order Items
                                    </h4>
                                    <div class="space-y-3">
                                        @foreach($order->products as $product)
                                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-3 border-b border-gray-200 last:border-0">
                                                <div class="flex items-center">
                                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-md mr-4 border border-gray-200 shadow-sm">
                                                    <div>
                                                        <p class="font-medium text-gray-800">{{ $product->name }}</p>
                                                        <div class="flex flex-wrap gap-x-4 text-sm text-gray-600 mt-1">
                                                            <span>Qty: {{ $product->pivot->quantity }}</span>
                                                            <span>${{ number_format($product->pivot->price, 2) }} each</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-right mt-2 sm:mt-0">
                                                    <p class="font-medium text-red-600 line-through">${{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    
                    @if(!$hasCancelledOrders)
                        <div class="p-8 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <p class="mt-4 text-gray-500">You don't have any cancelled orders.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Completed Orders Section -->
            <div class="mb-10">
                <div class="mb-6 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg shadow-md overflow-hidden relative">
                    <div class="absolute inset-0 opacity-20">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                            <defs>
                                <pattern id="pattern-completed" width="40" height="40" patternUnits="userSpaceOnUse">
                                    <path d="M0 20 L40 20" stroke="white" stroke-width="0.5" fill="none" />
                                    <path d="M20 0 L20 40" stroke="white" stroke-width="0.5" fill="none" />
                                </pattern>
                            </defs>
                            <rect width="100%" height="100%" fill="url(#pattern-completed)" />
                        </svg>
                    </div>
                    <div class="px-6 py-4 relative z-10">
                        <h2 class="text-lg font-bold text-white">Completed Orders</h2>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-100">
                    @php $hasCompletedOrders = false; @endphp
                    
                    @foreach($orders as $order)
                        @if($order->status == 'completed')
                            @php $hasCompletedOrders = true; @endphp
                            <div class="mb-1 p-6 border-b border-gray-100 hover:bg-green-50 transition-colors">
                                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-4">
                                    <div>
                                        <h3 class="text-xl font-semibold mb-2 text-gray-800">Order #{{ $order->id }}</h3>
                                        <div class="flex flex-wrap gap-4 text-sm">
                                            <p class="text-gray-600">Status: 
                                                <span class="ml-1 font-medium px-2 py-1 text-xs rounded-full inline-flex items-center bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Completed
                                                </span>
                                            </p>
                                            <p class="text-gray-600">Placed: <span class="font-medium">{{ $order->placed_at->format('M d, Y g:i A') }}</span></p>
                                        </div>
                                    </div>
                                    <div class="md:text-right">
                                        <div class="text-lg font-bold text-green-600">${{ number_format($order->total_price, 2) }}</div>
                                        <div class="text-xs text-gray-500 mt-1">{{ $order->products->sum('pivot.quantity') }} item(s)</div>
                                    </div>
                                </div>

                                <div class="mt-4 bg-gray-50 rounded-lg p-4">
                                    <h4 class="font-semibold mb-3 text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                        Order Items
                                    </h4>
                                    <div class="space-y-3">
                                        @foreach($order->products as $product)
                                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-3 border-b border-gray-200 last:border-0">
                                                <div class="flex items-center">
                                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-md mr-4 border border-gray-200 shadow-sm">
                                                    <div>
                                                        <p class="font-medium text-gray-800">{{ $product->name }}</p>
                                                        <div class="flex flex-wrap gap-x-4 text-sm text-gray-600 mt-1">
                                                            <span>Qty: {{ $product->pivot->quantity }}</span>
                                                            <span>${{ number_format($product->pivot->price, 2) }} each</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-right mt-2 sm:mt-0">
                                                    <p class="font-medium text-green-600">${{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    
                    @if(!$hasCompletedOrders)
                        <div class="p-8 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="mt-4 text-gray-500">You don't have any completed orders yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            @if(!$orders->count())
                <div class="bg-white rounded-lg shadow-md p-10 text-center">
                    <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No Orders Found</h3>
                    <p class="text-gray-500 mb-6">You haven't placed any orders yet.</p>
                    <a href="{{ route('products') }}" class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-medium rounded-md shadow transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Browse Products
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

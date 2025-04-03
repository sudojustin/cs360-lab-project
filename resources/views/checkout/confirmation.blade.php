<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Order Confirmation') }}
            </h2>
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-green-500 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="ml-2 text-sm font-medium">Shipping</div>
                </div>
                <div class="h-px w-8 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-green-500 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="ml-2 text-sm font-medium">Payment</div>
                </div>
                <div class="h-px w-8 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-green-500 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="ml-2 text-sm font-medium">Review</div>
                </div>
                <div class="h-px w-8 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-indigo-600 text-white">4</div>
                    <div class="ml-2 text-sm font-medium">Confirmation</div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="text-center py-8">
                        <div class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-green-100 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        
                        <h3 class="text-3xl font-bold text-gray-900 mb-2">Thank You For Your Order!</h3>
                        <p class="text-lg text-gray-600 mb-6">Your order has been placed successfully.</p>
                        
                        <!-- Order Information -->
                        <div class="inline-block bg-gray-50 rounded-lg px-6 py-4 mb-6">
                            <p class="text-gray-700">Order Number: <span class="font-bold">#{{ $order->id }}</span></p>
                            <p class="text-gray-700">Date: <span class="font-medium">{{ $order->placed_at->format('F j, Y, g:i a') }}</span></p>
                        </div>
                        
                        <div class="flex justify-center space-x-4">
                            <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                View My Orders
                            </a>
                            
                            <a href="{{ route('products') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                    
                    <!-- Order Details Section -->
                    <div class="mt-8 border-t border-gray-200 pt-8">
                        <h4 class="text-xl font-bold text-gray-800 mb-4">Order Details</h4>
                        
                        <div class="overflow-hidden">
                            <table class="w-full text-sm lg:text-base mb-8">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-600 uppercase text-xs border-b border-gray-200">
                                        <th class="text-left py-3 px-4">Product</th>
                                        <th class="text-center py-3 px-4">Quantity</th>
                                        <th class="text-right py-3 px-4">Price</th>
                                        <th class="text-right py-3 px-4">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->products as $product)
                                    <tr class="border-b border-gray-200">
                                        <td class="py-4 px-4 text-left">
                                            <span class="font-medium text-gray-800">{{ $product->name }}</span>
                                        </td>
                                        <td class="py-4 px-4 text-center">{{ $product->pivot->quantity }}</td>
                                        <td class="py-4 px-4 text-right">${{ number_format($product->pivot->price, 2) }}</td>
                                        <td class="py-4 px-4 text-right font-medium">${{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="border-t-2 border-gray-200">
                                    <tr>
                                        <td colspan="3" class="py-4 px-4 text-right">
                                            <span class="font-bold">Order Total:</span>
                                        </td>
                                        <td class="py-4 px-4 text-right">
                                            <span class="font-bold text-indigo-600">${{ number_format($order->total_price, 2) }}</span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-6 mt-8">
                            <!-- Shipping Information -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h5 class="text-lg font-medium text-gray-900 mb-2">Shipping Information</h5>
                                <div class="border-t border-gray-200 pt-2">
                                    <pre class="text-sm text-gray-600 whitespace-pre-line">{{ $order->shipping_address }}</pre>
                                </div>
                            </div>
                            
                            <!-- Payment Information -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h5 class="text-lg font-medium text-gray-900 mb-2">Payment Information</h5>
                                <div class="border-t border-gray-200 pt-2">
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Payment Method:</span> {{ $order->payment_provider }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Status:</span> {{ ucfirst($order->payment_status) }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-2">
                                        Transaction ID: {{ $order->payment_transaction_id }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
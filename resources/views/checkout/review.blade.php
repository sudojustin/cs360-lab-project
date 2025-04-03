<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Checkout - Review Order') }}
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
                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-indigo-600 text-white">3</div>
                    <div class="ml-2 text-sm font-medium">Review</div>
                </div>
                <div class="h-px w-8 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-200 text-gray-500">4</div>
                    <div class="ml-2 text-sm font-medium text-gray-500">Confirmation</div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Review Your Order</h3>
                    
                    <div class="lg:flex lg:space-x-6">
                        <div class="lg:w-2/3">
                            <!-- Order Items -->
                            <div class="mb-8">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Order Items</h4>
                                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="bg-gray-50 text-gray-600 uppercase text-xs border-b border-gray-200">
                                                <th class="py-3 px-4 text-left">Product</th>
                                                <th class="py-3 px-4 text-center">Quantity</th>
                                                <th class="py-3 px-4 text-right">Price</th>
                                                <th class="py-3 px-4 text-right">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cart_items as $item)
                                            <tr class="border-b border-gray-200">
                                                <td class="py-4 px-4">
                                                    <div class="flex items-center">
                                                        <img src="{{ $item->attributes->image }}" alt="{{ $item->name }}" class="w-12 h-12 object-cover rounded mr-4">
                                                        <span class="font-medium text-gray-800">{{ $item->name }}</span>
                                                    </div>
                                                </td>
                                                <td class="py-4 px-4 text-center">{{ $item->quantity }}</td>
                                                <td class="py-4 px-4 text-right">${{ number_format($item->price, 2) }}</td>
                                                <td class="py-4 px-4 text-right font-medium">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Order Details -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- Shipping Information -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h4 class="text-lg font-medium text-gray-900 mb-2">Shipping Information</h4>
                                    <div class="border-t border-gray-200 pt-2">
                                        <pre class="text-sm text-gray-600 whitespace-pre-line">{{ $shipping_address }}</pre>
                                    </div>
                                </div>
                                
                                <!-- Payment Information -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h4 class="text-lg font-medium text-gray-900 mb-2">Payment Method</h4>
                                    <div class="border-t border-gray-200 pt-2">
                                        <p class="text-sm text-gray-600">
                                            @if ($payment_method === 'credit_card')
                                                Credit Card
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <form method="POST" action="{{ route('checkout.place-order') }}" class="mt-8">
                                @csrf
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('checkout.payment') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                        Back to Payment
                                    </a>
                                    
                                    <button type="submit" class="inline-flex items-center px-5 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Place Order
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Order Summary Sidebar -->
                        <div class="lg:w-1/3 mt-8 lg:mt-0">
                            <div class="bg-gray-50 rounded-lg p-6 sticky top-6">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h4>
                                
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Subtotal</span>
                                        <span class="font-medium">${{ number_format($cart_total, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Shipping</span>
                                        <span class="font-medium">Free</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tax</span>
                                        <span class="font-medium">$0.00</span>
                                    </div>
                                </div>
                                
                                <div class="border-t border-gray-200 mt-4 pt-4">
                                    <div class="flex justify-between font-bold text-lg">
                                        <span>Total</span>
                                        <span class="text-indigo-600">${{ number_format($cart_total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
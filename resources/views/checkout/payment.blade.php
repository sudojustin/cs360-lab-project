<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Checkout - Payment Method') }}
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
                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-indigo-600 text-white">2</div>
                    <div class="ml-2 text-sm font-medium">Payment</div>
                </div>
                <div class="h-px w-8 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-200 text-gray-500">3</div>
                    <div class="ml-2 text-sm font-medium text-gray-500">Review</div>
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
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Payment Method</h3>

                    <div class="lg:flex lg:space-x-6">
                        <div class="lg:w-2/3">
                            <form method="POST" action="{{ route('checkout.payment.process') }}" class="space-y-4">
                                @csrf
                                
                                <div class="space-y-4">
                                    <div class="border border-gray-200 rounded-md overflow-hidden">
                                        <label class="flex items-center p-4 cursor-pointer hover:bg-gray-50">
                                            <input type="radio" name="payment_method" value="credit_card" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" checked>
                                            <div class="ml-3">
                                                <span class="block text-sm font-medium text-gray-900">Credit Card</span>
                                                <span class="block text-sm text-gray-500">Visa, MasterCard, Amex, Discover</span>
                                            </div>
                                            <div class="ml-auto flex items-center space-x-2">
                                                <span class="text-xs font-medium text-gray-800 bg-gray-100 px-2 py-1 rounded">VISA</span>
                                                <span class="text-xs font-medium text-gray-800 bg-gray-100 px-2 py-1 rounded">MC</span>
                                                <span class="text-xs font-medium text-gray-800 bg-gray-100 px-2 py-1 rounded">AMEX</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Credit card form -->
                                <div id="credit-card-form" class="mt-6 p-4 border border-gray-200 rounded-md bg-gray-50">
                                    <h4 class="text-lg font-medium text-gray-900 mb-4">Card Information</h4>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label for="card_number" class="block text-sm font-medium text-gray-700">Card Number</label>
                                            <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" 
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            @error('card_number')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="card_name" class="block text-sm font-medium text-gray-700">Name on Card</label>
                                            <input type="text" id="card_name" name="card_name" placeholder="John Doe" 
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            @error('card_name')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <div class="grid grid-cols-3 gap-4">
                                            <div class="col-span-1">
                                                <label for="expiry_month" class="block text-sm font-medium text-gray-700">Expiry Month</label>
                                                <select id="expiry_month" name="expiry_month" 
                                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <option value="{{ $i }}">{{ sprintf('%02d', $i) }}</option>
                                                    @endfor
                                                </select>
                                                @error('expiry_month')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-span-1">
                                                <label for="expiry_year" class="block text-sm font-medium text-gray-700">Expiry Year</label>
                                                <select id="expiry_year" name="expiry_year" 
                                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    @for ($i = date('Y'); $i <= date('Y') + 10; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                @error('expiry_year')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-span-1">
                                                <label for="cvv" class="block text-sm font-medium text-gray-700">CVV</label>
                                                <input type="text" id="cvv" name="cvv" placeholder="123" 
                                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                @error('cvv')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between pt-4">
                                    <a href="{{ route('checkout.shipping') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                        Back to Shipping
                                    </a>
                                    
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Continue to Review
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Order Summary Sidebar -->
                        <div class="lg:w-1/3 mt-8 lg:mt-0">
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h4>
                                
                                <div class="space-y-3 mb-4">
                                    @foreach($cart_items as $item)
                                        <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                                            <div>
                                                <p class="font-medium">{{ $item->name }}</p>
                                                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                            </div>
                                            <p class="font-medium">${{ number_format($item->price * $item->quantity, 2) }}</p>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="flex justify-between font-medium text-lg mt-4 pt-2 border-t border-gray-200">
                                    <p>Total:</p>
                                    <p class="text-indigo-600">${{ number_format($cart_total, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
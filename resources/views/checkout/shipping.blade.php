<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Checkout - Shipping Information') }}
            </h2>
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-indigo-600 text-white">1</div>
                    <div class="ml-2 text-sm font-medium">Shipping</div>
                </div>
                <div class="h-px w-8 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-200 text-gray-500">2</div>
                    <div class="ml-2 text-sm font-medium text-gray-500">Payment</div>
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
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Shipping Information</h3>
                    
                    <div class="lg:flex lg:space-x-6">
                        <div class="lg:w-2/3">
                            <form method="POST" action="{{ route('checkout.shipping.process') }}" class="space-y-4">
                                @csrf
                                
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                    <input type="text" id="address" name="address" value="{{ old('address') }}" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                    @error('address')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                        <input type="text" id="city" name="city" value="{{ old('city') }}" 
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                        @error('city')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="state" class="block text-sm font-medium text-gray-700">State/Province</label>
                                        <input type="text" id="state" name="state" value="{{ old('state') }}" 
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                        @error('state')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="zip_code" class="block text-sm font-medium text-gray-700">Zip/Postal Code</label>
                                        <input type="text" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" 
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                        @error('zip_code')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                    @error('phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="flex justify-between pt-4">
                                    <a href="{{ route('cart.list') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                        Back to Cart
                                    </a>
                                    
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Continue to Payment
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
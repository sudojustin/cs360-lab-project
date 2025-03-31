<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Cart') }}
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
            <div class="bg-white overflow-hidden shadow-md rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-800">Your Cart</h3>
                        <a href="{{ route('products') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                            </svg>
                            Continue Shopping
                        </a>
                    </div>
                    
                    @if ($message = Session::get('success'))
                    <div class="p-4 mb-6 bg-green-100 border border-green-200 text-green-700 rounded-md">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>{{ $message }}</p>
                        </div>
                    </div>
                    @endif

                    @if(count($cartItems) > 0)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                        <table class="w-full text-sm lg:text-base" cellspacing="0">
                            <thead>
                                <tr class="bg-gray-50 text-gray-600 uppercase text-xs border-b border-gray-200">
                                    <th class="hidden md:table-cell py-3 px-4"></th>
                                    <th class="text-left py-3 px-4">Product</th>
                                    <th class="text-center py-3 px-4">
                                        <span class="lg:hidden" title="Quantity">QTY</span>
                                        <span class="hidden lg:inline">Quantity</span>
                                    </th>
                                    <th class="hidden text-right md:table-cell py-3 px-4">Price</th>
                                    <th class="hidden text-right md:table-cell py-3 px-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $item)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="hidden py-4 px-4 md:table-cell">
                                        <a href="#">
                                            <img src="{{ $item->attributes->image }}" class="w-20 h-20 object-cover rounded-md shadow-sm" alt="Thumbnail">
                                        </a>
                                    </td>
                                    <td class="py-4 px-4">
                                        <a href="#" class="font-medium text-gray-800 hover:text-indigo-600 transition-colors">
                                            {{ $item->name }}
                                        </a>
                                    </td>

                                    <td class="py-4 px-4">
                                        <div class="flex items-center justify-center space-x-2">
                                            <form action="{{ route('cart.update') }}" method="POST" class="flex items-center space-x-2">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id}}">
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                                    class="w-16 text-center bg-gray-100 border border-gray-200 rounded-md py-1 px-2 focus:ring-indigo-500 focus:border-indigo-500" min="1" step="1" />
                                                <button type="submit" class="px-3 py-1 text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 rounded-md transition duration-150 ease-in-out shadow-sm flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                    Update
                                                </button>
                                            </form>
                                        </div>
                                    </td>


                                    <td class="hidden text-right md:table-cell py-4 px-4">
                                        <span class="text-base font-bold text-gray-800">
                                            ${{ $item->price }}
                                        </span>
                                    </td>
                                    <td class="hidden text-right md:table-cell py-4 px-4">
                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{ $item->id }}" name="id">
                                            <button class="px-3 py-1 text-white bg-red-500 hover:bg-red-600 rounded-md transition duration-150 ease-in-out shadow-sm flex items-center ml-auto">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8 space-y-4">
                        <div class="flex justify-between items-center py-4 px-6 bg-gray-50 rounded-lg">
                            <span class="text-lg font-bold text-gray-800">Total:</span>
                            <span class="text-2xl font-bold text-indigo-600">${{ Cart::getTotal() }}</span>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 justify-between">
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                <button class="w-full sm:w-auto px-5 py-2 text-white bg-red-500 hover:bg-red-600 rounded-md transition duration-150 ease-in-out shadow-sm flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Empty Cart
                                </button>
                            </form>

                            <!-- Order button -->
                            <form action="{{ route('orders.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="shipping_address" value="Your default address or request input">
                                <input type="hidden" name="payment_provider" value="PayPal"> <!-- or other payment provider -->
                                <input type="hidden" name="payment_transaction_id" value="SomeTransactionID">
                                <button type="submit" class="w-full sm:w-auto px-6 py-2 text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 rounded-md transition duration-150 ease-in-out shadow-sm flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Place Order
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h3 class="text-xl font-medium text-gray-700 mb-2">Your cart is empty</h3>
                        <p class="text-gray-500 mb-6">Looks like you haven't added any products to your cart yet.</p>
                        <a href="{{ route('products') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 shadow-sm transition-all hover:shadow">
                            Start Shopping
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

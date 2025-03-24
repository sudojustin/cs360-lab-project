<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Cart') }}
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
                <div class="p-6 text-gray-900">
                    <h3 class="text-3xl font-bold mb-4">Your Cart</h3>
                    @if ($message = Session::get('success'))
                    <div class="p-4 mb-3 bg-green-400 rounded">
                        <p class="text-green-800">{{ $message }}</p>
                    </div>
                    @endif
                    <table class="w-full text-sm lg:text-base" cellspacing="0">
                        <thead>
                            <tr class="h-12 uppercase">
                                <th class="hidden md:table-cell"></th>
                                <th class="text-left">Name</th>
                                <th class="pl-5 text-left lg:text-right lg:pl-0">
                                    <span class="lg:hidden" title="Quantity">Qtd</span>
                                    <span class="hidden lg:inline">Quantity</span>
                                </th>
                                <th class="hidden text-right md:table-cell"> price</th>
                                <th class="hidden text-right md:table-cell"> Remove </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $item)
                            <tr>
                                <td class="hidden pb-4 md:table-cell">
                                    <a href="#">
                                        <img src="{{ $item->attributes->image }}" class="w-20 rounded" alt="Thumbnail">
                                    </a>
                                </td>
                                <td>
                                    <a href="#">
                                        <p class="mb-2 md:ml-4">{{ $item->name }}</p>
                                    </a>
                                </td>

                                <td class="justify-center mt-6 md:justify-end md:flex">
                                    <div class="h-10 w-32 flex items-center space-x-2">
                                        <form action="{{ route('cart.update') }}" method="POST" class="flex items-center space-x-2">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item->id}}">
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" class="w-12 text-center bg-gray-300 rounded" min="1" step="1" />
                                            <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded">Update</button>
                                        </form>
                                    </div>
                                </td>


                                <td class="hidden text-right md:table-cell">
                                    <span class="text-sm font-medium lg:text-base">
                                        ${{ $item->price }}
                                    </span>
                                </td>
                                <td class="hidden text-right md:table-cell">
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" value="{{ $item->id }}" name="id">
                                        <button class="px-4 py-2 text-white bg-red-600">x</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        <strong>Total: ${{ Cart::getTotal() }}</strong>
                    </div>
                    <div class="mt-4">
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button class="px-6 py-2 text-red-800 bg-red-300">Remove All Cart</button>
                        </form>
                    </div>

                    <!-- Order button -->
                    <div class="mt-6">
                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="shipping_address" value="Your default address or request input">
                            <input type="hidden" name="payment_provider" value="PayPal"> <!-- or other payment provider -->
                            <input type="hidden" name="payment_transaction_id" value="SomeTransactionID">
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

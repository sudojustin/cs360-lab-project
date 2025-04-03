<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Order Details') }} #{{ $order->id }}
            </h2>
            <a href="{{ route('admin') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-md text-gray-700 text-sm transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <!-- Order Summary -->
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">Order Summary</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <span class="text-gray-600 w-32">Order ID:</span>
                                    <span class="font-medium">#{{ $order->id }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-600 w-32">Placed at:</span>
                                    <span class="font-medium">{{ $order->placed_at->format('F j, Y g:i A') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-600 w-32">Status:</span>
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($order->status == 'completed') bg-green-100 text-green-800
                                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-600 w-32">Total Price:</span>
                                    <span class="font-bold text-indigo-600">${{ number_format($order->total_price, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <span class="text-gray-600 w-32">Customer:</span>
                                    <span class="font-medium">{{ $order->user->name }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-600 w-32">Email:</span>
                                    <span class="font-medium">{{ $order->user->email }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-600 w-32">Payment Status:</span>
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($order->payment_status == 'paid') bg-green-100 text-green-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-600 w-32">Payment Provider:</span>
                                    <span class="font-medium">{{ $order->payment_provider }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">Shipping Information</h3>
                    <p class="text-gray-700">{{ $order->shipping_address }}</p>
                </div>

                <!-- Order Items -->
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">Order Items</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($order->products as $product)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <img class="h-10 w-10 rounded-md object-cover" src="{{ $product->image }}" alt="{{ $product->name }}">
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($product->pivot->price, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->pivot->quantity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600">
                                            ${{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray-50">
                                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">Total:</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-base font-bold text-indigo-600">${{ number_format($order->total_price, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Update Status -->
                <div class="p-6 bg-gray-50 border-t border-gray-200">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">Update Order Status</h3>
                    
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="flex items-center space-x-4">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
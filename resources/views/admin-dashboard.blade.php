<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg relative mb-6 flex items-center shadow-sm" role="alert">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg relative mb-6 flex items-center shadow-sm" role="alert">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Admin Header -->
            <div class="mb-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg shadow-md overflow-hidden relative">
                <div class="absolute inset-0 opacity-20">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                        <defs>
                            <pattern id="pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                                <path d="M0 20 L40 20" stroke="white" stroke-width="0.5" fill="none" />
                                <path d="M20 0 L20 40" stroke="white" stroke-width="0.5" fill="none" />
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#pattern)" />
                    </svg>
                </div>
                <div class="px-5 py-5 md:py-6 md:px-8 relative z-10">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-xl font-bold tracking-tight text-white sm:text-2xl">
                                Welcome to the Admin Dashboard
                            </h2>
                            <p class="mt-2 max-w-xl text-base text-indigo-100">
                                Manage your users, products, and store from this control panel.
                            </p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-white hover:bg-indigo-50 shadow-sm transition-all hover:shadow">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add New Product
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-md rounded-lg">
                <!-- User Table -->
                <div class="p-6 border-b border-gray-200">
                    <h3 class="font-bold text-xl text-gray-800 mb-4">User Management</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <th class="px-4 py-3 border-b border-gray-200">ID</th>
                                    <th class="px-4 py-3 border-b border-gray-200">Name</th>
                                    <th class="px-4 py-3 border-b border-gray-200">Email</th>
                                    <th class="px-4 py-3 border-b border-gray-200">Admin</th>
                                    <th class="px-4 py-3 border-b border-gray-200">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 whitespace-nowrap">{{ $user->id }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-800">{{ $user->name }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">{{ $user->email }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @if($user->is_admin)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Yes
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    No
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @if(!$user->is_admin || auth()->id() !== $user->id)
                                                <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-sm transition-colors shadow-sm flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 text-sm">Cannot delete</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Product Table -->
                <div class="p-6">
                    <h3 class="font-bold text-xl text-gray-800 mb-4">Product Management</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <th class="px-4 py-3 border-b border-gray-200">ID</th>
                                    <th class="px-4 py-3 border-b border-gray-200">Image</th>
                                    <th class="px-4 py-3 border-b border-gray-200">Name</th>
                                    <th class="px-4 py-3 border-b border-gray-200">Price</th>
                                    <th class="px-4 py-3 border-b border-gray-200 w-1/4">Description</th>
                                    <th class="px-4 py-3 border-b border-gray-200">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($products as $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 whitespace-nowrap">{{ $product->id }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-md object-cover">
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-800">{{ $product->name }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-indigo-600 font-bold">${{ $product->price }}</td>
                                        <td class="px-4 py-3">
                                            <div class="text-sm text-gray-500 overflow-hidden line-clamp-2">{{ $product->description }}</div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <form action="{{ route('admin.products.delete', $product) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-sm transition-colors shadow-sm flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="mt-6 bg-white overflow-hidden shadow-md rounded-lg">
                <div class="p-6">
                    <h3 class="font-bold text-xl text-gray-800 mb-4">Order Management</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <th class="px-4 py-3 border-b border-gray-200">Order ID</th>
                                    <th class="px-4 py-3 border-b border-gray-200">Customer</th>
                                    <th class="px-4 py-3 border-b border-gray-200">Date</th>
                                    <th class="px-4 py-3 border-b border-gray-200">Total</th>
                                    <th class="px-4 py-3 border-b border-gray-200">Status</th>
                                    <th class="px-4 py-3 border-b border-gray-200">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($orders as $order)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 whitespace-nowrap">#{{ $order->id }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-800">{{ $order->user->name }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">{{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-indigo-600 font-bold">${{ number_format($order->total_price, 2) }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($order->status == 'completed') bg-green-100 text-green-800
                                                @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                                @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="px-3 py-1 bg-indigo-500 hover:bg-indigo-600 text-white rounded-md text-sm transition-colors shadow-sm flex items-center inline-flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

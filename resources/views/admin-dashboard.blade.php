<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Welcome to the Admin Dashboard!") }}
                </div>

                <!-- User Table -->
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-xl">User List</h3>

                    <table class="min-w-full table-auto mt-4 border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 border-b text-left">ID</th>
                                <th class="px-4 py-2 border-b text-left">Name</th>
                                <th class="px-4 py-2 border-b text-left">Email</th>
                                <th class="px-4 py-2 border-b text-left">Admin</th>
                                <th class="px-4 py-2 border-b text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $user->id }}</td>
                                    <td class="px-4 py-2 border-b">{{ $user->name }}</td>
                                    <td class="px-4 py-2 border-b">{{ $user->email }}</td>
                                    <td class="px-4 py-2 border-b">
                                        @if($user->is_admin)
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border-b">
                                        @if(!$user->is_admin || auth()->id() !== $user->id)
                                            <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded">Delete</button>
                                            </form>
                                        @else
                                            <span class="text-gray-400">Cannot delete</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Product Table -->
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-xl">Product List</h3>
                        <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Add New Product
                        </a>
                    </div>

                    <table class="min-w-full table-auto mt-4 border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 border-b text-left">ID</th>
                                <th class="px-4 py-2 border-b text-left">Name</th>
                                <th class="px-4 py-2 border-b text-left">Price</th>
                                <th class="px-4 py-2 border-b text-left">Description</th>
                                <th class="px-4 py-2 border-b text-left">Image</th>
                                <th class="px-4 py-2 border-b text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $product->id }}</td>
                                    <td class="px-4 py-2 border-b">{{ $product->name }}</td>
                                    <td class="px-4 py-2 border-b">${{ $product->price }}</td>
                                    <td class="px-4 py-2 border-b">{{ $product->description }}</td>
                                    <td class="px-4 py-2 border-b">
                                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="h-16 w-16 object-cover">
                                    </td>
                                    <td class="px-4 py-2 border-b">
                                        <form action="{{ route('admin.products.delete', $product) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

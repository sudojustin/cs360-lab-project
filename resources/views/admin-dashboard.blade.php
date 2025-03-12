<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                                <th class="px-4 py-2 border-b">ID</th>
                                <th class="px-4 py-2 border-b">Name</th>
                                <th class="px-4 py-2 border-b">Email</th>
                                <th class="px-4 py-2 border-b">Admin</th>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

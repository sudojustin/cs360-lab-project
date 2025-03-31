<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Product') }}
            </h2>
            <a href="{{ route('admin') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Admin Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Title Banner -->
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
                <div class="px-5 py-5 md:py-6 md:px-8 relative z-10 text-center">
                    <h2 class="text-xl font-bold tracking-tight text-white sm:text-2xl">
                        Add a New Product
                    </h2>
                    <p class="mt-2 max-w-xl mx-auto text-base text-indigo-100">
                        Fill out the form below to add a new product to your store.
                    </p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-md rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative">
                            <div class="flex items-center mb-1">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="font-medium">
                                    {{ __('Whoops! Something went wrong.') }}
                                </div>
                            </div>

                            <ul class="mt-2 list-disc list-inside text-sm text-red-600 ml-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.products.store') }}" class="space-y-6">
                        @csrf

                        <!-- Product Name -->
                        <div>
                            <x-input-label for="name" :value="__('Product Name')" class="text-gray-700 font-medium"/>
                            <x-text-input id="name" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="text" name="name" :value="old('name')" required autofocus placeholder="Enter product name" />
                        </div>

                        <!-- Price -->
                        <div>
                            <x-input-label for="price" :value="__('Price')" class="text-gray-700 font-medium"/>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <x-text-input id="price" class="block w-full pl-7 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="number" name="price" step="0.01" min="0" :value="old('price')" required placeholder="0.00" />
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description')" class="text-gray-700 font-medium"/>
                            <textarea id="description" name="description" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="4" required placeholder="Enter product description">{{ old('description') }}</textarea>
                        </div>

                        <!-- Image URL -->
                        <div>
                            <x-input-label for="image" :value="__('Image URL')" class="text-gray-700 font-medium"/>
                            <x-text-input id="image" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="url" name="image" :value="old('image')" placeholder="https://example.com/image.jpg" />
                            <p class="text-sm text-gray-500 mt-1 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Enter a direct URL to an image. If left empty, a default image will be used.
                            </p>
                        </div>

                        <div class="flex items-center justify-end pt-4 border-t border-gray-200">
                            <a href="{{ route('admin') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 border border-transparent rounded-md font-medium text-sm text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Create Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
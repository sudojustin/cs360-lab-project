<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <a href="{{ route('cart.list') }}" class="flex items-center hover:text-indigo-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="ml-1 bg-indigo-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ Cart::getTotalQuantity() }}</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="login-message" class="bg-green-50 border border-green-100 overflow-hidden shadow-sm sm:rounded-lg transition-opacity duration-500 ease-in-out">
                <div class="p-3 text-sm text-green-700">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ __("You're logged in!") }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Welcome Banner -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg shadow-md overflow-hidden relative">
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
            <div class="px-5 py-5 md:py-6 md:px-8 text-center relative z-10">
                <h2 class="text-xl font-bold tracking-tight text-white sm:text-2xl">
                    Welcome to Our Shop
                </h2>
                <p class="mt-2 max-w-xl mx-auto text-base text-indigo-100">
                    Discover our handpicked selection of quality products.
                </p>
                <div class="mt-4">
                    <a href="{{ route('products') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-white hover:bg-indigo-50 shadow-sm transition-all hover:shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h8V3a1 1 0 112 0v1h1a2 2 0 012 2v11a2 2 0 01-2 2H3a2 2 0 01-2-2V6a2 2 0 012-2h1V3a1 1 0 011-1zm2 3h8v3H7V5zm10 4H3v8h14v-8z" clip-rule="evenodd" />
                        </svg>
                        Explore Products
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container px-6 mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-medium text-gray-700">Featured Products</h3>
            <a href="{{ route('products') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition-colors">
                View All Products →
            </a>
        </div>
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($products as $product)
                <div class="w-full max-w-sm mx-auto overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="relative">
                        <img src="{{ url($product->image) }}" alt="{{ $product->name }}" class="w-full h-60 object-cover">
                        <div class="absolute top-0 right-0 bg-indigo-600 text-white px-2 py-1 m-2 rounded-md text-xs font-bold shadow-sm">
                            Featured
                        </div>
                    </div>
                    <div class="px-5 py-4">
                        <h3 class="text-gray-700 uppercase font-medium">{{ $product->name }}</h3>
                        <div class="flex items-center justify-between mt-3">
                            <span class="text-gray-900 font-bold">${{ $product->price }}</span>
                            <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{ $product->id }}" name="id">
                                <input type="hidden" value="{{ $product->name }}" name="name">
                                <input type="hidden" value="{{ $product->price }}" name="price">
                                <input type="hidden" value="{{ $product->image }}" name="image">
                                <input type="hidden" value="1" name="quantity">
                                <button class="px-4 py-2 text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 rounded-md transition duration-150 ease-in-out shadow-sm">
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Add To Cart
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        // Auto-hide login message after 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const loginMessage = document.getElementById('login-message');
                if (loginMessage) {
                    loginMessage.style.opacity = '0';
                    setTimeout(function() {
                        loginMessage.style.display = 'none';
                    }, 500); // Wait for fade out animation to complete
                }
            }, 3000); // 3 seconds
        });
    </script>
</x-app-layout>
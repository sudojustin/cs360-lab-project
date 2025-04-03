<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Products') }}
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
            <!-- Category Banner -->
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
                        Browse Our Products
                    </h2>
                    <p class="mt-2 max-w-xl mx-auto text-base text-indigo-100">
                        Discover our selection of quality products at great prices.
                    </p>
                </div>
            </div>

            <!-- Search and Filtering -->
            <div class="mb-8 bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <form method="GET" action="{{ route('products') }}">
                        <!-- Search and Sort Row -->
                        <div class="flex flex-col md:flex-row gap-4 mb-6">
                            <!-- Search Bar -->
                            <div class="flex-1">
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Sort Options -->
                            <div class="w-full md:w-64">
                                <select name="sort" class="w-full border border-gray-300 rounded-md py-2 pl-3 pr-10 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Filters Row -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
                            <!-- Category Filter -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select id="category" name="category" class="w-full border border-gray-300 rounded-md py-2 pl-3 pr-10 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">All Categories</option>
                                    <option value="electronics" {{ request('category') == 'electronics' ? 'selected' : '' }}>Electronics</option>
                                    <option value="clothing" {{ request('category') == 'clothing' ? 'selected' : '' }}>Clothing</option>
                                    <option value="home" {{ request('category') == 'home' ? 'selected' : '' }}>Home & Living</option>
                                    <option value="beauty" {{ request('category') == 'beauty' ? 'selected' : '' }}>Beauty</option>
                                    <option value="sports" {{ request('category') == 'sports' ? 'selected' : '' }}>Sports</option>
                                </select>
                            </div>
                            
                            <!-- Price Range -->
                            <div>
                                <label for="min_price" class="block text-sm font-medium text-gray-700 mb-1">Min Price</label>
                                <input type="number" id="min_price" name="min_price" value="{{ request('min_price') }}" min="0" placeholder="Min $" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            
                            <div>
                                <label for="max_price" class="block text-sm font-medium text-gray-700 mb-1">Max Price</label>
                                <input type="number" id="max_price" name="max_price" value="{{ request('max_price') }}" min="0" placeholder="Max $" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            
                            <!-- In Stock Only -->
                            <div class="flex items-end">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">In Stock Only</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex justify-between">
                            <button type="submit" class="bg-indigo-600 border border-transparent rounded-md py-2 px-4 flex items-center justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Apply Filters
                            </button>
                            
                            <a href="{{ route('products') }}" class="bg-gray-100 border border-gray-300 rounded-md py-2 px-4 flex items-center justify-center text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Clear Filters
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results Summary and Active Filters -->
            <div class="mb-6">
                <!-- Results Count -->
                <div class="flex items-center justify-between mb-4">
                    <div class="text-sm text-gray-600">
                        Showing <span class="font-medium text-gray-900">{{ $products->firstItem() ?? 0 }}</span> to 
                        <span class="font-medium text-gray-900">{{ $products->lastItem() ?? 0 }}</span> of
                        <span class="font-medium text-gray-900">{{ $products->total() }}</span> {{ Str::plural('product', $products->total()) }}
                        @if(request()->anyFilled(['search', 'category', 'min_price', 'max_price', 'in_stock', 'sort']))
                            with applied filters
                        @endif
                    </div>
                    
                    @if(request()->anyFilled(['search', 'category', 'min_price', 'max_price', 'in_stock']))
                    <a href="{{ route('products', request()->has('sort') ? ['sort' => request('sort')] : []) }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                        Clear all filters
                    </a>
                    @endif
                </div>
                
                <!-- Active Filters -->
                @if(request()->anyFilled(['search', 'category', 'min_price', 'max_price', 'in_stock']))
                <div class="flex flex-wrap gap-2 mb-4">
                    @if(request('search'))
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100">
                        <span class="mr-1 text-gray-600">Search:</span>
                        <span class="font-medium">{{ request('search') }}</span>
                        <a href="{{ route('products', request()->except('search')) }}" class="ml-2 text-gray-500 hover:text-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    </div>
                    @endif
                    
                    @if(request('category'))
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100">
                        <span class="mr-1 text-gray-600">Category:</span>
                        <span class="font-medium">{{ ucfirst(request('category')) }}</span>
                        <a href="{{ route('products', request()->except('category')) }}" class="ml-2 text-gray-500 hover:text-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    </div>
                    @endif
                    
                    @if(request('min_price') || request('max_price'))
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100">
                        <span class="mr-1 text-gray-600">Price:</span>
                        <span class="font-medium">
                            @if(request('min_price') && request('max_price'))
                                ${{ request('min_price') }} - ${{ request('max_price') }}
                            @elseif(request('min_price'))
                                ${{ request('min_price') }}+
                            @elseif(request('max_price'))
                                Up to ${{ request('max_price') }}
                            @endif
                        </span>
                        <a href="{{ route('products', request()->except(['min_price', 'max_price'])) }}" class="ml-2 text-gray-500 hover:text-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    </div>
                    @endif
                    
                    @if(request('in_stock'))
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100">
                        <span class="font-medium">In Stock Only</span>
                        <a href="{{ route('products', request()->except('in_stock')) }}" class="ml-2 text-gray-500 hover:text-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">All Products</h3>
                    
                    @if(count($products) > 0)
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach ($products as $product)
                        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                            <div class="relative">
                                <img src="{{ url($product->image) }}" alt="{{ $product->name }}" class="w-full h-60 object-cover cursor-pointer" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-price="{{ $product->price }}" data-product-image="{{ $product->image }}" data-product-description="{{ $product->description ?? 'No description available' }}">
                                <!-- Quick View Overlay -->
                                <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-center justify-center product-quick-view" data-product-id="{{ $product->id }}">
                                    <div class="bg-white text-gray-800 px-4 py-2 rounded-md shadow-sm flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Quick View
                                    </div>
                                </div>
                                
                                <!-- Product Badges -->
                                @if($product->created_at->diffInDays(now()) < 14)
                                <div class="absolute top-0 left-0 bg-emerald-500 text-white px-2 py-1 m-2 rounded-md text-xs font-bold shadow-sm">
                                    New
                                </div>
                                @endif
                                
                                @if(isset($product->discount_percent) && $product->discount_percent > 0)
                                <div class="absolute bottom-0 left-0 bg-rose-500 text-white px-2 py-1 m-2 rounded-md text-xs font-bold shadow-sm">
                                    -{{ $product->discount_percent }}%
                                </div>
                                @endif
                                
                                @if(isset($product->stock) && $product->stock <= 5 && $product->stock > 0)
                                <div class="absolute bottom-0 right-0 bg-amber-500 text-white px-2 py-1 m-2 rounded-md text-xs font-bold shadow-sm">
                                    Low Stock
                                </div>
                                @elseif(isset($product->stock) && $product->stock <= 0)
                                <div class="absolute bottom-0 right-0 bg-gray-500 text-white px-2 py-1 m-2 rounded-md text-xs font-bold shadow-sm">
                                    Out of Stock
                                </div>
                                @endif
                            </div>
                            <div class="p-4 flex flex-col h-[180px]">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-lg font-medium text-gray-800 truncate">{{ $product->name }}</h3>
                                    <span class="text-lg font-bold text-indigo-600">${{ $product->price }}</span>
                                </div>
                                <p class="text-sm text-gray-500 mb-4 overflow-hidden line-clamp-2 h-10">{{ $product->description ?? 'No description available' }}</p>
                                
                                <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data" class="mt-auto">
                                    @csrf
                                    <input type="hidden" value="{{ $product->id }}" name="id">
                                    <input type="hidden" value="{{ $product->name }}" name="name">
                                    <input type="hidden" value="{{ $product->price }}" name="price">
                                    <input type="hidden" value="{{ $product->image }}" name="image">
                                    <input type="hidden" value="1" name="quantity">
                                    <button class="w-full px-4 py-2 text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 rounded-md transition duration-150 ease-in-out shadow-sm flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Add To Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                    @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">No products found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria.</p>
                        <div class="mt-6">
                            <a href="{{ route('products') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Clear all filters
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Product Modal -->
<div id="productModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-modal="true">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" onclick="closeProductModal()"></div>
        
        <div class="relative w-full max-w-3xl transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:w-full">
            <div class="absolute right-0 top-0 p-4 z-10">
                <button type="button" onclick="closeProductModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="p-6" id="productModalContent">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listeners to all product images and quick view overlays
        const productImages = document.querySelectorAll('.product-quick-view, img[data-product-id]');
        
        productImages.forEach(element => {
            element.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id') || 
                                 this.closest('.relative').querySelector('img').getAttribute('data-product-id');
                                 
                openProductModal(productId);
            });
        });
    });
    
    function openProductModal(productId) {
        // Find the product image with the matching productId
        const productImg = document.querySelector(`img[data-product-id="${productId}"]`);
        
        if (productImg) {
            const productName = productImg.getAttribute('data-product-name');
            const productPrice = productImg.getAttribute('data-product-price');
            const productImage = productImg.getAttribute('data-product-image');
            const productDescription = productImg.getAttribute('data-product-description');
            
            const content = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center justify-center">
                        <img src="${productImage}" alt="${productName}" class="w-full h-64 rounded-lg object-contain">
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-1">${productName}</h3>
                        <div class="text-xl font-bold text-indigo-600 mb-4">$${productPrice}</div>
                        <div class="prose prose-sm text-gray-600 mb-5 max-h-40 overflow-y-auto">
                            ${productDescription}
                        </div>
                        <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="${productId}" name="id">
                            <input type="hidden" value="${productName}" name="name">
                            <input type="hidden" value="${productPrice}" name="price">
                            <input type="hidden" value="${productImage}" name="image">
                            <div class="flex items-center mb-4">
                                <label class="block text-gray-700 mr-3">Quantity:</label>
                                <input type="number" name="quantity" value="1" min="1" class="w-16 px-2 py-1 border border-gray-300 rounded">
                            </div>
                            <button class="w-full px-4 py-2 text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 rounded-md transition duration-150 ease-in-out shadow-sm flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Add To Cart
                            </button>
                        </form>
                    </div>
                </div>
            `;
            
            document.getElementById('productModalContent').innerHTML = content;
            document.getElementById('productModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
    }
    
    function closeProductModal() {
        document.getElementById('productModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>

<style>
    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: rgba(156, 163, 175, 0.5) rgba(229, 231, 235, 0.5);
    }
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(229, 231, 235, 0.5);
        border-radius: 3px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(156, 163, 175, 0.5);
        border-radius: 3px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(107, 114, 128, 0.5);
    }
</style>

<!-- Footer Component -->
<x-footer />
